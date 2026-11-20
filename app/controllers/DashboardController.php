
<?php

class DashboardController extends Controller
{
    // Display customer dashboard
   
// Display customer dashboard

public function index()
{
    if (empty($_SESSION['user_id'])) {
        $this->redirect(APP_URL . '/login');
    }

    $userModel = new User();

    $user = $userModel->findById($_SESSION['user_id']);

    if (!$user) {
        $_SESSION = [];
        session_destroy();

        $this->redirect(APP_URL . '/login');
    }

    if ($user['role'] === 'admin') {
        $this->redirect(APP_URL . '/admin/dashboard');
    }

    if ($user['status'] !== 'active') {
        $_SESSION = [];
        session_destroy();

        $this->redirect(APP_URL . '/login');
    }

    $_SESSION['user_name'] = $user['name'];

    // Load provider profile if one exists
    $providerModel = new Provider();

    $provider = $providerModel->findByUserId($user['id']);

    // Load bookings belonging to this customer
    $bookingModel = new Booking();

    $bookings = $bookingModel->getBookingsByCustomer($user['id']);

    // Display customer dashboard
    $this->view('dashboard.index', [
        'user' => $user,
        'provider' => $provider,
        'bookings' => $bookings
    ]);
}

   
// Display Become a Provider page
public function becomeProvider()
{
    // Check login
    if (empty($_SESSION['user_id'])) {
        $this->redirect(APP_URL . '/login');
    }

    // Get logged-in user
    $userModel = new User();

    $user = $userModel->findById($_SESSION['user_id']);

    // Check whether user exists and is active
    if (!$user || $user['status'] !== 'active') {
        $this->redirect(APP_URL . '/login');
    }

    // Admin cannot register as a provider
    if ($user['role'] === 'admin') {
        $this->redirect(APP_URL . '/admin/dashboard');
    }

    // Check whether provider profile already exists
    $providerModel = new Provider();

    $existingProvider = $providerModel->findByUserId($user['id']);

    if ($existingProvider) {
        $this->redirect(APP_URL . '/provider/dashboard');
    }

    // Get main categories from database
    $categoryModel = new Category();

    $categories = $categoryModel->getMainCategories();

    // Display Become a Provider form
    $this->view('provider.become', [
        'user' => $user,
        'categories' => $categories
    ]);
}

public function becomeProviderSubmit()
{
    // Check login
    if (empty($_SESSION['user_id'])) {
        $this->json([
            'success' => false,
            'message' => 'Please log in to continue.'
        ], 401);
    }

    // Verify CSRF token
    if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
        $this->json([
            'success' => false,
            'message' => 'Invalid security token. Please refresh the page.'
        ], 403);
    }

    // Get logged-in user
    $userModel = new User();
    $user = $userModel->findById($_SESSION['user_id']);

    if (!$user || $user['status'] !== 'active') {
        $this->json([
            'success' => false,
            'message' => 'Your account is not available.'
        ], 403);
    }

    if ($user['role'] === 'admin') {
        $this->json([
            'success' => false,
            'message' => 'Admin accounts cannot register as providers.'
        ], 403);
    }

    // Get submitted form values
    $businessName = trim($_POST['business_name'] ?? '');
    $mainCategoryId = filter_var(
        $_POST['main_category_id'] ?? null,
        FILTER_VALIDATE_INT
    );
    $categoryId = filter_var(
        $_POST['category_id'] ?? null,
        FILTER_VALIDATE_INT
    );

    $description = trim($_POST['description'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');

    // Validate business name
    if ($businessName === '' || strlen($businessName) > 150) {
        $this->json([
            'success' => false,
            'message' => 'Please enter a valid business name.'
        ], 422);
    }

    // Validate main category and subcategory IDs
    if (
        !$mainCategoryId ||
        $mainCategoryId <= 0 ||
        !$categoryId ||
        $categoryId <= 0
    ) {
        $this->json([
            'success' => false,
            'message' => 'Please select a valid main category and subcategory.'
        ], 422);
    }

    // Verify that the selected subcategory belongs to the selected main category
    $categoryModel = new Category();

    if (!$categoryModel->subcategoryBelongsToParent(
        $categoryId,
        $mainCategoryId
    )) {
        $this->json([
            'success' => false,
            'message' => 'The selected subcategory does not belong to the selected main category.'
        ], 422);
    }

    // Validate description
    if (strlen($description) < 30 || strlen($description) > 2000) {
        $this->json([
            'success' => false,
            'message' => 'Description must contain between 30 and 2000 characters.'
        ], 422);
    }

    // Validate address
    if ($address === '' || strlen($address) > 255) {
        $this->json([
            'success' => false,
            'message' => 'Please enter a valid business address.'
        ], 422);
    }

    // Validate city
    if ($city === '' || strlen($city) > 100) {
        $this->json([
            'success' => false,
            'message' => 'Please enter a valid city.'
        ], 422);
    }

    // Validate state
    if ($state === '' || strlen($state) > 100) {
        $this->json([
            'success' => false,
            'message' => 'Please enter a valid state.'
        ], 422);
    }

    // Validate Indian PIN code
    if (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $this->json([
            'success' => false,
            'message' => 'Please enter a valid 6-digit PIN code.'
        ], 422);
    }

    $providerModel = new Provider();

    // Prevent duplicate provider profiles
    if ($providerModel->findByUserId($user['id'])) {
        $this->json([
            'success' => false,
            'message' => 'You already have a provider profile.'
        ], 409);
    }

    try {

        // Create provider profile with selected subcategory
        $providerModel->create(
            $user['id'],
            $categoryId,
            $businessName,
            $description,
            $address,
            $city,
            $state,
            $pincode
        );

        $this->json([
            'success' => true,
            'message' => 'Your provider profile has been created successfully.'
        ]);

    } catch (Throwable $e) {

        error_log($e->getMessage());

        $this->json([
            'success' => false,
            'message' => 'Unable to create your provider profile. Please try again.'
        ], 500);
    }
}

    // Update customer profile information
    public function updateProfile()
    {
        if (empty($_SESSION['user_id'])) {
            $this->json([
                'success' => false,
                'message' => 'Please log in to continue.'
            ], 401);
        }

        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            $this->json([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page.'
            ], 403);
        }

        $userId = $_SESSION['user_id'];

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($name === '') {
            $this->json([
                'success' => false,
                'message' => 'Please enter your full name.'
            ], 422);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        if ($phone === '') {
            $phone = null;
        } elseif (!preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
            $this->json([
                'success' => false,
                'message' => 'Please enter a valid phone number.'
            ], 422);
        }

        $userModel = new User();

        if ($userModel->emailExistsForOtherUser($email, $userId)) {
            $this->json([
                'success' => false,
                'message' => 'This email address is already being used.'
            ], 409);
        }

        if (
            $phone !== null &&
            $userModel->phoneExistsForOtherUser($phone, $userId)
        ) {
            $this->json([
                'success' => false,
                'message' => 'This phone number is already being used.'
            ], 409);
        }

        try {
            $userModel->updateProfile(
                $userId,
                $name,
                $email,
                $phone
            );

            $_SESSION['user_name'] = $name;

            $this->json([
                'success' => true,
                'message' => 'Your profile has been updated successfully.',
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone
                ]
            ]);

        } catch (PDOException $e) {
            error_log($e->getMessage());

            $this->json([
                'success' => false,
                'message' => 'Unable to update your profile. Please try again.'
            ], 500);
        }
    }


    // Upload or change customer profile photo
    public function uploadProfileImage()
    {
        if (empty($_SESSION['user_id'])) {
            $this->json([
                'success' => false,
                'message' => 'Please log in to continue.'
            ], 401);
        }

        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            $this->json([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page.'
            ], 403);
        }

        if (
            !isset($_FILES['profile_image']) ||
            $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK
        ) {
            $this->json([
                'success' => false,
                'message' => 'Please select a valid image.'
            ], 422);
        }

        $image = $_FILES['profile_image'];

        if ($image['size'] > 2 * 1024 * 1024) {
            $this->json([
                'success' => false,
                'message' => 'Image size must not exceed 2 MB.'
            ], 422);
        }

        $imageInfo = getimagesize($image['tmp_name']);

        if ($imageInfo === false) {
            $this->json([
                'success' => false,
                'message' => 'The uploaded file is not a valid image.'
            ], 422);
        }

        $allowedTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_WEBP => 'webp'
        ];

        $imageType = $imageInfo[2];

        if (!isset($allowedTypes[$imageType])) {
            $this->json([
                'success' => false,
                'message' => 'Only JPG, PNG and WebP images are allowed.'
            ], 422);
        }

        $extension = $allowedTypes[$imageType];

        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

        $uploadDirectory = PUBLIC_PATH . '/uploads/profiles/';

        if (!is_dir($uploadDirectory)) {
            $this->json([
                'success' => false,
                'message' => 'Profile upload folder is unavailable.'
            ], 500);
        }

        $destination = $uploadDirectory . $fileName;

        if (!move_uploaded_file($image['tmp_name'], $destination)) {
            $this->json([
                'success' => false,
                'message' => 'Unable to upload your image. Please try again.'
            ], 500);
        }

        $imagePath = 'uploads/profiles/' . $fileName;

        try {
            $userModel = new User();

            $userModel->updateProfileImage(
                $_SESSION['user_id'],
                $imagePath
            );

            $this->json([
                'success' => true,
                'message' => 'Profile photo updated successfully.',
                'image' => APP_URL . '/' . $imagePath
            ]);

        } catch (PDOException $e) {
            if (is_file($destination)) {
                unlink($destination);
            }

            error_log($e->getMessage());

            $this->json([
                'success' => false,
                'message' => 'Unable to save your profile photo.'
            ], 500);
        }
    }

// Load subcategories for the selected main category
public function providerSubcategories()
{
    header('Content-Type: application/json');

    // Check login
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);

        echo json_encode([
            'success' => false,
            'message' => 'Please log in first.'
        ]);

        exit;
    }

    // Get selected main category ID
    $parentId = filter_input(INPUT_GET, 'parent_id', FILTER_VALIDATE_INT);

    if (!$parentId || $parentId <= 0) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid category selected.'
        ]);

        exit;
    }

    // Retrieve its subcategories
    $categoryModel = new Category();

    $subcategories = $categoryModel->getSubcategories($parentId);

    echo json_encode([
        'success' => true,
        'subcategories' => $subcategories
    ]);

    exit;
}

// Display reviews submitted by the logged-in customer
public function myReviews()
{
    // Check login
    if (empty($_SESSION['user_id'])) {
        $this->redirect(APP_URL . '/login');
    }

    // Get logged-in user
    $userModel = new User();

    $user = $userModel->findById($_SESSION['user_id']);

    // Check whether user exists and is active
    if (!$user || $user['status'] !== 'active') {
        $_SESSION = [];
        session_destroy();

        $this->redirect(APP_URL . '/login');
    }

    // Admin accounts cannot access the customer reviews page
    if ($user['role'] === 'admin') {
        $this->redirect(APP_URL . '/admin/dashboard');
    }

    // Retrieve reviews belonging to this customer
    $reviewModel = new Review();

    $reviews = $reviewModel->getByCustomerId($user['id']);

    // Display customer reviews page
    $this->view('dashboard.my-reviews', [
        'user' => $user,
        'reviews' => $reviews
    ]);
}

}

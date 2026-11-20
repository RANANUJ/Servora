
<?php

class ProviderController extends Controller
{
    // Display all service providers
    public function index()
    {
        $this->view('providers.index', [
            'pageTitle' => 'Browse Service Providers'
        ]);
    }


    // Display provider dashboard
    public function dashboard()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $this->view('provider.dashboard', [
            'user' => $user,
            'provider' => $provider
        ]);
    }


    // Display provider's services
    public function services()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $serviceModel = new Service();
        $services = $serviceModel->getServicesByProvider($provider['id']);

        $this->view('provider.services.index', [
            'user' => $user,
            'provider' => $provider,
            'services' => $services,
            'pageTitle' => 'My Services'
        ]);
    }


    // Display create service form
    public function createService()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getMainCategories();

        if (empty($_SESSION['service_csrf_token'])) {
            $_SESSION['service_csrf_token'] = bin2hex(random_bytes(32));
        }

        $serviceError = $_SESSION['service_error'] ?? null;
        unset($_SESSION['service_error']);

        $this->view('provider.services.create', [
            'user' => $user,
            'provider' => $provider,
            'categories' => $categories,
            'csrfToken' => $_SESSION['service_csrf_token'],
            'serviceError' => $serviceError,
            'pageTitle' => 'Add New Service'
        ]);
    }


    // Save a new service submitted by the provider
    public function storeService()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(APP_URL . '/provider/services');
            return;
        }

        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $submittedToken = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['service_csrf_token'] ?? '';

        if (
            empty($sessionToken) ||
            empty($submittedToken) ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            $_SESSION['service_error'] = 'Your form session expired. Please try again.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $mainCategoryId = filter_var(
            $_POST['main_category_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $categoryId = filter_var(
            $_POST['category_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $priceType = $_POST['price_type'] ?? '';
        $priceInput = trim($_POST['price'] ?? '');

        if (
            $title === '' ||
            $description === '' ||
            !$mainCategoryId ||
            !$categoryId
        ) {
            $_SESSION['service_error'] = 'Please complete all required fields.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        if (strlen($title) > 150) {
            $_SESSION['service_error'] = 'Service title cannot exceed 150 characters.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        $allowedPriceTypes = [
            'fixed',
            'starting_from',
            'hourly',
            'negotiable'
        ];

        if (!in_array($priceType, $allowedPriceTypes, true)) {
            $_SESSION['service_error'] = 'Please select a valid price type.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        if ($priceType === 'negotiable' && $priceInput === '') {
            $price = 0;
        } else {
            if (
                $priceInput === '' ||
                !is_numeric($priceInput) ||
                (float) $priceInput < 0 ||
                (float) $priceInput > 99999999.99
            ) {
                $_SESSION['service_error'] = 'Please enter a valid service price.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            $price = round((float) $priceInput, 2);
        }

        $categoryModel = new Category();

        $mainCategory = $categoryModel->findMainCategoryById(
            $mainCategoryId
        );

        if (!$mainCategory) {
            $_SESSION['service_error'] = 'Please select a valid main category.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        if (
            !$categoryModel->subcategoryBelongsToParent(
                $categoryId,
                $mainCategoryId
            )
        ) {
            $_SESSION['service_error'] = 'The selected subcategory is not valid.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        $imagePath = null;
        $uploadedFilePath = null;

        if (
            isset($_FILES['service_image']) &&
            $_FILES['service_image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $file = $_FILES['service_image'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['service_error'] = 'There was a problem uploading your image.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            if ($file['size'] > 3 * 1024 * 1024) {
                $_SESSION['service_error'] = 'The service image must be smaller than 3 MB.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);

            $allowedMimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            if (!isset($allowedMimeTypes[$mimeType])) {
                $_SESSION['service_error'] = 'Only JPG, PNG and WEBP images are allowed.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            if (getimagesize($file['tmp_name']) === false) {
                $_SESSION['service_error'] = 'The uploaded file is not a valid image.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            $uploadDirectory = APP_ROOT . '/public/uploads/services';

            if (
                !is_dir($uploadDirectory) &&
                !mkdir($uploadDirectory, 0755, true)
            ) {
                $_SESSION['service_error'] = 'Unable to prepare the image upload folder.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            $extension = $allowedMimeTypes[$mimeType];
            $filename = bin2hex(random_bytes(16)) . '.' . $extension;

            $uploadedFilePath = $uploadDirectory . '/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $uploadedFilePath)) {
                $_SESSION['service_error'] = 'Unable to save the service image.';
                $this->redirect(APP_URL . '/provider/services/create');
                return;
            }

            $imagePath = 'uploads/services/' . $filename;
        }

        $slugTitle = strtolower($title);
        $slugTitle = preg_replace('/[^a-z0-9]+/', '-', $slugTitle);
        $slugTitle = trim($slugTitle, '-');

        if ($slugTitle === '') {
            $slugTitle = 'service';
        }

        $slug = $slugTitle . '-' . bin2hex(random_bytes(4));

        try {
            $serviceModel = new Service();

            $saved = $serviceModel->create(
                $provider['id'],
                $categoryId,
                $title,
                $slug,
                $description,
                $price,
                $priceType,
                $imagePath
            );

            if (!$saved) {
                throw new RuntimeException('Service could not be saved.');
            }
        } catch (Throwable $exception) {
            if ($uploadedFilePath && is_file($uploadedFilePath)) {
                unlink($uploadedFilePath);
            }

            error_log('Servora service creation error: ' . $exception->getMessage());

            $_SESSION['service_error'] = 'We could not save your service. Please try again.';
            $this->redirect(APP_URL . '/provider/services/create');
            return;
        }

        unset($_SESSION['service_csrf_token']);

        $this->redirect(
            APP_URL . '/services?category=' . urlencode($mainCategory['slug'])
        );
    }


    // Display all bookings received by the provider
    public function bookings()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $bookingModel = new Booking();
        $bookings = $bookingModel->getBookingsByProvider($provider['id']);

        $bookingMessage = $_SESSION['booking_message'] ?? null;
        unset($_SESSION['booking_message']);

        $bookingError = $_SESSION['booking_error'] ?? null;
        unset($_SESSION['booking_error']);

        $this->view('provider.bookings.index', [
            'user' => $user,
            'provider' => $provider,
            'bookings' => $bookings,
            'bookingMessage' => $bookingMessage,
            'bookingError' => $bookingError,
            'pageTitle' => 'Customer Bookings'
        ]);
    }


    // Display details of one booking belonging to this provider
    public function bookingDetails()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $bookingId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$bookingId || $bookingId < 1) {
            $this->redirect(APP_URL . '/provider/bookings');
            return;
        }

        $bookingModel = new Booking();

        $booking = $bookingModel->findForProvider(
            $bookingId,
            $provider['id']
        );

        if (!$booking) {
            $_SESSION['booking_error'] = 'The requested booking could not be found.';
            $this->redirect(APP_URL . '/provider/bookings');
            return;
        }

        // Retrieve the customer's review for this booking
        $reviewModel = new Review();

        $review = $reviewModel->getByBookingId($booking['id']);

        $bookingMessage = $_SESSION['booking_message'] ?? null;
        unset($_SESSION['booking_message']);

        $bookingError = $_SESSION['booking_error'] ?? null;
        unset($_SESSION['booking_error']);

        $this->view('provider.bookings.details', [
            'user' => $user,
            'provider' => $provider,
            'booking' => $booking,
            'review' => $review,
            'bookingMessage' => $bookingMessage,
            'bookingError' => $bookingError,
            'csrfToken' => Csrf::token(),
            'pageTitle' => 'Booking Details'
        ]);
    }


    // Accept, reject, start or complete a booking
    public function updateBookingStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(APP_URL . '/provider/bookings');
            return;
        }

        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $bookingId = filter_var(
            $_POST['booking_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $newStatus = $_POST['status'] ?? '';

        if (
            !$bookingId ||
            $bookingId < 1 ||
            !Csrf::verify($_POST['csrf_token'] ?? '')
        ) {
            $_SESSION['booking_error'] = 'Invalid request. Please try again.';
            $this->redirect(APP_URL . '/provider/bookings');
            return;
        }

        $allowedStatuses = [
            'accepted',
            'rejected',
            'in_progress',
            'completed'
        ];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            $_SESSION['booking_error'] = 'Invalid booking status selected.';
            $this->redirect(APP_URL . '/provider/bookings');
            return;
        }

        try {
            $bookingModel = new Booking();

            $updated = $bookingModel->updateStatus(
                $bookingId,
                $provider['id'],
                $newStatus
            );

            if (!$updated) {
                $_SESSION['booking_error'] =
                    'This booking could not be updated. It may have already changed.';
            } else {
                $_SESSION['booking_message'] =
                    'Booking status updated successfully.';
            }
        } catch (Throwable $exception) {
            error_log(
                'Servora booking status update error: ' .
                $exception->getMessage()
            );

            $_SESSION['booking_error'] =
                'Something went wrong while updating the booking.';
        }

        $this->redirect(
            APP_URL . '/provider/bookings/details?id=' . $bookingId
        );
    }


    // Display customer reviews received by this provider
    public function reviews()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
            return;
        }

        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
            return;
        }

        $providerModel = new Provider();
        $provider = $providerModel->findByUserId($user['id']);

        if (!$provider || $provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $reviewModel = new Review();

        $reviews = $reviewModel->getPublishedByProviderId(
            $provider['id']
        );

        $ratingSummary = $reviewModel->getProviderRatingSummary(
            $provider['id']
        );

        $this->view('provider.reviews.index', [
            'user' => $user,
            'provider' => $provider,
            'reviews' => $reviews,
            'ratingSummary' => $ratingSummary,
            'pageTitle' => 'Customer Reviews'
        ]);
    }

}

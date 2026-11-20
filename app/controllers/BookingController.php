
<?php

class BookingController extends Controller
{
    // Handle customer booking submission
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(APP_URL . '/services');
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

        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            $_SESSION['booking_error'] =
                'Your form session expired. Please try again.';

            $this->redirect(APP_URL . '/services');
            return;
        }

        $serviceId = filter_var(
            $_POST['service_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$serviceId || $serviceId < 1) {
            $_SESSION['booking_error'] = 'Invalid service selected.';
            $this->redirect(APP_URL . '/services');
            return;
        }

        $serviceModel = new Service();
        $service = $serviceModel->findActiveById($serviceId);

        if (!$service) {
            $_SESSION['booking_error'] =
                'This service is no longer available.';

            $this->redirect(APP_URL . '/services');
            return;
        }

        $bookingDate = trim($_POST['booking_date'] ?? '');
        $bookingTime = trim($_POST['booking_time'] ?? '');
        $serviceAddress = trim($_POST['service_address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $pincode = trim($_POST['pincode'] ?? '');
        $customerMessage = trim($_POST['customer_message'] ?? '');

        $dateObject = DateTime::createFromFormat(
            '!Y-m-d',
            $bookingDate
        );

        $validDate = $dateObject &&
            $dateObject->format('Y-m-d') === $bookingDate;

        if (!$validDate || $bookingDate < date('Y-m-d')) {
            $_SESSION['booking_error'] =
                'Please select a valid date today or later.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        if (!preg_match('/\A(?:[01]\d|2[0-3]):[0-5]\d\z/', $bookingTime)) {
            $_SESSION['booking_error'] =
                'Please select a valid booking time.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        if ($serviceAddress === '' || strlen($serviceAddress) > 5000) {
            $_SESSION['booking_error'] =
                'Please enter a valid service address.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        if ($city === '' || strlen($city) > 100) {
            $_SESSION['booking_error'] = 'Please enter a valid city.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        if (!preg_match('/\A[0-9]{4,10}\z/', $pincode)) {
            $_SESSION['booking_error'] = 'Please enter a valid pincode.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        if (strlen($customerMessage) > 2000) {
            $_SESSION['booking_error'] =
                'Your additional message cannot exceed 2000 characters.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
            return;
        }

        $bookingData = [
            'customer_id' => $user['id'],
            'provider_id' => $service['provider_id'],
            'provider_user_id' => $service['provider_user_id'],
            'service_id' => $service['id'],
            'service_title' => $service['title'],
            'booking_date' => $bookingDate,
            'booking_time' => $bookingTime,
            'service_address' => $serviceAddress,
            'city' => $city,
            'pincode' => $pincode,
            'customer_message' => $customerMessage !== ''
                ? $customerMessage
                : null,
            'price' => $service['price']
        ];

        try {
            $bookingModel = new Booking();

            $result = $bookingModel->createBooking($bookingData);

            if (!$result || empty($result['booking_number'])) {
                throw new RuntimeException(
                    'Booking could not be created.'
                );
            }

            $this->redirect(
                APP_URL . '/booking/confirmation?booking=' .
                urlencode($result['booking_number'])
            );

        } catch (Throwable $exception) {

            error_log(
                'Servora booking creation error: ' .
                $exception->getMessage()
            );

            $_SESSION['booking_error'] =
                'We could not submit your booking. Please try again.';

            $this->redirect(
                APP_URL . '/service/details?id=' . $serviceId
            );
        }
    }


    // Display customer booking confirmation
    public function confirmation()
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

        $bookingNumber = trim($_GET['booking'] ?? '');

        if ($bookingNumber === '') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $bookingModel = new Booking();

        $booking = $bookingModel->findForCustomer(
            $bookingNumber,
            $user['id']
        );

        if (!$booking) {
            http_response_code(404);

            $this->view('services.not-found', [
                'pageTitle' => 'Booking Not Found'
            ]);

            return;
        }

        $this->view('booking.confirmation', [
            'pageTitle' => 'Booking Confirmation',
            'booking' => $booking
        ]);
    }


    // Display details of a customer's booking
    public function details()
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

        $bookingNumber = trim($_GET['number'] ?? '');

        if ($bookingNumber === '') {
            $this->redirect(APP_URL . '/dashboard');
            return;
        }

        $bookingModel = new Booking();

        $booking = $bookingModel->findForCustomer(
            $bookingNumber,
            $user['id']
        );

        if (!$booking) {
            http_response_code(404);

            $this->view('services.not-found', [
                'pageTitle' => 'Booking Not Found'
            ]);

            return;
        }

        // Retrieve the review belonging to this booking, if one exists.
        $reviewModel = new Review();

        $review = $reviewModel->getByBookingId($booking['id']);

        $this->view('booking.details', [
            'pageTitle' => 'My Booking Details',
            'booking' => $booking,
            'review' => $review,
            'csrfToken' => Csrf::token(),
            'reviewError' => $_SESSION['review_error'] ?? null,
            'reviewSuccess' => $_SESSION['review_success'] ?? null
        ]);

        unset(
            $_SESSION['review_error'],
            $_SESSION['review_success']
        );
    }


    // Handle customer review submission
    
// Handle customer review submission
public function submitReview()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect(APP_URL . '/dashboard');
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

    // Get the booking number before validating the form.
    $bookingNumber = trim($_POST['booking_number'] ?? '');

    if ($bookingNumber === '') {
        $_SESSION['review_error'] = 'Invalid booking reference.';
        $this->redirect(APP_URL . '/dashboard');
        return;
    }

    // Verify CSRF token.
    if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
        $_SESSION['review_error'] =
            'Your form session expired. Please try again.';

        $this->redirect(
            APP_URL . '/booking/details?number=' .
            urlencode($bookingNumber)
        );
        return;
    }

    // Validate rating.
    $rating = filter_var(
        $_POST['rating'] ?? null,
        FILTER_VALIDATE_INT
    );

    if ($rating === false || $rating === null || $rating < 1 || $rating > 5) {
        $_SESSION['review_error'] =
            'Please select a rating between 1 and 5 stars.';

        $this->redirect(
            APP_URL . '/booking/details?number=' .
            urlencode($bookingNumber)
        );
        return;
    }

    // Validate review message.
    $comment = trim($_POST['comment'] ?? '');

    if ($comment === '' || strlen($comment) > 2000) {
        $_SESSION['review_error'] =
            'Please write a review between 1 and 2000 characters.';

        $this->redirect(
            APP_URL . '/booking/details?number=' .
            urlencode($bookingNumber)
        );
        return;
    }

    // Confirm that this booking belongs to the logged-in customer.
    $bookingModel = new Booking();

    $booking = $bookingModel->findForCustomer(
        $bookingNumber,
        $user['id']
    );

    if (!$booking) {
        $_SESSION['review_error'] =
            'The requested booking could not be found.';

        $this->redirect(APP_URL . '/dashboard');
        return;
    }

    if ($booking['status'] !== 'completed') {
        $_SESSION['review_error'] =
            'You can review a service only after it is completed.';

        $this->redirect(
            APP_URL . '/booking/details?number=' .
            urlencode($bookingNumber)
        );
        return;
    }

    try {
        $reviewModel = new Review();

        $created = $reviewModel->createForCompletedBooking(
            $booking['id'],
            $user['id'],
            $rating,
            $comment
        );

        if (!$created) {
            $_SESSION['review_error'] =
                'A review may already exist for this booking.';
        } else {
            $_SESSION['review_success'] =
                'Thank you! Your review has been submitted successfully.';
        }

    } catch (Throwable $exception) {

        error_log(
            'Servora review submission error: ' .
            $exception->getMessage()
        );

        $_SESSION['review_error'] =
            'We could not submit your review. Please try again.';
    }

    $this->redirect(
        APP_URL . '/booking/details?number=' .
        urlencode($bookingNumber)
    );
}
}
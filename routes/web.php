
<?php

// Homepage
$router->get('/', function () {
    $controller = new HomeController();
    $controller->index();
});

// Login page
$router->get('/login', function () {
    $controller = new AuthController();
    $controller->login();
});

// Registration page
$router->get('/register', function () {
    $controller = new AuthController();
    $controller->register();
});

// Handle customer registration
$router->post('/register', function () {
    $controller = new AuthController();
    $controller->registerSubmit();
});

// Handle customer login
$router->post('/login', function () {
    $controller = new AuthController();
    $controller->loginSubmit();
});

// Browse services
$router->get('/services', function () {
    $controller = new ServiceController();
    $controller->index();
});

// Display complete service details
$router->get('/service/details', function () {
    $controller = new ServiceController();
    $controller->details();
});

// Browse service providers
$router->get('/providers', function () {
    $controller = new ProviderController();
    $controller->index();
});

// Customer dashboard
$router->get('/dashboard', function () {
    $controller = new DashboardController();
    $controller->index();
});

// Update customer profile
$router->post('/dashboard/profile/update', function () {
    $controller = new DashboardController();
    $controller->updateProfile();
});

// Upload or change profile photo
$router->post('/dashboard/profile/upload-image', function () {
    $controller = new DashboardController();
    $controller->uploadProfileImage();
});

// Display Become a Provider page
$router->get('/dashboard/become-provider', function () {
    $controller = new DashboardController();
    $controller->becomeProvider();
});

// Handle provider registration
$router->post('/dashboard/become-provider', function () {
    $controller = new DashboardController();
    $controller->becomeProviderSubmit();
});

// Fetch subcategories for selected main category
$router->get('/dashboard/provider-subcategories', function () {
    $controller = new DashboardController();
    $controller->providerSubcategories();
});

// Display provider dashboard
$router->get('/provider/dashboard', function () {
    $controller = new ProviderController();
    $controller->dashboard();
});

// Provider My Services
$router->get('/provider/services', function () {
    $controller = new ProviderController();
    $controller->services();
});

// Add a new provider service
$router->get('/provider/services/create', function () {
    $controller = new ProviderController();
    $controller->createService();
});

// Save a new provider service
$router->post('/provider/services/store', function () {
    $controller = new ProviderController();
    $controller->storeService();
});

// Submit customer booking
$router->post('/booking/store', function () {
    $controller = new BookingController();
    $controller->store();
});

// Display booking confirmation
$router->get('/booking/confirmation', function () {
    $controller = new BookingController();
    $controller->confirmation();
});

// Provider booking management

$router->get('/provider/bookings', function () {
    $controller = new ProviderController();
    $controller->bookings();
});

// Provider customer reviews
$router->get('/provider/reviews', function () {
    $controller = new ProviderController();
    $controller->reviews();
});

$router->get('/provider/bookings/details', function () {
    $controller = new ProviderController();
    $controller->bookingDetails();
});

$router->post('/provider/bookings/update-status', function () {
    $controller = new ProviderController();
    $controller->updateBookingStatus();
});


// Customer booking details
$router->get('/booking/details', function () {
    $controller = new BookingController();
    $controller->details();
});

// Customer submits a service review
$router->post('/booking/review', function () {
    $controller = new BookingController();
    $controller->submitReview();
});

// Customer reviews page
$router->get('/dashboard/my-reviews', function () {
    $controller = new DashboardController();
    $controller->myReviews();
});


// Handle user logout
$router->get('/logout', function () {

    // Clear all session data
    $_SESSION = [];

    // Remove the session cookie
    if (ini_get('session.use_cookies')) {

        $cookieParams = session_get_cookie_params();

        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $cookieParams['path'],
            'domain' => $cookieParams['domain'],
            'secure' => $cookieParams['secure'],
            'httponly' => $cookieParams['httponly'],
            'samesite' => $cookieParams['samesite']
        ]);
    }

    // Destroy the session
    session_destroy();

    // Redirect to homepage
    header('Location: ' . APP_URL . '/');
    exit;
});

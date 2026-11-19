
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


// Browse service providers
$router->get('/providers', function () {

    $controller = new ProviderController();

    $controller->index();

});
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
// Display provider dashboard
$router->get('/provider/dashboard', function () {
    $controller = new ProviderController();
    $controller->dashboard();
});


$router->get(
    '/dashboard/provider-subcategories',
    [DashboardController::class, 'providerSubcategories']
);


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

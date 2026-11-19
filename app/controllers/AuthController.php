
<?php

class AuthController extends Controller
{

    // Display the login page
    public function login()
    {
        $this->view('auth.index', [
            'activeTab' => 'login'
        ]);
    }


    // Display the registration page
    public function register()
    {
        $this->view('auth.index', [
            'activeTab' => 'register'
        ]);
    }


    // Process customer registration
    public function registerSubmit()
    {
        // Verify CSRF token
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            $this->json([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page.'
            ], 403);
        }

        // Receive form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate name
        if ($name === '') {
            $this->json([
                'success' => false,
                'message' => 'Please enter your full name.'
            ], 422);
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        // Validate password
        if (strlen($password) < 8) {
            $this->json([
                'success' => false,
                'message' => 'Password must contain at least 8 characters.'
            ], 422);
        }

        // Convert empty phone number to NULL
        if ($phone === '') {
            $phone = null;
        }

        // Create User model
        $userModel = new User();

        // Check whether email already exists
        if ($userModel->findByEmail($email)) {
            $this->json([
                'success' => false,
                'message' => 'This email address is already registered.'
            ], 409);
        }

        // Create customer account
        try {
            $userModel->create(
                $name,
                $email,
                $phone,
                $password
            );

            $this->json([
                'success' => true,
                'message' => 'Your account has been created successfully.',
                'redirect' => APP_URL . '/login'
            ]);

        } catch (PDOException $e) {
            error_log($e->getMessage());

            $this->json([
                'success' => false,
                'message' => 'Unable to create your account. Your email or phone number may already be registered.'
            ], 409);
        }
    }


    // Process customer login
    public function loginSubmit()
    {
        // Verify CSRF token
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) {
            $this->json([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page.'
            ], 403);
        }

        // Receive form data
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        // Validate password
        if ($password === '') {
            $this->json([
                'success' => false,
                'message' => 'Please enter your password.'
            ], 422);
        }

        // Find account
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Check email and password
        if (!$user || !password_verify($password, $user['password'])) {
            $this->json([
                'success' => false,
                'message' => 'Incorrect email or password.'
            ], 401);
        }

        // Check account status
        if ($user['status'] !== 'active') {
            $this->json([
                'success' => false,
                'message' => 'Your account is currently suspended. Please contact support.'
            ], 403);
        }

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Store authenticated user information
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on account role
        if ($user['role'] === 'admin') {
            $redirect = APP_URL . '/admin/dashboard';
        } else {
            $redirect = APP_URL . '/dashboard';
        }

        // Return successful response
        $this->json([
            'success' => true,
            'message' => 'Login successful. Welcome back!',
            'redirect' => $redirect
        ]);
    }

}

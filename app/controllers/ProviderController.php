
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
        // Check login
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/login');
        }

        $userModel = new User();

        $user = $userModel->findById($_SESSION['user_id']);

        // Check whether user exists and is active
        if (!$user || $user['status'] !== 'active') {
            $_SESSION = [];
            session_destroy();

            $this->redirect(APP_URL . '/login');
        }

        // Admin accounts use their own dashboard
        if ($user['role'] === 'admin') {
            $this->redirect(APP_URL . '/admin/dashboard');
        }

        // Find provider profile
        $providerModel = new Provider();

        $provider = $providerModel->findByUserId($user['id']);

        // Customer without provider profile cannot access
        if (!$provider) {
            $this->redirect(APP_URL . '/dashboard');
        }

        // Suspended providers cannot access provider dashboard
        if ($provider['status'] !== 'active') {
            $this->redirect(APP_URL . '/dashboard');
        }

        // Display provider dashboard
        $this->view('provider.dashboard', [
            'user' => $user,
            'provider' => $provider
        ]);
    }
}

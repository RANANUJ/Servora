
<?php

// Check whether a user is logged in
$isLoggedIn = !empty($_SESSION['user_id']);

// Get logged-in user details
$headerUserName = $_SESSION['user_name'] ?? '';
$headerUserRole = $_SESSION['user_role'] ?? 'customer';

// Create user initials
$headerInitial = $headerUserName !== ''
    ? strtoupper(substr($headerUserName, 0, 1))
    : 'U';

// Default dashboard URL
$dashboardUrl = $headerUserRole === 'admin'
    ? APP_URL . '/admin/dashboard'
    : APP_URL . '/dashboard';

// Default provider account settings
$hasProviderProfile = false;
$providerAccountUrl = APP_URL . '/dashboard/become-provider';
$providerAccountLabel = 'Become a Provider';

// Check whether the logged-in customer has a provider profile
if ($isLoggedIn && $headerUserRole !== 'admin') {

    try {

        global $pdo;

        $stmt = $pdo->prepare("
            SELECT id
            FROM provider_profiles
            WHERE user_id = :user_id
            LIMIT 1
        ");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $providerProfile = $stmt->fetch();

        if ($providerProfile) {

            $hasProviderProfile = true;

            $providerAccountUrl = APP_URL . '/provider/dashboard';

            $providerAccountLabel = 'Provider Account';
        }

    } catch (PDOException $e) {

        error_log($e->getMessage());

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Servora helps you find trusted local professionals for everyday services.">

    <title>Servora - Find Trusted Local Professionals</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Servora Custom CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">

</head>

<body>

    <!-- WEBSITE HEADER -->
    <header class="main-header">

        <nav class="navbar navbar-expand-lg">

            <div class="container">

                <!-- Servora Brand -->
                <a class="navbar-brand" href="<?= APP_URL ?>/">

                    <span class="brand-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>

                    <span class="brand-name">Servora<span>.</span></span>

                </a>

                <!-- Mobile Menu Button -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <!-- Navigation -->
                <div class="collapse navbar-collapse" id="mainNavbar">

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/#services">
                                Explore Services
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/#how-it-works">
                                How It Works
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/#about">
                                About Us
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/#contact">
                                Contact
                            </a>
                        </li>

                    </ul>

                    <!-- HEADER ACTIONS -->
                    <div class="header-actions">

                        <?php if ($isLoggedIn): ?>

                            <div class="dropdown">

                                <button
                                    class="user-profile-button dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                    <span class="user-profile-avatar">
                                        <?= htmlspecialchars($headerInitial, ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                    <span class="user-profile-name">
                                        <?= htmlspecialchars($headerUserName, ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end user-profile-menu">

                                    <li class="dropdown-header">

                                        Signed in as

                                        <strong>
                                            <?= htmlspecialchars($headerUserName, ENT_QUOTES, 'UTF-8') ?>
                                        </strong>

                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="<?= $dashboardUrl ?>">
                                            <i class="bi bi-grid me-2"></i>
                                            My Dashboard
                                        </a>
                                    </li>

                                    <?php if ($headerUserRole !== 'admin'): ?>

                                        <li>
                                            <a class="dropdown-item" href="<?= $providerAccountUrl ?>">
                                                <i class="bi bi-briefcase me-2"></i>
                                                <?= htmlspecialchars($providerAccountLabel, ENT_QUOTES, 'UTF-8') ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item logout-menu-item" href="<?= APP_URL ?>/logout">
                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            Logout
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        <?php else: ?>

                            <a href="<?= APP_URL ?>/login" class="login-link">
                                Log In
                            </a>

                            <a href="<?= APP_URL ?>/register" class="btn btn-primary header-register-btn">
                                Get Started
                                <i class="bi bi-arrow-up-right ms-1"></i>
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </nav>

    </header>

    <!-- Page content is rendered after this file. -->

</body>
</html>


<?php

// Generate a fresh CSRF token
$csrfToken = bin2hex(random_bytes(32));

$_SESSION['csrf_token'] = $csrfToken;

// Set active authentication tab
$activeTab = $activeTab ?? 'login';

// Include website header
include APP_ROOT . '/app/views/layouts/header.php';

?>

<section class="auth-page">

    <div class="auth-container">

        <div class="auth-card">

            <!-- WELCOME CONTENT -->
            <div class="auth-heading">

                <h1>Welcome</h1>

                <p>
                    Sign in with email to manage your saved
                    providers, reviews and business.
                </p>

            </div>


            <!-- AUTHENTICATION MESSAGE -->
            <div
                id="authMessage"
                class="auth-message"
                role="alert"
                aria-live="polite"
                style="display: none;"
            ></div>


            <!-- AUTHENTICATION TABS -->
            <div class="auth-tabs">

                <button
                    type="button"
                    class="auth-tab <?= $activeTab === 'login' ? 'active' : '' ?>"
                    data-tab="login"
                >
                    Sign in
                </button>

                <button
                    type="button"
                    class="auth-tab <?= $activeTab === 'register' ? 'active' : '' ?>"
                    data-tab="register"
                >
                    Create account
                </button>

                <div class="auth-tab-indicator <?= $activeTab === 'register' ? 'move-right' : '' ?>"></div>

            </div>


            <!-- LOGIN FORM -->
            <div
                class="auth-form-panel <?= $activeTab === 'login' ? 'active' : '' ?>"
                id="loginPanel"
            >

                <form id="loginForm">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <div class="auth-form-group">

                        <label for="loginEmail">Email</label>

                        <input
                            type="email"
                            id="loginEmail"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    <div class="auth-form-group">

                        <label for="loginPassword">Password</label>

                        <input
                            type="password"
                            id="loginPassword"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >

                    </div>


                    <div class="auth-forgot">

                        <a href="#">Forgot password?</a>

                    </div>


                    <button type="submit" class="auth-submit">

                        Sign in

                        <i class="bi bi-arrow-right"></i>

                    </button>

                </form>

            </div>


            <!-- REGISTRATION FORM -->
            <div
                class="auth-form-panel <?= $activeTab === 'register' ? 'active' : '' ?>"
                id="registerPanel"
            >

                <form id="registerForm">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                    >


                    <div class="auth-form-group">

                        <label for="registerName">Full name</label>

                        <input
                            type="text"
                            id="registerName"
                            name="name"
                            placeholder="Enter your full name"
                            required
                        >

                    </div>


                    <div class="auth-form-group">

                        <label for="registerEmail">Email</label>

                        <input
                            type="email"
                            id="registerEmail"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    <div class="auth-form-group">

                        <label for="registerPhone">Phone number</label>

                        <input
                            type="tel"
                            id="registerPhone"
                            name="phone"
                            placeholder="Enter your phone number"
                        >

                    </div>


                    <div class="auth-form-group">

                        <label for="registerPassword">Password</label>

                        <input
                            type="password"
                            id="registerPassword"
                            name="password"
                            placeholder="Create a password"
                            required
                        >

                    </div>


                    <button type="submit" class="auth-submit">

                        Create account

                        <i class="bi bi-arrow-right"></i>

                    </button>

                </form>

            </div>


            <!-- BACK TO HOMEPAGE -->
            <div class="auth-back">

                <a href="<?= APP_URL ?>/">

                    <i class="bi bi-arrow-left"></i>

                    Back to homepage

                </a>

            </div>

        </div>

    </div>

</section>


<script>

document.addEventListener('DOMContentLoaded', function () {

    // Authentication URLs
    const appUrl = <?= json_encode(APP_URL) ?>;

    // Authentication elements
    const tabs = document.querySelectorAll('.auth-tab');

    const indicator = document.querySelector('.auth-tab-indicator');

    const loginPanel = document.getElementById('loginPanel');

    const registerPanel = document.getElementById('registerPanel');

    const loginForm = document.getElementById('loginForm');

    const registerForm = document.getElementById('registerForm');

    const authMessage = document.getElementById('authMessage');


    // Show authentication messages
    function showMessage(message, success) {

        authMessage.textContent = message;

        authMessage.style.display = 'block';

        authMessage.classList.remove('success', 'error');

        authMessage.classList.add(
            success ? 'success' : 'error'
        );

    }


    // Switch between login and registration
    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const selectedTab = this.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');

            indicator.classList.toggle(
                'move-right',
                selectedTab === 'register'
            );

            loginPanel.classList.toggle(
                'active',
                selectedTab === 'login'
            );

            registerPanel.classList.toggle(
                'active',
                selectedTab === 'register'
            );

            authMessage.style.display = 'none';

        });

    });


    // LOGIN FORM SUBMISSION
    loginForm.addEventListener('submit', async function (event) {

        event.preventDefault();

        const submitButton = loginForm.querySelector(
            'button[type="submit"]'
        );

        const originalText = submitButton.innerHTML;

        submitButton.disabled = true;

        submitButton.textContent = 'Signing in...';

        try {

            const response = await fetch(
                appUrl + '/login',
                {
                    method: 'POST',
                    body: new FormData(loginForm),
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {

                showMessage(
                    result.message || 'Unable to log in. Please try again.',
                    false
                );

                return;

            }

            showMessage(
                result.message || 'Login successful!',
                true
            );

            // Redirect to the dashboard returned by PHP
            if (result.redirect) {

                window.location.assign(result.redirect);

            }

        } catch (error) {

            console.error('Login error:', error);

            showMessage(
                'Something went wrong. Please try again.',
                false
            );

        } finally {

            submitButton.disabled = false;

            submitButton.innerHTML = originalText;

        }

    });


    // REGISTRATION FORM SUBMISSION
    registerForm.addEventListener('submit', async function (event) {

        event.preventDefault();

        const submitButton = registerForm.querySelector(
            'button[type="submit"]'
        );

        const originalText = submitButton.innerHTML;

        submitButton.disabled = true;

        submitButton.textContent = 'Creating account...';

        try {

            const response = await fetch(
                appUrl + '/register',
                {
                    method: 'POST',
                    body: new FormData(registerForm),
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {

                showMessage(
                    result.message || 'Unable to create your account.',
                    false
                );

                return;

            }

            showMessage(
                result.message || 'Account created successfully!',
                true
            );

            // Redirect to login page
            if (result.redirect) {

                window.location.assign(result.redirect);

            }

        } catch (error) {

            console.error('Registration error:', error);

            showMessage(
                'Something went wrong. Please try again.',
                false
            );

        } finally {

            submitButton.disabled = false;

            submitButton.innerHTML = originalText;

        }

    });

});

</script>


<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>

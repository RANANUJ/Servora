
<?php include APP_ROOT . '/app/views/layouts/header.php'; ?>

<section class="auth-section">

    <div class="container">

        <div class="auth-card">

            <h2>Welcome Back</h2>

            <p>Login to continue using Servora.</p>


            <form id="loginForm">

                <div class="form-group">

                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                </div>


                <button type="submit" class="btn btn-primary">
                    Login
                </button>

            </form>


            <p class="auth-link">
                Don't have an account?
                <a href="<?= APP_URL ?>/register">Create Account</a>
            </p>

        </div>

    </div>

</section>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>

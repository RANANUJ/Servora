
<?php include APP_ROOT . '/app/views/layouts/header.php'; ?>

<section class="auth-section">

    <div class="container">

        <div class="auth-card">

            <h2>Create Your Account</h2>

            <p>Join Servora and discover trusted local services.</p>

            <form id="registerForm">

                <div class="form-group">

                    <label for="name">Full Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


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

                    <label for="phone">Phone Number</label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="Enter your phone number"
                    >

                </div>


                <div class="form-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        required
                    >

                </div>


                <button type="submit" class="btn btn-primary">
                    Create Account
                </button>

            </form>


            <p class="auth-link">
                Already have an account?
                <a href="<?= APP_URL ?>/login">Login</a>
            </p>

        </div>

    </div>

</section>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>

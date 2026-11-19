
<!-- FOOTER -->
<footer class="main-footer">

    <div class="container">

        <div class="row g-4 footer-main">

            <!-- BRAND -->
            <div class="col-lg-4 col-md-6">

                <a href="<?= APP_URL ?>/" class="footer-brand">
                    <i class="bi bi-geo-alt-fill"></i>
                    servora<span>.</span>
                </a>

                <p class="footer-description">
                    Your trusted local service marketplace.
                    Discover skilled professionals and make
                    everyday tasks easier with Servora.
                </p>

                <div class="footer-socials">

                    <a href="#" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="#" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="#" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>

                </div>

            </div>

            <!-- QUICK LINKS -->
            <div class="col-lg-2 col-md-6">

                <h5>Quick Links</h5>

                <ul class="footer-links">
                    <li><a href="<?= APP_URL ?>/">Home</a></li>
                    <li><a href="<?= APP_URL ?>/#services">Explore Services</a></li>
                    <li><a href="<?= APP_URL ?>/#how-it-works">How It Works</a></li>
                    <li><a href="<?= APP_URL ?>/#about">About Us</a></li>
                    <li><a href="<?= APP_URL ?>/#contact">Contact</a></li>
                </ul>

            </div>

            <!-- FOR CUSTOMERS -->
            <div class="col-lg-3 col-md-6">

                <h5>For Customers</h5>

                <ul class="footer-links">
                    <li><a href="<?= APP_URL ?>/register">Create Account</a></li>
                    <li><a href="<?= APP_URL ?>/login">Customer Login</a></li>
                    <li><a href="<?= APP_URL ?>/services">Browse Services</a></li>
                    <li><a href="<?= APP_URL ?>/#contact">Get Help</a></li>
                </ul>

            </div>

            <!-- FOR PROFESSIONALS -->
            <div class="col-lg-3 col-md-6">

                <h5>For Professionals</h5>

                <ul class="footer-links">
                    <li><a href="<?= APP_URL ?>/login">Become a Service Provider</a></li>
                    <li><a href="<?= APP_URL ?>/#contact">Contact Support</a></li>
                </ul>

            </div>

        </div>

        <!-- FOOTER BOTTOM -->
        <div class="footer-bottom">

            <p>
                &copy; <?= date('Y'); ?> Servora.
                All rights reserved.
            </p>

            <div>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
            </div>

        </div>

    </div>

</footer>

<!-- BOOTSTRAP JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SERVORA CUSTOM JAVASCRIPT -->
<script src="<?= APP_URL ?>/assets/js/script.js"></script>

</body>
</html>


document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // CUSTOMER REGISTRATION
    // =====================================

    const registerForm = document.getElementById('registerForm');

    if (registerForm) {

        registerForm.addEventListener('submit', async function (event) {

            event.preventDefault();

            const submitButton = registerForm.querySelector(
                'button[type="submit"]'
            );

            const messageBox = document.getElementById('authMessage');

            const originalButtonText = submitButton.innerHTML;

            messageBox.classList.remove('success', 'error');
            messageBox.style.display = 'none';
            messageBox.textContent = '';

            submitButton.disabled = true;
            submitButton.textContent = 'Creating account...';

            try {

                const response = await fetch('/servora/public/register', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },

                    body: new URLSearchParams(
                        new FormData(registerForm)
                    )

                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message || 'Registration failed.'
                    );
                }

                messageBox.classList.add('success');
                messageBox.textContent = result.message;
                messageBox.style.display = 'block';

                setTimeout(function () {

                    if (result.redirect) {
                        window.location.href = result.redirect;
                    } else {
                        window.location.href = '/servora/public/login';
                    }

                }, 1500);

            } catch (error) {

                messageBox.classList.add('error');
                messageBox.textContent = error.message;
                messageBox.style.display = 'block';

            } finally {

                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;

            }

        });

    }


    // =====================================
    // CUSTOMER LOGIN
    // =====================================

    const loginForm = document.getElementById('loginForm');

    if (loginForm) {

        loginForm.addEventListener('submit', async function (event) {

            event.preventDefault();

            const submitButton = loginForm.querySelector(
                'button[type="submit"]'
            );

            const messageBox = document.getElementById('authMessage');

            const originalButtonText = submitButton.innerHTML;

            messageBox.classList.remove('success', 'error');
            messageBox.style.display = 'none';
            messageBox.textContent = '';

            submitButton.disabled = true;
            submitButton.textContent = 'Signing in...';

            try {

                const response = await fetch('/servora/public/login', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },

                    body: new URLSearchParams(
                        new FormData(loginForm)
                    )

                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message || 'Login failed.'
                    );
                }

                messageBox.classList.add('success');
                messageBox.textContent = result.message;
                messageBox.style.display = 'block';

                setTimeout(function () {

                    if (result.redirect) {
                        window.location.href = result.redirect;
                    } else {
                        window.location.href = '/servora/public/dashboard';
                    }

                }, 1000);

            } catch (error) {

                messageBox.classList.add('error');
                messageBox.textContent = error.message;
                messageBox.style.display = 'block';

            } finally {

                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;

            }

        });

    }

});


$(document).ready(function () {

    // =====================================
    // CUSTOMER REGISTRATION
    // =====================================

    $('#registerForm').on('submit', function (event) {

        event.preventDefault();

        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        const messageBox = $('#authMessage');

        messageBox.removeClass('success error').hide().text('');

        submitButton.prop('disabled', true);
        submitButton.html('Creating account...');

        $.ajax({

            url: '/servora/public/register',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.success) {

                    messageBox
                        .removeClass('error')
                        .addClass('success')
                        .text(response.message)
                        .show();

                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 1500);

                } else {

                    messageBox
                        .removeClass('success')
                        .addClass('error')
                        .text(response.message)
                        .show();

                }

            },

            error: function (xhr) {

                let message = 'Something went wrong. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                messageBox
                    .removeClass('success')
                    .addClass('error')
                    .text(message)
                    .show();

            },

            complete: function () {

                submitButton.prop('disabled', false);

                submitButton.html(
                    'Create account <i class="bi bi-arrow-right"></i>'
                );

            }

        });

    });


    // =====================================
    // CUSTOMER LOGIN
    // =====================================

    $('#loginForm').on('submit', function (event) {

        event.preventDefault();

        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        const messageBox = $('#authMessage');

        messageBox.removeClass('success error').hide().text('');

        submitButton.prop('disabled', true);
        submitButton.html('Signing in...');

        $.ajax({

            url: '/servora/public/login',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.success) {

                    messageBox
                        .removeClass('error')
                        .addClass('success')
                        .text(response.message)
                        .show();

                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 1000);

                } else {

                    messageBox
                        .removeClass('success')
                        .addClass('error')
                        .text(response.message)
                        .show();

                }

            },

            error: function (xhr) {

                let message = 'Something went wrong. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                messageBox
                    .removeClass('success')
                    .addClass('error')
                    .text(message)
                    .show();

            },

            complete: function () {

                submitButton.prop('disabled', false);

                submitButton.html(
                    'Sign in <i class="bi bi-arrow-right"></i>'
                );

            }

        });

    });

});


<?php

// Load application configuration

require_once __DIR__ . '/../config/app.php';


// Automatically load application classes

spl_autoload_register(function ($className) {

    $directories = [
        APP_ROOT . '/app/core/',
        APP_ROOT . '/app/controllers/',
        APP_ROOT . '/app/models/',
        APP_ROOT . '/app/middleware/'
    ];

    foreach ($directories as $directory) {

        $file = $directory . $className . '.php';

        if (is_file($file)) {

            require_once $file;

            return;

        }

    }

});


// Load database connection

require_once __DIR__ . '/../config/database.php';


// Configure secure session cookies

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax'
    ]);

    session_start();

}

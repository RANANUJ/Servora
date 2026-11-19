
<?php

// Application configuration

define('APP_NAME', 'Servora');

define('APP_URL', 'http://localhost/servora/public');

define('APP_ROOT', dirname(__DIR__, 2));

define('PUBLIC_PATH', APP_ROOT . '/public');


// Application environment

define('APP_ENV', 'development');


// Timezone

date_default_timezone_set('Asia/Kolkata');


// Error reporting

if (APP_ENV === 'development') {

    error_reporting(E_ALL);

    ini_set('display_errors', '1');

} else {

    error_reporting(0);

    ini_set('display_errors', '0');

}

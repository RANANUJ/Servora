
<?php

// Load application bootstrap

require_once __DIR__ . '/../app/core/bootstrap.php';


// Create Router instance

$router = new Router();


// Load website routes

require_once APP_ROOT . '/routes/web.php';


// Execute the requested route

$router->dispatch();


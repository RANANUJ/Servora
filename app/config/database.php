
<?php

// Database configuration

$host = 'localhost';

$dbname = 'servora_db';

$username = 'root';

$password = '';


// Create database connection

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Enable database error exceptions
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Return database results as associative arrays
    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

    // Disable emulated prepared statements
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );

} catch (PDOException $e) {

    // Log the actual error privately
    error_log($e->getMessage());

    // Display a general error message
    die('Database connection failed. Please try again later.');

}

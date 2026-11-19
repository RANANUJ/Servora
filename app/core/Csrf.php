
<?php

class Csrf
{
    // Generate or retrieve a valid CSRF token
    public static function token()
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        // Check whether the existing token is valid
        if (
            !is_string($sessionToken) ||
            !preg_match('/\A[a-f0-9]{64}\z/i', $sessionToken)
        ) {
            // Generate a fresh 64-character token
            $sessionToken = bin2hex(random_bytes(32));

            $_SESSION['csrf_token'] = $sessionToken;
        }

        return $sessionToken;
    }

    // Verify the submitted CSRF token
    public static function verify($token)
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        if (
            !is_string($token) ||
            !is_string($sessionToken) ||
            !preg_match('/\A[a-f0-9]{64}\z/i', $token) ||
            !preg_match('/\A[a-f0-9]{64}\z/i', $sessionToken)
        ) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }
}

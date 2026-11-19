
<?php

class Router
{

    // Store all application routes
    private $routes = [];


    // Register a GET route
    public function get($uri, $callback)
    {

        $this->routes['GET'][$uri] = $callback;

    }


    // Register a POST route
    public function post($uri, $callback)
    {

        $this->routes['POST'][$uri] = $callback;

    }


    // Match and execute the requested route
    public function dispatch()
    {

        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        // Remove the project base path
        $basePath = '/servora/public';

        if (strpos($uri, $basePath) === 0) {

            $uri = substr($uri, strlen($basePath));

        }

        // Treat an empty path as the homepage
        $uri = $uri ?: '/';

        // Find the matching route
        $callback = $this->routes[$method][$uri] ?? null;

        if (!$callback) {

            http_response_code(404);

            echo '404 - Page Not Found';

            return;

        }

        // Execute the route callback
        if (is_callable($callback)) {

            call_user_func($callback);

        } else {

            throw new RuntimeException(
                'Invalid route callback.'
            );

        }

    }

}

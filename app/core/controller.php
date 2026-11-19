
<?php

class Controller
{

    // Load a view file
    protected function view($view, $data = [])
    {

        // Convert dot notation into folder paths
        $view = str_replace(
            '.',
            DIRECTORY_SEPARATOR,
            $view
        );

        // Build the complete view path
        $viewPath = APP_ROOT
            . '/app/views/'
            . $view
            . '.php';


        // Check whether the view exists
        if (!is_file($viewPath)) {

            throw new RuntimeException(
                'View not found: ' . $view
            );

        }


        // Make data available inside the view
        extract($data, EXTR_SKIP);


        // Load the view
        require $viewPath;

    }


    // Return a JSON response
    protected function json($data, $statusCode = 200)
    {

        http_response_code($statusCode);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);

        exit;

    }


    // Redirect to another URL
    protected function redirect($url)
    {

        header('Location: ' . $url);

        exit;

    }

}

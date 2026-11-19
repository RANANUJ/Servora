
<?php

class Model
{

    // Store the database connection
    protected $db;


    // Receive the PDO connection
    public function __construct()
    {

        global $pdo;

        $this->db = $pdo;

    }


    // Return the database connection
    protected function getConnection()
    {

        return $this->db;

    }

}

<?php

class Connector
{
    private $server = null;
    private $username = null;
    private $password = null;
    private $database = null;
    private $connection;

    public function __construct()
    {
        $this->database = "alexandr_manowarrior";
        $this->password = "Ma448204666";
        $this->username = "alexandr_manowar";

        $conn = new mysqli($this->server, $this->username, $this->password, $this->database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $this->connection = $conn;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
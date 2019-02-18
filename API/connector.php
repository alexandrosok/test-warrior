<?php

class Connector
{
    private $server = null;
    private $username = null;
    private $password = null;
    private $database = null;

    public function __construct()
    {
        $this->database = "alexandr_manowarrior";
        $this->password = "Ma448204666";
        $this->username = "alexandr_manowar";

        $conn = new mysqli($this->server, $this->username, $this->password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";
    }
}
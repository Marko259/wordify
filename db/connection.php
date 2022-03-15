<?php
class DB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "db_test";
    public $conn;

    public function connection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
        } catch(PDOException $exception) {
            echo "Connection error:" . $exception->getMessage();
        }

        return $this->conn;
    }
}
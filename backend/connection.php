<?php

class Database {
    private $host = "localhost"; // Host
    private $db_name = "wordify"; // Database navn
    private $username = "markus"; // MySQL Brugernavn
    private $password = "hejmeddig"; // MySQL Password

    public function connection() { // Definer funktionen connection

        $this->conn = null; // Nullstiller connection

        try { // Prøver at oprette forbindelse til databasen
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]); // Opretter forbindelse til databasen
        } catch(PDOException $exception) { // Hvis forbindelsen ikke kan oprettes
            echo "Connection error: " . $exception->getMessage(); // Skriver fejlbesked
        }

        return $this->conn; // Returnerer forbindelsen
    }
}
<?php
class Multiplayer
{
    private $conn; // Definerer forbindelsen
    private $table_name = "games"; // Definerer tabelnavnet

    public function __construct($db)
    {
        $this->conn = $db; // Definerer forbindelsen
    }

    public function create_game($id, $length, $guesses, $player_1)
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error); // Hvis forbindelsen ikke kan oprettes sendes fejlbesked
        }

        $query = "INSERT INTO " . $this->table_name . " (id, word_length, guesses, player_1) VALUES (?, ?, ?, ?)"; // Definerer query

        $stmt = $this->conn->prepare($query); // Konverter query til SQL statement

        try {
            if ($stmt->execute([$id, $length, $guesses, $player_1])) { // Hvis query'en kører
                return $id; // Hvis query'en var successfuld returnes id'et
            }
        } catch (Exception $e) { 
            echo $e->getMessage();// Hvis query ikke kan udføres sendes fejlbesked
        }
    }

    public function update_game($id, $word, $guesses, $player_1, $player_2)
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error); // Hvis forbindelsen ikke kan oprettes sendes fejlbesked
        }

        $query = "UPDATE " . $this->table_name . " SET word_length = ?, guesses = ?, player_1 = ?, player_2 = ? WHERE id = ?"; // Definerer query

        $stmt = $this->conn->prepare($query); // Konverter query til SQL statement

        try {
            if ($stmt->execute([$word, $guesses, $player_1, $player_2, $id])) { // Hvis query'en kører
                return true; // Hvis query'en var successfuld returnes true
            }
        } catch (Exception $e) { 
            echo $e->getMessage();// Hvis query ikke kan udføres sendes fejlbesked
        }
    }

    public function delete_game($id)
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error); // Hvis forbindelsen ikke kan oprettes sendes fejlbesked
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id"; // Definerer query

        $stmt = $this->conn->prepare($query); // Konverter query til SQL statement

        $stmt->bindParam(":id", $id); // Bind parametre

        try {
            if ($stmt->execute()) { 
                return true; // Hvis query'en var successfuld returnes true
            }
        } catch (Exception $e) { 
            echo $e->getMessage();// Hvis query ikke kan udføres sendes fejlbesked
        }
    }

    public function get_game($id)
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error); // Hvis forbindelsen ikke kan oprettes sendes fejlbesked
        }

        $query = "SELECT * FROM " . $this->table_name . " WHERE id=:id"; // Definerer query

        $stmt = $this->conn->prepare($query); // Konverter query til SQL statement

        $stmt->bindParam(":id", $id); // Bind parametre

        try {
            if ($stmt->execute()) { 
                return $stmt->fetch(PDO::FETCH_OBJ); // Hvis query'en var successfuld returnes resultatet i form af objekt
            }
        } catch (Exception $e) { 
            echo $e->getMessage();// Hvis query ikke kan udføres sendes fejlbesked
        }
    }

    public function guid()
    {
        return strtoupper(bin2hex(openssl_random_pseudo_bytes(8))); // Returner en guid
    }

    public function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

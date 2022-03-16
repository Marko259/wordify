<?php
class multiplayer {
    private $conn;
    private $table_name;

    public function create_game($uuid, $word_length, $guesses, $player_1) {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $query = "INSERT INTO " . $this->table_name . " (id, word_length, guesses, player_1) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $uuid);
        $stmt->bindParam(2, $word_length);
        $stmt->bindParam(3, $guesses);
        $stmt->bindParam(4, $player_1);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        header("Location: game.html");
        exit();
    }
}
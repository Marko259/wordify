<?php
class multiplayer
{
    private $conn;
    private $table_name = "games";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create_game($uuid)
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $query = "INSERT INTO $this->table_name SET id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $uuid);

        if ($stmt->execute()) {
            return $uuid;
        } else {
            return 'Nope';
        }
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

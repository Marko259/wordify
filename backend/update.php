<?php

if($_POST) {
    include_once 'connection.php';
    include_once 'handling.php';
    
    $database = new Database;
    $db = $database->connection();
    $multiplayer = new Multiplayer($db);
    $game = $multiplayer->update($id = $_POST['id'], $type = $_POST['type'], $attr = $_POST['attr']);
    
    if (!is_object($game)) {
        die("Error: Game not found");
    }
    
    echo json_encode($game);
} else {
    die("Error: No game ID provided");
}

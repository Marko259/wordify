<?php
include 'backend/connection.php';
include 'backend/handling.php';

$database = new Database;
$db = $database->connection();

$multiplayer = new Multiplayer($db);
if (isset($_GET['id'])) {
    $game = $multiplayer->get_game($_GET['id']);
} elseif (!$game && $_POST) {
    $game = $multiplayer->get_game($_POST['game']);
}

if($_POST){
    $newgame = $multiplayer->update_game($game->id, $game->word_length, $game->guesses, $game->player_1, $_POST['player_2']);
    if($newgame == true){
        session_start();
        $_SESSION['player'] = 'player_2';
        header("Location: setup.php?id=$game->id");
    } else {
        echo $newgame;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Wordify - Tilslut et spil</title>
</head>

<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card text-center responsiveCard">
            <div class="position-absolute top-0 start-0">
                <a href="index.html" id="play-btn" class="btn btn-primary mt-3 ms-3"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            </div>
            <div class="card-body">
                <br><br>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <p class="card-text-inv">Indtast selvvalgt brugernavn</p>
                    <div class="form-group mb-3">
                        <input type="text" name="player_2" class="form-control" placeholder="Brugernavn" maxlength="16">
                    </div>
                    <p class="card-text-inv">Indsæt din kode</p>
                    <div class="input-group mb-3 inviteLink">
                        <input type="text" id="inviteLink" name="game" class="form-control" placeholder="Kode til at tilslutte et spil" aria-label="Invite link til deling" value="<?php if (is_object($game)) : echo $game->id; else : echo null; endif ?>" aria-describedby="button-addon2">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3 w-50">Tilslut et spil</button>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="">Hjælp</a>
            </div>
        </div>
    </div>


    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>
<?php

include_once 'backend/connection.php';
include_once 'backend/handling.php';

$database = new Database;
$db = $database->connection();

$multiplayer = new Multiplayer($db);
$game = $multiplayer->get_game($_GET['id']);
if(!is_object($game)) {
    die("Error: Game not found");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/game.css">
    <title>Wordify - Game</title>
</head>

<body>
    <div class="alert-container" data-alert-container></div>
    <div class="row">
        <div class="justify-content-between">
            <section class="game-opp">
                <div class="game-window">
                    <div class="card border-primary border-3 text-center">
                        <div class="card-body">
                            <?php echo $game->player_1;?> 
                            <div class="guess-grid mt-3 mb-3" data-guess-grid>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                                <div class="tile"></div>
                            </div>
                           
                        </div>
                    </div>
                </div>


                <div class="opp-window hide-on-mobile">
                    <div class="card text-center">
                        <div class="card-body">
                            <?php echo $game->player_2;?> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>




    <!-- <div class="position-absolute top-0 start-50 translate-middle-x">
        <h1>WORDIFY</h1>
    </div>

    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card text-center">
            <div class="card-body">
                <div id="spinner">
                    <div class="spinner-border text-red mt-3" role="status">
                        <span class="sr-only">Venter på modstander</span>
                    </div>
                    <p class="card-text m-3">Venter på modstander..</p>
                </div>
                <div id="completed" style="display: none;">
                    <p class="card-text">tyk</p>
                </div>

            </div>
            <div class="card-footer text-muted">
                <a href="">Hjælp</a>
            </div>
        </div>
    </div> -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/socket.io/client-dist/socket.io.js"></script>
    <script src="assets/js/game.js" defer></script>
</body>

</html>
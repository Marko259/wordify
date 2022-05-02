<?php

include_once 'backend/connection.php';
include_once 'backend/handling.php';

$database = new Database;
$db = $database->connection();

$multiplayer = new Multiplayer($db);
$game = $multiplayer->get_game($_GET['id']);
if (!is_object($game)) {
    die("Error: Game not found");
}

session_start();
if (!$_SESSION['player']) : die("Error: You are not logged in");
endif;

if ($_SESSION['player'] == 'player_1') {
    $player = $game->player_1;
    $opponent = $game->player_2;
} else {
    $player = $game->player_2;
    $opponent = $game->player_1;
    $_SESSION['username'] = $game->player_2;
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
    <style>
        .guess-grid {
            grid-template-columns: repeat(<?php echo $game->word_length; ?>, 4em);
            grid-template-rows: repeat(<?php echo $game->guesses; ?>, 4em);
        }
    </style>
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
                            <?php echo $player; ?>
                            <div class="guess-grid mt-3 mb-3" data-guess-grid>
                                <?php for ($x = 1; $x <= $game->word_length * $game->guesses; $x++) { ?>
                                    <div class="tile"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="opp-window hide-on-mobile">
                    <div class="card text-center">
                        <div class="card-body">
                            <?php echo $opponent; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="position-absolute top-50 start-50 translate-middle mt-5" id="game-complete" style="display: none;">
        <a id="confirmButton" href="http://wordify.dk" class="btn btn-primary btn-lg m-2">Hovedmenu</a>
        <a id="confirmButtonPlay" class="btn btn-primary btn-lg m-2">Spil Igen</a>
    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/socket.io/client-dist/socket.io.js"></script>
    <script type="text/javascript">
        const word_length = <?php echo $game->word_length; ?>;
        <?php if ($_SESSION['player'] == 'player_1') : ?>
            const targetword = "<?php echo $game->player_2_word ?>";
            const player = "player_1_complete";
        <?php else : ?>
            const targetword = "<?php echo $game->player_1_word ?>";
            const player = "player_2_complete";
        <?php endif; ?>
        const game_id = '<?php echo $game->id; ?>';
        $("#confirmButtonPlay").click(function() {
            $.ajax({
                url: 'backend/reset.php',
                type: 'POST',
                data: {
                    id: game_id
                },
                dataType: 'json',
                success: function(data) {
                    window.location.href = "../setup.php?id=" + game_id;
                }, error: function(data) {
                    console.log(data);
                }
            })
        });
    </script>
    <script src="assets/js/game.js" defer></script>
</body>

</html>
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
if (!$_SESSION['player']) : die("Error: You are not logged in");endif;

if($_SESSION['player'] == 'player_2' && $_SESSION['username'] != null) {
    $newgame = $multiplayer->update_game($game->id, $game->word_length, $game->guesses, $game->player_1, $_SESSION['username']);
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
    <title>Wordify - Setup</title>
</head>

<body>
    <div class="alert-container" data-alert-container></div>
    <div class="position-absolute top-50 start-50 translate-middle" style="display: none;" id="completed">
        <div class="card text-center responsiveCard setup-card border-primary">
            <p class="card-text-inv">Indtast ord som modstander skal gætte</p>
            <p class="text-muted">Max <span class="highlight-color"><?php echo $game->word_length; ?></span> bogstaver</p>
            <div class="form-group m-3">
                <input type="text" name="player_1" class="form-control" placeholder="Ord" maxlength="<?php echo $game->word_length; ?>" onkeydown="return /[a-zæøå]/i.test(event.key)">
            </div>
            <button id="confirmButton" class="btn btn-primary" onclick="confirmWord('<?php echo $game->id; ?>', '<?php echo $_SESSION['player']; ?>')">Bekræft ord</button>
            <button id="waitButton" class="btn btn-primary btn-primary-dis">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Venter på modstander..
            </button>
        </div>
    </div>


    <div class="position-absolute top-0 start-50 translate-middle-x">
        <h1>WORDIFY</h1>
    </div>
    <div class="position-absolute top-50 start-50 translate-middle" id="spin">
        <div class="card text-center">
            <div class="card-body">
                <div id="spinner">
                    <div class="spinner-border text-red mt-3" role="status">
                        <span class="sr-only">Venter på modstander</span>
                    </div>
                    <p class="card-text m-3">Venter på modstander..</p>
                    <p class="card-text-inv mt-5">Link til invitation</p>
                    <div class="input-group inviteLink">
                        <input type="text" id="inviteLink" class="form-control" placeholder="Link til modstander" aria-label="Link til modstander" aria-describedby="button-addon2" value="<?php echo 'http://wordify.dk/join-game.php?id=' . $game->id; ?>" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i id="copy-btn" class="fa-regular fa-clone"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="#">Hjælp</a>
            </div>
        </div>
    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#button-addon2").click(function() {
                copyToClipboard()
            });


            function copyToClipboard() {
                console.time('time1');
                var copyText = document.getElementById("inviteLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                document.getElementById("copy-btn").classList.remove('fa-regular');
                document.getElementById("copy-btn").classList.remove('fa-clone');
                document.getElementById("copy-btn").classList.add('fa-solid');
                document.getElementById("copy-btn").classList.add('fa-check');
                console.timeEnd('time1');
            }

            function getData() {
                const player_type = '<?php echo $_SESSION['player']; ?>';
                $.ajax({
                    url: "/backend/get.php",
                    type: "GET",
                    data: {
                        'id': '<?php echo $game->id; ?>'
                    },
                    dataType: "json",
                    success: function(data) {
                        if (player_type == 'player_1') {
                            if (data.player_2 != null) {
                                Completed();
                            }
                        } else {
                            if (data.player_1 != null) {
                                Completed();
                            }
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            check = setInterval(getData, 1000);

            function Completed() {
                $('#spin').hide();
                $('#completed').show();
                clearInterval(check);
            }
        });
        const word_length = <?php echo $game->word_length; ?>;
    </script>
    <script src="./assets/js/setup.js"></script>
</body>

</html>
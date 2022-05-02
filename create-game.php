<?php

include 'backend/connection.php';
include 'backend/handling.php';

$database = new Database;
$db = $database->connection();

$game = new Multiplayer($db);
$id = $game->guid();

if($_POST): $newgame = $game->create_game($_POST['id'], $_POST['length'], $_POST['guesses'], $_POST['player_1']); endif;

if($newgame){
  session_start(); 
  $_SESSION['player'] = 'player_1';
  header("Location: setup.php?id=$newgame"); 
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

  <title>Wordify - Lav spil</title>
</head>

<body>
   <div class="position-absolute top-50 start-50 translate-middle">
    <div class="card text-center responsiveCard create-game-card">
      <div class="position-absolute top-0 start-0">
        <a href="index.html" id="play-btn" class="btn btn-primary mt-3 ms-3"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
      </div>
      <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          <div align="center">
          <p class="card-text w-25">Ordlængde</p>
          </div>
          

          <fieldset class="center" data-quantity="">
            <legend>Change quantity</legend>
            <button type="button" title="Down" class="sub" id="counterDOWN-length" data-type="length">Down</button><input name="length" type="number" id="counter-length" min="4" max="6" value="4" readonly><button type="button" title="Up" class="add" id="counterUP-length" data-type="length">Up</button>
          </fieldset>

          <p class="card-text">Antal Gæt</p>

          <fieldset class="center" data-quantity="">
            <legend>Change quantity</legend>
            <button type="button" title="Down" class="sub" id="counterDOWN-quantity" data-type="quantity">Down</button><input name="guesses" type="number" min="4" max="8" id="counter-quantity" value="4" readonly><button type="button" title="Up" class="add" id="counterUP-quantity" data-type="quantity">Up</button>
          </fieldset>

          <p class="card-text-inv">Indtast selvvalgt brugernavn</p>
          <div class="form-group mb-3">
              <input type="text" name="player_1" class="form-control" placeholder="Brugernavn" maxlength="16">
          </div>

          <p class="card-text-inv">Link til invitation</p>
          <div class="input-group mb-3 inviteLink">
            <input type="text" id="inviteLink" class="form-control" placeholder="Link til modstander" aria-label="Link til modstander" aria-describedby="button-addon2" value="<?php echo 'http://wordify.dk/join-game.php?id=' . $id; ?>" readonly>
            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i id="copy-btn" class="fa-regular fa-clone"></i></button>

          </div>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <button id="play-btn" class="btn btn-primary btn-lg" type="submit">Lav Spil</button>
        </form>
      </div>
      <div class="card-footer text-muted">
        <a data-bs-toggle="collapse" href="#helpCard" role="button" aria-expanded="false" aria-controls="collapseExample">Hjælp</a>
      </div>
    </div>
    <br>
    <div class="collapse" id="helpCard">
  <div class="card card-body">
    Allan er liiiidt tyk o_o
  </div>
</div>
  </div>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>

</body>

</html>

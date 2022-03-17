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
        <form action="" method="post">
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
            <button type="button" title="Down" class="sub" id="counterDOWN-quantity" data-type="quantity">Down</button><input name="quantity" type="number" min="4" max="8" id="counter-quantity" value="4" readonly><button type="button" title="Up" class="add" id="counterUP-quantity" data-type="quantity">Up</button>
          </fieldset>

          <p class="card-text-inv">Indtast selvvalgt brugernavn</p>
          <div class="form-group mb-3">
              <input type="text" name="player_1" class="form-control" placeholder="Brugernavn" maxlength="16">
          </div>

          <p class="card-text-inv">Kode til invitation</p>
          <div class="input-group mb-3 inviteLink">
            <input type="text" id="inviteLink" class="form-control" placeholder="Kode til modstander" aria-label="Kode til modstander" aria-describedby="button-addon2" value="QWMERM12" readonly>
            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i id="copy-btn" class="fa-regular fa-clone"></i></button>

          </div>
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
    Markus er liiiidt tyk o_o
  </div>
</div>
  </div>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>

</body>

</html>

<?php

include('../backend/handling.php');
include('../db/connection.php');

if (isset($_POST['submit'])) {
  $length = $_POST['length'];
  $guesses = $_POST['guesses'];
  $player_1 = $_POST['player_1'];
  $uuid = $_POST['uuid'];

  $database = new DB;
  $db = $database->connection();

  $game = new multiplayer($db);
  $game->create_game($uuid, $length, $guesses, $player_1);
}

?>

<?php
  session_start();
  include_once('./database.php');

  if(!isset($_SESSION['games_player']))
    header('location: register.php');

  $conn = Database();
    
  if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

  $GAMES = ['hexagon_game', 'color_game', 'einstein_game'];
  $has_played = array();

  $player_id = $_SESSION['games_player']['id'];

  foreach ($GAMES as $game) {
    $sql = "SELECT * FROM `".$game."` WHERE (`player_id` = '$player_id' AND `completed` = '1')";
    $result = $conn->query($sql);    

    if($result->num_rows > 0){
      array_push($has_played, true);
    } else {
      array_push($has_played, false);
    }
  }
  unset($game);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Főoldal</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="selection-container">
  
  <a href="./hexagon-puzzle" class="game-box game1 <?php if($has_played[0]) echo 'completed'?>">
    <?php if($has_played[0]) echo "<div class='completed-tick'></div>"; ?>
    <div class="game-layer">
      <div class="game-name">Hexagon Puzzle</div>
    </div>
  </a>

  <a href="./color-game" class="game-box game2 <?php if($has_played[1]) echo 'completed'?>">
    <?php if($has_played[1]) echo "<div class='completed-tick'></div>"; ?>
    <div class="game-layer">
      <div class="game-name">Torta szeletelés</div>
    </div>
  </a>

  <a href="./einstein-game" class="game-box game3 <?php if($has_played[2]) echo 'completed'?>">
    <?php if($has_played[2]) echo "<div class='completed-tick'></div>"; ?>
    <div class="game-layer">
      <div class="game-name">Einstein feladványa</div>
    </div>
  </a>
</div>

</body>
</html>
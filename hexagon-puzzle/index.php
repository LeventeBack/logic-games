<?php
  session_start();
  
  if(!isset($_SESSION['games_player']))
    header('location: ../');

  include_once('../database.php');

  $conn = Database();
    
  if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

  $player_id = $_SESSION['games_player']['id'];

  $sql = "SELECT * FROM hexagon_game WHERE player_id = '$player_id' AND completed = '1'";
  $result = $conn->query($sql);

  if($result->num_rows > 0)
    header('location: ../');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hexagon Puzzle</title>
  <script 
    src="https://code.jquery.com/jquery-3.5.1.min.js" 
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
    crossorigin="anonymous">
  </script>
  <script src="script.js" defer></script>
  <link rel="stylesheet" href="./style.css">
  <link rel="shortcut icon" href="./pics/hexagon.png" type="image/x-icon">
</head>
<body>  
  <div class="wrapper">

    <div class="outer-container">
      <div class="task-container" data-task>
        <span>
          <strong>Feladat:</strong>
          Helyezd el a kis hatszögeket a nagy alakzatba, úgy, hogy két szomszédos háromszögben ugyanaz a szám legyen. A megadott hatszögeket nem lehet elforgatni.
        </span>
        <button class="btn" data-restart>Újrakezd</button>
      </div>

      <div class="container">
      
        <div class="pieces-container" data-pieces-container>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
          <div class="puzzle-piece" data-piece></div>
        </div>
      
        <div class="grid" data-grid>
          <div class="div1 target-cell" data-target-cell data-id="1"> </div>
          <div class="div2 target-cell" data-target-cell data-id="2"> </div>
          <div class="div3 target-cell" data-target-cell data-id="3"> </div>
          <div class="div4 target-cell" data-target-cell data-id="4"> </div>
          <div class="div5 target-cell" data-target-cell data-id="5"> </div>
          <div class="div6 target-cell" data-target-cell data-id="6"> </div>
          <div class="div7 target-cell" data-target-cell data-id="7"> </div>
        </div>
      
      </div>

      <div class="message hidden" data-message>
          <h1 class="text">Gratulálok! Ügyes vagy!</h1>
          <a href="../" class="btn">Vissza a Főoldalra</a>
      </div>
    </div>
  </div>
  
</body>
</html>
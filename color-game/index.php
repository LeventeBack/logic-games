<?php
  session_start();
  
  if(!isset($_SESSION['games_player']))
    header('location: ../');

  include_once('../database.php');
  
  $conn = Database();
    
  if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

  $player_id = $_SESSION['games_player']['id'];

  $sql = "SELECT * FROM color_game WHERE player_id = '".$player_id."'";
  $result = $conn->query($sql);

  if($result->num_rows > 0)
    header('location: ../');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="./img/cursor.png" type="image/x-icon">
  <script 
    src="https://code.jquery.com/jquery-3.5.1.min.js" 
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
    crossorigin="anonymous">
  </script>
  <script src="script.js" defer></script>
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="side">
      <div class="task">
        <strong>Feladat: </strong>
        <p>
          Az ábrán egy megdézsmált rácsos sütemény látható, éppen 20 darab egyforma rácsnégyzettel díszítve. Öt barát úgy szeretné egymás között testvériesen elosztani a süteményt, hogy mindegyikük sütije egy darabból álljon, éppen négy rácsnégyzetet tartalmazzon, de mindegyikük más-más alakú sütit kapjon. Segíts nekik!
        </p>
      </div>
      <div class="color-container">
        <div class="color" data-color id="startClick"></div>
        <div class="color" data-color></div>
        <div class="color" data-color></div>
        <div class="color" data-color></div>
        <div class="color" data-color></div>
        <div class="color" data-color></div>
      </div>    
      <div class="button-container">
        <button class="btn" data-restart>Újrakezdem</button>
        <button class="btn" data-finish>Befejezem</button>
      </div>  
    </div>
    <div class="grid" data-grid>
      <div class="grid-cell" data-grid-cell data-row="1" data-column="1"></div>
      <div class="grid-cell" data-grid-cell data-row="1" data-column="2"></div> 
      <div class="grid-cell" data-grid-cell data-row="1" data-column="3" ></div>
      <div class="div1 disabled"> </div>
      <div class="grid-cell" data-grid-cell data-row="1" data-column="5"></div>
      <div class="div2 disabled"> </div>
      <div class="grid-cell" data-grid-cell data-row="2" data-column="1"></div>
      <div class="grid-cell" data-grid-cell data-row="2" data-column="2"></div>
      <div class="grid-cell" data-grid-cell data-row="2" data-column="3"></div>
      <div class="grid-cell" data-grid-cell data-row="2" data-column="4"></div>
      <div class="grid-cell" data-grid-cell data-row="2" data-column="5"></div>
      <div class="grid-cell" data-grid-cell data-row="3" data-column="1"></div>
      <div class="grid-cell" data-grid-cell data-row="3" data-column="2"></div>
      <div class="grid-cell" data-grid-cell data-row="3" data-column="3"></div>
      <div class="grid-cell" data-grid-cell data-row="3" data-column="4"></div>
      <div class="grid-cell" data-grid-cell data-row="3" data-column="5"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="1"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="2"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="3"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="4"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="5"></div>
      <div class="grid-cell" data-grid-cell data-row="4" data-column="6"></div>
    </div>
  </div>
</body>
</html>
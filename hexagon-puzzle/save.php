<?php
  session_start();
  include_once('../database.php');

  if(isset($_SESSION['games_player']) && isset($_POST['time'])){
    $name = $_SESSION['games_player']['name'];
    $code = $_SESSION['games_player']['id'];
    $school = $_SESSION['games_player']['school'];
    $class = $_SESSION['games_player']['class'];
    $time = $_POST['time'];

    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);

    $sql = "INSERT INTO hexagon_game (name, player_id, time, school, class) 
            VALUES ('".$name."', '".$code."', '".$time."', '".$school."', '".$class."') ";
    $result = $conn->query($sql);

    if(!$result)
      die("Insertion failed.");
    
    echo "Data stored to database!";
  } 
  else {
    echo "Invalid datas!";
  }
?>
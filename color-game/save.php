<?php 
  session_start();
  include_once('../database.php');

  if(isset($_SESSION['games_player'])){
    $player_id = $_SESSION['games_player']['id'];
    $institution = $_SESSION['games_player']['institution'];
    $major = $_SESSION['games_player']['major'];
    $class = $_SESSION['games_player']['class'];
    $time = $_POST['time'];
    $completed = $_POST['completed'];

    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM color_game WHERE player_id = '$player_id'";
    $history = $conn->query($sql);
  
    if($history->num_rows == 0){
      $sql = "INSERT INTO color_game (player_id, institution, major, class, time, completed) 
              VALUES ('$player_id', '$institution', '$major', '$class', '$time', $completed) ";
      $result = $conn->query($sql);
  
      if(!$result)
        die("Insertion failed.");
      
      echo "Data stored to database!";
    } else {
      $player = $history->fetch_object();

      $formattedTime = date("H:i:s", mktime(0, 0, $time));
      $secs = strtotime($formattedTime)-strtotime("00:00:00");
      $totalTime = date("H:i:s",strtotime($player->time)+$secs);

      $totalAttempt = $player->attempt + 1;

      $sql = "UPDATE color_game 
              SET `time` = '$totalTime', 
              `completed` = '$completed',
              `attempt` = '$totalAttempt'
              WHERE player_id = '$player_id'";
      $result = $conn->query($sql);
      echo "Player time updated";
    }
    if($completed){
      $image = $_POST['image'];
      $image = explode(";", $image)[1];
      $image = explode(",", $image)[1];      
      $image = base64_decode($image);
      file_put_contents("./solutions/$player_id.jpg", $image);
    }

  
  } 
  else {
    echo "Invalid datas!";
  }
?>
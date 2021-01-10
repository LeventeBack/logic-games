<?php 
  session_start();
  include_once('../database.php');

  if(isset($_SESSION['games_player']) && isset($_POST['time']) && isset($_POST['image'])){
    $name = $_SESSION['games_player']['name'];
    $code = $_SESSION['games_player']['id'];
    $school = $_SESSION['games_player']['school'];
    $class = $_SESSION['games_player']['class'];

    $time = $_POST['time'];

    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);

    $sql = "INSERT INTO color_game (name, player_id, time, school, class) 
            VALUES ('".$name."', '".$code."', '".$time."', '".$school."', '".$class."') ";
    $result = $conn->query($sql);

    if(!$result)
      die("Insertion failed.");
    
    echo "Data stored to database!";

    $image = $_POST['image'];
    $image = explode(";", $image)[1];
    $image = explode(",", $image)[1];
  
    $image = base64_decode($image);
    file_put_contents("./solutions/".$_SESSION['games_player']['id'].".jpg", $image);
  } 
  else {
    echo "Invalid datas!";
  }
?>
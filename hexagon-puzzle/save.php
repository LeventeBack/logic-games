<?php
  include_once('database.php');

  if(isset($_POST['name']) && isset($_POST['time'])){
    $time = $_POST['time'];
    
    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);

    $sql = "INSERT INTO hexagon_game (name, time) VALUES ('".$name."', '".$time."') ";
    $result = $conn->query($sql);

    if(!$result)
      die("Insertion failed.");
    
    echo "Data stored to database!";
  } 
  else {
    echo "Invalid datas!";
  }
?>
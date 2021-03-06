<?php
  session_start();
  include('./database.php');
  if(isset($_SESSION['games_player'])){
    header('location: index.php');
  }
  if(isset($_POST['submit']) && isset($_POST['player_id'])){
    $id = $_POST['player_id'];
    
    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);


    $sql = "SELECT * FROM players WHERE id = '".$id."'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
      $_SESSION['games_player'] = $result->fetch_assoc();
      header('location: index.php');
    }
    else {
      echo "<div class='error'>Hibás Kód!</div>";
    }
  } 
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
<?php

  if(isset($_GET['success'])){
    echo "<div class='notice'>Sikeres regisztráció, most jelentkezz be!</div>";
  }
?>

  <div class="form-container">
    <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="player_id">Add meg az azonosító kódod!</label>
      <input type="text" name="player_id" id="player_id" required>
      <input type="submit" value="Belépés" name="submit" id="submit">
      
      <a href="./register.php" class="link">Nincs azonosítód? Kattints ide!</a>
    </form>
  </div>

</body>
</html>
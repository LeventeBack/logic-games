<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Főoldal</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php
      if(isset($_SESSION['games_player']))
        include('./pages/menu.php');
      else 
        include('./pages/register.php');
    ?>
</body>
</html>
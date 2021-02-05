<?php
  session_start();
  if(isset($_SESSION['games_player']))
    include('./pages/menu.php');
  else 
    include('./pages/register.php');
?>
<?php 
  include('./database.php');
  if(isset($_POST['submit']) && isset($_POST['code'])){
    $code = $_POST['code'];
    
    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);


    $sql = "SELECT * FROM players WHERE id = '".$code."'";
    $result = $conn->query($sql);

    if($result->num_rows == 0)
      echo "<div class='error'>Hibás Kód!</div>";
    else {
      $_SESSION['games_player'] = $result->fetch_assoc();
      header('location: ./');
    }
  } 
?>
<div class="login-container">
  <form class="login-form" method="POST">
    <label for="code">Add meg az azonosító kódod!</label>
    <input type="text" name="code" id="code" required>
    <input type="submit" value="Belépés" name="submit" id="submit">
  </form>
</div>
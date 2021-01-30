<?php 
  include('./database.php');
  $isError = false;

  if(isset($_POST['submit'])){
    $id = $_POST['player_id'];
    $institution = $_POST['institution'];
    $major = $_POST['major'];
    $class = $_POST['class'];
    
    $conn = Database();
    
    if ($conn->connect_error) 
      die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM players WHERE id = '".$id."'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
      echo "<div class='error'>Ez az azonostó már foglalt!</div>";
      $isError = true;
    }
    else {
      $sql = "INSERT INTO players (id, institution, major, class) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $id, $institution, $major, $class);
      $result = $stmt->execute();
      if($result){
        header('location: login.php?success');
        exit(0);
      } else {

      }
    }
  } 
?>
<div class="form-container" >
  <form class="form " action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="type">Add meg az adataidat!</label>
    <div class="<?PHP echo ($isError)? "hidden":""?>">
      <select name="type" data-type>
        <option value="" selected="selected">Válaszd ki a korosztályodat</option>
      </select>
    
      <select class="hidden" name="institution" data-institution>
        <option value="" selected="selected">Válaszd ki az tanintézményed</option>
      </select>

      <select class="hidden" name="major" data-major>
        <option value="" selected="selected">Válaszd ki a szakodat</option>
      </select>
    
      <select class="hidden" name="class" data-class>
        <option value="" selected="selected">Válaszd ki az osztályod/évfolyamod</option>
      </select>
    </div>

    <label for="player_id" class="<?PHP echo ($isError)? "":"hidden"?> small" data-playerid>Adj meg egy egyéni azonosítót amivel majd be tudsz jelentkezni.
      <input 
        type="text" 
        id="player_id" 
        name="player_id" 
        placeholder="Azonostó"
        autocomplete="off"
        minlength="3"
        maxlength="50"
        required
      >
    </label>
 
    <input 
      name="submit" 
      type="submit" 
      <?PHP echo ($isError)? "":"disabled"?> 
      value="Regisztráció" 
      data-submit
    >  

    <a href="./login.php" class="link">Van már azonosítód? Kattints ide!</a>

  </form> 

</div>
<script src="script.js"></script>
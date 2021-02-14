<?php
  session_start();
  
  if(!isset($_SESSION['games_player']))
    header('location: ../');

  include_once('../database.php');
  
  $conn = Database();
    
  if ($conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);

  $player_id = $_SESSION['games_player']['id'];

  $sql = "SELECT * FROM einstein_game WHERE player_id = '$player_id' AND completed = '1'";
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
  <script 
    src="https://code.jquery.com/jquery-3.5.1.min.js" 
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
    crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
  <script src="../html2canvas.min.js"></script>
  <script src="./script.js" defer></script>
  <title>Einstein feladványa</title>
</head>
<body>
<div class="wrapper">
    <div class="task">
      <div class="task__column">
          <h1 class="task__title">Einstein feladványa</h1>
          <p class="task_description">
            Van 5 ház, mindegyik más színű.
            Minden házban egy más-más nemzetiségű személy lakik.
            Minden háztulajdonos bizonyos italt részesít előnyben, különböző hobbija van és más állatot tart.
            Ezen személyek közül <span class="bold">egyik sem</span> iszik <span class="bold">ugyanolyan</span> italt. Nem ugyanaz a hobbija és nem tart ugyanolyan állatot, mint valamelyik szomszédja.
          </p>

      </div>
      <div class="task__column">
        <h2 class="task__list-title">Azt lehet tudni, hogy: </h2>
        <ul class="task__list">
          <li><input type="checkbox" id="task1"><label for="task1">A brit piros házban lakik.</label></li>
          <li><input type="checkbox" id="task2"><label for="task2">A svéd kutyát tart.</label></li>
          <li><input type="checkbox" id="task3"><label for="task3">A dán szívesen iszik teát.</label></li>
          <li><input type="checkbox" id="task4"><label for="task4">A német szeret zongorázni.</label></li>
          <li><input type="checkbox" id="task5"><label for="task5">A norvég az első házban lakik.</label></li>
          <li><input type="checkbox" id="task6"><label for="task6">A zöld ház tulajdonosa kávét iszik.</label></li>
          <li><input type="checkbox" id="task7"><label for="task7">Aki golfozik, szívesen iszik gyümölcslevet.</label></li>
          <li><input type="checkbox" id="task8"><label for="task8">A sárga ház tulajdonosa szabadidejében focizik.</label></li>
          <li><input type="checkbox" id="task9"><label for="task9">Az a személy, aki táncol, papagájt tart.</label></li>
          <li><input type="checkbox" id="task10"><label for="task10">A férfi, aki a középső házban lakik, tejet iszik.</label></li>
          <li><input type="checkbox" id="task11"><label for="task11">Aki társasjátékozni szokott, a mellett lakik az, aki macskát tart.</label></li>
          <li><input type="checkbox" id="task12"><label for="task12">A férfi, akinek lova van, a mellett lakik, aki focizik.</label></li>
          <li><input type="checkbox" id="task13"><label for="task13">A norvég a kék ház mellett lakik.</label></li>
          <li><input type="checkbox" id="task14"><label for="task14">Aki társasjátékozik, annak a szomszédja az, aki vizet iszik.</label></li>
          <li><input type="checkbox" id="task15"><label for="task15">A zöld ház, a fehér ház mellett balra van.</label></li>
        </ul>
      </div>
    </div>

    <div id="img-container" class="img-container">
      <div class="category-container" data-container="animal">
        <div class="image" data-img data-id="1"></div>
        <div class="image" data-img data-id="2"></div>
        <div class="image" data-img data-id="3"></div>
        <div class="image" data-img data-id="4"></div>
        <div class="image" data-img data-id="5"></div>
      </div>
      <div class="category-container" data-container="drink">
        <div class="image" data-img data-id="1"></div>
        <div class="image" data-img data-id="2"></div>
        <div class="image" data-img data-id="3"></div>
        <div class="image" data-img data-id="4"></div>
        <div class="image" data-img data-id="5"></div>
      </div>
      <div class="category-container" data-container="hobby">
        <div class="image" data-img data-id="1"></div>
        <div class="image" data-img data-id="2"></div>
        <div class="image" data-img data-id="3"></div>
        <div class="image" data-img data-id="4"></div>
        <div class="image" data-img data-id="5"></div>
      </div>
      <div class="category-container" data-container="nationality">
        <div class="image nationality" data-img data-id="1" data-nationality="Norvég"></div>
        <div class="image nationality" data-img data-id="2" data-nationality="Dán"></div>
        <div class="image nationality" data-img data-id="3" data-nationality="Brit"></div>
        <div class="image nationality" data-img data-id="4" data-nationality="Német"></div>
        <div class="image nationality" data-img data-id="5" data-nationality="Svéd"></div>
      </div>
    </div>
  
    <div id="house-container" class="house-container" data-house-container>
      <div class="house house3" data-order="3">
        <div class="house__roof"></div>
        <div class="house__body">
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
        </div>
      </div>
      <div class="house house4" data-order="4">
        <div class="house__roof"></div>
        <div class="house__body">
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
        </div>
      </div>
      <div class="house house1" data-order="1">
        <div class="house__roof"></div>
        <div class="house__body">
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
        </div>
      </div>
      <div class="house house5" data-order="5">
        <div class="house__roof"></div>
        <div class="house__body">
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
        </div>
      </div>
      <div class="house house2" data-order="2">
        <div class="house__roof"></div>
        <div class="house__body">
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
          <div class="house__cell" data-target-cell></div>
        </div>
      </div>
    </div>
  
    <div class="task__buttons">
      <button class="btn" data-restart>Újrakezdés</button>
      <button class="btn" data-finish>Befejezem</button>
    </div>

</div>
  <div class="message hidden" data-message>
    <h3 class="message__score" data-message-score>80/100 pontot értél el</h3>
    <p class="message__text" data-message-text>Tökéletes megoldás! Gratulálok!</p>
    <a href="../" class="btn">Vissza a Főoldalra</a>
  </div>
</body>
</html>
<?php
$title = "النتائج";
require_once "header.php";

?>

<html lang="en">

<head>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <div class="card one">
    <div class="header">
      <i class="arrow fas fa-chevron-left"></i>
      <h3 class="title">🏆 سابق 🏇</h3>
      <div></div>
    </div>
    <div class="profile">
      <?php
      $stuNames = $conn->query("SELECT id,`name`,`money` FROM user_psw WHERE `money` > 0 ORDER BY `money` DESC")->fetch_all(MYSQLI_ASSOC);
?>


      <div class="person second">
      <div class="num">2</div>
      <i class="fas fa-caret-up"></i>
      <img src="https://image.flaticon.com/icons/png/512/949/949666.png" alt="" class="photo">
      <p class="link"><?php echo $stuNames[1]['name'] ?></p>
      <p class="points"><?php echo $stuNames[1]['money'] ?></p>
      </div>

      <div class="person first">
        <img src="../crown.png" alt="" width="40px">
      <div class="num">1</div>
      <i class="fas fa-crown"></i>
      <img src="https://image.flaticon.com/icons/png/512/949/949666.png" alt="" class="photo">
      <p class="link"><?php echo $stuNames[0]['name'] ?></p>
      <p class="points"><?php echo $stuNames[0]['money'] ?></p>
      </div>

      <div class="person third">
      <div class="num">3</div>
      <i class="fas fa-caret-up"></i>
      <img src="https://image.flaticon.com/icons/png/512/949/949666.png" alt="" class="photo">
      <p class="link"><?php  if($stuNames[2]['name'] != null){echo $stuNames[2]['name'];} else {echo "";} ?></p>
      <p class="points"><?php echo ($stuNames[2]['money'] != null)? $stuNames[2]['money'] : ""; ?></p>
      </div></div>
      <div class="rest">
        <?php
      $j = 4;
      for ($i = 3; $i < count($stuNames);) :
      ?>
        <div class="others flex">
          <div class="rank">
            <i class="fas fa-caret-up"></i>
            <p class="num"><?php echo $j ?></p>
          </div>
          <div class="info flex">
            <img src="" alt="" class="p_img">
            <p class="link"><?php echo $stuNames[$i]['name']; ?></p>
            <p class="points"><?php echo $stuNames[$i]['money']; ?></p>
          </div>
        </div>
      <?php

        if ($i == count($stuNames) - 1) {
          break;
        } elseif ($stuNames[$i]['money'] != $stuNames[++$i]['money']) {
          $j++;
        }
      endfor;
      ?>
    </div>



  </div>


</body>

</html>
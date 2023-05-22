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
    <h3 class="title">Leaderboard</h3>
    <div></div>
  </div>
  <div class="sort">
    <div class="day">Today</div>
    <div class="day active">Week</div>
    <div class="day">Month</div>
  </div>
  <div class="profile">
    <div class="person second">
      <div class="num">2</div>
      <i class="fas fa-caret-up"></i>
      <img src="https://image.flaticon.com/icons/png/512/949/949666.png" alt="" class="photo">
      <p class="link">@dorisklien</p>
      <p class="points">8023</p>
    </div>
    <div class="person first">
      <div class="num">1</div>
      <i class="fas fa-crown"></i>
      <img src="https://image.flaticon.com/icons/png/512/4086/4086600.png" alt="" class="photo main">
      <p class="link">@sher234</p>
      <p class="points">8122</p>
    </div>
    <div class="person third">
      <div class="num">3</div>
      <i class="fas fa-caret-up"></i>
      <img src="https://image.flaticon.com/icons/png/512/4333/4333609.png" alt="" class="photo">
      <p class="link">@lord_0980</p>
      <p class="points">7884</p>
    </div>
  </div>
  <div class="rest">
    <div class="others flex">
      <div class="rank">
        <i class="fas fa-caret-up"></i>
        <p class="num">4</p>
      </div>
      <div class="info flex">
        <img src="https://image.flaticon.com/icons/png/512/2922/2922510.png" alt="" class="p_img">
        <p class="link">@adam56</p>
        <p class="points">7861</p>
      </div>
    </div>
  </div>
</div>
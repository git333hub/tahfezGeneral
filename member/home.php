<?php
$title = "الصفحة الرئيسة";
require_once "header.php";
echo "<h1>" . "أهلاً " . $_SESSION['name'] . "</h1>" . "</br>";
echo "<h2>" ."الرصيد: " . $_SESSION['money'] . "</h2>" . "</br>";
echo "<h2>" ."نقاط الحياة: " . $_SESSION['lifeP'] . "</h2>" . "</br>";
echo "<h2>" ."المجموعة: " . $_SESSION['group'] . "</h2>" . "</br>";
?>

<br>
<br>

<?php
require_once "footer.php";
?>
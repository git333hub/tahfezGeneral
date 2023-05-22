<?php 
$title = "صفحة العدة";
require_once("header.php");
echo "الرصيد: " . $_SESSION['money']."</br>"; 
echo "نقاط الحياة: " . $_SESSION['lifeP']; 
?>

    <?php     
        $controlAdmin = $conn->query("SELECT * FROM admincontrols WHERE `name` = 'buyPointsPrice' AND `adminid` = " . $_SESSION['adminid'])->fetch_array(MYSQLI_ASSOC);
        $weapons = $conn->query("SELECT w1,w2,w3,d1 FROM user_psw WHERE `id` = '" . $_SESSION['id'] . "' AND `adminid` = " . $_SESSION['adminid']);
        while ($weapon = mysqli_fetch_array($weapons)):
    ?>

    <fieldset>
        <legend>تسديد1</legend>
        <?php  echo ($weapon['w1'] == NULL) ? '<a href="store.php?p=w1">شراء</a>' :  $weapon['w1']; // show the weapon name, if not allow him to buy ?>
    </fieldset>

    <fieldset>
        <legend>تسديد2</legend>
        <?php echo ($weapon['w2'] == NULL) ? '<a href="store.php?p=w2">شراء</a>' :  $weapon['w2']; // p=w2 to put the weapon in the box where he clicked  ?>
    </fieldset>

    <fieldset>
        <legend>تسديد3</legend>
        <?php   echo ($weapon['w3'] == NULL) ? '<a href="store.php?p=w3">شراء</a>' :  $weapon['w3'];  ?>
    </fieldset>

    <fieldset>
        <legend>صـــد</legend>
        <?php   echo ($weapon['d1'] == NULL) ? '<a href="store.php?p=d1">شراء</a>' :  $weapon['d1'];  ?>
    </fieldset>
<?php endwhile;?>
<br>
<h1>شراء نقاط حياة</h1>
<p>10 نقاط = <?php echo $controlAdmin['status']?>$</p>
<form method="POST" >
    <label>أدخل عدد النقاط</label>
    <input type="text" name="buyPoints">
    <input type="submit" name="submit" value="شراء نقاط حياة">
</form>
<?php 
if(isset($_POST['submit'])){
    $price = ($_POST['buyPoints']) * ($controlAdmin['status'] / 10); // if the user enter 10, the price will be 50$.    20 = 100 .... could be change
    if($_POST['buyPoints'] % 10 !== 0){
        $_SESSION["message"] = "يجب ان تكون عدد النقاط من مضاعفات 10";
        echo "<script>window.location.href='info.php'</script>";
        die();
    }elseif($_SESSION['money'] < $price){
        $_SESSION["message"] = "لا تمتلك رصيد كافي!";
        echo "<script>window.location.href='info.php'</script>";
        die();
    }else{
    $conn->query("UPDATE user_psw SET `money` = " .($_SESSION['money'] - $price). ", `lifeP` = ".($_SESSION['lifeP'] + $_POST['buyPoints'])." WHERE `id` = " . $_SESSION['id'] . " AND `adminid` = " . $_SESSION['adminid']);
    updateGroupPoints($conn);
    $_SESSION["message"] = "تم شراء النقاط";
    echo "<script>window.location.href='info.php'</script>";
    }
}
require_once("footer.php");
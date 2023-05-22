<?php 
$title = "الإعدادات" ;
require_once "header.php";
$controls = $conn->query("SELECT * FROM admincontrols WHERE adminid =" .$_SESSION['id'])->fetch_all(MYSQLI_ASSOC);

// $controls[0]  attack page
// $controls[1]  buyPointsPrice
// $controls[2]  packagePrice
$status = $attackPage = $controls[0]["status"];
$buyPointsPrice = $controls[1]["status"];
$packagePrice = $controls[2]["status"];



?>

<form method="post">
    <label for="attack">صفحة التسديد:</label>
    <input type="submit" name="open" value="فتح">
    <input type="submit" name="close" value="اغلاق" >
</form>
<?php 
    if(isset($_POST['open'])){
        $status = 1;
        $conn->query('UPDATE `admincontrols` SET `status` = 1 WHERE `name` = "attackPage" AND `adminid` = ' .$_SESSION['id']); 
    }elseif(isset($_POST['close'])){
        $status = 0;
        $conn->query('UPDATE `admincontrols` SET `status` = 0 WHERE `name` = "attackPage" AND `adminid` = ' .$_SESSION['id'] );
    }
    if($status == 1){
        echo("مفتوح");
    }elseif($status == 0){
        echo("مغلق");
    }
    ?>

</br>
<hr>
</br>
<form method="post">
    <label for="">زيادة الأسعار بمقدار</label>
    <input type="text" name="increasePrice">
    <input type="submit" name="incrsPriceButton" value="زيادة السعر">
</form>
</br>
<hr>
</br>

<form method="POST">
    <label for="">سعر نقاط الحياة:</label>
    <input type="text" name="lifePprice" value="<?php echo $buyPointsPrice ?>">
    <br>
    <label for="">سعر البكج:</label>
    <input type="text" name="packagePrice" value="<?php echo $packagePrice?>">
    <br>
    <input type="submit" name="updatePrices" value="حفظ الاسعار" >
</form>
<br>
<hr>
</br>

<form method="POST" onsubmit="return confirm('هل حقا تريد تصفير النقاط والرصيد؟')">
    <label for="attack">اعادة تهيئة النقاط والرصيد :</label>
    <input type="submit" name="reset" value="اعادة التهيئة" >
</form>
<br>
<hr>
</br>



<form method="POST" onsubmit="return confirm('   هل حقا تريد اعادة تهئية النظام؟ سيؤدي ذلك الى حذف جميع البيانات بما في ذلك الأسماء... والبدء من جديد ولا يمكن استعادة البيانات')">
    <label for="attack">اعادة تهيئة جميع النظام ( سيتم حذف الأسماء والبدء من جديد ) :</label>
    <input type="submit" name="deleteEverything" value="اعادة التهيئة" >
</form>

<?php
if(isset($_POST['updatePrices'])){
    $conn->query('UPDATE `admincontrols` SET `status` = '.$_POST['lifePprice'].' WHERE `id` = ' . $controls[1]["id"] );
    $conn->query('UPDATE `admincontrols` SET `status` = '.$_POST['packagePrice'].' WHERE `id` = ' . $controls[2]["id"] );
    $_SESSION['message'] = ("تم تغيير الاسعار بنجاح");
    echo "<script>window.location.href='controls.php'</script>";
}
if(isset($_POST['reset'])){
    $conn->query('DELETE FROM records WHERE `adminid` = '.$_SESSION['id']);
    $conn->query('UPDATE user_psw SET `money` = 0 , `lifeP` = 1000 , `tMoney` = 0 , `banned` = 0 , `w1` = "", `w2` = "", `w3` = "", `d1` = "", `powerd1` = 0 WHERE `adminid` = '.$_SESSION['id']);
    $conn->query('UPDATE groups SET `points` = 1000 WHERE `adminid` = '.$_SESSION['id']);
    $_SESSION['message'] = ("تم اعادة تصفير البيانات بنجاح");
    echo "<script>window.location.href='controls.php'</script>";

}
if(isset($_POST['deleteEverything'])){
    $conn->multi_query(
    'DELETE FROM `groups` WHERE `adminid` = '.$_SESSION['id'].";".
    'DELETE FROM `records` WHERE `adminid` = '.$_SESSION['id'].";".
    'DELETE FROM `store` WHERE `adminid` = '.$_SESSION['id'].";".
    'DELETE FROM `teachers` WHERE `adminid` = '.$_SESSION['id'].";".
    'DELETE FROM `user_psw` WHERE `adminid` = '.$_SESSION['id'].";"

);

    $_SESSION['message'] = ("تم اعادة تهيئة النظام بنجاح");
    echo "<script>window.location.href='controls.php'</script>";

}

if (isset($_POST['incrsPriceButton'])) {
    $prices = $conn->query("SELECT id, price FROM store WHERE adminid = " . $_SESSION['id']);
    $pointsPrice = $conn->query("SELECT * FROM admincontrols WHERE `name` ='buyPointsPrice' AND adminid = " . $_SESSION['id'])->fetch_array(MYSQLI_ASSOC);
    $packagePrice = $conn->query("SELECT * FROM admincontrols WHERE `name` ='packagePrice' AND adminid = " . $_SESSION['id'])->fetch_array(MYSQLI_ASSOC);
    while ($price = mysqli_fetch_array($prices)) {
        $conn->query('UPDATE store SET price = ' . ($_POST["increasePrice"] + $price["price"]) . " WHERE `id` =" . $price['id']);
    }
    $conn->query('UPDATE admincontrols SET `status` = ' . ($_POST["increasePrice"] + $pointsPrice["status"]) . " WHERE `name` = 'buyPointsPrice' AND adminid = " . $_SESSION['id']);
    $conn->query('UPDATE admincontrols SET `status` = ' . ($_POST["increasePrice"] + $packagePrice["status"]) . " WHERE `name` = 'packagePrice' AND adminid = " . $_SESSION['id']);
    echo "<script>window.location.href='controls.php'</script>"; // refresh the page
}



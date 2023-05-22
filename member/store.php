<?php
$title = "الهجوم";
require_once "header.php";
// echo $_SESSION['name'] . "</br>";
echo "الرصيد الحالي:" . $_SESSION['money'] . "</br>";

$controls = $conn->query("SELECT `status` FROM admincontrols WHERE `name` = 'packagePrice' AND adminid = " . $_SESSION["adminid"])->fetch_array(MYSQLI_ASSOC);



    $ws = $conn->query("SELECT id,product from store WHERE kind = 'هجوم' AND adminid = " . $_SESSION["adminid"]);
    $ds = $conn->query("SELECT id,product from store WHERE kind = 'دفاع' AND adminid = " . $_SESSION["adminid"]);
    if ($_GET['p'] == 'w1' || $_GET['p'] == 'w2' || $_GET['p'] == 'w3') {
        $kind = $ws;
    }elseif ($_GET['p'] == 'd1') {
        $kind = $ds;
    }

    if (isset($_GET['p']) && isset($_POST['openPackge'])) { // open Package
        $packageObj = $kind->fetch_all(MYSQLI_ASSOC)[rand(0,mysqli_num_rows($kind)-1)]; // open package randomly
        $package = $packageObj["product"];
        $packageId = $packageObj["id"];
        $adminid = $_SESSION['adminid'];
        
        
        $time = date("Y-m-d H:i:s", strtotime("+3 hours"));
        // $mixes = $conn->query("SELECT s.qty, s.price, s.product,s.id, s.power, u.money, u.name,u.id FROM store AS s INNER JOIN user_psw AS u ON u.name ='" . $_SESSION['name'] . "' AND s.product = '" . $package . "' AND adminid = " . $_SESSION["adminid"]);
        $mixes = $conn->query("SELECT * FROM store AS s INNER JOIN user_psw AS u ON u.name ='" . $_SESSION['name'] . "' AND s.id = '" . $packageId . "' AND u.adminid = " . $_SESSION["adminid"] . " AND s.adminid = " . $_SESSION["adminid"]);
        while($mix = mysqli_fetch_array($mixes)){
            if($mix['money'] < $controls['status']){
                $conn->query("INSERT INTO records VALUES ('حاول ".$_SESSION['name'] ." شراء باكج ".$package." لكنه لا يملك رصيد كافي','$time',".$_SESSION["adminid"].",0)");
                die("لا تمتلك رصيد كافي");
            } 
            if($mix['qty'] <= 0){die("نفذت الكمية");} 
            if($_GET["p"] == 'd1'){ //buying defend
                $conn->query("UPDATE `user_psw` SET `powerd1` = '" . $mix["power"] . "' WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // add usingTimes & power to weapons table
            }
            $conn->query("UPDATE `store` SET `qty` = " . ($mix['qty']-1) . " WHERE `id` = '" . $packageId . "' AND adminid = " . $_SESSION["adminid"]); // product quantity--
            $conn->query("UPDATE `user_psw` SET `" . $_GET["p"] . "` = '" . $package . "' WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // add weapon attak to weapons table
            $conn->query("UPDATE `user_psw` SET `money` = " . ($mix['money']-=$controls['status']) . " WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // reduce the money after buying
            $_SESSION['money'] = $mix['money'];
            $conn->query("INSERT INTO records VALUES ('اشترى ".$_SESSION['name'] ." باكج وحصل على ".$package."','$time',$adminid,0)");

    }
    echo "<script>window.location.href='info.php'</script>";
}
    ?>

<form method="POST" onsubmit="return confirm('هل حقا تريد فتح باكج?')">
    <input type="submit" name="openPackge" value="افتح باكج بسعر <?php echo $controls['status'] ?>">
</form>

<form method="POST">
    <br>
    <br>
    <select name="productid">
        <option value="" disabled selected>اختر نوع التسديدة</option>
        <?php
        while ($row = mysqli_fetch_array($kind)) {
            echo "<option value=" . $row["id"] . ">" . $row["product"] . "</option>";
        }
        ?>
    </select>
    <input type="submit" name="submit" value="شراء">

    <br>
    <br>

</form>
    <?php
if ($_GET['p'] == 'w1' || $_GET['p'] == 'w2' || $_GET['p'] == 'w3') {
    // echo "الهجوم:";
    $i = 1;
    $stores = $conn->query("SELECT * FROM store WHERE kind = 'هجوم' AND adminid = " . $_SESSION["adminid"]);
    ?>
    <div style='overflow-x:auto; max-width: 1000px;'>
    <table>
    <tr><td style="text-align:center" colspan= "5">التسديد</td></tr>
    <tr> <th>الرقم</th> <th>الاسم</th> <th>السعر</th> <th>القوة</th> <th>الوفرة</th></tr>
    <?php
    while($store = mysqli_fetch_array($stores)){
?>
        <tr>
        <td><?php echo $i?></td>
        <td><?php echo $store['product']?></td>
        <td><?php echo $store['price']?></td>
        <td><?php echo $store['power']?></td>
        <td><?php echo $store['qty']?></td>
        </tr>
    <?php
        $i++;
    }
    echo "</table></br></div>";
} elseif ($_GET['p'] == 'd1') {
    // echo "الدفاع:";
    $i = 1;
    $stores = $conn->query("SELECT * FROM store WHERE kind = 'دفاع' AND adminid = " . $_SESSION["adminid"]);
    ?>
    <div style='overflow-x:auto; max-width: 1000px;'>
    <table>
    <tr><td style="text-align:center" colspan= "5">التسديد</td></tr>
    <tr> <th>الرقم</th> <th>الاسم</th> <th>السعر</th> <th>القوة</th> <th>الوفرة</th></tr>
    <?php
    while($store = mysqli_fetch_array($stores)){
        ?>
        <tr>
        <td><?php echo $i?></td>
        <td><?php echo $store['product']?></td>
        <td><?php echo $store['price']?></td>
        <td><?php echo $store['power']?></td>
        <td><?php echo $store['qty']?></td>
        </tr>
    <?php
        $i++;
}
echo "</table></br></div>";
}

if (isset($_GET['p']) && isset($_POST['submit'])) { // $_GET['p'] to get which box is selected, w1,w2,w3, or d1 for defend
    $adminid = $_SESSION['adminid'];
    $time = date("Y-m-d H:i:s", strtotime("+3 hours"));
    $mixes = $conn->query("SELECT * FROM store AS s INNER JOIN user_psw AS u ON u.name ='" . $_SESSION['name'] . "' AND s.id = " . $_POST['productid'] . " AND u.adminid = " . $_SESSION["adminid"] . " AND s.adminid = " . $_SESSION["adminid"]);
    $productName = $conn->query("SELECT product FROM store WHERE id = " .$_POST['productid']. " AND adminid = " . $_SESSION["adminid"] . " LIMIT 1")->fetch_array(MYSQLI_ASSOC);
    // $_SESSION['message'] = $conn->error;
    // $_SESSION['message'] = (print_r($mixes[0]));
    while($mix = mysqli_fetch_array($mixes)){
            if($mix['money'] < $mix['price']){
                $conn->query("INSERT INTO records VALUES ('حاول ".$_SESSION['name'] ." شراء سلاح ".$productName['product']." لكنه لا يملك رصيد كافي','$time',$adminid,0)");
                die("لا تمتلك رصيد كافي");
            } 
            if($mix['qty'] <= 0){die("نفذت الكمية");} 
            if($_GET["p"] == 'd1'){ //buying defend
                $conn->query("UPDATE `user_psw` SET `powerd1` = '" . $mix["power"] . "' WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // add usingTimes & power to weapons table
            }
            $conn->query("UPDATE `store` SET `qty` = " . ($mix['qty']-1) . " WHERE `id` = " . $_POST['productid'] . " AND adminid = " . $_SESSION["adminid"]); // product quantity--
            $conn->query("UPDATE `user_psw` SET `" . $_GET["p"] . "` = '" . $productName['product'] . "' WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // add weapon attak to weapons table
            $conn->query("UPDATE `user_psw` SET `money` = " . ($mix['money']-=$mix['price']) . " WHERE `id` = '" . $mix["id"] . "' AND adminid = " . $_SESSION["adminid"]); // reduce the money after buying
            $_SESSION['money'] = $mix['money'];
            $conn->query("INSERT INTO records VALUES ('اشترى ".$_SESSION['name'] ." تسديدة ".$productName['product']."','$time',$adminid,0)");

    }
    // header("Location: info.php");
    echo "<script>window.location.href='info.php'</script>";
}

require_once ("footer.php");
    ?>



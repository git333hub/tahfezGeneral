<?php
$title = "صفحة الهجوم";
require_once "header.php";
$controls = $conn->query("SELECT * FROM admincontrols WHERE `adminid` = " . $_SESSION['adminid'])->fetch_all(MYSQLI_ASSOC);
$attack = $controls[0]["status"];
if(!$attack){
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("لا تستطيع الوصول الى هذه الصفحة بهذه الطريقة");
    }
}
$adminid = $_SESSION['adminid'];
?>
    
<form method="POST">
    <!--بدء اختيار الطالب الذي تريد الهجوم عليه -->
    <div class="container">


    <select name="victam">
        <option value="" disabled selected>اختر طالب</option>
        <?php
        $students = $conn->query("SELECT * from `user_psw` WHERE `adminid` = " . $_SESSION['adminid'] . " AND `lifeP` > 0 ORDER BY RAND()");
        while ($student = mysqli_fetch_array($students)) {
            if ($_SESSION['group'] !== $student['group']) { // skip the student whith in the same group
                $victamName = $student['name'];
                $victamId = $student['id'];
                echo "<option value='$victamId'>$victamName (" . $student['group'] . ")</option>";
            }
        }
        ?>
    </select>

    <br>
    <br>

    <select name="weapon">
        <option value="" disabled selected>اختر نوع التسديدة</option>
        <?php
        $weapons = $conn->query("SELECT w1,w2,w3 from `user_psw` WHERE `id` = " . $_SESSION['id'] . " AND `adminid` = " . $_SESSION['adminid']); // عرض الاسلحة التي يمتلكها المهاجم
        while ($weapon = mysqli_fetch_array($weapons)) {
            $w1 = $weapon['w1']; // w1 first box for attaking
            $w2 = $weapon['w2']; // second
            $w3 = $weapon['w3'];// third
            if (!empty($w1)) { // echo only existing weapons
                echo "<option value='1'>$w1</option>";
            }
            if (!empty($w2)) {
                echo "<option value='2'>$w2</option>";
            }
            if (!empty($w3)) {
                echo "<option value='3'>$w3</option>";
            }
        }
        ?>
    </select>
        <!--نهاية اختيار السلاح  -->
    <br>
    <br>
    <input type="submit" name="submit" value="تسديد">
    </div>
</form>


<?php
if (isset($_POST['submit']) && isset($_POST['victam']) && isset($_POST['weapon'])) {
    //prevent attack if the admin close this feature
    // $controls = $conn->query("SELECT * FROM admincontrols WHERE id = 1")->fetch_array(MYSQLI_ASSOC);
    // $attack = $controls["status"];
    $victamName = $conn->query("SELECT `name` FROM user_psw WHERE id = " .$_POST['victam']. " AND adminid = " . $_SESSION["adminid"] . " LIMIT 1")->fetch_array(MYSQLI_ASSOC);
    $adminid = $_SESSION['adminid'];
    if(!$attack){
        die("لقد اغلق المشرف صفحة الهجوم، يرجى المحاولة في الموعد القادم.");
    }
    
    if($_POST['weapon'] === '1'){ // to select which box has been selected 1 or 2 or 3
        $defend = $conn->query("SELECT s.product,s.power,u.name,u.lifeP,u.group,u.w1,u.w2,u.w3,u.d1,u.powerd1 FROM user_psw as u INNER JOIN store as s on s.product = '$w1' AND s.adminid = ".$_SESSION['adminid']." AND u.id = ".$_POST['victam']." AND u.adminid = ".$_SESSION['adminid']); // 
    }else if($_POST['weapon'] === "2"){
        $defend = $conn->query("SELECT s.product,s.power,u.name,u.lifeP,u.group,u.w1,u.w2,u.w3,u.d1,u.powerd1 FROM user_psw as u INNER JOIN store as s on s.product = '$w2' AND s.adminid = ".$_SESSION['adminid']." AND u.id = ".$_POST['victam']." AND u.adminid = ".$_SESSION['adminid']); // 
    }else if($_POST['weapon'] === "3"){
        $defend = $conn->query("SELECT s.product,s.power,u.name,u.lifeP,u.group,u.w1,u.w2,u.w3,u.d1,u.powerd1 FROM user_psw as u INNER JOIN store as s on s.product = '$w3' AND s.adminid = ".$_SESSION['adminid']." AND u.id = ".$_POST['victam']." AND u.adminid = ".$_SESSION['adminid']); // 
    }
    // if($_POST['weapon'] === '1'){ // to select which box has been selected 1 or 2 or 3
        // $defend = $conn->query("SELECT s.product, s.power, u.name, u.lifeP, u.group, w.d1,w.usingTimesd1, w.powerd1 FROM weapons AS w INNER JOIN store AS s ON s.product = '$w1' AND w.name = '" . $_POST['victam'] . "' INNER JOIN user_psw AS u on u.name = '" . $_POST['victam'] . "'"); // 
    // }else if($_POST['weapon'] === "2"){
    //     $defend = $conn->query("SELECT s.product, s.power, u.name, u.lifeP, u.group, w.d1,w.usingTimesd1, w.powerd1 FROM weapons AS w INNER JOIN store AS s ON s.product = '$w2' AND w.name = '" . $_POST['victam'] . "' INNER JOIN user_psw AS u on u.name = '" . $_POST['victam'] . "'"); // 
    // }else if($_POST['weapon'] === "3"){
    //     $defend = $conn->query("SELECT s.product, s.power, u.name, u.lifeP, u.group, w.d1,w.usingTimesd1, w.powerd1 FROM weapons AS w INNER JOIN store AS s ON s.product = '$w3' AND w.name = '" . $_POST['victam'] . "' INNER JOIN user_psw AS u on u.name = '" . $_POST['victam'] . "'"); // 
    // }

    while($d = mysqli_fetch_array($defend)){
        // $timestamp = strtotime(date("Y/m/d h:i:sa")) + 60*60*2; 
        // $time = date('Y/m/d h:i:sa', $timestamp);
        $time = date("Y-m-d H:i:s", strtotime("+3 hours"));
             // the victam has defend
            if(($d['power']-$d['powerd1']) >= 0){
                $conn->query("UPDATE user_psw SET `lifeP` = " . ($d['lifeP']-($d['power']-$d['powerd1'])) . " WHERE `id` = '" . $_POST['victam'] . "' AND adminid = " . $_SESSION["adminid"]); // substract restitance power and reduce usingTimes--
                if($d['powerd1'] > 0){
                    $conn->query("INSERT INTO records VALUES (' هجم ".$_SESSION['name'] ." بـ ".($d['power'])." على ".$victamName['name']." ودافع بـ ".($d['powerd1'])."❤','$time',$adminid,1)"); // records
                }else{
                    $conn->query("INSERT INTO records VALUES (' هجم ".$_SESSION['name'] ." بـ ".($d['power'])." على ".$victamName['name']."❤','$time',$adminid,1)"); // records
                }
                // $conn->query("INSERT INTO records VALUES (' هجم ".$_SESSION['name'] ." بـ ".($d['power'])." على ".$_POST['victam']." ودافع بـ ".($d['powerd1'])."💔 وأصبحت نقاطه ".($d['lifeP']-($d['power']-$d['powerd1']))."❤','$time')"); // records
                if(($d['lifeP']-($d['power']-$d['powerd1'])) < 0){
                    $conn->query("UPDATE user_psw SET `lifeP` = 0 WHERE `id` = '" . $_POST['victam'] . "'"); // no points less than 0
                }
            }elseif (($d['powerd1']-$d['power']) > 0) {
                $conn->query("INSERT INTO records VALUES ('دافع ".$victamName['name'] ." بـ ".($d['powerd1'])." من ".$_SESSION['name']." بعد أن هجم بـ ".($d['power'])."','$time',$adminid,1)"); // records
                // $conn->query("UPDATE user_psw SET `lifeP` = " . ($d['lifeP']-$d['power']) . " WHERE `name` = '" . $_POST['victam'] . "'"); // substract restitance power and reduce usingTimes--
                $attakerLifePoints = $conn->query("SELECT lifeP FROM `user_psw` WHERE `id` = '" . $_SESSION['id'] . "'")->fetch_array(MYSQLI_ASSOC); // substract restitance power and reduce usingTimes--
                $conn->query("UPDATE user_psw SET `lifeP` = " . ($attakerLifePoints['lifeP']-($d['powerd1']-$d['power'])) . " WHERE `id` = " . $_SESSION['id'] ." AND adminid = " . $_SESSION["adminid"]); // substract restitance power and reduce usingTimes--
                if(($attakerLifePoints['lifeP']-($d['powerd1']-$d['power'])) < 0){
                    $conn->query("UPDATE user_psw SET `lifeP` = 0 WHERE `id` = " . $_SESSION['id'] ); // substract restitance power and reduce usingTimes--
                }
            }
            // if(($d['powerd1']-$d['power']) <= 0){// defend dystroyed
            //     $conn->query("UPDATE user_psw SET d1 = NULL , `powerd1` = 0 WHERE `id` = '" . $_POST['victam'] . "'"); // reset defend   
            // }

            $conn->query("UPDATE user_psw SET `d1` = NULL , `powerd1` = 0 WHERE `id` = " . $_POST['victam']); // substract restitance power and reduce usingTimes--

            $conn->query("UPDATE user_psw SET `w" . $_POST['weapon'] . "` = NULL WHERE `id` = " . $_SESSION['id'] ); // delete attack weapon

            // for records page to calculate the current time
        }
        updateGroupPoints($conn);
        $_SESSION['message'] = "تم التسديد بنجاح!";
        echo "<script>window.location.href='attack.php'</script>";
    }

?>

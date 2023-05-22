<?php
$title = "صفحة المساندة";
require_once "header.php";
echo "الرصيد الحالي:" . $_SESSION['money'] . "</br>";
$adminid = $_SESSION['adminid'];
?>
    
<form method="POST">
    <!--بدء اختيار الطالب الذي تريد اعطاءه النقاط عليه -->
    <div class="container">


    <select name="friendId">
        <option value="" disabled selected>اختر طالب</option>
        <?php
        $students = $conn->query("SELECT * from `user_psw` WHERE `group` = '".$_SESSION['group']."' AND `adminid` = " . $_SESSION['adminid']);
        while ($student = mysqli_fetch_array($students)) {
                $friendId = $student['id']; 
                $friendName = $student['name']; 
                if($friendName == $_SESSION['name']){
                    continue;//skip the student him self
                }
                echo "<option value='$friendId'>$friendName</option>";
        }
        ?>
    </select>

    <br>
    <br>
        <label>ادخل الرصيد الذي تريد تحويله:</label>
        <input type="text" name="assestPoints" placeholder="مثال: 10">
    <br>
    <br>
    <input type="submit" name="submit" value="مساندة">
    </div>
</form>


<?php
if (isset($_POST['submit'])) {
    if(!isset($_POST['friendId']) || !isset($_POST['assestPoints'])){
            $_SESSION['message'] = "يرجى اكمال جميع البيانات!";
            echo "<script>window.location.href='assest.php'</script>";
            die();
    }
    $time = date("Y-m-d H:i:s", strtotime("+3 hours"));
        if($_SESSION['money'] < $_POST["assestPoints"]){
            die("عذراً، لا تمتلك هذا الرصيد.");
        }
        $conn->query("UPDATE user_psw SET `money` = " .($_SESSION['money'] - $_POST["assestPoints"]). " WHERE `id` = " . $_SESSION['id'] . " AND `adminid` = " . $_SESSION['adminid']);
        $friend = $conn->query("SELECT `money`,`name` FROM user_psw  WHERE `id` = " . $_POST['friendId'])->fetch_array(MYSQLI_ASSOC);
        $conn->query("UPDATE user_psw SET `money` = " .($friend['money'] + $_POST["assestPoints"]). " WHERE `id` = " . $_POST['friendId'] . " AND `adminid` = " . $_SESSION['adminid']);
        $conn->query("INSERT INTO records VALUES ('تم تحويل ".$_POST["assestPoints"] ." نقطة من ".$_SESSION['name']." الى ".$friend['name']."','$time',$adminid,2)"); // records
        $_SESSION['message'] = "تم تحويل الرصيد بنجاح!";
        echo "<script>window.location.href='assest.php'</script>";
    }

?>

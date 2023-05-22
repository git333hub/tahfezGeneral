<?php
$title = "اضافة طالب جديد";
require_once "header.php";
$DEFUALT_MONEY = 0;
$DEFUALT_POINTS = 1000;

?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

    <label>اسم المستخدم</label>
    <input type="text" name="userId" value="<?php echo uniqueStudenId($conn); ?>"></br>
    <label>كلمة المرور</label>
    <input type="text" name="userP" value="<?php echo uniqueStudenId($conn); ?>"></br>
    <label>اسم الطالب:</label>
    <input type="text" name="name" autofocus="autofocus"> </br>
    <label>المجموعة</label>

    <select name="ops">
        <option value="" disabled selected>اختر مجموعة</option>
        <?php
        $groupsNames = $conn->query("SELECT * from groups WHERE `adminid` =" . $_SESSION['id']);
        while (@$row = mysqli_fetch_array($groupsNames)) {
            $id = $row['id'];
            $nameG = $row['groupNames'];
            echo "<option value='$nameG'>$nameG</option>";
        }
        ?>
    </select>
    <label>المعلم</label>
    <select name="teachers">
        <option value="" disabled selected>اختر معلم</option>
        <?php

        $groupsNames = $conn->query("SELECT * from teachers WHERE `adminid` =" . $_SESSION['id']);
        while ($row = mysqli_fetch_array($groupsNames)) {
            $id = $row['id'];
            $teacher = $row['name'];
            echo "<option value='$teacher'>$teacher</option>";
        }
        ?>
    </select>
    <input type="submit" name="submit" value="إضافة الطالب"></br>
</form>

<?php
if(isset($_POST['submit'])){
    if (isset($_POST['name']) && isset($_POST['userId']) && isset($_POST['userP']) && isset($_POST['ops']) && isset($_POST['teachers'])) {
        $name = $_POST['name'];
        $userId = $_POST['userId'];
        $userP = $_POST['userP'];
        $group = $_POST['ops'];
        $teacher = $_POST['teachers'];
        $money = $DEFUALT_MONEY;
        $lifeP = $DEFUALT_POINTS;
        $tMoney = 0;
        $adminId = $_SESSION['id'];

        $rt = $conn->query("INSERT INTO `user_psw` VALUES (NULL,'$name','$money','$lifeP','$userId','$userP','$group','$teacher','$tMoney',0,'','','','',0,$adminId)"); // add the student in user_psw table

        $_SESSION['message'] = "تم اضافة " . $name . " في مجموعة " . $group . " بنجاح.";
        echo "<script>window.location.href='addStudent.php'</script>";
        
    } else {
        echo "يجب ملئ جميع الحقول";
    }
}
// this function is to generate unique students IDs, which is not in the database
function uniqueStudenId($conn)
{
    while (true) {
        $rand = rand(100000, 999999);
        $unique = $conn->query("SELECT `user` FROM user_psw WHERE `user` = '$rand'");
        if ($unique->num_rows > 0) {
            continue;
        } else {
            return $rand;
        }
    }
}

?>

<?php require_once "footer.php"; ?>
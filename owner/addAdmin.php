<?php 
$title = "اضافة مشرف جديد" ;
require_once "header.php";

$privousAdmin =  $conn->query("SELECT * FROM `admin` ORDER BY id DESC LIMIT 1")->fetch_array(MYSQLI_ASSOC);
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <label>رقم المشرف :</label>
    <?php echo isset($privousAdmin['id'])?$privousAdmin['id']+1 : 1 ;?>
    <br>

    <label>اسم المحضن:</label>
    <input autofocus type="text" name="name">
    <br>
    
    <label>اسم المستخدم:</label>
    <input type="text" name="user">
    <br>

    <label>الرقم السري:</label>
    <input type="text" name="password">
    <br>

    <label>تاريخ الانضمام:</label>
    <input type="text" name="joindate" value="<?php echo date("Y-m-d");?>">
    <br>

    <label>تاريخ الانتهاء</label>
    <input type="text" name="expiredate" value="<?php echo date('Y-m-d', strtotime("+1 year")); ?>">
    <br>


    <input type="submit" name="sumbit" value="اضافة مشرف">
</form>

<?php
    if(isset($_POST["sumbit"])){
        $id = $privousAdmin['id']+1;
        $name = $_POST['name'];
        $user = $_POST['user'];
        $password = $_POST['password'];
        $joindate = ($_POST['joindate']);
        $expiredate = ($_POST['expiredate']);

        $conn->query("INSERT INTO `admin` VALUES ($id,'$name','$user','$password','$joindate','$expiredate')"); 
        $conn->query("INSERT INTO `admincontrols` VALUES (NULL,'attackPage',0,$id)"); 
        $conn->query("INSERT INTO `admincontrols` VALUES (NULL,'buyPointsPrice',100,$id)"); 
        $conn->query("INSERT INTO `admincontrols` VALUES (NULL,'packagePrice',300,$id)"); 
        $_SESSION['message'] = "تم اضافة المشرف " . $name . " بنجاح.";
        echo "<script>window.location.href='home.php'</script>";
    }
?>

<?php require_once "footer.php";?>
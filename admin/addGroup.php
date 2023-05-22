<?php 
$title = "اضافة مجموعة جديدة" ;
require_once "header.php";
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <input type="text" name="group">
    <input type="submit" name="sumbit" value="اضافة مجموعة">
</form>

<?php
    if(isset($_POST["sumbit"])){
        $groupName = $_POST['group'];
        $adminid =  $_SESSION['id'];
        $conn->query("INSERT INTO groups VALUES (NULL,'$groupName',0,$adminid)"); // (id,)
        $_SESSION['message'] = "تم اضافة مجموعة " . $groupName . " بنجاح.";
        echo "<script>window.location.href='addGroup.php'</script>";
    }
?>

<?php require_once "footer.php";?>
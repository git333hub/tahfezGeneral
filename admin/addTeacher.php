<?php 
$title = "اضافة معلم جديد" ;
require_once "header.php";
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <input type="text" name="group">
    <input type="submit" name="sumbit" value="اضافة معلم">
</form>

<?php
    if(isset($_POST["sumbit"])){
        $adminid = $_SESSION['id'];
        $groupName = $_POST['group'];
        $conn->query("INSERT INTO teachers VALUES (NULL,'$groupName',$adminid)"); // (id,)
        $_SESSION['message'] = "تم اضافة المعلم " . $groupName . " بنجاح.";
        echo "<script>window.location.href='teachersData.php'</script>";
    }
?>

<?php require_once "footer.php";?>
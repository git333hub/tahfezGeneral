<?php
$title = "بيانات المعلمين" ;
require_once "header.php";
?>
<a href="addTeacher.php">اضافة معلم</a>
<h1>أسماء المعلمين:</h1>
<?php
$groupNames = $conn->query("SELECT * FROM teachers WHERE adminid = ".$_SESSION['id']);
while($group = mysqli_fetch_array($groupNames)):
    ?>
    <label><?php echo $group['name']?></label>
    <form onsubmit="return confirm('هل تريد حذف المعلم?')" action="" method='POST' style='display:inline-block'>
        <input type="hidden" name='deleteGroup' value="<?php echo $group['id'] ?>">
        <button >حذف</button>
    </form>
    <br>
<?php 
endwhile;
if(isset($_POST['deleteGroup'])){ // delete group
    $conn->query("DELETE FROM teachers WHERE `id` ='" . $_POST['deleteGroup']."' AND adminid = ".$_SESSION['id']);
    echo "<script>window.location.href='teachersData.php'</script>";
    die();
}
?>
<?php require_once "footer.php";?>
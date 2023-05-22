<?php 
$title = "الاعدادات" ;
require_once "header.php";
?>

<form method="POST" onsubmit="return confirm('هل تريد حذف كل شيء ؟!')">
    <label for="attack">اعادة تهيئة النقاط:</label>
    <input type="submit" name="reset" value="اعادة التهيئة" >
</form>


<?php 
if(isset($_POST['reset'])){
    // $conn->multi_query('ALTER TABLE `admincontrols` AUTO_INCREMENT = 1;');
    // $conn->multi_query('DELETE from `admin`;DELETE from `admincontrols`;DELETE from `groups`;DELETE from `records`;DELETE from `store`;DELETE from `teachers`;DELETE from `user_psw`;');
    $conn->multi_query('TRUNCATE TABLE `admin`;TRUNCATE TABLE `admincontrols`;TRUNCATE TABLE `groups`;TRUNCATE TABLE `records`;TRUNCATE TABLE `store`;TRUNCATE TABLE `teachers`;TRUNCATE TABLE `user_psw`;');
    echo("تم اعادة تهيئة النظام بنجاح");
}
<?php
require_once "../connection.php";
ini_set('display_errors', FALSE);
session_start();
if (!@$_SESSION['logged_owner']){ // prevent open all owner pages unless joining from the login page
    echo "<script>window.location.href='../login.php'</script>";
    die();
}
?>
    
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
    </head>
    <body dir="rtl">
        <div class="topnav">
            <ul>
                <li><a href="home.php">الصفحة الرئيسة</a></li>
                <li><a href="addAdmin.php">اضافة مشرف</a></li>
                <li><a href="controls.php">الاعدادات</a></li>
                <li class="logout"><a href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </div>
        <br>
        <br>

<?php
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    echo "</br>";
}
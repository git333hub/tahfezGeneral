<?php
ini_set('display_errors', FALSE);
session_start();
require_once "connection.php";
require_once("cookie.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>تسجيل الدخول</title>
</head>
<body dir="rtl">
<div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">تسجيل الدخول</h2>
    <form class="login-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
       <p><input type="text" name="user" value="<?php if(isset($_COOKIE['username'])){ echo $_COOKIE['username']; }?>" placeholder="اسم المستخدم" ></p> 
        <p><input type="password" name="password" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; }?>" placeholder="كلمة المرور"></p>
        <p><input type="submit" name="submit" value="دخول"></p>
        <h5>
          <?php if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
} ?>
</h5>
    </form>
    </div>


</body>
</html>


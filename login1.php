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
    </form>
    </div>

<?php
require_once "connection.php";
session_start();
$admins = $conn->query("SELECT * FROM `admin`");
while($admin = mysqli_fetch_array($admins)){
    $adminUser = $admin['user'];
    $adminPass = $admin['password'];
}
if(isset($_POST['submit'])){


    // $user = $_POST["user"]; 
    // $password = $_POST["password"];
    //if he is admin
    $user = trim(htmlspecialchars($_POST['user']));
    $password = trim(htmlspecialchars($_POST['password']));
    $hour = time() + 3600 * 24 * 120;
    setcookie('username', $user, $hour);
    setcookie('password', $password, $hour);
    if(isset($user) && isset($password) && !empty($user) && !empty($password)){
        if($user === $adminUser && $password === $adminPass){
            $_SESSION['name'] = $user;
            $_SESSION['logged_admin'] = true;
            header("Location: admin/home.php");
        }else{ // if he is member
            $members = $conn->query('SELECT * FROM `user_psw` WHERE `user` = ' . "$user" . ' AND psw = ' . "$password");
            if(isset($members)){
                if((@$members->num_rows) > 0){
                    while($member = mysqli_fetch_array($members)){
                        $_SESSION['name'] = $member['name'];
                        $_SESSION['money'] = $member['money'];
                        $_SESSION['lifeP'] = $member['lifeP'];
                        $_SESSION['group'] = $member['group'];
                        $_SESSION['logged_member'] = true;
                        header("Location: member/home.php");
                    }
                }else{
                    echo "لا يوجد حساب بهذه البيانات";
                }
            }
        }
    }else{
        echo "يرجى ملئ جميع الحقول";
    }




}

// need to create delaying 5 mins function when entering 3 wrong credintials 

?>


</body>
</html>

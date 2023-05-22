<?php
require_once "../connection.php";
ini_set('display_errors', FALSE);
session_start();
if (!@$_SESSION['logged_admin']){ // prevent open all admin pages unless joining from the login page
    echo "<script>window.location.href='../login.php'</script>";
    die();
}
updateGroupPoints($conn);
function updateGroupPoints($conn)// update the total group points, called when add new student or when attack someone
{
    $groupNames = $conn->query("SELECT * FROM groups WHERE adminid = ".$_SESSION['id'])->fetch_all(MYSQLI_ASSOC);
    $member = $conn->query("SELECT * FROM user_psw WHERE  adminid = ".$_SESSION['id'])->fetch_all(MYSQLI_ASSOC);
    $sum = 0;
    for ($i=0; $i < count($groupNames); $i++) { 
        $counter = 0;
        for ($j=0; $j < count($member); $j++) { 
            if($member[$j]['group'] === $groupNames[$i]['groupNames']){
                $sum += $member[$j]['lifeP'];
                $counter++;
            }
        }
        @$average = $sum/$counter;
        $conn->query("UPDATE groups SET `points` = $average WHERE `groupNames` = '". $groupNames[$i]['groupNames'] . "' AND adminid = ".$_SESSION['id']);
        $sum = 0;
    }
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
                <li><a href="studentsData.php">بيانات الطلاب</a></li>
                <li><a href="groupsData.php">بيانات المجموعات</a></li>
                <li><a href="points.php">النقاط</a></li>
                <li><a href="records.php">السجل</a></li>
                <li><a href="store.php">المتجر</a></li>
                <li><a href="controls.php">الإعدادات</a></li>
                <li><a href="teachersData.php">المعلمين</a></li>
                <li><a href="../b/?id=<?php echo substr(base64_encode($_SESSION['id']), 0, -2)?>">ترتيب الأوائل</a></li>
                <li class="logout"><a href="logout.php">تسجيل الخروج</a></li>
            </ul>
            <br>
            <br>
        </div>

<?php
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    echo "<br>";
    unset($_SESSION['message']);
}
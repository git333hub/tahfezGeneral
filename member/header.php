<?php
require_once "../connection.php";
ini_set('display_errors', FALSE);
session_start();
if (!@$_SESSION['logged_member']){// prevent open all member pages unless joining from the login page
    echo "<script>window.location.href='../login.php'</script>";
    die();
}
updateSessions($conn); // to update the shown session information everytime, as it is in the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>
<body dir="rtl">
    <!-- start top navigation bar -->
    <div class="topnav">
    <nav>
        <ul>
            <li><a class="active" href="home.php">الصفحة الرئيسة</a></li>
            <li class="logout"><a href="logout.php">تسجيل الخروج</a></li>     
            <?php
if($_SESSION['lifeP'] < 50){ // if the user has less than 50 life point, he can't do any thing, and only the main and logout pages are shown
    echo "<br>";
    echo "<br>";
    echo"</div>";
    echo "<h1>" . "أهلاً " . $_SESSION['name'] . "</h1>" . "</br>";
    echo "<h2>" ."الرصيد: " . $_SESSION['money'] . "</h2>" . "</br>";
    echo "<h2>" ."نقاط الحياة: " . $_SESSION['lifeP'] . "</h2>" . "</br>";
    echo "<h2>" ."المجموعة: " . $_SESSION['group'] . "</h2>" . "</br>";
    echo "نقاطك لا تسمح بفعل شيء";
    echo "</br>";
    echo "يجب عليك شراء نقاط حياة بسعر 100$";
    echo "لتحصل على 50 نقطة";
    echo "<form method='POST' >";
    echo '<input type="submit" name="submit" value="شراء">';
    echo '</form>';
    if(isset($_POST['submit'])){
        if($_SESSION['money'] >= 100){
            $conn->query("UPDATE user_psw SET `money` = " . ($_SESSION['money'] - 100) . " , `lifeP` = ".($_SESSION['lifeP'] + 50)." WHERE `id`= " . $_SESSION['id'] );
            echo "<script>window.location.href='home.php'</script>";
        }else{
            echo "للأسف لا تمتلك رصيد كافي";
            die();
        }
    }
    die();
    
}
function updateSessions($conn){
    $members = $conn->query('SELECT * FROM `user_psw` WHERE `id` = ' . $_SESSION['id']);
    while($member = mysqli_fetch_array($members)){
        $_SESSION['money'] = $member['money'];
        $_SESSION['lifeP'] = $member['lifeP'];
    }
}

function updateGroupPoints($conn)// update the total group points, called when add new student or when attack someone
{
    $groupNames = $conn->query("SELECT * FROM groups WHERE `adminid` = " . $_SESSION['adminid'])->fetch_all(MYSQLI_ASSOC);
    $member = $conn->query("SELECT * FROM user_psw WHERE `adminid` = " . $_SESSION['adminid'])->fetch_all(MYSQLI_ASSOC);
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
        $conn->query("UPDATE groups SET `points` = $average WHERE `groupNames` = '". $groupNames[$i]['groupNames'] . "'");
        $sum = 0;
    }
}
?>
<!-- continue show other li if the life point > 50 -->
<li><a href="membersPoints.php">النتائج</a></li>
<li><a href="assest.php">مساندة</a></li>
<li><a href="info.php">المستودع</a></li>
<?php 
            $controls = $conn->query("SELECT * FROM admincontrols WHERE `adminid` = " . $_SESSION['adminid'])->fetch_all(MYSQLI_ASSOC);
            $attack = $controls[0]["status"];
            if($attack){// if attack == 1 it will shown, i also will prevent making attack in case he entered the page before closing the the attack.php
            ?>
            <form id="form" action="attack.php" method="POST">
                <li><a onclick="submit()">تسديد</a></li>
            </form>
            <?php } ?>
        </ul>
        <br>
        <br>
        </nav>
    </div>
            <script>
            function submit() {
                let form = document.getElementById("form");
                form.submit();
                }
            </script>
    

    <?php 
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        echo "</br>";
    }

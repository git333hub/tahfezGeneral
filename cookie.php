<?php 
ini_set('display_errors', FALSE);
if(isset($_POST['submit'])){
    
    $user = trim(htmlspecialchars($_POST['user']));
    $password = trim(htmlspecialchars($_POST['password']));
    $hour = time() + 3600 * 24 * 60;

    if(isset($user) && isset($password) && !empty($user) && !empty($password)){
        $admins = $conn->query('SELECT * FROM `admin` WHERE `user` = "'. $user .'" AND `password` = "'. $password.'"')->fetch_array(MYSQLI_ASSOC);

            if(@count($admins) > 0){
                if($admins['joindate'] > $admins['expiredate']){
                    die("لقد انهتى الاشتراك في البرنامج");
                }

                    $adminId = $admins['id'];
                    $adminUser = $admins['user'];
                    $adminPass = $admins['password'];

                    setcookie('username', $user, $hour);
                    setcookie('password', $password, $hour);
                    $_SESSION['id'] = $adminId;
                    $_SESSION['name'] = $_POST['id'];
                    if($user === "owner"){
                        echo '<script>window.location = "owner/home.php"</script>';
                        $_SESSION['logged_owner'] = true;
                    }else{
                        $_SESSION['logged_admin'] = true;
                        echo '<script>window.location = "admin/home.php"</script>';
                    }
                
            
        }else{
            $members = $conn->query('SELECT * FROM `user_psw` WHERE `user` = "' .$user. '" AND `psw` = "' .$password. '"')->fetch_array(MYSQLI_ASSOC);

                if(@count($members) > 0){
                    $dateValidation = $conn->query('SELECT * FROM `admin` WHERE `id` = ' . $members['adminid'])->fetch_array(MYSQLI_ASSOC);

                        if($dateValidation['joindate'] > $dateValidation['expiredate']){
                            die("لقد انهتى الاشتراك في البرنامج");
                        }
                        elseif($members['banned']==1){
                            die("للأسف حسابك مغلق، حاول ان تجتهد لإعادة فتحه");
                        }
                        setcookie('username', $user, $hour);
                        setcookie('password', $password, $hour);
                        $memberUser = $members['user'];
                        @$memberPass = $members['password'];
                        $_SESSION['id'] = $members['id'];
                        $_SESSION['name'] = $members['name'];
                        $_SESSION['money'] = $members['money'];
                        $_SESSION['lifeP'] = $members['lifeP'];
                        $_SESSION['group'] = $members['group'];
                        $_SESSION['adminid'] = $members['adminid'];
                        $_SESSION['logged_member'] = true;
                        // header("Location: member/home.php");
                        echo '<script>window.location = "member/home.php"</script>';
                    
                }else{
                    $_SESSION['message'] = "لا يوجد حساب بهذه البيانات";
                }
            
        }
    }else{
        $_SESSION['message'] = "يرجى ملئ جميع الحقول";
    }

}

?>
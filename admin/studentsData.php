<?php
$title = "بيانات الطلاب";
require_once "header.php";
?>

<a href="addStudent.php">إضافة طالب</a>

<h1>بيانات الطلاب</h1>
<!-- بيانات الطلاب جدول -->
<div style="overflow-x:auto;">
    <table class="studentTable">


        <?php
        if (isset($_POST['deleteAccount'])) { //delete students from the data base from two tables
            $conn->query("DELETE FROM user_psw WHERE id =" . $_POST['deleteAccount'] . " AND adminid = " . $_SESSION['id']);
            echo "<script>window.location.href='studentsData.php'</script>"; // refresh the page
            die();
        }
        if (isset($_POST['save'])) { // update the enterd information about this student
            if ($_POST["d1"] == null || $_POST["d1"] == '' || !isset($_POST["d1"])) {
                $conn->query("UPDATE user_psw SET `d1` = '',`powerd1` = 0 WHERE `id` = '" . $_POST['id'] . "' AND adminid = " . $_SESSION['id']);
            } else {
                $powerd1 = $conn->query("SELECT `power` FROM store WHERE `product` = '" . $_POST["d1"] . "' AND adminid = " . $_SESSION['id'])->fetch_array(MYSQLI_ASSOC);
                $conn->query("UPDATE user_psw SET `d1` = '" . $_POST["d1"] . "' , `powerd1` = " . $powerd1['power'] . " WHERE `id` = " . $_POST['id'] . " AND adminid = " . $_SESSION['id']);
            }
            $isChecked = (isset($_POST['banned'])) ? 1 : 0;
            $conn->query('UPDATE user_psw SET  `banned` = ' . $isChecked . ', `name` = "' . $_POST["name"] . '" , `money` = ' . $_POST["money"] . ', `tMoney` = ' . $_POST["tMoney"] . ' , `lifeP` = ' . $_POST["lifeP"] . ' , `user` = "' . $_POST["user"] . '" , `psw` = "' . $_POST["psw"] . '" ,
             `group` = "' . $_POST["group"] . '" , `teacher` = "' . $_POST["teacher"] . '"  , `w1` = "' . $_POST["w1"] . '"  , `w2` = "' . $_POST["w2"] . '"  , `w3` = "' . $_POST["w3"] . '" 
              WHERE `id` = ' . $_GET['id'] . " AND adminid = " . $_SESSION['id']);
        }


        if (isset($_GET['id'])) { // display only this student
            $displayStu = $conn->query("SELECT * FROM user_psw WHERE `id` = '" . $_GET['id'] . "' AND adminid = " . $_SESSION['id'] . " limit 1")->fetch_array(MYSQLI_ASSOC);


        ?>

            <thead>
                <tr>
                    <th>مجمد</th>
                    <th><a href="?sort=name">الاسم</a></th>
                    <th><a href="?sort=teacher">المعلم</a></th>
                    <th><a href="?sort=money">المال</a></th>
                    <th><a href="?sort=tMoney">مجموع المال</a></th>
                    <th><a href="?sort=lifeP">نقاط الحياة</a></th>
                    <th>اسم المستخدم</th>
                    <th>الرمز السري</th>
                    <th><a href="?sort=group">المجموعة</a></th>
                    <th>تسديد1</th>
                    <th>تسديد2</th>
                    <th>تسديد3</th>
                    <th>دفاع</th>
                    <th>الحذف</th>
                </tr>
            </thead>
            <tbody>
                <form method="POST" id="form1">
                    <?php
                    $wValue = $conn->query("SELECT `group`,w1,w2,w3,d1 from `user_psw` WHERE `id` = " . $_GET['id'] . " AND `adminid` = " . $_SESSION['id'])->fetch_array(MYSQLI_ASSOC);
                    $groups = $conn->query("SELECT `groupNames` from `groups` WHERE `adminid` = " . $_SESSION['id']);
                    $weapons = $conn->query("SELECT product from `store` WHERE `kind` = 'هجوم' AND `adminid` = " . $_SESSION['id']);
                    ?>
                    <tr>
                        <input type="hidden" name="id" value="<?php echo $displayStu['id'] ?>">
                        <td><input <?php echo ($displayStu['banned'] == 1) ? "checked" : "" ?> type="checkbox" size="1" name="banned" value="1"></td>
                        <td><input type="text" size="4" name="name" value="<?php echo $displayStu['name'] ?>"></td>
                        <td><input type="text" size="4" name="teacher" value="<?php echo $displayStu['teacher'] ?>"></td>
                        <td><input type="text" size="4" name="money" value="<?php echo $displayStu['money'] ?>"></td>
                        <td><input type="text" size="4" name="tMoney" value="<?php echo $displayStu['tMoney'] ?>"></td>
                        <td><input type="text" size="4" name="lifeP" value="<?php echo $displayStu['lifeP'] ?>"></td>
                        <td><input type="text" size="4" name="user" value="<?php echo $displayStu['user'] ?>"></td>
                        <td><input type="text" size="4" name="psw" value="<?php echo $displayStu['psw'] ?>"></td>
                        <td><select name="group">
                                <option style="background-color: grey;" selected value="<?php echo $wValue['group'] ?>"><?php echo $wValue['group'] ?></option>
                                <?php
                                while ($group = mysqli_fetch_array($groups)) {
                                    if($wValue['group'] == $group['groupNames']) {continue;}
                                    echo "<option value='" . $group['groupNames'] . "'>" . $group['groupNames'] . "</option>";
                                }
                                ?>
                            </select></td>
                        <td><select name="w1">
                                <option selected><?php echo !empty($wValue['w1']) ? $wValue['w1'] : "" ?></option>
                                <option style='background-color:red' value=''>حذف</option>
                                <?php
                                $weapons = $conn->query("SELECT product from `store` WHERE `kind` = 'هجوم' AND `adminid` = " . $_SESSION['id']);
                                while ($weapon = mysqli_fetch_array($weapons)) {
                                    if(!empty($wValue['w1']) && $wValue['w1'] == $weapon['product']){continue;}
                                    echo "<option value='" . $weapon['product'] . "'>" . $weapon['product'] . "</option>";
                                }
                                ?>
                            </select></td>
                        <td><select name="w2">
                                <option selected><?php echo !empty($wValue['w2']) ? $wValue['w2'] : "" ?></option>
                                <option style='background-color:red' value=''>حذف</option>
                                <?php
                                $weapons = $conn->query("SELECT product from `store` WHERE `kind` = 'هجوم' AND `adminid` = " . $_SESSION['id']);
                                while ($weapon = mysqli_fetch_array($weapons)) {
                                    if(!empty($wValue['w2']) && $wValue['w2'] == $weapon['product']){continue;}
                                    echo "<option value='" . $weapon['product'] . "'>" . $weapon['product'] . "</option>";
                                } ?>
                            </select></td>
                        <td><select name="w3">
                                <option selected><?php echo !empty($wValue['w3']) ? $wValue['w3'] : "" ?></option>
                                <option style='background-color:red' value=''>حذف</option>
                                <?php
                                $weapons = $conn->query("SELECT product from `store` WHERE `kind` = 'هجوم' AND `adminid` = " . $_SESSION['id']);
                                while ($weapon = mysqli_fetch_array($weapons)) {
                                    if(!empty($wValue['w3']) && $wValue['w3'] == $weapon['product']){continue;}
                                    echo "<option value='" . $weapon['product'] . "'>" . $weapon['product'] . "</option>";
                                } ?>
                            </select></td>
                        <td><select name="d1">
                                <option selected><?php echo !empty($wValue['d1']) ? $wValue['d1'] : "" ?></option>
                                <option style='background-color:red' value=''>حذف</option>
                                <?php
                                $weapons = $conn->query("SELECT product from `store` WHERE `kind` = 'دفاع' AND `adminid` = " . $_SESSION['id']);
                                while ($weapon = mysqli_fetch_array($weapons)) {
                                    if(!empty($wValue['d1']) && $wValue['d1'] == $weapon['product']){continue;}
                                    echo "<option value='" . $weapon['product'] . "'>" . $weapon['product'] . "</option>";
                                } ?>
                            </select></td>
                </form>
                <td>
                    <form onsubmit="return confirm('هل تريد حذف الحساب?')" action="" method='POST' style='display:inline-block'>
                        <input type="hidden" name='deleteAccount' value="<?php echo $displayStu['id'] ?>">
                        <button>حذف</button>
                    </form>
                </td>
                </tr>
            </tbody>
    </table>
</div>
<br>
<input type="submit" name="save" value="حفظ التغييرات" form="form1">
<br>

<?php


        } else { // if there is no $_GET['id'], it will show all students data
?>
    <thead>
        <tr>
            <th><a href="?sort=id">الرقم</a></th>
            <th><a href="?sort=banned">مجمد</a></th>
            <th><a href="?sort=name">الاسم</a></th>
            <th><a href="?sort=teacher">المعلم</a></th>
            <th><a href="?sort=money">المال</a></th>
            <th><a href="?sort=tMoney">مجموع المال</a></th>
            <th><a href="?sort=lifeP">نقاط الحياة</a></th>
            <th>اسم المستخدم</th>
            <th>الرمز السري</th>
            <th><a href="?sort=group">المجموعة</a></th>
            <th>تسديد1</th>
            <th>تسديد2</th>
            <th>تسديد3</th>
            <th>دفاع</th>
            <th>التعديل</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($_GET['sort'])) { // sorting
                $stuNames = $conn->query("SELECT * FROM user_psw WHERE `adminid` =" . $_SESSION['id'] . " ORDER BY `" . $_GET['sort'] . "` DESC");
            } else {
                $stuNames = $conn->query("SELECT * FROM user_psw WHERE `adminid` =" . $_SESSION['id'] . " ORDER BY id");
            }

            $i = 1;
            while ($stuName = mysqli_fetch_array($stuNames)) :
        ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo ($stuName['banned'] == 1) ? "نعم" : "لا" ?></td>
                <td><?php echo $stuName['name'] ?></td>
                <td><?php echo $stuName['teacher'] ?></td>
                <td><?php echo $stuName['money'] ?></td>
                <td><?php echo $stuName['tMoney'] ?></td>
                <td><?php echo $stuName['lifeP'] ?></td>
                <td><?php echo $stuName['user'] ?></td>
                <td><?php echo $stuName['psw'] ?></td>
                <td><?php echo $stuName['group'] ?></td>
                <td><?php echo $stuName['w1'] ?></td>
                <td><?php echo $stuName['w2'] ?></td>
                <td><?php echo $stuName['w3'] ?></td>
                <td><?php echo $stuName['d1'] ?></td>
                <td><a href="?id=<?php echo $stuName['id'] ?>">تعديل</a></td>
            </tr>

        <?php endwhile;
        ?>
    </tbody>
    </table>
    </div>
<?php
        }
        require_once "footer.php"; ?>
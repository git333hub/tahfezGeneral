<?php
$title = "الصفحة الرئيسة";
require_once "header.php";

?>
<div class="container">
    <table>
        <tr>

            <th>الرقم</th>
            <th>اسم المحضن</th>
            <th>اسم المستخدم</th>
            <th>الرقم السري</th>
            <th>تاريخ الانضمام</th>
            <th>تاريخ الانتهاء</th>
            <th>تفاصيل</th>
        </tr>
        <?php
        if (isset($_POST['deleteAccount'])) { //delete students from the data base from two tables
            $conn->query("DELETE FROM `admin` WHERE id =" . $_POST['deleteAccount'] );
            echo "<script>window.location.href='home.php'</script>"; // refresh the page
            die();
        }
        if (isset($_POST['save'])) { // update the enterd information about this student
            $conn->query('UPDATE `admin` SET  `name` = "' . $_POST["name"] . '", `id` = ' . $_POST["id"] . ' , `user` = "' . $_POST["user"] . '" , `password` = "' . $_POST["password"] . '" , `joindate` = "' . $_POST["joindate"] . '" , `expiredate` = "' . $_POST["expiredate"] . '"  WHERE `id` = '.$_GET['id']);
        }

        if (isset($_GET['id'])) {
            $admin = $conn->query("SELECT * FROM `admin` WHERE id = " . $_GET['id'])->fetch_array(MYSQLI_ASSOC);
           
        ?>

                <form method="POST" id="form1">
                    <tr>
                        <td><input type="text" size="1" name="id" value="<?php echo $admin['id'] ?>"></td>
                        <td><input type="text" size="4" name="name" value="<?php echo $admin['name'] ?>"></td>
                        <td><input type="text" size="4" name="user" value="<?php echo $admin['user'] ?>"></td>
                        <td><input type="text" size="4" name="password" value="<?php echo $admin['password'] ?>"></td>
                        <td><input type="text" size="8" name="joindate" value="<?php echo $admin['joindate'] ?>"></td>
                        <td><input type="text" size="8" name="expiredate" value="<?php echo $admin['expiredate'] ?>"></td>
                    </form>
                    <td>
                        <form onsubmit="return confirm('هل تريد حذف الحساب?')" action="" method='POST' style='display:inline-block'>
                            <input type="hidden" name='deleteAccount' value="<?php echo $admin['id'] ?>">
                            <button>حذف</button>
                        </form>
                    </td>
                    
                </tr>
                
            </table>
        </div>
        <br>
        <input type="submit" name="save" value="حفظ التغييرات" form="form1">

<?php
        } else {
            $admins = $conn->query("SELECT * FROM `admin`");
            while ($admin = mysqli_fetch_array($admins)) : // print all admins with their students
                if($admin["name"] === "owner"){
                    continue;
                }
?>

    <tr>

        <td><?php echo $admin['id'] ?></td>
        <td><?php echo $admin['name'] ?></td>
        <td><?php echo $admin['user'] ?></td>
        <td><?php echo $admin['password'] ?></td>
        <td><?php echo $admin['joindate'] ?></td>
        <td><?php echo $admin['expiredate'] ?></td>
        <td><a href="?id=<?php echo $admin['id'] ?>">تعديل</a></td>
    </tr>
<?php endwhile; ?>
</table>
</div>

<?php } ?>






<?php require_once "footer.php"; ?>





<!-- // عرض جميع النقاط -->
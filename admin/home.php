<?php
$title = "الصفحة الرئيسة" ;
require_once "header.php";
$groupNames = $conn->query("SELECT * FROM groups WHERE adminid = ".$_SESSION['id']." ORDER BY points DESC");
$j = 1;
while($group = mysqli_fetch_array($groupNames)): // print all groups with their students
?>
<div class="container">
    <table>
        <tr>
            <th colspan= "2"><?php echo $j . "-" . $group['groupNames']?></th><th colspan= "2"><?php echo $group['points']?>💗</th>
        </tr>
        <tr>
            <th>م</th><th>العضو</th><th>المال</th><th>نقاط الحياة</th>
        </tr>
        <?php 
            $stuNames = $conn->query("SELECT * FROM user_psw WHERE `group` = '" . $group["groupNames"] . "' AND `adminid`= ".$_SESSION['id']);
            $i=1;
            while($student = mysqli_fetch_array($stuNames)):
        ?>
        <tr>
            <td><?php echo $i?></td><td><?php echo $student['name']?></td><td><?php echo $student['money']?>$</td><td><?php echo $student['lifeP']?>💗</td>
        </tr>
        <?php 
    $i++;
    endwhile; 
    $j++;
    ?>
    </table>
</div>

<?php endwhile; ?>

<?php require_once "footer.php";?>





<!-- // عرض جميع النقاط -->


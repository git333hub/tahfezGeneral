<?php
$title = "النتائج";
require_once "header.php";
$groupNames = $conn->query("SELECT * FROM groups WHERE adminid=".$_SESSION['adminid']." ORDER BY points DESC");
$j = 1;
while ($group = mysqli_fetch_array($groupNames)) : // print all groups with their students

?>
    <div class="container">
        <table>
            <tr>
                <th colspan="2"><?php echo $j . "-" . $group['groupNames'] ?></th>
                <th colspan="2"><?php echo $group['points'] ?>💗</th>
            </tr>
            <?php if ($_SESSION['group'] == $group['groupNames']) : ?>
                <tr>
                    <th>م</th>
                    <th>العضو</th>
                    <th>الرصيد</th>
                    <th>نقاط الحياة</th>
                </tr>
                <?php
                $stuNames = $conn->query("SELECT * FROM user_psw WHERE `group` = '" . $group["groupNames"] . "' AND adminid=".$_SESSION['adminid']);
                $i = 1;
                while ($student = mysqli_fetch_array($stuNames)) :
                // $weapons = $conn->query("SELECT `d1` FROM weapons WHERE `id` = '".$student['id']. "' AND adminid=".$_SESSION['adminid'])->fetch_array(MYSQLI_ASSOC);
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $student['name'] ?></td>
                        <td><?php echo $student['money'] ?>$</td>
                        <td><?php echo $student['lifeP'] ?>💗</td>
                    </tr>


                    <?php
                    $i++;
                endwhile;
                echo "</table>";
                $j++;
                continue;
                endif;
            ?>
            <tr>
                <th>م</th>
                <th>العضو</th>
                <th>نقاط الحياة</th>
            </tr>
            <?php
            $stuNames = $conn->query("SELECT * FROM user_psw WHERE `group` = '" . $group["groupNames"] . "' AND adminid=".$_SESSION['adminid']);
            $i = 1;
            while ($student = mysqli_fetch_array($stuNames)) :
            ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $student['name'] ?></td>
                    <td><?php echo $student['lifeP'] ?>💗</td>
                </tr>


            <?php
                $i++;
            endwhile;
            $j++;
            ?>
        </table>
    </div>

<?php endwhile; ?>

<?php require_once "footer.php"; ?>





<!-- // عرض جميع النقاط -->
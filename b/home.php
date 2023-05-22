<?php
$title = "النتائج";
require_once "header.php";

?>
    <div class="container">
        <table>
        
            <tr>
                <th>المركز</th>
                <th>الاسم</th>
                <th>النقاط</th>
            </tr>
            <?php
            $stuNames = $conn->query("SELECT id,`name`,`money` FROM user_psw WHERE `money` > 0 ORDER BY `money` DESC")->fetch_all(MYSQLI_ASSOC);
            $j = 1;
            for ($i=0; $i < count($stuNames);):
                
            ?>
                <tr>
                    <td><?php echo $j ?></td>
                    <td><?php echo $stuNames[$i]['name'] ?></td>
                    <td><?php echo $stuNames[$i]['money'] ?></td>
                    
                </tr>


            <?php
            if($i == count($stuNames)-1){
                break;
            }elseif($stuNames[$i]['money'] != $stuNames[++$i]['money']){
                $j++;
            }
            endfor;
            ?>
        </table>
    </div>


<?php require_once "footer.php"; ?>





<!-- // عرض جميع النقاط -->
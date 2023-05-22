<?php
$title = "السجل" ;
require_once "header.php";
?>

<h3>تصنيف حسب:</h3>
<a href="?kind=0">المشتريات</a>
<a href="?kind=1">التسديدات</a>
<a href="?kind=2">التحويلات</a>



<?php
// $records = $conn->query("SELECT * FROM records WHERE adminid = ".$_SESSION['id']);
// $records = $conn->query("SELECT * FROM `records` LIMIT " . $page_first_result . ',' . $results_per_page);
if (!isset ($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = $_GET['page'];  
}  
$results_per_page = 200;  
$page_first_result = ($page-1) * $results_per_page;
//determine the total number of pages available  
if (isset ($_GET['kind']) ) { 
    $records = $conn->query("SELECT * FROM `records` WHERE adminid = ".$_SESSION['id']." AND kind = ". $_GET['kind'] ." ORDER BY `time` DESC LIMIT $page_first_result , $results_per_page");
}else{
    $records = $conn->query("SELECT * FROM `records` WHERE adminid = ".$_SESSION['id']." ORDER BY `time` DESC LIMIT $page_first_result , $results_per_page");
}
$number_of_page = ceil (mysqli_num_rows($records) / $results_per_page);
?>

<table>
    <tr>
        <th>الحدث</th><th>الوقت</th>
    </tr>
    <?php while($record = mysqli_fetch_array($records)): ?>
        <tr>
            <td><?php echo $record['event'] ?></td><td><?php echo $record['time'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- make pages -->
<ul style="margin-top: 100px;">
    <?php 
    for ($i=1; $i <= $number_of_page ; $i++){
        echo "<li><a href='records.php?page=$i'>".$i."</li>";
    }
    ?>
        
</ul>

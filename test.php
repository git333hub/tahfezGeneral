
<form method="POST" >
    <input type="checkbox" name="banned" id="banned" value="1">
    <input type="submit" name="submit" value="submit">
</form>


<?php
if (isset($_POST['submit'])) {
    if(isset( $_POST['banned'])){

        echo $_POST['banned'];
    }else{
    echo 0;
}
}
// $a = substr(base64_encode('1'), 0, -2);
// $c = 'MQ'.'==';
// $a = base64_decode(('$c'));

// echo $a;
// $sdf = date("Y-m-d");
// echo $sdf;
// $current_datetime = strtotime("2028-01-02");
// $expire_datetime = strtotime(date('Y-m-d', strtotime("+1 year")));
// echo $current_datetime < $expire_datetime;
// if($current_datetime < $expire_datetime){
//     echo "your subscription has expired!";
// }
<?php
$title = "اضافة تسديدة" ;
require_once "header.php";
?>

    <form action="" method="POST">
        <label >اسم التسديدة: </label>
        <input autofocus autocomplete="off" type="text" name="weaponName"> </br>
        <label >سعر التسديدة: </label>
        <input type="text" autocomplete="off" name="weaponPrice"></br>
        <label >قوة التسديدة: </label>
        <input type="text" autocomplete="off" name="weaponPower"></br>
        <label >كمية التسديدة: </label>
        <input type="text" autocomplete="off" name="weaponQty"></br>
        <label >نوع التسديدة: </label>
        </br>
        <label >تسديد: </label>
        <input type="radio" name="weaponKind" value="هجوم"></br>
        <label >صد: </label>
        <input type="radio" name="weaponKind" value="دفاع"></br>
        <input type="submit" name="submit" value="اضافة التسديدة">


    </form>

    <?php
    if(isset($_POST['submit'])){
        if(isset($_POST['weaponName']) && isset($_POST['weaponPrice']) && isset($_POST['weaponPower']) &&  isset($_POST['weaponQty']) && isset($_POST['weaponKind']) && isset($_POST['submit'])){
            $name = $_POST['weaponName'];
            $price = $_POST['weaponPrice'];
            $power = $_POST['weaponPower'];
            $qty = $_POST['weaponQty'];
            $kind = $_POST['weaponKind'];
            $adminid = $_SESSION['id'];

            $conn->query("INSERT INTO store VALUES (NULL,'$name',$price,$power,$qty,'$kind',$adminid ) ");
            $_SESSION['message'] = "تم اضافة التسديدة بنجاح!";
            echo "<script>window.location.href='addWeapon.php'</script>";
        }else{
            echo "يرجى ملئ جميع الحقول";
        }
    }
    ?>
<?php require_once "footer.php";?>
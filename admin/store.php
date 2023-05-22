<?php
$title = "المتجر";
require_once "header.php";
?>


<br>
<a href="addWeapon.php">اضافة تسديدة</a>
<br>
<br>

<?php


// end show store items
if (isset($_GET['id'])) { // select one item
    $stores = $conn->query("SELECT * FROM store WHERE id = " . $_GET['id'] . " AND adminid = " . $_SESSION['id']); // select only this kind and make it in one box
    getOneItem($stores->fetch_array(MYSQLI_ASSOC));
} else { // show un editiable items
    // show store items
    $stores = $conn->query("SELECT * FROM store WHERE kind = 'هجوم' AND adminid = " . $_SESSION['id']); // select only this kind and make it in one box
    printStores($stores,'هجوم');

    $stores = $conn->query("SELECT * FROM store WHERE kind = 'دفاع' AND adminid = " . $_SESSION['id']);
    printStores($stores,'دفاع');
}
function getOneItem($stores)
{


    $i = 1; // to numbering the items
?>
    <form method="post">
        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>الرقم</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>القوة</th>
                    <th>الكمية</th>
                    <th>النوع</th>
                    <th>الحذف</th>
                </tr>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <input type="hidden" name='id' value="<?php echo $stores['id'] ?>">
                    <td> <input size="6" type="text" value="<?php echo $stores['product'] ?>" name="product<?php echo $stores['id'] ?>"> </td>
                    <td> <input size="6" type="text" value="<?php echo $stores['price'] ?>" name="price<?php echo $stores['id'] ?>"> </td>
                    <td> <input size="6" type="text" value="<?php echo $stores['power'] ?>" name="power<?php echo $stores['id'] ?>"> </td>
                    <td> <input size="6" type="text" value="<?php echo $stores['qty'] ?>" name="qty<?php echo $stores['id'] ?>"> </td>
                    <td>
                        <select name="kind<?php echo $stores['id'] ?>">
                            <option style="background-color: grey;" selected value="<?php echo ($stores['kind'] == 'هجوم') ? "هجوم" : "دفاع" ?>"><?php echo ($stores['kind'] == 'هجوم') ? "تسديد" : "صد" ?></option>
                            <option value="هجوم">تسديد</option>
                            <option value="دفاع">صد</option>
                        </select>
                    </td>

    </form>
    <td>
        <form onsubmit="return confirm('هل تريد حذف الحساب?')" method='POST' style='display:inline-block'>
            <input type="hidden" name='deleteweapon' value="<?php echo $stores['id'] ?>">
            <button onclick="return confirm('هل تريد حذف التسديدة?')">حذف</button>
        </form>
    </td>
    </tr>

    </table></br>
    </div>
    <input type="submit" name="submit" value="حفظ التغييرات">
<?php } // end getOneItem function  
?>

<?php
function printStores($stores,$knd)
{

    $i = 1; // to numbering the items
?>
    <div style="overflow-x:auto;">
        <table>
            <tr>
                <td colspan="7"><?php echo ($knd == 'هجوم') ? 'التسديد' : 'الصد' ?></td>
            </tr>
            <tr>
                <th>الرقم</th>
                <th>الاسم</th>
                <th>السعر</th>
                <th>القوة</th>
                <th>الكمية</th>
                <th>التعديل</th>
            </tr>
            <?php
            while ($store = mysqli_fetch_array($stores)):
            ?>

                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo $store['product'] ?></td>
                    <td><?php echo $store['price'] ?></td>
                    <td><?php echo $store['power'] ?></td>
                    <td><?php echo $store['qty'] ?></td>
                    <td><a href="?id=<?php echo $store['id'] ?>">تعديل</a></td>
                </tr>

            <?php endwhile; ?>

        </table></br>
    </div>
<?php } // end printStores function 



if (isset($_POST['deleteweapon'])) {
    $conn->query("DELETE FROM store WHERE id =" . $_POST['deleteweapon'] . " AND adminid = " . $_SESSION['id']);
    echo "<script>window.location.href='store.php'</script>"; // refresh the page
    die();
}

if (isset($_POST['submit'])) { // update the data base as entered above
    $stores = $conn->query("SELECT * FROM store WHERE id = " . $_POST['id'] . " AND adminid = " . $_SESSION['id']);
    while ($store = mysqli_fetch_array($stores)) {
        $conn->query('UPDATE store SET 
                `product` = "' . $_POST['product' . $store['id']]  . '",
                `price` = ' . $_POST['price' . $store['id']]  . ',
                `power` = ' . $_POST['power' . $store['id']]  . ',
                `qty` = ' . $_POST['qty' . $store['id']]  . ',
                `kind` = "' . $_POST['kind' . $store['id']]  . '"
                 WHERE `id` = ' . $store["id"]);
    }
    echo "<script>window.location.href='store.php'</script>";
}

require_once "footer.php"; ?>
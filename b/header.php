<?php
require_once "../connection.php";
session_start();
ini_set('display_errors', FALSE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>
<body dir="rtl">

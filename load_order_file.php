<?php
session_start();

$file_name = $_POST['order_file_name'];

header('Location: index.php');
?>
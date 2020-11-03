<?php
session_start();
unset($_SESSION['orderMatrix_session']);
unset($_SESSION['OrderNodes_session']);

$orderMatrix = array();

$file_name = $_POST['order_file_name'];
$order_nodes = 0;

unset($data);
$row = 1;
if (($handle = fopen('CSV/'.$file_name . '.csv', 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
        $num = count($data);
        if($row == 1) $_SESSION['OrderNodes_session'] = $data[0];
        else{
            for ($i = 0; $i < 3; $i++) {
                if($i>1) $data[$i] = str_replace(',','.',$data[$i]);
                $_SESSION['orderMatrix_session'][$row-2][$i] = $data[$i];
            }
        }
        $row++;
    }
    fclose($handle);
}

header('Location: data.php');
?>
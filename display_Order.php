<?php
session_start();
include_once "display.php";
include_once "algorithms.php";

$orderMatrix = array();

if(isset($_SESSION['orderMatrix_session'])){$orderMatrix = $_SESSION['orderMatrix_session'];}
else {echo "Error: SESSION Variable is not set! </br>";}
echo '<h1>Tabela Danych - zamówienia </h1>';
display_orderTable($orderMatrix);
?>
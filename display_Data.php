<?php
session_start();
include_once "display.php";

$cityData = array();
$distanceMatrix = array();

if(isset($_SESSION['cityData_session'])){$cityData = $_SESSION['cityData_session'];}
else {echo "Error: SESSION Variable is not set! </br>";}
echo '<h1>Tabela Danych - informacje o miastach</h1>';
display_cityTable($cityData);

if(isset($_SESSION['distanceMatrix_session'])){$distanceMatrix = $_SESSION['distanceMatrix_session'];}  
else {echo "Error: SESSION Variable is not set! </br>";}
echo '<h1>Tabela Danych - odległości między miastami </h1>';
display_distanceTable($distanceMatrix);
?>
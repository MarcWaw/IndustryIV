<?php
session_start();
include_once "display.php";
include_once "algorithms.php";

$orderMatrix = array();

if(isset($_SESSION['orderMatrix_session'])){$orderMatrix = $_SESSION['orderMatrix_session'];}
else {echo "Error: SESSION Variable is not set! </br>";}
echo '<h1>Tabela Danych - zamówienia </h1>';
display_orderTable($orderMatrix);

echo '<h1>Algorytm zachłanny VRP</h1>';

$hub = rand(0,$_SESSION['OrderNodes_session'] - 1);
echo "Hub: " . $hub . "<br/>";

$nbofTrucks = rand(6,12);
echo "Number of Trucks: " . $nbofTrucks . "<br/>";

$orders_array = array();
for($i=0; $i < $_SESSION['OrderNodes_session']; $i++){
    $orders_array[$i] = $_SESSION['orderMatrix_session'][$i][0];
}

$calculatedP = greedyVRP($orders_array, $_SESSION['distanceMatrix_session'], $hub, $nbofTrucks, $_SESSION['OrderNodes_session'] - 1);

echo "<br/><br/> Final Permutation: <br/>";
display_final_permutation($calculatedP, $hub);
?>
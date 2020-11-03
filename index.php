<?php session_start();?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="styles/index_style.css">
    <title>Problem marszrutyzacji pojazdów</title>
</head>
<body>
    <div id="logo">
        <h1>VRP – problem marszrutyzacji pojazdów</h1>
    </div>
    <div id="nav">
        <ul>
            <li><a class="active" href="index.php">Strona Główna</a></li>
            <li><a href="data.php">Dane</a></li>
            <li><a href="schedule.php">Harmonogram tras</a></li>
        </ul>
    </div>
    <div id="content">
        <h2>3. Algorytm zachłanny dla VRP</h2>
        <?php
            include_once "algorithms.php";
            $hub = rand(0,$_SESSION['OrderNodes_session'] - 1);
            echo "Hub: " . $hub . "<br/>";

            $nbofTrucks = rand(6,12);
            echo "Number of Trucks: " . $nbofTrucks . "<br/>";

            $orders_array = array();
            for($i=0; $i < $_SESSION['OrderNodes_session']; $i++){
                $orders_array[$i] = $_SESSION['orderMatrix_session'][$i][0];
            }
            array_splice($orders_array, $hub, 1);

            $calculatedP = greedyVRP($orders_array, $_SESSION['distanceMatrix_session'], $hub, $nbofTrucks, $_SESSION['OrderNodes_session'] - 1);

            echo "Final Permutation: ";
            display_final_permutation($calculatedP, $hub);
            echo "<br/>";

            ?>
        <h2>4. Algorytm zachłanny dla CVRP</h2>
    </div>

    
</body>
</html>
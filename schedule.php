<?php session_start();?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="styles/index_style.css">
    <title>Problem marszrutyzacji pojazdów</title>
</head>
<body>
    <div id="nav">
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="data.php">Dane</a></li>
            <li><a class="active" href="schedule.php">Harmonogram tras</a></li>
        </ul>
    </div>
    <div id="content">
    <h1>Tabela Danych - Zamówienia</h1>
        <div id="tablebox">
        <?php
        include_once "display.php";
        include_once "algorithms.php";
        
        $orderMatrix = array();
        
        if(isset($_SESSION['orderMatrix_session'])){$orderMatrix = $_SESSION['orderMatrix_session'];}
        else {echo "Error: SESSION Variable is not set! </br>";}
        display_orderTable($orderMatrix);
        ?>
        </div>
        <button type="button" class="collapsible">Wczytaj dane o zamówieniach</button>
        <div class="colcontent">
            <form action="load_order_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="order_file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
        </div>
    <h2>Algorytm zachłanny dla VRP</h2>
        <?php
            include_once "algorithms.php";
            $hub = rand(0,$_SESSION['OrderNodes_session'] - 1);
            echo "Hub: " . $hub . "<br/>";

            $nbofTrucks = 8;
            echo "Number of Trucks: " . $nbofTrucks . "<br/>";

            $orders_array = array();
            for($i=0; $i < $_SESSION['OrderNodes_session']; $i++){
                $orders_array[$i] = $_SESSION['orderMatrix_session'][$i][0];
            }
            array_splice($orders_array, $hub, 1);

            $start = microtime(true);
            $calculatedP = greedyVRP($orders_array, $_SESSION['distanceMatrix_session'], $hub, $nbofTrucks, $_SESSION['OrderNodes_session'] - 1);
            $timeElapsed = microtime(true) - $start;

            echo "Permutacja Końcowa: ";
            display_final_permutation($calculatedP, $hub);
            echo "<br/>";

            echo "Czas działania algorytmu: " . $timeElapsed * 100 . "ms<br/>";
            ?>
            <h2>Algorytm zachłanny dla CVRP</h2>
        <?php
            include_once "algorithms.php";
            $orders_array = array();
            for($i=0; $i < $_SESSION['OrderNodes_session']; $i++){
                $orders_array[$i] = $_SESSION['orderMatrix_session'][$i][0];
            }
            array_splice($orders_array, $hub, 1);
            
            $start = microtime(true);
            $calculatedP = greedyCVRP($orders_array, $_SESSION['distanceMatrix_session'], $hub, $_SESSION['orderMatrix_session']);
            $timeElapsed = microtime(true) - $start;

            echo "Permutacja końcowa: ";
            display_final_permutation($calculatedP, $hub);
            echo "<br/>";

            echo "Czas działania algorytmu: " . $timeElapsed * 100 . "ms<br/>";
            ?>
    </div>  
    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>   
</body>
</html>
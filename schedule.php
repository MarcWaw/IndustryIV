<?php 
    session_start();
    include_once "algorithms.php";
?>

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
        <div id="Hub">
        <form action="#" method="post">
            <label for="Cities">Wybierz Hub:</label>
            <select name="Cities" id="cities">
                <?php
                    for($int=0; $i < $_SESSION['Nodes_session']; $i++){
                        echo '<option value="' . $i .'">' . $_SESSION['cityData_session'][$i][1] . '</option>';
                    }
                ?>
            </select>
            <input type="submit" name="submit" value="Wybierz" />
        </form>
        <?php
            unset($_SESSION['Hub_session']);
            if(isset($_POST['submit'])){
                $_SESSION['Hub_session'] = $_POST['Cities'];  // Storing Selected Value In Variable
            }
        ?>
        </div>
        <?php 
        $hub = $_SESSION['Hub_session']; //rand(0,$_SESSION['OrderNodes_session'] - 1);
        echo "Hub: " . $hub . ", " . $_SESSION['cityData_session'][$hub][1] ."<br/>";
        ?>
        <h2>Algorytm zachłanny dla VRP</h2>
        <canvas id="Map" width="850" height="850" style="border:1px solid #000000;">
        </canvas>
        <br/>
        <?php

            $nbofTrucks = 8;

            $orders_array = array();
            for($i=0; $i < $_SESSION['OrderNodes_session']; $i++){
                $orders_array[$i] = $_SESSION['orderMatrix_session'][$i][0];
            }
            array_splice($orders_array, $hub, 1);

            $start = microtime(true);
            $calculatedP = greedyVRP($orders_array, $_SESSION['distanceMatrix_session'], $hub, $nbofTrucks, $_SESSION['OrderNodes_session'] - 1);
            $timeElapsed = microtime(true) - $start;

            display_on_map($calculatedP, $_SESSION['cityData_session'], $hub, "Map");

            echo "Trasy pojazdów: ";
            display_final_permutation($calculatedP, $hub, $_SESSION['cityData_session'],$_SESSION['distanceMatrix_session'],$_SESSION['orderMatrix_session']);
            echo "<br/>";

            echo "Czas działania algorytmu: " . $timeElapsed * 100 . "ms<br/>";
            ?>

            <h2>Algorytm zachłanny dla CVRP</h2>
            <canvas id="Map2" width="850" height="850" style="border:1px solid #000000;">
            </canvas>
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

            display_on_map($calculatedP, $_SESSION['cityData_session'], $hub, "Map2");

            echo "<br/>";
            echo "Trasy pojazdów: ";
            display_final_permutation($calculatedP, $hub, $_SESSION['cityData_session'], $_SESSION['distanceMatrix_session'],$_SESSION['orderMatrix_session']);
            echo "<br/>";

            echo "Czas działania algorytmu: " . $timeElapsed * 100 . "ms<br/>";
            ?>

            <h2>Algorytm metaheurystyczny - Symulowane wyżarzanie</h2>
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
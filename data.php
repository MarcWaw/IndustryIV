<?php session_start();
include_once "display.php";

$cityData = array();
$distanceMatrix = array();
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
            <li><a class="active" href="data.php">Dane</a></li>
            <li><a href="schedule.php">Harmonogram tras</a></li>
        </ul>
    </div>
    <div id="content">
        <h1>Tabela Danych - informacje o miastach</h1>
        <div id="tablebox">
        <?php
        if(isset($_SESSION['cityData_session'])){$cityData = $_SESSION['cityData_session'];}
        else {echo "Error: SESSION Variable is not set! </br>";}
        display_cityTable($cityData);
        ?>
        </div>
        <h1>Tabela Danych - odległości między miastami </h1>
        <div id="tablebox">
            <?php
            if(isset($_SESSION['distanceMatrix_session'])){$distanceMatrix = $_SESSION['distanceMatrix_session'];}  
            else {echo "Error: SESSION Variable is not set! </br>";}
            display_distanceTable($distanceMatrix);    
            ?>
        </div>

        <button type="button" class="collapsible">Wczytaj dane o miastach</button>
        <div class="colcontent">
            <form action="load_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
        </div>
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
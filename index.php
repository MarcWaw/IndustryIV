<?php session_start();?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Problem marszrutyzacji pojazdów</title>
</head>
<body>
    <div id="container">
        <div id="logo">
            <h1>VRP – problem marszrutyzacji pojazdów</h1>
        </div>
        <div id="nav">
            <ul>
                <li><a class="active"> Home </a></li>
                <li><a>Order</a></li>
                <li><a>Data</a></li>
                <li><a>Map</a></li>
                <li><a>Algorithms</a></li>
            </ul>
        </div>
        <div id="content">
            <h2>1. Wczytaj dane o miastach z pliku</h2>
            <form action="load_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
            <br />
            <form action="display_Data.php">
                <input type="submit" value="Wyświetl" />
                <br />
            </form>
            <h2>2. Wczytaj dane zamówienia z pliku.</h2>
            <form action="load_order_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="order_file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
            <br />
            <form action="display_Order.php">
                <input type="submit" value="Wyświetl" />
                <br />
            </form>
            <h2>3. Algorytm zachłanny dla VRP</h2>
            <h2>4. Algorytm zachłanny dla CVRP</h2>
        </div>
    </div>

    
</body>
</html>
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
        <h1>VRP</h1>
    </div>
    <div id="nav">
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a class="active" href="data.php">Dane</a></li>
            <li><a href="schedule.php">Harmonogram tras</a></li>
        </ul>
    </div>
    <div id="content">
        <button type="button" class="collapsible">Wczytaj dane o miastach</button>
        <div class="colcontent">
            <form action="load_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
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
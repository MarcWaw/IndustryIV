<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Problem marszrutyzacji pojazdów</title>
    <link rel="stylesheet" href="Styles/index_style.css" type="text/css"/>

</head>
<body>
    <div id="container">
        <div id="logo">
            <h1>VRP – problem marszrutyzacji pojazdów</h1>
        </div>
        <div id="nav">
            Home <br/>
            Add <br/>
            Update <br/>
            Table <br/>
        </div>
        <div id="content">
            <form action="load_file.php" method="post">
                Nazwa Pliku:
                <input type="text" name="file_name"/> 
                <input type="submit" value="Wczytaj" />
                <br />
            </form>
            <form action="dbupdate.php" method="post">
                Name:
                <input type="text" name="city_name"/> 
                <br />
                Postcode:
                <input type="text" name="city_postcode"/> 
                <br />
                Latitude:
                <input type="text" name="city_latitude"/> 
                <br />
                Longitude:
                <input type="text" name="city_longitude"/> 
                <input type="submit" value="Add" />
                <br />
            </form>
        </div>
        <footer>
            Laboratorium Przemysł 4.0 
        </footer>
    </div>

    
</body>
</html>
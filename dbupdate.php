<?php

    
function displayCitiesTable(){
    require_once "dbconnect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    
    if($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    else
    {   
        $sql = "SELECT * FROM cities";
        $result = $connection->query($sql);
        if($result->num_rows > 0)
        {       
            while($row = $result->fetch_assoc())
            {
                echo "id: " . $row["id"] . " | Name: " . $row["Name"] . " | Postcode: " . $row["Postcode"] . " | Latitude: " . $row["Latitude"] . " | Longitude: " . $row["Longitude"] . "<br/>";
            }
            $result->free_result();
        }
        else
        {
            echo 'Kupsztal!';
        }
    
        $connection->close();
    }
}
?>
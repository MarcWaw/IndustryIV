<?php
function update_cityData($connection, $cityData, $nodes){
    if($connection->connect_errno!=0)
    {
        echo "Connection failed: ".$connection->connect_errno;
    }
    else{
        for($i = 0; $i < $nodes; $i++)
        {   
            $name = $cityData[$i][1];
            $postcode = $cityData[$i][0];
            $latitude = $cityData[$i][2];
            $longitude = $cityData[$i][3];

            $sql = "SELECT * FROM cities WHERE Name='$name'";
            $result = $connection->query($sql);
            if($result->num_rows > 0)
            {
                echo " Istnieje już taki record: ". "Name: ". $name. " | Postcode: ". $postcode. " | Latitude: ". $latitude. " | Longitude: ". $longitude ."<br/>";
            }
            else {
                $sql = "INSERT INTO cities (Name, Postcode, Latitude, Longitude)
                        VALUES ('$name', '$postcode', '$latitude', '$longitude')";

                if($connection->query($sql) === TRUE)
                {       
                    echo "New record created succesfully! ". "Name: ". $name. " | Postcode: ". $postcode. " | Latitude: ". $latitude. " | Longitude: ". $longitude ."<br/>";    
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . $connection->error;
                }
            }   
        }
        $connection->close();
    }
}

?>
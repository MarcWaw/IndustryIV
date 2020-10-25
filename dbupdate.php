<?php
function add_record(){
    require_once "dbconnect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    else
    {
        $sql = "SELECT * FROM 'cities' WHERE name='WROCLAW'";

        if($result = $connection->query($sql))
        {       
            $amount = $result->num_rows;
            echo "Kaczka? " . $amount;

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
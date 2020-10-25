<?php
require_once "dbconnect.php";
$connection = new mysqli($host, $db_user, $db_password, $db_name);

if($connection0->connect_errno!=0)
{
    echo "Error: ".$connection->connect_errno. " Description: ". $connection->connect_error;
}
else
{
    echo "Działa!";
    $connection->close();
}


?>
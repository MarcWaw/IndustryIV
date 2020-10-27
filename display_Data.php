<?php
session_start();

$cityData = array();
$distanceMatrix = array();

//Show Table with CSV Data
function display_dataTable($m){
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>', 'ID', '</td>';
    foreach(array_keys(current($m)) as $i) { 
        echo '<td>', $i ,'</td>';
    }
    echo '</tr>';

    foreach(array_keys($m) as $j) {
        echo '<tr>';
        echo '<td>', $j, '</td>';
        foreach(array_keys($m[$j]) as $i) {
            echo '<td>', $m[$j][$i], '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

if(isset($_SESSION['cityData_session'])){
    $cityData = $_SESSION['cityData_session'];
}
else {
    echo "Error: SESSION Variable is not set! </br>";
}
echo '<h1>Tabela Danych - informacje o miastach</h1>';
display_dataTable($cityData);

if(isset($_SESSION['distanceMatrix_session'])){
    $distanceMatrix = $_SESSION['distanceMatrix_session'];
}  
else {
    echo "Error: SESSION Variable is not set! </br>";
}
echo '<h1>Tabela Danych - odległości między miastami </h1>';
display_dataTable($distanceMatrix);
?>
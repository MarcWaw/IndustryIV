<?php
session_start();

$orderMatrix = array();
$orderNodes = 0;

function display_orderTable($m)
{
    $table_names = array(
        0 => "Cel",
        1 => "Długość",
        2 => "Waga",  
    );
    
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>', 'ID', '</td>';
    foreach(array_keys(current($m)) as $i) { 
        echo '<td>', $table_names[$i] ,'</td>';
    }
    echo '</tr>';

    foreach(array_keys($m) as $j) {
        echo '<tr>';
        echo '<td>', $j, '</td>';
        foreach(array_keys($m[$j]) as $i) {
            if($i == 0)
                echo '<td>', $_SESSION['cityData_session'][$m[$j][$i]-1][1], '</td>';
            else if($i == 1)
                echo '<td>', $m[$j][$i] . " m", '</td>';
            else
                echo '<td>', $m[$j][$i] . " kg", '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

$orderNodes = $_SESSION['OrderNodes_session'];
if(isset($_SESSION['orderMatrix_session'])){
    $orderMatrix = $_SESSION['orderMatrix_session'];
}
else {
    echo "Error: SESSION Variable is not set! </br>";
}
echo '<h1>Tabela Danych - zamówienia </h1>';
display_orderTable($orderMatrix);
?>
<?php

function display_cityTable($m)
{
    $table_names = array(
        0 => "Kod Pocztowy",
        1 => "Nazwa",
        2 => "Szerokość",
        3 => "Długość", 
    );
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>', 'ID', '</th>';
    foreach(array_keys(current($m)) as $i) { 
        echo '<th>', $table_names[$i] ,'</th>';
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

function display_distanceTable($m)
{
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

function display_orderTable($m)
{
    $table_names = array(
        0 => "Cel",
        1 => "Długość",
        2 => "Waga",  
    );
        echo '<table border="1">';
    echo '<tr>';
    echo '<th>', 'ID', '</th>';
    foreach(array_keys(current($m)) as $i) { 
        echo '<th>', $table_names[$i] ,'</th>';
    }
    echo '</tr>';
    foreach(array_keys($m) as $j) {
        echo '<tr>';
        echo '<td>', $j, '</td>';
        foreach(array_keys($m[$j]) as $i) {
            if($i == 0)
                echo '<td>', $_SESSION['cityData_session'][$m[$j][$i]][1], '</td>';
            else if($i == 1)
                echo '<td>', $m[$j][$i] . " m", '</td>';
            else
                echo '<td>', $m[$j][$i] . " kg", '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

?>
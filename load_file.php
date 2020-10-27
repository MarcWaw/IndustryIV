<?php
session_start();

require_once "dbupdate.php";
require_once "dbconnect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

$file_name = $_POST['file_name'];

function load_citydata_file($f){
    unset($_SESSION['distanceMatrix_session']);
    unset($_SESSION['cityData_session']);
    unset($_SESSION['Nodes_session']);
    unset($_SESSION['UoD_session']);

    $row = 1;
    unset($data);
    if (($handle = fopen('CSV/'. $f . '.csv', 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
            $num = count($data);
            if($row == 1) $_SESSION['Nodes_session'] = $data[0];
            elseif($row == 2) $_SESSION['UoD_session'] = $data[0];
            elseif($row <= ($_SESSION['Nodes_session'] + 2)){
                for ($i = 0; $i < $num; $i++) {
                        if ($data[$i]=='')$i = $num;
                        else {
                            $data[$i] = str_replace(',','.',$data[$i]);
                            $_SESSION['distanceMatrix_session'][$row - 3][$i] = $data[$i];
                        }
                }
            }
            else{
                for ($i = 0; $i < 4; $i++) {
                    if($i>1) $data[$i] = str_replace(',','.',$data[$i]);
                    $_SESSION['cityData_session'][$row-$_SESSION['Nodes_session']-3][$i] = $data[$i];
                }
            }
            $row++;
        }
        fclose($handle);
    }
}

load_citydata_file($file_name);
header('Location: index.php');

/*
function display_permutation($h, $p, $cD){
    $x = 0;
    foreach($p as $value){
        
        if($value == $h){ 
            echo "<br> Pojazd $x : ";
            $x++;
        }
        echo "[" . $cD[$value][1] . "]";
        
    }
}

function calculate_distance($p, $matrix){
    $sum = 0;
    for($i=0;$i < sizeof($p) - 1; $i++){
        $sum = $sum + $matrix[$i][$i+1];
        if($i == sizeof($p) - 2) $sum = $sum + $matrix[$i+1][0];
    }
    return $sum;
}

$permutation = array();
$hub = rand(0, $nodes - 1);
$vNb = rand(2,8);
echo "<h1>Wylosowana ilość pojazdów: $vNb </h1>";
$ind = 0;
for($i = 0; $i < $vNb; $i++){
    $numberOfPoints = rand(1,4);
    echo "<h3>Pojazd $i , wylosowana ilość punktów: $numberOfPoints </h3>";
    array_push($permutation, $hub);
    
    for($j = 0; $j < $numberOfPoints; $j++){
        $temp = rand(0, $nodes - 1);
        while($temp == $hub) $temp = rand(0, $nodes - 1);
        array_push($permutation, $temp);
    }
}

echo '<h1>Permutacja</h1>';
echo '[';
foreach($permutation as $value){
    if($value == $hub)    echo "<u>$value</u> ";
    else echo "$value ";
}
echo ']';
echo '<h1>Trasy pojazdów</h1>';
display_permutation($hub,$permutation,$cityData);
*/
//echo '<h1>Całkowita przebyta odległość</h1>';
//$sum = calculate_distance($permutation, $distanceMatrix);
//echo $sum . " " . $UoD . "<br>";

//test
?>
<?php 
require_once "dbupdate.php";
require_once "dbconnect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

$distanceMatrix = array();
$cityData = array();

$file_name = $_POST['file_name'];

$nodes = 0;
$UoD = '';
$row = 1;
if (($handle = fopen('CSV/'.$file_name . '.csv', 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
        $num = count($data);
        if($row == 1) $nodes = $data[0];
        elseif($row == 2) $UoD = $data[0];
        elseif($row <= ($nodes + 2)){
            for ($i = 0, $j = 0; $i < $num; $i++) {
                    if ($data[$i]=='')$i = $num;
                    else {
                        $data[$i] = str_replace(',','.',$data[$i]);
                        $distanceMatrix[$row - 3][$i] = $data[$i];
                    }
            }
        }
        else{
            for ($i = 0; $i < 4; $i++) {
                if($i>1) $data[$i] = str_replace(',','.',$data[$i]);
                $cityData[$row-$nodes-3][$i] = $data[$i];
            }
        }
        $row++;
    }
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
    fclose($handle);
}

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

echo '<h1>Tabela Danych - informacje o miastach</h1>';
display_dataTable($cityData);
echo '<h1>Tabela Danych - odległości między miastami </h1>';
display_dataTable($distanceMatrix);

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

//echo '<h1>Całkowita przebyta odległość</h1>';
//$sum = calculate_distance($permutation, $distanceMatrix);
//echo $sum . " " . $UoD . "<br>";

//test
?>
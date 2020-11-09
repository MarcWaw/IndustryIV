<?php
function display_array($a){
    echo "[ ";
    for($i=0; $i < sizeof($a); $i++) { 
        echo $a[$i] . " ";
    }
    echo "]<br/>";
}

function display_final_permutation($a, $h, $cd){
    $color = array(
        0 => "#ffffff",
        1 => "#ff0000",
        2 => "#ff7f50",
        3 => "#ffa500",
        4 => "#ffd700",
        5 => "#ffff00",
        6 => "#00ff00",
        7 => "#7fff00",
        8 => "#98FB98",
        9 => "#20B2AA",
        10 => "#00FFFF",
        11 => "#00BFFF",
        12 => "#1E90FF",
        13 => "#0000FF",
        14 => "#8A2BE2",
        15 => "#FF00FF",
        16 => "#FF1493",
        17 => "#D2691E",
        18 => "#F5FFFA",
        19 => "#F8F8FF",
    );

    $truckCount = 1;
    for($i=0; $i < sizeof($a); $i++) { 
        if($i==sizeof($a)-1);
        elseif($a[$i] == $h){
             echo "<br/>Pojazd ". $truckCount . ": " . "<u>".$cd[$a[$i]][1]."</u>" . " ";
             $truckCount++;
            }
        else echo $cd[$a[$i]][1] . " ";
    }
    echo "<br/>";
}

function display_on_map($permutaion, $cityData, $hub, $canvasID){
    $color = array(
        0 => "#ffffff",
        1 => "#ff0000",
        2 => "#ff7f50",
        3 => "#ffa500",
        4 => "#ffd700",
        5 => "#ffff00",
        6 => "#00ff00",
        7 => "#7fff00",
        8 => "#98FB98",
        9 => "#20B2AA",
        10 => "#00FFFF",
        11 => "#00BFFF",
        12 => "#1E90FF",
        13 => "#0000FF",
        14 => "#8A2BE2",
        15 => "#FF00FF",
        16 => "#FF1493",
        17 => "#D2691E",
        18 => "#F5FFFA",
        19 => "#F8F8FF",
    );
    $change = 0;
    echo '<script type="text/javascript" src="scripts/mapdraw.js"></script>';
            echo '<script type="text/javascript">';
            for($i = 0; $i < sizeof($permutaion); $i++){
                if($i == 0){
                    echo 'drawPoint(' . $cityData[$permutaion[$i]][2].',' . $cityData[$permutaion[$i]][3] . ',' . '"'. $canvasID .'"' . ',"' . $cityData[$permutaion[$i]][1] . '", "'. $color[$change] .'");';
                }
                elseif($hub == $permutaion[$i]){
                    
                    echo 'connectPoints(' . $cityData[$permutaion[$i-1]][2] . ',' . $cityData[$permutaion[$i-1]][3] . ',' . $cityData[$permutaion[$i]][2] . ',' . $cityData[$permutaion[$i]][3] . ',"'. $canvasID .'", "'. $color[$change] .'");';
                    $change++;
                }
                else{
                    echo 'connectPoints(' . $cityData[$permutaion[$i-1]][2] . ',' . $cityData[$permutaion[$i-1]][3] . ',' . $cityData[$permutaion[$i]][2] . ',' . $cityData[$permutaion[$i]][3] . ',"'. $canvasID .'", "'. $color[$change] .'");';
                    echo 'drawPoint(' . $cityData[$permutaion[$i]][2].',' . $cityData[$permutaion[$i]][3] . ',' . '"'. $canvasID .'"' . ',"' . $cityData[$permutaion[$i]][1] . '", "'. $color[$change] .'");';
                }
            }
            echo '</script>';
}

function find_max_distance($from, $available, $distanceMatrix){
    $maxDistance = $distanceMatrix[$from][$available[0]];
    $target = 0;
    for($i=0; $i<sizeof($available); $i++){
        if($maxDistance < $distanceMatrix[$from][$available[$i]]){
            $target = $i;
            $maxDistance = $distanceMatrix[$from][$available[$i]];
        }
    }
    return $target;
}

function find_min_distance($from, $available, $distanceMatrix){
    $minDistance = 1000000000000000;
    $target = 0;
    for($i=0; $i<sizeof($available); $i++){
        if($minDistance > $distanceMatrix[$from][$available[$i]] && $distanceMatrix[$from][$available[$i]] != 0){
            $target = $i;
            $minDistance = $distanceMatrix[$from][$available[$i]];
        }
    }
    return $target;
}

function greedyVRP($permutation, $distanceMatrix, $hub, $availableTrucks, $nbOfTargets){
    $available = $permutation;

    unset($tempPermutation);
    $tempPermutation = array();
    $target = 0;
    $truckNb = 1;
    while(sizeof($available) != 0){
        array_push($tempPermutation, $hub);
        $j = find_max_distance($hub, $available, $distanceMatrix);
        array_push($tempPermutation, $available[$j]);
        array_splice($available, $j, 1);
        
        $x_truck_tasks = 0;
        if(sizeof($available) != 0) $limit = true;

        while($limit == true){
            $target = find_min_distance($j, $available, $distanceMatrix);
            if($x_truck_tasks + 1 < $nbOfTargets/$availableTrucks){
                array_push($tempPermutation, $available[$target]);
                array_splice($available, $target, 1);
            }
            else{
                $limit = false;
            }
            $x_truck_tasks++;
        }           
        $truckNb++;
    }    
    array_push($tempPermutation, $hub);
    return $tempPermutation;
}

function greedyCVRP($permutation, $distanceMatrix, $hub, $orderMatrix){
    $available = $permutation;

    unset($tempPermutation);
    $tempPermutation = array();
    $target = 0;
    $truckNb = 1;
    while(sizeof($available) != 0){
        array_push($tempPermutation, $hub);
        $j = find_max_distance($hub, $available, $distanceMatrix);
        array_push($tempPermutation, $available[$j]);
        $x_truck_mass = $orderMatrix[$available[$j]][2];
        $x_truck_space = $orderMatrix[$available[$j]][1];
        array_splice($available, $j, 1);
        
        $x_truck_tasks = 0;
        if(sizeof($available) != 0) $limit = true;

        while($limit == true){
            $target = find_min_distance($j, $available, $distanceMatrix);
            if($x_truck_mass + $orderMatrix[$available[$target]][2] <= 8000 && $x_truck_space + $orderMatrix[$available[$target]][1] <= 7.8){
                $x_truck_mass = $x_truck_mass + $orderMatrix[$available[$target]][2];
                $x_truck_space = $x_truck_space + $orderMatrix[$available[$target]][1];
                array_push($tempPermutation, $available[$target]);
                array_splice($available, $target, 1);
                if(sizeof($available) == 0) $limit = false;
            }
            else{
                $limit = false;
            }
            $x_truck_tasks++;
        }           
        $truckNb++;
    }    
    array_push($tempPermutation, $hub);
    return $tempPermutation;
}

?>
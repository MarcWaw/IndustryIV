<?php
function display_array($a){
    echo "[ ";
    for($i=0; $i < sizeof($a); $i++) { 
        echo $a[$i] . " ";
    }
    echo "]<br/>";
}

function display_final_permutation($a, $h, $cd, $dM, $oD){
    $truckCount = 1;
    $distanceCount = 0;
    $TotaldistanceCount = 0;
    $truck_total_mass = 0;
    $truck_total_space = 0;
    for($i=0; $i < sizeof($a); $i++) { 
        if($i==sizeof($a)-1){
            $distanceCount = $distanceCount + $dM[$a[$i-1]][$a[$i]];
            echo "<br/>Długość trasy pojazdu: " . $distanceCount . " km";
            echo "<br/>Masa ładunku pojazdu: " . $truck_total_mass . "/8000 kg";
            echo "<br/>Długość ładunku pojazdu: " . $truck_total_space . "/7.8 m";
            echo "<br/><br/>Całkowita długość tras: " . $TotaldistanceCount . " km";
        }
        elseif($i==0){
        echo "<br/>Pojazd ". $truckCount . ": " . "<u>".$cd[$a[$i]][1]."</u>" . " ";
        $truckCount++;       
        }
        elseif($a[$i] == $h){
            echo "<br/>Długość trasy pojazdu: " . $distanceCount . " km";
            echo "<br/>Masa ładunku pojazdu: " . $truck_total_mass . "/8000 kg";
            echo "<br/>Długość ładunku pojazdu: " . $truck_total_space . "/7.8 m";
            $TotaldistanceCount = $TotaldistanceCount + $distanceCount;
            $distanceCount = 0;
            $truck_total_mass = 0;
            $truck_total_space = 0;
            echo "<br/><br/>Pojazd ". $truckCount . ": " . "<u>".$cd[$a[$i]][1]."</u>" . " ";
            $truckCount++;
        }
        else{ 
            echo " >>> " . $cd[$a[$i]][1] . " ";
            $distanceCount = $distanceCount + $dM[$a[$i-1]][$a[$i]];
            $truck_total_mass = $truck_total_mass + $oD[$a[$i]][2];
            $truck_total_space = $truck_total_space + $oD[$a[$i]][1];
        }
    }
    echo "<br/>";
}

function display_on_map($permutation, $cityData, $hub, $canvasID){
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
        20 => "#ffffff",
        21 => "#ff0000",
        22 => "#ff7f50",
        23 => "#ffa500",
        24 => "#ffd700",
        25 => "#ffff00",
        26 => "#00ff00",
        27 => "#7fff00",
        28 => "#98FB98",
        29 => "#20B2AA",
        30 => "#00FFFF",
        31 => "#00BFFF",
        32 => "#1E90FF",
        33 => "#0000FF",
        34 => "#8A2BE2",
        35 => "#FF00FF",
        36 => "#FF1493",
        37 => "#D2691E",
        38 => "#F5FFFA",
        39 => "#F8F8FF",
        40 => "#20B2AA",
        41 => "#00FFFF",
        42 => "#00BFFF",
        43 => "#1E90FF",
        44 => "#0000FF",
        45 => "#8A2BE2",
        46 => "#FF00FF",
        47 => "#FF1493",
        48 => "#D2691E",
        49 => "#F5FFFA",
        50 => "#F8F8FF",
    );
    $change = 0;
    echo '<script type="text/javascript" src="scripts/mapdraw.js"></script>';
            echo '<script type="text/javascript">';
            for($i = 0; $i < sizeof($permutation); $i++){
                if($i == 0){
                    echo 'drawPoint(' . $cityData[$permutation[$i]][2].',' . $cityData[$permutation[$i]][3] . ',' . '"'. $canvasID .'"' . ',"' . $cityData[$permutation[$i]][1] . '", "'. $color[$change] .'");';
                }
                elseif($hub == $permutation[$i]){
                    
                    echo 'connectPoints(' . $cityData[$permutation[$i-1]][2] . ',' . $cityData[$permutation[$i-1]][3] . ',' . $cityData[$permutation[$i]][2] . ',' . $cityData[$permutation[$i]][3] . ',"'. $canvasID .'", "'. $color[$change] .'");';
                    $change++;
                }
                else{
                    echo 'connectPoints(' . $cityData[$permutation[$i-1]][2] . ',' . $cityData[$permutation[$i-1]][3] . ',' . $cityData[$permutation[$i]][2] . ',' . $cityData[$permutation[$i]][3] . ',"'. $canvasID .'", "'. $color[$change] .'");';
                    echo 'drawPoint(' . $cityData[$permutation[$i]][2].',' . $cityData[$permutation[$i]][3] . ',' . '"'. $canvasID .'"' . ',"' . $cityData[$permutation[$i]][1] . '", "'. $color[$change] .'");';
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
            if($x_truck_mass + $orderMatrix[$available[$target]][2] < 8000 && $x_truck_space + $orderMatrix[$available[$target]][1] < 7.8){
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

function swap($permutaion, $first, $second){
    $tempPermutation = $permutaion;
    $tempPermutation[$first] = $permutaion[$second];
    $tempPermutation[$second] = $permutaion[$first];
    return $tempPermutation;
}

function calculateTotalDistance($permutation, $distanceMatrix){
    $TotalDistance = 0;
    for($i=0; $i<sizeof($permutation); $i++){
        if($i==0);
        else{
            $TotalDistance = $TotalDistance + $distanceMatrix[$permutation[$i-1]][$permutation[$i]];
        }
    }
    return $TotalDistance;
}

function reduceT($T, $it){return $T/log($it+1);}

function checkConditions($permutation, $orderMatrix, $hub){
    $tempMass = 0;
    $tempSpace = 0;
    for($i = 0; $i < sizeof($permutation); $i++){
        if($i==0);
        elseif($permutation[$i] == $hub){
            if($tempMass <= 8000 && $tempSpace <= 7.8){
            $tempMass = 0;
            $tempSpace = 0;
            }
            else
                return FALSE;
        }
        else{
            if($tempMass <= 8000 && $tempSpace <= 7.8){
                $tempMass = $tempMass + $orderMatrix[$permutation[$i]][2];;
                $tempSpace = $tempSpace + $orderMatrix[$permutation[$i]][1];
            }
            else
                return FALSE;
        }
    }
    return TRUE;
}

function simulatedAnnealing($permutation, $distanceMatrix, $orderMatrix, $Tend, $hub){
    $it = 0;
    unset($tempPermutation);
    unset($finalPermutation);
    $tempPermutation = $permutation;
    $finalPermutation = $permutation;
    $T0 = 10000;
    $L = sizeof($permutation) * sizeof($permutation);
    
    
    while($Tend < $T0){
        for($k = 0; $k < $L; $k++){
            $i = rand(1, sizeof($permutation) - 2);
            $j = rand(1, sizeof($permutation) - 2);

            $newPermutation = swap($tempPermutation, $i, $j);
            if(calculateTotalDistance($tempPermutation,$distanceMatrix) > calculateTotalDistance($newPermutation,$distanceMatrix)){
                $dCmax = calculateTotalDistance($tempPermutation,$distanceMatrix) - calculateTotalDistance($newPermutation,$distanceMatrix);
                $r = rand(0, 10000) / 10000;
                if($r >= exp($dCmax/$T0)){
                    $newPermutation = $tempPermutation;
                }
            }
            if(checkConditions($newPermutation, $orderMatrix,$hub) != FALSE)
                $tempPermutation = $newPermutation;
            if(calculateTotalDistance($tempPermutation,$distanceMatrix) < calculateTotalDistance($finalPermutation,$distanceMatrix)){
                $finalPermutation = $tempPermutation;
            }
        }
        $it++;
        $T0 = reduceT($T0, $it);
    } 
    return $finalPermutation;
}

?>
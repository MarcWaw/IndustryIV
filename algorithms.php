<?php
function display_array($a){
    echo "[ ";
    for($i=0; $i < sizeof($a); $i++) { 
        echo $a[$i] . " ";
    }
    echo "]<br/>";
}

function display_final_permutation($a, $h){
    echo "Array: [ ";
    for($i=0; $i < sizeof($a); $i++) { 
        if($a[$i] == $h) echo "<u>$a[$i]</u>" . " ";
        else echo $a[$i] . " ";
    }
    echo "]<br/>";
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
    $cycle1 = 0;
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

        $cycle2 = 0;
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
            $cycle2++;
        }           
        $truckNb++;
        $cycle1++;
    }    
    array_push($tempPermutation, $hub);
    return $tempPermutation;
}

function greedyCVRP($permutation, $distanceMatrix){

}

?>
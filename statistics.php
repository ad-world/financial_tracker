<?php

$sql = "SELECT id, username, description, cost, date, category FROM expenses";
$results = $link->query($sql);

$totalspentthismonth = 0;

function splitMonth($date){
    $date = explode('-', $date);
    return $date[1];
}

if($results->num_rows > 0){
    while($row = $results->fetch_assoc()){
        if($row['username'] == $_SESSION['username']){
            if(date('m')== splitMonth($row['date'])){
                $totalspentthismonth += $row['cost'];
            }
        }
    }
}
$_SESSION['totalspentthismonth'] = $totalspentthismonth;

$familyspentthismonth = 0;

$sql2 = "SELECT id, cost, date FROM expenses"; 
$results2 = $link->query($sql2);
if($results2->num_rows > 0){
    while($row = $results2->fetch_assoc()){
        if(date('m') == splitMonth($row['date'])){
            $familyspentthismonth += $row['cost'];
        }
    }
}

$_SESSION['familyspent'] = $familyspentthismonth;

?>

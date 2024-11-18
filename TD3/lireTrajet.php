<?php

include_once 'Trajet.php';


$tableau = Trajet::recupererTrajets();

foreach($tableau as $row){
    echo $row;
    $passagers = $row->getPassagers();
    foreach($passagers as $col){
        echo "    " . $col;
    }
}

?>
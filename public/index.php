<?php

include "../src/server/config.php";
include "../src/server/models/QuestTable.php";

if($db){
    echo "We are connected";
    $questTable = new QuestTable($db);
    $arr = $questTable->getAllQuests();

    foreach($arr as $i){
        echo $i->QUESTNAME . "<br/>";
    }
}


?>
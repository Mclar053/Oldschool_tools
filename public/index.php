<?php

include "../src/server/config.php";
include "../src/server/models/QuestTable.php";

if($db){
    echo "We are connected";
    $questTable = new QuestTable($db);

    $details = $questTable->retrieveQuestDetails(149);
    $questReqs = $questTable->retrieveQuestRequirements(149);
    $skillReqs = $questTable->retrieveSkillRequirements(149);
    $skillRews = $questTable->retrieveSkillRewards(149);

    echo "<br/>" . sizeof($questReqs)
        . "<br/>" . sizeof($skillReqs)
        . "<br/>" . sizeof($skillRews)
        . "<br/>";

    echo "ID: " . $details->QUESTID
        . "<br/>NAME: " . $details->NAME
        . "<br/>DESCRIPTION: " . $details->DESCRIPTION
        . "<br/>DIFFICULTY: " . $details->DIFFICULTY
        . "<br/>LENGTH: " . $details->LENGTH
        . "<br/>MEMBERS: " . $details->MEMBERS
        . "<br/>QUESTPOINTS: " . $details->QUESTPOINTS;

    foreach($questReqs as $q) {
        echo "ID: " . $q->QUESTID
            . "<br/> REQUIREDQUESTID: " . $q->REQUIREDQUESTID
            . "<br/>NAME: " . $q->NAME
            . "<br/>DESCRIPTION: " . $q->DESCRIPTION
            . "<br/>DIFFICULTY: " . $q->DIFFICULTY
            . "<br/>LENGTH: " . $q->LENGTH
            . "<br/>MEMBERS: " . $q->MEMBERS
            . "<br/>QUESTPOINTS: " . $q->QUESTPOINTS;
    }

    foreach($skillReqs as $s){
        echo "ID: " . $s->CURRENTQUESTID
            . "<br/> SKILLNAME: " . $s->SKILLNAME
            . "<br/>LEVEL: " . $s->LEVEL
            . "<br/>BOOSTABLE: " . $s->BOOSTABLE
            . "<br/>COMMENT: " . $s->COMMENT;
    }

    foreach($skillRews as $s){
        echo "ID: " . $s->CURRENTQUESTID
            . "<br/> SKILLNAME: " . $s->SKILLNAME
            . "<br/>XP: " . $s->XP
            . "<br/>BOOSTABLE: " . $s->OPTIONAL
            . "<br/>CONDITIONAL: " . $s->CONDITIONAL
            . "<br/>COMMENT: " . $s->COMMENT;
    }


//    $questDetails = [
//        "QUESTNAME" => "Test Quest 1",
//        "QUESTPOINTS" => 3,
//        "MEMBERS" => true,
//        "DIFFICULTY" => 2,
//        "LENGTH" => 1,
//        "QUESTNUMBER" => 139
//    ];
//
//    $questQuestRequirements = [
//        50
//    ];
//
//    $questSkillRequirements = [
//        [
//            "SKILLID" => 4,
//            "LEVEL" => 40,
//            "BOOSTABLE" => false,
//            "COMMENT" => null
//        ]
//    ];
//
//    $questSkillRewards = [
//        [
//            "SKILLID" => 4,
//            "XPREWARD" => 50000,
//            "CONDITIONAL" => false,
//            "OPTIONAL" => false,
//            "COMMENT" => null
//        ]
//    ];
//
//    $result = $questTable->addQuest($questDetails, $questQuestRequirements, $questSkillRequirements, $questSkillRewards );
//
//    if($result){
//        $arr = $questTable->getAllQuests();
//
//        foreach($arr as $i){
//            echo $i->NAME . "<br/>";
//        }
//    }
//    else{
//        echo "Naah";
//    }


}

function getQuests($questTable){
    $arr = $questTable->getAllQuests();

    foreach($arr as $i){
        echo $i->QUESTNAME . "<br/>";
    }
}

?>
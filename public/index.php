<?php

include "../src/server/config.php";
include "../src/server/models/QuestTable.php";

if($db){
    echo "We are connected";
    $questTable = new QuestTable($db);

    // getQuests($questTable);

    $questNumber = 50;

    $details = $questTable->retrieveQuestDetails($questNumber);
    $questReqs = $questTable->retrieveQuestRequirements($questNumber);
    $skillReqs = $questTable->retrieveSkillRequirements($questNumber);
    $skillRews = $questTable->retrieveSkillRewards($questNumber);

    $questReqsLength = 0;
    $skillReqsLength = 0;
    $skillRewsLength = 0;

    if($questReqs) $questReqsLength = sizeof($questReqs);
    if($skillReqs) $skillReqsLength = sizeof($skillReqs);
    if($skillRews) $skillRewsLength = sizeof($skillRews);


    echo "<br/>" . $questReqsLength
        . "<br/>" . $skillReqsLength
        . "<br/>" . $skillRewsLength
        . "<br/>";

    echo "<br/><br/>ID: " . $details->QUESTID
        . "<br/>NAME: " . $details->NAME
        . "<br/>DESCRIPTION: " . $details->DESCRIPTION
        . "<br/>DIFFICULTY: " . $details->DIFFICULTY
        . "<br/>LENGTH: " . $details->LENGTH
        . "<br/>MEMBERS: " . $details->MEMBERS
        . "<br/>QUESTPOINTS: " . $details->QUESTPOINTS;

    foreach($questReqs as $q) {
        echo "<br/><br/>ID: " . $q->CURRENTQUESTID
            . "<br/> REQUIREDQUESTID: " . $q->REQUIREDQUESTID
            . "<br/>NAME: " . $q->NAME
            . "<br/>DESCRIPTION: " . $q->DESCRIPTION
            . "<br/>DIFFICULTY: " . $q->DIFFICULTY
            . "<br/>LENGTH: " . $q->LENGTH
            . "<br/>MEMBERS: " . $q->MEMBERS
            . "<br/>QUESTPOINTS: " . $q->QUESTPOINTS;
    }

    foreach($skillReqs as $s){
        echo "<br/><br/>ID: " . $s->CURRENTQUESTID
            . "<br/> SKILLNAME: " . $s->SKILLNAME
            . "<br/>LEVEL: " . $s->LEVEL
            . "<br/>BOOSTABLE: " . $s->BOOSTABLE
            . "<br/>COMMENT: " . $s->COMMENT;
    }

    foreach($skillRews as $s){
        echo "<br/><br/>ID: " . $s->CURRENTQUESTID
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
        echo $i->NAME . "<br/>";
    }
}

?>
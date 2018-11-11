<?php

/**
* Name: Single Quest Controller
* Author: Matthew Clark
* Date: 29/10/2018
*/

/**
 * TODO
 * - Add styling to view
 */


include_once $HOME_DIRECTORY . 'src/server/models/QuestTable.php';
$questTable = new QuestTable($db);

// Get the selected quest
$selectedQuest = isset( $_GET['id'] );

if ($selectedQuest ) {
    $id = $_GET['id'];
    //Gets blog post data from id provided
    $questDetails = $questTable->retrieveQuestDetails($id, $result, $localMessages);
    $messages = array_merge($messages, $localMessages);
    
    if($result) {
        $questRequirements = $questTable->retrieveQuestRequirements($id, $result, $localMessages);
        $messages = array_merge($messages, $localMessages);
    }

    if($result) {
        $skillRequirements = $questTable->retrieveSkillRequirements($id, $result, $localMessages);
        $messages = array_merge($messages, $localMessages);
    }

    if($result) {
        $skillRewards = $questTable->retrieveSkillRewards($id, $result, $localMessages);
        $messages = array_merge($messages, $localMessages);
    }

    if($result) {
        include_once "views/single-quest.php";
    }
    else {
        $msg = "An error has occurred while retrieving a quest.";
        $message = new Message($msg, 1, "Exception");
        array_push($messages, $message);
    }
    // printError("An error has occurred while retrieving the quest: %s. ID: %u", array($questDetails->NAME, $questDetails->QUESTID));

} else {

//Shows all entries to user
    // $allEntries = $entryTable->getAllEntries();
    // include_once "views/list-entries-html.php";
}


?>
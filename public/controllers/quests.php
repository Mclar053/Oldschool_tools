<?php

/**
 * Name: Quests Controller
 * Author: Matthew Clark
 * Date: 29/10/2018
 */

include_once $HOME_DIRECTORY . 'src/server/models/QuestTable.php';
$questTable = new QuestTable($db);

$allQuests = $questTable->getAllQuests($result, $localMessages);
$messages = array_merge($messages, $localMessages);

if($result) {
    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th><th>Name</th><th>Description</th><th>Difficulty</th><th>Length</th><th>Members</th><th>Quest Points</th>';
    echo '</tr>';
    foreach($allQuests as $quest) {
        echo '<tr>';
        echo '<td>' . $quest->QUESTID . '</td>';
        echo '<td> <a href="index.php?page=quest&amp;id=' . $quest->QUESTID . '">' . $quest->NAME . '</a></td>';
        echo '<td>' . $quest->DESCRIPTION . '</td>';
        echo '<td>' . $quest->DIFFICULTYTEXT . '</td>';
        echo '<td>' . $quest->LENGTHTEXT . '</td>';
        echo '<td>' . $quest->MEMBERSTEXT . '</td>';
        echo '<td>' . $quest->QUESTPOINTS . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

?>
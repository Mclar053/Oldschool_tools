<?php
include "../src/server/config.php";
include_once '../src/server/constants.php';
include_once '../src/server/functions.php';
include_once '../src/server/messages.php';

$navigation = isset( $_GET['page'] );
if ( $navigation ) {
    //prepare to load corresponding controller
    $contrl = $_GET['page'];
} else {
    //or prepare to load default controller
    $contrl = "quests";
}
// include "templates/header.html";
// include "views/nav.php";
include_once "controllers/$contrl.php";

// include "templates/footer.html";

if(count($messages) > 0){
    echo "<hr/>";
    echo "<h2> Messages </h2>";
    foreach($messages as $message) {
        $message->displayMessage();
    }
}
?>

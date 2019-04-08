<?php

/**
* Name: Account Creation Controller
* Author: Matthew Clark
* Date: 08/04/2019
*/


include_once $HOME_DIRECTORY . 'src/server/models/UserTable.php';
$userTable = new UserTable($db);

$error = false;

include_once $HOME_DIRECTORY . 'public/views/createAccountView.php';

// Get the selected quest
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty( $_POST['username'])) {
        echo 'USERNAME';
        $error = true;
    }

    if(empty( $_POST['username2'])) {
        echo 'USERNAME';
        $error = true;
    }

    if(empty($_POST['password'])) {
        echo 'PASSWORD';
        $error = true;
    }

    if(empty($_POST['password2'])) {
        echo 'PASSWORD';
        $error = true;
    }

    if(!$error) {
        $userTable->addUser($_POST['username'], $_POST['password'], $userID, $result, $localMessages);
        $messages = array_merge($messages, $localMessages);

        if($result){
            $_SESSION['userID'] = $userID;
            $_SESSION['username'] = $_POST['username'];
            header("Location:" . $HOME_PAGE, true, 301);
            exit();
        }
    }
}

?>
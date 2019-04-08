<?php

/**
* Name: Account Login Controller
* Author: Matthew Clark
* Date: 16/01/2019
*/

/**
 * TODO
 * - Add styling to view
 */


include_once $HOME_DIRECTORY . 'src/server/models/UserTable.php';
$userTable = new UserTable($db);

$error = false;

include_once $HOME_DIRECTORY . 'public/views/login-view.php';

// Get the selected quest
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty( $_POST['username'])) {
        echo 'USERNAME';
        $error = true;
    }

    if(empty($_POST['password'])) {
        echo 'PASSWORD';
        $error = true;
    }

    if(!$error) {
        $passwordVerified = $userTable->checkPassword($_POST['username'], $_POST['password'], $userID, $result, $localMessages);
        $messages = array_merge($messages, $localMessages);

        if($result && $passwordVerified) {
            $_SESSION['userID'] = $userID;
            $_SESSION['username'] = $_POST['username'];
            header("Location:" . $HOME_PAGE, true, 301);
            exit();
        }
    }
}

?>
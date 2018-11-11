<?php

/**
 * Name: Messages Object
 * Author: Matthew Clark
 * Date: 10/11/2018
 */

 // Holder of all message objects.
$messages = array();


// Messages class 
class Message
{
    private $message, $code, $type;

    public function __construct ($message, $code, $type ) {
        $this->message = $message;
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * Displays the error type, code and message in order to find where the error is occuring.
     */
    public function displayMessage() {
        // If the message is an exception then use the trigger error method
        if ($this->type === "Exception"){
            trigger_error($this->message);
            echo "<br/>";
        }
        else {
            echo "<b>Message Type: </b>" . $this->type . "<br/>";
            echo "<b>Code: </b>" . $this->code . "<br/>";
            echo "<b>Message: </b>" . $this->message . "<br/>";
        }
        echo "<br/>";
    }
}

?>
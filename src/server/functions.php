<?php 

/**
* Name: Functions File
* Author: Matthew Clark
* Date: 29/10/2018
*/

/**
 * Print errors to the screen with location of the file
 * @param $errorString Error string to be printed to the screen
 * @param $args
 */
function printError($errorString) {
    echo '<div>ERROR: ' . $errorString . '</div>';
}

/**
 * Gets the current time with microseconds
 * Coutesy of: https://stackoverflow.com/questions/3656713/how-to-get-current-time-in-milliseconds-in-php
 */
function getTimeToMicroseconds() {
    $t = microtime(true);
    $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
    $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

    return $d->format("Y-m-d H:i:s.u"); 
}

?>
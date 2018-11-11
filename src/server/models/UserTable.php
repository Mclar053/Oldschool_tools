<?php


/**
 * Name: User Table
 * Author: Matthew Clark
 * Date: 09/11/2018
 */

 class UserTable extends Table
 {
    public function addUser(&$result, &$messages)
    {
        $result = true;
        $messages = array();
        try {

        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }

    /**
     * Checks password for a given username and password
     * @param $username The username/email address of the given user
     * @param $password The unverified password of the given user
     * @param &$result States whether an operation has failed.
     * @return bool States whether then the user has successfully been verified
     */
    public function checkPassword($username, $password, &$result, &$messages)
    {
        $result = true;
        $messages = array();
        try {
            // Check to see if the username exists and if so retrieve the user data
            $user = $this->retrieveUser($username, $result, $localMessages);
            $messages = array_merge($messages, $localMessages);

            // If the user exists and there were no problems retrieving the user data
            if($result && !is_null($user)) {
                
                // Check the users password that has been entered with the hash that has been saved against the password
                // If they are not equal then they user cannot login
                if(password_verify($password, $user->PASSWORD)) {
                    return true;
                }
            }

            // Reaching this point means that the password or username is incorrect.
            $msg = "The entered username/password is incorrect";
            $message = new Message(sprintf($msg, array($username)), 4, "Information");
            array_push($messages, $message);

            // If the password hasn't been verified correctly or the user account doesn't exist then return false
            return false;
        }
        catch(Exception $e){
            echo $e;
            return false;
        }
    }

    public function getRole(&$result, &$messages)
    {
        $result = true;
        $messages = array();
        try{ 

        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }

    public function retrieveUser($username, &$result, &$messages)
    {
        try{ 
            $result = true;
            $messages = array();
            
            $sql = "
            SELECT
                USERS.EMAILADDRESS AS EMAILADDRESS,
                USERS.PASSWORD AS PASSWORD,
                USERROLES.ROLENAME AS ROLENAME,
                USERROLES.ROLECODE AS ROLECODE
            FROM
                USERS
            INNER JOIN USERROLES
                ON USERS.USERROLEID = USERROLES.USERROLEID
            WHERE
                USERS.EMAILADDRESS = ?;
            ";

            $data = array($username);
            return $this->makeStatement($sql, $data, SQLType::Retrieve, true, $result, $localMessages);
            $messages = array_merge($messages, $localMessages);
        }
        catch(Exception $e){
            echo $e;
            return null;
        }
    }

    protected function checkUserExists($username, &$result, &$messages)
    {
        $result = true;
        $messages = array();
        try {
            
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve, true, $result);
        }
        catch(Exception $e){
            echo $e;
            return null;
        }
    }
 }


 /*
 $hashed_password = password_hash('', PASSWORD_DEFAULT);
var_dump($hashed_password);

if(password_verify('', $hashed_password)) {
    // If the password inputs matched the hashed password in the database
    // Do something, you know... log them in.
    echo 'Yipee';
} 
 */
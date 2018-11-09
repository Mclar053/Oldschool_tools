<?php


/**
 * Name: User Table
 * Author: Matthew Clark
 * Date: 09/11/2018
 */

 class UserTable extends Table
 {
    public function addUser(&$result)
    {
        $result = true;
        try {

        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }

    public function checkUser($username, $password, &$result)
    {
        $result = true;
        try {
            
        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }

    public function getRole(&$result)
    {
        $result = true;
        try{ 

        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }
 }
<?php

/**
 * Created by PhpStorm.
 * User: MatthewClark
 * Date: 01/04/2018
 * Time: 21:20
 */
class Table
{
    protected $db;

    public function __construct ( $db ) {
        $this->db = $db;
    }

    //Makes sql statements, prepares them and sends them to the database
    protected function makeStatement($sql, $data = NULL, $sqlType){
        try{
            $statement = $this->db->prepare($sql);
            $statement->execute( $data );

            //If the statement type is a retrieve
            if($sqlType === SQLType::Retrieve){
                //Checking if data is null so can return all entries or just 1
                if($data){
                    $model = $statement->fetchObject();
                }else{
                    $statement->setFetchMode(PDO::FETCH_OBJ);
                    $model=$statement->fetchAll();
                }
                return $model;
            }
            //If statement type is an insert
            else if($sqlType === SQLType::Insert){
                //Return the last inserted id
                return $this->db->lastInsertId();
            }
        }catch(Exception $e){
            $msg = "<p>You tried to run this sql: $sql<p>
                    <p>Exception: $e</p>";
            trigger_error($msg);
        }
    }


    /**
     * Inserts a row into the database of a specified table
     *
     * @param string $table
     * @param array $columns
     * @param array $data
     * @return mixed
     */
    public function insert($table, $columns, $data){

        if(sizeof($columns) === sizeof($data)){
            // Initialise the form data and sql string
            $sql =  "INSERT INTO ? ";
            $sql .= $this->_addSQLPlaceholder($columns); //Columns

            $sql .= "VALUES";
            $sql .= $this->_addSQLPlaceholder($data); //Data

            $formData =  array_merge(array($table), $columns, $data);

            return $this->makeStatement($sql, $formData, SQLType::Insert);
        }
        else{
            return false;
        }

    }

    public function update($table, $columns, $data, $whereCondition){

        if(sizeof($columns) === sizeof($data)){
            // Initialise the form data and sql string
            $sql =  "UPDATE ? ";
            $sql .= $this->_addSQLPlaceholder($columns); //Columns

            $sql .= "VALUES ";
            $sql .= $this->_addSQLPlaceholder($data); //Data

            $sql .= "WHERE ";
            $sql .= $whereCondition;

            $formData =  array_merge(array($table), $columns, $data);

            return $this->makeStatement($sql, $formData, SQLType::Insert);
        }
        else{
            return false;
        }
    }

    public function retrieve($table, $columns, $whereCondition){
        $sql =  "";
        $formData =  array();
        return $this->makeStatement($sql, $formData, SQLType::Insert);
    }

    public function delete($table, $whereCondition){
        $sql =  "";
        $formData =  array();
        return $this->makeStatement($sql, $formData, SQLType::Insert);
    }

    /**
     * @param array $columns
     * @return string
     */
    private function _addSQLPlaceholder($columns){
        $sqlString = "(";

        // Loop through all columns
        for($i = 0; $i< sizeof($columns); $i++){

            // Add placeholder
            $sqlString .= "?";

            //If the current position less than the length of the columns then add a comma
            if($i != sizeof($columns)-1){
                $sqlString .= ", ";
            }
        }

        $sqlString .= ")";

        return $sqlString;
    }
}

abstract class SQLType{
    const Retrieve = 0;
    const Insert = 0;
    const Update = 0;
    const Delete = 0;
}
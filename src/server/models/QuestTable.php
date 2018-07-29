<?php

include "Table.php";

/**
 * Created by PhpStorm.
 * User: MatthewClark
 * Date: 01/04/2018
 * Time: 21:25
 */
class QuestTable extends Table
{

    private $QUEST_TABLE_NAME = "QUESTS";
    private $QUEST_SKILL_REQUIREMENTS_TABLE_NAME = "QUESTSKILLREQUIREMENTS";
    private $QUEST_SKILL_REWARDS_TABLE_NAME = "QUESTSKILLREWARDS";

    /**
     * Adds quest with data inputted
     * 
     * @param array $questColumns Dictionary containing columns for different quest tables
     * @param array $questData Dictionary containing data for different quest tables
     * @return array
     */
    public function addQuest ( $questColumns, $questData ) {    
        
        

        $sql = "INSERT INTO QUESTS ( QUESTNAME, QUESTPOINTS, MEMBERS, DIFFICULTY, LENGTH, QUESTNUMBER )
                     VALUES ( ?, ?, ?, ?, ?, ?)";
        $data = array_merge(array( "QUESTS"), $questData );
        return $this->makeStatement($sql, $data);
    }

    //Delete entry by inputting id
    public function deleteQuest ($id){
        $sql = "DELETE FROM blog_entry WHERE blog_id = ?";
        $data = array($id);
        return $this->makeStatement($sql, $data);
    }

    //Update the entry from particular id of blog post
    public function updateQuest($id, $title, $entry){
        $sql = "UPDATE blog_entry SET blog_title = ?, blog_text = ? WHERE blog_id = ?";
        $data = array($title, $entry, $id);
        return $this->makeStatement($sql, $data);
    }

    //Get all entries from the blog_entry table
    public function getAllQuests(){
        $returnSQL = "SELECT * FROM QUESTS";
        return $this->makeStatement($returnSQL,null, 0);
    }

    //Get a particular entry from an id
    public function getQuest($id){
        $sql = "SELECT blog_id, blog_title, blog_text, blog_date FROM blog_entry WHERE blog_id = ?";
        $data = array($id);
        return $this->makeStatement($sql, $data);
    }

}
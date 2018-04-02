<?php

/**
 * Created by PhpStorm.
 * User: MatthewClark
 * Date: 01/04/2018
 * Time: 21:25
 */
class QuestTable extends Table
{

    private $QUEST_TABLE_NAME = "";
    private $QUEST_SKILL_REQUIREMENTS_TABLE_NAME = "";
    private $QUEST_SKILL_REWARDS_TABLE_NAME = "";

    //Save title and entry for the blog post in the database
    public function saveQuest ( $title, $entry ) {
        $sql = "INSERT INTO ? ( blog_title, blog_text )
                     VALUES ( ?, ?)";
        $data = array( $this->QUEST_TABLE_NAME, $title, $entry );
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
        $returnSQL = "SELECT blog_id, blog_title, SUBSTRING(blog_text, 1, 150) AS intro FROM blog_entry";
        return $this->makeStatement($returnSQL);
    }

    //Get a particular entry from an id
    public function getQuest($id){
        $sql = "SELECT blog_id, blog_title, blog_text, blog_date FROM blog_entry WHERE blog_id = ?";
        $data = array($id);
        return $this->makeStatement($sql, $data);
    }

}
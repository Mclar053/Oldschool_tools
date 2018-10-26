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
    /**
     * Adds quest with data inputted
     *
     * @param $questData Array dictionary containing all columns to be inserted to the QUESTS table
     * @param $questRequirements Array array of dictionaries containing all columns to be inserted to the QUESTQUESTREQUIREMENTS table
     * @param $skillRequirements Array array of dictionaries containing all columns to be inserted to the QUESTSKILLREQUIREMENTS table
     * @param $skillRewards Array array of dictionaries containing all columns to be inserted to the QUESTSKILLREWARDS table
     * @return mixed
     */
    public function addQuest ( $questData, $questRequirements, $skillRequirements, $skillRewards ) {

        try{
            // Begin the database transaction
            $this->db->beginTransaction();

            // QUESTS
            $sql = "INSERT INTO QUESTS ( QUESTNAME, QUESTPOINTS, MEMBERS, DIFFICULTY, LENGTH, QUESTNUMBER )
                     VALUES ( ?, ?, ?, ?, ?, ? )";
            $data = array(
                $questData["QUESTNAME"],
                $questData["QUESTPOINTS"],
                $questData["MEMBERS"],
                $questData["DIFFICULTY"],
                $questData["LENGTH"],
                $questData["QUESTNUMBER"]
            );
            $questID = $this->makeStatement($sql, $data, SQLType::Insert);

            echo $questID;
            echo $this->db->lastInsertId();

            // QUEST REQUIREMENTS
            foreach($questRequirements as $questReq){
                $sql = "INSERT INTO QUESTQUESTREQUIREMENTS ( QUESTID, REQUIREDQUESTID )
                     VALUES ( ?, ? )";
                $data = array(
                    $questID,
                    $questReq
                );
                $this->makeStatement($sql, $data, SQLType::Insert);
            }


            // SKILL REQUIREMENTS
            foreach($skillRequirements as $skillReq){
                $sql = "INSERT INTO QUESTSKILLREQUIREMENTS ( QUESTID, SKILLID, LEVEL, BOOSTABLE, COMMENT )
                     VALUES ( ?, ?, ?, ?, ? )";
                $data = array(
                    $questID,
                    $skillReq["SKILLID"],
                    $skillReq["LEVEL"],
                    $skillReq["BOOSTABLE"],
                    $skillReq["COMMENT"]
                );
                $this->makeStatement($sql, $data, SQLType::Insert);
          }


            // SKILL REQUIREMENTS
            foreach($skillRewards as $skillRew){
                $sql = "INSERT INTO QUESTSKILLREWARDS ( QUESTID, SKILLID, XPREWARD, CONDITIONAL, OPTIONAL, COMMENT )
                     VALUES ( ?, ?, ?, ?, ?, ?)";
                $data = array(
                    $questID,
                    $skillRew["SKILLID"],
                    $skillRew["XPREWARD"],
                    $skillRew["CONDITIONAL"],
                    $skillRew["OPTIONAL"],
                    $skillRew["COMMENT"]
                );
                $this->makeStatement($sql, $data, SQLType::Insert);
            }

            $this->db->commit();

            return true;
        }
        catch(Exception $e){
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return false;
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteQuest ($id){

        try{
            $this->db->beginTransaction();

            $sql = "DELETE FROM QUESTSKILLREWARDS WHERE QUESTID = ?";
            $data = array($id);
            $this->makeStatement($sql, $data);

            $sql = "DELETE FROM QUESTSKILLREQUIREMENTS WHERE QUESTID = ?";
            $data = array($id);
            $this->makeStatement($sql, $data);

            $sql = "DELETE FROM QUESTQUESTREQUIREMENTS WHERE QUESTID = ?";
            $data = array($id);
            $this->makeStatement($sql, $data);

            $sql = "DELETE FROM QUESTS WHERE QUESTID = ?";
            $data = array($id);
            $this->makeStatement($sql, $data);

            $this->db->commit();

            return true;
        } catch( Exception $e ){
            $this->db->rollback();
            echo $e;
            return false;
        }


    }

    /**
     * @param $id
     * @param $title
     * @param $entry
     * @return mixed
     */
    public function updateQuest($id, $title, $entry){
        $sql = "UPDATE blog_entry SET blog_title = ?, blog_text = ? WHERE blog_id = ?";
        $data = array($title, $entry, $id);
        return $this->makeStatement($sql, $data);
    }

    /**
     * Returns all quest details
     * @return mixed
     */
    public function getAllQuests(){
        $returnSQL = "
SELECT
    QUESTS.QUESTID AS QUESTID,
    QUESTS.QUESTNAME AS NAME,
    QUESTS.QUESTDESCRIPTION AS DESCRIPTION,
    QUESTS.DIFFICULTY AS DIFFICULTY,
    QUESTS.LENGTH AS LENGTH,
    QUESTS.MEMBERS AS MEMBERS,
    QUESTS.QUESTPOINTS AS QUESTPOINTS
FROM
  QUESTS";
        return $this->makeStatement($returnSQL,null, SQLType::Retrieve);
    }


    /**
     * Retrieves quest details of specified quest
     * @param $id Quest Id
     * @return mixed Datatable with the retrieved quest
     */
    public function retrieveQuestDetails($id){
        $sql = "
SELECT
    QUESTS.QUESTID AS QUESTID,
    QUESTS.QUESTNAME AS NAME,
    QUESTS.QUESTDESCRIPTION AS DESCRIPTION,
    QUESTS.DIFFICULTY AS DIFFICULTY,
    QUESTS.LENGTH AS LENGTH,
    QUESTS.MEMBERS AS MEMBERS,
    QUESTS.QUESTPOINTS AS QUESTPOINTS
FROM
  QUESTS
WHERE
  QUESTS.QUESTID = ?
";
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve, true);
    }

    /**
     * Retrieves all quest requirements for a specified quest
     * @param $id Quest Id
     * @return mixed Datatable with all quests required for the specified quest
     */
    public function retrieveQuestRequirements($id){
        $sql = "
SELECT
    current.QUESTID AS CURRENTQUESTID,
    required.QUESTID AS REQUIREDQUESTID,
    required.QUESTNAME AS NAME,
    required.QUESTDESCRIPTION AS DESCRIPTION,
    required.DIFFICULTY AS DIFFICULTY,
    required.LENGTH AS LENGTH,
    required.MEMBERS AS MEMBERS,
    required.QUESTPOINTS AS QUESTPOINTS
FROM
  QUESTS current
INNER JOIN
  QUESTQUESTREQUIREMENTS
  ON
    current.QUESTID = QUESTQUESTREQUIREMENTS.QUESTID
INNER JOIN
  QUESTS required
  ON
    QUESTQUESTREQUIREMENTS.REQUIREDQUESTID = required.QUESTID
WHERE
  current.QUESTID = ?
";
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve);
    }

    /**
     * Retrieves all skill requirements for a specified quest
     * @param $id Quest Id
     * @return mixed Datatable with all skill levels required for the specified quest
     */
    public function retrieveSkillRequirements($id){
        $sql = "
SELECT
    QUESTS.QUESTID AS CURRENTQUESTID,
    SKILLS.SKILLNAME AS SKILLNAME,
    QUESTSKILLREQUIREMENTS.LEVEL AS LEVEL,
    QUESTSKILLREQUIREMENTS.BOOSTABLE AS BOOSTABLE,
    QUESTSKILLREQUIREMENTS.COMMENT AS COMMENT
FROM
  QUESTS
INNER JOIN
  QUESTSKILLREQUIREMENTS
  ON
    QUESTS.QUESTID = QUESTSKILLREQUIREMENTS.QUESTID
INNER JOIN
  SKILLS
  ON
    QUESTSKILLREQUIREMENTS.SKILLID = SKILLS.SKILLID
WHERE
  QUESTS.QUESTID = ?
";
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve);
    }

    /**
     * Retrieves all skill rewards from a specified quest
     * @param $id Quest Id
     * @return mixed Datatable with all skill xp rewarded from the specified quest
     */
    public function retrieveSkillRewards($id){
        $sql = "
SELECT
    QUESTS.QUESTID AS CURRENTQUESTID,
    SKILLS.SKILLNAME AS SKILLNAME,
    QUESTSKILLREWARDS.XPREWARD AS XP,
    QUESTSKILLREWARDS.OPTIONAL AS OPTIONAL,
    QUESTSKILLREWARDS.CONDITIONAL AS CONDITIONAL,
    QUESTSKILLREWARDS.COMMENT AS COMMENT
FROM
  QUESTS
INNER JOIN
  QUESTSKILLREWARDS
  ON
    QUESTS.QUESTID = QUESTSKILLREWARDS.QUESTID
INNER JOIN
  SKILLS
  ON
    QUESTSKILLREWARDS.SKILLID = SKILLS.SKILLID
WHERE
  QUESTS.QUESTID = ?
";
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve);
    }

}
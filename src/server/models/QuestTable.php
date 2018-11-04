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
     * @param &$result States if any errors have occurred
     * @return $questID The Quest ID that has been inserted. If error has occurred, return null.
     */
    public function addQuest($questData, $questRequirements, $skillRequirements, $skillRewards, &$result)
    {
        $result = true;
        try {
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
                $questData["QUESTNUMBER"],
            );
            $questID = $this->makeStatement($sql, $data, SQLType::Insert, false, $result);

            echo $questID;
            echo $this->db->lastInsertId();

            if ($result) {
                // QUEST REQUIREMENTS
                foreach ($questRequirements as $questReq) {
                    $sql = "INSERT INTO QUESTQUESTREQUIREMENTS ( QUESTID, REQUIREDQUESTID )
                        VALUES ( ?, ? )";
                    $data = array(
                        $questID,
                        $questReq,
                    );
                    $this->makeStatement($sql, $data, SQLType::Insert, false, $result);
                }
            }

            if ($result) {
                // SKILL REQUIREMENTS
                foreach ($skillRequirements as $skillReq) {
                    $sql = "INSERT INTO QUESTSKILLREQUIREMENTS ( QUESTID, SKILLID, LEVEL, BOOSTABLE, COMMENT )
                        VALUES ( ?, ?, ?, ?, ? )";
                    $data = array(
                        $questID,
                        $skillReq["SKILLID"],
                        $skillReq["LEVEL"],
                        $skillReq["BOOSTABLE"],
                        $skillReq["COMMENT"],
                    );
                    $this->makeStatement($sql, $data, SQLType::Insert, false, $result);
                }
            }

            if ($result) {
                // SKILL REQUIREMENTS
                foreach ($skillRewards as $skillRew) {
                    $sql = "INSERT INTO QUESTSKILLREWARDS ( QUESTID, SKILLID, XPREWARD, CONDITIONAL, OPTIONAL, COMMENT )
                        VALUES ( ?, ?, ?, ?, ?, ?)";
                    $data = array(
                        $questID,
                        $skillRew["SKILLID"],
                        $skillRew["XPREWARD"],
                        $skillRew["CONDITIONAL"],
                        $skillRew["OPTIONAL"],
                        $skillRew["COMMENT"],
                    );
                    $this->makeStatement($sql, $data, SQLType::Insert, false, $result);
                }
            }

            if ($result) {
                $this->db->commit();
            } else {
                echo "Insert Quest Failed";
                $this->db->rollback();
            }

            return $questID;
        } catch (Exception $e) {
            echo "Rollback";
            $this->db->rollback();
            echo $e;
            return null;
        }
    }

    /**
     * @param $id
     * @param &$result States if any errors have occurred
     * @return mixed
     */
    public function deleteQuest($id, &$result)
    {

        try {
            $result = true;
            $this->db->beginTransaction();

            if ($result) {
                $sql = "DELETE FROM QUESTSKILLREWARDS WHERE QUESTID = ?";
                $data = array($id);
                $this->makeStatement($sql, $data, SQLType::Delete, false, $result);
            }

            if ($result) {
                $sql = "DELETE FROM QUESTSKILLREQUIREMENTS WHERE QUESTID = ?";
                $data = array($id);
                $this->makeStatement($sql, $data, SQLType::Delete, false, $result);
            }

            if ($result) {
                $sql = "DELETE FROM QUESTQUESTREQUIREMENTS WHERE QUESTID = ?";
                $data = array($id);
                $this->makeStatement($sql, $data, SQLType::Delete, false, $result);
            }

            if ($result) {
                $sql = "DELETE FROM QUESTS WHERE QUESTID = ?";
                $data = array($id);
                $this->makeStatement($sql, $data, SQLType::Delete, false, $result);
            }

            if ($result) {
                $this->db->commit();
            } else {
                echo "Delete Quest failed";
                $this->db->rollback();
            }

            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            echo $e;
            return false;
        }

    }

    /**
     * @param $id
     * @param $title
     * @param $entry
     * @param &$result States if any errors have occurred
     * @return mixed
     */
    public function updateQuest($id, $title, $entry, &$result)
    {
        $result = true;
        $sql = "UPDATE blog_entry SET blog_title = ?, blog_text = ? WHERE blog_id = ?";
        $data = array($title, $entry, $id);
        return $this->makeStatement($sql, $data, SQLType::Update, false, $result);
    }

    /**
     * Returns all quest details
     * @param &$result States if any errors have occurred
     * @return mixed
     */
    public function getAllQuests(&$result)
    {
        $returnSQL = "
SELECT
    QUESTS.QUESTID AS QUESTID,
    QUESTS.QUESTNAME AS NAME,
    QUESTS.QUESTDESCRIPTION AS DESCRIPTION,
    QUESTS.DIFFICULTY AS DIFFICULTY,
    QUESTS.LENGTH AS LENGTH,
    QUESTS.MEMBERS AS MEMBERS,
    QUESTS.QUESTPOINTS AS QUESTPOINTS,
    (CASE
        WHEN QUESTS.MEMBERS = 1 THEN 'Members'
        ELSE 'Free to Play' END) AS MEMBERSTEXT,
    (CASE
        WHEN QUESTS.LENGTH = 0 THEN 'Short'
        WHEN QUESTS.LENGTH = 1 THEN 'Medium'
        WHEN QUESTS.LENGTH = 2 THEN 'Long'
        WHEN QUESTS.LENGTH = 3 THEN 'Very Long'
        END) AS LENGTHTEXT,
    (CASE
        WHEN QUESTS.DIFFICULTY = 0 THEN 'Novice'
        WHEN QUESTS.DIFFICULTY = 1 THEN 'Intermediate'
        WHEN QUESTS.DIFFICULTY = 2 THEN 'Experienced'
        WHEN QUESTS.DIFFICULTY = 3 THEN 'Master'
        WHEN QUESTS.DIFFICULTY = 4 THEN 'Grandmaster'
        WHEN QUESTS.DIFFICULTY = 5 THEN 'Special'
        END) AS DIFFICULTYTEXT
FROM
  QUESTS";
        return $this->makeStatement($returnSQL, null, SQLType::Retrieve, false, $result);
    }

    /**
     * Retrieves quest details of specified quest
     * @param $id Quest Id
     * @param &$result States if any errors have occurred
     * @return mixed Datatable with the retrieved quest
     */
    public function retrieveQuestDetails($id, &$result)
    {
        $result = true;
        $sql = "
SELECT
    QUESTS.QUESTID AS QUESTID,
    QUESTS.QUESTNAME AS NAME,
    QUESTS.QUESTDESCRIPTION AS DESCRIPTION,
    QUESTS.DIFFICULTY AS DIFFICULTY,
    QUESTS.LENGTH AS LENGTH,
    QUESTS.MEMBERS AS MEMBERS,
    QUESTS.QUESTPOINTS AS QUESTPOINTS,
    (CASE
        WHEN QUESTS.MEMBERS = 1 THEN 'Members'
        ELSE 'Free to Play' END) AS MEMBERSTEXT,
    (CASE
        WHEN QUESTS.LENGTH = 0 THEN 'Short'
        WHEN QUESTS.LENGTH = 1 THEN 'Medium'
        WHEN QUESTS.LENGTH = 2 THEN 'Long'
        WHEN QUESTS.LENGTH = 3 THEN 'Very Long'
        END) AS LENGTHTEXT,
    (CASE
        WHEN QUESTS.DIFFICULTY = 0 THEN 'Novice'
        WHEN QUESTS.DIFFICULTY = 1 THEN 'Intermediate'
        WHEN QUESTS.DIFFICULTY = 2 THEN 'Experienced'
        WHEN QUESTS.DIFFICULTY = 3 THEN 'Master'
        WHEN QUESTS.DIFFICULTY = 4 THEN 'Grandmaster'
        WHEN QUESTS.DIFFICULTY = 5 THEN 'Special'
        END) AS DIFFICULTYTEXT
FROM
  QUESTS
WHERE
  QUESTS.QUESTID = ?
";
        $data = array($id);
        return $this->makeStatement($sql, $data, SQLType::Retrieve, true, $result);
    }

    /**
     * Retrieves all quest requirements for a specified quest
     * @param $id Quest Id
     * @param &$result States if any errors have occurred
     * @return mixed Datatable with all quests required for the specified quest
     */
    public function retrieveQuestRequirements($id, &$result)
    {
        $result = true;
        $sql = "
SELECT
    current.QUESTID AS CURRENTQUESTID,
    required.QUESTID AS REQUIREDQUESTID,
    required.QUESTNAME AS NAME,
    required.QUESTDESCRIPTION AS DESCRIPTION,
    required.DIFFICULTY AS DIFFICULTY,
    required.LENGTH AS LENGTH,
    required.MEMBERS AS MEMBERS,
    required.QUESTPOINTS AS QUESTPOINTS,
    (CASE
        WHEN required.MEMBERS = 1 THEN 'Members'
        ELSE 'Free to Play' END) AS MEMBERSTEXT,
    (CASE
        WHEN required.LENGTH = 0 THEN 'Short'
        WHEN required.LENGTH = 1 THEN 'Medium'
        WHEN required.LENGTH = 2 THEN 'Long'
        WHEN required.LENGTH = 3 THEN 'Very Long'
        END) AS LENGTHTEXT,
    (CASE
        WHEN required.DIFFICULTY = 0 THEN 'Novice'
        WHEN required.DIFFICULTY = 1 THEN 'Intermediate'
        WHEN required.DIFFICULTY = 2 THEN 'Experienced'
        WHEN required.DIFFICULTY = 3 THEN 'Master'
        WHEN required.DIFFICULTY = 4 THEN 'Grandmaster'
        WHEN required.DIFFICULTY = 5 THEN 'Special'
        END) AS DIFFICULTYTEXT
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
        return $this->makeStatement($sql, $data, SQLType::Retrieve, false, $result);
    }

    /**
     * Retrieves all skill requirements for a specified quest
     * @param $id Quest Id
     * @param &$result States if any errors have occurred
     * @return mixed Datatable with all skill levels required for the specified quest
     */
    public function retrieveSkillRequirements($id, &$result)
    {
        $result = true;
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
        return $this->makeStatement($sql, $data, SQLType::Retrieve, false, $result);
    }

    /**
     * Retrieves all skill rewards from a specified quest
     * @param $id Quest Id
     * @param &$result States if any errors have occurred
     * @return mixed Datatable with all skill xp rewarded from the specified quest
     */
    public function retrieveSkillRewards($id, &$result)
    {
        $result = true;
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
        return $this->makeStatement($sql, $data, SQLType::Retrieve, false, $result);
    }

}

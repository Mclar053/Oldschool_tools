USE oldschool_tools;
CREATE TABLE QUESTSKILLREQUIREMENTS(
  QUESTSKILLREQUIREMENTID     INT NOT NULL AUTO_INCREMENT,
  QUESTID                     INT NOT NULL,
  SKILLID                     INT NOT NULL,
  LEVEL                       INTEGER NOT NULL,
  BOOSTABLE                   BOOLEAN NULL,
  COMMENT                     NVARCHAR(1000) NULL,
  PRIMARY KEY (QUESTSKILLREQUIREMENTID),
  FOREIGN KEY (QUESTID) REFERENCES QUESTS(QUESTID),
  FOREIGN KEY (SKILLID) REFERENCES SKILLS(SKILLID)
);
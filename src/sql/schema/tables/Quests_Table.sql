CREATE TABLE QUESTS(
  QUESTID         INT NOT NULL AUTO_INCREMENT,
  QUESTNAME         NVARCHAR(50) NOT NULL,
  QUESTDESCRIPTION  NVARCHAR(500) NULL,
  QUESTPOINTS       INTEGER NULL,
  LOCX              INTEGER NULL,
  LOCY              INTEGER NULL,
  QUESTNUMBER       INTEGER NULL,
  PRIMARY KEY (QUESTID)
);
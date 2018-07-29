CREATE TABLE QUESTQUESTREQUIREMENTS(
  QUESTID                   INT NOT NULL, -- The quest which requires the quest
  REQUIREDQUESTID             INT NOT NULL, -- The quest that needs to be completed
  PRIMARY KEY (QUESTID, REQUIREDQUESTID)
);
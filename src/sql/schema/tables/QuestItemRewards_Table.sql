USE oldschool_tools;
CREATE TABLE QUESTITEMREWARDS(
  QUESTITEMREWARDID           INT NOT NULL AUTO_INCREMENT,
  QUESTID                     INT NOT NULL,
  ITEMID                      INT NOT NULL,
  AMOUNT                      INTEGER NULL,
  COMMENT                     NVARCHAR(1000),
  PRIMARY KEY (QUESTITEMREWARDID),
  FOREIGN KEY (QUESTID) REFERENCES QUESTS(QUESTID),
  FOREIGN KEY (ITEMID) REFERENCES ITEMS(ITEMID)
);
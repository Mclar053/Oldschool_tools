CREATE TABLE QUESTITEMREQUIREMENTS(
  QUESTITEMREQUIREMENTGUID    CHAR(38) NOT NULL,
  QUESTGUID                   CHAR(38) NOT NULL,
  ITEMGUID                    CHAR(38) NOT NULL,
  AMOUNT                      INTEGER NULL,
  OPTIONAL                    BOOLEAN NULL,
  PRIMARY KEY (QUESTITEMREQUIREMENTGUID),
  FOREIGN KEY (QUESTGUID) REFERENCES QUESTS(QUESTGUID),
  FOREIGN KEY (ITEMGUID) REFERENCES ITEMS(ITEMGUID)
);
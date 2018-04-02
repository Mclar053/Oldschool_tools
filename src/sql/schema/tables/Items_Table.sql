CREATE TABLE ITEMS(
  ITEMGUID          CHAR(38) NOT NULL,
  ITEMNAME          NVARCHAR(40) NOT NULL,
  ITEMDESCRIPTION   NVARCHAR(200) NULL,
  EXAMINETEXT       NVARCHAR(200) NULL,
  TRADEABLE         BOOLEAN NULL,
  PRIMARY KEY (ITEMGUID)
);
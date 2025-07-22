USE [bambi-bmi];
GO
CREATE TABLE [dbo].ms_numberJadwalImport (
    nomor           INT NOT NULL  DEFAULT 0 PRIMARY KEY,
);

INSERT INTO [dbo].ms_numberJadwalImport (nomor) VALUES (0);

CREATE TABLE  import_shipments (
    ItemNo           FLOAT NULL,
    supplier        VARCHAR(100) NOT NULL PRIMARY KEY,
    ready           DATETIME,
    etd             DATETIME,
    eta              DATETIME,
    status           text,
    user_input      VARCHAR(100) DEFAULT 'system',
    date_input       DATETIME DEFAULT GETDATE(),
    user_update      VARCHAR(100),
    date_update      DATETIME,
    user_finish VARCHAR(100),
    date_finish DATETIME,

);


ALTER TABLE import_shipments
ADD  user_finish VARCHAR(100),
date_finish DATETIME;
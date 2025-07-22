USE [bambi-bmi]
GO
/****** Object:  StoredProcedure [dbo].[USP_TamplilListJadwalImport]    Script Date: 7/22/2025 1:47:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[USP_TamplilListJadwalImport]
@status VARCHAR(1),
@tahun  int,
@userid VARCHAR(100)

AS

	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#temptess') 
    BEGIN
      DROP TABLE #temptess;
    END;

	CREATE TABLE  #temptess(
	ItemNo           FLOAT NULL,
    supplier        VARCHAR(100),
    ready           DATETIME,
    etd             DATETIME,
    eta              DATETIME,
    status           VARCHAR(3000),
    user_input      VARCHAR(100)
	);
BEGIN

	IF(@status ='Y')
		BEGIN
			INSERT INTO #temptess
			SELECT ItemNo,supplier,ready,etd,eta,status,user_input
			FROM  [bambi-bmi].[dbo].import_shipments  WHERE YEAR(date_input) =@tahun AND  date_finish IS NULL ORDER BY ItemNo ASC  ;
		END
	  ELSE
		BEGIN
			INSERT INTO #temptess
			SELECT ItemNo,supplier,ready,etd,eta,status,user_input
			FROM  [bambi-bmi].[dbo].import_shipments  WHERE YEAR(date_input)=@tahun  AND  user_input=@userid AND  date_finish IS NULL ORDER BY ItemNo ASC ;
	 	END

		SELECT * FROM #temptess
END



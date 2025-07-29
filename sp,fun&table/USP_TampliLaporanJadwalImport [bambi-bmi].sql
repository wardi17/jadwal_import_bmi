USE [bambi-bmi]
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[USP_TampliLaporanJadwalImport]
	@jadwal NVARCHAR(50),
	@status_kirim NVARCHAR(50),
	@tgl_from DATETIME,
	@tgl_to DATETIME
AS
BEGIN
	SET NOCOUNT ON;

	SELECT 
		ItemNo,
		supplier,
		ready,
		etd,
		eta,
		CAST(status AS VARCHAR(3000)) AS status,
		date_finish
	FROM [bambi-bmi].[dbo].[import_shipments]
	WHERE
		-- Filter status kirim berdasarkan date_finish
		(
			@status_kirim = 'ALL'
			OR 
			(@status_kirim = 'Selesai' AND date_finish IS NOT NULL)
			OR 
			(@status_kirim = 'Belum Selesai' AND date_finish IS NULL)
		)
		AND
		-- Filter jadwal berdasarkan kolom tanggal
		(
			@jadwal = 'ALL'
			OR 
			(@jadwal = 'Ready' AND ready BETWEEN @tgl_from AND @tgl_to)
			OR 
			(@jadwal = 'ETD' AND etd BETWEEN @tgl_from AND @tgl_to)
			OR 
			(@jadwal = 'ETA' AND eta BETWEEN @tgl_from AND @tgl_to)
		)
	

	ORDER BY ItemNo ASC
END
GO

EXEC  USP_TampliLaporanJadwalImport 'ALL', 'ALL', '2025-07-01', '2025-07-22 23:59:59'
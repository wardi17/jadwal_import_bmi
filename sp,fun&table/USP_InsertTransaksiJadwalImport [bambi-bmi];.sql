USE [bambi-bmi];
GO

SET ANSI_NULLS ON;
GO
SET QUOTED_IDENTIFIER ON;
GO

-- =============================================
-- Author: Kamu
-- Create date: 24 Mei 2024
-- Description: Insert data ke import_shipments
-- =============================================
ALTER PROCEDURE [dbo].[USP_InsertTransaksiJadwalImport]
    @supplier VARCHAR(100),
    @ready DATETIME,
    @etd DATETIME,
    @eta DATETIME,
    @ket VARCHAR(100),
    @userid VARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @noumer INT;

    -- Ambil nomor terakhir dari tabel ms_numberJadwalImport
    SELECT @noumer = nomor FROM ms_numberJadwalImport;

    -- Misalnya ambil dari tabel
    SELECT @noumer = nomor FROM ms_numberJadwalImport;

    IF @noumer IS NOT NULL AND @noumer <> 0
        SET @noumer = @noumer + 1;
    ELSE
        SET @noumer = 1;

    -- Lakukan insert ke import_shipments
    INSERT INTO import_shipments (
        ItemNo,
        supplier,
        ready,
        etd,
        eta,
        status,
        user_input
    )
    VALUES (
        @noumer,
        @supplier,
        @ready,
        @etd,
        @eta,
        @ket,
        @userid 
    );

    -- (Opsional) Update nomor ke berikutnya
    UPDATE ms_numberJadwalImport SET nomor = nomor + 1;
END;
GO

/*EXEC dbo.USP_InsertTransaksiJadwalImport
    @supplier = 'TES',
    @ready = '2025-07-21 11:33:16',
    @etd = '2025-07-21 11:33:16',
    @eta = '2025-07-21 11:33:16',
    @ket = 'Test kiriman pertama',
    @userid = 'wardi';*/




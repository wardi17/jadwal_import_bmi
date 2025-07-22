<?php

class TransaksiModel extends Models
{

    protected $table_trs = "[bambi-bmi].[dbo].import_shipments";



    public function SaveData()
    {


        // Decode JSON ke array
        $rawData = file_get_contents("php://input");

        $post = json_decode($rawData, true);

        $supplier  = $this->test_input($post["supplier"]);
        $ready     = $this->setdate($this->test_input($post["ready"]));
        $etd       = $this->setdate($this->test_input($post["etd"]));
        $eta       = $this->setdate($this->test_input($post["eta"]));
        $ket       = $this->test_input($post["status"]);
        $userid    = $this->test_input($post["userid"]);




        $query = "USP_InsertTransaksiJadwalImport '{$supplier}','{$ready}','{$etd}','{$eta}','{$ket}','{$userid}'";

        //$this->consol_war($query);
        $result = $this->db->baca_sql2($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Tambah";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Tambah";
        }
    }


    protected function setdate($tanggal)
    {
        if (empty($tanggal)) {
            return null; // Return null if the date is empty
        }

        $tanggalObj = DateTime::createFromFormat("d/m/Y", $tanggal);
        $tanggal_sql = $tanggalObj->format(("Y-m-d"));
        $waktu = date("H:i:s");
        return $tanggal_sql . " " . $waktu;
    }





    public function ListData()
    {
        try {
            $rawData = file_get_contents("php://input");

            $post = json_decode($rawData, true);
            $userid = $this->test_input($post["userid"]);


            $status = ($userid == "wardi" || $userid == "herman" || $userid == "weelan") ? "Y" : "N";
            $tahun  = $this->test_input($post["tahun"]);
            $level_posting = ($userid == "wardi" || $userid == "herman" || $userid == "weelan") ? "Y" : "N";

            // Siapkan query SQL

            $query = "USP_TamplilListJadwalImport '{$status}','{$tahun}','{$userid}'";
            $result = $this->db->baca_sql2($query);

            if (!$result) {
                throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
            }

            $datas = [];
            while (odbc_fetch_row($result)) {
                $ItemNo      = rtrim(odbc_result($result, 'ItemNo'));
                $readyRaw    = odbc_result($result, 'ready');
                $etdRaw      = odbc_result($result, 'etd');
                $etaRaw      = odbc_result($result, 'eta');
                $supplier    = rtrim(odbc_result($result, 'supplier'));
                $status      = rtrim(odbc_result($result, 'status'));
                $user_input  = rtrim(odbc_result($result, 'user_input'));

                $ready = $this->formatDate($readyRaw);
                $etd   =  $this->formatDate($etdRaw);
                $eta   =  $this->formatDate($etaRaw);


                $datas[] = [
                    "ItemNo"      => $ItemNo,
                    "ready"       => $ready,
                    "supplier"    => $supplier,
                    "user_input"  => $user_input,
                    "status"      => $status,
                    "etd"         => $etd,
                    "eta"         => $eta,
                ];
            }

            return $datas;
        } catch (Exception $e) {
            // Catat error log untuk debug
            error_log("Error in GetKatgori: " . $e->getMessage());

            // Kembalikan array kosong jika gagal
            return [];
        }
    }


    protected function formatDate($dateRaw, $format = 'd-m-y')
    {


        $dateRaw = rtrim($dateRaw);
        if ($dateRaw === '1900-01-01 00:00:00.000') {
            return '-';
        }
        return date_format(new DateTime($dateRaw), $format);
    }


    public function getById($id)
    {
        $query = "SELECT * FROM $this->table_trs  WHERE supplier ='{$id}'";
        $result = $this->db->baca_sql2($query);
        if (!$result) {
            throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
        }

        $datas = [];
        while (odbc_fetch_row($result)) {
            $ItemNo        = rtrim(odbc_result($result, 'ItemNo'));
            $ready       = new DateTime(rtrim(odbc_result($result, 'ready')));
            $supplier    = rtrim(odbc_result($result, 'supplier'));
            $status  = rtrim(odbc_result($result, 'status'));
            $eta             = new DateTime(rtrim(odbc_result($result, "eta")));
            $etd             = new DateTime(rtrim(odbc_result($result, "etd")));
            $datas = [
                "ItemNo"   => $this->cleanTrailingZero($ItemNo),
                "ready"       => date_format($ready, "d-m-Y"),
                "supplier"    => $supplier,
                "status"      => $status,
                "etd"       => date_format($etd, "d-m-Y"),
                "eta"       => date_format($eta, "d-m-Y"),

            ];
        }

        //$this->consol_war($datas);
        return $datas;
    }

    private function cleanTrailingZero($numberStr)
    {
        return rtrim(rtrim($numberStr, '0'), '.');
    }


    //proses posting 
    public function PostingData()
    {
        $inputJSON = $_POST["datahider"];
        $post = json_decode($inputJSON, true);
        $ItemNo           = $this->test_input($post["ItemNo"]);
        $ID_document      = $this->test_input($post["ID_document"]);
        $userid = $_SESSION['login_user'];
        $dataposting =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs  SET FlagPosting='Y', UserPosting='{$userid}', DatePosting='{$dataposting}' 
            WHERE  ItemNo ='{$ItemNo}' AND ID_document='{$ID_document}' ";

        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Posting";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Posting";
        }

        return $status;
    }

    //and proses posting




    public function StatusPrint()
    {
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);

        $ItemNo           = $this->test_input($post["ItemNo"]);
        $userid           = $this->test_input($post["userid"]);
        $dateprint        =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs  SET FlagPrint='Y', UserPrint='{$userid}', DatePrint='{$dateprint}' 
            WHERE  ItemNo ='{$ItemNo}' ";

        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            return $this->ListData();
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Posting";

            return $status;
        }
    }



    public function ListPosted()
    {
        try {
            $rawData = file_get_contents("php://input");

            $post = json_decode($rawData, true);
            $userid = $this->test_input($post["userid"]);
            $status = ($userid == "wardi" || $userid == "herman") ? "Y" : "N";
            $tahun  = $this->test_input($post["tahun"]);

            // Siapkan query SQL

            $query = "USP_TamplilListPostedForwaderImport '{$status}','{$tahun}','{$userid}'";
            $result = $this->db->baca_sql2($query);

            if (!$result) {
                throw new Exception("Query execution failed: " . odbc_errormsg($this->db));
            }

            $datas = [];
            while (odbc_fetch_row($result)) {
                $ItemNo        = rtrim(odbc_result($result, 'ItemNo'));
                $Tanggal       = new DateTime(rtrim(odbc_result($result, 'Tanggal')));
                $forwaderid    = rtrim(odbc_result($result, 'forwaderid'));
                $pc            = rtrim(odbc_result($result, 'pc'));
                $importer      = rtrim(odbc_result($result, "importer"));
                $jenisbarang   = rtrim(odbc_result($result, "jenisbarang"));
                $userinput   = rtrim(odbc_result($result, "userinput"));
                $FlagPosting  = rtrim(odbc_result($result, "FlagPosting"));
                $FlagPrint    = rtrim(odbc_result($result, "FlagPrint"));

                $datas[] = [
                    "ItemNo"        => $ItemNo,
                    "Tanggal"       => date_format($Tanggal, "d-m-y"),
                    "forwaderid"    => $forwaderid,
                    "pc"            => $pc,
                    "importer"      => $importer,
                    "jenisbarang"   => $jenisbarang,
                    "userinput"     => $userinput,
                    "FlagPosting"   => $FlagPosting,
                    "FlagPrint"     => $FlagPrint,
                    "status"        => $status,

                ];
            }
            // $this->consol_war($datas);
            return $datas;
        } catch (Exception $e) {
            // Catat error log untuk debug
            error_log("Error in GetKatgori: " . $e->getMessage());

            // Kembalikan array kosong jika gagal
            return [];
        }
    }

    public function UpdateData()
    {

        // Decode JSON ke array
        $rawData = file_get_contents("php://input");

        $post = json_decode($rawData, true);

        $supplier  = $this->test_input($post["supplier"]);
        $ready     = $this->setdate($this->test_input($post["ready"]));
        $etd       = $this->setdate($this->test_input($post["etd"]));
        $eta       = $this->setdate($this->test_input($post["eta"]));
        $ket       = $this->test_input($post["status"]);
        $userid    = $this->test_input($post["userid"]);
        $ItemNo    =  $this->test_input($post["ItemNo"]);
        $date_update        =  date('Y-m-d H:i:s');

        $query = "UPDATE $this->table_trs SET ItemNo='{$ItemNo}',
            ready='{$ready}', etd='{$etd}', eta='{$eta}', status='{$ket}', user_update='{$userid}', date_update='{$date_update}' 
            WHERE supplier='{$supplier}'";
        $result = $this->db->baca_sql($query);
        $cek = 0;
        if (!$result) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Update";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Update";
        }
        return $status;
    }




    public function DeleteData()
    {
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);
        $supplier = $this->test_input($post["supplier"]);


        $query2 = "DELETE  FROM $this->table_trs  WHERE supplier='{$supplier}'";
        $result2 =  $this->db->baca_sql2($query2);
        $cek = 0;
        if (!$result2) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Dihapus";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Dihapus";
        }
        return $status;
    }


    public function FinishData()
    {
        $rawData = file_get_contents("php://input");
        $post = json_decode($rawData, true);
        $supplier = $this->test_input($post["supplier"]);
        $tanggalfinish = $this->setdate($this->test_input($post["tanggalfinish"]));
        $userid = $this->test_input($post["userid"]);

        $query2 = "UPDATE $this->table_trs SET date_finish='{$tanggalfinish}', user_finish='{$userid}' 
            WHERE supplier='{$supplier}'";
        $result2 =  $this->db->baca_sql2($query2);
        $cek = 0;
        if (!$result2) {
            $cek = $cek + 1;
        }
        if ($cek == 0) {
            $status['nilai'] = 1; //bernilai benar
            $status['error'] = "Data Berhasil Selesai";
        } else {
            $status['nilai'] = 0; //bernilai benar
            $status['error'] = "Data Gagal Selesai";
        }
        return $status;
    }
}

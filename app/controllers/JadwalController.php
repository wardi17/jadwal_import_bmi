<?php
class JadwalController extends Controller
{

    private $model;
    private $model_ts;

    protected $datajadwal = [
        ["id" => 1, "code" => "ALL"],
        ["id" => 2, "code" => "Ready"],
        ["id" => 3, "code" => "ETD"],
        ["id" => 4, "code" => "ETA"],
    ];

    protected $status = [
        ["id" => 1, "code" => "ALL"],
        ["id" => 2, "code" => "Selesai"],
        ["id" => 3, "code" => "Belum Selesai"],
    ];

    public function __construct()
    {
        $this->model_ts = $this->model("TransaksiModel");
    }


    public function getdetail()
    {


        try {
            $data = $this->model->getDataDetail(); // Assuming this method exists in your model
            // Check if data is empty
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }

            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }







    //simpant data import forwader

    public function SaveData()
    {


        try {


            // Retrieve data from the model
            $data = $this->model_ts->SaveData(); // Assuming this method exists in your model
            // Check if data is empty
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }

            // Send the data as a JSON response
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in ForwaderController::savedata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
    //and


    public function ListData()
    {

        try {
            $data = $this->model_ts->ListData(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }


    //untuposting data 


    public function PostingData()
    {
        try {
            // Retrieve data from the model
            $data = $this->model_ts->PostingData(); // Assuming this method exists in your model
            // Check if data is empty
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }

            // Send the data as a JSON response
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in ForwaderController::savedata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }


    public function StatusPrint()
    {
        try {
            $data = $this->model_ts->StatusPrint(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }

            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }



    //tampil list postid
    public function listposted()
    {
        try {
            $data = $this->model_ts->ListPosted(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
    //untuk updatedata
    public function UpdateData()
    {
        try {
            $data = $this->model_ts->UpdateData(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }


    public function DeleteData()
    {
        try {
            $data = $this->model_ts->DeleteData(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
    public function FinishData()
    {
        try {
            $data = $this->model_ts->FinishData(); // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
    public function getjadwal()
    {
        try {
            $data = $this->datajadwal; // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
    public function getStatus()
    {
        try {
            $data = $this->status; // Assuming this method exists in your model
            if (empty($data)) {
                $this->sendJsonResponse([], 200); // Return an empty array if no data found
                return;
            }
            $this->sendJsonResponse($data, 200);
        } catch (Throwable $e) {
            error_log('Error in InventarisController::listdata: ' . $e->getMessage());
            $this->sendErrorResponse('Internal server error', 500);
        }
    }
}

import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class Simpdatdata {
    constructor() {
    //if (!uploadedFiles) return;
        this.saveData();
    }

    saveData() {
        const supplier  = $("#supplier").val();
        const ready     = $("#ready").val();
        const etd       = $("#etd").val();
        const eta       = $("#eta").val();
        const status    = $("#status").val();
       const userid   = $("#username").val();
     
 
       

       


        const datas ={
            
            "supplier":supplier,
            "etd"     :etd,
            "eta"     :eta,
            "status"  :status,
            "userid"  :userid,
            "ready"   :ready,
        }

   
       this.prosesSave(datas);

    }

    validateField(value, fieldSelector, errorSelector, errorMessage) {
        if (!value) {
            $(errorSelector).text(errorMessage);
            $(fieldSelector).focus();
            return false;
        } else {
            $(errorSelector).text("");
            return true;
        }
    }


        prosesSave(datas) {
        // Tampilkan loading SweetAlert
        Swal.fire({
            title: "Menyimpan Data...",
            text: "Harap tunggu sebentar",
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading();
            }
        });

    
        // Kirim AJAX request
        $.ajax({
            url: `${baseUrl}/router/seturl`,
            method: 'POST',
             headers: {
                "url": "jwl/savedata"
            },
            data:JSON.stringify(datas),
            dataType: 'json',
            success: function(result) {
            Swal.close(); // Tutup loading
            console.log("Respon dari server:", result);

            const nilai = result.nilai;
            const pesan = result.error;

            if (nilai == 0) {
                Swal.fire({
                icon: "info",
                title: pesan || "Gagal menyimpan",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil disimpan",
                showConfirmButton: false,
                timer: 3000
                }).then(() => {
                goBack(); // Fungsi kembali halaman, jika ada
                });
            }
            },
            error: function(xhr, status, error) {
            Swal.close(); // Tutup loading
            console.error("AJAX Error:", error);
            Swal.fire({
                icon: "error",
                title: "Gagal Simpan Data!",
                text: "Supplier sudah ada, silahkan ganti supplier lain!",
            });
            }
        });
        }


}

export default Simpdatdata;

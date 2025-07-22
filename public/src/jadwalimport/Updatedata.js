import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class Updatedata {
    constructor() {
       this.putData();
    }

    putData() {
        const supplier  = $("#supplier").val();
        const ready     = $("#ready").val();
        const etd       = $("#etd").val();
        const eta       = $("#eta").val();
        const status    = $("#status").val();
        const userid   = $("#username").val();
        const ItemNo   = $("#ItemNo").val();


   const datas ={
            
            "supplier":supplier,
            "etd"     :etd,
            "eta"     :eta,
            "status"  :status,
            "userid"  :userid,
            "ready"   :ready,
            "ItemNo"  :ItemNo
        }
 

        

      
       this.prosesUpdate(datas);

    }
getAttachedFileNames() {
  const container = document.getElementById('tampil_attach');
  const fileLinks = container.querySelectorAll('a.text-decoration-none');

  const fileNames = Array.from(fileLinks).map(link => link.textContent.trim());

  return fileNames;
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


        prosesUpdate(datas) {
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
                "url": "jwl/updatedata"
            },
            data: JSON.stringify(datas),
            processData: false,        // Penting: Jangan proses FormData
            contentType: false,        // Penting: Biar browser set otomatis
            dataType: 'json',
            success: function(result) {
            Swal.close(); // Tutup loading
            console.log("Respon dari server:", result);

            const nilai = result.nilai;
            const pesan = result.error;

            if (nilai == 0) {
                Swal.fire({
                icon: "info",
                title: pesan || "Gagal mengupdate",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil diUpdate",
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
                title: "Gagal Update Data!",
                text: "Cek koneksi internet atau coba beberapa saat lagi."
            });
            }
        });
        }


}

export default Updatedata;

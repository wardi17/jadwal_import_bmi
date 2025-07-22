import { baseUrl } from "../config.js";
import {goBack} from "./main.js";
class FinishData {
    constructor() {
      
       this.finishData();
    }

    finishData() {
       
        const supplier    = $("#supplier").val();
        const tanggalfinish = $("#tanggalfinish").val();
        const userid   = $("#username").val();
        const datas ={
            "supplier"    :supplier,
            "tanggalfinish": tanggalfinish,
            "userid"      :userid

        }
       this.prosesfinishData(datas)

    }



 


        prosesfinishData(datas) {
        // Tampilkan loading SweetAlert
        Swal.fire({
            title: "Loading Data...",
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
                "url": "jwl/finishdata"
            },
            data: JSON.stringify(datas),
            dataType: 'json',
            success: function(result) {
            Swal.close(); // Tutup loading
            console.log("Respon dari server:", result);

            const nilai = result.nilai;
            const pesan = result.error;

            if (nilai == 0) {
                Swal.fire({
                icon: "info",
                title: pesan || "Gagal proses finish data",
                showConfirmButton: true
                });
            } else {
                Swal.fire({
                icon: "success",
                title: pesan || "Berhasil proses finish data",
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
                title: "Gagal selesai Data!",
                text: "Cek koneksi internet atau coba beberapa saat lagi."
            });
            }
        });
        }


}

export default FinishData;

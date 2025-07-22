<?php


?>
<style>
  #thead {
    background-color: #E7CEA6 !important;
    /* font-size: 8px;
        font-weight: 100 !important; */
    /*color :#000000 !important;*/
  }

  .table-hover tbody tr:hover td,
  .table-hover tbody tr:hover th {
    background-color: #F3FEB8;
  }

  /* .table-striped{
      background-color:#E9F391FF !important;
    } */
  .dataTables_filter {
    padding-bottom: 20px !important;
  }

  #frompacking {
    width: 100%;
    height: 2% !important;
    margin: 0 auto;
  }

  .card {
    border: none !important;
    border-top: 1px !important;
    /* Garis horizontal */
    margin: 1px 0 !important;
    /* Jarak atas dan bawah */
  }
</style>
<div id="main">
  <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  <div class="col-md-12 col-12">
    <div class="card">
      <div class="card-body">
        <div class="page-heading mb-3">
          <div class="page-title">

            <!-- <h6>Hari : <span id="harikerja"></span></h6> -->
          </div>
        </div>
        <div id="filterdata" class="row col-md-12">
          <input type="hidden" id="usernama" class="form-control" value="<?= trim($data["userid"]) ?>">
          <div class="row col-md-4" style="width:18%;">
            <label style="width:30%;" for="selectjadwal" class="col-sm-2 col-form-label">Jadwal</label>
            <div class="col-sm-8">
              <select class="form-control" id="selectjadwal"></select>
            </div>
          </div>
          <div class="row col-md-4" style="width:18%;">
            <label style="width:30%;" for="selectstatus" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-8">
              <select class="form-control" id="selectstatus"></select>
            </div>
          </div>
          <div style="width:19%;" class="row col-md-4">
            <label style="width:30%;" class="col-sm-2 col-form-label">From</label>
            <div style="width:70%;" class="col-md-6">
              <input type="date" class=" form-control" id="tgl_from" name="tgl_from">
            </div>
          </div>

          <div style="width:19%;" class="row col-md-4">
            <label style="width:25%;" class="col-sm-2 col-form-label">To</label>
            <div style="width:70%;" class="col-md-6">
              <input type="date" class=" form-control" id="tgl_to" name="tgl_to">
            </div>
          </div>

          <div style="width:10%;" class="col-sm-2">
            <button type="submit" name="submit" class="submit btn btn-primary me-1 mb-3" id="Createdata">Submit</button>
          </div>
        </div>

        <div id="tabellist" class="mt-4"></div>

      </div>

    </div>
  </div>
</div>
</div>

<script>
  $(document).ready(function() {
    gettanggal();
    getDataJadwal();
    getDataStatus();
    const userid = $(" #usernama").val();
    let datas = {
      "userid": userid
    }
    $("#Createdata").on("click", function(event) {
      event.preventDefault();
      let tgl_to = $("#tgl_to").val();
      let tgl_from = $("#tgl_from").val();
      const jadwal = $("#selectjadwal").val();
      const status = $("#selectstatus").val();
      let datas = {
        "tgl_from": tgl_from,
        "tgl_to": tgl_to,
        "userid": userid,
        "jadwal": jadwal,
        "status": status
      }


      getData(datas);
    });


    $(document).on("click", "#printBtn", function() {
      $("#filterdata").hide();
      $("#printBtn").hide();
      $("#footerid").hide();

      const date_to = $("#tgl_from").val();
      let splite = date_to.split("/");


      let tgl = splite[0];
      let bln = splite[1];
      let thn = splite[2];
      let bln_indo = convertnamabulan(bln);


      let judul = 'IMPORT BMI tgl' + ' ' + tgl + ' ' + bln_indo + ' ' + thn;


      document.title = judul;
      window.print();
      showtombol();

    });

  }) //document ready

  convertnamabulan = (englishMonth) => {
    const monthMapping = {
      "01": "Januari",
      "02": "Februari",
      "03": "Maret",
      "04": "April",
      "05": "Mei",
      "06": "Juni",
      "07": "Juli",
      "08": "Agustus",
      "09": "September",
      "10": "Oktober",
      "11": "November",
      "12": "Desember"
    };

    return monthMapping[englishMonth] || "Bulan tidak valid";
  }

  function showtombol() {
    $("#filterdata").show();
    $("#printBtn").show();
    $("#footerid").show();
    $("#dateprint").hide();
    document.title = "Jadwal Import bmi";
  }

  function getDataJadwal() {
    $.ajax({
      url: "<?= base_url ?>/router/seturl",
      method: "POST",
      dataType: "json",
      headers: {
        'url': 'jwl/getjadwal'
      },
      success: function(result) {
        const data_result = result.data;
        let options = `<option disabled value="">Pilih Jadwal</option>`;
        $.each(data_result, function(a, b) {
          options += `<option value="${b.code}">${b.code}</option>`;
        });
        $("#selectjadwal").empty().html(options);
      }
    });
  }

  function getDataStatus() {
    $.ajax({
      url: "<?= base_url ?>/router/seturl",
      method: "POST",
      dataType: "json",
      headers: {
        'url': 'jwl/getstatus'
      },
      success: function(result) {

        const data_result = result.data;
        let options = `<option disabled value="">Pilih Status</option>`;
        $.each(data_result, function(a, b) {
          options += `<option value="${b.code}">${b.code}</option>`;
        });
        $("#selectstatus").empty().html(options);
      }
    });
  }

  function gettanggal() {
    let currentDate = new Date();
    // Mengatur tanggal pada objek Date ke 1 untuk mendapatkan awal bulan
    currentDate.setDate(1);
    // Membuat format tanggal YYYY-MM-DD
    let tgl_from = currentDate.toISOString().slice(0, 10);
    let id_from = "tgl_from";
    // Menampilkan hasil


    let d = new Date();
    let month = d.getMonth() + 1;
    let day = d.getDate();
    let tgl_to = d.getFullYear() + '-' +
      (month < 10 ? '0' : '') + month + '-' +
      (day < 10 ? '0' : '') + day;

    let id_tgl_to = "tgl_to";
    SetTanggal(id_from, tgl_from)
    SetTanggal(id_tgl_to, tgl_to)



  }

  SetTanggal = (id, tanggal) => {

    let setid = "#" + id;
    flatpickr(setid, {
      dateFormat: "d/m/Y", // Format yang diinginkan
      allowInput: true, // Memungkinkan input manual
      defaultDate: new Date(tanggal)
    });

  }

  function getData(datas) {

    $.ajax({
      url: "<?= base_url ?>/router/seturl",
      data: JSON.stringify(datas),
      method: "POST",
      dataType: "json",
      headers: {
        'url': 'lap/getlaporan'
      },
      success: function(result) {
        const data_result = result.data;

        Set_Tabel(data_result);

      }
    });
  }

  function Set_Tabel(data_result) {
    let datatabel = `
            <style>
              #tabel1 {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
              }

              #printdate {
              font-size: 12px;
      }
              #tabel1 th,
              #tabel1 td {
                border: 1px solid #000;
                padding: 4px;
              }


              #tabel1 thead th {
                background-color: #F5CBCB;
                /* Warna oranye */
              }

              h3.title {
                text-align: center;
                margin-bottom: 20px;
              }

              .header-bar {
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-bottom: 10px;
              font-size: 14px;
            }

            .header-bar .title {
              flex: 1;
              font-weight: bold;
              text-align: center;
            }

            .header-bar .print-btn {
              flex: 1;
              text-align: left;
            }

            .header-bar .printdate {
              flex: 1;
              text-align: right;
              font-style: italic;
            }
            }
            </style>

           <div class="header-bar">
            <div class="print-btn">
                <button id="printBtn">🖨️ Print</button>
              </div>
              <div class="title">
                <h5>UPDATE IMPORT BMI/BMN</h5>
              </div>
             <div class="printdate">
            
              </div>
            </div>

            <table id="tabel1">
              <thead>
                <tr>
                  <th style="width: 2%;" rowspan="2" class="text-center">No</th>
                  <th style="width: 10%;" rowspan="2" class="text-center">SUPPLIER</th>
                  <th style="width: 85%;" colspan="4" class="text-center">JADWAL</th>
                </tr>
                <tr>
                  <th style="width: 15%;">READY</th>
                  <th style="width: 15%;">ETD</th>
                  <th style="width: 15%;">ETA</th>
                  <th style="width: 30%;">STATUS</th>
                </tr>
              </thead>
              <tbody>
                `;

    let no = 1;
    $.each(data_result, function(i, item) {
      datatabel += `
                <tr>
                  <td class="text-center">${no++}</td>
                  <td>${item.supplier ?? ''}</td>
                  <td>${item.ready ?? ''}</td>
                  <td>${item.etd ?? ''}</td>
                  <td>${item.eta ?? ''}</td>
                  <td>${item.status ?? ''}</td>
                </tr>
                `;
    });

    datatabel += `
              </tbody>
            </table>
               <div id="printdate" class="text-end">
                PrintDate : <span id="clock"></span>
              </div>
            `;

    $("#tabellist").html(datatabel);
    updateClock(); // Update immediately
    setInterval(updateClock, 1000);
  }

  updateClock = () => {
    const now = new Date();
    const day = now.getDate().toString().padStart(2, '0');
    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
    const year = now.getFullYear();

    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    const formattedDate = `${day}-${month}-${year}`;
    const formattedTime = `${hours}:${minutes}:${seconds}`;
    $('#clock').text(`${formattedDate} ${formattedTime}`);
  }
</script>
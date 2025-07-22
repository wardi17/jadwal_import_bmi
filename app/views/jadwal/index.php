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

  form {
    width: 100%;
    height: 2% !important;
    margin: 0 auto;
  }
</style>
<div id="main">
  <header class="mb-3">
    <input type="hidden" id="usernama" class="form-control" value="<?= trim($data["userid"]) ?>">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  <!-- Content Header (Page header) -->
  <div class="col-md-12 col-12">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h5 class="text-center"> List Forwader Import</h5>
      </div>
      <div class="card-body">
        <div class="row col-md-12 col-12">
          <!-- <h3 class="text-center">Target upload</h3> -->

          <div class="col-md-8">
            <form id="form_filter">
              <div class=" row col-md-8">
                <div style="width:25%;" class="col-md-2">
                  <select class="form-control" id="filter_tahun"></select>
                </div>

              </div>
            </form>

          </div>


          <div class="col-md-4 text-end mb-3">
            <!-- <button class="btn" id="btnTambah">Tambah</button> -->
            <a class="btn" href="<?= base_url; ?>/jadwal/tambah">
              <i class="fa-solid fa-file-circle-plus fa-lg "></i></a>
          </div>

        </div>
        <div id="tabellist" class="table-responsive"></div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</div>


<script>
  $(document).ready(function() {
    get_tahun();
    const dateya = new Date();
    let bulandefault = dateya.getMonth() + 1;
    let tahundefault = dateya.getFullYear();
    let tahun = tahundefault;
    const userid = $("#usernama").val();
    $("#filter_tahun").val(tahun);

    const datas = {
      "userid": userid,
      "tahun": tahun
    };


    get_Data(datas);


    $(document).on("change", "#filter_tahun", function() {

      const tahun = $(this).val();
      const useridx = $("#usernama").val();

      const datas = {
        "userid": useridx,
        "tahun": tahun
      };
      get_Data(datas);
    })

  });
  // and document ready
  function get_tahun() {
    let startyear = 2020;
    let date = new Date().getFullYear();
    let endyear = date + 5;
    for (let i = startyear; i <= endyear; i++) {
      var selected = (i !== date) ? 'selected' : date;

      $("#filter_tahun").append($(`<option />`).val(i).html(i).prop('selected', selected));
    }
  }

  function get_Data(datas) {

    $.ajax({
      url: "<?= base_url ?>/router/seturl",
      data: JSON.stringify(datas),
      method: "POST",
      dataType: "json",
      headers: {
        'url': 'jwl/listdata'
      },
      success: function(result) {
        const data_result = result.data;
        Set_Tabel(data_result);


      }
    });
  }




  function Set_Tabel(data_result) {

    let userid = $("#usernama").val();
    let datatabel = ``;

    datatabel += `
        <table id="tabel1" class='table table-striped table-hover' style='width:100%'>                    
            <thead id='thead' class='thead'>
                <tr>
                    <th>No</th>
                    <th>Supplier</th>
                    <th>Ready</th>
                    <th>ETD</th>
                    <th>ETA</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Edit</th>
                    <th>Selesai</th>
                </tr>
            </thead>
            <tbody>
    `;

    let no = 1;
    $.each(data_result, function(a, b) {
      datatabel += `
            <tr>
                <td>${no++}</td>
                <td >${b.supplier}</td>
                <td>${b.ready}</td>
                <td>${b.etd}</td>
                <td>${b.eta}</td>
                <td>${b.status}</td>
                <td>${b.user_input}</td>
        `;

      datatabel += `
                <td>
                    <form  id="frompacking" role="form" action="<?= base_url; ?>/jadwal/edit" method="POST" enctype="multipart/form-data"
                    >
                        <input type="hidden" name="supplier" value="${b.supplier}">
                        <button  type="submit" class="btn btn-primary" title="Edit">
                            <i class="fa-solid fa-file-pen"></i>
                        </button>
                    </form>
                </td>
            `;
      datatabel += `
                <td>
                    <form  id="frompacking" role="form" action="<?= base_url; ?>/jadwal/finish" method="POST" enctype="multipart/form-data"
                    >
                        <input type="hidden" name="supplier" value="${b.supplier}">
                        <button  type="submit" class="btn btn-info" title="Edit">
                            <i class="fa-solid fa-file-pen"></i>
                        </button>
                    </form>
                </td>
            `;


      datatabel += `</tr>`;
    });

    datatabel += `</tbody></table>`;
    $("#tabellist").empty().html(datatabel);
    Tampildatatabel();
  }

  function Tampildatatabel() {

    const id = "#tabel1";
    $(id).DataTable({
      order: [
        [0, 'asc']
      ],
      responsive: true,
      "ordering": true,
      "destroy": true,
      pageLength: 5,
      lengthMenu: [
        [5, 10, 20, -1],
        [5, 10, 20, 'All']
      ],
      fixedColumns: {
        // left: 1,
        right: 1
      },

    })
  }


  $(document).on("click", "#printButton", function(e) {
    e.preventDefault();



  }); // document ready

  printButton = (event, flag, action) => {
    if (flag === 'N') {
      event.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: `Tidak bisa ${action}`,
        text: `Level user anda tidak ada akses untuk ${action}`,
        confirmButtonText: 'OK'
      });

      return false;
    } else {

      // Submit form
      document.getElementById('cetakforwader').submit();

      // Ambil data
      const ItemNo = document.getElementById("ItemNo")?.value;
      const userid = document.getElementById("usernama")?.value;
      const tahun = document.getElementById("filter_tahun")?.value;

      const datas = {
        "userid": userid,
        "ItemNo": ItemNo,
        "tahun": tahun
      };


      // Kirim status
      UpdateStatusPrint(datas);

      return false; // cegah submit default (karena sudah pakai JS)

    }


  }

  checkAccess = (event, flag, action) => {
    if (flag === 'N') {
      event.preventDefault();

      Swal.fire({
        icon: 'warning',
        title: `Tidak bisa ${action}`,
        text: `Level user anda tidak ada akses untuk ${action}`,
        confirmButtonText: 'OK'
      });

      return false;
    }
    return true;
  }

  UpdateStatusPrint = (datas) => {
    $.ajax({
      url: "<?= base_url ?>/router/seturl",
      data: JSON.stringify(datas),
      method: "POST",
      dataType: "json",
      headers: {
        'url': 'forimport/statusprint'
      },
      success: function(result) {
        const data_result = result.data;
        Set_Tabel(data_result);


      }
    });
  }
  //and updae satus print
</script>
<!-- Button trigger modal -->
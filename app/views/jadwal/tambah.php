<?php
$userid = htmlspecialchars($data["userid"], ENT_QUOTES, 'UTF-8');

?>

<style>
    /* Untuk Chrome, Safari, Edge, dan Opera */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Untuk Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .error {
        color: red;
    }

    input[type="file"] {
        display: none;
    }

    .error {
        color: red;
    }

    .ldBar path.mainline {
        stroke-width: 10;
        stroke: #09f;
        stroke-linecap: round;
    }

    .ldBar path.baseline {
        stroke-width: 14;
        stroke: #f1f2f3;
        stroke-linecap: round;
        filter: url(#custom-shadow);
    }

    .loading-spinner {
        width: 30px;
        height: 30px;
        border: 2px solid indigo;
        border-radius: 50%;
        border-top-color: #0001;
        display: inline-block;
        animation: loadingspinner .7s linear infinite;
    }

    @keyframes loadingspinner {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .thead {
        background-color: #E7CEA6;
    }

    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th {
        background-color: #F5DE14FF !important;
    }

    .table-striped>tbody>tr:nth-child(2n+1)>td,
    .table-striped>tbody>tr:nth-child(2n+1)>th {
        background-color: #BFECFF !important;
    }

    .focusedInput {
        border-color: rgba(82, 168, 236, .8);
        outline: 0;
        outline: thin dotted \9;
        box-shadow: 0 0 8px rgba(82, 168, 236, .6) !important;
    }
</style>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div id="formhider" class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="row col-md-12">
                    <div class="col-md-1">
                        <button id="kembali" type="button" class="btn btn-lg text-start">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="col-md-11">
                        <h5 class="text-center">Tambah Data</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" id="username" class="form-control" value="<?= $userid ?>">
                <form>
                    <!-- Supplier -->
                    <div class="row mb-2">
                        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                        <div class="col-sm-4">
                            <input type="text" id="supplier" class="form-control">
                        </div>
                        <span id="supplierError" class="error"></span>
                    </div>

                    <!-- Date Ready -->
                    <div class="row mb-2">
                        <label for="ready" class="col-sm-2 col-form-label">Ready</label>
                        <div class="col-sm-2">
                            <input type="date" id="ready" class="form-control">
                        </div>
                        <span id="readyError" class="error"></span>
                    </div>

                    <!-- etd Input -->
                    <div class="row mb-2">
                        <label for="etd" class="col-sm-2 col-form-label">ETD</label>
                        <div class="col-md-2">
                            <input type="date" id="etd" class="form-control">
                        </div>
                        <span id="etdError" class="error"></span>
                    </div>
                    <!-- ETA Input -->
                    <div class="row mb-2">
                        <label for="eta" class="col-sm-2 col-form-label">ETA</label>
                        <div class="col-md-2">
                            <input type="date" id="eta" class="form-control">
                        </div>
                        <span id="etaError" class="error"></span>
                    </div>

                    <!-- status Input -->
                    <div class="row mb-2">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-md-4">
                            <textarea type="text" id="status" class="form-control"></textarea>
                        </div>
                        <span id="statusError" class="error"></span>
                    </div>


                    <div class="col-md-6 text-end mt4">
                        <button class="btn btn-primary me-1 mb-3" id="CreateAdd">Save</button>
                        <button class="btn btn-secondary me-1 mb-3" id="batal">Batal</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module" src="<?= base_url; ?>/src/jadwalimport/main.js"></script>
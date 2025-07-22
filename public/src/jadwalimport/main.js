import GetSupplierForwader from './SuppleirForwader.js';

import Simpdatdata from './Simpdatdata.js';
import {baseUrl} from '../config.js';
import Updatedata from './Updatedata.js';

import Deletedata  from './Deletedata.js';
import FinishData from './finishdata.js';
//import {initKeypresInput} from './KeypresInput.js';

let uploadedFiles = []; 
export let pageMode = "";
document.addEventListener('DOMContentLoaded', function() {
     pageMode = getPageMode();
   
    initializeDatePicker();
    initialzeButton();
  

});

// === Helper untuk mengecek mode ===
function getPageMode() {
    const pathSegments = window.location.pathname.split("/").filter(Boolean);

   const lastSegment = pathSegments.pop();
    return lastSegment;
}


  function initialzeButton(){
     $('#supplierforwade').on('change', function() {
       const val = $(this).val();
       new GetSupplierForwader(val); // Kirim val sebagai parameter
    });

     $('#supplier').on('change', function() {
       const val = $(this).val();
       new Potransaction(val); // Kirim val sebagai parameter
    });

    $("#CreateAdd").on("click",function(even){
        even.preventDefault();
        new Simpdatdata();
    })

    $("#kembali ,#batal").on("click",function(even){
        even.preventDefault();
        goBack();
    });

    $("#Update").on("click",function(even){
        even.preventDefault();
        new Updatedata()
    });

    $("#FinishData").on("click",function(even){
           even.preventDefault();
        new FinishData()
    })
    
    $("#DeleteData").on("click",function(event){
       
        event.preventDefault();
         Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Hapus Data Ini!",
                type: "warning",
                showDenyButton: true,
                confirmButtonColor: "#DD6B55",
                denyButtonColor: "#757575",
                confirmButtonText: "Ya, Hapus!",
                denyButtonText: "Tidak, Batal!",
              }).then((result) =>{
                if (result.isConfirmed) {
                    new Deletedata();
                }
            }) 

    
    })

    $("#Postingdata").on("click",function(even){
        even.preventDefault();
        new PostingData();
    })
      if(pageMode =="edit" || pageMode =="post" || pageMode ==="detail" || pageMode ==="lap_d"){
        const supplier = $("#supplier").val();
        new Potransaction(supplier);
   
      }
  
  
 }


 


function initializeDatePicker() {
    let defaultReady = "";
    let defaultEtd = "";
    let defaultEta = "";

    const isEditMode = ["edit", "post","finish", "lap_d"].includes(pageMode);
let placeholderText = "dd/mm/yyyy";

    if (isEditMode) {
        const readyOld = $("#ready_old").val();
        const etdOld = $("#etd_old").val(); 
        const etaOld = $("#eta_old").val();
     defaultReady = isValidDate(readyOld) ? readyOld : null;
     defaultEtd   = isValidDate(etdOld)   ? etdOld   : null;
     defaultEta   = isValidDate(etaOld)   ? etaOld   : null;
    
     // Set placeholder jika null
    if (!defaultReady) $("#ready").attr("placeholder", placeholderText);
    if (!defaultEtd)   $("#etd").attr("placeholder", placeholderText);
    if (!defaultEta)   $("#eta").attr("placeholder", placeholderText);
    } else {
       // const today = new Date();
        defaultReady = null; // penting: bukan "dd/mm/yyyy"
        defaultEtd = null;
        defaultEta = null;

    // set placeholder untuk input
    $("#ready").attr("placeholder", placeholderText);
    $("#etd").attr("placeholder", placeholderText);
    $("#eta").attr("placeholder", placeholderText);
    }

    const flatpickrOptions = (defaultDate) => ({
        dateFormat: "d/m/Y",
        allowInput: true,
        defaultDate: defaultDate
    });

    flatpickr("#ready", flatpickrOptions(defaultReady));
    flatpickr("#etd", flatpickrOptions(defaultEtd));
    flatpickr("#eta", flatpickrOptions(defaultEta));

    const flatpickrOptionsfinish = ()=>({
        dateFormat: "d/m/Y",
        allowInput: true,
        defaultDate: new Date()
    });
     flatpickr("#tanggalfinish", flatpickrOptionsfinish());
}


function isValidDate(dateStr) {
    if (!dateStr) return false;
    const normalized = dateStr.replace(/\/|-/g, '-'); // ubah jadi format seragam
    return normalized !== '01-01-1900' && normalized !== '1900-01-01';
}




export function goBack() {
    window.location.replace(`${baseUrl}/jadwal`);
}


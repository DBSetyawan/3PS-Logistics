function formatMoney(amount, float = 2, decimal = ".", thousands = ",") {

    try {
       
        float = Math.abs(float);
        float = isNaN(float) ? 2 : float;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(float)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (float ? decimal + Math.abs(amount - i).toFixed(float).slice(2) : "");
    }
        catch (e) {
            swal("Something else!", "Number is not function")
        
    }
};

$(document).ready(function() {
    
    document.getElementById("pricesz").style.display ='none';
    $(".loaders").hide();
    $(".Counter").hide();
    $("#dataResults").hide();

    $("#itemList > TBODY").attr("class","tbodys");
    $("#waitings").hide();
    $("#exp").hide();
    $('.parent').parent().append($('.parent').get().reverse());

})


// function toggleExpandCollapse(vals) {
//     // const appsID = document.getElementById("opClose");
//     // $(vals).closest('tr').toggle("hidden")
//     // $(this).closest('tr').toggle(!not_found);
//     // console.log($(vals).closest('tr').toggle("hidden"))
//     // if ( $( vals ).is( "first:hidden" ) ) {
//     //     $(vals).closest('tr').toggle( "show" );

//     // } else {
//         // $(vals).closest('tr').toggle("hidden");
//         // if ( $(vals).is( ":hidden" ) ) {
//         // $(vals).nextUntil('tr.parent')
//         // .wrapInner('<div style="display: block;" />')
//         // .parent()
//         // .slideUp("fast");
//         // $(vals).slideDown("slow");
//         $(vals).closest('tr').toggle("hidden");
//         // } else {
//         //     Actived(vals)
//         // }
//     // }
//     // return vals
// }
    
$('#plus').live('click', function(e){ 
    e.preventDefault();
    $(this).closest('tr').slideToggle(100);
});

    // $('#accd').live('click', function(e){ 
    //     e.preventDefault();
    //     if($(this).is(":hidden")){
        
    //         $(this).closest('tr').toggle("hidden");
        
    //     } else {
            
    //         $(this).closest('tr').toggle("hidden");

    //     }
    // });

// function Actived(x) {
  
    // $('#accd').live('click', function(e){ 
    //     e.preventDefault();
    //         $("#cell1").closest('tr').toggle("hidden");
    // });
    // $(x).nextUntil('tr.parent')
    //                 .wrapInner('<div style="display: block;" />')
    //                 .parent()
    //                 .slideUp("fast");
    //                 $(x).toggle("hidden");
    // console.log($(vals).closest('tr').toggle("hidden"))
 
    // $('#itemList').on('click','a', function (e) {
        // // e.preventDefault();
        // let xx = [x];
        // if ( $( "#cell1" ).is( ":hidden" ) ) {
        //     $("#plus").closest('tr').toggle("hidden");

        // } else {
            // $("#cell1").closest('tr').nextUntil(".parent").toggle("hidden")
            // $("#cell1").closest("tr").parent().nextUntil("tr.parent#cell1").toggle("hidden");
           
// alert("td")
// $('#accd').click(function(){
    //This is what we're going to toggle:
    // var togglable = $("#cell1").parent().nextUntil('tr.parent');
    // //Toggle togglable:
    // togglable.slideToggle(1, function() {
    //     //Close all of the child slideToggles after toggling the parent:
    //     $("#accd").each(function() {
    //     });
    // });
// });
        // }
    // });
    // console.log("in...")
// }



    $(function(){
        $('#addorders').click(function (e) {
            e.preventDefault();
            let customers = $("#customers_name").val();
            $("#addorders").prop( "disabled", true );
            $("#addorders").text('Please wait proccessing...');
                return new Promise((resolve, reject) => {
                    setTimeout(() => resolve(StoreOrderTransport()), 3500)
                });
        });
    });
    
    let submit = document.querySelector("#clickme");

    let promiseResolve = null;
    
    if(submit){
        submit.addEventListener('click', onSubmitClick);
    }

    function startListening() {

    new Promise(function(resolve, reject) {
        promiseResolve = (error) => {
        if (error) { reject(error); } else { resolve(); }
        };
    }).then(onSubmit)
    .catch(error => onError(error));
    }

    function onSubmitClick() {
    $("#clickme").attr("disabled", false);
    $(".loaders").show();
    $(".Counter").show();
    $("#dataResults").hide();
    // $("#waitings").show();

    const tBody = $("#itemList > TBODY")[0];
    let rowIndex = document.getElementById("ID").rowIndex;
    let rows = tBody.insertRow(rowIndex);
    rows = tBody.insertRow(rowIndex);
    $(rows.insertCell(0));
    let cell1 = $(rows.insertCell(1));
    rows.insertCell(2);
    rows.insertCell(3);
    rows.insertCell(4);

    cell1.attr("id","waitings");
    cell1.colSpan = "5";
    cell1.html(`<div class="loaders row-fluid">
        <img src="{{ asset('img/FhHRx.gif') }}" id="form_loading_img" alt="Sedang memuat history order" style="display:none;display: block;margin-left: auto;margin-right: auto;">
    </div>`);
    

    // $(".parent").hide();
    $("#itemList > THEAD > TBODY").show();
 
    
    if (promiseResolve) promiseResolve();
            const id_sbservice = $("#sub_servicess").val();
            const idItem = $("#items_tc").val();
            const qty = $("#qty").val();
            const price = $("#rate").val();
            const totalHarga = $("#total_rate").val();
            const cabang = "{{ $some }}";
            const topup = $("#hrgatmbahan").val();
            let Quantity = $("#qty").val();
            let Prices = $("#rate").val();
            let TotalPrice = $("#total_rate").val();

            // https://lipis.github.io/bootstrap-sweetalert/

            if(qty < 1){

                swal("Peringatan!", "Maaf Qty minimal 1 (kg/koli/m3)?")
                setTimeout(() => $(".loaders").hide(),1500);
            } 
                else {

                    // swal("Here's a message!", "It's pretty, true?")
                    return new Promise((resolve, reject) => {
                        // let awaitTransport = new Promise((resolve, reject) => {
                        setTimeout(() => resolve(FetchDetailItemCustomer(cabang, idItem, qty, price, totalHarga, topup)),3500)
                    });
            }

    }

    function onSubmit() {
        console.log("Done");
    }

    // $('#clickme').click(function (e) {
    //         e.preventDefault();
            
            
    //         const id_sbservice = $("#sub_servicess").val();
    //         const idItem = $("#items_tc").val();
    //         const qty = $("#qty").val();
    //         const totalHarga = $("#total_rate").val();
    //         const cabang = "{{$some}}";
    //         let Quantity = $("#qty").val();
    //         let Prices = $("#rate").val();
    //         let TotalPrice = $("#total_rate").val();
    //         return new Promise((resolve, reject) => {
    //             $("#clickme").text("please wait")
    //             $("#clickme").prop("disabled", true)
    //             // let awaitTransport = new Promise((resolve, reject) => {
    //                 setTimeout(() => resolve(FetchDetailItemCustomer(cabang, idItem, qty, totalHarga)),3500)
    //             });

    //     });
            
            // $('#spanty').each(function(){
            //     total += parseFloat(this.innerHTML)
            // });
            
            // $('#spantyf').text(total+sd);
            
         
            // const itemsx = [id_sbservice, Quantity, Prices, TotalPrice]

            //     const insert = (arr, index, ...newItems) => [
            //     // part of the array before the specified index
            //     ...arr.slice(0, index),
            //     // inserted items
            //     ...newItems,
            //     // part of the array after the specified index
            //     ...arr.slice(index)
            //     ]

            //     const result = insert(itemsx, 1, 10, 20)

            //     console.log(result)

     // with initial value to avoid when the array is empty

        async function FetchDetailItemCustomer(cabang, idItem, qty, price, totalHarga, topup) {
            const test = `/dashboard/find-branch-with-branch/branch-id/${cabang}/viewDetailItemcustomer/`+idItem;
            const responsetest = await fetch(test, {

                method: 'GET',
                cache: 'no-cache',
                credentials: 'same-origin',
                redirect: 'follow',
                referrer: 'no-referrer',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                }

                });

                if(!responsetest){  

                    $(".loaders").show();
                    $("#dataResults").hide();

                    $(".Counter").show();
                    $("#waitings").show();

                    $(".parent").hide();

                    
                } else {
                    
                    $(".loaders").hide();
                    $("#dataResults").show();

                    $(".Counter").hide();

                    $(".parent").show();
                    // $("#itemList tr").find("#xxxx").parent().each(function(){
                    $("#itemList tr").find("#waitings").parent().each(function(){
                        $(this).closest("tr").hide();
                    })



                }
                
                const dataJsons = await responsetest.json();

                const dataMinimumQty = JSON.stringify(dataJsons.data.batch_itemCustomer.itemMinimumQty);
                const dataRateSelanjutnya = JSON.stringify(dataJsons.data.batch_itemCustomer.rateKgFirst);
                const dataprice = JSON.stringify(dataJsons.data.price);
                const dataUnit = JSON.stringify(dataJsons.data.unit);

                // console.log(dataRateSelanjutnya, dataMinimumQty)
                let TotalPrice = $("#total_rate").val();
                let Rate = $("#rate").val();
                let tostal = TotalPrice.toString();
                let sd = tostal.replace('.', '');
                let harga = sd.replace('.', '');
                let total = 0;

                $('#pricesz').append($('<option>' ,{
                    value:harga,
                    text:harga
                }));
                $('#itemID').append($('<option>' ,{
                    value:dataJsons.data.id,
                    text:dataJsons.data.id
                }));

            let iArrays = new Array();
            let JArrays = new Array();
            let QArrays = new Array();
            let HargaArrays = new Array();
            let topArrays = new Array();
            let biayaTambahan = [topup];
            const tBody = $("#itemList > TBODY")[0];
            let rowIndex = document.getElementById("ID").rowIndex;
            let rows = tBody.insertRow(rowIndex + 1);
            let saldoakhir = 0;
            let Besides = 0;
            let StuckQty = 0;
            let StuckPrices = 0;
            let hasilRatedanMinimalRate = 0;
            let rateSelanjutnya = 0;
            let wom = 0;
            let leftQouter;
            let tambahanMinimalQty = 0;
            let resultCountRateCat1 = 0;
            let resultCountRate = 0;
            let SaldoBiayaTambahan = 0;
            let order_id_dumps = document.getElementById('pricesz');
            let Kuantitas = document.getElementById('qtyID');
            let pricesz = document.getElementById('pricesz');
            let topups = document.getElementById('topup');

                for (i = 0; i < order_id_dumps.options.length; i++) {

                    iArrays[i] = order_id_dumps.options[i].value;

                }

                    for (i = 0; i < iArrays.length; i++) {

                        total += parseInt(iArrays[i]);
                    }  

                        for (i = 0; i < Kuantitas.options.length; i++) {

                            QArrays[i] = Kuantitas.options[i].value;

                        }

                            let fetchQTY = [];

                                for (i = 0; i < QArrays.length; i++) {

                                    fetchQTY.push(QArrays[i]);
                                
                                }  

                                for (i = 0; i < pricesz.options.length; i++) {

                                        HargaArrays[i] = pricesz.options[i].value;

                                    }

                                    let fetchHarga = [];

                                        for (i = 0; i < pricesz.length; i++) {

                                            fetchHarga.push(HargaArrays[i]);
                                        
                                        }  
                                        
                                // console.log(fetchHarga)
                                /**
                                 * metode pertama
                                */
                                if(dataMinimumQty == 0 && dataRateSelanjutnya == 0){
                                    console.log("semua data kosong")
                                    $('#topup').append($('<option>' ,{
                                        value:harga,
                                        text:harga
                                    }));
                                    for (i = 0; i < topups.options.length; i++) {

                                        topArrays[i] = topups.options[i].value;

                                    }

                                        for (i = 0; i < topArrays.length; i++) {

                                            resultCountRateCat1 += parseInt(topArrays[i]);

                                        }  

                                        total = parseFloat(resultCountRateCat1)
                                        StuckQty = qty;
                                        StuckPrices = Rate;

                                } 
                                    else 
                                            {

                                                /**
                                                * metode kedua
                                                */
                                                    if(dataMinimumQty > 0 && dataRateSelanjutnya == 0){
                                                        console.log("data minimum ada")
                                                            if(parseInt(qty) < parseInt(dataMinimumQty)){
                                                                console.log("data kurang dari data minimum")

                                                                tambahanMinimalQty = dataMinimumQty*parseInt(Rate);
                                                                StuckQty = dataMinimumQty;
                                                                StuckPrices = Rate;
                                                                wom = dataMinimumQty;
                                                                // total = tambahanMinimalQty;
                                                                console.log("harga :",Rate)
                                                                console.log("dataMinimumQty qty :",dataMinimumQty)
                                                                console.log("rate qty :",Rate)
                                                                console.log("minimum qty :",tambahanMinimalQty)
                                                                console.log("total :",total)

                                                                                            
                                                                $('#topup').append($('<option>' ,{
                                                                    value:tambahanMinimalQty,
                                                                    text:tambahanMinimalQty
                                                                }));

                                                                for (i = 0; i < topups.options.length; i++) {

                                                                    topArrays[i] = topups.options[i].value;

                                                                }

                                                                    for (i = 0; i < topArrays.length; i++) {

                                                                        resultCountRate = parseInt(topArrays[i]);
                                                                        saldoakhir += parseInt(topArrays[i]);
                                                                    }  

                                                                totalcategory2 = parseFloat(saldoakhir)

                                                            } 
                                                                else 
                                                                        {

                                                                            tambahanMinimalQty = qty*parseInt(Rate);
                                                                            StuckQty = qty;
                                                                            StuckPrices = Rate;
                                                                            wom = qty;
                                                                            // totalcategory2 = tambahanMinimalQty;
                                                                            $('#topup').append($('<option>' ,{
                                                                                value:tambahanMinimalQty,
                                                                                text:tambahanMinimalQty
                                                                            }));

                                                                            for (i = 0; i < topups.options.length; i++) {

                                                                                    topArrays[i] = topups.options[i].value;

                                                                                }

                                                                                for (i = 0; i < topArrays.length; i++) {

                                                                                    resultCountRate = parseInt(topArrays[i]);
                                                                                    saldoakhir += parseInt(topArrays[i]);
                                                                                }  

                                                                                // totalcategory2 = parseFloat(saldoakhir)+tambahanMinimalQty
                                                                                totalcategory2 = parseFloat(saldoakhir)


                                                                            console.log("data lebih dari data minimum")
                                                                            console.log(tambahanMinimalQty)

                                                                            
                                                                        }
                                                    } 
                                                        else 
                                                                {
                                                                   
                                                                    if(dataMinimumQty == 0 && dataRateSelanjutnya > 0){
                                                                        console.log("data rate selanjutnya ada")
                                                                    }
                                                    }

                                            /**
                                            * metode ketiga
                                            */
                                            if(dataMinimumQty > 0 && dataRateSelanjutnya > 0){
                                                       console.log("semua data ada")
                                                    // if(parseInt(qty) > parseInt(dataMinimumQty)){

                                                        
                                                    //     swal("Peringatan!", "Maaf Qty tidak boleh lebih dari minimal qty!")
                                                    //     return false;

                                                    // } 
                                                    //     else 
                                                                // {
                                                    tambahanMinimalQty = dataMinimumQty-qty;
                                                        StuckQty = tambahanMinimalQty;

                                                        if(tambahanMinimalQty == 0){

                                                                    leftQouter = 0;
                                                                    tambahanMinimalQty = qty;
                                                                    // tambahanMinimalQty = qty%dataMinimumQty;
                                                                    StuckQty = tambahanMinimalQty;

                                                                } 
                                                                    else {

                                                                        tambahanMinimalQty = Math.abs(tambahanMinimalQty)
                                                                        // tambahanMinimalQty = qty%dataMinimumQty;

                                                                        StuckQty = tambahanMinimalQty;

                                                                }

                                                                    if(parseInt(dataMinimumQty) >= parseInt(qty)){
                                                                        if(parseInt(dataMinimumQty) == parseInt(qty)){

                                                                                leftQouter = 0;
                                                                                // tambahanMinimalQty = qty;
                                                                                // tambahanMinimalQty = qty;
                                                                                // tambahanMinimalQty = qty%dataMinimumQty;
                                                                                // StuckQty = tambahanMinimalQty;
                                                                            console.log("sisa bagi dari", tambahanMinimalQty)
                                                                        console.log("ini sama dengan minimal")
                                                                                    // StuckPrices = Math.ceil((parseFloat(Rate * StuckQty)+parseFloat(dataRateSelanjutnya))/(parseFloat(StuckQty)));
                                                                                    // ResultRate = parseFloat(Rate)*StuckQty+parseFloat(dataRateSelanjutnya);
                                                                                    // SaldoBiayaTambahan = parseFloat(Rate)*StuckQty+parseFloat(dataRateSelanjutnya);
                                                                                    // StuckPrices = Math.ceil(parseFloat(dataRateSelanjutnya));
                                                                                    ResultRate = parseFloat(dataRateSelanjutnya);
                                                                                    SaldoBiayaTambahan = parseFloat(dataRateSelanjutnya);

                                                                                    StuckPrices = parseFloat(ResultRate/tambahanMinimalQty)
                                                                                    x = Math.ceil(StuckPrices)*parseFloat(tambahanMinimalQty)

                                                                                    ResultRate = parseFloat(x);
                                                                                    
                                                                                    diskon = 0;

                                                                                    $('#itemDiscount').append($('<option>' ,{
                                                                                                value:diskon,
                                                                                                text:diskon
                                                                                            }
                                                                                        )
                                                                                    )
                                                                        } else {
                                                                               // tambahanMinimalQty = qty;
                                                                            //    tambahanMinimalQty = qty;
                                                                                // StuckQty = tambahanMinimalQty;
                                                                            console.log("sisa bagi dari", tambahanMinimalQty)
                                                                        console.log("ini kurang dari minimal")
                                                                        leftQouter = 0;
        
                                                                                    // StuckPrices = parseFloat(Rate);
                                                                                    // StuckPrices = Math.ceil((parseFloat(Rate * StuckQty))/(parseFloat(StuckQty)));
                                                                                    // ResultRate = parseFloat(Rate)*StuckQty;
                                                                                    // SaldoBiayaTambahan = parseFloat(Rate)*StuckQty;

                                                                                    StuckPrices = Math.ceil(parseFloat(dataRateSelanjutnya)/(parseFloat(StuckQty)));
                                                                                    ResultRate = parseFloat(dataRateSelanjutnya);
                                                                                    SaldoBiayaTambahan = parseFloat(dataRateSelanjutnya);
                                                                                    jumlahRate = Math.ceil(StuckPrices)*parseFloat(tambahanMinimalQty)

                                                                                    diskon = Math.abs(ResultRate - jumlahRate);

                                                                                    $('#itemDiscount').append($('<option>' ,{
                                                                                                value:diskon,
                                                                                                text:diskon
                                                                                            }
                                                                                        )
                                                                                    )

                                                                                    console.log("hasil",ResultRate)
                                                                                    console.log("diskon",diskon)

                                                                                    console.log("cari harga total (kurang dari):", Math.abs(StuckPrices))

                                                                        }
                                                                    } else {
                                                                           // tambahanMinimalQty = qty;
                                                                        //    tambahanMinimalQty = qty%dataMinimumQty;
                                                                                // StuckQty = tambahanMinimalQty;
                                                                            console.log("sisa bagi dari", tambahanMinimalQty)
                                                                        console.log("ini lebih dari minimal")
                                                                        leftQouter = 0;

                                                                        // StuckPrices = parseFloat(Rate);
                                                                        // StuckPrices = Math.ceil((parseFloat(Rate * StuckQty)+parseFloat(dataRateSelanjutnya))/(parseFloat(StuckQty)));
                                                                        StuckQty = qty
                                                                        StuckQtys = tambahanMinimalQty
                                                                        Besides = parseFloat(Rate)*tambahanMinimalQty
                                                                        ResultRate = parseFloat(Rate)*StuckQtys+parseFloat(dataRateSelanjutnya);
                                                                        StuckPrices = Math.abs(Math.ceil(parseFloat(ResultRate)/parseFloat(qty)));
                                                                        jumlahRate = Math.ceil(StuckPrices)*parseFloat(qty)
                                                                        SaldoBiayaTambahan = parseFloat(Rate)*StuckQtys+parseFloat(dataRateSelanjutnya);

                                                                        /**
                                                                         * development diskon on accurate
                                                                        */
                                                                        diskon = Math.abs(ResultRate - jumlahRate);

                                                                        $('#itemDiscount').append($('<option>' ,{
                                                                                    value:diskon,
                                                                                    text:diskon
                                                                                }
                                                                            )
                                                                        )
                                                                        console.log("cari harga:", jumlahRate)
                                                                        console.log("hasil rate:",ResultRate)
                                                                        console.log("harga:",StuckPrices)
                                                                        console.log("hasil pengurangan:",diskon)

                                                                    }

                                                                    // if(tambahanMinimalQty >= 0) {

                                                                    //     if(dataMinimumQty < qty){

                                                                    //                 console.log("ini kurang dari")
                                                                    //                 StuckPrices = parseFloat(Rate);
                                                                    //                 ResultRate = parseFloat(Rate)*qty;
                                                                    //                 SaldoBiayaTambahan = parseFloat(Rate)*qty;

                                                                                    
                                                                    //             } else {

                                                                    //                     console.log("ini positive")
                                                                    //                     console.log("tambaahan qty",tambahanMinimalQty)
                                                                    //                     tambahanMinimalQty = parseInt(tambahanMinimalQty)
                                                                    //                     // rateSelanjutnya = tambahanMinimalQty*Rate;
                                                                    //                     StuckQty = tambahanMinimalQty;

                                                                                       
                                                                    //                     SaldoBiayaTambahan = parseFloat(tambahanMinimalQty*dataRateSelanjutnya);
                                                                    //                     // StuckPrices = Math.ceil((parseFloat(dataRateSelanjutnya * StuckQty)+parseFloat(Rate))/(parseFloat(StuckQty)));
                                                                    //                     StuckPrices = Math.ceil((parseFloat(Rate) * tambahanMinimalQty)+parseFloat(dataRateSelanjutnya));
                                                                    //                     hasilRatedanMinimalRate = parseFloat(tambahanMinimalQty*Rate)+parseFloat(dataRateSelanjutnya);

                                                                    //                     // ResultRate = parseFloat(StuckPrices*StuckQty)
                                                                    //                     ResultRate = parseFloat(hasilRatedanMinimalRate)

                                                                    //                     total = SaldoBiayaTambahan;

                                                                    //             }

                                                                    // }   
                                                                    //     else {

                                                                    //             console.log("ini minus")
                                                                    //             console.log("tambahan hasil mod", tambahanMinimalQty)
                                                                    //             hasilRatedanMinimalRate = dataRateSelanjutnya*parseInt(tambahanMinimalQty);
                                                                    //             StuckPrices = Math.ceil((parseFloat(dataRateSelanjutnya * StuckQty)+parseFloat(Rate))/(parseFloat(StuckQty)));
                                                                                
                                                                    //             StuckQty = tambahanMinimalQty;
                                                                    //             // rateSelanjutnya = tambahanMinimalQty*Rate;
                                                                    //             SaldoBiayaTambahan = parseFloat(tambahanMinimalQty*dataRateSelanjutnya)+parseFloat(Rate);
                                                                    //             total = SaldoBiayaTambahan;
                                                                    //             ResultRate = parseFloat(StuckPrices*StuckQty)

                                                                    // }
                                                                 

                                                                    $('#topup').append($('<option>' ,{
                                                                            value:ResultRate,
                                                                            text:ResultRate
                                                                        }));

                                                                            for (i = 0; i < topups.options.length; i++) {

                                                                                    topArrays[i] = topups.options[i].value;

                                                                                }

                                                                                for (i = 0; i < topArrays.length; i++) {

                                                                                    resultCountRate = parseInt(topArrays[i]);
                                                                                    saldoakhir += parseInt(topArrays[i]);
                                                                                }  

                                                                                // totalcategory2 = parseFloat(saldoakhir)+tambahanMinimalQty
                                                                                totalcategory2 = parseFloat(saldoakhir)

                                                                    console.log("dataprice :",dataprice)
                                                                    console.log("tambahanMinimalQty :",tambahanMinimalQty)
                                                                    console.log("datarateSelanjutnya :", dataRateSelanjutnya)
                                                                    console.log("SaldoBiayaTambahan :",SaldoBiayaTambahan)
                                                                    console.log("total :",total)
                                                                // }
                                                  
   
                                            }

                                }

                                /*
                                * stuck array here with component box for send to request back end server
                                */
                                $('#qtyID').append($('<option>' ,{
                                    value:StuckQty,
                                    text:StuckQty
                                }));
                                $('#priceID').append($('<option>' ,{
                                    value:StuckPrices,
                                    text:StuckPrices
                                }));

                                // if(fetchQTY.length > 1 ){
                                    
                                //     // total = sum(biayaTambahan, total);

                                    // $.each(biayaTambahan, function( i, v ) { 
                                    //     $('#topup').append($('<option>' ,{
                                    //         value:v,
                                    //         text:v
                                    //     }));
                                    // });

                                    // // $('#topup').append($('<option>' ,{
                                    // //     value:biayaTambahan,
                                    // //     text:biayaTambahan
                                    // // }));

                                    // for (i = 0; i < topups.options.length; i++) {

                                    //     topArrays[i] = topups.options[i].value;

                                    // }

                                    //     for (i = 0; i < topArrays.length; i++) {

                                    //         saldoakhir += parseInt(topArrays[i]);
                                    //     }  

                                    //     total = parseFloat(saldoakhir+total)
                                        // console.log("lebih dari satu",total)
                                //     // total = biayaTambahan.map(item =>
                                //     //     item
                                //     // ).reduce((a,c)=>
                                //     //      +a + +c+total, 0
                                //     // );
                                //     //     x += biayaTambahan.map(xx => xx);

                                    
                                // } 
                                //     else {
                                //         total = total;
                                //     // console.log("kurang dari satu",total)
                                // }

                        if(dataMinimumQty == 0 && dataRateSelanjutnya == 0){
                            /*
                            * metode pertama
                            */
                            const tBody = $("#itemList > TBODY")[0];
                            let row = tBody.insertRow(-1);
                                        
                            let Sub_services = $(row.insertCell(0));
                            let ItemList = $(row.insertCell(1));
                            let Qty = $(row.insertCell(2));
                            let Harga = $(row.insertCell(3));
                            let Price = $(row.insertCell(4));
                            const djl = formatMoney(`${total}`);
                            const priceXV = formatMoney(`${price}`);
                            // Sub_services.html(dataJsons.data.sub_services.name)
                            // ItemList.html(dataJsons.data.itemovdesc)
                            // Qty.html(qty)
                            // $("#chi").show();
                            // Harga.html("Rp. "+priceXV)
                            // Price.html("Rp. "+totalHarga)
                            // // Harga.html(price)
                            // // Price.html(totalHarga)
                            // $("#rateSL").hide();
                            // $("#kgSL").hide();
                            // $("#besidesID").hide();
                            // $("#TotalRTID").hide();
                            // $("#sldKSL").show();
                            // $("#spantyf").html(`<span> Saldo Akhir <span style='margin:0px 11px'>: Rp. <span id='ttl' class='dds add-on'>${djl}</span></span></span>`)
                            // $("#SaldokgResults").html(`<span> Kg Pertama <span style='margin:0px 17px'>: <span id='ttl' class='dds add-on'>0 ${dataUnit} (Tidak ada kg pertama)</span></span></span>`)
                            // $("#tmbahan").html(`<span> Total Rate <span style='margin:0px 18px'>: Rp. <span id='xxcz' class='dds add-on'>${totalHarga} (Tidak ada tambahan Rate)</span></span></span>`)
                            // $("#kgFirst").html(`<span> Kg Minimal: </span><span id='KGPertama' class='dds add-on'>Tidak ada minimal Kg</span>`)
                            // $("#rateFirst").html(`<span> Rate <span style='margin:0px 69px'>: Rp. <span id='ttl' class='dds add-on'>${Rate} &chi; ${qty} ${dataUnit} = Rp. ${totalHarga} </span></span></span>`)
                            // $("#clickme").removeAttr('disabled');
                            // $("#clickme").html("<i class='icon-plus'></i>");

                            rows = tBody.insertRow(rowIndex);
                            // rows.insertCell(0);
                            let indexx = $(rows.insertCell(0));
                            let cell1 = $(rows.insertCell(1));

                            let btnRemove = $("<span />");
                            btnRemove.attr("id","plus");
                            btnRemove.attr("style","cursor:pointer");
                            btnRemove.attr("class", "icon-minus");
                            btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                            indexx.append(btnRemove);

                            cell1.attr("id","cell1");
                            cell1.attr("class","xzx");

                            $("#itemList tr").each(function(){
                                    $(this)
                                        .attr("class","parent")
                            });

                            cell1.colSpan = "5";
                            rows.insertCell(2);
                            rows.insertCell(3);
                            rows.insertCell(4);
                            Sub_services.html(dataJsons.data.sub_services.name)
                            ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                            Qty.html(qty)
                            Harga.html("Rp. "+priceXV)
                            Price.html("Rp. "+totalHarga)
                            cell1.html(`<span style="font-family:Fira Code;font-size:11px"><span id='rtprtm' class='dds add-on'><b>Rp. ${Rate}  &chi;  ${qty} ${dataUnit} = Rp. ${totalHarga}</b></span></span>`)
                            $("#subtotal").html(`<span>Rp. ${djl}</span>`)

                                let codxxxx = `Rate          : Rp. ${Rate}  &chi;  ${qty} ${dataUnit}`+'<br/>'+`Total rate    : Rp. ${totalHarga}` 
                                      
                                        let arrLISTsQ = 
                                                'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                'Rate (Normal) : '+`Rp. ${Rate} x ${qty} ${dataUnit}`+'\n'+
                                                'Total rate    : '+`Rp. ${totalHarga}`

                                                $('#detailnotesID').append($('<option>' ,{
                                                                value:arrLISTsQ,
                                                            text:arrLISTsQ
                                                        }
                                                    )
                                                )

                                        $("#itemList tr").find("#xxxx").parent().each(function(){
                                            $(this).html(`${dataJsons.data.itemovdesc}
                                            <div class="row-fluid">
                                                    <div class="span12">
                                                        <hr>
                                                    </div>
                                                </div>
                                            <span style="text-align:left;font-family: Fira Code;font-size:12px"
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <span style="font-size:15px">
                                                                    Perhitungan detail transaksi pengiriman:
                                                                </span>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <span id="xxxzx">
                                                    </span>
                                            </span>`
                                        )
                                    }
                                );

                                    $("#itemList tr").find("#xxxzx").parent().each(function(){
                                        
                                        let detail = codxxxx.replace(/"/g, '');
                                            
                                            $(this).html('<pre><span style="font-size:15px">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                        }
                                    );

                                $("#exp").hide();
                            return

                        } 
                            else 
                                    {
                                    /*
                                    * metode kedua
                                    */
                                        if(dataMinimumQty > 0 && dataRateSelanjutnya == 0){

                                            const tBody = $("#itemList > TBODY")[0];
                                            let row = tBody.insertRow(-1);

                                            // // rows = tBody.insertRow(rowIndex);
                                            // // rows.insertCell(0);
                                            // let indexx = $(row.insertCell(0));
                                            // let cell1 = $(row.insertCell(1));

                                            // let btnRemove = $("<span />");
                                            // btnRemove.attr("id","plus");
                                            // btnRemove.attr("style","cursor:pointer");
                                            // btnRemove.attr("class", "icon-minus");
                                            // btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                                            // indexx.append(btnRemove);

                                            // cell1.attr("id","cell1");
                                            // cell1.attr("class","xzx");

                                            // $("#itemList tr").each(function(){
                                            //         $(this)
                                            //             .attr("class","parent")
                                            // });
                                                        
                                            let Sub_services = $(row.insertCell(0));
                                            let ItemList = $(row.insertCell(1));
                                            let Qty = $(row.insertCell(2));
                                            let Harga = $(row.insertCell(3));
                                            let Price = $(row.insertCell(4));
                                            const djl = formatMoney(`${totalcategory2}`);
                                            const changeCuountRate = formatMoney(`${resultCountRate}`);
                                            const tmbn = formatMoney(`${saldoakhir}`);
                                            const funcPriceX = formatMoney(`${StuckPrices}`);
                                            const RateTwo = formatMoney(`${Rate}`);
                                            // Sub_services.html(dataJsons.data.sub_services.name)  
                                            // ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                                            // // ItemList.html(dataJsons.data.itemovdesc)
                                            // // Qty.html(qty)
                                            // // Harga.html(price)
                                            // // Qty.html(StuckQty)
                                            // Qty.html(qty)
                                            // // Harga.html("Rp. "+funcPriceX)
                                            // Price.html("Rp. "+changeCuountRate)
                                            // cell1.html(`<span style="font-family:Fira Code;font-size:11px"><span id='rtprtm' class='dds add-on'><b>Rp. ${dataRateSelanjutnyaX} + ${StuckQty} ${dataUnit} &chi; Rp. ${RateX} = Rp. ${TotalSaldoRate}</b></span></span>`)

                                            // $("#kgSL").show();
                                            // $("#sldKSL").hide();
                                            // $("#rateSL").hide();
                                            // $("#besidesID").hide();
                                            // $("#TotalRTID").hide();
                                            // $("#spantyf").html(`<span> Saldo Akhir <span style='margin:0px 13px'>: <span id='sdascx' class='dds add-on'>Rp. ${djl}</span></span></span>`)
                                            // $("#tmbahan").html(`<span> Total Rate <span style='margin:0px 21px'>: <span id='asdvx' class='dds add-on'>Rp. ${changeCuountRate}</span></span></span>`)
                                            // $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 21px'>: <span id='cxzb' class='dds add-on'>${dataMinimumQty} ${dataUnit} (Tidak ada potongan kg pertama)</span></span></span>`)
                                            // $("#rateFirst").html(`<span> Rate <span style='margin:0px 72px'>: <span id='sagc' class='dds add-on'>Rp. ${RateTwo} &chi; ${wom} ${dataUnit} = Rp. ${changeCuountRate} (Tidak ada tambahan Rate)</span></span></span>`)
                                            // $("#clickme").removeAttr('disabled');
                                            // $("#clickme").html("<i class='icon-plus'></i>");

                                            rows = tBody.insertRow(rowIndex);
                                            // rows.insertCell(0);
                                            let indexx = $(rows.insertCell(0));
                                            let cell1 = $(rows.insertCell(1));

                                            let btnRemove = $("<span />");
                                            btnRemove.attr("id","plus");
                                            btnRemove.attr("style","cursor:pointer");
                                            btnRemove.attr("class", "icon-minus");
                                            btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                                            indexx.append(btnRemove);

                                            cell1.attr("id","cell1");
                                            cell1.attr("class","xzx");

                                            $("#itemList tr").each(function(){
                                                    $(this)
                                                        .attr("class","parent")
                                            });

                                            cell1.colSpan = "5";
                                            rows.insertCell(2);
                                            rows.insertCell(3);
                                            rows.insertCell(4);
                                            Sub_services.html(dataJsons.data.sub_services.name)
                                            // ItemList.html(dataJsons.data.itemovdesc)
                                            ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                                            Qty.html(StuckQty)
                                            // Qty.html(qty)
                                            // Harga.html("Rp. "+funcPrice)
                                            Price.html("Rp. "+changeCuountRate)
                                            cell1.html(`<span style="font-family:Fira Code;font-size:11px"><span id='rtprtm' class='dds add-on'><b>Rp. ${RateTwo} &chi; ${wom} ${dataUnit} = Rp. ${changeCuountRate}</b></span></span>`)
                                            $("#subtotal").html(`<span>Rp. ${djl}</span>`)

                                            let codxxxx = `Kg Minimal    : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                        +`Kg Actual     : ${qty} ${dataUnit}`+'<br/>'
                                                        +`Rate pertama  : Rp. ${RateTwo} &chi; ${wom} ${dataUnit}`+'<br/>'
                                                        +`Rate          : Rp. ${changeCuountRate}`

                                                        let arrLISTQ = 
                                                                'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                'Kg Minimal    : '+`${dataMinimumQty} ${dataUnit}`+'\n'+
                                                                'Kg Actual     : '+`${qty} ${dataUnit}`+'\n'+
                                                                'Rate pertama  : '+`Rp. ${RateTwo} x ${wom} ${dataUnit}`+'\n'+
                                                                'Rate          : '+`Rp. ${changeCuountRate}`

                                                                $('#detailnotesID').append($('<option>' ,{
                                                                                value:arrLISTQ,
                                                                            text:arrLISTQ
                                                                        }
                                                                    )
                                                                )
                                                                    
                                                            $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                $(this).html(`${dataJsons.data.itemovdesc}
                                                                <div class="row-fluid">
                                                                        <div class="span12">
                                                                            <hr>
                                                                        </div>
                                                                    </div>
                                                                <span style="text-align:left;font-family: Fira Code;font-size:12px"
                                                                            <div class="row-fluid">
                                                                                <div class="span12">
                                                                                    <span style="font-size:15px">
                                                                                        Perhitungan detail transaksi pengiriman:
                                                                                    </span>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                            <br/>
                                                                            <span id="xxxzx">
                                                                        </span>
                                                                </span>`
                                                            )
                                                        }
                                                    );

                                                    $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                        
                                                        let detail = codxxxx.replace(/"/g, '');
                                                            
                                                            $(this).html('<pre><span style="font-size:15px">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                        }
                                                    );

                                                $("#exp").hide();
                                            return

                                        } 
                                            else 
                                                    {
                                                    /*
                                                    * metode ketiga
                                                    */
                                                    if(dataMinimumQty > 0 && dataRateSelanjutnya > 0){

                                                        const tBody = $("#itemList > TBODY")[0];
                                                        let row = tBody.insertRow(-1);
                                                                    
                                                        let Sub_services = $(row.insertCell(0));
                                                        let ItemList = $(row.insertCell(1));
                                                        let Qty = $(row.insertCell(2));
                                                        let Harga = $(row.insertCell(3));
                                                        let Price = $(row.insertCell(4));
                                                        const djl = formatMoney(`${totalcategory2}`);
                                                        const totalQtyRate = formatMoney(`${Besides}`);
                                                        const tmbn = formatMoney(`${saldoakhir}`);
                                                        const TotalSaldoRate = formatMoney(`${SaldoBiayaTambahan}`);
                                                        const funcPrice = formatMoney(`${StuckPrices}`);
                                                        const dataRateSelanjutnyaX = formatMoney(`${dataRateSelanjutnya}`);
                                                        // const hasilRatedanMinimalRateX = formatMoney(`${hasilRatedanMinimalRate}`);
                                                        const hasilRatedanMinimalRateX = formatMoney(`${ResultRate}`);
                                                        const RateX = formatMoney(`${Rate}`);
                                                        
                                                        if(dataMinimumQty == qty){

                                                            rows = tBody.insertRow(rowIndex);
                                                            let indexx = $(rows.insertCell(0));
                                                            let cell1 = $(rows.insertCell(1));
                                                            cell1.colSpan = "5";
                                                            rows.insertCell(2);
                                                            rows.insertCell(3);
                                                            rows.insertCell(4);
                                                            let btnRemove = $("<span />");
                                                            btnRemove.attr("id","plus");
                                                            btnRemove.attr("style","cursor:pointer");
                                                            btnRemove.attr("class", "icon-minus");
                                                            btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                                                            btnRemove.val("+");
                                                            indexx.append(btnRemove);

                                                            cell1.attr("id","cell1");
                                                            cell1.attr("class","xzx");

                                                            $("#itemList tr").each(function(){
                                                                    $(this)
                                                                        .attr("class","parent")
                                                            });

                                                            Sub_services.html(dataJsons.data.sub_services.name)
                                                            ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                                                            // ItemList.html(dataJsons.data.itemovdesc)
                                                            Qty.html(qty)
                                                            // Qty.html(StuckQty)
                                                            // Harga.html("Rp. "+funcPrice)
                                                            Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                            cell1.html(`<span style="font-family:Fira Code;font-size:12px" id="opClose"><span id='rtprtm' class='add-on'><b>Rp. ${dataRateSelanjutnyaX} + ( ${leftQouter}  &chi;  Rp. ${RateX} ) = Rp. ${TotalSaldoRate}</b></span></span>`)
                                                            // cell1.html(`<span id="opClose"><span id='rtprtm' class='add-on'> Rp. ${StuckPrices} &chi; (${dataMinimumQty} - ${qty} = ${StuckQty} ${dataUnit}) + Rp. ${dataRateSelanjutnyaX} = Rp. ${TotalSaldoRate}</span></span>`)
                                                            // cell1.html(`<span id="opClose"><span id='rtprtm' class='add-on'> Rp. ${dataRateSelanjutnyaX} + (${StuckQty} ${dataUnit} - ${qty}) &chi; Rp. ${dataRateSelanjutnyaX} = Rp. ${TotalSaldoRate}</span></span>`)
                                                            $("#kgSL").show();
                                                            $("#sldKSL").hide();
                                                            $("#rateSL").show();
                                                            $("#chi").show();

                                                            $("#subtotal").html(`<span>Rp. ${djl}</span>`)
                                                            $("#rateFirst").html(`<span> Rate pertama <span style='margin:0px 58px'>: Rp. <span id='rtprtm' class='dds add-on'>${RateX}</span></span></span>`)
                                                            $("#rateNexts").html(`<span> Rate kg pertama <span style='margin:0px 33px'>: <span id='kgprtm' class='dds add-on'>Rp. ${dataRateSelanjutnyaX}</span></span></span>`)
                                                            $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit} - (Dikenakan kg pertama)</span></span></span>`)

                                                            $("#clickme").removeAttr('disabled');
                                                            $("#clickme").html("<i class='icon-plus'></i>");

                                                            let codxxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                        +`Kg Actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                        +`Rate kg pertama  : ${dataRateSelanjutnyaX}`+'<br/>'
                                                                        +`Rate             : Rp. ${TotalSaldoRate}` 

                                                                let arrLISTb = 
                                                                        'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                        'Kg Minimal       : '+`${dataMinimumQty} ${dataUnit}`+'\n'+
                                                                        'Kg Actual        : '+`${qty} ${dataUnit}`+'\n'+
                                                                        'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                        'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                            $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                                $(this).html(`${dataJsons.data.itemovdesc}
                                                                                <div class="row-fluid">
                                                                                        <div class="span12">
                                                                                            <hr>
                                                                                        </div>
                                                                                    </div>
                                                                                <span style="text-align:left;font-family: Fira Code;font-size:12px"
                                                                                            <div class="row-fluid">
                                                                                                <div class="span12">
                                                                                                    <span style="font-size:15px">
                                                                                                        Perhitungan detail transaksi pengiriman:
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </div>
                                                                                            </div>
                                                                                            <br/>
                                                                                            <span id="xxxzx">
                                                                                        </span>
                                                                                </span>`
                                                                            )
                                                                        }
                                                                    );

                                                                    $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                                        
                                                                        let detail = codxxxx.replace(/"/g, '');
                                                                            
                                                                            $(this).html('<pre><span style="font-size:15px">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                                
                                                                            }
                                                                        );

                                                                            $('#detailnotesID').append($('<option>' ,{
                                                                                    value:arrLISTb,
                                                                                text:arrLISTb
                                                                            }
                                                                        )
                                                                    )

                                                                $("#exp").hide();
                                                            return

                                                        } 
                                                            else {

                                                                if(parseInt(dataMinimumQty) >= parseInt(qty)){

                                                                        rows = tBody.insertRow(rowIndex);
                                                                        // rows.insertCell(0);
                                                                        let indexx = $(rows.insertCell(0));
                                                                        let cell1 = $(rows.insertCell(1));

                                                                        let btnRemove = $("<span />");
                                                                        btnRemove.attr("id","plus");
                                                                        btnRemove.attr("style","cursor:pointer");
                                                                        btnRemove.attr("class", "icon-minus");
                                                                        btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                                                                        indexx.append(btnRemove);

                                                                        cell1.attr("id","cell1");
                                                                        cell1.attr("class","xzx");

                                                                        $("#itemList tr").each(function(){
                                                                                $(this)
                                                                                    .attr("class","parent")
                                                                        });

                                                                        cell1.colSpan = "5";
                                                                        rows.insertCell(2);
                                                                        rows.insertCell(3);
                                                                        rows.insertCell(4);
                                                                        Sub_services.html(dataJsons.data.sub_services.name)
                                                                        // ItemList.html(dataJsons.data.itemovdesc)
                                                                        ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                                                                        // Qty.html(StuckQty)
                                                                        Qty.html(qty)
                                                                        // Harga.html("Rp. "+funcPrice)
                                                                        Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                                        $("#besidesID").hide();
                                                                        $("#TotalRTID").hide();
                                                                        $("#kgSL").hide();
                                                                        $("#sldKSL").show();
                                                                        $("#rateSL").show();
                                                                        $("#chi").show();
                                                                        $("#subtotal").html(`<span>Rp. ${djl}</span>`)
                                                                        // cell1.html(`<span><span id='rtprtm' class='dds add-on'>${StuckQty} ${dataUnit} &chi; Rp. ${RateX} = Rp. ${TotalSaldoRate}</span></span>`)
                                                                        // cell1.html(`<span id="opClose"><span id='rtprtm' class='add-on'> Rp. ${StuckPrices} &chi; (${dataMinimumQty} - ${qty}) + Rp. ${dataRateSelanjutnyaX} = Rp. ${TotalSaldoRate}</span></span>`)
                                                                        cell1.html(`<span style="font-family:Fira Code;font-size:13px" id="opClose"><span id='rtprtm' class='add-on'><b> Rp. ${dataRateSelanjutnyaX} + ( ${leftQouter}  &chi;  Rp. ${Rate} ) = Rp. ${TotalSaldoRate}</b></span></span>`)
                                                                        // cell1.html(`<span id="opClose"><span id='rtprtm' class='add-on'> Rp. ${StuckPrices} &chi; (${dataMinimumQty} - ${qty} = ${StuckQty} ${dataUnit}) + Rp. ${dataRateSelanjutnyaX} = Rp. ${TotalSaldoRate}</span></span>`)

                                                                        $("#spantyf").html(`<span> Saldo Akhir <span style='margin:0px 69px'>: Rp. <span id='ttl' class='dds add-on'>${djl}</span></span></span>`)
                                                                        $("#SaldokgResults").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='SaldoResults' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                        $("#tmbahan").html(`<span> Total Rate <span style='margin:0px 76px'>: Rp. <span id='tmbhn' class='dds add-on'>${hasilRatedanMinimalRateX}</span></span></span>`)
                                                                        
                                                                        if(leftQouter == 0){
                                                                            $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                        } else {

                                                                            $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit} &minus; ${dataMinimumQty} (Minimal ${dataUnit}) = ${tambahanMinimalQty} ${dataUnit}</span></span></span>`)

                                                                        }

                                                                        $("#rateNexts").html(`<span> Rate Selanjutnya  <span style='margin:0px 24px'>: <span id='kgprtm' class='dds add-on'>Rp. ${TotalSaldoRate}</span></span></span>`)
                                                                        $("#rateFirst").html(`<span> Rate Pertama <span style='margin:0px 58px'>: Rp. <span id='rtprtm' class='dds add-on'>${RateX}</span></span></span>`)
                                                                        $("#clickme").removeAttr('disabled');
                                                                        $("#clickme").html("<i class='icon-plus'></i>");

                                                                        let codxxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                                    +`Kg actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                                    +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX}`+'<br/>'
                                                                                    +`Rate             : Rp. ${TotalSaldoRate}`

                                                                                    let arrLISTx = 
                                                                                            'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                                            'Kg Minimal       : '+`${dataMinimumQty} ${dataUnit}`+'\n'+
                                                                                            'Kg Actual        : '+`${qty} ${dataUnit}`+'\n'+
                                                                                            'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                            'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                            $('#detailnotesID').append($('<option>' ,{
                                                                                                            value:arrLISTx,
                                                                                                        text:arrLISTx
                                                                                                    }
                                                                                                )
                                                                                            )

                                                                        $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                            $(this).html(`${dataJsons.data.itemovdesc}
                                                                                <div class="row-fluid">
                                                                                            <div class="span12">
                                                                                                <hr>
                                                                                            </div>
                                                                                        </div>
                                                                                    <span style="text-align:left;font-family: Fira Code;font-size:12px"
                                                                                                <div class="row-fluid">
                                                                                                    <div class="span12">
                                                                                                        <span style="font-size:15px">
                                                                                                            Perhitungan detail transaksi pengiriman:
                                                                                                        </span>
                                                                                                        <hr>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br/>
                                                                                                <span id="xxxzx">
                                                                                            </span>
                                                                                    </span>`
                                                                                )
                                                                            }
                                                                        );

                                                                        $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                                            
                                                                            let detail = codxxxx.replace(/"/g, '');
                                                                            
                                                                            $(this).html('<pre><span style="font-size:15px">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                        }
                                                                    );
                                                                    
                                                                $("#exp").hide();
                                                            return
                                                            
                                                        }  
                                                                else 
                                                                        {

                                                                            rows = tBody.insertRow(rowIndex);
                                                                            // rows.insertCell(0);
                                                                            let indexx = $(rows.insertCell(0));
                                                                            let cell1 = $(rows.insertCell(1));

                                                                            let btnRemove = $("<span />");
                                                                            btnRemove.attr("id","plus");
                                                                            btnRemove.attr("style","cursor:pointer");
                                                                            btnRemove.attr("class", "icon-minus");
                                                                            btnRemove.attr("onclick", "toggleExpandCollapse(this);");
                                                                            indexx.append(btnRemove);

                                                                            cell1.attr("id","cell1");
                                                                            cell1.attr("class","xzx");

                                                                            $("#itemList tr").each(function(){
                                                                                    $(this)
                                                                                        .attr("class","parent")
                                                                            });

                                                                            cell1.colSpan = "5";
                                                                            rows.insertCell(2);
                                                                            rows.insertCell(3);
                                                                            rows.insertCell(4);
                                                                            Sub_services.html(dataJsons.data.sub_services.name)

                                                                            ItemList.html(dataJsons.data.itemovdesc+'<span id="xxxx"></span>')
                                                                            Qty.html(qty)
                                                                            // Harga.html("Rp. "+funcPrice)
                                                                            Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                                            cell1.html(`<span style="font-family:Fira Code;font-size:11px"><span id='rtprtm' class='dds add-on'><b>Rp. ${dataRateSelanjutnyaX} + ${StuckQtys} ${dataUnit} &chi; Rp. ${RateX} = Rp. ${TotalSaldoRate}</b></span></span>`)

                                                                            $("#kgSL").hide();
                                                                            $("#sldKSL").hide();
                                                                            $("#rateSL").show();
                                                                            $("#chi").show();

                                                                            $("#subtotal").html(`<span>Rp. ${djl}</span>`)
                                                                            $("#rateFirst").html(`<span> Rate Pertama <span style='margin:0px 58px'>: <span id='rtprtm' class='dds add-on'>${StuckQtys} ${dataUnit} &chi; Rp. ${RateX} = Rp. ${totalQtyRate}</span></span></span>`)
                                                                            $("#rateNexts").html(`<span> Rate kg pertama <span style='margin:0px 33px'>: <span id='kgprtm' class='dds add-on'>Rp. ${dataRateSelanjutnyaX}</span></span></span>`)
                                                                            $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                            $("#besides").html(`<span> Rate Selanjutnya <span style='margin:0px 24px'>: <span id='besideDD' class='dds add-on'>Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}</span></span></span>`)
                                                                            $("#TotalRT").html(`<span> Total Rate <span style='margin:0px 76px'>: <span id='asdasdasd' class='dds add-on'>Rp. ${TotalSaldoRate}</span></span></span>`)

                                                                            $("#clickme").removeAttr('disabled');
                                                                            $("#clickme").html("<i class='icon-plus'></i>");

                                                                            let codxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                                        +`Kg actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                                        +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX}`+'<br/>'
                                                                                        +`Rate pertama     : ${StuckQtys} ${dataUnit}  &chi;  Rp. ${RateX}`+'<br/>'
                                                                                        +`Rate selanjutnya : Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}`+'<br/>'
                                                                                        +`Rate             : Rp. ${TotalSaldoRate}` 

                                                                                        let arrLISTs = 
                                                                                            'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                                            'Kg Minimal       : '+`${dataMinimumQty} ${dataUnit}`+'\n'+
                                                                                            'Kg Actual        : '+`${qty} ${dataUnit}`+'\n'+
                                                                                            'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                            'Rate Pertama     : '+`Rp. ${StuckQtys} ${dataUnit} x Rp. ${RateX}`+'\n'+
                                                                                            'Rate Selanjutnya : '+`Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                            'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                            $('#detailnotesID').append($('<option>' ,{
                                                                                                            value:arrLISTs,
                                                                                                        text:arrLISTs
                                                                                                    }
                                                                                                )
                                                                                            )

                                                                            $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                                $(this).html(`${dataJsons.data.itemovdesc}
                                                                                <div class="row-fluid">
                                                                                        <div class="span12">
                                                                                            <hr>
                                                                                        </div>
                                                                                    </div>
                                                                                <span style="text-align:left;font-family: Fira Code;font-size:12px"
                                                                                            <div class="row-fluid">
                                                                                                <div class="span12">
                                                                                                    <span style="font-size:15px">
                                                                                                        Perhitungan detail transaksi pengiriman:
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </div>
                                                                                            </div>
                                                                                            <br/>
                                                                                            <span id="xxxz">
                                                                                        </span>
                                                                                </span>`
                                                                            )
                                                                            /**
                                                                             * Customize DOM to expose component actually
                                                                             * 
                                                                            */
                                                                            //    <span> Kg Minimal
                                                                            //         <span style='margin:0px 46px'>: 
                                                                            //             <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span>
                                                                            //             </span>
                                                                            //     </span>
                                                                            //     <br/>
                                                                            //     <span> Rate kg pertama <span style='margin:0px 10px'>: 
                                                                            //         <span id='kgprtm' class='dds add-on'>Rp. ${dataRateSelanjutnyaX}</span>
                                                                            //         </span>
                                                                            //     </span>
                                                                            //     <br/>
                                                                            //     <span> Rate Pertama <span style='margin:0px 32px'>: 
                                                                            //         <span id='rtprtm' class='dds add-on'>${StuckQty} ${dataUnit}  &chi;  Rp. ${RateX}</span>
                                                                            //         </span>
                                                                            //     </span>
                                                                            //     <br/>
                                                                            //     <span> Rate Selanjutnya <span style='margin:0px 3px'>:
                                                                            //         <span id='besideDD' class='dds add-on'>Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}</span>
                                                                            //         </span>
                                                                            //     </span>
                                                                            //     <br/>
                                                                            //     <span> Total Rate <span style='margin:0px 48px'>: 
                                                                            //         <span id='asdasdasd' class='dds add-on'>Rp. ${TotalSaldoRate}</span>
                                                                            //     </span>
                                                                            // </span>
                                                                        }
                                                                    );

                                                                    $("#itemList tr").find("#xxxz").parent().each(function(){
                                                                        
                                                                        let detail = codxxx.replace(/"/g, '');
                                                                            
                                                                            $(this).html('<pre><span style="font-size:15px">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                    }
                                                                );

                                                        $("#exp").hide();
                                                    return

                                                }
                                        }
                                                
                                }

                        }
                                
                }

        }
        
        $( "#clicksOpenClosed" ).click(function () {
            if ( $( "#hint" ).is( ":hidden" ) ) {
                $( "#hint" ).slideDown( "slow" );
            } else {
                $( "#hint" ).slideUp("slow");
            }
        });

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var contents = this.nextElementSibling;
        if (contents.style.display === "block") {
            setTimeout(function() {
                contents.style.display = "none";
            }, 1000);
        } else {
            setTimeout(function() {
                contents.style.display = "block";
            }, 1000);
        }
    });
    }

function sum(arrayData, total){
    let data =0;
return arrayData.reduce((a,b) => {
        return data += a + b +total
    })
}

async function StoreOrderTransport() {
        
        const SuccessAlertsTransportAPI = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 7500
        })

        let customers = $("#customers_name").val();
        let id_project = $("#id_project").val();
                    
        // origin
        let saved_origin = $("#saved_origin").val();
        let origin = $("#origin").val();
        let origin_city = $("#origin_city").val();
        let origin_address = $("#origin_address").val();
        let pic_phone_origin = $("#pic_phone_origin").val();
        let pic_name_origin = $("#pic_name_origin").val();
        let id_origin_city = $("#id_origin_city").val();

        // destination
        let saved_destination = $("#saved_destination").val();
        let destination = $("#destination").val();
        let destination_city = $("#destination_city").val();
        let destination_address = $("#destination_address").val();
        let pic_phone_destination = $("#pic_phone_destination").val();
        let pic_name_destination = $("#pic_name_destination").val();
        let id_destination_city = $("#id_destination_city").val();

        // detail order
        let sub_servicess = $("#sub_servicess").val();
        let items_tc = $("#items_tc").val();
        let qty = $("#qty").val();
        let harga = $("#rate").val();
        let total_rate = $("#total_rate").val();
        let etd = $("#etd").val();
        let eta = $("#eta").val();
        let time_zone = $("#time_zone").val();

        let collie = $("#collie").val();
        let volume = $("#volume").val();
        let actual_weight = $("#actual_weight").val();
        let chargeable_weight = $("#chargeable_weight").val();
        let notes = $("#notes").val();

        let document_referenceArray = new Array();
        let document_referenceArrayQTY = new Array();
        let document_referenceArrayPRICE = new Array();
        let document_referenceArrayDETAILNOTE = new Array();
        let document_referenceArrayitemDiscount = new Array();
        let document_reference = document.getElementById('itemID');
        let document_referenceQTY = document.getElementById('qtyID');
        let document_referencePRICE = document.getElementById('priceID');
        let document_referenceDETAILNOTES = document.getElementById('detailnotesID');
        let document_referenceitemDiscount = document.getElementById('itemDiscount');

        for (i = 0; i < document_reference.options.length; i++) {

            document_referenceArray[i] = document_reference.options[i].value;

            }

                let itemID = [];

                for (i = 0; i < document_referenceArray.length; i++) {

                    itemID.push(document_referenceArray[i]);

        }

        for (i = 0; i < document_referenceQTY.options.length; i++) {

            document_referenceArrayQTY[i] = document_referenceQTY.options[i].value;

            }

                let qtyID = [];

                for (i = 0; i < document_referenceArrayQTY.length; i++) {

                    qtyID.push(document_referenceArrayQTY[i]);

            }

            for (i = 0; i < document_referencePRICE.options.length; i++) {

                document_referenceArrayPRICE[i] = document_referencePRICE.options[i].value;

                }

                    let priceID = [];

                    for (i = 0; i < document_referenceArrayPRICE.length; i++) {

                        priceID.push(document_referenceArrayPRICE[i]);

                }
                
                for (i = 0; i < document_referenceDETAILNOTES.options.length; i++) {

                    document_referenceArrayDETAILNOTE[i] = document_referenceDETAILNOTES.options[i].value;

                        }

                            let detailNotesID = [];

                            for (i = 0; i < document_referenceArrayDETAILNOTE.length; i++) {

                                detailNotesID.push(document_referenceArrayDETAILNOTE[i]);

                        }

                        for (i = 0; i < document_referenceitemDiscount.options.length; i++) {

                                document_referenceArrayitemDiscount[i] = document_referenceitemDiscount.options[i].value;

                            }

                                let itemDiscount = [];

                                for (i = 0; i < document_referenceArrayitemDiscount.length; i++) {

                                    itemDiscount.push(document_referenceArrayitemDiscount[i]);

                            }

            const apiTransports = "{{ route('transport.stored.static', $some ) }}";
            const dataTransports = { 

                        token : "{{ csrf_token() }}",
                        customers: customers,
                        id_project: id_project,

                        // origin
                        saved_origin: saved_origin,
                        origin: origin,
                        itemID: itemID,
                        priceID: priceID,
                        qtyID: qtyID,
                        origin_city: origin_city,
                        origin_address: origin_address,
                        pic_phone_origin: pic_phone_origin,
                        pic_name_origin: pic_name_origin,
                        id_origin_city: id_origin_city,

                        // destination 
                        saved_destination: saved_destination,
                        destination: destination,
                        destination_city: destination_city,
                        destination_address: destination_address,
                        pic_phone_destination: pic_phone_destination,
                        pic_name_destination: pic_name_destination,
                        id_destination_city: id_destination_city,

                        // detail order 
                        sub_servicess:sub_servicess, //array
                        items_tc:items_tc, //array
                        harga:harga, //array
                        qty:qty, //array
                        detailNotesID:detailNotesID,
                        itemDiscount:itemDiscount,
                        total_rate:total_rate,
                        eta:eta,
                        etd:etd,
                        time_zone:time_zone,
                        
                        collie:collie,
                        volume:volume,
                        actual_weight:actual_weight,
                        chargeable_weight:chargeable_weight,
                        notes:notes
                       
                    };

    try 
        {
            const responseTransport = await fetch(apiTransports, {

                    method: 'GET',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    redirect: 'follow',
                    referrer: 'no-referrer',
                    body: JSON.stringify(dataTransports),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                }

            });

            const dataJson = await responseTransport.json();
            let TransportPromise = new Promise((resolve, reject) => {
                setTimeout(() => resolve(dataJson), 1000)
            });

                let transportPromises = await TransportPromise;

            //customer 
            $("#customers_name").empty();
            // id_project ->  customer in izzy refs['customers_name']
            $("#id_project").val('');
            
            // origin detail
            $("#saved_origin").empty();
            $("#origin").val('');
            $("#origin_city").val('');
            $("#origin_address").val('');
            $("#origin_city").empty();
            $("#pic_phone_origin").val('');
            $("#pic_name_origin").val('');
            $("#id_origin_city").val('');

            // destination detail
            $("#saved_destination").empty();
            $("#destination_city").empty();
            $("#destination").val('');
            $("#destination_city").val('');
            $("#destination_address").val('');
            $("#pic_phone_destination").val('');
            $("#pic_name_destination").val('');
            $("#id_destination_city").val('');

            //detail order transport
            $("#sub_servicess").empty();
            $("#items_tc").empty();
            $("#qty").val('');
            $("#total_rate").val('');
            $("#eta").val('');
            $("#etd").val('');
            $("#time_zone").val('');
            $("#rate").val('');
            
            $("#collie").val('');
            $("#volume").val('');
            $("#actual_weight").val('');
            $("#chargeable_weight").val('');
            $("#notes").val('');
                
            $("#addorders").prop("disabled", false);
            $("#addorders").text("Order Now");

            // console.log('Success:', JSON.stringify(transportPromises.order_id));
            // return redirect()->route('transport.static', session()->get('id'));
            // let leavemeplease = document.location.href = "{!! route('transport.static', session()->get('id')); !!}";

            // return leavemeplease;
            // SuccessAlertsTransportAPI.fire({
            //     type: 'success',
            //     title: transportPromises.success +''+ 
            // })
        } 
            catch (errors) {
              
                $.ajaxSetup(
                                {
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                        }
                    )
                ;

                let request = $.ajax({
                
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: apiTransports,
                type: "GET",
                dataType: "json",
                data: dataTransports,
                success: function (data) {

                    // console.log('data-success',data)
                    // do something else without data
                        
            },
            complete:function(data){

                // TODO: do something with complete arguments
             
            },
                error: function(jqXhr, json, errorThrown){
                 
                    let responses = $.parseJSON(jqXhr.responseText).errors;
                        errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each( responses, function( key, value ) {
                            errorsHtml +=  value[0] +'<br/>';
                        }
                    );
                        errorsHtml += '</ul></div>';
                        buttonconfirm = '<div class="badge badge-info closeme" style="font-size:14px;height:19px;width:40px;cursor: pointer">Okay</div>';
                        let TransportPromise = new Promise((resolve, reject) => {
                            setTimeout(() =>        
                                    Swal({
                                    title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                    text: "Maaf proses upload gagal diproses !",
                                        confirmButtonColor: '#3085d6',
                                        html: errorsHtml +'<br/>'+ buttonconfirm,
                                        width: 'auto',
                                        showConfirmButton: false,
                                        // confirmButtonText: '<div class="badge badge-success">Ok</div>',
                                        type: 'error'
                                    }).then((result) => {
                                    if (result.value) {

                                            return false;
                                
                                }
                        }),
                            $("#addorders").prop("disabled", false),
                            $("#addorders").text("Order Now"), 1000)
                    });
                }
            }
        );
                // const ErrorsAlertsTransportAPI = Swal.mixin({
                //     toast: true,
                //     position: 'bottom-end',
                //     showConfirmButton: false,
                //     timer: 7000
                // })

                // let TransportPromiseErrors = new Promise((resolve, reject) => {
                //     setTimeout(() => reject(console.error('Error:', errors)), 2000)
                // });

                    // ErrorsAlertsTransportAPI.fire({
                    //     type: 'error',
                    //     title: `Data gagal disimpan `+ errors
                    // })

            }

    }

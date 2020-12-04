async function stall(stallTime = 3000) {
    await new Promise(resolve => setTimeout(resolve, stallTime));
}

function formatMoney(amount, float = 2, decimal = ".", thousands = ",") {

try {

float = Math.abs(float);
float = isNaN(float) ? 2 : float;

const negativeSign = amount < 0 ? "-" : "";

let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(float)).toString();
let j = (i.length > 3) ? i.length % 3 : 0;

return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (float ? "" : "");
}
catch (e) {
    swal("Something else!", "Number is not function")
    
}

};

$(document).ready(function() {

document.getElementById("pricesz").style.display ='none';
$(".loaders").hide();
$(".Counter").hide();
$("#method").hide();
$("#dataResults").hide();
$("#spanText").attr('style', 'font-family:Quicksand');
$("#itemList > TBODY").attr("class","tbodys");
$("#itemList > TBODY").attr("styl","tbodys");
$("#waitings").hide();
$("#exp").hide();
$("#clickme").hide()
$('.parent').parent().append($('.parent').get().reverse());

$( "#rate" ).keyup(function( event ) {
// if (parseInt($(this).val()) == 0 || this.value.length === 0 || event.which === 48 || event.which == 13 || event.keyCode == 13) {
if (this.value.length === 0 || event.which == 13 || event.keyCode == 13) {
    event.preventDefault();
    
        $("#clickme").hide()

    } else {
        $("#clickme").show()

    }

});
})


$('#plus').live('click', function(e){ 
e.preventDefault();
$(this).closest('tr').slideToggle(100);
});

function getObjectLength( obj )
{
var length = 0;
for ( var p in obj )
{
if ( obj.hasOwnProperty( p ) )
{
length++;
}
}
return length;
}

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

let totalCount = 0;

function DecrementLimit()
{
totalCount--;
}

async function Limit(cabang, idItem, qty, price, totalHarga, topup) {

/**
Modal window position, can be 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'.
*/
const toast = Swal.mixin({
            toast: true,
            position: 'center-end',
            showConfirmButton: false,
            timer: 6000
    });

if(totalCount >= 3)
{
$(".Counter").hide();
$("#dataResults").show();

toast.fire({    
        type: "error",
        title: "maaf anda tidak bisa menambahkan lagi.. "
    })
return false;
}
else
{
    totalCount++;
        if(qty < 1) {
                    toast.fire({    
                        type: "error",
                        title: "Maaf Qty minimal 1 (kg/koli/m3)?"
                    })
                        setTimeout(() =>$(".loaders").hide(), $(".waitings").hide(),1500);
                    return false;
        } else
                {

                    $("#itemList > THEAD > TBODY").show()

                        const tBody = $("#itemList > TBODY")[0];
                        let rowIndex = document.getElementById("ID").rowIndex;
                        let rows = tBody.insertRow(rowIndex);
                            rows = tBody.insertRow(rowIndex);
                            $(rows.insertCell(0));
                            let cell1 = $(rows.insertCell(1));
                                        rows.insertCell(2);
                                        rows.insertCell(3);
                                        rows.insertCell(4);
                                        rows.insertCell(5);

                            cell1.attr("id","waitings");
                            cell1.colSpan = "6";
                            cell1.html(`<div class="loaders row-fluid">
                                <img src="{{ url('http://devyour-api.co.id/img/FhHRx.gif') }}" id="form_loading_img" alt="Sedang memuat history order" style="display:none;display: block;margin-left: auto;margin-right: auto;">
                            </div>`);

                        return new Promise((resolve, reject) => {
                            setTimeout(() => resolve(FetchDetailItemCustomer(cabang, idItem, qty, price, totalHarga, topup)),3500)
                        }
                    );
            }
        return true;
    }
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
$("#dataResults").hide();
$(".Counter").show();
$("#method").hide();

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

    var table = document.getElementById('itemList');  
    var ArrY = new Array()  
    var count = table.rows.length;  
    for(var i=0; i<count; i++) {    
        ArrY.push(i);    
    }

    const sweeterArray = ArrY.map(sweetItem => {
        return sweetItem
    })

Limit(cabang, idItem, qty, price, totalHarga, topup)

}


function stripquotes(a) {
if (a.charAt(0) === '"' && a.charAt(a.length-1) === '"') {
return a.substr(1, a.length-2);
}
return a;
}


function onSubmit() {
console.log("Done");
}

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
        $("#itemList tr").find("#waitings").parent().each(function(){
            $(this).closest("tr").hide();
        })

    }
    
    const dataJsons = await responsetest.json();

    const dataMinimumQty = JSON.stringify(dataJsons.data.batch_itemCustomer.itemMinimumQty);
    const dataRateSelanjutnya = JSON.stringify(dataJsons.data.batch_itemCustomer.rateKgFirst);
    const dataprice = JSON.stringify(dataJsons.data.price);
    const dataUnit = JSON.stringify(dataJsons.data.unit);

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
                            
                    /**
                     * metode pertama
                    */
                    if(dataMinimumQty == 0 && dataRateSelanjutnya == 0){

                        $('#topup').append($('<option>' ,{
                            value:totalHarga.replace(/\D/g, ''),
                            text:totalHarga.replace(/\D/g, '')
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

                                                if(parseInt(qty) < parseInt(dataMinimumQty)){

                                                    tambahanMinimalQty = dataMinimumQty*parseInt(Rate);
                                                    StuckQty = dataMinimumQty;
                                                    StuckPrices = Rate;
                                                    wom = dataMinimumQty;
                                                                                
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

                                        tambahanMinimalQty = dataMinimumQty-qty;
                                            StuckQty = tambahanMinimalQty;

                                            if(tambahanMinimalQty == 0){

                                                        leftQouter = 0;
                                                        tambahanMinimalQty = qty;
                                                        StuckQty = tambahanMinimalQty;

                                                    } 
                                                        else {

                                                            tambahanMinimalQty = Math.abs(tambahanMinimalQty)

                                                            StuckQty = tambahanMinimalQty;

                                                    }

                                                        if(parseInt(dataMinimumQty) >= parseInt(qty)){
                                                            if(parseInt(dataMinimumQty) == parseInt(qty)){

                                                                    leftQouter = 0;
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
                                                            } else 
                                                                    {

                                                                        leftQouter = 0;

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
                                                            }

                                                        } 
                                                            else 
                                                                    {

                                                                        leftQouter = 0;

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
                                                                    }

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

                                        totalcategory2 = parseFloat(saldoakhir)

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
                let Actions = $(row.insertCell(5));
                const djl = formatMoney(`${total}`);
                const priceXV = formatMoney(`${price}`);

                $("#itemList tr").each(function(){
                        $(this)
                            .attr("class","parent")
                });

                let celluuid = $(row.insertCell(6));
                let notes = $(row.insertCell(7));
                
                /**
                 * metode pertama [default] tidak ada nilai reduce value pada itemDiscount
                 **/

                let btnRemovejc = $("<input />");
                    btnRemovejc.attr("style","cursor:pointer");
                    btnRemovejc.attr("type","button");
                    btnRemovejc.attr("class", "btn btn-danger");
                    btnRemovejc.attr("onclick", "RemoveDetailItemOrdersWithoutDiscount(this);");
                    btnRemovejc.val("-");
                    Actions.append(btnRemovejc);

                Sub_services.html(dataJsons.data.sub_services.name)
                celluuid.attr("id","uid_services");
                celluuid.attr("class","hidden");
                celluuid.html(dataJsons.data.id);
                
                ItemList.html('<span id="xxxx"></span>')

                Qty.html(qty)
                Harga.html("Rp. "+priceXV)
                Price.html("Rp. "+totalHarga)
                Actions.html(btnRemovejc)
                $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                $('#subtotal').each(function () {
                        $(this).prop('Counter',0).animate({
                            Counter: total
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function (now) {
                                return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                            }
                        });
                    });

                    let codxxxx = `Rate          : Rp. ${Rate}  &chi;  ${qty} ${dataUnit}`+'<br/>'+`Total rate    : Rp. ${totalHarga}` 
                          
                            let arrLISTsQ = 
                                    'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                    'Rate (Normal) : '+`Rp. ${Rate} x ${qty} ${JSON.parse(dataUnit)}` +'\n'+
                                    'Total rate    : '+`Rp. ${totalHarga}`

                                    $('#detailnotesID').append($('<option>' ,{
                                                    value:arrLISTsQ,
                                                text:arrLISTsQ
                                            }
                                        )
                                    )

                                    notes.attr("id","detailnotes");
                                    notes.attr("class","hidden");
                                    notes.html(arrLISTsQ);

                            $("#itemList tr").find("#xxxx").parent().each(function(){
                                $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                <div class="row-fluid">
                                        <div class="span12">
                                            <hr>
                                        </div>
                                    </div>
                                <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <span style="font-size:15px;font-family:Quicksand">
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
                                
                                $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')

                            }
                        );

                    $("#exp").hide();

                    await stall()

                    $("#method").show();

                    $("#method").html(`<span class="badge badge-info">Model Rate - 1</span>`)

                    $('#method').animate('slideFromRight scaleTo', {
                        "custom": {
                            "slideFromRight": {
                            "duration": 4000,
                            "direction": "normal"
                            }
                        }
                    });

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

                                let Sub_services = $(row.insertCell(0));
                                let ItemList = $(row.insertCell(1));
                                let Qty = $(row.insertCell(2));
                                let Harga = $(row.insertCell(3));
                                let Price = $(row.insertCell(4));
                                let Actions = $(row.insertCell(5));

                                const djl = formatMoney(`${totalcategory2}`);
                                const changeCuountRate = formatMoney(`${resultCountRate}`);
                                const tmbn = formatMoney(`${saldoakhir}`);
                                const funcPriceX = formatMoney(`${StuckPrices}`);
                                const RateTwo = formatMoney(`${Rate}`);


                                $("#itemList tr").each(function(){
                                        $(this)
                                            .attr("class","parent")
                                });

                                let celluuid = $(row.insertCell(6));
                                let notes = $(row.insertCell(7));

                                /**
                                 * metode kedua ada nilai reduce value pada itemDiscount
                                 **/

                                let btnRemovejc = $("<input />");
                                    btnRemovejc.attr("style","cursor:pointer");
                                    btnRemovejc.attr("type","button");
                                    btnRemovejc.attr("class", "btn btn-danger");
                                    btnRemovejc.attr("onclick", "RemoveDetailItemOrdersWithoutDiscount(this);");
                                    btnRemovejc.val("-");
                                    Actions.append(btnRemovejc);

                                Sub_services.html(dataJsons.data.sub_services.name)
                                celluuid.attr("id","uid_services")
                                celluuid.attr("class","hidden")
                                celluuid.html(dataJsons.data.id)
                                ItemList.html('<span id="xxxx"></span>')

                                Actions.html(btnRemovejc)

                                Qty.html(StuckQty)
                                Price.html("Rp. "+changeCuountRate)
                                $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                                    $('#subtotal').each(function () {
                                        $(this).prop('Counter',0).animate({
                                            Counter: totalcategory2
                                        }, {
                                            duration: 4000,
                                            easing: 'swing',
                                            step: function (now) {
                                                return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                            }
                                        });
                                    });

                                let codxxxx = `Kg Minimal    : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                            +`Kg Actual     : ${qty} ${dataUnit}`+'<br/>'
                                            +`Rate pertama  : Rp. ${RateTwo} &chi; ${wom} ${dataUnit}`+'<br/>'
                                            +`Rate          : Rp. ${changeCuountRate}`

                                            let arrLISTQx = 
                                                    'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                    'Kg Minimal    : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                    'Kg Actual     : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                    'Rate pertama  : '+`Rp. ${RateTwo} x ${wom} ${JSON.parse(dataUnit)}`+'\n'+
                                                    'Rate          : '+`Rp. ${changeCuountRate}`

                                                    $('#detailnotesID').append($('<option>' ,{
                                                                    value:arrLISTQx,
                                                                text:arrLISTQx
                                                            }
                                                        )
                                                    )

                                                    notes.attr("id","detailnotes")
                                                    notes.attr("class","hidden")
                                                    notes.html(arrLISTQx)
                                                        
                                                $("#itemList tr").find("#xxxx").parent().each(function(){
                                                    $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                    <div class="row-fluid">
                                                            <div class="span12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                <div class="row-fluid">
                                                                    <div class="span12">
                                                                        <span style="font-size:15px;font-family:Quicksand">
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
                                                
                                                $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                            }
                                        );

                                    $("#exp").hide();

                                    await stall()
                                    
                                    $("#method").show();
                                    
                                    $("#method").html(`<span class="badge badge-info">Model Rate - 2</span>`)
                                    
                                    $('#method').animate('slideFromRight scaleTo', {
                                            "custom": {
                                                "slideFromRight": {
                                                "duration": 4000,
                                                
                                                "direction": "normal"
                                                }
                                            }
                                        });

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
                                            let Actions = $(row.insertCell(5));

                                            const djl = formatMoney(`${totalcategory2}`);
                                            const totalQtyRate = formatMoney(`${Besides}`);
                                            const tmbn = formatMoney(`${saldoakhir}`);
                                            const TotalSaldoRate = formatMoney(`${SaldoBiayaTambahan}`);
                                            const funcPrice = formatMoney(`${StuckPrices}`);
                                            const dataRateSelanjutnyaX = formatMoney(`${dataRateSelanjutnya}`);
                                            const hasilRatedanMinimalRateX = formatMoney(`${ResultRate}`);
                                            const RateX = formatMoney(`${Rate}`);
                                            
                                            if(dataMinimumQty == qty){

                                                $("#itemList tr").each(function(){
                                                        $(this)
                                                            .attr("class","parent")
                                                });

                                                let celluuid = $(row.insertCell(6));
                                                let notes = $(row.insertCell(7));

                                                /**
                                                 * metode ketiga ada nilai reduce value pada itemDiscount
                                                 **/

                                                let btnRemovejc = $("<input />");
                                                    btnRemovejc.attr("style","cursor:pointer");
                                                    btnRemovejc.attr("type","button");
                                                    btnRemovejc.attr("class", "btn btn-danger");
                                                    btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);");
                                                    btnRemovejc.val("-");
                                                    Actions.append(btnRemovejc);

                                                Sub_services.html(dataJsons.data.sub_services.name)

                                                celluuid.attr("id","uid_services")
                                                celluuid.attr("class","hidden")
                                                celluuid.html(dataJsons.data.id)

                                                ItemList.html('<span id="xxxx"></span>')
                                               
                                                Qty.html(qty)
                                                
                                                Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                
                                                Actions.html(btnRemovejc)
                                                
                                                $("#kgSL").show();
                                                $("#sldKSL").hide();
                                                $("#rateSL").show();
                                                $("#chi").show();

                                                $('#subtotal').each(function () {
                                                    $(this).prop('Counter',0).animate({
                                                        Counter: totalcategory2
                                                    }, {
                                                        duration: 4000,
                                                        easing: 'swing',
                                                        step: function (now) {
                                                            return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        }
                                                    });
                                                });

                                                $("#subtotal").html(`<span id="subtotal">${djl}</span>`)
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
                                                            'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                            'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                            'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                            'Rate             : '+`Rp. ${TotalSaldoRate}`
                                                            
                                                            notes.attr("id","detailnotes")
                                                            notes.attr("class","hidden")
                                                            notes.html(arrLISTb)

                                                                $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                    $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                    <div class="row-fluid">
                                                                            <div class="span12">
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                    <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                <div class="row-fluid">
                                                                                    <div class="span12">
                                                                                        <span style="font-size:15px;font-family:Quicksand">
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
                                                                
                                                                $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                    
                                                                }
                                                            );

                                                                $('#detailnotesID').append($('<option>' ,{
                                                                        value:arrLISTb,
                                                                    text:arrLISTb
                                                                }
                                                            )
                                                        )

                                                    $("#exp").hide();

                                                    await stall()
                                                    
                                                    $("#method").show();
                                                    
                                                    $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)
                                                    
                                                    $('#method').animate('slideFromRight scaleTo', {
                                                            "custom": {
                                                                "slideFromRight": {
                                                                "duration": 4000,
                                                                
                                                                "direction": "normal"
                                                                }
                                                            }
                                                        });

                                                return

                                            } 
                                                else {

                                                    if(parseInt(dataMinimumQty) >= parseInt(qty)){

                                                        let celluuid = $(row.insertCell(6));
                                                        let notes = $(row.insertCell(7));

                                                            $("#itemList tr").each(function(){
                                                                    $(this)
                                                                        .attr("class","parent")
                                                            });

                                                            /**
                                                             * metode ketiga ada nilai reduce value pada itemDiscount
                                                             **/

                                                            let btnRemovejc = $("<input />");
                                                                btnRemovejc.attr("style","cursor:pointer");
                                                                btnRemovejc.attr("type","button");
                                                                btnRemovejc.attr("class", "btn btn-danger");
                                                                btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);")
                                                                btnRemovejc.val("-");
                                                                Actions.append(btnRemovejc);

                                                            Sub_services.html(dataJsons.data.sub_services.name)

                                                            celluuid.attr("id","uid_services")
                                                            celluuid.attr("class","hidden")
                                                            celluuid.html(dataJsons.data.id)

                                                            ItemList.html('<span id="xxxx"></span>')
                                                            Qty.html(qty)
                                                            Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                            
                                                            Actions.html(btnRemovejc)

                                                            $("#besidesID").hide();
                                                            $("#TotalRTID").hide();
                                                            $("#kgSL").hide();
                                                            $("#sldKSL").show();
                                                            $("#rateSL").show();
                                                            $("#chi").show();
                                                            $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                                                            $("#spantyf").html(`<span> Saldo Akhir <span style='margin:0px 69px'>: Rp. <span id='ttl' class='dds add-on'>${djl}</span></span></span>`)
                                                            $("#SaldokgResults").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='SaldoResults' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                            $("#tmbahan").html(`<span> Total Rate <span style='margin:0px 76px'>: Rp. <span id='tmbhn' class='dds add-on'>${hasilRatedanMinimalRateX}</span></span></span>`)
                                                            
                                                            if(leftQouter == 0){
                                                                $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                            } else {

                                                                $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit} &minus; ${dataMinimumQty} (Minimal ${dataUnit}) = ${tambahanMinimalQty} ${dataUnit}</span></span></span>`)

                                                            }

                                                            $('#subtotal').each(function () {
                                                                $(this).prop('Counter',0).animate({
                                                                    Counter: totalcategory2
                                                                }, {
                                                                    duration: 4000,
                                                                    easing: 'swing',
                                                                    step: function (now) {
                                                                        return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                                    }
                                                                });
                                                            });

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
                                                                                'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                $('#detailnotesID').append($('<option>' ,{
                                                                                                value:arrLISTx,
                                                                                            text:arrLISTx
                                                                                        }
                                                                                    )
                                                                                )

                                                                notes.attr("id","detailnotes")
                                                                notes.attr("class","hidden")
                                                                notes.html(arrLISTx)

                                                            $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                    <div class="row-fluid">
                                                                                <div class="span12">
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                        <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                    <div class="row-fluid">
                                                                                        <div class="span12">
                                                                                            <span style="font-size:15px;font-family:Quicksand">
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
                                                                
                                                                $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                            }
                                                        );
                                                        
                                                    $("#exp").hide();
                                                    
                                                    await stall()

                                                    $("#method").show();

                                                    $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)
                                                    
                                                    $('#method').animate('slideFromRight scaleTo', {
                                                            "custom": {
                                                                "slideFromRight": {
                                                                "duration": 4000,
                                                                
                                                                "direction": "normal"
                                                                }
                                                            }
                                                        });

                                                return
                                                
                                            }  
                                                    else 
                                                            {

                                                                let celluuid = $(row.insertCell(6));
                                                                let notes = $(row.insertCell(7));

                                                                $("#itemList tr").each(function(){
                                                                        $(this)
                                                                            .attr("class","parent")
                                                                });

                                                                /**
                                                                 * metode ketiga ada nilai reduce value pada itemDiscount
                                                                 **/

                                                                let btnRemovejc = $("<input />");
                                                                    btnRemovejc.attr("style","cursor:pointer");
                                                                    btnRemovejc.attr("type","button");
                                                                    btnRemovejc.attr("class", "btn btn-danger");
                                                                    btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);");
                                                                    btnRemovejc.val("-");
                                                                    Actions.append(btnRemovejc);

                                                                Sub_services.html(dataJsons.data.sub_services.name)
                                                              
                                                                celluuid.attr("id","uid_services")
                                                                celluuid.attr("class","hidden")
                                                                celluuid.html(dataJsons.data.id)

                                                                ItemList.html('<span id="xxxx"></span>')
                                                                
                                                                Qty.html(qty)

                                                                Price.html("Rp. "+ hasilRatedanMinimalRateX)

                                                                Actions.html(btnRemovejc)

                                                                $("#kgSL").hide();
                                                                $("#sldKSL").hide();
                                                                $("#rateSL").show();
                                                                $("#chi").show();

                                                                $('#subtotal').each(function () {
                                                                    $(this).prop('Counter',0).animate({
                                                                        Counter: totalcategory2
                                                                    }, {
                                                                        duration: 4000,
                                                                        easing: 'swing',
                                                                        step: function (now) {
                                                                            return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                                        }
                                                                    });
                                                                });

                                                                $("#subtotal").html(`<span id="subtotal">${djl}</span>`)
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

                                                                            let arrLISTsF = 
                                                                                'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                                'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                'Rate Pertama     : '+`Rp. ${StuckQtys} ${JSON.parse(dataUnit)} x Rp. ${RateX}`+'\n'+
                                                                                'Rate Selanjutnya : '+`Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}`+'\n'+
                                                                                'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                $('#detailnotesID').append($('<option>' ,{
                                                                                                value:arrLISTsF,
                                                                                            text:arrLISTsF
                                                                                        }
                                                                                    )
                                                                                )

                                                                    notes.attr("id","detailnotes")
                                                                    notes.attr("class","hidden")
                                                                    notes.html(arrLISTsF)

                                                                $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                    $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                    <div class="row-fluid">
                                                                            <div class="span12">
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                    <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                <div class="row-fluid">
                                                                                    <div class="span12">
                                                                                        <span style="font-size:15px;font-family:Quicksand">
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
                                                            }
                                                        );

                                                        $("#itemList tr").find("#xxxz").parent().each(function(){
                                                            
                                                            let detail = codxxx.replace(/"/g, '');
                                                                
                                                                $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                        }
                                                    );

                                            $("#exp").hide();
                                            
                                            await stall()

                                            $("#method").show();

                                            $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)

                                            $('#method').animate('slideFromRight scaleTo', {
                                                    "custom": {
                                                        "slideFromRight": {
                                                        "duration": 4000,
                                                        
                                                        "direction": "normal"
                                                        }
                                                    }
                                                });

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

        if(data){

            let cabang = "{{ $some }}";
                let link = '{!! route("transport.static", ":cabang")  !!}';
                let redirect = link.replace(":cabang",cabang)

                setTimeout(function(){ 

                    window.location.href = redirect;

            }, 4500);

        } else {

            const ErrorsAlertsTransportAPI = Swal.mixin({
                toast: true,
                position: 'bottom-top',
                showConfirmButton: false,
                timer: 7000
            })

                ErrorsAlertsTransportAPI.fire({
                    type: 'error',
                    title: `Data gagal disimpan `
                })

        }
            
},
complete:function(data){

    // TODO: do something with complete arguments
 
},
    error: function(jqXhr, json, errorThrown){
     
        let responses = JSON.parse(jqXhr.responseText).errors;
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

}
}

function animateVal(obj, start=0, end=100, steps=100, duration=500) {   
start = parseFloat(start)
end = parseFloat(end)

let stepsize = (end - start) / steps
let current = start
var stepTime = Math.abs(Math.floor(duration / (end - start)));
let stepspassed = 0
let stepsneeded = (end - start) / stepsize

let x = setInterval( () => {
    current += stepsize
    stepspassed++
    obj.innerHTML = Math.round(current * 1000) / 1000 
if (stepspassed >= stepsneeded) {
    clearInterval(x)
}
}, stepTime)
}   

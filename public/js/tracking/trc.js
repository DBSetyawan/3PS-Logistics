const alertx = document.getElementById('alertx');
const alertxNotfound = document.getElementById('alertxNotfound');
const menu = document.getElementById('menu');
const toggle = () => menu.classList.toggle("hidden");
const detailTransaksi = document.getElementById('detailTransaksi');
const reetailTransaksi = document.getElementById('detailTransaksi');
const cldetailTransaksi = document.getElementById('detailTransaksi');
const open = document.getElementById('open');
const opened = document.getElementById('opened');
const appsd = document.getElementById('appsd');
const OtoggleDetailTransaksi = () => detailTransaksi.classList.toggle("hidden") || open.classList.toggle("hidden");
const REtoggleDetailTransaksi = () => reetailTransaksi.classList.toggle("hidden") || appsd.classList.toggle("hidden") || opened.classList.toggle("hidden"); 
const CtoggleDetailTransaksi = () => appsd.classList.toggle("hidden") || cldetailTransaksi.classList.toggle("hidden");
alertx.classList.toggle("hidden")
alertxNotfound.classList.toggle("hidden")

var openmodal = document.querySelectorAll('.modal-open')
for (var i = 0; i < openmodal.length; i++) {
    openmodal[i].addEventListener('click', function (event) {
        event.preventDefault()
        toggleModal()
    })
}

const overlay = document.querySelector('.modal-overlay')
overlay.addEventListener('click', toggleModal)

var closemodal = document.querySelectorAll('.modal-close')
for (var i = 0; i < closemodal.length; i++) {
    closemodal[i].addEventListener('click', toggleModal)
}

document.onkeydown = function (evt) {
    evt = evt || window.event
    var isEscape = false
    if ("key" in evt) {
        isEscape = (evt.key === "Escape" || evt.key === "Esc")
    } else {
        isEscape = (evt.keyCode === 27)
    }
    if (isEscape && document.body.classList.contains('modal-active')) {
        toggleModal()
    }
};

function toggleModal() {
    const body = document.querySelector('body')
    const modal = document.querySelector('.modal')
    modal.classList.toggle('opacity-0')
    modal.classList.toggle('pointer-events-none')
    body.classList.toggle('modal-active')
}

const status = response => {

    if (response.status >= 200 && response.status < 300) {
        return Promise.resolve(response)
    }

    return Promise.reject(new Error(response.statusText))
}

function sOtoggleDetailTransaksi() {
    const detailTransaksi = document.getElementById('detailTransaksi');
    const open = document.getElementById('open');
    detailTransaksi.classList.toggle("hidden") || open.classList.toggle("hidden");
}

async function stall(stallTime = 1000) {
    await new Promise(resolve => setTimeout(resolve, stallTime));
}

async function continues(ConTime = 6000) {
    await new Promise(resolve => setTimeout(resolve, ConTime));
}

function sREtoggleDetailTransaksi() {
    const reetailTransaksi = document.getElementById('detailTransaksi');
    const appsd = document.getElementById('appsd');
    const opened = document.getElementById('opened');
    reetailTransaksi.classList.toggle("hidden") || appsd.classList.toggle("hidden") || opened.classList.toggle("hidden"); 
}

function sCtoggleDetailTransaksi() {
    const cldetailTransaksi = document.getElementById('detailTransaksi');
    const appsd = document.getElementById('appsd');
    appsd.classList.toggle("hidden") || cldetailTransaksi.classList.toggle("hidden");
}

function closeAlert(event){
    let element = event.target;
    while(element.nodeName !== "BUTTON"){
        element = element.parentNode;
    }
    element.parentNode.parentNode.removeChild(element.parentNode);
  }

async function ReadDataShipments() {
    const code = document.getElementById('shipment').value;
    const alrt = document.getElementById('alertx');

    if(code == ""){
         
        document.getElementById('readthis').innerHTML = 'CHECKING...';
        await stall()
        alrt.classList.toggle("hidden")
        await continues()
        alrt.classList.toggle("hidden")
        document.getElementById('readthis').innerHTML = 'TRACK NOW';

    } 

      else 
            {

                let promise = new Promise((resolve, reject) => {
                    setTimeout(() => resolve(code), 1000)
                });

                let result = await promise; 

                console.log("start")
                const dtSH = document.getElementById("detailshipment")
                const origins = document.getElementById("origins")
                const destinations = document.getElementById("destinations")
                const status = document.getElementById("status")
                const codes = document.getElementById("code_shipment")
                const shipmentsNotFound = document.getElementById("shipmentsNotFound")

                const SearchShipments = (code) => {
                    return fetch(`/geolocation/tracking/${code}`, {
                            method: 'POST',
                            cache: 'no-cache',
                            credentials: 'same-origin',
                            redirect: 'follow',
                            referrer: 'no-referrer',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'}
                            }
                        )
                    .then(response => response.json())
                    .then(datashipment => datashipment)
                    .then(address => fetch(`/geolocation/tracking/address/${address.order_id}`))
                    .then(responseAddress => responseAddress.json())
                    .then(resultDetailDataShiment => resultDetailDataShiment)
                }

                const SearchHistory = (code) => {
                    return fetch(`/geolocation/tracking/${code}`, {
                            method: 'POST',
                            cache: 'no-cache',
                            credentials: 'same-origin',
                            redirect: 'follow',
                            referrer: 'no-referrer',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'}
                            }
                        )
                    .then(responseHistory => responseHistory.json())
                    .then(dataHIS => dataHIS)
                    .then(history => fetch(`/geolocation/tracking/detail-history/${history.order_id}`))
                    .then(responseDETAILHIS => responseDETAILHIS.json())
                    .then(resultHistoryOrders => resultHistoryOrders)
                    .catch(err => console.log(err))
                }
                    
                SearchShipments(code).then(function (asyncdata) {
                    console.log("datatransport:", asyncdata)

                    // console.log(asyncdata.cek_status_transaction.status_name)
                    if(!isEmptyObject(asyncdata)){
                        console.log("founded")
                        
                        /**
                        *  |			search last index of array				
                        *  [this logic can used it job planing from frontend]
                        *  [can be used to dynamically retrieve index arrays]
                        * ex: Object.Array.slice(-1)[0]
                        * This fetch last index dynamic
                        * console.log(asyncdata.slice(-1)[0])
                        */

                        document.getElementById("code_shipment").innerHTML = asyncdata.order_id
                        document.getElementById("status").innerHTML = asyncdata.cek_status_transaction.status_name
                        document.getElementById("originaddress").innerHTML = asyncdata.origin_address
                        document.getElementById("destinationaddress").innerHTML = asyncdata.destination_address
                        document.getElementById('shipmentsNotFound').style.display='none'
                        document.getElementById('originnotfound').style.display='none'
                        document.getElementById('destinationnotfound').style.display='none'
                        document.getElementById('detailshipment').style.display='inline'

                        document.getElementById('origins').style.display='inline'
                        document.getElementById('destinations').style.display='inline'

                        dtSH.classList.toggle("hidden")
                        origins.classList.toggle("hidden")
                        destinations.classList.toggle("hidden")
                        document.getElementById('readthis').innerHTML = 'TRACK NOW'

                        
                    } else {
                        console.log("not found")

                        setTimeout(() => {
                            document.getElementById('alertxNotfound').style.display='inline'
                        }, 3000);

                        console.log(asyncdata)
                        document.getElementById('detailshipment').style.display='none'
                        document.getElementById('shipmentsNotFound').style.display='inline'

                        document.getElementById('originnotfound').style.display='inline'
                        document.getElementById('destinationnotfound').style.display='inline'
                        
                        document.getElementById('origins').style.display='none'
                        document.getElementById('destinations').style.display='none'
                        document.getElementById('readthis').innerHTML = 'TRACK NOW'

                        setTimeout(() => {
                            document.getElementById('alertxNotfound').style.display='none'
                        }, 7000);
                            


                    }
                });
                // console.log(object[el.a].status_history_name.status_name)

                SearchHistory(code).then(function (asyncdata) {
                    // console.log("datahistory:", asyncdata)
                    let   object = Object.create(null);
                    asyncdata.forEach(function (el) {
                        object[el.a] = el;
                        // if(object[el.a].status_history_name.status_name == "draft"){
                        // 	document.getElementById("tbl").innerHTML = 
                        // 	'<thead>'
                        // 		+'<tr>'
                        // 				+'<th class"u-1of12">'
                        // 				+'</th>'
                        // 				+'<th class"u-4of12">'
                        // 					+'Tanggal'
                        // 				+'</th>'
                        // 				+'<th class"u-7of12">'
                        // 					+'Status Pengiriman'
                        // 				+'</th>'
                        // 		+'</tr>'
                        // 	+'</thead>'
                        // 	+'<tbody>'+
                        // 		'<tr>'
                        // 				+'<td id="draft" class="u-valign-top">'
                        // 					+'<span class="c-icon c-icon--check-circle">'+'</span>'
                        // 				+'</td>'
                        // 					+'<td class="u-4of12 u-fg--ash-dark u-valign-top">23 DRAFTS 3242'
                        // 					+'</td>'
                        // 				+'<td class="u-7of12 c-dot-steps">'
                        // 					+'<div class="o-layout">'
                        // 						+'<div class="o-layout__item">Dalam Proses - In Transit'
                        // 						+'</div>'
                        // 					+'</div>'
                        // 				+'</td>'+
                        // 		'</tr>'
                        // 	+'</tbody>'
                        // }

                        if(object[el.a].status_history_name.status_name == "new"){
                            document.getElementById("tbl").innerHTML = 
                            '<thead>'
                                +'<tr>'
                                        +'<th class"u-1of12">'
                                        +'</th>'
                                        +'<th class"u-4of12">'
                                            +'Tanggal'
                                        +'</th>'
                                        +'<th class"u-7of12">'
                                            +'Status Pengiriman'
                                        +'</th>'
                                +'</tr>'
                            +'</thead>'
                            +'<tbody>'+
                                '<tr>'
                                        +'<td id="draft" class="u-valign-top">'
                                            +'<span class="c-icon c-icon--check-circle">'+'</span>'
                                        +'</td>'
                                            +'<td class="u-4of12 u-fg--ash-dark u-valign-top">23/06/2020'
                                            +'</td>'
                                        +'<td class="u-7of12 c-dot-steps">'
                                            +'<div class="o-layout">'
                                                +'<div class="o-layout__item">Sedang diproses'
                                                +'</div>'
                                            +'</div>'
                                        +'</td>'+
                                '</tr>'
                            +'</tbody>'
                        }

                        if(object[el.a].status_history_name.status_name == "done"){
                            document.getElementById("tbl").innerHTML = 
                            '<thead>'
                                +'<tr>'
                                        +'<th class="u-1of12">'
                                            +''
                                        +'</th>'
                                        +'<th class="u-4of12">'
                                            +'Tanggal'
                                        +'</th>'
                                        +'<th class="u-7of12">'
                                            +'Status Pengiriman'
                                        +'</th>'
                                    +'</tr>'
                                +
                            '</thead>'+
                            '<tbody>'+
                            '<tr>'
                                    +'<td class="u-1of12 c-dot-steps u-valign-top">'
                                        +'<div class="c-dot-steps__circle">'
                                            +'<span class="c-icon c-icon--check-circle">'+'</span>'
                                        +'</div>'
                                    +'</td>'
                                        +'<td class="u-4of12 u-fg--ash-dark u-valign-top">13/06/2020'
                                        +'</td>'
                                    +'<td class="u-7of12 c-dot-steps">'
                                        +'<div class="o-layout">'
                                            +'<div class="o-layout__item">Order berhasil dibuat'
                                            +'</div>'
                                        +'</div>'
                                    +'</td>'+
                            '</tr>'
                            +'<tr>'
                                    +'<td class="u-1of12 c-dot-steps u-valign-top">'
                                        +'<div class="c-dot-steps__circle">'
                                            +'<span class="c-icon c-icon--check-circle">'+'</span>'
                                        +'</div>'
                                    +'</td>'
                                        +'<td class="u-4of12 u-fg--ash-dark u-valign-top">23/06/2020'
                                        +'</td>'
                                    +'<td class="u-7of12 c-dot-steps">'
                                        +'<div class="o-layout">'
                                            +'<div class="o-layout__item">Barang sudah di loading'
                                            +'</div>'
                                        +'</div>'
                                    +'</td>'+
                            '</tr>'
                            +'<tr>'
                                    +'<td class="u-1of12 c-dot-steps u-valign-top">'
                                        +'<div class="c-dot-steps__circle c-dot-steps__circle--active c-dot-steps__circle--last">'
                                            +'<span>'+'</span>'
                                        +'</div>'
                                    +'</td>'
                                        +'<td class="u-4of12 u-fg--ash-dark u-valign-top">05/07/2020'
                                        +'</td>'
                                    +'<td class="u-7of12">'
                                        +'<div class="o-layout">'
                                            +'<div class="o-layout__item u-txt--bold">'
                                                +'Diterima oleh Penerima Paket'
                                            +'</div>'
                                                +'<div id="open" class="o-layout__item">'
                                                    +'<a class="c-link-rd" onclick="sOtoggleDetailTransaksi()">'
                                                        +'Lihat Detail'
                                                    +'</a>'
                                                +'</div>'
                                                +'<div id="appsd" class="o-layout__item hidden">'
                                                    +'<a class="c-link-rd" onclick="sREtoggleDetailTransaksi()">'
                                                        +'Lihat Detail'
                                                    +'<a/>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div id="detailTransaksi" class="o-layout u-mrgn-top--2 cursor-pointer hidden">'
                                            +'<div class="o-layout__item">'
                                                +'<div class="o-layout">'
                                                    +'<div class="o-layout__item">'
                                                        +'<div class="o-flag o-flag--micro">'
                                                                +'<div class="o-flag__head u-pad-bottom--2 u-valign-top c-dot-steps">'
                                                                        +'<div class="c-dot-steps__circle c-dot-steps__circle--active c-dot-steps__circle--last"'
                                                                            +'<span class=""></span>'
                                                                        +'</div>'
                                                                +'</div>'
                                                                +'<div class="o-flag__body u-valign-top">'
                                                                    +'<div class="u-txt--small">'
                                                                        +':DELIVERED'
                                                                        +'</div>'
                                                                        +'<div class="u-txt--small">'
                                                                            +'DANIEL SETYAWAN'
                                                                            +'</div>'
                                                                    +'</div>'
                                                            +'</div>'
                                                            +'<div class="o-layout">'
                                                            +'<div class="o-layout__item">'
                                                                +'<a class="c-link-rd" onclick="sCtoggleDetailTransaksi()">'
                                                                    +'Lihat lebih sedikit'
                                                                    +'</a>'
                                                                +'</div>'
                                                        +'</div>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                    +'</td>'+
                            '</tr>'
                        +'</tbody>'
                    }
                });

                    // if (typeof(asyncdata[3].status_history_name) === undefined) {
                    // 	if(asyncdata[0].status_history_name.status_name == "draft"){
                        
                    // 		console.log("this draft:",asyncdata.cek_status_transaction.status_name)

                    // 	}

                    // } else {

                    // 	if(asyncdata[3].status_history_name.status_name == "done"){
                        

                    // 		console.log("this done:",asyncdata.cek_status_transaction.status_name)
                            
                    // 	} 


                    // }

                }
            );
            
    }
}

function isEmptyObject(obj){
    return JSON.stringify(obj) === '{}';
}
@section('scripts')
<script async type="text/javascript" language="javascript">
function logout(event){
    event.preventDefault();
        bootbox.confirm("Apa anda yakin ingin keluar aplikasi?", function(event){
                if(event){ 
                    document.getElementById('logout-form').submit();
                }
        })
        
     }
// function loadScript(url) {

// return new Promise(function(resolve, reject) {

//   var script = document.createElement("script")
//   script.type = "text/javascript";

//   if (script.readyState) { //IE
//     script.onreadystatechange = function() {
//       if (script.readyState == "loaded" ||
//         script.readyState == "complete") {
//         script.onreadystatechange = null;
//         resolve();
//       }
//     };
//   } else { //Others
//     script.onload = function() {
//       resolve();
//     };
//   }

//   script.src = url;
//   document.getElementsByTagName("head")[0].appendChild(script);

// });
// }

// var resources = [
// "https://code.jquery.com/jquery-2.2.3.min.js",
// "https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"
// ]

// function loadAllResources() {
// return resources.reduce(function(prev, current) {

//   return prev.then(function() {
//     return loadScript(current);
//   });

// }, Promise.resolve());
// }

// loadAllResources().then(function() {
// $('#result').text('Everything loaded');
// $('#datepicker').datepicker();
// });

   $('#success').delay(10000).fadeOut('slow');
   $('#error').delay(10000).fadeOut('slow');
    // # ===================================================================================================
    // # fitur untuk pemilihan perusahaan dan cabang secara dinamis ^high priority [branch][roles][username]
    // # ===================================================================================================

   $( document ).ready(function() {
 
        $({property: 0}).animate({property: 110}, {
            duration: 3000,
            step: function() {
                var _percent = Math.round(this.property);
                $('#progress').css('width',  _percent+"%");
                if(_percent == 200) {
                    $("#progress").addClass("done");
                }
            },
            complete: function() {
                $("#progress").hide();
            }
        });
    });

    $(document).ready(()=>{ 
             
        let branch_id = "{{$some}}";
        var url = '{{ route("showit.find", ":id") }}';

        url = url.replace(':id', branch_id);
        $.get(url, function(data){
            $.each(data, function(index, Obj){
                    var $option_brnch = $("<option selected></option>").val(Obj.id).text(Obj.branch);
                    var $option_cmp = $("<option selected></option>").val(Obj.company.id).text(Obj.company.name);
                    // for parent
                    $('#companychoose').append($option_cmp).trigger('load');
                    $('#branchchoose').append($option_brnch).trigger('load');

                    // for child
                    $('#company_child').append($option_cmp).trigger('load');
                    $('#company_branchs_child').append($option_brnch).trigger('load');

                }   
            );
        });

        $('.dtcompanychoosen').select2({
            placeholder: 'Choose Company',
            "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
            url: '/load-company-for-super-user', 
            dataType: 'json',
            delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                            })
                        };
                    },
                    cache: true
                }
           });

           $('.dtcompany').select2({
            placeholder: 'Choose Company child',
            "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
            url: '/load-company-for-super-user', 
            dataType: 'json',
            delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                            })
                        };
                    },
                    cache: true
                }
           });

    /** 
    * Mixed roles opened super users
    */
    $('#companychoose').on('change', function(ex){
            const thisval = ex.target.value;

                    $('.dtbranchchoosen').select2({
                            placeholder: 'Choose Branch',
                            "language": {
                                    "noResults": function(){
                                        return "Maaf, Silahkan isikan role anda terlebih dahulu";
                                    }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            ajax: {
                            url: '/load-company-branch-with-super-user/find/'+`${thisval}`,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                        results:  $.map(data, function (item) {
                                            return {
                                                text: item.branch,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                            cache: true
                        }

                    }).on('change', function(es){
                        const branch = es.target.value;
                        let user = "{{Auth::User()->roles[0]->name}}";
                        let timerInterval
                            Swal.fire({
                            title: '<div class="row-fluid form-control-label" style="font-font-family: Fira Code;font-size:18px">Sedang mempersiapkan transaksi...</div>',
                            // text: 'Currently matching system data.',
                            imageUrl: '{{ asset("img/ghload.gif")}}',
                            imageWidth: 340         ,
                            imageHeight: 90,
                            imageAlt: 'Processing',
                            // html:
                            // "<div style='color: #9787ea' class='la-ball-scale-pulse la-3x'><div></div><div></div><div></div><div></div></div>" +
                                // ""+
                            // JSON.stringify(user) +
                            // background: 'rgba(0,0,0,0) linear-gradient(#444,#111) repeat scroll 0 0',
                            // html: `<div class="vertical-center"><div class="w-100"><div class="w-100 d-flex justify-content-center ldlz" style="opacity: 1; visibility: visible;"><div class="rounded-lg m-4 ld ld-heartbeat" style="width:48px;height:48px;animation-delay:0s;background:#e15b64"></div><div class="rounded-lg m-4 ld ld-flip" style="width:48px;height:48px;animation-delay:.3s;background:#f8b26a"></div><div class="rounded-lg m-4 ld ld-metronome" style="width:48px;height:48px;animation-delay:.6s;background:#abbd81"></div></div></div></div>`,
                            // // html: '<strong>SYSTEM AUTHENTICATIONsdasdasdas</strong><br/> The system is processing your request'+'<br/>'+'&nbsp;<div class="lds-dual-ring"></div>',
                            timer: 12000,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer
                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://devyour-api.co.id/updated-api-setting-branch/find/${thisval}/find-branch/${branch}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    if(!responseJsonData){
                                                        
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        var value = url.substring(url.lastIndexOf('/') + 1);
                                                        url = url.replace(value, responseJsonData)
                                                        

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "dashboard"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                                window.location.href = url;

                                                        } 

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                                window.location.href = url;

                                                        }

                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "history-job-shipments"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                            window.location.href = url;

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                            window.location.href = url; 

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                            window.location.href = url;

                                                        } 

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                            window.location.href = url;

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                            window.location.href = url;

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                            window.location.href = url;
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                            window.location.href = url;
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                            window.location.href = url;
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                            window.location.href = url;
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                            window.location.href = url;
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                            window.location.href = url;
                            
                                                        } 

                                                    }

                                                resolve();

                                            }, 3000);
                                        })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();
                             
                            }
                        })
                           
                    });

                }
            );

            ScrollReveal().reveal('.sub-menu', { interval: 425 });
            ScrollReveal().reveal('.cabang', { delay: 500 });
            ScrollReveal().reveal('.roles', { delay: 800 });
            ScrollReveal().reveal('.permission', { delay: 2000 });

            $('.dtbranchchoosen').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                        "noResults": function(){
                            return "Maaf, Silahkan isikan role anda terlebih dahulu";
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.branch,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    cache: true
                }
            })

            $('.dtbranchs').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.branch,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    cache: true
                }
            })
    
    $('#branchchoose').prop("disabled", false);
   
    $('.dtcompanychoosen').select2({
        placeholder: 'Choose Company',
        "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        // containerCssClass: "background-color: blue !important",
        ajax: {
        url: '/load-company-for-super-user',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           }).on('load', function(e){
            const company = e.target.value;
            $('#branchchoose').empty();
                $('.dtbranchchoosen').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                                    return markup;
                                },
                    ajax: {
                    url: '/load-company-branch-with-super-user/find/'+`${company}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                            return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.branch,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        cache: true
                    }
                }).on('change', function(es){
                        const thisval = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html:'<strong>SYSTEM AUTHENTICATION</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5300,
                            showConfirmButton: false, 
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://devyour-api.co.id/updated-api-setting-branch/find/${company}/find-branch/${thisval}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    
                                                    if(!responseJsonData){

                                                        //do something else
                                                    
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        let urls = current_origin_url+current_pathname_url;

                                                        let value = url.substring(url.lastIndexOf('/') + 1);
                                                        let values = urls.substring(urls.lastIndexOf('/') + 1);

                                                        url = url.replace(value, responseJsonData)
                                                        urls = urls.replace(values, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                            window.location.href = url;

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "history-job-shipments"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "create-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                            window.location.href = urls;
                                                        }
                                                        
                                                        if(value == "list-job-shipment"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                            window.location.href = urls;

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = urls;

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                            window.location.href = urls;

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                            window.location.href = urls;
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-modsa')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                            window.location.href = urls;
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                            window.location.href = urls;
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                            window.location.href = urls;
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                            window.location.href = url;
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                            window.location.href = url;
                            
                                                        } 

                                                    }

                                                   resolve();

                                                }, 3000);
                                            })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();
                                
                            }
                        })

                    });

           });
           
        });    

        $(document).ready(()=>{ 
        // this child parent
        $('#company_child').on('change', function(ex){
            const thisval = ex.target.value;

                    $('.dtbranchs').select2({
                            placeholder: 'Choose Branch',
                            "language": {
                                    "noResults": function(){
                                        return "Maaf, Silahkan isikan role anda terlebih dahulu";
                                    }
                            },
                            escapeMarkup: function (markup) {
                                            return markup;
                                        },
                            ajax: {
                            url: '/load-company-branch-with-super-user/find/'+`${thisval}`,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                        results:  $.map(data, function (item) {
                                            return {
                                                text: item.branch,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                            cache: true
                        }

                    }).on('change', function(es){
                        const branch = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html: '<strong>SYSTEM AUTHENTICATION</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5200,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://devyour-api.co.id/updated-api-setting-branch/find/${thisval}/find-branch/${branch}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    if(!responseJsonData){
                                                        
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        var value = url.substring(url.lastIndexOf('/') + 1);
                                                        url = url.replace(value, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "dashboard"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                            window.location.href = url;

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                            window.location.href = url;

                                                        } 

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "history-job-shipments"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                            window.location.href = url;

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = url;

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                            window.location.href = url; 

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                            window.location.href = url;

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                            window.location.href = url;

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                            window.location.href = url;

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                            window.location.href = url;
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                            window.location.href = url;
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                            window.location.href = url;
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                            window.location.href = url;
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                            window.location.href = url;
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                            window.location.href = url;
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                            window.location.href = url;
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                            window.location.href = url;
                            
                                                        }
                                                        
                                                    }
                                                 
                                               resolve();

                                            }, 3000);
                                        })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();

                            }
                        })

                    });

                }
            );

        // this load change branch for child parent
    
        $('.dtcompany').select2({
        placeholder: 'Choose Company',
        "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        // containerCssClass: "background-color: blue !important",
        ajax: {
        url: '/load-company-for-super-user',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           }).on('load', function(e){
            const company = e.target.value;
            $('#company_branchs_child').empty();
                $('.dtbranchs').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },          
                    ajax: {
                    url: '/load-company-branch-with-super-user/find/'+`${company}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                            return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.branch,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        cache: true
                    }
                }).on('change', function(es){
                        const thisval = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html:'<strong>SYSTEM AUTHENTICATION</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5300,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://devyour-api.co.id/updated-api-setting-branch/find/${company}/find-branch/${thisval}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    
                                                    if(!responseJsonData){

                                                        //do something else
                                                    
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        let urls = current_origin_url+current_pathname_url;

                                                        let value = url.substring(url.lastIndexOf('/') + 1);
                                                        let values = urls.substring(urls.lastIndexOf('/') + 1);

                                                        url = url.replace(value, responseJsonData)
                                                        urls = urls.replace(values, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                            window.location.href = url;

                                                        }
                                                        
                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = url;

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                                window.location.href = url;

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                                window.location.href = url;

                                                        } 

                                                        if(value == "history-job-shipments"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                            window.location.href = urls;

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                            window.location.href = urls;
                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                            window.location.href = urls;

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                            window.location.href = urls;

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                            window.location.href = urls;

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                            window.location.href = urls;

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                            window.location.href = urls;
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "detail-data-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                            window.location.href = urls;
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                            window.location.href = urls;
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                            window.location.href = urls;
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                            window.location.href = urls;
                                                        }
                                                        
                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                            window.location.href = url;
                
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                            window.location.href = url;
                            
                                                        } 

                                                    }

                                                    resolve();

                                                }, 3000);
                                            })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                            SettingUp();
                        }
                    })

                });

            });
        });

            // check when all ajax load completed
            function get_ajax(link, data, callback) {
                $.ajax({
                    url: link,
                    type: "GET",
                    data: data,
                    dataType: "json",
                    success: function (data, status, jqXHR) {
                        callback(jqXHR.status, data)
                    },
                    error: function (jqXHR, status, err) {
                        callback(jqXHR.status, jqXHR);
                    },
                    complete: function (jqXHR, status) {
                    }
                })
            }

            function run_list_ajax(callback){
                var size=0;
                var max= 10;
                for (let index = 0; index < max; index++) {
                    var link = 'this url';
                    var data={i:index}
                    get_ajax(link,data,function(status, data){
                        console.log(index)
                        if(size>max-2){
                            callback('done')
                        }
                        size++
                        
                    })
                }
            }   

            // run this function --
            // run_list_ajax(function(info){
            //     console.log(info)
            // })


    // let run = function(){
    //     const check_connection = new XMLHttpRequest();
    //     check_connection.timeout = 6500;
    //     check_connection.open('GET', 'http://devyour-api.co.id/home', true);
    //     check_connection.send();
    // }

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
    $('#asdzx').click(function(){
        $('#asdzx').prop('disabled','disabled');
    })

      var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {

            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            disableStats: true,
                auth: {
                    headers: {

                            'X-CSRF-Token': '{{ csrf_token() }}'

                    }
                }

            }
        ); 
        
        const channel = pusher.subscribe('webhooks-channel');
        const check = "{{$some}}";

        channel.bind('warehouse\\Events\\WebhookEvents', function(data) {
            
            if(check == ''){

                // do something with user not choose branch first
                
            } 
                else {

                       WebhookEventSync(data.webhooks);

            }
            
        });

        async function WebhookEventSync(response) {

    // TODO: progres sync to update [3PS][POP]() to process with accurate to create SO.IT-SH....
    // TODO: progres sync to update [3PS][POD]() to done with accurate to create DO.IT-SH....
        $("#asdzx").text("Processing status");
        
        let promise = new Promise((resolve, reject) => {
                        setTimeout(() => resolve(response), 2000);
                    });

                    const results = await promise;
                    let timerInterval
                    let method = results.method;
                    let shipment_code = results.shipment;

                    if(shipment_code){
                        $('#ModalStatusAccoutingTC').modal('hide')
                    }

                    // =>>> webhook accurate cloud
                    //     let warehouseID = results[0].data[0].warehouseId;
                    //     let itemNo = results[0].data[0].itemNo;
                    //     let Quantity = results[0].data[0].quantity;
                    //     Swal({
                    //             title:"IzzyTransport Webhook Notification",
                    //             text: "Notification",
                    //             confirmButtonColor: '#3085d6',
                    //             html: "Information method :" +method+ '</br>' + "shipment code :" +shipment_code,
                    //             width: 'auto',
                    //             // showConfirmButton: true,
                    //             confirmButtonText: '<div class="badge badge-success">Ok</div>',
                    //             type: 'info'
                    //         }).then((result) => {
                    //             if (result.value) {
                    //                 return true;
                    //     }
                    // })
                    // =>>> webhook accurate cloud

                        Swal.fire({
                        title: 'Processing Requests',
                        html:"Synchronize data <img src='{!! asset('img/pre-loader/loader3.gif') !!}'></br>"+"<div class='emptys-state'><span style='color: DARKSLATEGRAY;font-family: Fira Code'><b>"+shipment_code+"</b></span></div><br/><br/><span class='form-control' style='color: DARKSLATEGRAY;font-family: Fira Code'>Shipment["+method+"] sedang diproses..<br/>"+"<br/><img src='{!! asset('img/pre-loader/Preloader_7d5d.gif') !!}'></span>",
                        timer: 9000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                        },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                                if (

                                        result.dismiss === Swal.DismissReason.timer

                                    ) 

                                    {
                                        setTimeout(() => {
                                                AsyncData(method, shipment_code)
                                            }, 
                                        3000
                                    );
                                }
                            }
                        );
             
                // console.log(method)
                
                // console.log(results[0].data[0]);
            }

    // =>>> testing socker webhook accurate cloud
    // var socket = io.connect('http://127.0.0.1:4200');

	// socket.on('connect', function(data) {
    // 	socket.emit('join', 'Socket from handle request');
    // });

    // socket.on('messages', function(data) {
    //           $(".test").append(data);
    //     });

        // socket.on('call progress event', function(data) {
        //       $(".test").append(data);
        // });
                async function AsyncData(response,shipment_code) 
                {
                    try {
                            await fetch(`http://devyour-api.co.id/3PS-received-webhooks/${response}/${shipment_code}`).then(async (ResponseString)=> {
                                
                                //processing queueing dispatch jobs
                                let received_webhook = await ResponseString.json()
                                // console.log(received_webhook)

                                let current_origin_url = window.location.origin;
                                let current_pathname_url = window.location.pathname;
                                let url = current_origin_url+current_pathname_url;

                                let cabang = "{{ $some }}";
                                let transport_order = '{{ route("transport.static", ":id") }}';

                                if(current_pathname_url == '/dashboard/find-branch-with-branch/branch-id/'+cabang+'/list-order-transport') {
             
                                    transport_order = transport_order.replace(':id', cabang);
                                    window.location.href = transport_order;

                                } 
                                    else 
                                            {
                                                //do something with queueing failed, or rollback data / etc.
                                            }
                                }
                            );

                            const toast = Swal.mixin({
                                            toast: true,
                                            position: 'right',
                                            showConfirmButton: false,
                                            timer: 6500
                                         });

                            toast({
                                title:"Data berhasil disinkronkan dengan Izzy Transports."
                            })

                            let id = "{{ session()->get('id') }}";

                            if(!id){
                                
                                } 
                                    else
                                            {

                                                let cabang = "{{ $some }}";
                                                let link = '{!! route("transport.static", ":cabang")  !!}';
                                                let redirect = link.replace(":cabang",cabang)

                                    setTimeout(function(){ 

                                            window.location.href = redirect;

                                }, 4500);

                        }


                    } 
                        catch {

                            const toast = Swal.mixin({
                                            toast: true,
                                            position: 'bottom',
                                            showConfirmButton: false,
                                            timer: 6500
                                         });

                                toast({
                                    title:"Waiting request from server, try it again !"
                                }
                            )

                    }
                
                }


            $(document).ready(function () {
                Inputmask("99.999.999.9-999.999").mask("#tax_no");
                // (.999){+|1},00 Inputmask("/[^0-9.]+").mask("#ttlQty");
                Inputmask("99.999.999.9-999.999").mask("#no_npwp");
                $("#since").inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy" });
                $("#email").inputmask({ alias: "email"});
                $("#ttlQty").inputmask({ alias: "currency"});
                // $('#tax_no').keypress((e) => {

                    // const data = e.currentTarget.value;
                        // if (typeof data === 'string') {
                        //    let format = data.replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})(\d{3})/, '$1.$2.$3.$4-$5.$6');
                        //    $(".npwps").val(format);
                        //    return true;
                        // }
                // });
            });
</script>
@endsection
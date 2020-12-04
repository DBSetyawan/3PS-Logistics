@extends('admin.layouts.master', ['some' => $some])
@section('head')
@notifyCss
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/hunterPopup.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/like-yt.css') }}" />
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
    <link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
    <link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css"
@endsection
@section('brand')
{{-- <a class="brand" href="/home"> --}}
    {{--  <img src="../img/logo.png" alt="Tiga Permata System" />  --}}
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Item</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>
{{-- <li class="pull-right search-wrap">
    <form action="search_result.html" class="hidden-phone">
        <div class="input-append search-input-area">
            <input class="" id="appendedInputButton" type="text">
            <button class="btn" type="button"><i class="icon-search"></i> </button>
        </div>
    </form>
</li> --}}
@endsection

@section('content')
<div id="main-content">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
       <!-- BEGIN PAGE HEADER-->
       <div class="row-fluid">
          <div class="span12">
             <!-- BEGIN PAGE TITLE & BREADCRUMB-->
              <h3 class="page-title">
                   {{ $menu }}
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>
              <!-- END PAGE TITLE & BREADCRUMB-->
          </div>
       </div>
       <!-- END PAGE HEADER-->
       @include('flash::message')
       @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
       @endif
       <div id="progress" class="waiting">
            <dt></dt>
            <dd></dd>
        </div>
       <!-- BEGIN ADVANCED TABLE widget-->
       <div class="row-fluid">
            <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget red">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> {{ $menu }}</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
                <div class="widget-body">
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                        <div style="text-align:right;">
                            <span class="add-on"><a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="" class="itemsadd btn btn-success"><i class="icon-plus"></i> Add Item</a></span>
                                {{-- <button type="button" class="btn btn-info" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="">
                                        <i class="icon-plus"></i>
                                            Add Item
                                    </button> --}}
                        {{-- <input type="button" value="+ Customer Registration" onclick="location.href='{{ url('customer/registration') }}'"> --}}
                    </div>
                    <div>
                        &nbsp;
                    </div>
                        <table class="table table-striped table-bordered" id="sample_1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Code</th>
                                    <th>Customer</th>
                                    <th>Sub Service</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Users</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($data_customer_transport as $item_rows)
                                        <tr class="odd gradeX">
                                            <td style="width: 3%;">{{ $loop->iteration }}</td>
                                            <td style="width: 12%;">{{ $item_rows->item_code }}</td>
                                            <td style="width: 15%;">{{ isset($item_rows->customers['name']) ? $item_rows->customers['name'] : 'NON PROJECT - PUBLISH RATE' }}</td>
                                            <td style="width: 9%;">{{ $item_rows->sub_services->name }}</td>
                                            <td style="width: 20%;">{{ $item_rows->city_show_it_origin->name }}</td>
                                            <td style="width: 20%;">{{ $item_rows->city_show_it_destination->name }}</td>
                                            <td style="width: 2%;">{{ $item_rows->unit }}</td>
                                            <td style="width: 10%;">Rp. {{ number_format($item_rows->price, 0) }}</td>
                                            @if(Auth::User()->oauth_accurate_company == "146583")
                                            <td style="width: 2%;">
                                                <center><span style="background: rgb(170, 6, 6)" class="badge">{{ __('PT. Tiga Permata Logistik')}}</span>    
                                            </td>    
                                            @elseif(Auth::User()->oauth_accurate_company == "146584")
                                                <td style="width: 2%;">
                                                    <center><span style="background: rgb(21, 112, 21)" class="badge">{{ __('PT. Tiga Permata Ekspres')}}</span>    
                                                </td>
                                            @endif
                                            <td style="width: 13%;">{{ $item_rows->created_at }}</td>
                                            {{-- <td style="width: 60px;">
                                            <button onclick="location.href='{{ route('items.show', $item_rows->id) }}'" class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button>
                                            </td> --}}
                                            @php
                                                $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($item_rows->id);   
                                            @endphp
                                            <td style="width: 30px;">
                                                <a href="{{ route('update.item.customer', array($some, $encrypts))}}"><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                            </td>
                                        </tr>
                                    @endforeach()
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    $data=[

'content' => 'true'

];  
@endphp
@include('admin.transport.transport_order.modal_add_item_customer', ['datax'=>$data])
@endsection
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
@include('notify::messages')
@notifyJs
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<!--script for this page only-->
<script src="{{ asset('js/table_customer_item_transports.js') }}"></script>
<script async language="javascript" type="text/javascript">

    let dots = 0;
        
        $(document).ready(function()
        {
            setInterval (type, 300);
        });
        
        function type()
        {
            if(dots < 3)
            {
                $('#wait-loading').append('.');
                dots++;
            }
            else
            {
                $('#wait-loading').html('Sedang menyimpan data [3PS] & menyambungkan ke [ACCURATE]');
                dots = 0;
            }
        }

        async function stall(stallTime = 300) {
            await new Promise(resolve => setTimeout(resolve, stallTime));
        }

        async function thisThrows() {
            throw new Error("Thrown from thisThrows()");
        }

        async function SaveItemCustomer(RateFirst, qtypertama, minimalQty, customername, shipment_category, sub_service,
                                        shipment_category, moda, origin, destination, itemovdesc, unit, gen_code, price
        ) {
                      
                      let dataItemCustomer = {
                              gen_code:gen_code,
                              Reqcustomer:customername,
                              Reqsubservice:sub_service,
                              Reqshipment_category: shipment_category,
                              Reqmoda: moda,
                              Reqorigin: origin,
                              Reqdestination: destination,
                              Reqitemovdesc: itemovdesc,
                              Reqprice: price,
                              Requnit: unit,
                              Qtyminimum: minimalQty,
                              qtyPERTAMA: qtypertama,
                              RatePertama: RateFirst
                          }

                  const apiSaveItemCustomers = "{{ route('save.item.accurate.customer', $some) }}";
                          
                      const settings = {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Content-Type': 'application/json;charset=utf-8',
                                    'Accept': 'application/json'
                                    },
                                body: JSON.stringify(dataItemCustomer)
                          }

                  try {
                        
                    await stall();

                        const fetchResponse = await fetch(`${apiSaveItemCustomers}`, settings);
                        const data = await fetchResponse.json();
                        return data;
                    } catch (e) {
                        return JSON.stringify(e);
                    }    

              }

        $(document).ready(function() {

            $('#tab2').hide();
            $('#resend').hide();
            $('#x').hide();
            $("#spinner_loading_processing").hide()
            $("#Notes").hide()
            $('#codeNumber').hide();
            $('#tab3').hide();
            $('#MessageResponseRest').hide();
            $('#wait-loading').hide();

        });

        $(document).on("click", ".copy-action-btn", function() { 
            var trigger = $(this);
            $(".copy-action-btn").removeClass("text-success");
            var $tempElement = $("<input>");
                $("body").append($tempElement);
                var copyType = $(this).attr("data-code");
                $tempElement.val(copyType).select();
                document.execCommand("Copy");
                $tempElement.remove();
                $(trigger).addClass("text-success");

        });

        let typingTimer;
        let doneTypingInterval = 1000; 

        let formObj = document.getElementById('form_item_sub_services');

        $('.metodeX').select2({
                placeholder: 'Cari...',
            }).on("change", function(e){
                if(e.target.value == "metode2"){

                        $('#tab2').delay(2500).fadeIn('slow');
                        $("#qtyFirst").val("");
                        $('#tab3').delay(2500).fadeOut('slow');
                        $("#itemovdesc").val("");
                        $("#price").val("");
                        $("#ratex").text("Rate");

                    } 
                        else 
                                {
                                    if(e.target.value == "metode3"){

                                        $("#minimalQty").val("");
                                        $("#ratex").text("Rate Selanjutnya");
                                        $('#tab2').delay(2500).fadeOut('slow');
                                        $('#tab3').delay(2500).fadeIn('slow');
                                        $("#itemovdesc").val("");
                                        $("#price").val("");

                                } 
                                    else 
                                            {

                                                $('#tab2').delay(2500).fadeOut('slow');
                                                $('#tab3').delay(2500).fadeOut('slow');
                                                
                                $("#minimalQty").val("");
                                $("#qtyFirst").val("");
                                $("#itemovdesc").val("");
                                $("#price").val("");
                                formObj.rateFirsts.value = ''

                        }
                    } 
                }
            );
            
        $('.customerload').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_customers_transport/find/',
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

        async function dbug() {
                
            let customername = document.getElementById('customerx_id').value;
            let sub_service = document.getElementById('sub_service_id').value;
            let shipment_category = document.getElementById('shipmentx').value;
            let moda = document.getElementById('moda_x').value;
            let origin = document.getElementById('originx').value;
            let destination = document.getElementById('destination_x').value;
            let itemovdesc = document.getElementById('itemovdesc').value;
            let unit = document.getElementById('unit').value;
            let gen_code = document.getElementById('itemcode').value;
            let price = document.getElementById('price').value;
            
            let minimalQty = document.getElementById('minimalQty').value;
        
            let qtypertama = document.getElementById('qtyFirst').value;
            let RateFirst = document.getElementById('rateFirsts').value;

            $('#wait-loading').show();
            
            await stall();

            SaveItemCustomer(
                RateFirst, qtypertama, minimalQty,
                customername, shipment_category,
                sub_service, shipment_category, moda,
                origin, destination, itemovdesc,
                unit, gen_code, price).then(function(results){

            if(results == "{}"){

                const MessageResponseRest = document.getElementById("MessageResponseRest")

                $("#spinner_loading_processing").attr("class","badge badge-important");
                $("#resend").show();
                $("#MessageResponseRest").show();
                $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
                $("#MessageResponseRest").css("font-family","Quicksand");
                $("#MessageResponseRest").css("font-size","15px");

                setTimeout(() => MessageResponseRest.style.display='none', 5600)

                $("#spinner_loading_processing").text("Process failed");

                $("#resend").attr("class","icon-refresh");
                $("#resend").attr("style","cursor:pointer");
                $("#resend").attr("onclick", "dbug();");

                $("#spinner_loading_processing").text("Process failed");
                $("#Notes").text("Hubungkan ulang");
                $("#Notes").css("font-family","Quicksand");
                $("#Notes").css("font-size","15px");

                $("#add_item_customer").prop( "disabled", false );
                $("#add_item_customer").text("Save");

                $("#add_item_customer").hide();
                $("#codeNumber").hide();
                $("#x").hide();
                $('#wait-loading').hide();

            }

            else 
                    {
                        if(results['status_SyncAccurate'] !== "false"){
                    
                            $('#wait-loading').hide();

                            $("#add_item_customer").show();
                                
                            $("#resend").attr("class","hidden");

                                $("#spinner_loading_processing").attr("class","badge badge-success");
                                $("#spinner_loading_processing").text("Process successed");
                                    
                                            $("#Notes").text("Data item berhasil disinkronisasi ke Accurate.");
                                            $("#Notes").css("font-family","Quicksand");
                                            $("#Notes").css("font-size","15px");

                                        $("#codeNumber").show();
                                        $("#MessageResponseRest").hide();
                                        $("#x").show();
                                        $("#codeNumber").attr("class","badge badge-warning");
                                        $("#x").text("Selamat data anda berhasil diproses.");
                                        $("#codeNumber").text(results["status_SyncAccurate"]);

                                    $("#add_item_customer").prop( "disabled", false );
                                    $("#add_item_customer").text('Save');
                                                
                            runsSave(results['fullfield']);

                        } 
                            else {

                                    if(typeof results['status_SyncAccurate'] !== "undefined"){

                                        $('#wait-loading').hide();

                                        if(results["status_SyncAccurate"] == "false"){

                                            const MessageResponseRest = document.getElementById("MessageResponseRest")

                                            $("#spinner_loading_processing").attr("class","badge badge-important");
                                            $("#resend").show();
                                            $("#MessageResponseRest").show();
                                            $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
                                            $("#MessageResponseRest").css("font-family","Quicksand");
                                            $("#MessageResponseRest").css("font-size","15px");

                                            setTimeout(() => MessageResponseRest.style.display='none', 5600)

                                            $("#spinner_loading_processing").text("Process failed");

                                            $("#resend").attr("class","icon-refresh");
                                            $("#resend").attr("style","cursor:pointer");
                                            $("#resend").attr("onclick", "dbug();");

                                            $("#spinner_loading_processing").text("Process failed");
                                            $("#Notes").text("Hubungkan ulang");
                                            $("#Notes").css("font-family","Quicksand");
                                            $("#Notes").css("font-size","15px");

                                            $("#add_item_customer").prop( "disabled", false );
                                            $("#add_item_customer").text("Save");

                                            $("#add_item_customer").hide();
                                            $("#codeNumber").hide();
                                            $("#x").hide();

                                        } 
                                            else 
                                                    {

                                                        $("#resend").attr("class","hidden");

                                                        $("#spinner_loading_processing").attr("class","badge badge-success");
                                                        $("#spinner_loading_processing").text("Process successed");

                                                                    $("#Notes").text("Data item berhasil disinkronisasi ke Accurate.");
                                                                    $("#Notes").css("font-family","Quicksand");
                                                                    $("#Notes").css("font-size","15px");

                                                        $("#codeNumber").show();
                                                        $("#MessageResponseRest").hide();
                                                        $("#x").show();
                                                        $("#codeNumber").attr("class","badge badge-warning");
                                                        $("#x").text("Selamat data anda berhasil diproses.");
                                                        $("#codeNumber").text(results["status_SyncAccurate"]);


                                                    $("#add_item_customer").prop( "disabled", false );
                                                    $("#add_item_customer").text('Save');
                                                    $("#add_item_customer").show();
                                                                        

                                                runsSave(results['fullfield']);
                                        }

                                } 
                        }
                    }
            })
        }

    async function runsSave(fullfield) {

        try {

            if(fullfield == "queue done") {
                const CloseModal = () => new Promise((resolve, reject) => {
                    setTimeout(() => {

                            $('#add_item').modal('hide')

                        }, 
                    
                    1000);

                });
                    const RefreshPage = () => {
                        return new Promise((resolve, reject) => {
                            let cabang = "{{ $some }}";
                            let link = '{!! route("datacustomer.show", ":cabang")  !!}';
                            let redirect = link.replace(":cabang",cabang)
                            setTimeout(() => {
                                // console.log("in timeout",fullfield)
                                window.location.href = redirect;
                            // }, 6500);
                            }, 500);
                        }
                    );
                }

            return await Promise.all([CloseModal(), RefreshPage()]);

        } 
                else {

                    if(fullfield == "queue start") {

                            return new Promise(function(resolve, reject) {
                                // $("#output").append("start");

                                setTimeout(function() {
                                resolve();
                                // }, 30000);
                                }, 500);
                            }).then(function() {
                                // $("#output").append(" middle");
                                // return " end";
                                // return;
                                const CloseModal = () => new Promise((resolve, reject) => {
                                setTimeout(() => {

                                    $('#add_item').modal('hide')

                                }, 
                                    1300);
                                    // 4000);
                                }
                            );
                                    const RefreshPage = () => {
                                        return new Promise((resolve, reject) => {
                                            let cabang = "{{ $some }}";
                                            let link = '{!! route("datacustomer.show", ":cabang")  !!}';
                                            let redirect = link.replace(":cabang",cabang)
                                            setTimeout(() => {
                                                // console.log("out timeout",fullfield)
                                                window.location.href = redirect;
                                            }, 3500);
                                        });
                                    }
                                return RefreshPage();
                            // return await Promise.all([CloseModal(), RefreshPage()]);
                            }
                        );
                    } 
                } 

            } catch (error) {
                console
                .log(`ehm, something went wrong`, error)
            }

        };

        function isUndefined(array, index) {
            return ((String(array[index]) == "undefined") ? "Yes" : "No");
        }

        $("#add_item_customer").click(function(event) {
            event.preventDefault()
            bootbox.confirm({ 
                size: "small",
                message: "Yakin ingin menambahkan item?",
                callback: function(result){ /* result is a boolean; true = OK, false = Cancel*/
                    if(result == false)
                    {
                        return;
                    } 
                        else 
                    {
                            $("#add_item_customer").prop( "disabled", true );
                            $("#add_item_customer").text('Syncing Data..');

                                let customername = document.getElementById('customerx_id').value;
                                let sub_service = document.getElementById('sub_service_id').value;
                                let shipment_category = document.getElementById('shipmentx').value;
                                let moda = document.getElementById('moda_x').value;
                                let origin = document.getElementById('originx').value;
                                let destination = document.getElementById('destination_x').value;
                                let itemovdesc = document.getElementById('itemovdesc').value;
                                let unit = document.getElementById('unit').value;
                                let gen_code = document.getElementById('itemcode').value;
                                let price = document.getElementById('price').value;
                                
                                let minimalQty = document.getElementById('minimalQty').value;
                            
                                let qtypertama = document.getElementById('qtyFirst').value;
                                let RateFirst = document.getElementById('rateFirsts').value;

                                if(!shipment_category || !sub_service || !shipment_category || !moda || !origin || !destination || !itemovdesc || !unit || !gen_code || !price ) {
                                
                                    setTimeout(() => $("#add_item_customer").prop( "disabled", false), 200 );
                                    setTimeout(() => $("#add_item_customer").text('Save'),2500);
                                    setTimeout(() => swal("Peringatan !","Pastikan sudah terisi semua !","error"), 3000);
                                
                                } 
                                    else 
                                            {

                                                return new Promise((resolve, reject) => {

                                                    SaveItemCustomer(
                                                        RateFirst, qtypertama, minimalQty,
                                                        customername, shipment_category,
                                                        sub_service, shipment_category, moda,
                                                        origin, destination, itemovdesc,
                                                        unit, gen_code, price).then((result) => {
                                                            setTimeout(() =>
                                                            $("#spinner_loading_processing").show(),
                                                            $("#Notes").show(),2500);

                                                    if(result == "{}"){

                                                        $("#spinner_loading_processing").attr("class","badge badge-important");
                                                        $("#resend").show();
                                                        $("#MessageResponseRest").show();
                                                        $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
                                                        setTimeout(() => MessageResponseRest.style.display='none', 5600)
                                                        
                                                        $("#x").hide();
                                                        $("#codeNumber").hide();
                                                        
                                                        $("#spinner_loading_processing").text("Process failed");

                                                        $("#resend").attr("class","icon-refresh");
                                                        $("#resend").attr("style","cursor:pointer");
                                                        $("#resend").attr("onclick", "dbug();");
                                                        $("#Notes").show();
                                                        $("#Notes").css("font-family","Quicksand");
                                                        $("#Notes").css("font-size","15px");

                                                        $("#MessageResponseRest").css("font-family","Quicksand");
                                                        $("#MessageResponseRest").css("font-size","15px");

                                                        $("#spinner_loading_processing").text("Process failed");
                                                        $("#Notes").text("Hubungkan ulang");

                                                        $("#add_item_customer").prop( "disabled", false );
                                                        $("#add_item_customer").text("Save");
                                                        
                                                        $("#add_item_customer").hide();

                                                    } 
                                                        else {

                                                            if(result['status_SyncAccurate'] == 'false'){
                                                                        
                                                                        $("#spinner_loading_processing").attr("class","badge badge-important");
                                                                        $("#resend").show();
                                                                        $("#MessageResponseRest").show();
                                                                        $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
                                                                        setTimeout(() => MessageResponseRest.style.display='none', 5600)
                                                                        
                                                                        $("#x").hide();
                                                                        $("#codeNumber").hide();
                                                                        
                                                                        $("#spinner_loading_processing").text("Process failed");

                                                                        $("#resend").attr("class","icon-refresh");
                                                                        $("#resend").attr("style","cursor:pointer");
                                                                        $("#resend").attr("onclick", "dbug();");
                                                                        $("#Notes").show();
                                                                        $("#Notes").css("font-family","Quicksand");
                                                                        $("#Notes").css("font-size","15px");

                                                                        $("#MessageResponseRest").css("font-family","Quicksand");
                                                                        $("#MessageResponseRest").css("font-size","15px");

                                                                        $("#spinner_loading_processing").text("Process failed");
                                                                        $("#Notes").text("Hubungkan ulang");

                                                                        $("#add_item_customer").prop( "disabled", false );
                                                                        $("#add_item_customer").text("Save");
                                                                        
                                                                        $("#add_item_customer").hide();
                                                                                        
                                                                } 
                                                                    else 
                                                                            {
                                                                                console.log("berhasil mengakses... true")

                                                                                if(result["status_SyncAccurate"] == 'true'){
                                                                                    
                                                                                    $("#resend").attr("class","hidden");
                                                                                    $("#spinner_loading_processing").attr("class","badge badge-success");
                                                                                    $("#spinner_loading_processing").text("Process successed");
                                                                                    $("#MessageResponseRest").hide();

                                                                                    $("#Notes").text("Data item berhasil disinkronisasi ke Accurate.");
                                                                                    $("#Notes").css("font-family","Quicksand");
                                                                                    $("#Notes").css("font-size","15px");
                                                                                    $("#codeNumber").show();
                                                                                    $("#x").show();
                                                                                    $("#codeNumber").attr("class","badge badge-warning");
                                                                                    $("#x").text("Selamat data anda berhasil diproses.");
                                                                                    $("#codeNumber").text(result["status_SyncAccurate"]);

                                                                                    $("#add_item_customer").prop( "disabled", false );
                                                                                    $("#add_item_customer").text('Save');

                                                                                    $("#add_item_customer").show();
                                                                                        
                                                                                    runsSave(result['fullfield']);

                                                                                } 
                                                                                    else 
                                                                                            {

                                                                console.log("gagal mengakses... false")
                                                                console.log(result['status_failed_accurate'])

                                                                    const MessageResponseRest = document.getElementById("MessageResponseRest")

                                                                        $("#spinner_loading_processing").attr("class","badge badge-important");
                                                                        $("#resend").show();
                                                                        $("#MessageResponseRest").show();
                                                                        $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
                                                                        $("#MessageResponseRest").css("font-family","Quicksand");
                                                                        $("#MessageResponseRest").css("font-size","15px");

                                                                    setTimeout(() => MessageResponseRest.style.display='none', 5600)

                                                                            $("#spinner_loading_processing").text("Process failed");

                                                                            $("#resend").attr("class","icon-refresh");
                                                                            $("#resend").attr("style","cursor:pointer");
                                                                            $("#resend").attr("onclick", "dbug();");

                                                                        $("#spinner_loading_processing").text("Process failed");
                                                                        $("#Notes").text("Hubungkan ulang");
                                                                        $("#Notes").css("font-family","Quicksand");
                                                                        $("#Notes").css("font-size","15px");

                                                                    $("#add_item_customer").hide();

                                                                }
                                                        }
                                                }
                                            }
                                        )
                                }
                            );
                        }
                    }
                }
            })
        });

        // function SaveItemCustomers(event){
        //     event.preventDefault();
          
            // bootbox.confirm("Apa anda yakin ingin keluar aplikasi?", function(event){
            //         if(event){ 
            //             document.getElementById('add_item_customer').submit();
            //         }
            // })
            
        // }

        // scripts add items lost;
        // $("#add_item_customer").click(function(event) {
            // $("#add_item_customer").prop( "disabled", true );
            // $("#add_item_customer").text('Syncing Data..');

            // event.preventDefault();

            //     let customername = document.getElementById('customerx_id').value;
            //     let sub_service = document.getElementById('sub_service_id').value;
            //     let shipment_category = document.getElementById('shipmentx').value;
            //     let moda = document.getElementById('moda_x').value;
            //     let origin = document.getElementById('originx').value;
            //     let destination = document.getElementById('destination_x').value;
            //     let itemovdesc = document.getElementById('itemovdesc').value;
            //     let unit = document.getElementById('unit').value;
            //     let gen_code = document.getElementById('itemcode').value;
            //     let price = document.getElementById('price').value;
                
            //     let minimalQty = document.getElementById('minimalQty').value;
               
            //     let qtypertama = document.getElementById('qtyFirst').value;
            //     let RateFirst = document.getElementById('rateFirsts').value;

            //     if(!shipment_category || !sub_service || !shipment_category || !moda || !origin || !destination || !itemovdesc || !unit || !gen_code || !price ) {
                   
            //         setTimeout(() => $("#add_item_customer").prop( "disabled", false), 200 );
            //         setTimeout(() => $("#add_item_customer").text('Save'),2500);
            //         setTimeout(() => swal("Peringatan !","Pastikan sudah terisi semua !","error"), 3000);
                
            //     } 
            //         else 
            //                 {

            //                     return new Promise((resolve, reject) => {

            //                         SaveItemCustomer(
            //                             RateFirst, qtypertama, minimalQty,
            //                             customername, shipment_category,
            //                             sub_service, shipment_category, moda,
            //                             origin, destination, itemovdesc,
            //                             unit, gen_code, price).then((result) => {
                                            
            //                                 setTimeout(() =>
            //                                 $("#spinner_loading_processing").show(),
            //                                 $("#Notes").show(),2500);

            //                                   if(result['status_SyncAccurate'] == 'false'){
                                                        
            //                                             $("#spinner_loading_processing").attr("class","badge badge-important");
            //                                             $("#resend").show();
            //                                             $("#MessageResponseRest").show();
            //                                             $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
            //                                             setTimeout(() => MessageResponseRest.style.display='none', 5600)
                                                        
            //                                             $("#x").hide();
            //                                             $("#codeNumber").hide();
                                                        
            //                                             $("#spinner_loading_processing").text("Process failed");

            //                                             $("#resend").attr("class","icon-refresh");
            //                                             $("#resend").attr("style","cursor:pointer");
            //                                             $("#resend").attr("onclick", "dbug();");
            //                                             $("#Notes").show();
            //                                             $("#Notes").css("font-family","Quicksand");
            //                                             $("#Notes").css("font-size","15px");

            //                                             $("#MessageResponseRest").css("font-family","Quicksand");
            //                                             $("#MessageResponseRest").css("font-size","15px");

            //                                             $("#spinner_loading_processing").text("Process failed");
            //                                             $("#Notes").text("Hubungkan ulang");

            //                                             $("#add_item_customer").prop( "disabled", false );
            //                                             $("#add_item_customer").text("Save");
                                                        
            //                                             $("#add_item_customer").hide();
                                                                           
            //                                     } 
            //                                         else 
            //                                                 {
            //                                                     console.log("berhasil mengakses... true")

            //                                                     if(result["status_SyncAccurate"] == 'true'){
                                                                    
            //                                                         $("#resend").attr("class","hidden");
            //                                                         $("#spinner_loading_processing").attr("class","badge badge-success");
            //                                                         $("#spinner_loading_processing").text("Process successed");
            //                                                         $("#MessageResponseRest").hide();

            //                                                         $("#Notes").text("Data item berhasil disinkronisasi ke Accurate.");
            //                                                         $("#Notes").css("font-family","Quicksand");
            //                                                         $("#Notes").css("font-size","15px");
            //                                                         $("#codeNumber").show();
            //                                                         $("#x").show();
            //                                                         $("#codeNumber").attr("class","badge badge-warning");
            //                                                         $("#x").text("Selamat data anda berhasil diproses.");
            //                                                         $("#codeNumber").text(result["status_SyncAccurate"]);

            //                                                         $("#add_item_customer").prop( "disabled", false );
            //                                                         $("#add_item_customer").text('Save');

            //                                                         $("#add_item_customer").show();
                                                                        
            //                                                         $("#customerx_id").empty();
            //                                                         $("#sub_service_id").empty();
            //                                                         $("#shipmentx").empty();
            //                                                         $("#moda_x").empty();
            //                                                         $("#originx").empty();
            //                                                         $("#destination_x").empty();
            //                                                         $("#itemovdesc").val('');
            //                                                         $("#unit").val('');
            //                                                         $("#price").val('');

            //                                                         $("#rateFirsts").val('');
            //                                                         $("#minimalQty").val('');
            //                                                         $("#qtyFirst").val('');
            //                                                         $("#rateFirsts").val('');

                                                                    // runsSave();

            //                                                     } 
            //                                                         else 
            //                                                                 {
            //                                                                     console.log("gagal mengakses... false")

            //                                                     const MessageResponseRest = document.getElementById("MessageResponseRest")

            //                                                         $("#spinner_loading_processing").attr("class","badge badge-important");
            //                                                         $("#resend").show();
            //                                                         $("#MessageResponseRest").show();
            //                                                         $("#MessageResponseRest").text("Maaf data barang & jasa yang anda input sudah ada sebelumnya input jasa yang berbeda, silahkan coba lagi..")
            //                                                         $("#MessageResponseRest").css("font-family","Quicksand");
            //                                                         $("#MessageResponseRest").css("font-size","15px");

            //                                                     setTimeout(() => MessageResponseRest.style.display='none', 5600)

            //                                                             $("#spinner_loading_processing").text("Process failed");

            //                                                             $("#resend").attr("class","icon-refresh");
            //                                                             $("#resend").attr("style","cursor:pointer");
            //                                                             $("#resend").attr("onclick", "dbug();");

            //                                                         $("#spinner_loading_processing").text("Process failed");
            //                                                         $("#Notes").text("Hubungkan ulang");
            //                                                         $("#Notes").css("font-family","Quicksand");
            //                                                         $("#Notes").css("font-size","15px");

            //                                                     $("#add_item_customer").hide();

            //                                             }
            //                                     }
            //                             }
            //                     )
            //             }
            //     );
            //  }

             
        // });

    $('.units').select2({});
   $('.citys').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_city',
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

            $(document).ready(function(){
                $.get('/loaded_customer', function(data){
                    let data_add = {'id': 'null', 'name': 'PUBLISH'};
                    data.push(data_add);
                    data.forEach(function (item, index, array) {
                        $('.dtcstmers').select2({
                            placeholder: 'Cari...',
                            ajax: {
                            url: '/loaded-results-customers',
                            dataType: 'json',
                            delay: 250,
                            processResults: function (item, index) {
                                return {
                                    results:  $.map(data, function (fetch_data) {
                                        let sda = '';
                                        return {
                                                text: fetch_data.name,
                                            id: fetch_data.id
                                        }
                                    })
                                };
                            },
                                    cache: true
                                }
                        });
                    });
                });
            });


           $('.dtmoda').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_moda',
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
           
           $('.dtsubservices').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_sub_services',
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

           $('.dtshipmentctgry').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_shipments_category',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.nama,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           var autoExpand = function (field) {

            field.style.height = 'inherit';

            var computed = window.getComputedStyle(field);

            var height = parseInt(computed.getPropertyValue('border-top-width'), 24)
                        + parseInt(computed.getPropertyValue('padding-top'), 24)
                        + field.scrollHeight
                        + parseInt(computed.getPropertyValue('padding-bottom'), 24)
                        + parseInt(computed.getPropertyValue('border-bottom-width'), 24);

            field.style.height = height + 'px';

            };
            $("#itemovdesc").css("min-height", 120)
            document.addEventListener('input', function (event) {
            if (event.target.tagName.toLowerCase() !== 'textarea') return;
            autoExpand(event.target);
            }, false);

        
        $(window).on('load', function(){
           $('#destination_x').on('change', function(e){
                let destination = e.target.value;
                $.get('/loaded_auto_search_txt/find/'+ destination, function(data){
                    $.each(data, function(ix, ox){
                        $.get('/loaded_auto_search_txt/find/'+ $('#originx').val(), function(dax){
                            $.each(dax, function(ix, sdx){
                                $.get('/loaded_sub_services_idx/find/'+ $('#sub_service_id').val(), function(dxz){
                                    $.each(dxz, function(ix, sdc){
                                        $.get('/loaded_shipments_category_idx/find/'+ $('#shipmentx').val(), function(dsxz){
                                            $.each(dsxz, function(ix, sdzx){
                                                $.get('/loads_moda/find/'+ $('#moda_x').val(), function(modid){
                                                    $.each(modid, function(ix, idxkpmo){
                                                        let xss = ``
                                                            $('#price').keyup(function(e){
                                                                const metode = $("#metode").val();
                                                                e.preventDefault()
                                                                clearTimeout(typingTimer);
                                                                if(metode == "dflt"){
                                                                    if ($('#price').val) {
                                                                        let unit1 = $("#unit").val();
                                                                                typingTimer = setTimeout(function(){
                                                                                xss = `( Rate: Rp. ${e.target.value}, Unit: ${unit1} )`
                                                                                $('#itemovdesc').val(''+sdc.name+' '+
                                                                                    sdzx.nama+' '+
                                                                                    idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                                }, 
                                                                            doneTypingInterval 
                                                                        );
                                                                    }
                                                                }
                                                                if(metode == "metode2"){
                                                                    if ($('#minimalQty').val) {
                                                                        typingTimer = setTimeout(function(){
                                                                            let minimalQTx = $("#minimalQty").val();
                                                                            let unitx = $("#unit").val();
                                                                            xss = `( Qty Minimal: ${minimalQTx} ${unitx}, Rate: Rp. ${e.target.value} )`
                                                                            $('#itemovdesc').val(''+sdc.name+' '+
                                                                                sdzx.nama+' '+
                                                                                idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                            }, 
                                                                        doneTypingInterval );
                                                                    }
                                                                } 
                                                            if(metode == "metode3"){
                                                                if ($('#price').val || $('#rateFirsts').val || $("#qtyFirst").val) {
                                                                            typingTimer = setTimeout(function(){
                                                                            let price = $("#price").val();
                                                                            let minimalQT = $("#minimalQty").val();
                                                                            let qtyFirst = $("#qtyFirst").val();
                                                                            let unit = $("#unit").val();
                                                                            let metode = $("#metode").val();
                                                                            let rateFirsts = $("#rateFirsts").val();
                                                                                xss = `( Qty Minimal: ${qtyFirst} ${unit}, Rate: Rp. ${rateFirsts}, Rate Selanjutnya: Rp. ${e.target.value} )`
                                                                                    $('#itemovdesc').val(''+sdc.name+' '+
                                                                                        sdzx.nama+' '+
                                                                                        idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                                    }, 
                                                                            doneTypingInterval
                                                                        );
                                                                    }
                                                                }
                                                            });
                                                         }
                                                    );
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    })
                });
           });
        });
          
   </script>

   <!-- END JAVASCRIPTS -->

@endsection

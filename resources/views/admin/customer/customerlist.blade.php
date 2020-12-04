@extends('admin.layouts.master')
@section('head')
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css">
<style>
    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 50px;
        height: 50px;
        margin: -75px 0 0 -75px;
        border: -2px solid #f3f3f3;
        border-radius: 50%;
        border-top: -2px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    }
    
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s;
        
    }
    
    @-webkit-keyframes animatebottom {
        from { bottom:-100px; opacity:0 } 
        to { bottom:0px; opacity:1 }
    }
    
    @keyframes animatebottom { 
        from{ bottom:-100px; opacity:0 } 
        to{ bottom:0; opacity:1 }
    }
    #myDiv {
        display: none;
    }

</style>
@notifyCss
@endsection
@section('brand')
<a class="brand" href="/home">
    {{--  <img src="../img/logo.png" alt="Tiga Permata System" />  --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Customer</a>
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
       {{-- notifikasi form validasi --}}
		@if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			<strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif
 
		{{-- notifikasi sukses --}}
		@if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button> 
			<strong>{{ $sukses }}</strong>
		</div>
		@endif
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
                        @if(count($trashlist))
                        <div class="metro-nav">
                                <div class="metro-nav-block nav-block-orange">
                                    <a data-original-title="" onclick="location.href='{{url('customer_trashed')}}'">
                                        <i class="info">{{ count($trashlist) }}</i>
                                        <i class="icon-trash"></i>
                                        <div class="status">Trash</div>
                                    </a>
                                </div>
                            <div class="space10"></div>
                            <!--END METRO STATES-->
                        </div>
                    @endif
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                        <div style="text-align:right;">
                                {{-- <button type="button" class="btn btn-info" onclick="location.href='{{ route('create.master.customer', array($some)) }}'">
                                        <i class="icon-plus"></i>
                                            Customer Registration
                                    </button> --}}
                                    <button type="button" class="btn btn-primary mr-5" disabled data-toggle="modal" data-target="#importExcel">
                                        Import
                                    </button>
                        <a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_customer" data-whatever="" class="btn btn-success"><i class="icon-plus"></i> Add Customer</a>
                        {{-- <input type="button" value="+ Customer Registration" onclick="location.href='{{ url('customer/registration') }}'"> --}}
                    </div>

                    <!-- Import Excel -->
	
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>CODE</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Made by users</th> --}}
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($customerlist as $list_customer)
                            <tr class="odd gradeX">
                                @if(Auth::User()->oauth_accurate_company == "146583")
                                <td style="width: 5%;">{{ $list_customer->itemID_accurate3PL }}</td>
                                @else
                                <td style="width: 5%;">{{$list_customer->itemID_accurate}}</td>
                                @endif
                                <td style="width: 19%;">{{$list_customer->name}}</td>
                                <td style="width: 21%;">{{$list_customer->address}}</td>
                                <td style="width: 11%;">{{$list_customer->phone}}</td>
                                <td style="width: 13%;">{{$list_customer->email}}</td>
                                {{-- <td style="width: 10%;">{{$list_customer->check_users_logged_in["name"]}}</td> --}}
                                <td style="width: 15%;">{{$list_customer->created_at}}</td>
                                <td style="width: 20px;"><span class="label label-inverse">{{$list_customer->cstatusid->status}}</span></td>
                                @php
                                    $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($list_customer->id);   
                                @endphp
                                <td style="width: 200px;">
                                    <div class="span3">
                                      <button onclick="location.href='{{ route('update.master.customer', array($some, $encrypts)) }}'" 
                                        class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button>
                                    </div>
                                    <div class="span3">
                                        <button onclick="location.href='{{ route('orders.customer', array($some, $encrypts)) }}'" 
                                        data-original-title="Order Customer Warehouse" data-placement="top" 
                                        class="btn tooltips btn-small btn-success" type="button"><i class="fas fa-warehouse"></i>
                                        </button>
                                    </div>
                                    @can('operasional')
                                    <div class="span4">
                                            <button onclick="location.href='{{ route('add_item_customer.added', $encrypts) }}'" 
                                            data-original-title="Added Item Customer TC" data-placement="top" 
                                            class="btn tooltips btn-small btn-warning" type="button"><i class="fas fa-user-tie"></i>
                                            </button>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                          @endforeach()
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
            </div>
        </div>
        <!-- END ADVANCED TABLE widget-->
        @foreach($customerlist as $list_customer)
        <div class="modal fade" id="add_item{{ $list_customer->id}}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="add_item" aria-hidden="true" style="width:600px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add Items</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="add_item" method="post" action="{{url('transport_item_customer')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                <br />
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Item Code</label>
                    <div class="controls">
                        <input class="input-larg validate[required]" type="text" maxlength="30" name="itemcode" value="{{ $jobs_order_idx }}" />
                        {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Customer</label>
                    <div class="controls">
                    <select class="dtcstmers input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="customerx" name="customerx">
                    </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Sub Service</label>
                    <div class="controls">
                        <select class="dtsubservices input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="sub_service_id" name="sub_service_id">
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Shipment category</label>
                <div class="controls">
                    <select class="dtshipmentctgry input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="shipmentx" name="shipmentx">
                </select>
            </div>
        </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Moda</label>
                <div class="controls">
                    <select class="dtmoda input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="moda_x" name="moda_x">
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" style="text-align: end">Origin</label>
            <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="originx" name="originx">
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="text-align: end">Destination</label>
        <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="destination_x" name="destination_x">
                </select>
            </div>
        </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Move Description</label>
                    <div class="controls">
                        <textarea class="input-large validate[required]" type="text" maxlength="105" id="itemovdesc" name="itemovdesc"></textarea>
                            {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Unit</label>
                        <div class="controls">
                        <input class="input-large validate[required]" type="text" maxlength="30" name="unit" />
                            {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Price</label>
                    <div class="controls">
                    <input class="input-large validate[required]" type="text" maxlength="30" name="price" />
                        {{-- <span class="help-inline">Some hint here</span> --}}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>
@endforeach

<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('import.customer.list', $some) }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import disini</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
 </div>
 @php
        $data=[

            'content' => $generateUNIQUE
        
        ];
 @endphp
@include('admin.transport.transport_order.modal_customer', array(['project_id' => $data ]))
@endsection
@section('javascript')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/mod-validation-customer/mod-validate-field-customers.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
@include('notify::messages')
@notifyJs
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script src="{{ asset('js/dynamic-table.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
   <script> 

    function initialize() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
    }

   let vars;

    function LoaderLoading() {
        vars = setTimeout(initialize, 3000);
    }

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

           $('.dtcstmers').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_customer',
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

           $('.CustomerTaxTypes').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/type-pajak',
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

          const data = $("#since").datepicker( {
                dateFormat: 'dd/mm/yy',
                viewMode: "years",
                minViewMode: "years"
            });

            $('.provins').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
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
           }).on('change', function(e){
                const id = e.target.value;
                    $('.kotaNPWP').select2({
                    placeholder: 'Cari...',
                    ajax: {
                    url: '/cari_province/find/'+ id,
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
                })
           });

           $('.kotaNPWP').select2({
                placeholder: 'Cari...',
           })

           $('.kotaOps').select2({
                placeholder: 'Cari...',
           })

           $('.provinsOps').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
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
           }).on('change', function(e){
               const id = e.target.value;
                $('.kotaOps').select2({
                placeholder: 'Cari...',
                ajax: {
                url: '/cari_province/find/'+ id,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                })
           });

           $(document).ready(function () {
                $("#tax_no").keypress(function (data) {
                    if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                        $("#tax_no").html('errors')
                        return false;
                    }
                });
            });


        // $(document).ready(function () {
        //     $('#tax_no').keypress((e) => {
        //         const data = e.currentTarget.value;
        //             if (typeof data === 'string') {
        //                let format = data.replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})(\d{3})/, '$1.$2.$3.$4-$5.$6');
        //                $(".npwps").val(format);
        //                return true;
        //             }
        //     });
        // });

           $('.type_of_business').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/search_type_of_business',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                    results:  $.map(data, function (item) {
                            return {
                                text: item.industry,
                                id: item.id
                            }
                        })
                    };
                },
                    cache: true
              }
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

           $('#destination_x').on('change', function(e){
                let destination = e.target.value;
                $.get('/loaded_auto_search_txt_cs/find/'+ destination, function(data){
                    $.each(data, function(ix, ox){
                        $.get('/loaded_auto_search_txt_cs/find/'+ $('#originx').val(), function(dax){
                            $.each(dax, function(ix, sdx){
                                $.get('/loaded_sub_services_idx/find/'+ $('#sub_service_id').val(), function(dxz){
                                    $.each(dxz, function(ix, sdc){
                                        $.get('/loaded_shipments_category_idx/find/'+ $('#shipmentx').val(), function(dsxz){
                                            $.each(dsxz, function(ix, sdzx){
                                                $.get('/loads_moda/find/'+ $('#moda_x').val(), function(modid){
                                                    $.each(modid, function(ix, idxkpmo){
                                                        $('#itemovdesc').val(''+sdc.name+' '+sdzx.nama+' '+idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name);
                                                    });
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
           

        $("#add_master_customer").click(function(event) {
            event.preventDefault();

            $("#add_master_customer").prop( "disabled", true )
            $("#add_master_customer").text('Wait processing..'); 

                    let customer_name = $("#project_name").val();
                    let code = $("#code_project").val();
                    let since = $("#since").val();
                    let director = $("#director").val();
                    let type_of_business = $("#type_of_business").val();

                    let npwp = $("#tax_no").val();
                    let tax_address = $("#tax_address").val();
                    let tax_phone = $("#tax_phone").val();
                    let tax_city = $("#tax_city").val();
                    let tax_fax = $("#tax_fax").val();

                    let address = $("#address").val();
                    let kota = $("#kota").val();
                    let phone = $("#phone").val();
                    let fax = $("#fax").val();
                    let email = $("#email").val();
                    let website = $("#website").val();

                    let bank_name = $("#bank_name").val();
                    let no_rek = $("#no_rek").val();
                    let an_bank = $("#an_bank").val();
                    let term_of_payment = $("#term_of_payment").val();

                    let taxtype = $("#CustomerTaxType").val();
                    let kodepos = $("#ops_kodepos").val();
                    let provin = $("#provinceops").val();

                    let almtpnghb = $("#alamatpenagihan").val();
                    let almtpnghprvn = $("#penagihanPRV").val();
                    let almtpnghcty = $("#penagihanKOTA").val();

            
                    // if(!customer_name || !director) {

                        // swal("System Detects","Pastikan sudah terisi semua !","error");
                        // $("#add_master_customer").prop( "disabled", false)
                        // $("#add_master_customer").text('Save');
                    // } else {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        let project = customer_name;
                        let tahun = since;
                        let code_project = code;
                        let tax_no = npwp;
                        let direktur = director;
                        let tipe_bisnis = type_of_business;
                        let tax_nomor = tax_no;
                        let tax_alamat = tax_address;
                        let tax_telephone = tax_phone;
                        let tax_kota = tax_city;
                        let tax_faxs = tax_fax;
                        let alamat = address;
                        let ops_kota = kota;
                        let ops_phone = phone;
                        let ops_fax = fax;
                        let ops_email = email;
                        let ops_webs = website;
                        let nama_bank = bank_name;
                        let nomor_rekening = no_rek;
                        let atas_nama_bank = an_bank;
                        let kebijakan_pembayaran = term_of_payment;
                        let CustomerTaxType = taxtype;
                        let ops_kodepos = kodepos;
                        let provinceops = provin;

                        let pengihanPRV = almtpnghprvn;
                        let PNGHN_alamat = almtpnghb;
                        let PNGHcty = almtpnghcty;

                        let request = $.ajax({
                        
                            url: "/save-master-customer",
                            method: "GET",
                            dataType: "json",
                            data: {
                                pengihanPRV:pengihanPRV,
                                PNGHN_alamat:PNGHN_alamat,
                                PNGHcty:PNGHcty,
                                CustomertaxType:CustomerTaxType,
                                tax_no:tax_no,
                                ops_kodepos:ops_kodepos,
                                provinceops:provinceops,
                                project:project,
                                tahun:tahun,
                                code_project:code_project,
                                direktur:direktur,
                                tipe_bisnis: tipe_bisnis,
                                tax_nomor: tax_nomor,
                                tax_alamat: tax_alamat,
                                tax_telephone: tax_phone,
                                tax_kota: tax_kota,
                                tax_faxs: tax_faxs,
                                alamat: alamat,
                                ops_kota: ops_kota,
                                ops_phone: ops_phone,
                                ops_fax: ops_fax,
                                ops_email: ops_email,
                                ops_webs: ops_webs,
                                nama_bank: nama_bank,
                                nomor_rekening: nomor_rekening,
                                atas_nama_bank: atas_nama_bank,
                                kebijakan_pembayaran: kebijakan_pembayaran,
                            },
                            success: function (data) {

                                Swal({
                                    title: 'Successfully',
                                    allowOutsideClick: false,
                                    text: "You have done save Customers!",
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay!',
                                }).then((result) => {
                                    if (result.value) {

                                        setTimeout(() => $('#add_customer').modal('hide'), 1300);
                                        // do domething else with response 
                                        // $('#add_customer').modal('hide');
                                            // clear field after success saved data request!
                                            const provinceops = $("#provinceops");
                                            const provincenpwp = $("#provincenpwp");
                                            const customer_name = $("#project_name");
                                            const since = $("#since");
                                            const director = $("#director");
                                            const type_of_business = $("#type_of_business");

                                            const tax_no = $("#tax_no");
                                            const tax_address = $("#tax_address");
                                            const tax_phone = $("#tax_phone");
                                            const tax_city = $("#tax_city");
                                            const tax_fax = $("#tax_fax");

                                            const address = $("#address");
                                            const kota = $("#kota");
                                            const phone = $("#phone");
                                            const fax = $("#fax");
                                            const email = $("#email");
                                            const website = $("#website");

                                            const bank_name = $("#bank_name");
                                            const no_rek = $("#no_rek");
                                            const an_bank = $("#an_bank");
                                            const term_of_payment = $("#term_of_payment");

                                            const kodePost = $("#ops_kodepos");
                                            const tipepajak = $("#CustomerTaxType");
                                            const addressPRV = $("#penagihanPRV");
                                            const addressCTY = $("#penagihanKOTA");
                                            const addressTGH = $("#alamatpenagihan");
                                            
                                            kodePost.val('');
                                            tipepajak.empty();
                                            addressPRV.empty();
                                            addressCTY.empty();
                                            addressTGH.val('');

                                            provincenpwp.empty();
                                            provinceops.empty();
                                            customer_name.val('');
                                            since.val('');
                                            director.val('');
                                            type_of_business.empty();

                                            tax_no.val('');
                                            tax_address.val('');
                                            tax_phone.val('');
                                            tax_city.empty();
                                            tax_fax.val('');

                                            address.val('');
                                            kota.empty();
                                            phone.val('');
                                            fax.val('');
                                            email.val('');
                                            website.val('');

                                            bank_name.val('');
                                            no_rek.val('');
                                            an_bank.val('');
                                            term_of_payment.val('');
                    
                                            setTimeout(() =>
                                        
                                                window.location.reload()
                                            
                                            , 3500);

                                    }
                                    
                                })
                                    
                        },
                        complete:function(data){

                            $("#add_master_customer").prop( "disabled", false)
                            $("#add_master_customer").text('Save');
                         
                        },
                            error: function(jqXhr, json, errorThrown){

                                let responses = $.parseJSON(jqXhr.responseText).errors;
                               
                                errorsHtml = '<div class="alert alert-danger"><ul>';

                                    if(!$.isEmptyObject(responses.tahun)){

                                        $.each( responses.tahun, function( key, value ) {
                                                $(".StartEnd").html('');
                                                $(".StartEnd").append(value)

                                            }
                                        );

                                    } 
                                        else
                                            {
                                                $(".StartEnd").html('');
                                                $(".Sinces").hide()
                                    }

                                    // if(!$.isEmptyObject(responses.tax_no)){
                                    
                                    // $.each( responses.tax_no, function( key, value ) {
                                    //         $(".inputNpwp").html('');
                                    //         $(".inputNpwp").append(value);
                                    //         $(".npwp").show();

                                    //         }
                                    //     );

                                    // } 
                                    //     else
                                    //         {
                                    //             $(".inputNpwp").html('');
                                    //             $(".npwp").hide();
                                    // }

                                $.each( responses, function( key, value ) {
                                   
                                    // errorsHtml +=  value[0] +'<br/>';
                                   
                                    if(key == "project"){
                                        $(".Customer").html('<label class="Customer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_no"){ //nomor pajak
                                        $(".npwp").html('<label class="npwp control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_kota"){
                                        $(".tax_citys").html('<label class="tax_citys control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_alamat"){
                                        $(".tax_alamatss").html('<label class="tax_alamatss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "ops_kota"){
                                        $(".ops_kotass").html('<label class="ops_kotass control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "alamat"){
                                        $(".alamatops").html('<label class="alamatops control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "nama_bank"){
                                        $(".nama_bankss").html('<label style="width:235px" class="nama_bankss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "atas_nama_bank"){
                                        $(".atas_nama_bankss").html('<label style="width:235px" class="atas_nama_bankss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "nomor_rekening"){
                                        $(".nomor_rekeningss").html('<label style="width:235px" class="nomor_rekeningss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "kebijakan_pembayaran"){
                                        $(".kebijakan_pembayaranss").html('<label class="Custkebijakan_pembayaranssomer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tipe_bisnis"){
                                        $(".tipe_bisnisss").html('<label style="width:235px" class="tipe_bisnisss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "CustomertaxType"){
                                        $(".CustomertaxTypess").html('<label style="width:235px" class="CustomertaxTypess control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "ops_kodepos"){
                                        $(".ops_kodeposss").html('<label style="width:235px" class="ops_kodeposss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "provinceops"){
                                        $(".provinceopsss").html('<label style="width:235px" class="provinceopsss control-label error"><i class="icon-exclamation-sign popovers alert-danger></i></label>');
                                    }
                                    if(key == "PNGHN_alamat"){
                                        $(".PNGHN_alamatss").html('<label class="PNGHN_alamatss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "PNGHcty"){
                                        $(".PNGHctyss").html('<label class="PNGHctyss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "pengihanPRV"){
                                        $(".pengihanPRVss").html('<label style="width:235px" class="CustopengihanPRVssmer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tahun"){

                                        $(".Sinces").html('<label class="Sinces control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');

                                    }
                                    if(key == "ops_email"){

                                        $(".Emails").html('<label class="Emails control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');

                                    }
                                    // console.log(empty(result))
        // document.write("Output : " + result); 
                                });
                                // errorsHtml += '</ul></div>';
                                // Swal({
                                //     title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                //     text: "Maaf proses upload gagal diproses !",
                                //     confirmButtonColor: '#3085d6',
                                //     html: errorsHtml,
                                //     width: 'auto',
                                //     confirmButtonText: 'Confirm',
                                //     // showCancelButton: true,
                                //     type: 'error'
                                //         }).then((result) => {
                                //         if (result.value) {
                                //             return false;
                                //         }
                                //     })
                            }
                        }
                    );
            });
   </script>

@endsection
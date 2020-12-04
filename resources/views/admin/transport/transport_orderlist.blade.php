@extends('admin.layouts.master')
@section('head')
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
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
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<style>
.c-dot-steps {
    position: relative
}
.u-valign-top {
    vertical-align: top !important
}
.c-icon--check-circle:before {
    content: "Z";
    color: #4CAF50;
}

@font-face {
    font-family: "bl_icons_v4";
    src: url("/vendor/pictograph/typefaces/bl_icons_v4/bl_icons_v4.eot");
    src: local("☺"), url("/vendor/pictograph/typefaces/bl_icons_v4/bl_icons_v4.eot") format("embedded-opentype"), url("/vendor/pictograph/typefaces/bl_icons_v4/bl_icons_v4.ttf") format("truetype"), url("/vendor/pictograph/typefaces/bl_icons_v4/bl_icons_v4.woff") format("woff"), url("/vendor/pictograph/typefaces/bl_icons_v4/bl_icons_v4.svg") format("svg");
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: "bl_icons_v4";
    src: url("https://s2.bukalapak.com/ast/pictograph/typefaces/bl_icons_v4/bl_icons_v4-75ffaf090b555ccf5a7d87bca7f0612a0f1ec4efa5e001894be240707c38907b.eot");
    src: local("☺"), url("https://s2.bukalapak.com/ast/pictograph/typefaces/bl_icons_v4/bl_icons_v4-75ffaf090b555ccf5a7d87bca7f0612a0f1ec4efa5e001894be240707c38907b.eot") format("embedded-opentype"), url("https://s3.bukalapak.com/ast/pictograph/typefaces/bl_icons_v4/bl_icons_v4-afd456d75c15a57e4e0f6120d91f34d8da88176739ffb8849de65a48d9cc5727.ttf") format("truetype"), url("https://s2.bukalapak.com/ast/pictograph/typefaces/bl_icons_v4/bl_icons_v4-11fc0aa05a53850a99b5190fa038861fbefd38aabb7521801e606dba9af411c5.woff") format("woff"), url("https://s2.bukalapak.com/ast/pictograph/typefaces/bl_icons_v4/bl_icons_v4-d8f08b703267ba5487fbfef9751453aca30e090e51d77ce013ab6c2b65297c16.svg") format("svg");
    font-weight: normal;
    font-style: normal
}
.c-icon {
    font-family: "bl_icons_v4" !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    vertical-align: middle;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

</style>
@notifyCss
@endsection
@section('brand')
<a class="brand" href="/home">
    {{--  <img src="../img/logo.png" alt="Tiga Permata Systems" />  --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Transport List</a>
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
<body style="overflow-x: hidden; margin: 0;height: 100%;width: 100%;display:inline-block">
    
</body>
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
       {{-- @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div>
       @endif --}}
       {{-- @if (\Session::has('error'))
       <div class="alert alert-danger">
         <p>{{ \Session::get('error') }}</p>
       </div>
      @endif --}}
      <style>
      .ColorsC {
        background-color: #4CAF50; /* Green */
        border: none;
        color:  #ddffee;
        text-decoration: none;
        display: inline-block;
    }
      </style>
    @if ($error = \Session::has('surat-jalan-tidak-tersedia'))
      <div class="alert alert-block alert-error fade in">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <h4 class="alert-heading">{{ \Session::get('surat-jalan-tidak-tersedia') }}</h4><br />
        {{-- <p>{{ \Session::get($error) }}</p> --}}
    </div>
 @endif
      @if (\Session::has('success'))
      <div class="alert alert-block alert-success fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <h4 class="alert-heading">Berhasil disimpan!</h4>
            <p>{{ \Session::get('success') }}</p>
        </div>
     @endif
      @if (\Session::has('error'))
      <div class="alert alert-block alert-error fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <h4 class="alert-heading">System mendeteksi kesalahan!</h4><br />
            <p>{{ \Session::get('error') }}</p>
        </div>
     @endif
     @if(session('alert-success-db-accurate-index'))
        <p id="acc" class="alert alert-success fade in">{!! __("Account has been actived.") !!} </p>
    @endif
     <div id="progress" class="waiting">
        <dt></dt>
        <dd></dd>
    </div>
       <!-- BEGIN ADVANCED TABLE widget-->
       <div class="row-fluid">
            <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget blue">
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
                        {{-- <div style="text-align:left;">
                                <button type="button" class="btn btn-info" onclick="location.href='{{ url('warehouse/registration') }}'">
                                        <i class="icon-plus"></i>
                                            Warehouse Order Registration
                                    </button>
                                </div> --}}
                                        {{-- <div class="form-actions" style="margin-left:29px;"> --}}
                                            {{-- <div class="row-fluid">
                                            <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">Start From Date</label>
                                                        <div class="controls">
                                                            <div class="input-prepend">
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                        <input id="datepickerfrom" name="datepickerfrom" type="text" value="{{ old('datepickerfrom') }}" class="m-ctrl-medium" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">End To Date</label>
                                                <div class="controls">
                                                    <div class="input-prepend">
                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                        <input id="datepickerto" name="datepickerto" v/alue="{{ old('datepickerto') }}" type="text" class="m-ctrl-medium" />
                                                        <button id="explore_data_with_daterange" type="submit" style="margin:0px 10px" class="btn btn-primary">Apply <i class="icon-circle-arrow-right"></i> <i class=""></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                          
                                {{-- </div> --}}
                            {{-- </div> --}}
                            {{-- <form action="/authorization/accurate-db-list-transport-list" method="get">
                                @csrf
                                <div class="row-fluid">
                                    <div class="row-fluid">
                                        <div class="span12" style="text-align:justify;">
                                        @if(!Auth::User()->oauth_accurate_token)
                                                <button type="submit" class="badge badge-default btn-danger">Unactive, activation your account now</button>
                                            @else
                                                <button type="submit" class="badge badge-default btn-success popovers" data-trigger="hover" data-content="Jika pertama masuk kedalam aplikasi 3PS, aktifkan semua session untuk melakukan Transaksi/berpindah cabang. Jika sudah melakukan aktivasi, tidak perlu menekan tombol disamping." data-original-title="Informasi Pengaktifan transaksi pengguna">Activation application</button>
                                        @endif
                                    </div>
                                </div>
                        </form> --}}
                <form action="{{ route('display.rate', array($some)) }}">
                            <h5  style="overflow:hidden"><br/></h5>
                            <div class="input-prepend" style="
                            position: absolute;
                            transform: translate(1%, 10%);">
                              <div class="span3">
                                <div class="control-group span12">
                                        <div class="controls">
                                            <div class="input-prepend">
                                            <span class="add-on">Start Date <i class="icon-calendar"></i></span>
                                            {{-- <input id="datepickerfrom" name="datepickerfrom" value="{{ old('datepickerfrom') }}" type="text" class="span5" /> --}}
                                            <input id="datepickerfrom" name="datepickerfrom" type="text" value="{{ old('datepickerfrom') }}" class="m-ctrl-medium" />

                                            <span class="add-on">End Date <i class="icon-calendar"></i></span>
                                            <input id="datepickerto" name="datepickerto" value="{{ old('datepickerto') }}" type="text" class="m-ctrl-medium" />
                                            <button id="explore_data_with_daterange" type="submit" style="margin:1px 15px" class="btn btn-primary">Apply <i class="icon-circle-arrow-right"></i> <i class=""></i></button>
                                            <button type="button" class="btn btn-info"  onclick="location.href='{{ route('transport.create.order', array($some)) }}'">
                                                <i class="icon-plus"></i>
                                                    Create Transport Order
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                </form>
                    <div style="margin:-13vh 1vw;position: absolute;">
                        <div class="widget-body">
                            <h5><br/></h5>
                            <div class="input-prepend" style="
                            position: absolute;
                            transform: translate(-7%, 100%);">
                                <label class="span3" style="color:black;margin:-7px 25px">Status Order :</label>
                                {{-- <label class="control-label"></label>
                                <label class="span3" style="color:black;margin:0px 10px">Status Order :</label>
                                <span class="label" id="draftds">Draft</span>
                                <span class="label" id="news">New</span>
                                <span class="label" id="processed">Process</span>
                                <span class="label" id="dones">Done</span>
                                <span class="label" id="uploaded">Upload</span>
                                <div class="space10 visible-phone visible-tablet"></div>
                                <span class="label" id="invoice">Invoice</span>
                                <span class="label" id="paid">Paid</span>
                                <span id="canceled" class="label">Cancel</span> --}}
                                <ul class="dus">
                                    <li class="badge badge-info"><a style="text-decoration:none" href="#all" class="all"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>all status</font></a></li>&nbsp;
                                    <li class="badge badge-info" id="draftds"><a style="text-decoration:none" class="static" href="#draft"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>draft</font></a></li>
                                    <li class="badge" id="news"><a href="#new" style="text-decoration:none" class="static"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>new</font></a></li>
                                    <li class="badge" id="processed"><a style="text-decoration:none" class="static" href="#process"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>process</font></a></li>
                                    {{-- <li class="badge" id="uploaded"><a style="text-decoration:none" class="static" href="#upload"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>upload</font></a></li>
                                    <li class="badge" id="invoice"><a style="text-decoration:none" class="static" href="#invoice"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>invoice</font></a></li>
                                    <li class="badge" id="paid"><a style="text-decoration:none" class="static" href="#paid"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>paid</font></a></li> --}}
                                    <li class="badge" id="dones"><a style="text-decoration:none" class="static" href="#done"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>done</font></a></li>
                                    {{-- <li class="badge" id="canceled"><a style="text-decoration:none" class="static" href="#canceled"><font face='Quicksand' style='font-size:12px;color:blanchedalmond'>cancel</font></a></li> --}}
                                  </ul>
                            </div>
                        </div>
                    </div>
                    <div align=right>
                        &nbsp;
                        {{-- <div id="status">  --}}
                        </div> 
                    </div>
                    <div class="form-group">
                    {{-- <form action="{{ route('exports.tc.list', array($some)) }}">
                        <div style="text-align:right;">
                            <div class="form-actions" style="">
                                {{-- <button id="export_orders" type="submit" class="btn btn-success">Export To Accurate <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button> --}}
                    <table class="table table-striped table-bordered table-striped stripe" width=100% id="sample_1">
                            <div style="min-height: calc(8vh - 60px);">
                                    <!-- Your page's content goes here, including header, nav, aside, everything -->
                                   <caption style="font-family: Quicksand"> Management information transport order </caption>
                                </div>  
                        <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#FAFAFA" class="action"></th>
                                    <th colspan="1" bgcolor="#FAFAFA" class="Accurate"></th>
                                    <th colspan="13" bgcolor="#FAFAFA" class="Transports"></th>
                                </tr>
                            <tr>
                                {{-- <th bgcolor="#FAFAFA">#</th> --}}
                                {{-- <th class="nosort" bgcolor="#FAFAFA">Action</th> --}}

                                {{-- <th bgcolor="#FAFAFA">Code</th> --}}
                                <th bgcolor="#FAFAFA"></th>
                                <th bgcolor="#FAFAFA"></th>
                                <th bgcolor="#FAFAFA"></th>
                                {{-- <th bgcolor="#FAFAFA">No Faktur</th> --}}
                                {{-- <th bgcolor="#FAFAFA">Receipt of payment</th> --}}
                                <th class="nosort" bgcolor="#FAFAFA">status</th>
                                {{-- <th bgcolor="#FAFAFA">Job status</th> --}}
                                {{-- <th>ID</th> --}}
                                <th class="nosort" bgcolor="#FAFAFA">Customer</th>
                                {{-- <th bgcolor="#FAFAFA">PO Codes</th> --}}
                                <th class="nosort" bgcolor="#FAFAFA">Collie</th>
                                <th class="nosort" bgcolor="#FAFAFA">A.W(kg)</th>
                                <th class="nosort" bgcolor="#FAFAFA">C.W(kg)</th>
                                <th class="nosort" bgcolor="#FAFAFA">Volume</th>
                                <th class="nosort" bgcolor="#FAFAFA">Origin Details</th>
                                <th class="nosort" bgcolor="#FAFAFA">Destination Details</th>
                                <th class="nosort" bgcolor="#FAFAFA">User</th>
                                <th bgcolor="#FAFAFA">Created By</th>
                            </tr>
                        </thead>
                        @php
                            $results_job_id = $data_transport;
                            foreach ($results_job_id as $key => $value) {
                                # code...
                                $rx[] = $value;
                            }
                        @endphp
                            {{-- {{ $rx }} --}}
                        <tbody>
                          @foreach($data_transport as $transport_order_lists)
                            <tr class="odd gradeX">
                                @php
                                    $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($transport_order_lists->id);   
                                    $encrypt_shipments = \Illuminate\Support\Facades\Crypt::encrypt($transport_order_lists->order_id);   
                                @endphp
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'new')
                                <td style="width: 7%;">
                                        <div class="row-fluid">
                                            <div class="span5">
                                                   <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                        class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal"
                                                        data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                        data-content="Update orders">
                                                       <i class="icon-file"></i>
                                                   </button>
                                                {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                            </div>
                                            &nbsp;
                                            @if ($api_v1 == "true")
                                            <div class="span5">
                                                @if(!$transport_order_lists->order_id)
                                                <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                    data-trigger="hover" data-placement="right"
                                                    data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                    <i class="fas fa-road"></i>
                                                </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                    @else
                                                        <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                            target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                            data-trigger="hover" data-placement="right"
                                                            data-content="Surat jalan Tersedia.">
                                                            <i class="fas fa-road"></i>
                                                        </a>
                                                @endif
                                            </div>
                                            @endif
                                            @if ($api_v1 == "false")
                                                <div class="span5">
                                                        <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                            target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                            data-trigger="hover" data-placement="left">
                                                            {{-- data-content="Report API no Active"> --}}
                                                            <i class="fas fa-road"></i>
                                                        </a>
                                                    {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                </div>
                                            @endif 
                                        </div>
                                        <div class="row-fluid">
                                            {{-- <div class="span3">
                                                <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                                class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                type="button"><i class="icon-small icon-cloud-download"></i></button>
                                            </div> --}}
                                            {{-- hide button, because don't have needs method with status this --}}
                                            {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                                data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                                data-trigger="hover" data-placement="right">
                                                <i class="icon-pencil"></i>
                                            </button> --}}
                                        </div>
                                        @if ($transport_order_lists->sync_accurate == "true")
                                        <div class="span5">
                                            {{-- Sync again, if failed process --}}
                                            <button class="btn popovers btn-small badge badge-warning" data-toggle="modal" onclick="ReSyncAccurateSQSO('{{ $transport_order_lists->order_id }}')"
                                            data-original-title="Accurate Asynchronous" data-trigger="hover" data-placement="right"
                                            data-content="Jika anda yakin menghubungkan HWB ini ke accurate, silahkan klik tombol disamping.">
                                                <i class="icon-refresh"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'process')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                        @if ($transport_order_lists->sync_accurate == "true")
                                        <div class="span5">
                                            {{-- Sync again, if failed process --}}
                                            <button class="btn popovers btn-small badge badge-warning" data-toggle="modal" onclick="ReSyncAccurateSQSO('{{ $transport_order_lists->order_id }}')"
                                            data-original-title="Accurate Asynchronous" data-trigger="hover" data-placement="right"
                                            data-content="Jika anda yakin menghubungkan HWB ini ke accurate, silahkan klik tombol disamping.">
                                                <i class="icon-refresh"></i>
                                            </button>
                                        </div>
                                        @endif
                                        @if ($transport_order_lists->sync_DO == "true")
                                        <div class="span5">
                                            {{-- Sync again, if failed process --}}
                                            <button class="btn popovers btn-small btn-info " data-toggle="modal" onclick="ReSyncAccurateDelivery('{{ $transport_order_lists->order_id }}')"
                                            data-original-title="See more details" data-trigger="hover" data-placement="right"
                                            data-content="Re - Sync again DO, Make sure you use from Mobile Izzy Transport">
                                                <i class="icon-refresh"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'upload')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'draft')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span5">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button>
                                    </div>
                                    @if ($transport_order_lists->sync_accurate == "true")
                                    <div class="span5">
                                        {{-- Sync again, if failed process --}}
                                        <button class="btn popovers btn-small btn-info " data-toggle="modal" onclick="ReSyncAccurateSQSO('{{ $transport_order_lists->order_id }}')"
                                        data-original-title="See more details" data-trigger="hover" data-placement="right"
                                        data-content="Re - Sync again SQ/SO">
                                            <i class="icon-refresh"></i>
                                        </button>
                                    </div>
                                    @endif
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'done')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                data-content="Update orders">
                                                        <i class="icon-file"></i>
                                                </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                    </div>
                                    @if ($transport_order_lists->sync_accurate == "true")
                                    <div class="span5">
                                        {{-- Sync again, if failed process --}}
                                        <button class="btn popovers btn-small badge badge-warning" data-toggle="modal" onclick="ReSyncAccurateSQSO('{{ $transport_order_lists->order_id }}')"
                                        data-original-title="Accurate Asynchronous" data-trigger="hover" data-placement="right"
                                        data-content="Jika anda yakin menghubungkan HWB ini ke accurate, silahkan klik tombol disamping.">
                                            <i class="icon-refresh"></i>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'invoice')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'cancel')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'paid')
                            <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                                <button onclick="location.href='{{ route('transport.show.detail.transaction', array($some, $encrypts)) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="See more details" data-trigger="hover" data-placement="right"
                                                    data-content="Update orders">
                                                   <i class="icon-file"></i>
                                               </button>
                                            {{-- <button  data-original-title="On Progress" data-placement="right" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                        </div>
                                        &nbsp;
                                        @if ($api_v1 == "true")
                                        <div class="span5">
                                            @if(!$transport_order_lists->order_id)
                                            <a target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                data-trigger="hover" data-placement="right"
                                                data-content="Maaf surat jalan, saat ini tidak tersedia.">
                                                <i class="fas fa-road"></i>
                                            </a>
                                            {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                                @else
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="right"
                                                        data-content="Surat jalan Tersedia.">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                            @endif
                                        </div>
                                        @endif
                                        @if ($api_v1 == "false")
                                            <div class="span5">
                                                    <a href="{{ route('shipment.surat.jalan', array($some, $encrypt_shipments)) }}"
                                                        target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                                        data-trigger="hover" data-placement="left">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row-fluid">
                                        {{-- <div class="span3">
                                            <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                            data-original-title="Export xml file" data-placement="right" data-trigger="hover"
                                            class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                            type="button"><i class="icon-small icon-cloud-download"></i></button>
                                        </div> --}}
                                        {{-- <button style="background-color:DARKKHAKI" class="btn popovers btn-small ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                            data-target="#ModalStatusAccoutingTC" style data-toggle="modal"
                                            data-trigger="hover" data-placement="right">
                                            <i class="icon-pencil"></i>
                                        </button> --}}
                                    </div>
                                </td>
                                @else
                            @endif
                                {{-- make custom badge with style="background-color:TEAL|*" --}}
                                {{-- <td style="width: 2%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="{{ $transport_order_lists->id}}"></td> --}}
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'draft')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'process')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:REBECCAPURPLE;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'upload')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:CORAL;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'new')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:DEEPSKYBLUE;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'done')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:FORESTGREEN;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'invoice')
                                <td style="width: 5%;">
                                    {{-- <center><span style='background-color:' class='label'>{{$transport_order_lists->cek_status_transaction->status_name}}</span></center> --}}
                                    <center><span type="button" style="background-color:DARKTURQUOISE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'cancel')
                                <td style="width: 5%;">
                                    <center><span style='background-color:ORANGERED' class='label'>{{$transport_order_lists->cek_status_transaction->status_name}}</span></center>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'paid')
                                <td style="width: 5%;">
                                    <center><span type="button" style="background-color:MEDIUMVIOLETRED;color:white" class="btn badge badge-dark popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Order status history"
                                        data-trigger="hover" data-placement="right" data-content="Lihat riwayat status transaksi">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span></center>
                                    {{-- <center><span style='background-color:MEDIUMVIOLETRED' class='label'>{{$transport_order_lists->cek_status_transaction->status_name}}</span></center> --}}
                                </td>
                                    @else
                                @endif
                                @if(!$transport_order_lists->order_id)
                                    <td style="width: 15%;"><center><span class="badge badge-default btn-danger"> pending</span></center></td>
                                @else 
                                    <td style="width: 15%;"><center>{{$transport_order_lists->order_id}} <span class="c-icon c-icon--check-circle"></span></center></td>
                                @endif
                                {{--  <td style="width: 15%;">{{$transport_order_lists->salesQuotation_cloud}}</td>  --}}
                                @if(!$transport_order_lists->order_id)
                                        @if (!$transport_order_lists->method_izzy)
                                                <td style="width: 15%;"><center><span class="badge badge-default btn-info">pending</span></center></td>
                                            @else
                                                <td style="width: 15%;"><center><span class="badge badge-default btn-danger">pending</span></center></td>
                                        @endif
                                @else 
                                    @if ($transport_order_lists->sync_accurate == "true")
                                            @if (!$transport_order_lists->method_izzy)
                                                    <td style="width: 15%;"><center><span class="badge badge-default btn-info">pending</span></center></td>
                                                @else
                                                    <td style="width: 15%;"><center><span class="badge badge-default btn-info">pending</span></center></td>
                                            @endif
                                        @else
                                     <td style="width: 15%;"><center>{{$transport_order_lists->salesOrders_cloud}} <span class="c-icon c-icon--check-circle"></span></center></td>
                                    @endif
                                @endif
                                {{--  <td style="width: 15%;">{{$transport_order_lists->deliveryOrders_cloud}}</td>  --}}
                                {{-- <td style="width: 15%;">{{$transport_order_lists->salesInvoice_cloud}}</td> --}}
                                {{-- <td style="width: 15%;">{{$transport_order_lists->salesReceipt_cloud}}</td> --}}
                            
                                {{-- this code job for shipments --}}
                                {{-- @if($transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] == "process")
                                    <td style="width: 8%;">
                                    @foreach ($transport_order_lists->job_transaction_details as $item)
                                        @php
                                            $partition = implode(",", (array) $item->job_transports_normalize->job_no);
                                            $preg_replace_to_array = explode(",", $partition);

                                            $partition_fetch_job_id = implode(",", (array) $item->job_transports_normalize->id);
                                            $preg_replace_to_array_fetch_job_id = explode(",", $partition_fetch_job_id);
                                        @endphp
                                        @foreach ($preg_replace_to_array_fetch_job_id as $result_split_array)
                                            <center>
                                                <span id="jobs_delivered" class="badge badge-warning" onclick="voteup('{{ $result_split_array}}')">
                                                    @foreach($preg_replace_to_array as $job_no) 
                                                        {{ $job_no }} 
                                                    @endforeach
                                                </span>
                                            </center>
                                        @endforeach
                                    @endforeach
                                    </td>
                                @endif --}}
                                {{-- @if($transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] == "new")
                                    <td style="width: 8%;">
                                    @foreach ($transport_order_lists->job_transaction_details as $item)
                                        @php
                                            $partition = implode(",", (array) $item->job_transports_normalize->job_no);
                                            $preg_replace_to_array = explode(",", $partition);
                                            $partition_fetch_job_id = implode(",", (array) $item->job_transports_normalize->id);
                                            $preg_replace_to_array_fetch_job_id = explode(",", $partition_fetch_job_id);
                                        @endphp
                                        @foreach ($preg_replace_to_array_fetch_job_id as $result_split_array)
                                            <center>
                                                <span id="jobs_delivered" class="badge" style="background-color:DARKKHAKI" onclick="voteup('{{ $result_split_array}}')">
                                                    @foreach($preg_replace_to_array as $job_no) 
                                                        {{ $job_no }} 
                                                    @endforeach
                                                </span>
                                            </center>
                                        @endforeach
                                    @endforeach
                                    </td>
                                @endif --}}
                                {{-- @if($transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] == "delivering")
                                    <td style="width: 8%;">
                                        @foreach ($transport_order_lists->job_transaction_details as $item)
                                            @php
                                                $partition = implode(",", (array) $item->job_transports_normalize->job_no);
                                                $preg_replace_to_array = explode(",", $partition);
                                                $partition_fetch_job_id = implode(",", (array) $item->job_transports_normalize->id);
                                                $preg_replace_to_array_fetch_job_id = explode(",", $partition_fetch_job_id);
                                            @endphp
                                            @foreach ($preg_replace_to_array_fetch_job_id as $result_split_array)
                                                <center>
                                                    <span id="jobs_delivered" class="badge badge-info" onclick="voteup('{{ $result_split_array}}')">
                                                        @foreach($preg_replace_to_array as $job_no) 
                                                            {{ $job_no }} 
                                                        @endforeach
                                                    </span>
                                                </center>
                                            @endforeach
                                        @endforeach
                                    </td>
                                    @endif --}}
                                {{-- @if($transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] == "delivered")
                                    <td style="width: 8%;">
                                        @foreach ($transport_order_lists->job_transaction_details as $item)
                                            @php
                                                $partition = implode(",", (array) $item->job_transports_normalize->job_no);
                                                $preg_replace_to_array = explode(",", $partition);
                                                $partition_fetch_job_id = implode(",", (array) $item->job_transports_normalize->id);
                                                $preg_replace_to_array_fetch_job_id = explode(",", $partition_fetch_job_id);
                                            @endphp
                                            @foreach ($preg_replace_to_array_fetch_job_id as $result_split_array)
                                                <center>
                                                    <span id="jobs_delivered" class="badge badge-success" onclick="voteup('{{ $result_split_array}}')">
                                                        @foreach($preg_replace_to_array as $job_no) 
                                                            {{ $job_no }} 
                                                        @endforeach
                                                    </span>
                                                </center>
                                            @endforeach
                                        @endforeach
                                    </td>
                                @endif --}}
                                {{-- @if($transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] == "canceled")
                                    <td style="width: 8%;">
                                        @foreach ($transport_order_lists->job_transaction_details as $item)
                                            @php
                                                $partition = implode(",", (array) $item->job_transports_normalize->job_no);
                                                $preg_replace_to_array = explode(",", $partition);
                                                $partition_fetch_job_id = implode(",", (array) $item->job_transports_normalize->id);
                                                $preg_replace_to_array_fetch_job_id = explode(",", $partition_fetch_job_id);
                                            @endphp
                                            @foreach ($preg_replace_to_array_fetch_job_id as $result_split_array)
                                                <center>
                                                    <span id="jobs_delivered" class="badge badge-important" onclick="voteup('{{ $result_split_array}}')">
                                                        @foreach($preg_replace_to_array as $job_no) 
                                                            {{ $job_no }} 
                                                        @endforeach
                                                    </span>
                                                </center>
                                            @endforeach
                                        @endforeach
                                    </td>
                                @endif --}}
                                {{-- @if(!$transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'])
                                    <td style="width:8%;">
                                        {{-- this clear display if not job on this shipment --}}
                                        {{-- <center><span class="badge" style="background-color:DARKRED">unknown</span></center> --}}
                                    {{-- </td>
                                @endif --}}
                                 {{-- <td style="width: 13%;">{{ $transport_order_lists->job_transaction_ones['job_transports']['status_vendor_jobs']['name'] }}
                                   @foreach($transport_order_lists->job_transaction_ones as $job_transport)
                                     {{ $job_transport->job_transports->status_vendor_jobs->name }} 
                                    @endforeach 
                                </td>--}}
                                {{-- <td style="width: 5%;"><div style="text-transform:uppercase">{{++$i}}</div></td> --}}
                                <td style="width: 11%;">{{$transport_order_lists->customers->name}}</td>
                                {{-- <td style="width: 8%;">{{$transport_order_lists->purchase_order_customer}}</td> --}}
                                <td style="width: 3%">{{$transport_order_lists->collie}}</td>
                                <td style="width: 3%">{{$transport_order_lists->actual_weight}}</td>
                                <td style="width: 3%;">{{$transport_order_lists->chargeable_weight}}</td>
                                <td style="width: 3%;">{{$transport_order_lists->volume}}</td>
                                <td style="width: 11%;">{{$transport_order_lists->addressRelatsOrigins['citys']['name']}}</td>
                                <td style="width: 11%;">{{$transport_order_lists->addressRelatsDestinations['citys']['name']}}</td>
                                @if($transport_order_lists->by_users == "146583")
                                <td style="width: 2%;">
                                    <center><span class="badge 3plbadge">{{ __('PT. Tiga Permata Logistik')}}</span>    
                                </td>    
                                @else 
                                    <td style="width: 2%;">
                                        <center><span class="badge 3pebadge">{{ __('PT. Tiga Permata Ekspres')}}</span>    
                                    </td>
                                @endif
                                    <td style="width: 8%;">{{$transport_order_lists->updated_at}}</td>
                                </tr>
                            @endforeach()
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th class="nosort" bgcolor="#FAFAFA">Action</th>
                                    <th bgcolor="#FAFAFA">Status</th>
                                    <th bgcolor="#FAFAFA">Code</th>
                                    {{--  <th bgcolor="#FAFAFA">SQ Number</th>  --}}
                                    <th bgcolor="#FAFAFA">SO Number</th>
                                    {{--  <th bgcolor="#FAFAFA">DO Number</th>  --}}
                                    {{-- <th bgcolor="#FAFAFA">No Faktur</th> --}}
                                    {{-- <th bgcolor="#FAFAFA">Receipt of payment</th> --}}
                                    {{-- <th>ID</th> --}}
                                    {{-- <th class="nosort" bgcolor="#FAFAFA">JOB ID</th> --}}
                                    {{-- <th bgcolor="#FAFAFA">PO Codes</th> --}}
                                    <th class="nosort" bgcolor="#FAFAFA">Customers</th>
                                    <th class="nosort" bgcolor="#FAFAFA">Collie</th>
                                    <th class="nosort" bgcolor="#FAFAFA">A.W(kg)</th>
                                    <th class="nosort" bgcolor="#FAFAFA">C.W(kg)</th>
                                    <th class="nosort" bgcolor="#FAFAFA">Volume</th>
                                    <th class="nosort" bgcolor="#FAFAFA">Origin Details</th>
                                    <th class="nosort" bgcolor="#FAFAFA">Destination Details</th>
                                    <th class="nosort" bgcolor="#FAFAFA">User</th>
                                    <th bgcolor="#FAFAFA">Created</th>
                                </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
            <div class="modal fade" id="ModalStatusAccoutingTC" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="add_item" aria-hidden="true" style="width:600px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Update your status order</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="update_data_transports">
                    <br />
                    {{-- in progress updated vendor --}}
                    <div class="control-group">
                            <label class="control-label" style="text-align: end">Update Status</label>
                            <div class="controls">
                                <select class="updated_status_warehouse_whs form-control validate[required]" style="width:250px;" id="update_status_trnports" name="update_status_trnports">
                           
                            </select>
                        </div>
                    </div>
            </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
        </div>
        </div>
    </div>
 </div>
         {{-- show detail modal --}}
    <div class="modal fade" id="ModalDataOrderTrack" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="add_item" aria-hidden="true" style="width:600px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="headernya" id="myModalWarehouse">Tracking History Order [ Transport ] - </h3>
        </div>
        <div class="row-fluid">
        <img src="{{ asset('img/pre-loader/Preloader_3.gif') }}" id="form_loading_img" alt="Sedang memuat history order" style="display:none;display: block;margin-left: auto;margin-right: auto;">
    </div>
        <div class="loader">
            <div id="modals" class="modal-body">
                <form class="form-horizontal" id="history_data_order_warehouse">
                    <br />
                    <table class="table table-striped table-bordered table-striped" id="TableHistory">
                            <thead>
                                <tr>
                                    <th bgcolor="#FAFAFA">index 1</th>
                                    <th bgcolor="#FAFAFA">index 2</th>
                                    <th bgcolor="#FAFAFA">index 3</th>
                                    <th bgcolor="#FAFAFA">index 4</th>
                                </tr>
                            </thead>
                    </table>
            </div>
        </div>
             <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
    </div>
@endsection

@section('javascript')
 <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
@include('notify::messages')
@notifyJs

<script src="{{ asset('js/jquery-popup.js') }}"></script>
 <script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery-new.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/jquery-1.9.10.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script async type="text/javascript">
   $('#acc').delay(10000).fadeOut('slow');

$("#fntid").css("background","#808080");

$("#paids").css("background","MEDIUMVIOLETRED");
$("#paid").css("background","MEDIUMVIOLETRED");
$("#paidssx").css("background","#0E6655");
$("#news").css("background","DEEPSKYBLUE");
$("#canceled").css("background","#E74C3C");
$("#draftds").css("background","MIDNIGHTBLUE");
$("#drft").css("background","MIDNIGHTBLUE");
$("#dones").css("background","FORESTGREEN");
$(".3pebadge").css("background","FORESTGREEN");
$("#shipments").css("background","FORESTGREEN");
$(".3plbadge").css("background","#9a3832");
$("#processed").css("background","REBECCAPURPLE");
$("#uploaded").css("background","CORAL");
$("#invoice").css("background","#3498DB");
$("#invoiced").css("background","#3498DB");

function voteup(job_id)
{
    // do something with code jobs
    // var item = $("#jobs_delivered").html(job_id);
    alert(job_id);
    // alert("you have deleted Employee "+document.getElementById(val1).innerText);    
}

$(document).ready(function() {
    $('#sample_1 thead th').each( function () {
        $('.action').html("&nbsp; <div id='status'>");
        $('.Accurate').html("<font face='Quicksand' style='font-size:14px'><center> Accurate Online</center></font>");
        $('.Transports').html("");
        let headers = $('#sample_1 thead th').eq( $(this).index() ).text();

            if ($(this).index() == 0 ) {
                // mengkosongkan/clean inputan, jika index mengacu pada action
                headers = $(this).html('<center><label><b>Action</b></label><input style="width:70px" type="text" class="hidden" placeholder="" /></center>');

            }else if($(this).index() == 1){ 

            headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>STATUS</b></label><input id="status_" name="status_" style="width:45px" type="text" placeholder="Status" /></center>' );

            } else if($(this).index() == 2){ 

            headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><span class="badge badge-default btn-danger">Izzy Transports</span><div class="span1"><b>ID ORDER</b></div></font><input id="to_number" name="to_number" style="width:165px" type="text" placeholder="TO Number" /></center>' );

            } else if($(this).index() == 3){ 

            headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><span class="badge badge-default btn-info">Accurate</span><div class="span1"><b>SALES ORDER</b></div></font><input id="so_number" name="so_number" style="width:165px" type="text" placeholder="SO Number" /></center>' );

            } else if($(this).index() == 4){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>CUSTOMER</b></label><input id="search_textfield" name="search_textfield" style="width:145px" type="text" placeholder="Search" /></center>' );

            } else if($(this).index() == 5){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>COLLIE</b></label><input id="collie_x" name="collie_x" style="width:15px" type="text" placeholder="" /></center>' );

            } else if($(this).index() == 6){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>A.W(kg)</b></label><input id="aw_x" name="aw_x" style="width:15px" type="text" placeholder="" /></center>' );
            
            } else if($(this).index() == 7){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>C.W(kg)</b></font><input id="cw_x" name="cw_x" style="width:15px" type="text" placeholder="" /></center>' );

            } else if($(this).index() == 8){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>VOLUME</b></label><input id="volume_x" name="volume_x" style="width:15px" type="text" placeholder="" /></center>' );

            } else if($(this).index() == 9){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>ORIGIN</b></label><input id="origin_x" name="origin_x" style="width:170px" type="text" placeholder="" /></center>' );

            } else if($(this).index() == 10){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>DESTINATION</b></label><input id="destination_x" name="destination_x" style="width:170px" type="text" placeholder="" /></center>' );

            } else if($(this).index() == 11){ 

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>BY</b></label><input id="user_x" name="user_x" style="width:80px" type="text" placeholder="User" /></center>' );

            } else if($(this).index() == 12){

                headers = $(this).html( '<center><font face="Quicksand" style="font-size:14px"><b>CREATED AT</b></font><input id="created_x" name="created_x" style="width:80px" type="text" placeholder="Created" /></center>' );

            }
                else {

                    headers = $(this).html( '<input id="headers" style="width:69px" name="headers" type="text" placeholder="'+headers+'" />' );

            }

            return headers;
            
    } );

    let transport_order_list = $('#sample_1').DataTable( {
        "bStateSave": true,
        "bProcessing":true,
        "bServiceSide":true,
        "scrollX":true,
        "scrollCollapse": true,
        "sScrollY": "388px",
        "sScrollX": "20%",
        "sScrollYInner": "280px",
        "paging":false,
        // "columnDefs": [
        //     { width: '79%', targets: 0 }
        //     "visible": false,
        //     "targets": -1
        // ],
        "columnDefs": [ {
            "visible": false,
            "targets": -1,
            "width": "80%"
        } ],
    //     'createdRow': function(row, data, dataIndex){
    //      // Use empty value in the "Office" column
    //      // as an indication that grouping with COLSPAN is needed
    //      if(data[2] === ''){
    //         // Add COLSPAN attribute
    //         $('td:eq(1)', row).attr('colspan', 5);

    //         // Hide required number of columns
    //         // next to the cell with COLSPAN attribute
    //         $('td:eq(2)', row).css('display', 'none');
    //         $('td:eq(3)', row).css('display', 'none');
    //         $('td:eq(4)', row).css('display', 'none');
    //         $('td:eq(5)', row).css('display', 'none');
    //      }
    //   },
        "colReorder": {
        "allowReorder": true
        },
        "fixedHeader": {
            header: true,
            footer: true
        },
        "fixedColumns": true,
        "bPaginate": false,
        "aaSorting": [[12, "desc" ]],
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets':  ['nosort']
        }],
        "oLanguage": {
            "sSearch": "Pencarian : ",
			"sLoadingRecords": "Silahkan tunggu Sebentar...",
            "sInfoEmpty": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sEmptyTable": "Tidak ada data dalam database.",
			"sZeroRecords": "Pencarian tidak sama dengan kata kunci didalam database!",
            "sInfo": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sLengthMenu": "_MENU_ Isi yang ditampil perhalaman",
            "oPaginate": {
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya"
            }
        },
    } );
      
    $('ul.dus').on('click', 'a.static', function() {

        transport_order_list
        .columns(1)
        .search($(this).text())
        .draw();

    });

    $('ul.dus').on('click', 'a.all', function() {

        transport_order_list
        .search('')
        .columns(1)
        .search('')
        .draw();

    });
    
    /*$("#example tfoot input").on( 'keyup change', function () {
       table
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
    } );*/
    transport_order_list.columns().every( function () {
        var load = this;
 
        $( 'input', this.header() ).on( 'keyup change clear', function () {
            if ( load.search() !== this.value ) {
                load
                .search( this.value )
                .draw();
            }
        } );
    } );
} );

// $(document).ready(function() {
//     // Setup - add a text input to each footer cell
//     $('#example tfoot th').each( function () {
//         var title = $(this).text();
//         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
//     } );
 
//     // DataTable
//     var table = $('#example').DataTable();
 
//     // Apply the search
//     table.columns().every( function () {
//         var that = this;
 
//         $( 'input', this.footer() ).on( 'keyup change clear', function () {
//             if ( that.search() !== this.value ) {
//                 that
//                     .search( this.value )
//                     .draw();
//             }
//         } );
//     } );
// } );


$(function () {
    $(".ModalStatusAccoutingTC").click(function (e) {
            let id_shipment = $(this).data('id');
            $.get('/find-id-transport-show-status/'+id_shipment, function(showingdatastatus){
            $('#myModalLabel1').text(showingdatastatus['cek_status_transaction']['status_name']);
            // $("#update_data_transports").attr('action', '/updated-transport-tc-status/'+id_shipment);
                    $('.updated_status_warehouse_whs').select2({
                        placeholder: 'Cari...',
                        "language": {
                            "noResults": function(){
                                
                                return "Maaf data tidak dapat diproses !"

                            }

                        },
                            ajax: {
                                url: '/load-status-tc-tbl-files/'+id_shipment,
                                dataType: 'json',
                                delay: 250,
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                return {
                                                    text: item.status_name,
                                                    id: item.id
                                            }
                                        })
                                };
                            },
                        cache: true
                        }
                    }
                );

            $("#asdzx").click(function (e) {
                e.preventDefault();
                let update_status_trnports = $("#update_status_trnports").val()
                $.get('/updated-transport-tc-status/'+showingdatastatus['id']+'/'+update_status_trnports, function(showingdatastatus){
                      return
                    })
                });
            })

        });

    });

    $(function() {
        $("#datepickerfrom").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
    
    $(function() {
        $("#datepickerto").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
  
    $( document ).ready(function() {
        $({property: 0}).animate({property: 110}, {
            duration: 4500,
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

    async function CallStaticTransport() {

            const RefreshPageTransport = () => new Promise((resolve, reject) => {

                let cabang = "{{ $some }}";
                let link = '{!! route("transport.static", ":cabang") !!}';
                let redirect = link.replace(":cabang", cabang)

                    setTimeout(() => {

                        window.location.href = redirect;

                    }, 8000);

                }
            );

        return await Promise.all([RefreshPageTransport()])

    }
    

    async function ReSyncAccurateSQSO(code) {

        bootbox.confirm({ 
                    size: "small",
                    message: "Apakah anda yakin untuk menyinkronkan shipment : <span class='badge btn-warning'> "+ code +"</span> Ke Accurate online ?",
                    callback: function(result){
                        if(result == false)
                        {
                            return;
                        } 
                        else 
                        {

                            const SyncDataAccurateCloudSQSO = (code) => {
                                return fetch(`http://your-api.co.id/re-sync-accurate-cloud/${code}`, {
                                        method: 'GET',
                                        cache: 'no-cache',
                                        credentials: 'same-origin',
                                        redirect: 'follow',
                                        referrer: 'no-referrer',
                                        headers: {
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                                    'Content-Type': 'application/json'
                                                }
                                        }
                                    )
                                .then(response => response.json())
                                .then(datashipment => datashipment)
                            }

                            SyncDataAccurateCloudSQSO(code).then(function (asyncdata) {
                            
                                const toast = Swal.mixin(
                                                            {
                                                                toast: true,
                                                                position: 'top',
                                                                showConfirmButton: false,
                                                                timer: 6500
                                                            }
                                                );

                                        if(asyncdata.response){

                                                if(asyncdata.success == "true"){
                                                    CallStaticTransport();
                                                    return new Promise((resolve, reject) => {
                                                        setTimeout(() => resolve(toast({
                                                                title:`<div><i class="fa fa-circle text-success"></i></div>&nbsp;${asyncdata.response}` 
                                                            }
                                                        )), 2000)
                                                    });


                                                }
                                                    else 
                                                            {
                                                                return new Promise((resolve, reject) => {
                                                                        setTimeout(() => resolve(toast({
                                                                                title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;${asyncdata.response}`
                                                                            }
                                                                        )),
                                                                    3000
                                                                )
                                                            }
                                                        );
                                                }
                                        } 
                                }
                            );
                    }
                }
            });
        }

        async function ReSyncAccurateDelivery(code) {

            const SyncDataAccurateCloudDelivery = (code) => {
                return fetch(`http://your-api.co.id/re-sync--delivery-accurate-cloud/${code}`, {
                        method: 'GET',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                    'Content-Type': 'application/json'
                                }
                        }
                    )
                .then(response => response.json())
                .then(datashipment => datashipment)
            }

            SyncDataAccurateCloudDelivery(code).then(function (asyncdata) {
                const toast = Swal.mixin({
                                            toast: true,
                                            position: 'top',
                                            showConfirmButton: false,
                                            timer: 6500
                                        });

                        if(asyncdata.response){

                            let cabang = "{{ $some }}";
                            let link = '{!! route("transport.static", ":cabang") !!}';
                            let redirect = link.replace(":cabang", cabang)

                            if(asyncdata.success == "true"){
                                CallStaticTransport();
                                    
                                    return new Promise((resolve, reject) => {
                                        setTimeout(() => resolve(toast({
                                                title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;${asyncdata.response}`
                                            }
                                        )), 2000)
                                    });

                            }
                                else 
                                        {
                                            return new Promise((resolve, reject) => {
                                                    setTimeout(() => resolve(toast({
                                                        title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;${asyncdata.response}`
                                                    }
                                                )),
                                            3000
                                        )
                                    }
                                );
                            }
                        } 
                    }
                );
            }

    $(function () {
        $(".ModalShowDataHistoryOrder").click(function (e) {
            e.preventDefault();
            let loading_image = $('#form_loading_img');
            let loader = $('.loader');
            loading_image.show();
            loader.hide();
            const tBody = $("#TableHistory > TBODY")[0];

                let histroy_log_idx = $(this).data('id');
                let trHTML = '';
                $('#myModalWarehouse').text("Riwayat transaksi - "+ histroy_log_idx);
                $.get('/history-find-it-details-tc/'+histroy_log_idx, function(showingdatastatus){

                    if(showingdatastatus != '' && showingdatastatus != null){
                        loader.show();
                        loading_image.hide();
                        let arrfsc = new Array();
                        let sdsad = new Array();
                       
                        let dump = function(string, target, replacement) {
                            let i = 0, length = string.length;
                            
                                for (i; i < length; i++) {
                                
                                string = string.replace(target, replacement);
                                
                                }
                            
                            return string;
                                    
                        }
                        let populateList = function(arr){
                        let str = '';
                        for(let i = 0; i < arr.length; i++){
                                    str += '<div><ul>'+ arr[i] +'</ul></div>';
                                }
                            return str;
                        }

                            let tolistnextcell = function(arr){
                                let str = '';
                                let ds, bs, dh, his, ketiga, dsko, dsjo, pod,sdasdf;
                                let arrays = [];
                                let arraysx = [];
                                arr.forEach(function(entry) {

                                    const arrayTCstatus = entry.toString();
                                    his = arrayTCstatus.replace("1","<center><span style='background-color:MIDNIGHTBLUE' class='badge badge-default'>draft</span></center>")
                                    ketiga = arrayTCstatus.replace("2","<center><span style='background-color:REBECCAPURPLE' class='badge badge-default'>Process</span></center>")
                                    pod = arrayTCstatus.replace("3","<center><span style='background-color:DARKTURQUOISE' class='badge badge-default'>Invoice</span></center>")
                                    dh = arrayTCstatus.replace("4","<center><span style='background-color:FORESTGREEN' class='badge badge-default'>Done</span></center>")
                                    ds = arrayTCstatus.replace("5","<center><span style='background-color:red' class='badge badge-default'>Canceled</span></center>")
                                    dsjo = arrayTCstatus.replace("6","<center><span style='background-color:CORAL' class='badge badge-default'>Upload</span></center>")
                                    dsko = arrayTCstatus.replace("7","<center><span style='background-color:MEDIUMVIOLETRED' class='badge badge-default'>Paid</span></center>")
                                    sdasdf = arrayTCstatus.replace("8","<center><span style='background-color:DEEPSKYBLUE' class='badge badge-default'>New</span></center>")
                                    let sd = dh.concat(ds,pod,ketiga,his,dsjo,dsko,sdasdf);
                                    let done = sd.replace(/[0-8]/g, '')
                                        str += '<ul style=""><li style="display:none"></li><div style="width:110px;height: 20px;margin:-1px"><div style="margin:2px;position:absolute" class="c-icon c-icon--check-circle"></div><div class="c-dot-steps"></div>'+ done +'</div></ul>';
                                        // str += '<ul style=""><li style="display:none"></li><div class="c-dot-steps u-valign-top"><span class="c-icon c-icon--check-circle" style="width:117px;z-index: -1;">'+ done +'</div></ul>';
                                       
                                    });

                                return str;
                            }

                            let tolistnextcellsdasd = function(arr){
                                let str = '';
                                for(let i = 0; i < arr.length; i++){
                                    str += '<ul>'+ arr[i] +'</ul>';
                                }
                                return str;
                            }
                                    let tolisterusername = function(arr){
                                        let str = '';
                                        for(let i = 0; i < arr.length; i++){
                                            
                                            str += '<div><ul>'+ arr[i] +'</ul></div>';

                                        }
                                        return str;
                                    }

                                    let tolistshipment = function(arr){
                                        let str = '';
                                        let ifnull;
                                        let arrays = [];
                                        arr.forEach(function(entry) {
                                                if(entry == null){
                                                let datanull = '';
                                                const dasd = JSON.stringify(entry).toString();
                                                    str += '<ul>'+ dasd.replace(null, "<center>empty</center>") +'</ul>';
                                                } else {

                                                    str += '<ul>'+ entry +'</ul>';

                                                }
                                            
                                            });

                                        return str;
                                        
                                    }

                                    let tolistnotelp = function(arr){
                                        let str = '';
                                        for(let i = 0; i < arr.length; i++){
                                            
                                            str += '<div><ul>'+ arr[i] +'</ul></div>';

                                        }
                                        return str;
                                    }

                        for (i = 0; i < showingdatastatus.length; i++) {

                            arrfsc[i] = showingdatastatus[i];

                        }
                            
                            let rdatatcxz3 = [];
                            let rdatatcxz0 = [];
                            let notelp = [];
                            let shipment = [];
                            let rdatatcxz1 = [];
                            let rdatatcxz2 = [];
                            let dasdzsds = [];
                            let asdasd = Array();

                            for (i = 0; i < arrfsc.length; i++) {

                                rdatatcxz0.push(arrfsc[i]['order_id']);
                                rdatatcxz1.push(arrfsc[i]['status']);
                                rdatatcxz2.push(arrfsc[i]['datetime']);
                                rdatatcxz3.push(arrfsc[i]['user_order_transport_history']['name']);
                                notelp.push(arrfsc[i]['user_order_transport_history']['nohp']);
                                shipment.push(arrfsc[i]['job_no']);

                            }

                            $('#modals').html('<td><div style="margin-left:19px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>'
                                +'<td><hr/><center><label>No Telp</label></center><hr /><div>'+'&nbsp;'+tolistnotelp(notelp)+'</div><div></div></div></td>'
                                +'<td><hr/><center><label>Job</label></center><hr /><div>'+'&nbsp;'+tolistshipment(shipment)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Quicksand">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });
</script>
@endsection
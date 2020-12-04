@extends('admin.layouts.master')
@section('head')
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
    <a href="#">Job List Transport</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>

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
                                {{-- <form action="{{url('transport-list-daterange')}}">
                                    <div style="text-align:center;">
                                        <div class="form-actions" style="margin-left:29px">
                                            <div class="row-fluid">
                                            <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">Start From Date</label>
                                                        <div class="controls">
                                                            <div class="input-prepend">
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                        <input id="datepickerfrom" name="datepickerfrom" type="text" class="m-ctrl-medium" />
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
                                                        <input id="datepickerto" name="datepickerto" type="text" class="m-ctrl-medium" />
                                                         <button id="explore_data_with_daterange" type="submit" style="margin:0px 10px" class="btn btn-primary">Apply <i class="icon-circle-arrow-right"></i> <i class=""></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </form> --}}
                    <form action="{{url('/export_transport_order')}}">
                        <div style="text-align:right;">
                            <div class="form-actions" style="">
                                <button type="button" class="btn btn-info" onclick="location.href='{{ route('create.job.transaction', array($some)) }}'">
                                    {{-- <i class="icon-plus"></i> --}}
                                        Add job shipment
                                </button>
                                {{-- <button id="export_orders" type="submit" class="btn btn-success">Export To Accurate <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button> --}}
                                {{-- &nbsp; --}}
                                {{-- <button type="button" class="btn btn-info" onclick="location.href='{{ url('/transport-order-list') }}'">
                                    <i class="icon-plus"></i>
                                        Transport Order Registration
                                </button> --}}
                            </div>
                        </div>
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                {{-- <th bgcolor="#FAFAFA">Vendor</th> --}}
                                <th bgcolor="#FAFAFA">Job Shipment</th>
                                <th bgcolor="#FAFAFA">Transport Code Shipment</th>
                                <th bgcolor="#FAFAFA">Status</th>
                                <th bgcolor="#FAFAFA">Details Shipment</th>
                                <th bgcolor="#FAFAFA">Billing</th>
                            </tr>
                        </thead>
                        {{-- {{ date('Y-m-d H:i:s') }} --}}
                        <tbody>
                                @foreach($dataretrieve_x as $shipment_job_lists)
                                    {{-- @foreach($shipment_job_lists as $shipment_job_lists) --}}
                                    <tr class="odd gradeX">
                                            {{-- <td style="width: 6%;">{{ $shipment_job_lists->vendor_item_transports->vendors->director }}</td> --}}
                                            <td style="width:13%;">{{ $shipment_job_lists->job_no }} </td>
                                            <td style="width:18%;">@foreach($shipment_job_lists->jobtransactiondetil as $shipment_retrieve)<ul><li>{{ e($shipment_retrieve->shipment_id) }}</li></ul>@endforeach()</td>
                                            @if ($shipment_job_lists->status_vendor_jobs->name == 'new')
                                            <td style="width: 5%;">
                                                <span type="button" style="background-color:STEELBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                    data-id="{{ $shipment_job_lists->job_no }}"
                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Jobs"
                                                    data-trigger="hover" data-placement="top" data-content="History Order Jobs">
                                                    {{$shipment_job_lists->status_vendor_jobs->name}}
                                                </span>
                                            </td>
                                                @else
                                            @endif
                                            @if ($shipment_job_lists->status_vendor_jobs->name == 'delivered')
                                            <td style="width: 5%;">
                                                <span type="button" style="background-color:SEAGREEN;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                    data-id="{{ $shipment_job_lists->job_no }}"
                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Jobs"
                                                    data-trigger="hover" data-placement="top" data-content="History Order Jobs">
                                                    {{$shipment_job_lists->status_vendor_jobs->name}}
                                                </span>
                                            </td>
                                                @else
                                            @endif
                                            @if ($shipment_job_lists->status_vendor_jobs->name == 'delivering')
                                            <td style="width: 5%;">
                                                <span type="button" style="background-color:INDIGO;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                    data-id="{{ $shipment_job_lists->job_no }}"
                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Jobs"
                                                    data-trigger="hover" data-placement="top" data-content="History Order Jobs">
                                                    {{$shipment_job_lists->status_vendor_jobs->name}}
                                                </span>
                                            </td>
                                                @else
                                            @endif
                                            @if ($shipment_job_lists->status_vendor_jobs->name == 'process')
                                            <td style="width: 5%;">
                                                <span type="button" style="background-color:SIENNA;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                    data-id="{{ $shipment_job_lists->job_no }}"
                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Jobs"
                                                    data-trigger="hover" data-placement="top" data-content="History Order Jobs">
                                                    {{$shipment_job_lists->status_vendor_jobs->name}}
                                                </span>
                                            </td>
                                                @else
                                            @endif
                                            @if ($shipment_job_lists->status_vendor_jobs->name == 'canceled')
                                            <td style="width: 5%;">
                                                <span type="button" style="background-color:ORANGERED;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                    data-id="{{ $shipment_job_lists->job_no }}"
                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Jobs"
                                                    data-trigger="hover" data-placement="top" data-content="History Order Jobs">
                                                    {{$shipment_job_lists->status_vendor_jobs->name}}
                                                </span>
                                            </td>
                                                @else
                                            @endif
                                            {{-- <td style="width:10%;">{{ $shipment_job_lists->status_vendor_jobs->name }}</td> --}}
                                            <td style="width:7%;">
                                                <div class="span3">
                                                    <button onclick="location.href='{{ route('joblist.vdetail', array($some, $shipment_job_lists->job_no)) }}'" data-original-title="Show Shipment Details" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="far fa-edit"></i></button>
                                                </div>
                                                <div class="span2">
                                                <button class="btn popovers btn-small btn-info ModalStatusJobshipmentlistClass" data-id="{{ $shipment_job_lists->id }}" 
                                                            data-target="#ModalStatusJobshipmentlist" data-toggle="modal" data-original-title="Status Order"
                                                            data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                    </div> 
                                                </div>
                                            </td>
                                            <td style="width:6%;">
                                                <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalAccountBillingClass" data-id="{{ $shipment_job_lists->id }}" 
                                                            data-target="#ModalAccountBilling" data-toggle="modal" data-original-title="Account Billing Shipment"
                                                            data-trigger="hover" data-placement="left" data-content="Detail Billing Account">
                                                        Upload
                                                    </button>
                                                    </div> 
                                                    @php
                                                        $encrypt_report_job = \Illuminate\Support\Facades\Crypt::encrypt($shipment_job_lists->id);   
                                                    @endphp
                                                <div class="span6">
                                                    <a style="background-color: burlywood" href="{{ route('listPekerjaan', array($some, $encrypt_report_job )) }}"
                                                        target="_blank" class="btn popovers btn-small ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                        data-content="Reports Shipper IzzyTransport">
                                                        <i class="fas fa-road"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                            @endforeach()
                        </tbody>
                    </table>
                </form>
                {{-- modal update status job shipment --}}
                <div class="modal fade" id="ModalStatusJobshipmentlist" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="update_status_shipment_list" aria-hidden="true" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Update your status job shipment</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="update_status_transports_job_shipments">
                        <br />
                        <div class="control-group">
                                <label class="control-label" style="text-align: end">[STATUS] Job Shipment</label>
                                <div class="controls">
                                    <select class="update_data_status_job_shipments form-control validate[required]" style="width:250px;" id="update_data_status_job_shipments_jdx" name="update_data_status_job_shipments_jdx">
                               
                                </select>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>

                    {{-- modal form account billing --}}
                    <div class="modal fade" id="ModalAccountBilling" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                    aria-labelledby="ModalAccountBillinglabelID" aria-hidden="true"
                    style="margin:60px -625px;width:1275px;">
                    <p>{{ \Session::get('errors') }}</p>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel1">FORM UPDATE [ TESTING ]</h3>
                    </div>
                    <div id="modal_tc" class="modal-body" style="position: fixed;width:1244px;border: 1px solid LAVENDER;background-color: white;overflow-y: auto;" >
                        <label class="control-label" id="header_status_job_shipment" style="text-align: end"></label>
                        <form class="form-horizontal" id="AccountFORMID">
                            <table class="table table-striped table-bordered table-striped" id="newlistsdsd">
                                    <thead>
                                        <tr>
                                            {{-- <th bgcolor="#FAFAFA">UID</th> --}}
                                            <th bgcolor="#FAFAFA">Transport Code Shipment</th>
                                            {{-- <th bgcolor="#FAFAFA">Status</th> --}}
                                            <th bgcolor="#FAFAFA">Upload</th>
                                            <th bgcolor="#FAFAFA"><center>Download List File</center></th>
                                        </tr>
                                    </thead>
                                    {{-- {{ date('Y-m-d H:i:s') }} --}}
                                    {{-- <tbody>
                                      
                                    </tbody> --}}
                            </table>
                    </form>
                    {{-- table yg blm diupload --}}
                    {{-- <label class="control-label" id="dsop" style="text-align: end"></label>
                    <form class="form-horizontal" id="Formblmupload">
                        <table class="table table-striped table-bordered table-striped" id="beforeUploaded">
                                <thead>
                                    <tr>
                                        <th bgcolor="#FAFAFA">Transport Code Shipment</th>
                                        <th bgcolor="#FAFAFA">Upload</th>
                                        <th bgcolor="#FAFAFA"><center>Download List File</center></th>
                                    </tr>
                                </thead>
                            </table>
                    </form> --}}
                    </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                {{-- <button id="dpnts" type="submit" class="btn btn-primary">Update</button> --}}
                            </div>
                        </div>
                        <div class="modal fade" style="background-color: white;overflow-y: auto;" id="modal_id" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-success">
                                  <h5 class="modal-title text-white" id="exampleModalLabel">Uploading</h5>
                                </div>
                                <div class="modal-body">
                                        <div class="status">0%</div>
                                        <br/>
                                    <br/>
                                </div>
                            </div>
                                <div class="modal-footer">
                                  <strong class="form-control uploading_close_btn">Please wait file uploading..</strong>
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
                                        <div id="modals" class="modal-body">
                                            <form class="form-horizontal" id="history_data_order_warehouse">
                                                <br />
                                                <table class="table table-striped table-bordered table-striped" id="TableHistory">
                                                        <thead>
                                                            <tr>
                                                                <th bgcolor="#FAFAFA">Status</th>
                                                                <th bgcolor="#FAFAFA">Date Time</th>
                                                                <th bgcolor="#FAFAFA">Username</th>
                                                            </tr>
                                                        </thead>
                                                </table>
                                        </div>
                                            <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                        </div>
                                </div>
                        </div>
                </div>
            </div>
          </div>
        </div>
    </div>
 </div>
@endsection
{{-- ro issues transformation https://www.w3.org/TR/css-transforms-1/#transform-rendering --}}
@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>

 @include('sweetalert::view')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>

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
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script src="{{ asset('js/transport_t_list.js') }}"></script>
<script src="{{ asset('js/list_update_pod.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">

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

   

    $(function () {
        $(".ModalAccountBillingClass").click(function (e) {
        e.preventDefault();
        $('#dsop').text('Waiting To Upload - [ File empty ]');
        
            let id_detail = $(this).data('id');

            $.get('/show-jobs-shipment-api-gdrive-v1/' + id_detail, function( data ) {

                for (i = 0; i < data.length; i++) {
                    const status = data[i]['status_vendor_jobs']['name'];
                    
                        $('#header_status_job_shipment').text('STATUS - [ ' + status.toUpperCase() + ' ]');

                }
        
        });

        function countElement(item,array) {
            var count = 0;
            $.each(array, function(i,v) { if (v === item) count++; });
            return count;
        }

        $.ajax({
        url: "/show-jobs-shipment-api-gdrive-v1/"+ id_detail,
        dataType: 'json',
        success: function (detil) {
            // console.table(detil)

            // $('#newlistsdsd tr').not(':first').not(':last').remove();
            $('#newlistsdsd tr').not(':first').remove();
            // $('#beforeUploaded tr').not(':first').remove();
            let html = '';
            let htmlxbefore = '';
            let asdasd = new Array();
                let rdatavitemidx = [];
                let asdxczxf = [];

                for (i = 0; i < detil.length; i++) {

                    rdatavitemidx.push(detil[i]["jobtransactiondetil"]);

                }

                // debug file dynamic and develop file upload

                    rdatavitemidx.forEach(element => {
                        $.each(element, function(idx, Values){

                            if(Values['file_list_pod'] !== null){ 

                                html += '<tr><form id="dix" enctype="multipart/form-data" method="POST">'+
                                            // '<td style="width:350px">' + asdasd['id'] + '</td>' + in 
                                            '<td style="width:400px">' + Values['shipment_id'] + '</td>' +
                                            // '<td style="width:200px">' +  asdasd.transport_shipment_status.status_name+ '</td>' +
                                            // '<td style="width:240px"><input style="width:190px" type="file" onclick="myfunction('+asdasd['id']+')" id="file"></td>' +
                                            '<td style="width:100px"><label style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;"><input data-icon="false" style="width:190px;display: none;" type="file" class="Uploaded" data-id="'+ Values['id'] +'" id="file" enctype="multipart/form-data" multiple="true"/><i class="fas icon-large fa-cloud-upload-alt"></i>&nbsp; Stuck File</label></td>' +
                                            // <button id="process-file-button">Upload</button>
                                        // '<td style="width:200px"><a href="/download-path-file-shipment/'+asdasd['id']+'/requestFILE/'+ sadsd[i] +'"><center>'+ arrx +'</center></td>' +s
                                        '<td style="width:50px"><a href="/google-drive-file-list/'+ Values['shipment_id'] +'/find-file/'+ Values['id'] +'" target="_blank"><center>Download File ('+ Values['file_list_pod'].length +')</center></td>' +
                                        '</form></tr>';

                                } else {
                                    // http://www.formvalidator.net/#file-validators
                                    html += '<tr><form id="dix" enctype="multipart/form-data" method="POST">'+
                                            // '<td style="width:350px">' + asdasd['id'] + '</td>' + in 
                                            '<td style="width:400px">'+ Values['shipment_id'] +'</td>' +
                                            // '<td style="width:200px">' +  asdasd.transport_shipment_status.status_name+ '</td>' +
                                            // '<td style="width:240px"><input style="width:190px" type="file" onclick="myfunction('+asdasd['id']+')" id="file"></td>' +
                                            '<td style="width:100px"><label style=" border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;"><input data-icon="false" style="width:190px;display: none;" type="file" class="Uploaded" data-id="'+ Values['id'] +'" id="file" enctype="multipart/form-data" multiple="true"/><i class="fas icon-large fa-cloud-upload-alt"></i>&nbsp; Upload File</label></td>' +
                                            // <button id="process-file-button">Upload</button>
                                        '<td style="width:50px"><a href="#"><center></center></td>' +
                                    '</form></tr>';
                            }

                        });

                        $('#newlistsdsd tr').first().after(html);
                        
                    });
                        // $('#beforeUploaded tr').first().after(htmlxbefore);

                            // url.split('php')[1]

                },
                error: function (data) {
                    alert(data)
                }
            });
        });
    });

    function getFile(){
        document.getElementById("file").click();
    }


    function functiondownloadfile(data){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            // header:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/download-path-file-shipment/"+data, 
            method: "GET",
            dataType: "json",
            success: function (data) {
                // location.href='/download-path-file-shipment/'+data
                swal("proses anda berhasil");

            },
                error: function(data){
                    swal("maaf terjadi kesalahan");
                }

        });
    }

    //https://stackoverflow.com/questions/25441893/laravel-uploading-file-using-ajax
        // xhr: function() { // custom xhr (is the best)

        // var xhr = new XMLHttpRequest();
        // var total = 0;

        // // Get the total size of files
        // $.each(document.getElementById('files').files, function(i, file) {
        //     total += file.size;
        // });

        // // Called when upload progress changes. xhr2
        // xhr.upload.addEventListener("progress", function(evt) {
        //     // show progress like example
        //     var loaded = (evt.loaded / total).toFixed(2)*100; // percent

        //     $('#progress').text('Uploading... ' + loaded + '%' );
        // }, false);

        // return xhr;
        // },

        // function myfunction(data){
            // console.log(data);

            $('#file').live('change', '.Uploaded', function(e){ 
            e.preventDefault();
            let validExt = ['pdf','jpeg','png']
            let file_data = this.files[0].type.split('/')[1];
                    // console.log(this.files[0].type)
                if(validExt.indexOf(file_data) == -1){
                    Swal({
                            title: 'Invalid file format',
                            text: "Maaf format yang anda masukkan tidak sesuai!",
                            type: 'error',
                            confirmButtonColor: '#FF0000',
                            confirmButtonText: 'Try it!',
                            }).then((result) => {
                                if (result.value) {
                                    // location.reload();
                                    return true;
                                }
                            })
                }
                    else 

                            {

                                let file_data = this.files;
                                let id_shipment = $(this).data('id');
                                let form_data = new FormData();
                                
                                        for (var i = 0; i < file_data.length; i++) {
                                            form_data.append('file[]', file_data[i]);
                                            form_data.append('id_shipment', id_shipment);

                                        }

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    
                                    $.ajax({
                                        xhr: function() {
                                            xhr = $.ajaxSettings.xhr();
                                            $("#modal_id").modal('show');
                                            xhr.upload.onprogress = function(ev) {
                                                if (ev.lengthComputable) {
                                                    let percentComplete = parseInt((ev.loaded / ev.total) * 100);
                                                    $('.uploadProgressBar').attr('aria-valuenow',percentComplete).css('width',percentComplete + '%').text(percentComplete + '%');

                                                    // $('.progressNumber').text('Waiting file uploading..' + percentComplete.toString() + '%');
                                                    // $('.progressNumberUploadNoexists').text('Waiting file uploading..' + percentComplete.toString() + '%');
                                                    if (percentComplete === 100) {
    
                                                        $("#modal_id").modal('hide');
                                                        // $('.progressNumber').text('Completed');
                                                        // $('.progressNumberUploadNoexists').text('Completed');
                                                    }
                                                }
                                            };

                                            xhr.upload.addEventListener("progress", function(evt) {
                                            if (evt.lengthComputable) {
                                                var percentComplete = evt.loaded / evt.total;
                                                percentComplete = parseInt(percentComplete * 100);
                                                $('.status').text('Waiting file uploading..' + percentComplete.toString() + '%');
                                                if (percentComplete === 100) {
                                                    $("#modal_id").modal('hide');
                                                }

                                            }
                                        }, false);

                                            return xhr;
                                        },
                                        async: true,
                                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        type: "POST",
                                        dataType: "json",
                                        contentType: false,
                                        url: "{{ url('/upload-file-shipment-id') }}", 
                                        data: form_data,
                                        processData: false,
                                        cache: false,
                                        success: function (results, textStatus, jqXHR) {
                                            Swal({
                                            title: 'Successfully',
                                            text: "File anda berhasil diupload!",
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Okay!',
                                                }).then((result) => {
                                                    if (result.value) {
                                                        location.reload();
                                                        return true;
                                                    }
                                                })
                                            },
                                            error: function (jqXhr, json, errorThrown) {
                                                let response = $.parseJSON(jqXhr.responseText).message;
                                                // alert(errorsd)
                                                // let msg = jqXhr.message;
                                                // let response = $.parseJSON(jqXhr.responseText).errors;
                                                // let errorsHtml = response;
                                                // alert(msg)
                                                // let errorsHtml = '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
                                                // $.each(response, function (index, value) {
                                                //     console.log(value)
                                                //     errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
                                                // });
                                                Swal({
                                                title: "Error " + jqXhr.status + ': ' + errorThrown,
                                                text: "Maaf proses upload gagal diproses !",
                                                confirmButtonColor: '#3085d6',
                                                html: response,
                                                width: 'auto',
                                                confirmButtonText: 'Refresh',
                                                // showCancelButton: true,
                                                type: 'error'
                                                }).then((result) => {
                                                            if (result.value) {
                                                                location.reload();
                                                                return false;
                                                            }
                                                        })

                                            },

                                    });

                     }
                    // $('#file').val("");

                });
            // });
        // }

         /***********Error msg if file not valid***************/
        //  $('class').change(function () {
        //         var val = $(this).val().toLowerCase();
        //         var regex = new RegExp("(.*?)\.(pdf|txt|jpg|png|doc|docx|xlx|xls|xlsx|jpg|ppt|pptx|tif|tiff|\n\
        //         bmp|pcd|gif|bmp|zip|rar|odt|avi|ogg|m4a|mov|mp3|mp4|mpg|wav|wmv|stp|sldprt|sldasm|iges|igs|stl|x_t|step\n\
        //         |stp|prt|asm|idw|iam|ipt|dxf|dwg|pdf|slddrw|dwf)$");
        //         if (!(regex.test(val))) {
        //             $(this).val('');
        //             alert('Please select correct file format');
        //         }
        //         });
            /*********End*****************/

        $(function () {
        $(".ModalStatusJobshipmentlistClass").click(function (e) {
        e.preventDefault();
            let status_job_shipment = $(this).data('id');
            $("#update_status_transports_job_shipments").attr('action', '/updated-status-job-shipment/'+status_job_shipment);
                    $('.update_data_status_job_shipments').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/status-find-job-shipment/'+status_job_shipment,
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
                        }
                    );
                }
            );
        });


        $(function () {
            $(".ModalShowDataHistoryOrder").click(function (e) {
            e.preventDefault();
            const tBody = $("#TableHistory > TBODY")[0];

                let histroy_log_idx = $(this).data('id');
                var trHTML = '';
                $('#myModalWarehouse').text('Tracking History Order [ Jobs ] - '+histroy_log_idx);
                $.get('/history-find-it-details-jobs/'+histroy_log_idx, function(showingdatastatus){
                    if(showingdatastatus != '' && showingdatastatus != null){
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
                                    const arrayJobsString = entry.toString();
                                        // https://htmlcolorcodes.com/color-names/
                                        his = arrayJobsString.replace("1","<center><span style='background-color:STEELBLUE' class='label'>new</span></center>")
                                        ketiga = arrayJobsString.replace("2","<center><span style='background-color:SIENNA' class='label'>process</span></center>")
                                        pod = arrayJobsString.replace("3","<center><span style='background-color:INDIGO' class='label'>delivering</span></center>")
                                        dh = arrayJobsString.replace("4","<center><span style='background-color:SEAGREEN' class='label'>delivered</span></center>")
                                        ds = arrayJobsString.replace("5","<center><span style='background-color:ORANGERED' class='label'>canceled</span></center>")
                                        let sd = dh.concat(ds,pod,ketiga,his);
                                        let done = sd.replace(/[0-8]/g, '')

                                        str += '<ul style=""><li style="display:none"></li><div style="width:90px;z-index: -1;border-left: 1px dashed gray;height: 20px;">'+ done +'</div></ul>';
                                       
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

                                    let tolistjobs = function(arr){
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
                            let rdatatcxz1 = [];
                            let rdatatcxz4 = [];
                            let rdatatcxz2 = [];
                            let dasdzsds = [];
                            let asdasd = Array();

                            for (i = 0; i < arrfsc.length; i++) {

                                rdatatcxz0.push(arrfsc[i]['order_id']);
                                rdatatcxz1.push(arrfsc[i]['status']);
                                rdatatcxz2.push(arrfsc[i]['datetime']);
                                rdatatcxz3.push(arrfsc[i]['user_order_job_shipment_history']['name']);
                                // rdatatcxz4.push(arrfsc[i]['job_no']);

                            }
                                        
                            $('#modals').html('<td><div style="margin-left:92px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>')
                                // +'<td><hr/><center><label>Jobs</label></center><hr /><div>'+'&nbsp;'+tolistjobs(rdatatcxz4)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Fira Code">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });
        
</script>
@endsection

@extends('admin.layouts.master')
@section('head')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
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
<link rel="stylesheet" href="{{ asset('css/datergpickercstm.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
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
    <a href="#">Jobs Transport List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>
@endsection

@section('content')
<div id="main-content" style="height:1555px">
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
      <div class="alert alert-block alert-success fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <h4 class="alert-heading">Berhasil disimpan!</h4>
            <p>{{ \Session::get('success') }}</p>
        </div>
     @endif
      @if (\Session::has('error'))
      <div class="alert alert-block alert-error fade in">
        <h4 class="alert-heading">System    
                mendeteksi kesalahan!</h4><br />
            <p>{{ \Session::get('error') }}</p>
        </div>
     @endif
     <div id="progress" class="waiting">
        <dt></dt>
        <dd></dd>
    </div>
          
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TAB PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> Job Transports</h4>
                </div>
                <div class="widget-body">
                        {{-- <ul class="nav nav-tabs">
                            <li><a href="#data-driver" data-toggle="tab"><i class="fas fa-money-check-alt"></i> Cost</i></a></li>
                            <li><a href="#pilih-MoT" data-toggle="tab"><i class="fas fa-money-check-alt"></i> Transportasi</i></a></li>
                            <li class="active"><a href="#pilih-shipment" data-toggle="tab"><i class="fas fa-clipboard-list"></i> Shipment</a></li>
                        </ul> --}}
                                <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"><pre><strong>Information Job Shipment</strong></pre></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid ">
                                        <div class="span6">
                                                <div class="control-group">
                                                <label class="control-label">Job UID</label>
                                                <div class="controls">
                                                        <input readonly="disabled" type="text" class="span8"  class="form-control" id="jbs_increment" name="jbs_increment">
                                                        <input readonly="disabled" type="text" class="hidden span8"  class="form-control" id="index_job_id" name="index_job_id">
                                                    {{-- <input type="text" maxlength="30" name="job" value="{{ old('vehicleIdentificationNumber') }}" class="span12 " /> --}}
                                                </div>
                                            </div>
                                        </div>
                                    {{-- <div style="text-align:left;">
                                        <div class="span7">
                                            <div class="control-group">
                                                <label class="control-label">Origin</label>
                                                <div class="controls">
                                                    <select style="width:398px" class="citys validate[required]" tabindex="-1" name="citys" id="citys">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                    <label class="control-label">Destination</label>
                                                    <div class="controls">
                                                        <select style="width:398px" class="citys validate[required]" tabindex="-1" name="destinations" id="destinations">
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                    </div> --}}
                                    </div>
                                    <br/>
                                    {{-- <div class="row-fluid">
                                  
                                    </div> --}}
                                    {{-- <div class="row-fluid">
                                      
                                    </div> --}}
                                    {{-- <div style="text-align:right;"> --}}
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                            <div class="controls">
                                                                    <span class="add-on" style="height: 18px!important;font-size: 15px"><i class="icon-home"> Origin</i></span>
                                                                    <select style="width:400px;" class="citys validate[required]" tabindex="" name="citys" id="citys">
                                                                    </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group" style="position:absolute;margin:23px 405px">
                                                        {{-- <div class="controls" style="font-size: 25px">
                                                            &#10143;
                                                        </div> --}}
                                                    </div>
                                                    <div class="span5">
                                                            <div class="control-group">
                                                                <div class="controls" style="margin-left:30px">
                                                                    <span class="add-on" style="height: 18px!important;font-size: 15px"><i class="icon-home"> Destination</i></span>
                                                                    <select style="width:401px;" class="citys validate[required]" tabindex="-1" name="destinations" id="destinations">
                                                                    </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                    <div class="controls">
                                                                        <div class="input-prepend">
                                                                        <span class="add-on"><i class="icon-calendar"> Estimated time of delivery</i></span>
                                                                            <input class="validate[required]" type="text" value="{{ old('etd') }}" style="width:209px;" placeholder="Enter ETD" maxlength="5" id="etd" name="etd" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="span4">
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <div class="input-prepend">
                                                                        <span class="add-on"><i class="icon-calendar">&nbsp; Estimated time of arrival</i></span>
                                                                        <input class="validate[required]" type="text" value="{{ old('eta') }}" maxlength="5" style="width:246px" placeholder="Enter ETA" id="eta" name="eta" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <button id="add_job_shipment" style="margin: 1px 60px" class="btn btn-success">Saved Jobs Shipment <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                    </div>
                                        {{-- </div> --}}
                                <div class="widget-body">
                                    {{-- <form id="ajax" action="{{url('jobs')}}"> --}}
                                        <div class="row-fluid">
                                                <div class="span12">
    
                                                    <hr>
                                                </div>
                                            </div> 
                        <span id="information_transaction_detail" style="display:none;"> {{-- testing display count collie --}}
                            <div class="row-fluid">
                                <div class="span12">
                                        <!-- BEGIN INLINE TABS PORTLET-->
                                        <div class="widget blue">
                                            <div class="widget-title">
                                                <h4><i class="icon-reorder"></i> Information transport detail</h4>
                                            <span class="tools">
                                            <a href="javascript:;" class="icon-chevron-down"></a>
                                            <a href="javascript:;" class="icon-remove"></a>
                                            </span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="bs-docs-example">
                                                    <ul class="nav nav-tabs" id="myTab">
                                                        <li class="active"><a data-toggle="tab" href="#shipment">Shipment</a></li>
                                                        <li><a data-toggle="tab" href="#transportasi">Transportasi</a></li>
                                                        <li><a data-toggle="tab" href="#costerinfile">Cost</a></li>
                                                        {{-- <li><a data-toggle="tab" href="#profile">Transportasi</a></li> --}}
                                                        {{-- <li class="dropdown">
                                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
                                                            <ul class="dropdown-menu">
                                                                <li><a data-toggle="tab" href="#dropdown1">@fat</a></li>
                                                                <li><a data-toggle="tab" href="#dropdown2">@mdo</a></li>
                                                            </ul>
                                                        </li> --}}
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent">
                                                        <div id="shipment" class="tab-pane fade in active">
                                                            <div style="text-align:left;">
                                                                <div class="form-actions" style="height:-25px">
                                                                    <input type="hidden" style="width:307px;" class="form-control" value="{{ $jobs_idx_latest }}" id="jbs_latest" name="jbs_latest">
                                                                        {{-- <input type="hidden" style="width:307px;" class="form-control" value="{{ $jobs_order_idx }}" id="jbs_increment" name="jbs_increment"> --}}
                                                                        <input type="hidden" style="width:307px;" class="form-control" value="{{ csrf_token() }}" name="_token">
                                                                           
                                                                    <div style="text-align:right;font-family: Fira Code;font-size:14px">
                                                                            <div class="span12">
                                                                                <span>Collie : </span><span id="spanty">0</span>
                                                                            </div>
                                                                        </div>
                                                                        <div style="text-align:right;font-family: Fira Code;font-size:14px">
                                                                            <div class="span12">
                                                                               <span> Volume : </span><span id="spantyx">0</span>
                                                                            </div>
                                                                        </div>
                                                                        <div style="text-align:right;font-family: Fira Code;font-size:14px">
                                                                            <div class="span12">
                                                                               <span> Actual Weight : </span><span id="spantyf">0</span>
                                                                            </div>
                                                                        </div>
                                                                    <div class="span6 hidden">
                                                                        <div class="control-group hidden">
                                                                            <label class="control-label" >get value id inc</label>
                                                                            <div class="controls controls-row">
                                                                                <input type="text" class="input-block-level validate[required]" placeholder="Enter name" id="get_vals" name="get_vals" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span6 hidden">
                                                                        <div class="control-group hidden">
                                                                            <label class="control-label" >get value uid</label>
                                                                            <div class="controls controls-row">
                                                                                <select class="form-control validate[required]" style="width:320px;" id="get_uid" name="get_uid">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span6 hidden">
                                                                        <div class="control-group hidden">
                                                                            <label class="control-label" >value sort shipper</label>
                                                                            <div class="controls controls-row">
                                                                                <select class="form-control validate[required]" style="width:320px;" id="shipper_index" name="shipper_index">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span6 hidden">
                                                                        <div class="control-group hidden">
                                                                            <label class="control-label" >value sort order_id</label>
                                                                            <div class="controls controls-row">
                                                                                <select class="form-control validate[required]" style="width:320px;" id="order_idx_fetch" name="order_idx_fetch">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div style="height:-55px">
                                                                <!-- Your page's content goes here, including header, nav, aside, everything -->
                                                                <div style="position: absolute;text-align:left;margin:-140px 20px">
                                                                    <div class="control-group">
                                                                        <label class="control-label">Pilih Shipment</label>
                                                                        <div class="controls">
                                                                            <select class="form-control validate[required]" style="width:320px;" id="shipment__j" name="shipment__j">
                                                                        </select>
                                                                        <button id="added_job_shipment" onclick="Add()" value="Add" style="margin: 3px" class="btn btn-primary">Add Jobs <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>  
                                                            <div style="text-align:right; hidden;height:25px">
                                                                    <button type="button" id="show_original_table_sample_1" class="btn btn-info hidden" 
                                                                    data-target="#ModalShowOriginalVAL" data-toggle="modal" data-original-title="Show Original List"
                                                                    data-trigger="hover" data-placement="left" data-content="Detail data shipment">
                                                                        {{-- <i class="icon-plus"></i> --}}
                                                                            Shipments List
                                                                    </button>
                                                                <div class="form-actions" style="">
                                                                </div>
                                                            </div>
                                                            <table class="table table-striped table-bordered table-striped toms" id="sample_1" name="ajax_jobs">
                                                                    <thead>
                                                                        <tr>
                                                                            {{-- <th bgcolor="#FAFAFA">check</th> --}}
                                                                            <th class="nosort" style="width:100px" bgcolor="#FAFAFA">Pengiriman Ke-</th>
                                                                            <th class="nosort hidden"style="width:100px" bgcolor="#FAFAFA">UUID</th>
                                                                            <th class="nosort"style="width:100px" bgcolor="#FAFAFA">Shipment ID</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Customers</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Collie</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">A.W(kg)</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Volume</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Origin Details</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Destination Details</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Created</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Status</th>
                                                                            <th class="nosort"bgcolor="#FAFAFA">Action</th>
                                                                            {{-- <th bgcolor="#FAFAFA"><center>Action</center></th> --}}
                                                                        </tr>  
                                                                    </thead>
                                                                    {{-- <button onclick="upNdown('up');">&ShortUpArrow;</button>&NonBreakingSpace;
                                                                    <button onclick="upNdown('down');">&ShortDownArrow;</button> --}}
                                                                    <tbody id="tbods">
                                                                {{-- @foreach($Joblistview as $jobs_field)
                                                                        <tr class="odd gradeX">
                                                                            <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                                                            <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                                                            <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                                                            <td style="width:2%;">
                                                                                <div class="span3">
                                                                                    <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                                                </div> 
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach() --}}
                                                                    </tbody>
                                                                </table>
                                                        <div class="modal fade" id="ModalShowOriginalVAL" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                                                                aria-labelledby="ModalShowOriginalVALID" aria-hidden="true"
                                                                style="margin:60px -625px;width:1275px;">
                                                        <p>{{ \Session::get('errors') }}</p>
                                            
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h3 id="myModalLabel1">FORM LIST SHIPMENTS</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label class="control-label" id="header_status_job_shipment" style="text-align: end"></label>
                                                                    <form class="form-horizontal" id="originalFORMID">
                                                                        <table class="table table-striped table-bordered table-striped" id="shipmentslist">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="width:100px" bgcolor="#FAFAFA">Pengiriman Ke-</th>
                                                                                        <th style="width:100px" bgcolor="#FAFAFA">Shipment ID</th>
                                                                                        <th bgcolor="#FAFAFA">Customers</th>
                                                                                        <th bgcolor="#FAFAFA">Collie</th>
                                                                                        <th bgcolor="#FAFAFA">A.W(kg)</th>
                                                                                        <th bgcolor="#FAFAFA">Volume</th>
                                                                                        <th bgcolor="#FAFAFA">Origin Details</th>
                                                                                        <th bgcolor="#FAFAFA">Destination Details</th>
                                                                                        <th bgcolor="#FAFAFA">Created</th>
                                                                                        <th bgcolor="#FAFAFA">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                            </tbody>
                                                                    </table>
                                                                </form>
                                            
                                                                </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                            {{-- <button id="dpnts" type="submit" class="btn btn-primary">Update</button> --}}
                                                                        </div>
                                                                    </div>
                                                                <div class="control-group hidden">
                                                                    <label class="control-label">parsing value dari shipment id</label>
                                                                        <div class="controls">
                                                                            <select class="vendor_shipment form-control " id="vendor_shipment" style="width:280px;" name="vendor_shipment">
                                                                            </select>
                                                                                <div class="row-fluid">
                                                                                    <div class="span12">
                                                                                        <br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        </div>
                                                <div id="transportasi" class="tab-pane fade">
                                                        <div class="control-group">
                                                                <div class="controls">
                                                                    {{-- <select class="cost_categorys form-control validate[required]" style="width:320px;" id="category_cost_id" name="category_cost_id">
                                                                </select> --}}
                                                                <label class="control-label">Pilih Vehicle</label>
                                                                <select class="vehicle_list form-control validate[required]" id="vehicle_list_id" name="vehicle_list_id" style="width:150px;">
                                                                </select>
                                                                {{-- <span id="tampil_choosen_vehicle" style="display:none;">
                                                                    <select class="vehicle_list form-control validate[required]" id="vehicle_list_id" name="vehicle_list_id" style="width:150px;">
                                                                    </select>
                                                                </span> --}}
                                                                <span id="tampil_NW" style="display:none;">
                                                                    <select class="vendors form-control validate[required]" style="width:320px;" id="vendor_j" name="vendor_j">
                                                                    </select>
                                                                <span id="tampil_v_item_transport" style="display:none;">
                                                                    <select class="vendor_item_transport form-control validate[required]" style="width:320px;" id="vendor_item_transport_idx" name="vendor_item_transport_idx">
                                                                    </select>
                                                                </span>
                                                            </span>
                                                                <span id="tampil_NI" style="display:none;">
                                                                    <select class="internal form-control validate[required]" style="width:320px;" id="internal" name="internal">
                                                                    </select>
                                                                </span>
                                                            </div>
                                                        </div>
                                        <div class="form-actions">
                                                <div class="modal-footer">
                                                        <label style="font-family:'Courier New', Courier, monospace;">INFORMATION TRANSPORTER</label> <strong></strong>
                                                    </div>
                                                            <!-- BEGIN FORM-->
                                                            <br />
                                                        <div class="row-fluid">
                                                                <div class="span6">
                                                                    <div class="control-group">
                                                                        <label class="control-label" >Driver Name</label>
                                                                        <div class="controls controls-row">
                                                                            <input type="text" class="input-block-level validate[required]" placeholder="Enter name" id="drname" name="drname" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="span6">
                                                                    <div class="control-group">
                                                                        <label class="control-label" >Plat Number</label>
                                                                        <div class="controls controls-row">
                                                                            <input type="text" class="input-block-level validate[required]" placeholder="Empty" id="pltnmbr" name="pltnmbr" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                    <div class="span6">
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Driver Phone</label>
                                                                            <div class="controls controls-row">
                                                                                <input type="text" class="input-block-level validate[required]" placeholder="Enter Contact" id="drphn" name="drphn" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span6">
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Document #Ref</label>
                                                                            <div class="controls controls-row">
                                                                                <input type="text" class="input-block-level validate[required]" placeholder="Enter Address" id="docref" name="docref" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Cost</label>
                                                                    <div class="controls controls-row">
                                                                        <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Cost" id="cost_"  name="cost_">
                                                                    </div>
                                                                </div>
                                                                <div class="control-group hidden">
                                                                        <label class="control-label">Value job_costs</label>
                                                                            <div class="controls">
                                                                                <select class="form-control validate[required]" style="width:320px;" id="value_job_costs" name="value_job_costs">
                                                                            </select>
                                                                            <span id="tampil_NW" style="display:none;">
                                                                                <select class="vendor_item_transport form-control validate[required]" style="width:320px;" id="vendor_item_transport_idx" name="vendor_item_transport_idx">
                                                                                </select>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Note</label>
                                                                    <div class="controls">
                                                                        <div class="input-prepend">
                                                                        <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Your Note" id="noted" name="noted">
                                                                        <button id="added_job_cost" onclick="AddJobCost()" value="Add" style="margin: 1px 5px" class="btn btn-primary">Add Transports Costs <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                                    </div>
                                                                </div>
                                                                <br/>
                                                                <br/>
                                                                <table class="table table-striped table-bordered table-striped" id="jobs_cost_list" name="cost_list">
                                                                        <thead>
                                                                            <tr >
                                                                                {{-- <th bgcolor="#FAFAFA">Vendor</th> --}}
                                                                                <th bgcolor="#FAFAFA">UUID</th>
                                                                                <th bgcolor="#FAFAFA">Driver Name</th>
                                                                                <th bgcolor="#FAFAFA">Driver Phone</th>
                                                                                <th bgcolor="#FAFAFA">Plat Number</th>
                                                                                <th bgcolor="#FAFAFA">#No Document</th>
                                                                                <th bgcolor="#FAFAFA">Category</th>
                                                                                <th bgcolor="#FAFAFA">Cost</th>
                                                                                <th bgcolor="#FAFAFA">Note</th>
                                                                                <th bgcolor="#FAFAFA">Action</th>
                                                                            </tr>  
                                                                        </thead>
                                                                        <tbody>
                                                                        {{-- @foreach($Joblistview as $jobs_field)
                                                                        <tr class="odd gradeX">
                                                                            <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                                                            <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                                                            <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                                                            <td style="width:2%;">
                                                                                <div class="span3">
                                                                                    <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                                                </div> 
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach() --}}
                                                                    </tbody>
                                                                </table>
                                                                <div class="control-group hidden">
                                                                        <label class="control-label">Parsing id vendor</label>
                                                                        <div class="controls">  
                                                                            <select class="form-control" id="vendorj_" style="width:280px;" name="vendorj_">
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                    {{-- <div class="modal-footer">
                                                        <br />
                                                        <br />
                                                        <br />
                                                        @can('transport')
                                                            <button id="holas" style="margin: 3px" class="btn btn-success span12">Saved Jobs Shipment <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                        @endcan()
                                                    </div> --}}
                                                </div>
                            
                                                                    {{-- <div style="height: 140px; overflow: auto"> --}}
                                                         
                                                        </div>
                                                         <div id="costerinfile" class="tab-pane fade">
                                                                <div class="control-group">
                                                                        <label class="control-label">Pilih Category Cost</label>
                                                                            <div class="controls">
                                                                                <select class="cost_categorys_of_cost form-control validate[required]" style="width:320px;" id="category_cost_of_cost_id" name="category_cost_of_cost_id">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                            <div class="control-group">
                                                                                <label class="control-label">Cost</label>
                                                                                <div class="controls controls-row">
                                                                                    <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Cost" id="costofcost"  name="costofcost">
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group hidden">
                                                                                    <label class="control-label">Value job_costs</label>
                                                                                        <div class="controls">
                                                                                            <select class="form-control validate[required]" style="width:320px;" id="value_job_costs" name="value_job_costs">
                                                                                        </select>
                                                                                        <span id="tampil_NW" style="display:none;">
                                                                                            <select class="vendor_item_transport form-control validate[required]" style="width:320px;" id="vendor_item_transport_idx" name="vendor_item_transport_idx">
                                                                                            </select>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                        <div class="control-group">
                                                                            <label class="control-label">Note</label>
                                                                                <div class="controls">
                                                                                    <div class="input-prepend">
                                                                                    <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Your Note" id="cost_noted" name="cost_noted">
                                                                                    <button id="added_job_of_cost" onclick="AddJobCostofcost()" style="margin: 1px 5px" class="btn btn-primary">Add Costs <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                                                </div>
                                                                            </div>
                                                                            <br/>
                                                                            <table class="table table-striped table-bordered table-striped" id="job_cost_ofcostlist" name="cost_of_cost_list">
                                                                                    <thead>
                                                                                        <tr >
                                                                                            {{-- <th bgcolor="#FAFAFA">Vendor</th> --}}
                                                                                            <th bgcolor="#FAFAFA">UUID</th>
                                                                                            <th bgcolor="#FAFAFA">Category</th>
                                                                                            <th bgcolor="#FAFAFA">Cost</th>
                                                                                            <th bgcolor="#FAFAFA">Note</th>
                                                                                            <th bgcolor="#FAFAFA">Action</th>
                                                                                        </tr>  
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    {{-- @foreach($Joblistview as $jobs_field)
                                                                                    <tr class="odd gradeX">
                                                                                        <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                                                                        <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                                                                        <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                                                                        <td style="width:2%;">
                                                                                            <div class="span3">
                                                                                                <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                                                            </div> 
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endforeach() --}}
                                                                                </tbody>
                                                                            </table>
                                                                            <div class="control-group hidden">
                                                                                    <label class="control-label">Parsing id vendor</label>
                                                                                    <div class="controls">  
                                                                                        <select class="form-control" id="vendorj_" style="width:280px;" name="vendorj_">
                                                                                        </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                {{-- <div class="modal-footer">
                                                                    <br />
                                                                    <br />
                                                                    <br />
                                                                    @can('transport')
                                                                        <button id="holas" style="margin: 3px" class="btn btn-success span12">Saved Jobs Shipment <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                                    @endcan()
                                                                </div> --}}
                                        
                                                                                {{-- <div style="height: 140px; overflow: auto"> --}}
                                                                     
                                                                    </div>
                                                                    {{-- <div id="dropdown1" class="tab-pane fade">
                                                                        <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                                                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                                                    </div>
                                                                    <div id="dropdown2" class="tab-pane fade">
                                                                        <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
                                                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                                                    </div> --}}
                                                        </div>
                                                        {{--<div id="dropdown2" class="tab-pane fade">
                                                            <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
                                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                                        </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END INLINE TABS PORTLET-->
                                                </div>
                                            </div>
                                            <!-- END INLINE TABS PORTLET-->
                                        </div>
                                    </div>
                                </span>
                            </div>
                               {{-- <div class="control-group">
                                <label class="control-label">Pilih Vendor</label>
                                    <div class="controls">
                                        <select class="vendors form-control validate[required]" style="width:320px;" id="vendor_j" name="vendor_j">
                                </select>
                            </div>
                        </div> --}}
                         
                            {{-- </div> --}}
                            <br />
                            <div class="control-group hidden">
                                <label class="control-label"></label>
                                <div class="controls">
                                <select class="form-control" id="driv_name" style="width:280px;" name="driv_name">
                                </select>
                            </div>
                        </div>

                        <div class="control-group hidden">
                            <label class="control-label"></label>
                            <div class="controls">
                            <select class="form-control" id="driv_phone" style="width:280px;" name="driv_phone">
                            </select>
                        </div>
                    </div>
                    <div class="control-group hidden">
                        <label class="control-label"></label>
                        <div class="controls">
                            <select class="form-control" id="plt_number" style="width:280px;" name="plt_number">
                            </select>
                        </div>
                    </div>
                    <div class="control-group hidden">
                        <label class="control-label"></label>
                        <div class="controls">
                            <select class="form-control" id="doc_driver_shipment" style="width:280px;" name="doc_driver_shipment">
                            </select>
                        </div>
                    </div>
                            <div class="control-group hidden">
                                <label class="control-label"></label>
                                <div class="controls">
                                <select class="form-control" id="itsnote" style="width:280px;" name="itsnote">
                                </select>
                            </div>
                        </div>
                            <div class="control-group hidden">
                                <label class="control-label"></label>
                                <div class="controls">  
                                    <select class="form-control" id="cost_price" style="width:280px;" name="cost_price">
                                    </select>
                            </div>
                        </div>
                            <div class="control-group hidden">
                                <label class="control-label"></label>
                                <div class="controls">  
                                    <select class="form-control" id="vitem_idx" style="width:280px;" name="vitem_idx">
                                    </select>
                            </div>
                        </div>
                        <div class="control-group hidden">
                            <label class="control-label"></label>
                            <div class="controls">  
                                <select class="form-control" style="width:280px;" id="data_all_shipment" name="data_all_shipment">
                                    @foreach ($fetch_data_jtd as $item)
                                        <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->order_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="control-group hidden">
                                    <label class="control-label"></label>
                                    <div class="controls">  
                                        <select class="form-control" id="costid_" style="width:280px;" name="costid_">
                                        </select>
                                </div>
                            </div>
                        <div class="control-group hidden">
                            <label class="control-label"></label>
                            <div class="controls">  
                                <select class="form-control" id="val_shipj" style="width:280px;" name="val_shipj">
                                    </select>
                                    <div class="row-fluid">
                                            <div class="span12">
                                                <br>
                                        </div>
                                    </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>
            <!-- END TAB PORTLET-->
        </div>
    <!-- END PAGE CONTENT-->         
    </div>
</div>
@endsection
@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
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
{{-- <script src="{{ asset('js/table_job_cost_list.js') }}"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">

    // $(document).ready(()=>{ 

    //         let branch_id = "{{$some}}";
    //         var url = '{{ route("showit.find", ":id") }}';

    //         // console.log(`${branch_id}`)
    //         url = url.replace(':id', branch_id);
    //         $.get(url, function(data){
    //             $.each(data, function(index, Obj){
    //                     // $('#cost_').val(''+Obj.price);
    //                     // console.log(Obj.)
    //                     var $option_brnch = $("<option selected></option>").val(Obj.id).text(Obj.branch);
    //                     var $option_cmp = $("<option selected></option>").val(Obj.company.id).text(Obj.company.name);
    //                     $('#companychoose').append($option_cmp).trigger('load');
    //                     $('#branchchoose').append($option_brnch).trigger('load');

    //                 }   
    //             );
    //         });

     
    // });

    $('.citys').select2({
        placeholder : "Select",
           ajax: {
           url: '/load-city-xs/find',
           dataType: 'json',
           delay: 250,
                processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                    text: item.id +' - '+ item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                        cache: true
                }
            }
        );
$(function() {
        $('input[name="etd"]').daterangepicker({
            singleDatePicker: true,
            startDate: new Date(),
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 10,
            autoUpdateInput: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: 'YYYY-MM-DD HH:mm',
                "applyLabel": "Terapkan",
                "cancelLabel": "Batal",
                "parentEl": "date",
             },
        });
    });
        
        $(function() {
            $('input[name="eta"]').daterangepicker({
                singleDatePicker: true,
                startDate: new Date(),
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    "applyLabel": "Terapkan",
                    "cancelLabel": "Batal",
                    "parentEl": "date",
                },
            });
        });

    function AddJobCost() {
        
        //add dummy value of field interface
        AddRowJobs($("#drname").val(),$("#drphn").val(),$("#pltnmbr").val(),$("#docref").val(),$("#vendor_j").val(),$('#category_cost_id').val(), $('#cost_').val(), $('#noted').val(), $('vitem_idx').val());
            // $("#vendor_j").prop("disabled", true);
            $("#vendor_item_transport_idx").empty();
            $("#category_cost_id").val('');
            $("#cost_").val('');
            $("#noted").val('');

        };

        function AddJobCostofcost() {
        
        //add dummy value of field interface
        AddRowJobsofcost($('#category_cost_of_cost_id').val(), $('#costofcost').val(), $('#cost_noted').val());
            // $("#vendor_j").prop("disabled", true);
            // $("#vendor_item_transport_idx").empty();
            // $("#category_cost_id").val('');
            // $("#cost_").val('');
            // $("#noted").val('');

        };

                // table row job cost and driver information transporter [ on progress ]
                function AddRowJobsofcost(category_cost_id, cost_, noted) {

                    if (!category_cost_id) {
                        const toast = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        toast({
                            title: '[Add Cost Jobs] Maaf permintaan anda gagal, Silahkan isikan Cost Category terlebih dahulusss ..'
                        })
                        $("#category_cost_of_cost_id").empty();
                        $("#cost_").val('');
                        $("#cost_noted").val('');
                    } else {
                        
                        //this retrieve value from form input
                        let cosid = document.getElementById('category_cost_of_cost_id').value;
                        let index_job = document.getElementById('index_job_id').value;
                        let cost_pricex = document.getElementById('costofcost').value;
                        let notedx = document.getElementById('cost_noted').value;

                        let request = $.ajax({
                        
                        url: "{{ url('/get-job-shipment-job-costs-equivalent-merged-x-Request-cost')}}",
                        method: "GET",
                        dataType: "json",
                        data: { 
                            // noteds:noteds,
                            cosid:cosid,
                            cost_pricex:cost_pricex,
                            notedx:notedx,
                            index_job:index_job,
                        },
                        success: function (data_ifsuccess) {
                            Swal({
                                title: 'Successfully',
                                text: "You have done save Cost!",
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Okay!',
                            }).then((result) => {
                                if (result.value) {
                                     const tsBody = $("#job_cost_ofcostlist > TBODY")[0];
                        rowjc = tsBody.insertRow(-1);
                        const format = num => {
                            const n = String(num),
                                p = n.indexOf('.')
                            return n.replace(
                                /\d(?=(?:\d{3})+(?:\.|$))/g,
                                (m, i) => p < 0 || i < p ? `${m},` : m
                            )

                        }
                                    let celljcuid = $(rowjc.insertCell(0));
                                    let celljc2 = $(rowjc.insertCell(1));
                                    let celljc3 = $(rowjc.insertCell(2));
                                    let celljc = $(rowjc.insertCell(3));
                                    $.get('/loaded-named-category-name/find/'+ 6, function(data){
                                        // console.log(data)
                                        celljcuid.html(data_ifsuccess.uuid);
                                        celljc2.html(data.name);
                                        celljc3.html(format(cost_));
                                        celljc.html(noted);

                                        celljc = $(rowjc.insertCell(-1));
                                        let btnRemovejc = $("<input />");
                                            btnRemovejc.attr("type", "button");
                                            btnRemovejc.attr("class", "btn btn-primary");
                                            btnRemovejc.attr("onclick", "RemoveCostOfJobs(this);");
                                            btnRemovejc.val("Remove");
                                            celljc.append(btnRemovejc);
                                    });
                                    // location.reload();
                                    // console.log(data)
                                    // $("#jbs_increment").val(data.job_gen);
                                    // $("#index_job_id").val(data.id);ss
                                    $("#add_job_shipment").prop("disabled", true);
                                    $("#added_job_shipment").prop("disabled", true);
                                    $("#added_job_cost").prop("disabled", true);

                                }
                            })
                        },
                            error: function(data){
                                Swal({
                                    type: 'error',
                                    title: 'Terjadi kesalahan sistem..',
                                    // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                    text: 'Try again, please check correct data!',
                                    footer: '<a href>Why do I have this issue?</a>'
                                })
                            }
                        }
                    );

                 
                    }

            };

        // table row job cost and driver information transporter
        function AddRowJobs(driver_name, driver_phone, plat_number, document_ref_shipment, vendor_id, category_cost_id, cost_, noted, arrvitemidx) {

            // if (!category_cost_id) {
                // const toast = Swal.mixin({
                //     toast: true,
                //     position: 'top',
                //     showConfirmButton: false,
                //     timer: 3000
                // });

                // toast({
                //     title: '[Add Jobs] Maaf permintaan anda gagal, Silahkan isikan Cost Category terlebih dahulu ..'
                // })
                // $("#vendor_j").empty();
                // $("#vendor_j").prop("enabled", true);
                // $("#vendor_item_transport_idx").empty();
                // $("#cost_").val('');
            // } else {
                $("#vendor_j").prop("enabled", false);
                const tsBody = $("#jobs_cost_list > TBODY")[0];
                rowjc = tsBody.insertRow(-1);
                const format = num => {
                    const n = String(num),
                        p = n.indexOf('.')
                    return n.replace(
                        /\d(?=(?:\d{3})+(?:\.|$))/g,
                        (m, i) => p < 0 || i < p ? `${m},` : m
                    )

                }

                // let celljc0 = $(rowjc.insertCell(0));
                // let celljc1 = $(rowjc.insertCell(1));
                // let celljc2 = $(rowjc.insertCell(-1));
                // let celljc3 = $(rowjc.insertCell(3));
             
                // });

                // added to job transports
                $('#driv_name').append($('<option>' ,{
                    value:driver_name,
                    text:driver_name
                }));

                $('#driv_phone').append($('<option>' ,{
                    value:driver_phone,
                    text:driver_phone
                }));

                $('#plt_number').append($('<option>' ,{
                    value:plat_number,
                    text:plat_number
                }));

                $('#doc_driver_shipment').append($('<option>' ,{
                    value:document_ref_shipment,
                    text:document_ref_shipment
                }));
                
                // added to job costs
                $('#costid_').append($('<option>' ,{
                    value:6,
                    text:6
                }));
                
                $('#vendorj_').append($('<option>' ,{
                    value:vendor_id,
                    text:vendor_id
                }));

                $('#cost_price').append($('<option>' ,{
                    value:cost_,
                    text:cost_
                }));

                $('#itsnote').append($('<option>' ,{
                    value:noted,
                    text:noted
                }));

                let ddlArray = new Array();
                let fflArray = new Array();
                let arrayvendor = new Array();
                let vvIlArray = new Array();
                let arrInoted = new Array();
                let costplArray = new Array();
                let drivnameArraylist = new Array();
                let pltnumber = new Array();
                let driverNumberArray = new Array();
                let document_referenceArray = new Array();

                //transports
                let driverName = document.getElementById('driv_name');
                let platNumber = document.getElementById('plt_number');
                let driverNumber = document.getElementById('driv_phone');
                let document_reference = document.getElementById('doc_driver_shipment');
                //triggered
                let ffl = document.getElementById('costid_');
                let vendor_idx = document.getElementById('vendorj_');
                //cost
                let arrNoted = document.getElementById('itsnote');
                let costll = document.getElementById('cost_price');
                

                // let selectElemxx = document.getElementById('category_cost_id');
                // let artxa = selectElemxx.value;
                let vals_vendosdasr = document.getElementById("vendor_item_transport_idx").value;


                 //driver number
                 for (i = 0; i < document_reference.options.length; i++) {

                    document_referenceArray[i] = document_reference.options[i].value;

                    }

                        let dataListdocumentref = [];

                        for (i = 0; i < document_referenceArray.length; i++) {

                            dataListdocumentref.push(document_referenceArray[i]);

                }

                   //driver number
                   for (i = 0; i < driverNumber.options.length; i++) {

                    driverNumberArray[i] = driverNumber.options[i].value;

                    }

                        let dataListdrivernumber = [];

                        for (i = 0; i < driverNumberArray.length; i++) {

                            dataListdrivernumber.push(driverNumberArray[i]);

                    }
                    
                   //vendor
                   for (i = 0; i < vendor_idx.options.length; i++) {

                    arrayvendor[i] = vendor_idx.options[i].value;

                    }

                        let dataListvendor = [];

                        for (i = 0; i < arrayvendor.length; i++) {

                            dataListvendor.push(arrayvendor[i]);

                    }

                    for (i = 0; i < platNumber.options.length; i++) {

                        pltnumber[i] = platNumber.options[i].value;

                        }

                            let dataListplat = [];

                            for (i = 0; i < pltnumber.length; i++) {

                                dataListplat.push(pltnumber[i]);

                        }


                 //driver name
                 for (i = 0; i < driverName.options.length; i++) {

                    drivnameArraylist[i] = driverName.options[i].value;

                    }

                        let dataListTab = [];

                        for (i = 0; i < drivnameArraylist.length; i++) {

                            dataListTab.push(drivnameArraylist[i]);

                }

                //noted
                for (i = 0; i < arrNoted.options.length; i++) {

                    arrInoted[i] = arrNoted.options[i].value;

                }

                let dataInoted = [];

                for (i = 0; i < arrInoted.length; i++) {

                    dataInoted.push(arrInoted[i]);

                }

                //cost
                
                for (i = 0; i < costll.options.length; i++) {

                    costplArray[i] = costll.options[i].value;

                }

                let datacprice = [];

                for (i = 0; i < costplArray.length; i++) {

                    datacprice.push(costplArray[i]);

                }

                //category cost id
                for (i = 0; i < ffl.options.length; i++) {

                    fflArray[i] = ffl.options[i].value;

                }

                let datajc = [];

                for (i = 0; i < fflArray.length; i++) {

                    datajc.push(fflArray[i]);

                }
                //this retrieve value from form input
                // let cosid = document.getElementById('category_cost_id').value;
                let cosid = 6;
                let driver_named = document.getElementById('drname').value;
                let index_job = document.getElementById('index_job_id').value;
                let vendoridx = document.getElementById('vendor_j').value;
                let plat_numbers = document.getElementById('pltnmbr').value;
                let docref = document.getElementById('docref').value;
                let drive_phones = document.getElementById('drphn').value;
                let cost_pricex = document.getElementById('cost_').value;
                let notedx = document.getElementById('noted').value;

                let noteds = dataInoted;
                let rdatajc = datajc;
                let cost_price = datacprice;
                let datafetchcostid = datajc;
                let datafetchTab = dataListTab;
                let datafetchVen = dataListvendor;
                let dataFetchPlat = dataListplat;
                let dataFetchdriverNumber = dataListdrivernumber;
                let dataFetchDocReference = dataListdocumentref;
                
                let request = $.ajax({
                
                url: "{{ url('/get-job-shipment-job-costs-equivalent-merged')}}",
                method: "GET",
                dataType: "json",
                data: { 
                    // noteds:noteds,
                    cosid:cosid,
                    docref:docref,
                    drive_phones:drive_phones,
                    cost_pricex:cost_pricex,
                    notedx:notedx,
                    vendoridx:vendoridx,
                    plat_numbers:plat_numbers,
                    driver_named:driver_named,
                    index_job:index_job,
                    rdatajc:rdatajc,
                    cost_price:cost_price,
                    datafetchcostid:datafetchcostid,
                    datafetchTab:datafetchTab,
                    datafetchVen:datafetchVen,
                    dataFetchPlat:dataFetchPlat,
                    dataFetchdriverNumber:dataFetchdriverNumber,
                    dataFetchDocReference:dataFetchDocReference
                },
                success: function (dataifsuccess) {
                    Swal({
                        title: 'Successfully',
                        text: "You have done save Summary Vehicle Cost!",
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                    }).then((result) => {
                        if (result.value) {
                            let celluid = $(rowjc.insertCell(0));
                            let celljcdriver = $(rowjc.insertCell(1));
                            let celljcdriverphone = $(rowjc.insertCell(2));
                            let celljcplatnumber = $(rowjc.insertCell(3));
                            let celljcdocument = $(rowjc.insertCell(4));
                            let celljc1 = $(rowjc.insertCell(5));
                            let celljc2 = $(rowjc.insertCell(6));
                            let celljc3 = $(rowjc.insertCell(7));

                            // $.get('/loaded-named-vendor-name/find/'+ vendor_id, function(dataven){
                                $.get('/loaded-named-category-name/find/'+ 6, function(data){
                                    // celljc0.html(dataven.director);
                                    // console.log(data)
                                    celluid.html(dataifsuccess.uuid);
                                    celljcdriver.html(driver_name);
                                    celljcdriverphone.html(driver_phone);
                                    celljcplatnumber.html(plat_number);
                                    celljcdocument.html(document_ref_shipment);
                                    celljc1.html(data.name);
                                    celljc2.html(format(cost_));
                                    celljc3.html(noted);

                                    celljc = $(rowjc.insertCell(-1));
                                    let btnRemovejc = $("<input />");
                                        btnRemovejc.attr("type", "button");
                                        btnRemovejc.attr("class", "btn btn-primary");
                                        btnRemovejc.attr("onclick", "RemoveJobs(this);");
                                        btnRemovejc.val("Remove");
                                        celljc.append(btnRemovejc);
                                });
                            // location.reload();
                            // console.log(data)
                            // $("#jbs_increment").val(data.job_gen);
                            // $("#index_job_id").val(data.id);s
                            $("#add_job_shipment").prop("disabled", true);
                            $("#added_job_of_cost").prop("disabled", false);
                            $("#added_job_shipment").prop("disabled", false);

                        }
                    })
                },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                            text: 'Try again, please check correct data!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    }
                }
            );

                if (artxa == 6) {
                    $.get('/loaded-vendor-item-transports/find/'+vendor_id, function(datax) {
                            $.each(datax, function(index, Hz){
                                $('#vitem_idx').append($('<option>' ,{
                                value:Hz.id,
                                text:Hz.id
                            }));
                        });
                    }
                );
            } 
                else {

                    if (arrvitemidx == null) {
                        $('#vitem_idx').append($('<option>' ,{
                                value:arrvitemidx,
                                text:arrvitemidx
                            })
                        );
                    }
                }
            // }

        };

        function RemoveJobs(button) {
            let rowsz = $(button).closest("TR");
            let namejc = $("TD", rowsz).eq(0).html();
            Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted.!",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    $.ajax({

                            url: "job-transports-cost-delete/find/"+namejc,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const tablesjc = $("#jobs_cost_list")[0];
                                tablesjc.deleteRow(rowsz[0].rowIndex);

                            }

                    });

                    // const table = $("#sample_1")[0];
                    // table.deleteRow(row[0].rowIndex);
                    // document.getElementsByName("vendor_shipment")[0].remove(0);
              
                }

            })
        };
        

        function RemoveCostOfJobs(button) {
            let rowsz = $(button).closest("TR");
            let uuid = $("TD", rowsz).eq(0).html();

            Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted !",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    $.ajax({

                            url: "job-cost-of-cost-delete/find/"+uuid,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const tablesjc = $("#job_cost_ofcostlist")[0];
                                tablesjc.deleteRow(rowsz[0].rowIndex);

                            }

                    });
              
                }

            })
        };

        
        function Add() {
            AddRow($("#shipment__j").val());
            $("#shipment__j").empty();
        };

    
        $("#add_job_shipment").click(function(event) {

            event.preventDefault();

            let ArrayDestinations = new Array();
            let ArrayCitys = new Array();

            let arrCity = document.getElementById('citys');
            let arrDesc = document.getElementById('destinations');


        if(!arrCity.value || !arrDesc.value) {
    
                swal("System Detects","Pastikan origin dan destination sudah ditentukan!","error");

            } else {


                for (i = 0; i < arrCity.options.length; i++) {

                    ArrayCitys[i] = arrCity.options[i].value;

                }

                    let rdatavitemidx = [];

                for (i = 0; i < ArrayCitys.length; i++) {

                    rdatavitemidx.push(ArrayCitys[i]);

                }

                    for (i = 0; i < arrDesc.options.length; i++) {

                        ArrayDestinations[i] = arrDesc.options[i].value;

                    }

                    let datazx = [];

                for (i = 0; i < ArrayDestinations.length; i++) {

                    datazx.push(ArrayDestinations[i]);

                }

                // console.log(datazx)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let gen_code = document.getElementById('jbs_increment').value;

                //data transporter
                let city = document.getElementById('citys').value;
                let destination = document.getElementById('destinations').value;

                let Reqcity = city;
                let Reqdestination = destination;

                let eta_ = document.getElementById('eta').value;
                let _etd = document.getElementById('etd').value;

                // save job transaction details job shpment
                let request = $.ajax({
                
                    url: "{{ url('/save-shipment-idx')}}",
                    method: "GET",
                    dataType: "json",
                    data: { 
                            Reqcity:Reqcity,
                            eta_:eta_,
                            _etd:_etd,
                            Reqdestination: Reqdestination
                    },
                    success: function (data) {
                        Swal({
                            title: 'Successfully',
                            text: "You have done save Job Shipments!",
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Okay!',
                        }).then((result) => {
                            if (result.value) {
                                // location.reload();
                                // console.log(data)
                                $("#jbs_increment").val(data.job_gen);
                                $("#index_job_id").val(data.id);
                                document.getElementById('information_transaction_detail').style.display='inline'
                                $("#add_job_shipment").prop("disabled", true);
                                $("#added_job_shipment").prop("disabled", false);

                            }
                        })
                    },
                        error: function(data){
                            Swal({
                                type: 'error',
                                title: 'Terjadi kesalahan sistem..',
                                // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                text: 'Try again, please check correct data!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    }
                );
            }

        });

        $("#holas").click(function(event) {
            // event.preventDefault();
                let ddlArray = new Array();
                let fflArray = new Array();
                let vvIlArray = new Array();
                let arrInoted = new Array();
                let costplArray = new Array();
                let arrsadkoa = new Array();

                let arrNoted = document.getElementById('itsnote');
                let costll = document.getElementById('cost_price');
                let ddl = document.getElementById('vendor_shipment');
                let ffl = document.getElementById('costid_');
                let vendor_idx = document.getElementById('vendorj_');
                let asdxzddd = document.getElementById('vitem_idx');


        if(!ddl.value || !ffl.value) {
    
                swal("System Detects","system mendeteksi adanya value masih kosong","error");

            } else {


                for (i = 0; i < asdxzddd.options.length; i++) {

                    arrsadkoa[i] = asdxzddd.options[i].value;

                }

                    let rdatavitemidx = [];

                for (i = 0; i < arrsadkoa.length; i++) {

                    rdatavitemidx.push(arrsadkoa[i]);

                }

                    for (i = 0; i < ddl.options.length; i++) {

                        ddlArray[i] = ddl.options[i].value;

                    }
                       
                    let datazx = [];

                for (i = 0; i < ddlArray.length; i++) {

                    datazx.push(ddlArray[i]);

                }

                for (i = 0; i < ffl.options.length; i++) {

                    fflArray[i] = ffl.options[i].value;

                }

                    let datajc = [];

                for (i = 0; i < fflArray.length; i++) {

                    datajc.push(fflArray[i]);

                }

                for (i = 0; i < vendor_idx.options.length; i++) {

                    vvIlArray[i] = vendor_idx.options[i].value;

                }

                let datavvI = [];

                for (i = 0; i < vvIlArray.length; i++) {

                    datavvI.push(vvIlArray[i]);

                }

                for (i = 0; i < costll.options.length; i++) {

                    costplArray[i] = costll.options[i].value;

                }

                let datacprice = [];

                for (i = 0; i < costplArray.length; i++) {

                    datacprice.push(costplArray[i]);

                }

                for (i = 0; i < arrNoted.options.length; i++) {

                    arrInoted[i] = arrNoted.options[i].value;

                }

                let dataInoted = [];

                for (i = 0; i < arrInoted.length; i++) {

                    dataInoted.push(arrInoted[i]);

                }
                // console.log(datazx)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let gen_code = document.getElementById('jbs_increment').value;

                //data transporter
                let driver_name = document.getElementById('drname').value;
                let plat_number = document.getElementById('pltnmbr').value;
                let driver_phone = document.getElementById('drphn').value;
                let document_reference = document.getElementById('docref').value;
                let eta_ = document.getElementById('eta').value;
                let _etd = document.getElementById('etd').value;
                //end

                let vendors_ = document.getElementById('vendor_j').value;

                let requestData = datazx;
                let rdatajc = datajc;
                let erpjc = datacprice;
                let noteds = dataInoted;
                let adspppdjk = rdatavitemidx;
                let asdkjasdoo = datavvI;

                let request = $.ajax({
                
                    url: "{{ url('/get-job-shipment-job-costs-equivalent')}}",
                    method: "GET",
                    dataType: "json",
                    data: { noteds:noteds, 
                            erpjc: erpjc, adspppdjk: adspppdjk,
                            requestData: requestData, rdatajc: rdatajc,
                            gen_code: gen_code, asdkjasdoo: asdkjasdoo,
                            vendors_:vendors_,
                            driver_name: driver_name,
                            plat_number:plat_number,
                            driver_phone:driver_phone,
                            document_reference:document_reference,
                            eta_:eta_,_etd:_etd
                    },
                    success: function (data) {
                        Swal({
                            title: 'Successfully',
                            text: "You have done save Job Shipment!",
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Okay!',
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        })
                    },
                        error: function(data){
                            Swal({
                                type: 'error',
                                title: 'Terjadi kesalahan sistem..',
                                // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                text: 'Try again, please check correct data!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    }
                );
            }

        });

        function up(rows){
            var row = $(this).parents('tr:first');
                if ($(this).is('.up')) {
                    row.insertBefore(row.prev());
                } else {
                    row.insertAfter(row.next());
                }
        };

    //     let job_planning = $('#sample_1').DataTable( {
    //     "bProcessing":false,
    //     "bServiceSide":false,
    //     "scrollX":true,
    //     "scrollCollapse": true,
    //     "sScrollY": "390px",
    //     "sScrollX": "95%",
    //     "sScrollYInner": "180px",
    //     "paging":false,
    //     "bFilter": false,
    //     "columnDefs": [
    //         { width: '70%', targets: 0 }
    //     ],
    //     "colReorder": {
    //     "allowReorder": false
    //     },
    //     "fixedHeader": {
    //         header: false,
    //         footer: true
    //     },
    //     "fixedColumns": true,
    //     "bPaginate": false,
    //     "aaSorting": [[0,1,2,3,4,5,6,7,8,9,10,11,12, "desc" ]],
    //     "aoColumnDefs": [{
    //         'bSortable': false,
    //         'aTargets':  ['nosort']
    //     }],
    //     // "oLanguage": {
    //     // //     "sSearch": "Pencarian : ",
	// 	// // 	"sLoadingRecords": "Silahkan tunggu Sebentar...",
    //     // //     "sInfoEmpty": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
    //     //     "sEmptyTable": " ",
    //     //     "zeroRecords": " "
    //     // //     "sInfo": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
    //     // //     "sLengthMenu": "_MENU_ Isi yang ditampil perhalaman",
    //     // //     "oPaginate": {
    //     // //         "sPrevious": "Sebelumnya",
    //     // //         "sNext": "Selanjutnya"
    //     // //     }
    //     // },
    // } );
    // job_planning.fnClearTable();
    // job_planning.fnDestroy();
// $(document).ready( function () {
//     $("#sample_1 tbody tr").each(function() {
//      var html = $(this).find("td:first-child").html();
//         if (html === 'No data available in table') {
//             $(this).remove()
//         }
//     });
// });
        function AddRow(shipment) {
            const toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 6000
                });

            if (! shipment) {
                Swal({
                    type: 'error',
                    title: 'Peringatan System',
                    // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                    text: 'Maaf, inputannya masih kosong. coba pilih shipmentnya!',
                    footer: '<===[ 3 Permata System ]===>'
                })
            } else {
              
            const tBody = $("#sample_1 > TBODY")[0];
            row = tBody.insertRow(-1);
                let arrShipmentJ = new Array();
                let x = document.getElementById("vendor_shipment");
                let getValShipment = document.getElementById('data_all_shipment');

                let txt;
                let i;
         
                for (i = 0; i < x.length; i++) {
                    txt = x.options[i].text;
                }
                for (i = 0; i < getValShipment.options.length; i++) {

                    arrShipmentJ[i] = getValShipment.options[i].value;

                }

                let dtashipments = [];

                for (i = 0; i < arrShipmentJ.length; i++) {

                    dtashipments.push(arrShipmentJ[i]);

                }

            $.get('/load_job_shipment/find/'+ shipment, function(data){

                    // if (txt != data.id) {
                        $('#vendor_shipment').append($('<option>' ,{
                            value:data[0]['order_id'],
                            text:data[0]['order_id']
                        }));

                            $('#val_shipj').append($('<option>' ,{
                                value:data[0]['order_id'],
                                text:data[0]['order_id']
                            }));

                        let ddlArray= new Array();
                        let ddl = document.getElementById('vendor_shipment');

                            for (i = 0; i < ddl.options.length; i++) {

                                ddlArray[i] = ddl.options[i].value;

                            }
                                let datazx = [];

                                for (i = 0; i < ddlArray.length; i++) {

                                    datazx.push(ddlArray[i]);
                                
                                }     
                            $('#shipment__j').select2({
                                placeholder: 'Cari...',
                                ajax: {
                                    url: '/load_uuid_job_shipment_selected/find'+datazx,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                return {
                                                    text: item.id +' - '+item.order_id,
                                                    id: item.id
                                                }
                                                
                                            })
                                        };

                                    },
                                        cache: true
                                }

                            });

                        let job_id = document.getElementById('index_job_id').value
                        let get_now = document.getElementById('get_vals').value
                        let reqshipment = data[0]['order_id'];
                        let reqshipmentidx = data[0]['id'];
                        let total = 0;
                        let totalx = 0;
                        let totalf = 0;
                        let request = $.ajax({
                                url: "{{ url('/req-add-shipment-id-saved')}}",
                                method: "GET",
                                dataType: "json",
                                data: { 
                                    reqshipment:reqshipment,
                                    reqshipmentidx:reqshipmentidx,
                                    job_id:job_id,
                                    get_now:get_now
                                },
                                success: function (dataifsuccess) {
                                    // Swal({
                                    //     title: 'Processing',
                                    //     text: "Please confirm... ",
                                    //     type: 'info',
                                    //     confirmButtonColor: '#3085d6',
                                    //     confirmButtonText: 'Okay!',
                                    // }).then((result) => {
                                    //     if (result.value) {
                                            $('#shipper_index').append($('<option>' ,{
                                                value:dataifsuccess.uuid,
                                                text:dataifsuccess.uuid
                                            }));

                                            $('#order_idx_fetch').append($('<option>' ,{
                                                value:data[0]['order_id'],
                                                text:data[0]['order_id']
                                            }));

                                            $('#get_uid').append($('<option>' ,{
                                                value:dataifsuccess.uuid,
                                                text:dataifsuccess.uuid
                                            }));
                                            // do {
                                            // i += 0;
                                            let cellorderby = $(row.insertCell(0));
                                            let celluuid = $(row.insertCell(1));
                                            let cell = $(row.insertCell(2));
                                            let cell2 = $(row.insertCell(3));
                                            let cell3 = $(row.insertCell(4));
                                            let cell4 = $(row.insertCell(5));
                                            let cell5 = $(row.insertCell(6));
                                            let cell6 = $(row.insertCell(7));
                                            let cell7 = $(row.insertCell(8));
                                            let cell8 = $(row.insertCell(9));
                                            let cell9 = $(row.insertCell(10));
                                            celluuid.attr("id","id_order");
                                            celluuid.attr("class","hidden");
                                            celluuid.html(dataifsuccess.uuid);
                                            cellorderby.attr("id","get_incre");
                                            // cellorderby.html(i);shippersort
                                            cellorderby.html(dataifsuccess.shippersort);
                                            $("#get_vals").val(i);
                                            // $("#get_uid").val(dataifsuccess.uuid);
                                            cell.attr("id","shipment_id");
                                            cell.html(data[0]['order_id']);
                                            cell2.html(data[0]['customers']['name']);
                                            cell3.html(data[0]['collie']);
                                            cell4.html(data[0]['actual_weight']);
                                            cell5.html(data[0]['chargeable_weight']);
                                            cell6.html(data[0]['origin_details']);
                                            cell7.html(data[0]['destination_details']);
                                            cell8.html(data[0]['created_at']);
                                            cell9.html('<span class="badge" style="background-color:REBECCAPURPLE">'+data[0]['cek_status_transaction']['status_name']+'</span>');
                                            $("#added_job_cost").prop("disabled", false);
                                            // $("#added_job_cost").prop("disabled", false);
                                            $("#show_original_table_sample_1").prop("disabled", false);
                                            cell = $(row.insertCell(-1));
                                            let btnRemove = $("<input />");
                                                btnRemove.attr("type", "button");
                                                btnRemove.attr("class", "btn btn-danger");
                                                btnRemove.attr("onclick", "RemoveShipments(this);");
                                                btnRemove.val("-");
                                                cell.append(btnRemove);
                                            // defined number;
 
                                            // FIXED: progress parsing to front end
                                            //manipulation DOM
                                            $('#spanty').each(function(){
                                                                    total += parseFloat(this.innerHTML)
                                                                });
                                            $('#spanty').text(total+data[0]['collie']);

                                            $('#spantyx').each(function(){
                                                                    totalx += parseFloat(this.innerHTML)
                                                                });
                                            $('#spantyx').text(totalx+data[0]['chargeable_weight']);


                                            $('#spantyf').each(function(){
                                                                    totalf += parseFloat(this.innerHTML)
                                                                });
                                            $('#spantyf').text(totalf+data[0]['actual_weight']);

                                            // end

                                            const first_collie = total+data[0]['collie'];
                                            const first_volume = totalx+data[0]['chargeable_weight'];
                                            const first_aw = totalf+data[0]['actual_weight'];
                                            const first_id_job = dataifsuccess.job_id;
                                            // TODO: progress parsing to backend
                                            async function updatedNow(){
                                                try {
                                                    let response = await fetch(`http://devyour-api.co.id/count-result-job-shipments/job-order/${first_id_job}/${first_collie}/${first_volume}/${first_aw}`, {mode: 'cors'});
                                                        let responseJsonData = await response.json();
                                                            await new Promise((resolve, reject) => {
                                                                setTimeout(() => {
                                                                    resolve("connected");
                                                            }, 3000);
                                                        })
                                                    } 
                                                        catch (e) {
                                                        
                                                           toast({

                                                                title: `<div><i class="fa fa-circle text-danger"></i></div>&nbsp;Terjadi Kesalahan!`

                                                            })  
                                                    }
                                                }
                                                return new Promise((resolve, reject) => {
                                                    setTimeout(() => {
                                                        resolve(updatedNow())
                                                        toast({

                                                            title: `<div><i class="fa fa-circle text-success"></i></div>&nbsp;Berhasil menambahkan shipment: ${dataifsuccess.shipment_id}`

                                                        })  
                                                    }, 500)
                                                })
                                                // ;(async () => {
                                                //     try {
                                                //         await create()
                                                //         await wait()
                                                //         await read()
                                                //     } catch (err) {
                                                //         console.error(err)
                                                //     }
                                                //     })()
                                                // cell = $(row.insertCell(-1));lock in street on sizeOf(array, item)
                                                //up vals
                                            // let orderby = $("<input />"); 
                                            //     orderby.attr("id", dataifsuccess.uuid);
                                            //     orderby.attr("type", "button");
                                            //     orderby.attr("value", "move up");
                                            //     orderby.attr("class", "move up btn-primary .product");
                                            //     orderby.attr("onclick", "up(this.id);");
                                            //     orderby.val("⇑");
                                            //     //down vals
                                            // let orderby1 = $("<input />");
                                            //     orderby1.attr("id", dataifsuccess.uuid);
                                            //     orderby1.attr("type", "button");
                                            //     orderby1.attr("value", "move down");
                                            //     orderby1.attr("class", "move down btn-primary");
                                            //     orderby1.attr("onclick", "down(this.id);");
                                            //     orderby1.val("⇓");
                                            //     cell.append(orderby);
                                            //     cell.append(orderby1);
                                                let tbl = document.getElementById("sample_1");
                                            // } while (i < dataifsuccess.length); 
                                        // }
                                    // })
                                },
                                    error: function(data){
                                        Swal({
                                            type: 'error',
                                            title: 'Terjadi kesalahan sistem..',
                                            // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                            text: 'Try again, please check correct data!',
                                            footer: '<a href>Why do I have this issue?</a>'
                                        })
                                    }
                                }
                            );

                        // cell2.html(data[0]['order_id']);
                        // console.log(data.order_id);
                      
                        
                        // } else {
                            // alert("kode yang sama.");
                            // document.getElementById("sample_1").deleteRow(-1);
                    // }
                    });
                        // alert("okay")
                
                    }   

                };


                // $('.cost_categorys').on('change', function(e){
                //     let category_cost = e.target.value;
                //     // let vals_vendor = document.getElementById("vendor_j").value;
                //     let vals_vitem_idx = document.getElementById("vitem_idx").value;
                //     let selectElem = document.getElementById('category_cost_id');
                //     let selectElemVehicle = document.getElementById('vehicle_list_id').value;
                //     // When a new <option> is selected
                //     // if(!vals_vendor){
                //     //     const toast = Swal.mixin({
                //     //             toast: true,
                //     //             position: 'top',
                //     //             showConfirmButton: false,
                //     //             timer: 3000
                //     //             }
                //     //         );
                            
                //     //     toast({
                //     //         title: 'Vendor belum dipilih, silahkan pilih terlebih dahulu.'
                //     // })
                //     //     $('#category_cost_id').empty();
                //         // } else {
                //             let index = selectElem.value;
                //             let vehicle_index = selectElemVehicle.value;
                //             let vals_vendor = document.getElementById("vendor_j").value;
                            
                //                 if (index == 6) {

                //                     document.getElementById('tampil_choosen_vehicle').style.display='inline'
                                    $('.vehicle_list').on('change', function(e){
                                        let selectElemVehiclesadasd = e.target.value;
                                        // console.log(selectElemVehiclesadasd)
                                        $("#vehicle_list_id").prop("disabled", false);

                                        if (selectElemVehiclesadasd == 2) {
                                            document.getElementById('tampil_NW').style.display='inline'
                                            document.getElementById('tampil_v_item_transport').style.display='inline'
                                            document.getElementById('tampil_NI').style.display='none'
                                            $('#pltnmbr').val('');
                                    //         $('#vendor_item_transport_idx').select2({
                                    //         placeholder: 'Cari...',
                                    //         ajax: {
                                    //             url: '/loaded-vendor-item-transports/find/'+vals_vendor,
                                    //             dataType: 'json',
                                    //             delay: 250,
                                    //             processResults: function (data) {
                                    //                 return {
                                    //                     results: $.map(data, function (item) {
                                    //                         return {
                                    //                             text: item.itemovdesc,
                                    //                             id: item.id
                                    //                         }
                                    //                     })
                                    //                 };
                                    //             },
                                    //                 cache: true
                                    //         }

                                    //     }

                                    // );
                                        } else {
                                            document.getElementById('tampil_NW').style.display='none'
                                            $('#cost_').val('');
                                            $('#noted').val('');

                                        }

                                        if (selectElemVehiclesadasd == 1) {
                                            document.getElementById('tampil_NI').style.display='inline'
                                            $('#vendor_item_transport_idx').empty();
                                            $('#vendor_j').empty();
                                           
                                        } else {
                                            document.getElementById('tampil_NI').style.display='none'

                                        }


                                    });
                                    // $("#category_cost_id").prop("disabled", true);
                                    // document.getElementById('tampil_NW').style.display='inline'
                                
                                       
                                // }
                                //     else {
                                        
                        //                 $('#cost_').val('');
                        //                 $('#noted').val('');
                        //                 $("#vehicle_list_id").prop("disabled", false);
                        //                 $("#vendor_j").prop("disabled", false);
                        //                 $("#vehicle_list_id").empty();

                        //                 $('#vendor_item_transport_idx').empty();
                        //                 $('#vendor_j').empty();
                        //                 $('#vendor_item_transport_idx').empty();
                        //                 document.getElementById('tampil_choosen_vehicle').style.display='none'
                        //                 document.getElementById('tampil_v_item_transport').style.display='none'
                        //                 document.getElementById('tampil_NI').style.display='none'
                        //                 document.getElementById('tampil_NW').style.display='none'
                        // }

                    // }
                
            //     }

            // );

            // $('#vendor_item_transport_idx').on('change', function(e){
            //     let vend_values = document.getElementById("vendor_j").value;
            //             $.get('/loaded-vendor-item-transports/find/'+ vend_values, function(data){
            //                     $.each(data, function(index, Obj){
            //                         $('#cost_').val(''+Obj.price);
            //                     }   
            //                 );
            //             }
            //         );
            //     }
            // );
    //     function up(ifup){
    //         console.log(ifup)

    //         let shipperarray = new Array();
    //         let shipperINDEX = document.getElementById('shipper_index');

    //         for (i = 0; i < shipperINDEX.options.length; i++) {

    //             shipperarray[i] = shipperINDEX.options[i].value;

    //         }

    //         let readdirdatashipper = [];

    //         for (i = 0; i < shipperarray.length; i++) {

    //             readdirdatashipper.push(shipperarray[i]);

    //         }

    //     //     let request = $.ajax({
    //     //     url: '/move-shipment/find/'+ifup,
    //     //     method: "GET",
    //     //     dataType: "json",
    //     //     data: { 
    //     //         isadoo:ifup,
    //     //         readdirdatashipper:readdirdatashipper,
    //     //     },
    //     //     success: function (data) {
    //     //         Swal({
    //     //                                 title: 'Successfully',
    //     //                                 text: "You have done save Order Shipments!",
    //     //                                 type: 'success',
    //     //                                 confirmButtonColor: '#3085d6',
    //     //                                 confirmButtonText: 'Okay!',
    //     //                             }).then((result) => {
    //     //                                 if (result.value) {
    //     //                                     // console.log(te)
    //                                 $('#sample_1 input.move').click(function() {
    //                                     var row = $(this).closest('tr');
    //                                     if ($(this).hasClass('up')){
    //                                         row.next().after(row);
    //                                         // row.prev().before(row);

    //                                     for(var x = 0, xLength = row. length; x < xLength; x++) {
    //                                     alert('rowIndex=' + row[x]. rowIndex);
    //                                     }

    //                                     var product_id = $(this).next().val();
    // alert('The product id is: ' + product_id);
    //                                             //                                         var table = document.getElementById("TableID");
                                                
    //                                             // for (var i = 0, row; row = table.rows[i]; i++) {   
    //                                             // 	for (var j = 0, col; col = row.cells[j]; j++) {     
    //                                             // 	}  
    //                                             // }
    //                                     }
                                       

    //                                     else {
    //                                         row.prev().before(row);
                                            
    //                                     }
    //                                         // row.next().after(row);
    //                                 });
    //     //                      }
    //     //         })
    //     //     },
    //     //         error: function(data){
    //     //             Swal({
    //     //                 type: 'error',
    //     //                 title: 'Terjadi kesalahan sistem..',
    //     //                 // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
    //     //                 text: 'Try again, please check correct data!',
    //     //                 footer: '<a href>Why do I have this issue?</a>'
    //     //             })
    //     //         }
    //     // });
          

    //     };


//     $(function() {
//     $( "#sortable1, #sortable2" ).sortable({
//       connectWith: ".connectedSortable"
//     }).disableSelection();
//   });
//   $("#sample_1").sortable({
//     items: "> tr:not(:first)",
//     appendTo: "parent",
//     helper: "clone",
//     stop: function(ui, event){debugger
//         var id = event.item.index();
//         alert(id);
//     }
// }).disableSelection();

    $(function () {
        $("#show_original_table_sample_1").click(function (e) {
        e.preventDefault();
        // $('#shipmentslist tr').not(function(){ 
        //         return !!$(this).has('th').length; 
        //     }).remove();
        let dsdaksj = new Array();
        let get_now = document.getElementById('get_uid')
        // url: "{{ url('/req-add-shipment-id-saved')}}",
        for (i = 0; i < get_now.options.length; i++) {

            dsdaksj[i] = get_now.options[i].value;

            }

            let datavvI = [];

            for (i = 0; i < dsdaksj.length; i++) {

            datavvI.push(dsdaksj[i]);

            }

            $('#shipmentslist tbody tr > td').remove();
            let html = '';
            $.get('/datarealshipments/json/'+datavvI, function(asdaczxc){
                $.each(asdaczxc, function (x, asdzxczxf) { 
                    $.get('/load-shipment-find/encode/'+asdzxczxf.shipment_id, function(asdxcxzda){
                        $.each(asdxcxzda, function (x, dasdasd) { 
                        
                        let listdatastransaction = [
                                {
                                    Shipping: asdzxczxf.shipping_to,
                                    Shipment: dasdasd.order_id,
                                    Customers: dasdasd.customers.name,
                                    Collie: dasdasd.collie,
                                    AWeight: dasdasd.actual_weight,
                                    Volume: dasdasd.chargeable_weight,
                                    Origin_details: dasdasd.origin_details,
                                    Destination_details: dasdasd.destination_details,
                                    Created: dasdasd.created_at,
                                    Cekstats: dasdasd.cek_status_transaction.status_name
                                }
                            ];

                            $.each(listdatastransaction, function(){
                                $('#shipmentslist tbody').append("<tr><td>" +this.Shipping +"</td><td>" + this.Shipment + "</td><td>"
                                    + this.Customers + "</td><td>" + this.Collie + "</td><td>" + this.AWeight + "</td><td>"
                                    + this.Volume + "</td><td>" + this.Origin_details + "</td><td>" + this.Destination_details + "</td><td>" + this.Created + "</td><td>" + this.Cekstats + "</td></tr>");
                            });
                        });
                    });
                });
            });

        });
    });

$(document).ready( function () {
  $('#shipmentslist').dataTable( {
    "bFilter": false,
    "bPaginate": false,
    "sSearch": false,
    "bInfo" : false
  } );
} );

    $(function() {

        $( "#tbods" ).sortable({
            tolerance: "pointer",
            appendTo: "parent",
            helper: "clone",
            start: function(event, ui){

                let uuid_shipment_starting = $( "#tbods tr td:eq( 1 )" ).html();

                let indexing_starting = ui.item.index();

                    let request = $.ajax({
                        url: '/move-shipment/find/'+uuid_shipment_starting,
                        method: "GET",
                        dataType: "json",
                        data: { 
                            indexing_starting:indexing_starting,
                            uuid_shipment_starting:uuid_shipment_starting,
                        },

                        success: function (data) {

                        let asdacxzcf = ui.item.index();

                            if(asdacxzcf == 0) { //index 1

                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);
                       
                            }

                            if(asdacxzcf== 1){ //index 2

                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 2){ //index 3

                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            
                            if(asdacxzcf == 3){ //index 4

                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 4){ //index 5

                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 5){ //index 6

                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 6){ //index 7

                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 7){ //index 8

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 8){ //index 9

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 9){ //index 10

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 10){ //index 11

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 11){ //index 12

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);
                            }

                            if(asdacxzcf == 12){ //index 13

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 13){ //index 14

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 14){ //index 15

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 15){ //index 16

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 16){ //index 17

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 17){ //index 18

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 18){ //index 19

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 19){ //index 20

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }

                            if(asdacxzcf == 20){ //index 21

                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                            }


                        },

                        error: function(data){
                            Swal({
                                type: 'error',
                                title: 'Terjadi kesalahan sistem..',
                                text: 'Try again, please check correct data!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    });
               
            },
            stop: function(ui, eventasdasd){
                        
                let uid_stop = $( "#tbods tr td:eq( 1 )" ).html();
                // let uid_stop = $('tr').find('td').eq(1).html();

                let indexing_stopping = eventasdasd.item.index();
                        
                    let request = $.ajax({
                        url: '/move-shipment-stop/find/'+uid_stop,
                        method: "GET",
                        dataType: "json",
                        data: { 
                            indexing_stopping:indexing_stopping,
                            uid_stop:uid_stop,
                        },
                        success: function (data) {

                        let asdacxz = eventasdasd.item.index();

                            if(asdacxz == 0) { //index 1
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21,

                                };
                                        $.ajax({
                                            url: '/update-movements/find',
                                            type    : "GET",
                                            cache   : true,
                                            dataType: "json",
                                            data    : {
                                                arrys:arrys
                                                    },                
                                            success: function(data) {
                                          
                                            const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_1 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index1
                                            })

                                        }
                                    });
                            }

                            if(asdacxz == 1){ //index 2
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21
                                };

                                    $.ajax({
                                        url: '/update-movements/find',
                                        type    : "GET",
                                        cache   : true,
                                        dataType: "json",
                                        data    : {
                                            arrys:arrys
                                                },                
                                        success: function(data) {

                                            const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_2 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index2
                                            })

                                        }
                                    });
                            }

                            if(asdacxz == 2){ //index 3
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };
                                    $.ajax({
                                        url: '/update-movements/find',
                                        type    : "GET",
                                        cache   : true,
                                        dataType: "json",
                                        data    : {
                                            arrys:arrys
                                                },                
                                        success: function(data) {

                                            const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_3 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index3
                                            })

                                        }
                                    });
                            }

                            if(asdacxz == 3){ //index 4
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };  
                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_4 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index4
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 4){ //index 5
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };
                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                        });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_5 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index5
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 5){ //index 6
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21,

                                };
                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_6 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index6
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 6){ //index 7
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };
                                
                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_7 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index7
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 7){ //index 8
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_8 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index8
                                        })

                                    }
                                });

                            }

                            if(asdacxz == 8){ //index 9
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_9 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index9
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 9){ //index 10
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_10 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index10
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 10){ //index 11
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_11 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index11
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 11){ //index 12
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_12 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index12
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 12){ //index 13
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_13 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index13
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 13){ //index 14
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_14 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index14
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 14){ //index 15
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_15 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index15
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 15){ //index 16
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_16 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index16
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 16){ //index 17
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_17 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index17
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 17){ //index 18
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_18 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index18
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 18){ //index 19
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_19 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index19
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 19){ //index 20
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_20 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index20
                                        })

                                    }
                                });
                            }

                            if(asdacxz == 20){ //index 21
                                $('tr').eq(1).find('td').eq(0).text(1);
                                $('tr').eq(2).find('td').eq(0).text(2);
                                $('tr').eq(3).find('td').eq(0).text(3);
                                $('tr').eq(4).find('td').eq(0).text(4);
                                $('tr').eq(5).find('td').eq(0).text(5);
                                $('tr').eq(6).find('td').eq(0).text(6);
                                $('tr').eq(7).find('td').eq(0).text(7);
                                $('tr').eq(8).find('td').eq(0).text(8);
                                $('tr').eq(9).find('td').eq(0).text(9);
                                $('tr').eq(10).find('td').eq(0).text(10);
                                $('tr').eq(11).find('td').eq(0).text(11);
                                $('tr').eq(12).find('td').eq(0).text(12);
                                $('tr').eq(13).find('td').eq(0).text(13);
                                $('tr').eq(14).find('td').eq(0).text(14);
                                $('tr').eq(15).find('td').eq(0).text(15);
                                $('tr').eq(16).find('td').eq(0).text(16);
                                $('tr').eq(17).find('td').eq(0).text(17);
                                $('tr').eq(18).find('td').eq(0).text(18);
                                $('tr').eq(19).find('td').eq(0).text(19);
                                $('tr').eq(20).find('td').eq(0).text(20);
                                $('tr').eq(21).find('td').eq(0).text(21);

                                let asdaxdcfdfs = $( "#tbods tr td:eq( 1 )" ).html();
                               
                                let index1 = $('tr').eq(1).find('td').eq(0).html();
                                let index2 = $('tr').eq(2).find('td').eq(0).html();
                                let index3 = $('tr').eq(3).find('td').eq(0).html();
                                let index4 = $('tr').eq(4).find('td').eq(0).html();
                                let index5 = $('tr').eq(5).find('td').eq(0).html();
                                let index6 = $('tr').eq(6).find('td').eq(0).html();
                                let index7 = $('tr').eq(7).find('td').eq(0).html();
                                let index8 = $('tr').eq(8).find('td').eq(0).html();
                                let index9 = $('tr').eq(9).find('td').eq(0).html();
                                let index10 = $('tr').eq(10).find('td').eq(0).html();
                                let index11 = $('tr').eq(11).find('td').eq(0).html();
                                let index12 = $('tr').eq(12).find('td').eq(0).html();
                                let index13 = $('tr').eq(13).find('td').eq(0).html();
                                let index14 = $('tr').eq(14).find('td').eq(0).html();
                                let index15 = $('tr').eq(15).find('td').eq(0).html();
                                let index16 = $('tr').eq(16).find('td').eq(0).html();
                                let index17 = $('tr').eq(17).find('td').eq(0).html();
                                let index18 = $('tr').eq(18).find('td').eq(0).html();
                                let index19 = $('tr').eq(19).find('td').eq(0).html();
                                let index20 = $('tr').eq(20).find('td').eq(0).html();
                                let index21 = $('tr').eq(21).find('td').eq(0).html();

                                let uid_index0 = $('tr').eq(1).find('td').eq(1).html();
                                let uid_index1 = $('tr').eq(2).find('td').eq(1).html();
                                let uid_index2 = $('tr').eq(3).find('td').eq(1).html();
                                let uid_index3 = $('tr').eq(4).find('td').eq(1).html();
                                let uid_index4 = $('tr').eq(5).find('td').eq(1).html();
                                let uid_index5 = $('tr').eq(6).find('td').eq(1).html();
                                let uid_index6 = $('tr').eq(7).find('td').eq(1).html();
                                let uid_index7 = $('tr').eq(8).find('td').eq(1).html();
                                let uid_index8 = $('tr').eq(9).find('td').eq(1).html();
                                let uid_index9 = $('tr').eq(10).find('td').eq(1).html();
                                let uid_index10 = $('tr').eq(11).find('td').eq(1).html();
                                let uid_index11 = $('tr').eq(12).find('td').eq(1).html();
                                let uid_index12 = $('tr').eq(13).find('td').eq(1).html();
                                let uid_index13 = $('tr').eq(14).find('td').eq(1).html();
                                let uid_index14 = $('tr').eq(15).find('td').eq(1).html();
                                let uid_index15 = $('tr').eq(16).find('td').eq(1).html();
                                let uid_index16 = $('tr').eq(17).find('td').eq(1).html();
                                let uid_index17 = $('tr').eq(18).find('td').eq(1).html();
                                let uid_index18 = $('tr').eq(19).find('td').eq(1).html();
                                let uid_index19 = $('tr').eq(20).find('td').eq(1).html();
                                let uid_index20 = $('tr').eq(21).find('td').eq(1).html();

                                //passing id shipments
                                let row_shipment1 = $('tr').eq(1).find('td').eq(2).html();
                                let row_shipment2 = $('tr').eq(2).find('td').eq(2).html();
                                let row_shipment3 = $('tr').eq(3).find('td').eq(2).html();
                                let row_shipment4 = $('tr').eq(4).find('td').eq(2).html();
                                let row_shipment5 = $('tr').eq(5).find('td').eq(2).html();
                                let row_shipment6 = $('tr').eq(6).find('td').eq(2).html();
                                let row_shipment7 = $('tr').eq(7).find('td').eq(2).html();
                                let row_shipment8 = $('tr').eq(8).find('td').eq(2).html();
                                let row_shipment9 = $('tr').eq(9).find('td').eq(2).html();
                                let row_shipment10 = $('tr').eq(10).find('td').eq(2).html();
                                let row_shipment11 = $('tr').eq(11).find('td').eq(2).html();
                                let row_shipment12 = $('tr').eq(12).find('td').eq(2).html();
                                let row_shipment13 = $('tr').eq(13).find('td').eq(2).html();
                                let row_shipment14 = $('tr').eq(14).find('td').eq(2).html();
                                let row_shipment15 = $('tr').eq(15).find('td').eq(2).html();
                                let row_shipment16 = $('tr').eq(16).find('td').eq(2).html();
                                let row_shipment17 = $('tr').eq(17).find('td').eq(2).html();
                                let row_shipment18 = $('tr').eq(18).find('td').eq(2).html();
                                let row_shipment19 = $('tr').eq(19).find('td').eq(2).html();
                                let row_shipment20 = $('tr').eq(20).find('td').eq(2).html();
                                let row_shipment21 = $('tr').eq(21).find('td').eq(2).html();

                                let arrys = {
                                    'shipment_index1': uid_index0,
                                    'shipment_index2': uid_index1, 
                                    'shipment_index3': uid_index2,
                                    'shipment_index4': uid_index3,
                                    'shipment_index5': uid_index4,
                                    'shipment_index6': uid_index5,
                                    'shipment_index7': uid_index6,
                                    'shipment_index8': uid_index7,
                                    'shipment_index9': uid_index8,
                                    'shipment_index10': uid_index9,
                                    'shipment_index11': uid_index10,
                                    'shipment_index12': uid_index11,
                                    'shipment_index13': uid_index12,
                                    'shipment_index14': uid_index13,
                                    'shipment_index15': uid_index14,
                                    'shipment_index16': uid_index15,
                                    'shipment_index17': uid_index16,
                                    'shipment_index18': uid_index17,
                                    'shipment_index19': uid_index18,
                                    'shipment_index20': uid_index19,
                                    'shipment_index21': uid_index20,
                                    'shorter_index1': index1,
                                    'shorter_index2': index2,
                                    'shorter_index3': index3,
                                    'shorter_index4': index4,
                                    'shorter_index5': index5,
                                    'shorter_index6': index6,
                                    'shorter_index7': index7,
                                    'shorter_index8': index8,
                                    'shorter_index9': index9,
                                    'shorter_index10': index10,
                                    'shorter_index11': index11,
                                    'shorter_index12': index12,
                                    'shorter_index13': index13,
                                    'shorter_index14': index14,
                                    'shorter_index15': index15,
                                    'shorter_index16': index16,
                                    'shorter_index17': index17,
                                    'shorter_index18': index18,
                                    'shorter_index19': index19,
                                    'shorter_index20': index20,
                                    'shorter_index21': index21,
                                    'record_shipment_1': row_shipment1,
                                    'record_shipment_2': row_shipment2,
                                    'record_shipment_3': row_shipment3,
                                    'record_shipment_4': row_shipment4,
                                    'record_shipment_5': row_shipment5,
                                    'record_shipment_6': row_shipment6,
                                    'record_shipment_7': row_shipment7,
                                    'record_shipment_8': row_shipment8,
                                    'record_shipment_9': row_shipment9,
                                    'record_shipment_10': row_shipment10,
                                    'record_shipment_11': row_shipment11,
                                    'record_shipment_12': row_shipment12,
                                    'record_shipment_13': row_shipment13,
                                    'record_shipment_14': row_shipment14,
                                    'record_shipment_15': row_shipment15,
                                    'record_shipment_16': row_shipment16,
                                    'record_shipment_17': row_shipment17,
                                    'record_shipment_18': row_shipment18,
                                    'record_shipment_19': row_shipment19,
                                    'record_shipment_20': row_shipment20,
                                    'record_shipment_21': row_shipment21

                                };

                                $.ajax({
                                    url: '/update-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        const toast = Swal.mixin({
                                                toast: true,
                                                position: 'top',
                                                showConfirmButton: false,
                                                timer: 6500
                                            });

                                            toast({
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_21 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index21
                                        })
                                        
                                    }
                                });
                            }

                        },

                        error: function(data){
                            Swal({
                                type: 'error',
                                title: 'Terjadi kesalahan sistem..',
                                text: 'Try again, please check correct data!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    });
                   
                }
            });

    $( "#tbods" ).disableSelection();

  });

  function arrayUnique(array) {
    var a = array.concat();
    for(var i=0; i<a.length; ++i) {
        for(var j=i+1; j<a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }

    return a;
}

        $('#vendor_item_transport_idx').on('change', function(e){
            let thisval = e.target.value;
                    $.get('/loaded-vendor-item-transports-with-vitem/find/'+ thisval, function(data){
                            $.each(data, function(index, Obj){
                                $('#cost_').val(''+Obj.price);
                                $('#noted').val(''+Obj.itemovdesc);
                            }   
                        );
                    }
                );
            }
        );

        $('#vendor_j').on('change', function(e){
            let idnyavendor = e.target.value;
            document.getElementById('tampil_v_item_transport').style.display='inline'
                $("#vendor_j").prop("disabled", false);
                $('#cost_').val('');
                $('#noted').val('');
                // console.log(idnyavendor)
                // $('#vendor_item_transport_idx').empty();
                // document.getElementById('tampil_NW').style.display='none';
                $('#vendor_item_transport_idx').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/loaded-vendor-item-transports/find/'+idnyavendor,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.itemovdesc,
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

        $('#vendor_item_transport_idx').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/loaded-vendor-item-transports/find/'+null,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.itemovdesc,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                                cache: true
                        }
                    }
                );

        $( document ).ready(function() {
            $("#added_job_shipment").prop("disabled", true); //testing add jobs
            $("#added_job_cost").prop("disabled", true); 
            $("#added_job_of_cost").prop("disabled", true);
            $("#show_original_table_sample_1").prop("disabled", true);

        });

        // start function
    function RemoveShipments(button) {
        const toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 6000
            });
            let row = $(button).closest("TR");
            let inc = $("TD", row).eq(0).html();
            let uuid = $("TD", row).eq(1).html();
            let order_id = $("TD", row).eq(2).html();
            let colli = $("TD", row).eq(4).html();
            let aweight = $("TD", row).eq(5).html();
            let volume = $("TD", row).eq(6).html();
            let index = $(button).closest('tr').index();

            if (confirm("Apakah anda ingin menghapus shipment: " + order_id)) {
            
            Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted.!",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    let total = 0;
                    let totalx = 0;
                    let totalf = 0;
                    /** 
                     * TODO: modify DOM
                     **/
                    $('#spanty').each(function(){
                        total = parseFloat(this.innerHTML);
                    });

                    $('#spanty').text(total-colli);

                    $('#spantyx').each(function(){
                        totalx = parseFloat(this.innerHTML);
                    });

                    $('#spantyx').text(totalx-volume);

                    $('#spantyf').each(function(){
                        totalf = parseFloat(this.innerHTML);
                    });

                    $('#spantyf').text(totalf-aweight);
                    
                    const last_collie = total-colli; 
                    const last_volumes = totalx-volume; 
                    const last_aw = totalf-aweight;
                    const last_id_job = $("#index_job_id").val();

                const table = $("#sample_1")[0];
                table.deleteRow(row[0].rowIndex);

                $("#order_idx_fetch option[value='" + order_id + "']").remove();
                $("#vendor_shipment option[value='" + order_id + "']").remove();
                $("#val_shipj option[value='" + order_id + "']").remove();
                let iArrays = new Array();
                let order_id_dumps = document.getElementById('order_idx_fetch');

                    for (i = 0; i < order_id_dumps.options.length; i++) {

                        iArrays[i] = order_id_dumps.options[i].value;

                    }
                        let fetch_order_id = [];

                        for (i = 0; i < iArrays.length; i++) {

                            fetch_order_id.push(iArrays[i]);
                        
                        }    

                    $('#shipment__j').select2({
                        placeholder: 'Cari...',
                        ajax: {
                                url: '/load_uuid_job_try_load/find'+ fetch_order_id,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.id +' - '+item.order_id,
                                                id: item.id
                                        }
                                        
                                    })
                                };

                            },

                            cache: true
                        }

                    });

                    /** 
                     * FIXME:specify, if an index deletion action is found in the plan, this starts static indexing
                     **/
                    //manipulation DOM
                    if(index == 0){
                        $('tr').eq(1).find('td').eq(0).text(1);
                        $('tr').eq(2).find('td').eq(0).text(2);
                        $('tr').eq(3).find('td').eq(0).text(3);
                        $('tr').eq(4).find('td').eq(0).text(4);
                        $('tr').eq(5).find('td').eq(0).text(5);
                        $('tr').eq(6).find('td').eq(0).text(6);
                        $('tr').eq(7).find('td').eq(0).text(7);
                        $('tr').eq(8).find('td').eq(0).text(8);
                        $('tr').eq(9).find('td').eq(0).text(9);
                        $('tr').eq(10).find('td').eq(0).text(10);
                        $('tr').eq(11).find('td').eq(0).text(11);
                        $('tr').eq(12).find('td').eq(0).text(12);
                        $('tr').eq(13).find('td').eq(0).text(13);
                        $('tr').eq(14).find('td').eq(0).text(14);
                        $('tr').eq(15).find('td').eq(0).text(15);
                        $('tr').eq(16).find('td').eq(0).text(16);
                        $('tr').eq(17).find('td').eq(0).text(17);
                        $('tr').eq(18).find('td').eq(0).text(18);
                        $('tr').eq(19).find('td').eq(0).text(19);
                        $('tr').eq(20).find('td').eq(0).text(20);
                        $('tr').eq(21).find('td').eq(0).text(21);
                    }
                    if(index == 1){
                        $('tr').eq(1).find('td').eq(1).text(1);
                        $('tr').eq(2).find('td').eq(1).text(2);
                        $('tr').eq(3).find('td').eq(1).text(3);
                        $('tr').eq(4).find('td').eq(1).text(4);
                        $('tr').eq(5).find('td').eq(1).text(5);
                        $('tr').eq(6).find('td').eq(1).text(6);
                        $('tr').eq(7).find('td').eq(1).text(7);
                        $('tr').eq(8).find('td').eq(1).text(8);
                        $('tr').eq(9).find('td').eq(1).text(9);
                        $('tr').eq(10).find('td').eq(1).text(10);
                        $('tr').eq(11).find('td').eq(1).text(11);
                        $('tr').eq(12).find('td').eq(1).text(12);
                        $('tr').eq(13).find('td').eq(1).text(13);
                        $('tr').eq(14).find('td').eq(1).text(14);
                        $('tr').eq(15).find('td').eq(1).text(15);
                        $('tr').eq(16).find('td').eq(1).text(16);
                        $('tr').eq(17).find('td').eq(1).text(17);
                        $('tr').eq(18).find('td').eq(1).text(18);
                        $('tr').eq(19).find('td').eq(1).text(19);
                        $('tr').eq(20).find('td').eq(1).text(20);
                        $('tr').eq(21).find('td').eq(1).text(21);
                    }
                    if(index == 2){
                        $('tr').eq(1).find('td').eq(2).text(1);
                        $('tr').eq(2).find('td').eq(2).text(2);
                        $('tr').eq(3).find('td').eq(2).text(3);
                        $('tr').eq(4).find('td').eq(2).text(4);
                        $('tr').eq(5).find('td').eq(2).text(5);
                        $('tr').eq(6).find('td').eq(2).text(6);
                        $('tr').eq(7).find('td').eq(2).text(7);
                        $('tr').eq(8).find('td').eq(2).text(8);
                        $('tr').eq(9).find('td').eq(2).text(9);
                        $('tr').eq(10).find('td').eq(2).text(10);
                        $('tr').eq(11).find('td').eq(2).text(11);
                        $('tr').eq(12).find('td').eq(2).text(12);
                        $('tr').eq(13).find('td').eq(2).text(13);
                        $('tr').eq(14).find('td').eq(2).text(14);
                        $('tr').eq(15).find('td').eq(2).text(15);
                        $('tr').eq(16).find('td').eq(2).text(16);
                        $('tr').eq(17).find('td').eq(2).text(17);
                        $('tr').eq(18).find('td').eq(2).text(18);
                        $('tr').eq(19).find('td').eq(2).text(19);
                        $('tr').eq(20).find('td').eq(2).text(20);
                        $('tr').eq(21).find('td').eq(2).text(21);
                    }
                    if(index == 3){
                        $('tr').eq(1).find('td').eq(3).text(1);
                        $('tr').eq(2).find('td').eq(3).text(2);
                        $('tr').eq(3).find('td').eq(3).text(3);
                        $('tr').eq(4).find('td').eq(3).text(4);
                        $('tr').eq(5).find('td').eq(3).text(5);
                        $('tr').eq(6).find('td').eq(3).text(6);
                        $('tr').eq(7).find('td').eq(3).text(7);
                        $('tr').eq(8).find('td').eq(3).text(8);
                        $('tr').eq(9).find('td').eq(3).text(9);
                        $('tr').eq(10).find('td').eq(3).text(10);
                        $('tr').eq(11).find('td').eq(3).text(11);
                        $('tr').eq(12).find('td').eq(3).text(12);
                        $('tr').eq(13).find('td').eq(3).text(13);
                        $('tr').eq(14).find('td').eq(3).text(14);
                        $('tr').eq(15).find('td').eq(3).text(15);
                        $('tr').eq(16).find('td').eq(3).text(16);
                        $('tr').eq(17).find('td').eq(3).text(17);
                        $('tr').eq(18).find('td').eq(3).text(18);
                        $('tr').eq(19).find('td').eq(3).text(19);
                        $('tr').eq(20).find('td').eq(3).text(20);
                        $('tr').eq(21).find('td').eq(3).text(21);
                    }
                    if(index == 4){
                        $('tr').eq(1).find('td').eq(4).text(1);
                        $('tr').eq(2).find('td').eq(4).text(2);
                        $('tr').eq(3).find('td').eq(4).text(3);
                        $('tr').eq(4).find('td').eq(4).text(4);
                        $('tr').eq(5).find('td').eq(4).text(5);
                        $('tr').eq(6).find('td').eq(3).text(6);
                        $('tr').eq(7).find('td').eq(4).text(7);
                        $('tr').eq(8).find('td').eq(4).text(8);
                        $('tr').eq(9).find('td').eq(4).text(9);
                        $('tr').eq(10).find('td').eq(4).text(10);
                        $('tr').eq(11).find('td').eq(4).text(11);
                        $('tr').eq(12).find('td').eq(4).text(12);
                        $('tr').eq(13).find('td').eq(4).text(13);
                        $('tr').eq(14).find('td').eq(4).text(14);
                        $('tr').eq(15).find('td').eq(4).text(15);
                        $('tr').eq(16).find('td').eq(4).text(16);
                        $('tr').eq(17).find('td').eq(4).text(17);
                        $('tr').eq(18).find('td').eq(4).text(18);
                        $('tr').eq(19).find('td').eq(4).text(19);
                        $('tr').eq(20).find('td').eq(4).text(20);
                        $('tr').eq(21).find('td').eq(4).text(21);
                    }
                    if(index == 5){
                        $('tr').eq(1).find('td').eq(5).text(1);
                        $('tr').eq(2).find('td').eq(5).text(2);
                        $('tr').eq(3).find('td').eq(5).text(3);
                        $('tr').eq(4).find('td').eq(5).text(4);
                        $('tr').eq(5).find('td').eq(5).text(5);
                        $('tr').eq(6).find('td').eq(5).text(6);
                        $('tr').eq(7).find('td').eq(5).text(7);
                        $('tr').eq(8).find('td').eq(5).text(8);
                        $('tr').eq(9).find('td').eq(5).text(9);
                        $('tr').eq(10).find('td').eq(5).text(10);
                        $('tr').eq(11).find('td').eq(5).text(11);
                        $('tr').eq(12).find('td').eq(5).text(12);
                        $('tr').eq(13).find('td').eq(5).text(13);
                        $('tr').eq(14).find('td').eq(5).text(14);
                        $('tr').eq(15).find('td').eq(5).text(15);
                        $('tr').eq(16).find('td').eq(5).text(16);
                        $('tr').eq(17).find('td').eq(5).text(17);
                        $('tr').eq(18).find('td').eq(5).text(18);
                        $('tr').eq(19).find('td').eq(5).text(19);
                        $('tr').eq(20).find('td').eq(5).text(20);
                        $('tr').eq(21).find('td').eq(5).text(21);
                    }
                    if(index == 6){
                        $('tr').eq(1).find('td').eq(6).text(1);
                        $('tr').eq(2).find('td').eq(6).text(2);
                        $('tr').eq(3).find('td').eq(6).text(3);
                        $('tr').eq(4).find('td').eq(6).text(4);
                        $('tr').eq(5).find('td').eq(6).text(5);
                        $('tr').eq(6).find('td').eq(6).text(6);
                        $('tr').eq(7).find('td').eq(6).text(7);
                        $('tr').eq(8).find('td').eq(6).text(8);
                        $('tr').eq(9).find('td').eq(6).text(9);
                        $('tr').eq(10).find('td').eq(6).text(10);
                        $('tr').eq(11).find('td').eq(6).text(11);
                        $('tr').eq(12).find('td').eq(6).text(12);
                        $('tr').eq(13).find('td').eq(6).text(13);
                        $('tr').eq(14).find('td').eq(6).text(14);
                        $('tr').eq(15).find('td').eq(6).text(15);
                        $('tr').eq(16).find('td').eq(6).text(16);
                        $('tr').eq(17).find('td').eq(6).text(17);
                        $('tr').eq(18).find('td').eq(6).text(18);
                        $('tr').eq(19).find('td').eq(6).text(19);
                        $('tr').eq(20).find('td').eq(6).text(20);
                        $('tr').eq(21).find('td').eq(6).text(21);
                    }
                    if(index == 7){
                        $('tr').eq(1).find('td').eq(7).text(1);
                        $('tr').eq(2).find('td').eq(7).text(2);
                        $('tr').eq(3).find('td').eq(7).text(3);
                        $('tr').eq(4).find('td').eq(7).text(4);
                        $('tr').eq(5).find('td').eq(7).text(5);
                        $('tr').eq(6).find('td').eq(7).text(6);
                        $('tr').eq(7).find('td').eq(7).text(7);
                        $('tr').eq(8).find('td').eq(7).text(8);
                        $('tr').eq(9).find('td').eq(7).text(9);
                        $('tr').eq(10).find('td').eq(7).text(10);
                        $('tr').eq(11).find('td').eq(7).text(11);
                        $('tr').eq(12).find('td').eq(7).text(12);
                        $('tr').eq(13).find('td').eq(7).text(13);
                        $('tr').eq(14).find('td').eq(7).text(14);
                        $('tr').eq(15).find('td').eq(7).text(15);
                        $('tr').eq(16).find('td').eq(7).text(16);
                        $('tr').eq(17).find('td').eq(7).text(17);
                        $('tr').eq(18).find('td').eq(7).text(18);
                        $('tr').eq(19).find('td').eq(7).text(19);
                        $('tr').eq(20).find('td').eq(7).text(20);
                        $('tr').eq(21).find('td').eq(7).text(21);
                    }
                    if(index == 8){
                        $('tr').eq(1).find('td').eq(8).text(1);
                        $('tr').eq(2).find('td').eq(8).text(2);
                        $('tr').eq(3).find('td').eq(8).text(3);
                        $('tr').eq(4).find('td').eq(8).text(4);
                        $('tr').eq(5).find('td').eq(8).text(5);
                        $('tr').eq(6).find('td').eq(8).text(6);
                        $('tr').eq(7).find('td').eq(8).text(7);
                        $('tr').eq(8).find('td').eq(8).text(8);
                        $('tr').eq(9).find('td').eq(8).text(9);
                        $('tr').eq(10).find('td').eq(8).text(10);
                        $('tr').eq(11).find('td').eq(8).text(11);
                        $('tr').eq(12).find('td').eq(8).text(12);
                        $('tr').eq(13).find('td').eq(8).text(13);
                        $('tr').eq(14).find('td').eq(8).text(14);
                        $('tr').eq(15).find('td').eq(8).text(15);
                        $('tr').eq(16).find('td').eq(8).text(16);
                        $('tr').eq(17).find('td').eq(8).text(17);
                        $('tr').eq(18).find('td').eq(8).text(18);
                        $('tr').eq(19).find('td').eq(8).text(19);
                        $('tr').eq(20).find('td').eq(8).text(20);
                        $('tr').eq(21).find('td').eq(8).text(21);
                    }
                    if(index == 9){
                        $('tr').eq(1).find('td').eq(9).text(1);
                        $('tr').eq(2).find('td').eq(9).text(2);
                        $('tr').eq(3).find('td').eq(9).text(3);
                        $('tr').eq(4).find('td').eq(9).text(4);
                        $('tr').eq(5).find('td').eq(9).text(5);
                        $('tr').eq(6).find('td').eq(9).text(6);
                        $('tr').eq(7).find('td').eq(9).text(7);
                        $('tr').eq(8).find('td').eq(9).text(8);
                        $('tr').eq(9).find('td').eq(9).text(9);
                        $('tr').eq(10).find('td').eq(9).text(10);
                        $('tr').eq(11).find('td').eq(9).text(11);
                        $('tr').eq(12).find('td').eq(9).text(12);
                        $('tr').eq(13).find('td').eq(9).text(13);
                        $('tr').eq(14).find('td').eq(9).text(14);
                        $('tr').eq(15).find('td').eq(9).text(15);
                        $('tr').eq(16).find('td').eq(9).text(16);
                        $('tr').eq(17).find('td').eq(9).text(17);
                        $('tr').eq(18).find('td').eq(9).text(18);
                        $('tr').eq(19).find('td').eq(9).text(19);
                        $('tr').eq(20).find('td').eq(9).text(20);
                        $('tr').eq(21).find('td').eq(9).text(21);
                    }

                async function ReduceTotals(){
                    try {
                        let response = await fetch(`http://devyour-api.co.id/reduce-result-job-shipments/job-order/${last_id_job}/${last_collie}/${last_volumes}/${last_aw}`, {mode: 'cors'});
                            let responseJsonData = await response.json();
                                await new Promise((resolve, reject) => {
                                    setTimeout(() => {
                                        resolve("connected");
                                }, 3000);
                            })
                        } 
                            catch (e) {
                                swal("Errors","Please try again...","error");
                        }
                    }

                    return new Promise((resolve, reject) => {
                        setTimeout(() => {
                            resolve(ReduceTotals())
                            toast({

                                title: `<div><i class="fa fa-circle text-error"></i></div>&nbsp;Berhasil menghapus shipment: `+order_id

                            })  
                        }, 1500)
                    })
                }
            });
        }
    };  

        // end function
 
        function Remove(button) {
            let row = $(button).closest("TR");
            let inc = $("TD", row).eq(0).html();
            let uuid = $("TD", row).eq(1).html();
            let name = $("TD", row).eq(2).html();
            // if (confirm("Do you want to delete: " + name)) {
            //     const table = $("#sample_1")[0];
            //     table.deleteRow(row[0].rowIndex);
            //     document.getElementsByName("vendor_shipment")[0].remove(0);
            // }
            // /load_uuid_job_shipment_selected/find/ <-- url try load uid shipment
            Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted.!",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    $.ajax({

                            url: "job-shipment-delete/find/"+uuid,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const table = $("#sample_1")[0];
                                table.deleteRow(row[0].rowIndex);

                            }

                    });

                   
                    // document.getElementsByName("vendor_shipment")[0].remove(0);
              
                }

            })

                let asdasd= new Array();
                let dsadzxdl = document.getElementById('vendor_shipment');

                    for (i = 0; i < dsadzxdl.options.length; i++) {

                        asdasd[i] = dsadzxdl.options[i].value;

                    }
                        let saderasdx = [];

                        for (i = 0; i < asdasd.length; i++) {

                            saderasdx.push(asdasd[i]);
                        
                        }    

            $('#shipment__j').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/load_uuid_job_try_load/find/'+ name,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.id +' - '+item.order_id,
                                        id: item.id
                                }
                                
                            })
                        };

                    },

                        cache: true
                }

            });
        };

        $.get('getValueTransport-find', function(data){
            // $.each(data, function(index, Obj){
            let arrfsc = new Array();

            for (i = 0; i < data.length; i++) {

                arrfsc[i] = data[i];

                }

                let rdatatcxz = [];
                let status = [];

                for (i = 0; i < arrfsc.length; i++) {

                    rdatatcxz.push(arrfsc[i]);
                    // status.push(arrfsc[i]['cek_status_transaction']['status_name']);

                }

                let populateList = function(arr){
                    let str = '';
                    
                        for(let iz = 0; iz < arr.length; iz++){

                            str += '<ul><li><font face="Fira Code">' +arr[iz]['order_id'].split(',') +' -> status : '+ arr[iz]['cek_status_transaction']['status_name'] +'</font></ul></li>';

                        }

                    return str;
                
                }

                    $('#shipment__j').select2({
                    placeholder: 'Cari...',
                    "language": {
                    "noResults": function(){

                            return "<font face='Fira Code'>Maaf data gagal diproses, hanya menampilkan shipment yang berstatus New\\Process\\Upload.</font>"

                        }

                    },
                        escapeMarkup: function (markup) {
                            return markup;
                        },

                        ajax: {
                            url: '/loaded-transporter/find',
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {

                                                // if(!item.order_id){
                                                
                                                // }
                                                    return {
                                                        text: item.id +' - '+item.order_id,
                                                        id: item.id
                                                    } 
                                            })
                                        };
                                    },
                                cache: true
                            }
                        });
                });

                    $('.cost_categorys').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/loaded-jobs-forloads-cost-category/find/',
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.id +' - '+item.name,
                                            id: item.id
                                        }
                                        
                                    }
                                    )
                                };
                            },
                            cache: true
                        }
                    }
                );

                $('.cost_categorys_of_cost').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/loaded-jobs-forloads-cost-category-of-cost/find/',
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.id +' - '+item.name,
                                            id: item.id
                                        }
                                        
                                    }
                                    )
                                };
                            },
                            cache: true
                        }
                    }
                );


//   $("#added_job_shipment").click(function(event) {
//         event.preventDefault();
//         if ($('#shipment__j').val()==null) {
//             swal("Inputan tidak boleh kosong!");
//         } else {
//             $.ajax({
//                 type: "post",
//                 url: "{{ url('jobs') }}",
//                 dataType: "json",
//                 data:{
//                     "_token": "{{ csrf_token() }}",
//                     "job_no": $('#shipment__j').val(),
//                 }, 
//                 success: function(data){
//                     let timerInterval
//                     Swal({
//                     title: 'You successfully added jobs!',
//                     allowOutsideClick: false,
//                     // html:
//                     //     'I will close in <strong></strong> seconds.<br/><br/>', 
//                     timer: 3000,
//                         onBeforeOpen: () => {
//                             const content = Swal.getContent()
//                             const $ = content.querySelector.bind(content)

//                             Swal.showLoading()

//                             function toggleButtons () {
//                             stop.disabled = !Swal.isTimerRunning()
//                             resume.disabled = Swal.isTimerRunning()
//                             }

//                             timerInterval = setInterval(() => {
//                             Swal.getContent().querySelector('strong')
//                                 .textContent = (Swal.getTimerLeft() / 1000)
//                                 .toFixed(0)
//                             }, 100)
//                         },
//                             onClose: () => {
//                                 clearInterval(timerInterval)
//                                 location.reload();
//                             }
//                     })
//                 },
//                 error: function(data){
//                     Swal({
//                         type: 'error',
//                         title: 'Oops...',
//                         text: 'Something went wrong!',
//                         footer: '<a href>Why do I have this issue?</a>'
//                         })
//                 }
//             });
//         }
//     });

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

    $('.vendors').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/loaded-vendor/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {

                        return {
                            text: item.id +' - '+ item.vendors['director'],
                            id: item.id
                        }
                        
                    })
                };
            },
            cache: true
        }
    });

    $('.internal').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/vehicle-list-internal-list',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.registrationNumberPlate,
                            id: item.id
                        }
                        
                    })
                };
            },
            cache: true
        }
    });
    
    $('#internal').on('change', function(e){
        let idxinternal = e.target.value;
        $.get('/vehicle-list-internal-find/'+idxinternal, function(data_show_it){
            $.each(data_show_it, function(index, JAV_DT){
                $('#pltnmbr').val(JAV_DT.registrationNumberPlate);
            });
        });
    });

    $('.vehicle_list').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/rest-api-customer-vendor',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                        }
                        
                    })
                };
            },
            cache: true
        }
    });
   
</script>
@endsection

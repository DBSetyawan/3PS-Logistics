@extends('admin.layouts.master', array(['stored_id_jobs' => session()->get('stored_id_jobs')]))
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/datergpickercstm.css') }}" rel="stylesheet" />
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
    <a href="#">Detail Jobs Shipment List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
    <span class="divider">/</span>
    {{ $reqid_jobs->job_no }}
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
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TAB PORTLET-->
            <div class="widget widget-tabs blue">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> Job Transportss</h4>
                </div>
                <div class="widget-body">
                    <div class="tabbable ">
                        <ul class="nav nav-tabs">
                            <li><a href="#data-cost" data-toggle="tab"><i class="fas fa-money-check-alt"></i> Cost </i></a></li>
                            <li><a href="#pilih-MoT" data-toggle="tab"><i class="fab fa-audible"></i> Transportasi</a></li>
                            <li class="active"><a href="#pilih-shipment" data-toggle="tab"><i class="fas fa-clipboard-list"></i> Shipment</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pilih-shipment">
                                <div class="widget-body">
                                        <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                            <div class="controls">
                                                                <div class="input-prepend">
                                                                <span class="add-on"><i class="icon-calendar"> Estimated time of delivery</i></span>
                                                                    <input class="validate[required]" type="text" value="{{ $reqid_jobs['estimated_time_of_delivery'] }}" style="width:209px;" placeholder="Enter ETD" maxlength="5" id="estimated_time_of_delivery" name="estimated_time_of_delivery">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <div class="input-prepend">
                                                                <span class="add-on"><i class="icon-calendar">&nbsp; Estimated time of arrival   </i></span>
                                                                <input class="validate[required]" type="text" value="{{ $reqid_jobs['estimated_time_of_arrival']  }}" maxlength="5" style="width:217px" placeholder="Enter ETA" id="estimated_time_of_arrival" name="estimated_time_of_arrival">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <div style="text-align:left;">
                                                <div class="form-actions">
                                                    <form id="shipment_load_is_draft_only">
                                                        <input type="hidden" style="width:307px;" class="form-control" value="{{ csrf_token() }}" name="_token">
                                                            <div class="control-group">
                                                            <label class="control-label">Pilih Shipment</label>
                                                            <div class="controls">
                                                                <select class="shipment_load_is_draft_only form-control validate[required]" style="width:320px;" id="shipment_idx" name="shipment_idx">
                                                            </select>
                                                            <button id="add_shipment_id" value="Add" style="margin: 3px" class="btn btn-primary">Add Shipment <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        <div class="form-actions">
                                        {{-- <div style="text-align:right;">
                                            <div style="text-align:left;">
                                                <div class="form-actions">
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
                                        </div> --}}
                                    {{-- </form> --}}
                                    <div class="control-group hidden">
                                            <label class="control-label">Value Shipment</label>
                                                <div class="controls">
                                                <select class="form-control validate[required]" style="width:320px;" id="value_shipj" name="value_shipj">
                                                    @foreach($fetch_data_jobs as $jobs_field)
                                                        @foreach($jobs_field->jobtransactiondetil as $fields => $value)
                                                            <option value="{{ $value->id }}">{{$value->id}}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    <table class="table table-striped table-bordered table-striped" id="undefined" name="ajax_jobs">
                                        <thead>
                                            <tr>
                                                <th bgcolor="#FAFAFA">Pengiriman Ke-</th>
                                                <th class="hidden" bgcolor="#FAFAFA">Uid</th>
                                                <th bgcolor="#FAFAFA">UID Shipment Transport Details</th>
                                                {{-- <th bgcolor="#FAFAFA">Action</th> --}}
                                                {{-- <th bgcolor="#FAFAFA">Action</th> --}}
                                            </tr>  
                                        </thead>
                                        <tbody id="tcbodless">
                                    {{-- @foreach($fetch_data_jobs as $jobs_field)
                                        @foreach($jobs_field->jobtransactiondetil as $fields => $value) --}}
                                            @foreach($fetch_data_jobs as $shipment_job_lists)
                                                @foreach($shipment_job_lists->jobtransactiondetil as $shipment_retrieve)
                                                    <tr class="odd gradeX">
                                                        <td >{{ $shipment_retrieve->shipping_to }}</td>
                                                        <td class="hidden">{{ $shipment_retrieve->id }}</td>
                                                        <td >{{ $shipment_retrieve->shipment_id }}</td>
                                                        {{-- <td style="width:6%;"> --}}
                                                        {{-- <div class="span3">
                                                            <button onclick="location.href=''"
                                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                            data-content="Detail data transport order">
                                                            <i class="icon-file"></i>
                                                          </button>
                                                        </div>   --}}
                                                          {{-- <div class="span3">
                                                            <button class="btn popovers btn-small btn-info ModalStatusJobshipmentlistClass" data-id="{{ $shipment_retrieve->shipment_id }}" 
                                                                    data-target="#ModalStatusJobshipmentlist" data-toggle="modal" data-original-title="Status Order"
                                                                    data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                                <i class="icon-pencil"></i>
                                                            </button>
                                                        </div>   --}}
                                                    {{-- </td> --}}
                                                        {{-- <td style="width:5%;">\ --}}
                                                            {{-- <div class="span3">
                                                                <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                            </div>  --}}
                                                        {{-- </td> --}}
                                                    </tr>
                                                @endforeach()
                                            @endforeach()
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            {{-- {{$fetch_data_jobs}} --}}
                            <div class="modal fade" id="ModalStatusJobshipmentlist" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                            aria-labelledby="update_status_shipment_list" aria-hidden="true" style="width:600px">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel1">Update your status job shipment</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" id="update_status_transports_job_shipment">
                                    <br />
                                    {{-- in progress updated vendor --}}
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
                        <div class="tab-pane" id="pilih-MoT">
                                <div class="form-actions hidden">
                                            <div class="control-group hidden">
                                                <label class="control-label">Pilih Vendor</label>
                                                <div class="controls">
                                                    <select class="vendors form-control validate[required]" style="width:320px;" id="vendor_default" name="vendor_default">
                                                    @foreach($fetch_data_jobs as $shipment_job_lists)
                                                        @foreach($getVendor as $fiels)
                                                            <option value="{{ $fiels->id }}"  @if($fiels->id==$shipment_job_lists->vendor_id) selected='selected' @endif >{{ $fiels->director }}</option>
                                                        @endforeach()
                                                    @endforeach()
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            {{-- <div class="control-group">
                                <label class="control-label">Pilih Category Cost</label>
                                    <div class="controls">
                                        <select class="cost_categorys form-control validate[required]" style="width:320px;" id="category_cost_id" name="category_cost_id">
                                    </select>
                                    <span id="tampil_NW" style="display:none;">
                                        <select class="vendor_item_transport form-control validate[required]" style="width:320px;" id="vendor_item_transport_idx" name="vendor_item_transport_idx">
                                        </select>
                                    </span>
                                </div>
                            </div> --}}
                            {{-- <div class="control-group">
                                    <label class="control-label">Pilih Category Cost</label>
                                        <div class="controls">
                                            <select class="cost_categorys form-control validate[required]" style="width:320px;" id="category_cost_id" name="category_cost_id">
                                        </select>
                                        <span id="tampil_NW" style="display:none;">
                                            <select class="vendors form-control validate[required]" style="width:320px;" id="vendor_j" name="vendor_j">
                                            </select>
                                            <select class="vendor_item_transport form-control validate[required]" style="width:320px;" id="vendor_item_transport_idx" name="vendor_item_transport_idx">
                                            </select>
                                        </span>
                                    </div>
                                </div> --}}
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
                                                                            <button id="added_job_cost" value="Add" style="margin: 1px 5px" class="btn btn-success">Add Job Costs <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                   
                                                        <br/>
                                                        <br/>
                                                        <table class="table table-striped table-bordered table-striped" id="samp1">
                                                                <thead>
                                                                    <tr >
                                                                        {{-- <th bgcolor="#FAFAFA">Vendor</th> --}}
                                                                        <th bgcolor="#FAFAFA">UUID</th>
                                                                        <th bgcolor="#FAFAFA">Driver Name</th>
                                                                        <th bgcolor="#FAFAFA">Driver Phone</th>
                                                                        <th bgcolor="#FAFAFA">Plat Number</th>
                                                                        <th bgcolor="#FAFAFA">#No Document</th>
                                                                        <th bgcolor="#FAFAFA">Cost</th>
                                                                        <th bgcolor="#FAFAFA">Note</th>
                                                                        <th bgcolor="#FAFAFA">Action</th>
                                                                    </tr>  
                                                                </thead>
                                                                <tbody>
                                                                @foreach($fetch_all_job_costs as $jobs_field)
                                                                <tr class="odd gradeX">
                                                                    <td style="width: 60px;">{{ $jobs_field->job_cost_id}}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->driver_name }}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->driver_number }}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->plat_number }}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->doc_reference }}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->cost }}</td>
                                                                    <td style="width: 90px;">{{ $jobs_field->note }}</td>
                                                                    <td style="width:2%;">
                                                                        <div class="span3">
                                                                            <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                                        </div> 
                                                                    </td>
                                                                </tr>
                                                            @endforeach()
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
                                        {{-- progress cost list --}}
                                        <div class="tab-pane" id="data-cost">
                                            <input readonly="enabled" type="text" class="hidden span8"  class="form-control" value="{{ $reqid_jobs["id"] }}" id="index_job_id" name="index_job_id">
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
                                                
                                        </div>
                                {{-- <div class="control-group">
                                    <label class="control-label">Pilih Category Cost</label>
                                        <div class="controls">
                                            <select class="cost_categorys form-control validate[required]" style="width:320px;" id="category_cost_id" name="category_cost_id">
                                        </select>
                                        <span id="tampil_choosen_vehicle" style="display:none;">
                                            <select class="vehicle_list form-control validate[required]" id="vehicle_list_id" name="vehicle_list_id" style="width:150px;">
                                            </select>
                                        </span>
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
                                </div> --}}
                            <div class="control-group hidden">
                                    <label class="control-label">CODE VENDOR</label>
                                    <div class="controls">
                                        <input type="text" class="input-block-level" style="width:320px" id="vendor_idx" name="vendor_idx" value="{{ $reqid_jobs['vendor_id'] }}">
                                </div>
                            </div>
                            <div class="control-group hidden">
                                    <label class="control-label">CODE JOB</label>
                                    <div class="controls">
                                        <input type="text" class="input-block-level" style="width:320px" id="code_jobs" name="code_jobs" value="{{ $reqid_jobs['id'] }}">
                                </div>
                            </div>
                            <div class="control-group hidden">
                                <label class="control-label">CODE  SHIPMENT</label>
                                <div class="controls">
                                    <input type="text" class="input-block-level" style="width:320px" id="code_job_hipment" name="code_job_hipment" value="{{ $reqid_jobs['job_no'] }}">
                            </div>
                        </div>
                        {{-- <div class="control-group">
                                    <label class="control-label">Cost</label>
                                    <div class="controls controls-row">
                                        <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Cost" id="cost_"  name="cost_">
                                    </div>
                                </div>
                                <div class="control-group hidden">
                                        <label class="control-label">Value job_costs</label>
                                            <div class="controls">
                                            <select class="form-control validate[required]" style="width:320px;" id="value_job_costs" name="value_job_costs">
                                                    @foreach($datajcosts as $fiels)
                                                    <option value="{{ $fiels->cost_id  }}">{{ $fiels->name }} - {{ $fiels->cost_id }}</option>
                                                    @endforeach     
                                            </select>
                                        </div>
                                    </div> --}}
                            {{-- <div class="control-group">
                                <label class="control-label">Note</label>
                                    <div class="controls">
                                        <div class="input-prepend">
                                        <input type="text" class="input-block-level validate[required]" style="width:320px" placeholder="Enter Your Note" id="noted" name="noted">
                                        <button id="added_job_cost" value="Add" style="margin: 1px 5px" class="btn btn-success">Add Job Costs <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div style="height: 140px; overflow: auto"> --}}
                            {{-- <div class="form-actions">
                                <table class="table table-striped table-bordered table-striped" id="sample_1s">
                                    <thead>
                                        <tr > --}}
                                            {{-- <th bgcolor="#FAFAFA">Vendor</th> --}}
                                            {{-- <th bgcolor="#FAFAFA">Category</th>
                                            <th bgcolor="#FAFAFA">Cost</th>
                                            <th bgcolor="#FAFAFA">Note</th>
                                            <th bgcolor="#FAFAFA">Action</th>
                                        </tr>  
                                    </thead>
                                    <tbody>
                                      @foreach($fetch_data_jobs as $fiels)
                                        @foreach($fiels->job_costs as $job_cost)
                                                <tr class="odd gradeX">
                                                    <td style="width: 1%;">{{ $job_cost->cost_category->name }}</td>
                                                    <td style="width: 2%;">{{ $job_cost->cost }}</td>
                                                    <td style="width: 8%;">{{ $job_cost->note }}</td>
                                                    <td style="width:1%;">
                                                        <div class="span4">
                                                            <a href="#" data-target="#ModalDataJobsCategory" data-toggle="modal" class="identifyingClass"
                                                            data-id="{{ $job_cost->job_cost_id }}" ><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                                        </div>
                                                        <div class="span4">
                                                            <button onclick="location.href='{{ route('deleting.details',array($job_cost->job_cost_id, $job_cost->id)) }}'" 
                                                            data-original-title="delete cost category" data-placement="top" 
                                                            class="btn tooltips btn-danger" type="button"><i class="fas fa-minus-square"></i>
                                                            </button>
                                                            {{-- <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                                        {{-- </div> 
                                                    </td>
                                                </tr>
                                            @endforeach()
                                        @endforeach()
                                    </tbody>
                                </table>
                            </div> --}}
                            <div class="form-actions">
                            </div>                            
                            {{-- progress show data with modal  --}}
                            {{-- @foreach($customerlist as $list_customer) --}}
                            <div class="modal fade" id="ModalDataJobsCategory" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                            aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel1">Details Job Costs</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" id="update_data_jcst">
                                    {!! csrf_field() !!}
                                    {{ method_field('PUT') }}
                                    <br />
                                    {{-- in progress updated vendor --}}
                                    <div class="control-group">
                                            <label class="control-label">Pilih Vendor</label>
                                            <div class="controls">
                                                <select class="vendors form-control validate[required]" style="width:320px;" id="update_vendor" name="update_vendor">
                                                @foreach($fetch_data_jobs as $shipment_job_lists)
                                                    @foreach($shipment_job_lists->job_costs as $job_cost_id)
                                                        @foreach($getVendor as $fiels)
                                                            <option value="{{ $fiels->id }}"  @if($fiels->id==$job_cost_id->vendor_item_id) selected='selected' @endif >{{ $fiels->director }}</option>
                                                        @endforeach()
                                                    @endforeach()
                                                @endforeach()
                                            </select>
                                        </div>
                                    </div>
                                    {{-- on progress build with selected --}}
                                    <div class="control-group">
                                            <label class="control-label">Category Cost</label>
                                            <div class="controls">
                                            <select class="cost_categorys_with_fk input-large m-wrap validate[required]" style="width:320px;"tabindex="1" id="category_cost" name="category_cost">
                                                @foreach($fetch_data_jobs as $shipment_job_lists)
                                                    @foreach($shipment_job_lists->job_costs as $job_cost_id)
                                                        @foreach($fetch_all_data_category as $fiels)
                                                            <option value="{{ $fiels->id }}"  @if($fiels->id==$job_cost_id->cost_id) selected='selected' @endif >{{ $fiels->name }}</option>
                                                        @endforeach()
                                                    @endforeach()
                                                @endforeach()
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" >Cost</label>
                                        <div class="controls">
                                            <input class="input-large validate[required]" type="text" style="width:312px;" maxlength="30" id="cost" name="cost" />
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Note</label>
                                        <div class="controls">
                                            <input class="input-large validate[required]" type="text" style="width:312px;" maxlength="30" id="noted" name="noted" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    {{-- @endforeach --}}
                    {{-- end progress show data with modal  --}}
                            <div class="control-group hidden">
                                <label class="control-label"></label>
                                <div class="controls">
                                <select class="form-control" style="width:280px;" id="cost_idxs" name="cost_idxs">
                                    @foreach($dkaoskd as $shipment_job_lists)
                                        @foreach($shipment_job_lists->job_costs as $sadas)
                                            <option value="{{ $sadas->cost_id }}">{{ $sadas->cost_id }} - {{ $sadas->note}}</option>
                                        @endforeach()
                                    @endforeach()
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
                                        <select class="vendor_shipment form-control" id="vendor_shipment" style="width:280px;" name="vendor_shipment">
                                        </select>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <br>
                                            </div>
                                        </div>
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
                            {{-- <div class="tab-pane" id="data-driver">
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
                                                                    @foreach($fetch_data_jobs as $sadasdafs)
                                                                      <input type="text" class="input-block-level validate[required]" placeholder="Enter name" id="drname" value="{{ $sadasdafs->driver_name }}" name="drname" required>
                                                                    @endforeach()
                                                                    </div>
                                                              </div>
                                                          </div>
                                                          <div class="span6">
                                                              <div class="control-group">
                                                                  <label class="control-label" >Plat Number</label>
                                                                  <div class="controls controls-row">
                                                                      <input type="text" class="input-block-level validate[required]" placeholder="Empty" value="{{ $sadasdafs->plate_number }}" id="pltnmbr" name="pltnmbr" required>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row-fluid">
                                                              <div class="span6">
                                                                  <div class="control-group">
                                                                      <label class="control-label" >Driver Phone</label>
                                                                      <div class="controls controls-row">
                                                                          <input type="text" class="input-block-level validate[required]" placeholder="Enter Contact" value="{{ $sadasdafs->driver_number }}" id="drphn" name="drphn" required>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="span6">
                                                                  <div class="control-group">
                                                                      <label class="control-label" >Document #Ref</label>
                                                                      <div class="controls controls-row">
                                                                          <input type="text" class="input-block-level validate[required]" placeholder="Enter Address" value="{{ $sadasdafs->document_reference }}" id="docref" name="docref" required>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                <div class="modal-footer">
                                                <br />
                                                    <br />
                                                        <br />
                                            @can('transport')
                                                <button id="updated_job_costs" style="margin: 3px" class="btn btn-info span12">Updated Jobs Shipment <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                        @endcan()
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TAB PORTLET-->
        </div>
    <!-- END PAGE CONTENT-->         
    </div>
{{-- </form> --}}
</div>
@endsection
@section('javascript')
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
<script src="{{ asset('js/detail_job_transport_list.js') }}"></script>
<script src="{{ asset('js/detail_job_cost_list.js') }}"></script>
<script src="{{ asset('js/tble_cost_detail.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script type="text/javascript">

        // sorting shipment with scroll javasript 
        $(function() {

            $( "#tcbodless" ).sortable({
                    tolerance: "pointer",
                    appendTo: "parent",
                    helper: "clone",
                        start: function(event, ui){

                            // this is a method for retrieving rows when the cursor starts taking rows at certain index points

                            let id_shipment_start = $( "#tcbodless tr td:eq( 0 )" ).html();

                            let start_index = ui.item.index();
                            
                            if(start_index == 0) { //index 1

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

                            if(start_index == 1){ //index 2

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

                            if(start_index == 2){ //index 3

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

                            if(start_index == 3){ //index 4

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

                            if(start_index == 4){ //index 5

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

                            if(start_index == 5){ //index 6

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

                            if(start_index == 6){ //index 7

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

                            if(start_index == 7){ //index 8

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

                            if(start_index == 8){ //index 9

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

                            if(start_index == 9){ //index 10

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

                            if(start_index == 10){ //index 11

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

                            if(start_index == 11){ //index 12

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

                            if(start_index == 12){ //index 13

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

                            if(start_index == 13){ //index 14

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

                            if(start_index == 14){ //index 15

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

                            if(start_index == 15){ //index 16

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

                            if(start_index == 16){ //index 17

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

                            if(start_index == 17){ //index 18

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

                            if(start_index == 18){ //index 19

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

                            if(start_index == 19){ //index 20

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

                            if(start_index == 20){ //index 21

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
                        stop: function(ui, eventstoping){

                            // this is a method for retrieving rows when the cursor stops at a certain index point

                            let id_shipment_stop = $( "#tcbodless tr td:eq( 0 )" ).html();

                            let stop_index = eventstoping.item.index();

                            if(stop_index == 0) { //index 1

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 1){ //index 2

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 2){ //index 3

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 3){ //index 4

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 4){ //index 5

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
                                    url: '/move-shipment-already-exists-movements/find',
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
                                                title:"Urutan pengiriman "+ data['response'].record_shipment_4 + " Berhasil diurutkan Ke- "+ data['response'].shorter_index5
                                        })

                                    }
                                });

                            }

                            if(stop_index == 5){ //index 6

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 6){ //index 7

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
                                    url: '/move-shipment-already-exists-movements/find',
                                    type    : "GET",
                                    cache   : true,
                                    dataType: "json",
                                    data    : {
                                        arrys:arrys
                                            },                
                                    success: function(data) {

                                        swal('testing indexing index 10, success!');
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

                            if(stop_index == 7){ //index 8

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 8){ //index 9

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 9){ //index 10

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 10){ //index 11

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 11){ //index 12

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 12){ //index 13

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 13){ //index 14

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 14){ //index 15

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 15){ //index 16

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 16){ //index 17

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 17){ //index 18

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 18){ //index 19

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 19){ //index 20

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                            if(stop_index == 20){ //index 21

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
                                    url: '/move-shipment-already-exists-movements/find',
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

                    }
            });
        });

        // in progress with showing data with modal
        $(function () {
            $(".identifyingClass").click(function (e) {
            e.preventDefault();
                let my_id_value = $(this).data('id');
                $.get('/get-data-jobs-costs-details/findit/'+ my_id_value, function(showingdata){
                $('.modal-body #category_cost').val(''+showingdata.cost_id);
                $('.modal-body #cost').val(''+showingdata.cost);
                $('.modal-body #noted').val(''+showingdata.note);
                $("#update_data_jcst").attr('action', '/job-show-eq/find/'+showingdata.job_cost_id);
                $('.cost_categorys_with_fk').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/loaded-jobs-forloads-cost-category/find-it-with-fk/'+showingdata.cost_id,
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
                    }
                );
            })
        });
        // end progress

//         $('#ModalDataJobsCategory').on('show.bs.modal', function () {
// //    alert('hi')
//     $('#asdzx').text('Update');



        $('#vendor_j').on('change', function(e){
            
                let idnyavendor = e.target.value;
                document.getElementById('tampil_v_item_transport').style.display='inline'
                        $("#vendor_j").prop("disabled", false);
                        $("#vendor_j").prop("disabled", false);
                            $('#cost_').val('');
                            $('#noted').val('');
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
            let leds = $("#code_job_hipment").val();
            $.get('/showing-status-shipment/find/'+leds, function(data_status){

                $('.shipment_load_is_draft_only').select2({
                    placeholder: 'Cari...',
                    "language": {
                    "noResults": function(){

                        // https://htmlcolorcodes.com/color-names/
                        
                        if(data_status == "delivered"){
                            return 'Maaf job ini sedang dalam status <span style="background-color:GOLD" class="label">'+data_status+'</span> <br/> anda tidak bisa menambahkan shipment lagi.';//thhis button, if you want add button on select2

                        }

                        // if(data_status == "process"){
                        //     return 'Maaf job ini sedang dalam status <button class="btn btn-primary">'+delivered+'</button> <br/> anda tidak bisa menambahkan shipment lagi.';//thhis button, if you want add button on select2

                        // }
                            // console.log(data_status.status_vendor_jobs)

                    }

                },
                    escapeMarkup: function (markup) {
                    return markup;
                        },
                            ajax: {
                                url: '/status-find-transport-order-id-only/find/'+ leds,
                                method: 'GET',
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                return {
                                                    text: item.order_id,
                                                    id: item.id
                                                }
                                            })
                                        };
                                    },
                                cache: true
                            }
                    }
                );
            });


        // })
        // $('.cost_categorys').on('change', function(e){
        //             let category_cost = e.target.value;
        //             // let vals_vendor = document.getElementById("vendor_j").value;
        //             let vals_vitem_idx = document.getElementById("vitem_idx").value;
        //             let selectElem = document.getElementById('category_cost_id');
        //             let selectElemVehicle = document.getElementById('vehicle_list_id').value;
                    // When a new <option> is selected
                    // if(!vals_vendor){
                    //     const toast = Swal.mixin({
                    //             toast: true,
                    //             position: 'top',
                    //             showConfirmButton: false,
                    //             timer: 3000
                    //             }
                    //         );
                            
                    //     toast({
                    //         title: 'Vendor belum dipilih, silahkan pilih terlebih dahulu.'
                    // })
                    //     $('#category_cost_id').empty();
                    //     } else {
                            // let index = selectElem.value;
                            // let vals_vendor = document.getElementById("vendor_j").value;
                            
                            //     if (index == 6) {
                                    // $("#category_cost_id").prop("disabled", true);
                                    // document.getElementById('tampil_NW').style.display='inline'
                                    // $('#vendor_item_transport_idx').select2({
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
                                //     document.getElementById('tampil_choosen_vehicle').style.display='inline'
                                //     $('.vehicle_list').on('change', function(e){
                                //         let selectElemVehiclesadasd = e.target.value;
                                //         // console.log(selectElemVehiclesadasd)
                                //         $("#vehicle_list_id").prop("disabled", true);

                                //         if (selectElemVehiclesadasd == 2) {
                                //             document.getElementById('tampil_NW').style.display='inline'
                                //             document.getElementById('tampil_v_item_transport').style.display='none'
                                //             document.getElementById('tampil_NI').style.display='none'

                                //         } else {
                                //             document.getElementById('tampil_NW').style.display='none'

                                //         }

                                //         if (selectElemVehiclesadasd == 1) {
                                //             document.getElementById('tampil_NI').style.display='inline'
                                //         } else {
                                //             document.getElementById('tampil_NI').style.display='none'

                                //         }


                                //     });
                                // }
                                //     else {
                                        
                                //         // $('#cost_').val('');
                                //         // $('#noted').val('');
                                //         // $('#vendor_item_transport_idx').empty();
                                //         // document.getElementById('tampil_NW').style.display='none'
                                //         $('#cost_').val('');
                                //         $('#noted').val('');
                                //         $("#vehicle_list_id").prop("disabled", false);
                                //         $("#vendor_j").prop("disabled", false);
                                //         $("#vehicle_list_id").empty();

                                //         $('#vendor_item_transport_idx').empty();
                                //         $('#vendor_j').empty();
                                //         $('#vendor_item_transport_idx').empty();
                                //         document.getElementById('tampil_choosen_vehicle').style.display='none'
                                //         document.getElementById('tampil_v_item_transport').style.display='none'
                                //         document.getElementById('tampil_NI').style.display='none'
                                //         document.getElementById('tampil_NW').style.display='none'
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
                //     }
                // }
            // );

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

    $("#added_job_cost").click(function(event) {
    event.preventDefault();
    const cost = $('#cost_').val();
    const driver_name = $('#drname').val();
    const driver_number = $('#drphn').val();
    const plat_number = $('#pltnmbr').val();
    const doc_ref = $('#docref').val();
    const job_id = $('#code_jobs').val();
    const note = $('#noted').val();
    const vendor = $('#update_vendor').val();
    const category_cost_id = $('#category_cost_id').val();

    let request = $.ajax({
                
                url: "{{ url('/get-code-job-shipment-equivalent')}}",
                method: "GET",
                dataType: "json",
                data: { 
                    job_id:job_id,
                    driver_name:driver_name,
                    driver_number:driver_number,
                    plat_number:plat_number,
                    cost_id:category_cost_id,
                    doc_ref:doc_ref,
                    cost:cost,
                    vendor:vendor,
                    note:note,
                },
                success: function (data) {
                    Swal({
                        title: 'Successfully',
                        text: "You have done save Job Shipment!", //this function in progress deploy ...
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                            $('#cost_').val('');
                            $('#noted').val('');
                        }
                    })
                    // alert(job_id)
                },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            text: 'Try again to correct data!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    }
                }
            );
        });

        
        function RemoveCostOfJobs(button) {
            let rowszsd = $(button).closest("TR");
            let uuids = $("TD", rowszsd).eq(0).html();
            // console.log(uuid)
            Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted !",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    $.ajax({

                            url: "{{ url('/job-cost-of-cost-delete/find') }}/"+uuids,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const tablesjsc = $("#job_cost_ofcostlist")[0];
                                tablesjsc.deleteRow(rowszsd[0].rowIndex);

                            }

                    });
              
                }

            })
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
        
        function AddRowJobsofcost(category_cost_id, cost_, noted) {

            if (!category_cost_id) {
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000
                });

                toast({
                    title: '[Add Cost Jobs] Maaf permintaan anda gagal, Silahkan isikan Cost Category terlebih dahulu ..'
                })
                $("#category_cost_of_cost_id").empty();
                $("#cost_").val('');
                $("#cost_noted").val('');
            } else {
                
                //this retrieve value from form input
                // const index_job = document.getElementById('index_job_id').value;
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



    $("#add_shipment_id").click(function(event) {
    event.preventDefault();
    const job_id = $('#code_jobs').val();
    const order_id = $('#shipment_idx').val();
    if (! order_id) {

        swal("System Detects","Maaf inputan anda tidak boleh kosong","error");

    } else {

        let request = $.ajax({
                
                url: "{{ url('/get-equivalent-shipment-id')}}",
                method: "GET",
                dataType: "json",
                data: { 
                    job_id:job_id,
                    order_id:order_id
                },
                success: function (data) {
                    Swal({
                        title: 'Successfully',
                        text: "You have done Added Shipment Order ID!", //this function in progress deploy ...
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                            $('#shipment_idx').empty();
                        }
                    })
                },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            text: 'Maaf anda tidak bisa menambahkan order id di shipment ini, karena pada job shipment ini dalam proses!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    }
                }
            );
        }

    });

        $("#updated_job_costs").click(function(event) {
            event.preventDefault();
            let arrDataShipment = new Array();
            let arrDataJCost = new Array();

            const job_id = $('#code_jobs').val();
            const vendor_id = $('#vendor_j').val();
            const vendor_default = $('#vendor_default').val();

            //information transporter
            const driver_name = $('#drname').val();
            const plat_number = $('#pltnmbr').val();
            const driver_number = $('#drphn').val();
            const document_reference = $('#docref').val();
            //end

            let val_shipment_id = document.getElementById('value_shipj');
            let cost_id = document.getElementById('cost_idxs');

            for (i = 0; i < val_shipment_id.options.length; i++) {

                arrDataShipment[i] = val_shipment_id.options[i].value;

            }

                let rdataShipment_id = [];

                for (i = 0; i < arrDataShipment.length; i++) {

                    rdataShipment_id.push(arrDataShipment[i]);

                }

                for (i = 0; i < cost_id.options.length; i++) {

                    arrDataJCost[i] = cost_id.options[i].value;

                    }

                    let rdataCosts = [];

                    for (i = 0; i < arrDataJCost.length; i++) {

                        rdataCosts.push(arrDataJCost[i]);

                }


            let requestUpdatedCost = $.ajax({
                
                url: "{{ url('/get-transaction-details/') }}",
                method: "GET",
                dataType: "json",
                data: { 
                    shipment_id:rdataShipment_id,
                    vendor_item_id:vendor_id,
                    job_id:job_id,
                    cost_id:rdataCosts,
                    default:vendor_default,
                    //information transporter
                    driver:driver_name,
                    plat:plat_number,
                    driver_number:driver_number,
                    docref:document_reference
                },
                success: function (data) {
                    console.log(data)
                    Swal({
                        title: '[ Data has been Updated ]',
                        text: "You have done updated Job Shipment!", //this function in progress deploy ...
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                    }).then((result) => {
                        if (result.value) {
                            // location.reload(); //this reload for after change data
                        }
                    })
                },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            text: 'Try again, please check correct data!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    }
                }
            );
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

    $(function () {
    $(".ModalStatusJobshipmentlistClass").click(function (e) {
    e.preventDefault();
        let status_job_shipment = $(this).data('id');
        $("#update_status_transports_job_shipment").attr('action', '/updated-status-transport-order/'+status_job_shipment);
                $('.update_data_status_job_shipments').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/status-find-job-transport-slug/'+status_job_shipment,
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
            }
        );
    });

    $(function() {
        $('#estimated_time_of_delivery').daterangepicker({
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
            $('#estimated_time_of_arrival').daterangepicker({
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
    
</script>
@endsection

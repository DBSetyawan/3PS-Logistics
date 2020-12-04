@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../img/logo.ico" />
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
                <form action="{{ route('display.trans', array($some)) }}">
                    <div style="text-align:center;margin:10px 10px">
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
                    </form>
                        <form action="{{route('exports.tc.list',array($some))}}">
                        <div style="text-align:left;">
                        <div class="span3">
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        @if ($api_v2 == "true")
                                            <button id="export_orders" type="submit" style="
                                            position: relative;
                                            background: GREEN;
                                            width: 190px;
                                            height: 30px;
                                            top: 19px;
                                            left: 155%;" class="btn btn-success">Export To Accurate <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button>
                                            @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                <th class="nosort" bgcolor="#FAFAFA">#</th>
                                <th bgcolor="#FAFAFA">Code</th>
                                {{-- <th>ID</th> --}}
                                <th class="nosort" bgcolor="#FAFAFA">Customer</th>
                                {{-- <th bgcolor="#FAFAFA">PO Codes</th> --}}
                                <th class="nosort" bgcolor="#FAFAFA">Collie</th>
                                <th class="nosort" bgcolor="#FAFAFA">A.W(kg)</th>
                                <th class="nosort" bgcolor="#FAFAFA">C.W(kg)</th>
                                <th class="nosort" bgcolor="#FAFAFA">Origin Details</th>
                                <th class="nosort" bgcolor="#FAFAFA">Destination Details</th>
                                <th class="nosort" bgcolor="#FAFAFA">Date-Time</th>
                                <th class="nosort" bgcolor="#FAFAFA">status</th>

                                <th class="nosort" bgcolor="#FAFAFA">Created By</th>
                                <th class="nosort" bgcolor="#FAFAFA">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data_transport as $transport_order_lists)
                            <tr class="odd gradeX">
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'upload')
                                        @if ($api_v2 == "true")
                                            <td style="width: 2%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="{{ $transport_order_lists->id}}"></td>
                                            @else
                                            <td style="width: 2%;"><center><span style='background-color:TOMATO' class='label'>Disabled</span></center></td>
                                        @endif
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'done')
                                    <td style="width: 2%;"></td>
                                @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'invoice')
                                    <td style="width: 2%;"></td>
                                @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'paid')
                                    <td style="width: 2%;"></td>
                                @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'cancel')
                                    <td style="width: 2%;"></td>
                                @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'draft')
                                    <td style="width: 2%;"></td>
                                @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'proses')
                                        @if ($api_v2 == "true")
                                            <td style="width: 2%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="{{ $transport_order_lists->id}}"></td>
                                            @else
                                            <td style="width: 2%;"><center><span style='background-color:TOMATO' class='label'>Disabled</span></center></td>
                                        @endif
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'new')
                                        @if ($api_v2 == "true")
                                        <td style="width: 2%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="{{ $transport_order_lists->id}}"></td>
                                        @else
                                        <td style="width: 2%;"><center><span style='background-color:TOMATO' class='label'>Disabled</span></center></td>
                                        @endif
                                    @else
                                @endif
                                <td style="width: 13%;">{{$transport_order_lists->order_id}}</td>
                                {{-- <td style="width: 5%;"><div style="text-transform:uppercase">{{++$i}}</div></td> --}}
                                <td style="width: 11%;">{{$transport_order_lists->customers->name}}</td>
                                {{-- <td style="width: 8%;">{{$transport_order_lists->purchase_order_customer}}</td> --}}
                                <td style="width: 6%">{{$transport_order_lists->collie}}</td>
                                <td style="width: 6%">{{$transport_order_lists->actual_weight}}</td>
                                <td style="width: 6%;">{{$transport_order_lists->chargeable_weight}}</td>
                                <td style="width: 11%;">{{$transport_order_lists->origin_details}}</td>
                                <td style="width: 11%;">{{$transport_order_lists->destination_details}}</td>
                                <td style="width: 8%;">{{$transport_order_lists->estimated_time_of_arrival}}</td>
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'draft')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'proses')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:REBECCAPURPLE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'upload')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:CORAL;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'new')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:DEEPSKYBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'done')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:FORESTGREEN;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'invoice')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'paid')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'cancel')
                                <td style="width: 5%;">
                                    <span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                        data-id="{{ $transport_order_lists->order_id }}"
                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Transport"
                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status Shipment">
                                        {{$transport_order_lists->cek_status_transaction->status_name}}
                                    </span>
                                </td>
                                    @else
                                @endif
                                <td style="width: 6%;">
                                    {{$transport_order_lists->by_users}}    
                                </td>
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'new')
                                    <td style="width: 7%;">
                                        @if ($api_v2 == "true")
                                        <div class="row-fluid">
                                            <div class="span5">
                                                    <button onclick="location.href='{{ route('xlsx_tc', array($some,$transport_order_lists->id)) }}'"
                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                        type="button"><i class="icon-large icon-cloud-download"></i>
                                                    </button>
                                                    {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                        class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                    data-content="Detail data transport order">
                                                    <i class="icon-file"></i>
                                                </button> --}}
                                            </div>
                                            &nbsp;
                                            <div class="span5">
                                                    {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                        type="button"><i class="icon-large icon-cloud-download"></i>
                                                    </button> --}}
                                                {{-- <button class="btn popovers btn-small btn-info ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                                    data-target="#ModalStatusAccoutingTC" style data-toggle="modal" data-original-title="Pemberitahuan system"
                                                    data-trigger="hover" data-placement="bottom" data-content="Up to status">
                                                    <i class="icon-pencil"></i>
                                                </button> --}}
                                            </div>
                                            </div>
                                                @else
                                                <div class="span5">
                                                        <center><span style='background-color:TOMATO' class='label'>Disabled</span></center>

                                                        {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                        data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                        data-content="Detail data transport order">
                                                        <i class="icon-file"></i>
                                                    </button> --}}
                                                </div>
                                            @endif
                                            <div class="row-fluid">
                                                <div class="span3">
                                                    {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                    data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                    class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                    type="button"><i class="icon-small icon-cloud-download"></i></button> --}}
                                                </div>
                                            </div>
                                    </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'upload')
                                <td style="width: 7%;">
                                        @if ($api_v2 == "true")
                                        <div class="row-fluid">
                                            <div class="span5">
                                                        <button onclick="location.href='{{ route('xlsx_tc', array($some,$transport_order_lists->id)) }}'"
                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                        type="button"><i class="icon-large icon-cloud-download"></i>
                                                    </button>
                                                    {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                        class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                    data-content="Detail data transport order">
                                                    <i class="icon-file"></i>
                                                </button> --}}
                                            </div>
                                            &nbsp;
                                            <div class="span5">
                                                    {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                        type="button"><i class="icon-large icon-cloud-download"></i>
                                                    </button> --}}
                                                {{-- <button class="btn popovers btn-small btn-info ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                                    data-target="#ModalStatusAccoutingTC" style data-toggle="modal" data-original-title="Pemberitahuan system"
                                                    data-trigger="hover" data-placement="bottom" data-content="Up to status">
                                                    <i class="icon-pencil"></i>
                                                </button> --}}
                                            </div>
                                            </div>
                                                @else
                                                <div class="span5">
                                                        <center><span style='background-color:TOMATO' class='label'>Disabled</span></center>

                                                        {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                        data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                        data-content="Detail data transport order">
                                                        <i class="icon-file"></i>
                                                    </button> --}}
                                                </div>
                                            @endif
                                            <div class="row-fluid">
                                                <div class="span3">
                                                    {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                    data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                    class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                    type="button"><i class="icon-small icon-cloud-download"></i></button> --}}
                                                </div>
                                            </div>
                                    </td>
                                    @else
                                @endif
                                @if ($transport_order_lists->cek_status_transaction->status_name == 'draft')
                                <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                            <center><font style="font:bold" face="Fira Code">Nothing Action</font></center>
                                                {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                data-content="Detail data transport order">
                                                <i class="icon-file"></i>
                                            </button> --}}
                                        </div>
                                        &nbsp;
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'invoice')
                            {{-- <td style="width: 6%;">
                                {{$transport_order_lists->by_users}}    
                            </td> --}}
                            <td style="width: 7%;">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <center><font style="font:bold" face="Fira Code">Nothing Action</font></center>
                                            {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                            data-content="Detail data transport order">
                                            <i class="icon-file"></i>
                                        </button> --}}
                                    </div>
                                    &nbsp;
                                </div>
                            </td>
                            
                            @else
                        @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'proses')
                            <td style="width: 7%;">
                                    @if ($api_v2 == "true")
                                    <div class="row-fluid">
                                        <div class="span5">
                                                    <button onclick="location.href='{{ route('xlsx_tc', array($some,$transport_order_lists->id)) }}'"
                                                    data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                    class="btn popovers btn-small btn-success" data-content="Save this order to list exportsss"
                                                    type="button"><i class="icon-large icon-cloud-download"></i>
                                                </button>
                                                {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                data-content="Detail data transport order">
                                                <i class="icon-file"></i>
                                            </button> --}}
                                        </div>
                                        &nbsp;
                                        <div class="span5">
                                                {{-- <center><font style="font:bold" face="Fira Code">feature disabled</font></center> --}}

                                                {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                    data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                    class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                    type="button"><i class="icon-large icon-cloud-download"></i>
                                                </button> --}}
                                            {{-- <button class="btn popovers btn-small btn-info ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                                data-target="#ModalStatusAccoutingTC" style data-toggle="modal" data-original-title="Pemberitahuan system"
                                                data-trigger="hover" data-placement="bottom" data-content="Up to status">
                                                <i class="icon-pencil"></i>
                                            </button> --}}
                                        </div>
                                        </div>
                                            @else
                                                <div class="span5">
                                                        <center><span style='background-color:TOMATO' class='label'>Disabled</span></center>

                                                        {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                        data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                        data-content="Detail data transport order">
                                                        <i class="icon-file"></i>
                                                    </button> --}}
                                                </div>
                                        @endif
                                        <div class="row-fluid">
                                            <div class="span3">
                                                {{-- <button onclick="location.href='{{ route('xlsx_tc', $transport_order_lists->id) }}'"
                                                data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                type="button"><i class="icon-small icon-cloud-download"></i></button> --}}
                                            </div>
                                        </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'done')
                                <td style="width: 7%;">
                                    <div class="row-fluid">
                                        <div class="span5">
                                            <center><font style="font:bold" face="Fira Code">Nothing Action</font></center>
                                                {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                                class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                data-content="Detail data transport order">
                                                <i class="icon-file"></i>
                                            </button> --}}
                                        </div>
                                        &nbsp;
                                    </div>
                                </td>
                                @else
                            @endif
                           
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'paid')
                            <td style="width: 7%;">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <center><font style="font:bold" face="Fira Code">Nothing Action</font></center>
                                            {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                            data-content="Detail data transport order">
                                            <i class="icon-file"></i>
                                        </button> --}}
                                        </div>
                                        &nbsp;
                                        
                                    </div>
                                </td>
                                @else
                            @endif
                            @if ($transport_order_lists->cek_status_transaction->status_name == 'cancel')
                            <td style="width: 7%;">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <center><font style="font:bold" face="Fira Code">Nothing Action</font></center>
                                            {{-- <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                            data-content="Detail data transport order">
                                            <i class="icon-file"></i>
                                        </button> --}}
                                        </div>
                                        &nbsp;
                                    </div>
                                </td>
                                @else
                            @endif
                            </tr>
                            @endforeach()
                        </tbody>
                    </table>
                </form>
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
@endsection
@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
 {{-- <script src="https://cdn.jsdelivr.net/jquery/1.11.3/jquery.min.js"></script> --}}
 <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
 @include('sweetalert::view')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>

<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>

 {{-- <script src="{{ asset('js/select2.min.js') }}"></script> --}}
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<!--script for this page only-->
<script src="{{ asset('js/tc_for_accounting.js') }}"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">

$(function () {
        $(".ModalStatusAccoutingTC").click(function (e) {export_orders
        e.preventDefault();
            let id_shipment = $(this).data('id');
            $.get('/find-id-transport-show-status/'+id_shipment, function(showingdatastatus){
            $('#myModalLabel1').text('STATUS - '+ showingdatastatus['cek_status_transaction']['status_name']);
            $("#update_data_transports").attr('action', '/updated-transport-tc-status/'+id_shipment);
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
            })
        })
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

    $(function () {
            $(".ModalShowDataHistoryOrder").click(function (e) {
            e.preventDefault();
            const tBody = $("#TableHistory > TBODY")[0];

                let histroy_log_idx = $(this).data('id');
                var trHTML = '';
                $('#myModalWarehouse').text('Tracking History Order [ Transport ] - '+histroy_log_idx);
                $.get('/history-find-it-details-tc/'+histroy_log_idx, function(showingdatastatus){
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
                                    const arrayTCstatus = entry.toString();

                                        his = arrayTCstatus.replace("1","<center><span style='background-color:REBECCAPURPLE' class='label'>draft</span></center>")
                                        ketiga = arrayTCstatus.replace("2","<center><span style='background-color:REBECCAPURPLE' class='label'>Process</span></center>")
                                        pod = arrayTCstatus.replace("3","<center><span  class='label'>Invoice</span></center>")
                                        dh = arrayTCstatus.replace("4","<center><span style='background-color:FORESTGREEN' class='label'>Done</span></center>")
                                        ds = arrayTCstatus.replace("5","<center><span style='background-color:red' class='label'>Canceled</span></center>")
                                        dsjo = arrayTCstatus.replace("6","<center><span style='background-color:CORAL' class='label'>Upload</span></center>")
                                        dsko = arrayTCstatus.replace("7","<center><span class='label btn-neutral'>POD</span></center>")
                                        sdasdf = arrayTCstatus.replace("8","<center><span style='background-color:DEEPSKYBLUE' class='label'>New</span></center>")
                                        let sd = dh.concat(ds,pod,ketiga,his,dsjo,dsko,sdasdf);
                                        let done = sd.replace(/[0-8]/g, '')

                                        str += '<ul style=""><li style="display:none"></li><div style="width:117px;z-index: -1;border-left: 1px dashed gray;height: 20px;">'+ done +'</div></ul>';
                                       
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

                                    let tolistshipmentacc = function(arr){
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
                            let shipments = [];
                            let rdatatcxz0 = [];
                            let rdatatcxz1 = [];
                            let rdatatcxz2 = [];
                            let dasdzsds = [];
                            let asdasd = Array();

                            for (i = 0; i < arrfsc.length; i++) {

                                rdatatcxz0.push(arrfsc[i]['order_id']);
                                rdatatcxz1.push(arrfsc[i]['status']);
                                rdatatcxz2.push(arrfsc[i]['datetime']);
                                rdatatcxz3.push(arrfsc[i]['user_order_transport_history']['name']);
                                shipments.push(arrfsc[i]['order_id']);

                            }
                                        
                            $('#modals').html('<td><div style="margin-left:19px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>'
                                +'<td><hr/><center><label>Shipment</label></center><hr /><div>'+'&nbsp;'+tolistshipmentacc(shipments)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Fira Code">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });
</script>
@endsection

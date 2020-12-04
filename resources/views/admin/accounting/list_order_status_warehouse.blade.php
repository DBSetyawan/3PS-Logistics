@extends('admin.layouts.master', array('indexorderid'=> session()->get('indexorderid')))
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
    <a href="#">Warehouse Order List</a>
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
                     <div style="text-align:right;">
                                {{-- <button type="button" class="btn btn-info" onclick="location.href='{{ url('warehouse/registration') }}'">
                                        <i class="icon-plus"></i>
                                            Warehouse Order Registration
                                    </button> --}}
                                </div>
                                <form action="{{ route('display.rate.for.warehouse', array($some))}}">
                                    <div style="text-align:center;">
                                        <div class="row-fluid">
                                            <div class="span3">
                                                <div class="control-group span12">
                                                    <label class="control-label"></label></label>
                                                        <div class="controls">
                                                            <div class="input-prepend">
                                                            <span class="add-on">Start Date <i class="icon-calendar"></i></span>
                                                            <input id="datepickerfrom" name="datepickerfrom" value="{{ old('datepickerfrom') }}" type="text" class="span5" />
                                                            <span class="add-on">End Date <i class="icon-calendar"></i></span>
                                                            <input id="datepickerto" name="datepickerto" value="{{ old('datepickerto') }}" type="text" class="span5" />
                                                            <button id="explore_data_with_daterange" type="submit" style="margin:1px 15px" class="btn btn-primary">Apply <i class="icon-circle-arrow-right"></i> <i class=""></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                     </form>
                                    <br/>
                                <br/>
                                <form action="{{ route('xml.files.http.only', array($some)) }}">
                                        {{-- @can('operasional') --}}
                                            <div class="span4">
                                                <div class="control-group span12">
                                                    <div class="controls" style="margin-left:450px;margin-top: -39px;">
                                                        <div class="input-prepend">
                                                            <span class="span2"></span>
                                                            @if($api_v2 =="true")
                                                            <button id="export_orders" type="submit" class="btn btn-success">Export To Accurate<i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button>
                                                            @else
                                                            <spam id="export_orders" type="submit" class="btn btn-warning">Feature disable <i class="fas fa-exclamation"></i></spam>
                                                            @endif
                                                            <button type="button" class="btn btn-info" onclick="location.href='{{ route('warehouse.registration', array($some)) }}'">
                                                                <i class="icon-plus"></i>
                                                                    Warehouse Order Registration
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- @endcan --}}
                                            <div style="text-align:left;">
                                                <div class="widget-body">
                                                    <h5><br/></h5>
                                                    <div class="input-prepend" style="
                                                    position: absolute;
                                                    transform: translate(-5%, 70%);">
                                                        <label class="control-label"></label>
                                                        <label class="span3" style="color:black">Status Order: &nbsp;&nbsp;</label>
                                                        <span class="label" id="draftds">draft</span>
                                                        <span class="label" id="processed">process</span>
                                                        <span class="label" id="uploaded">upload</span>
                                                        <div class="space10 visible-phone visible-tablet"></div>
                                                        <span class="label" id="invoice">invoice</span>
                                                        <span class="label" id="paids">paid</span>
                                                        <span id="canceled" class="label">cancel</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-striped table-bordered table-striped" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor="#FAFAFA" style="width: 10px;">#</th>
                                                        <th bgcolor="#FAFAFA">Order ID</th>
                                                        <th bgcolor="#FAFAFA">Customer Name</th>
                                                        <th bgcolor="#FAFAFA">Sub Services</th>
                                                        <th bgcolor="#FAFAFA">Contract Number</th>
                                                        <th bgcolor="#FAFAFA">Volume</th>
                                                        <th bgcolor="#FAFAFA">Rate</th>
                                                        <th bgcolor="#FAFAFA">Total Rate</th>
                                                        <th bgcolor="#FAFAFA">Created At</th>
                                                        {{-- <th bgcolor="#FAFAFA">Made by users</th> --}}
                                                        <th bgcolor="#FAFAFA">Status Order</th>
                                                        <th bgcolor="#FAFAFA">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            @for ($i = 0; $i < $id_auto; $i++)
                                                @foreach($warehouseTolist as $list_customer)
                                                    <tr class="odd gradeX">
                                                        @if($api_v2 =="true")
                                                        <td style="width: 3%;"><input class="{{++$i}}" type="checkbox" id="check_sales_order[]" name="check_sales_order[]" value="{{$list_customer->id}}"></td>
                                                        @else
                                                            <td style="width: 2%;"><center><span style='background-color:TOMATO' class='label'>Disabled</span></center></td>
                                                        @endif
                                                        <td style="width: 11%;">{{$list_customer->order_id}}</td>
                                                        <td style="width: 16%;">{{$list_customer->customers_warehouse->name}}</td>
                                                        <td style="width: 12%;">{{$list_customer->sub_service->name}}</td>
                                                        <td style="width: 10%;">{{$list_customer->contract_no}}</td>
                                                        <td style="width: 7%;">{{$list_customer->volume}}</td>
                                                        <td style="width: 7%;">{{number_format($list_customer->rate,0)}}</td>
                                                        <td style="width: 7%;">{{number_format($list_customer->total_rate,0)}}</td>
                                                        <td style="width: 7%;">{{$list_customer->created_at}}</td>
                                                        {{-- <td style="width: 7%;">{{$list_customer->users['name']}}</td> --}}
                                                        @if ($list_customer->warehouse_o_status->status_name == 'draft')
                                                        <td style="width: 5%;">
                                                                <span>
                                                                    <button id="draftds" style="background-color:gray;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                        data-id="{{ $list_customer->order_id }}"
                                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                        {{$list_customer->warehouse_o_status->status_name}}
                                                                    </button>
                                                                </span>
                                                            </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'process')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:GOLD;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:DODGERBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'done')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="dones" style="background-color:green;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $lsist_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="cancels" style="background-color:red;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'pod')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="pods" style="background-color:brown;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'paid')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:green;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" style data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'upload')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="uploaded" style="background-color:orange;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        <td style="width: 9%;">
                                                                @if ($list_customer->warehouse_o_status->status_name == 'draft')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail ordercx" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    {{-- <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                                                data-target="#ModalStatusOrder" data-toggle="modal" data-original-title="Status Order"
                                                                                data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div> --}}
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'process')
                                                                <div class="row-fluid">
                                                                    <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                         data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                                          data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                {{-- <div class="row-fluid">
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                                    <i class="far fa-eye"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div> --}}
                                                                        </div>
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'done')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'pod')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                                data-original-title="Pemberitahuan sistem"
                                                                                data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'paid')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button readOnly="true" class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left" 
                                                                            data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                        <div class="span5">
                                                                            <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                                data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                                data-trigger="hover" data-placement="bottom" data-content="Historys Order Status">
                                                                                <i class="far fa-eye"></i>
                                                                        </button>
                                                                        </div>
                                                                    </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'upload')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"   
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div>
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                                                data-target="#ModalStatusOrder" data-toggle="modal" data-original-title="Status Order"
                                                                                data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                @else
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endfor
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                        </div>
                <div class="modal fade" id="ModalStatusOrder" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Update your status order</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="update_data_status_whs">
                        <br />
                        {{-- in progress updated vendor --}}
                        <div class="control-group">
                                <label class="control-label" style="text-align: end">Update Status</label>
                                <div class="controls">
                                    <select class="updated_status_warehouse_whs form-control validate[required]" style="width:250px;" id="updated_status_warehouse" name="updated_status_warehouse">
                                </select>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    {{-- show detail modal --}}
                    <div class="modal fade" id="ModalDataOrderTrack" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                    aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="headernya" id="myModalWarehouse">Tracking History Order [ Warehouse ] - </h3>
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
                            {{-- in progress updated vendor --}}
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
@endsection
@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
 <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>

 {{-- <script src="https://cdn.jsdelivr.net/jquery/1.11.3/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    @include('sweetalert::view')
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
   <!--script for this page only-->
   <script src="{{ asset('js/warehouse_t_list.js') }}"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">
$("#paids").css("background","#27AE60");
$("#paidssx").css("background","#0E6655");
$("#canceled").css("background","#E74C3C");
$("#draftds").css("background","#808080");
$("#drft").css("background","#808080");
$("#dones").css("background","#F6CB2D");
$("#processed").css("background","#FFD700");
$("#uploaded").css("background","#F39C12");
$("#invoice").css("background","#3498DB");
$("#invoiced").css("background","#3498DB");
window.history.forward();
             function noBack() { 
                  window.history.forward(); 
             }


$('.dtbranchchoosen').select2({
                    placeholder: 'Choose Branch',
                    ajax: {
                    url: '/load-company-branch-with-super-user/find/'+8,
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

 $('#new_customer').on('click',function(e){
            $('<a href="#" class="show-pop data-placement="auto-bottom" data-title="Dynamic Title" data-content="Dynamic content"> Dynamic created Pop </a>').appendTo('.pops');
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

    $(function() {
        $("#datepickerfrom").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
    
    $(function() {
        $("#datepickerto").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    $().ready(function(e) {

var popupEvent = function() {
}

$('#popupReturn').hunterPopup({
    width: '90px',
    height: '40px',
    // title: "jQuery hunterPopup Demo",
    content: $('#tableContent'),
    event: popupEvent
});

});     
        $(function () {
            $(".ModalStatusClass").click(function (e) {
            e.preventDefault();
                let status_order_id = $(this).data('id');
                $.get('/updated-status-name-order-whs-ops/'+ status_order_id, function(showingdatastatus){
                $("#update_data_status_whs").attr('action', '/updated-status-order/'+status_order_id);

                        $('.updated_status_warehouse_whs').select2({
                            placeholder: 'Cari...',
                            ajax: {
                                url: '/load-status-order-warehouse/'+status_order_id,
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
                })
            });

        $(function () {
            $(".ModalShowDataHistoryOrder").click(function (e) {
            e.preventDefault();
            const tBody = $("#TableHistory > TBODY")[0];

                let histroy_log_idx = $(this).data('id');
                var trHTML = '';
                $('#myModalWarehouse').text('Tracking History Order [ Warehouse ] - '+histroy_log_idx);
                $.get('/history-find-it-details/'+histroy_log_idx, function(showingdatastatus){

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
                                    const arrayStatus = entry.toString();
                                    // if (entry==2 || entry==8) {
                                        // dh = dump(entry,"6","Terupload")
                                        // https://htmlcolorcodes.com/color-names/
                                        his = arrayStatus.replace("1","<center><span style='background-color:gray' class='label'>Draft</span></center>")
                                        ketiga = arrayStatus.replace("2","<center><span style='background-color:GOLD' class='label'>Process</span></center>")
                                        pod = arrayStatus.replace("3","<center><span style='background-color:DEEPSKYBLUE' class='label'>Invoice</span></center>")
                                        dh = arrayStatus.replace("4","<center><span class='label'>Complete</span></center>")
                                        ds = arrayStatus.replace("5","<center><span style='background-color:red' class='label'>Canceled</span></center>")
                                        dsjo = arrayStatus.replace("6","<center><span style='background-color:orange' class='label'>Uploaded</span></center>")
                                        dsko = arrayStatus.replace("7","<center><span class='label btn-neutral'>POD</span></center>")
                                        sdasdf = arrayStatus.replace("8","<center><span style='background-color:green' class='label'>Paid</span></center>")
                                        // pod = dump(entry,"7","Process on delivery")
                                        // ketiga = dump(entry,"3","Invoice")
                                        // dsjo = dump(entry,"1","Document baru")
                                        // dsko = dump(entry,"4","Proses Selesai")
                                        // his = dump(entry,"5","Proses dibatalkan")
                                        // ds = dump(entry,"2","Masih Proses")
                                        // bs = dump(entry,"8","Transaksi sudah dilunasis")
                                        // let sdkos = ds,bs,his,dsko,dsjo,ketiga,pod,dh;
                                        let sd = dh.concat(ds,pod,ketiga,his,dsjo,dsko,sdasdf);
                                        let done = sd.replace(/[0-8]/g, '')

                                        // str += '<ul>' + sd + '</ul>';
                                        // for(let i = 0; i < sd.length; i++){
                                        // str += '<ul class="fa-ul"><br/><li><span class="fa-li"></span>'+ done +'</li></ul>';
                                        // str += '<ul class="fa-ul">&nbsp;<li><span class="fa-li"></span>'+ done +'</li></ul>';
                                        // str += '<ul class="fa-ul">'+ done +'</li></ul>';
                                        // str += '<div><ul>'+ done +'</ul></div>';
                                        str += '<ul style=""><li style="display:none"></li><div style="width:117px;z-index: -1;border-left: 1px dashed gray;height: 20px;">'+ done +'</div></ul>';

                                        // str += '<ul class="fa-ul"><li></center><span class="fa-li"></span>&nbsp;<center>' + done + '</center></li></ul>';
                                // }
                                // return str;

                                        // }

                                        // if (entry==8) {
                                        //     // dh = dump(entry,"6","Terupload")
                                        //     ds = entry.replace("8","Telah dibayar lunas")
                                        //     // pod = dump(entry,"7","Process on delivery")
                                        //     // ketiga = dump(entry,"3"s,"Invoice")
                                        //     // dsjo = dump(entry,"1","Document baru")
                                        //     // dsko = dump(entry,"4","Proses Selesai")
                                        //     // his = dump(entry,"5","Proses dibatalkan")
                                        //     // ds = dump(entry,"2","Masih Proses")
                                        //     // bs = dump(entry,"8","Transaksi sudah dilunasi")
                                        //     // let sdkos = ds,bs,his,dsko,dsjo,ketiga,pod,dh;
                                        //     let paid = ds;
                                        //     str += '<ul>' + paid + '</ul>';

                                        // }
                                                                            
                                        // console.log(entry)
                                       
                                    });

                                        return str;
                                    }

                            let tolistnextcellsdasd = function(arr){
                                let str = '';
                                for(let i = 0; i < arr.length; i++){
                                    // str += '<ul class="fa-ul"><br/><li><span class="fa-li"></span>'+ arr[i] +'</li></ul>';
                                    // str += '<ul class="fa-ul">&nbsp;<li><span class="fa-li"></span>'+ arr[i] +'</li></ul>';
                                    str += '<ul>'+ arr[i] +'</ul>';
                                    // str += '<ul class="fa-ul"><li><center>Order ID&nbsp;</center><span class="fa-li" ></center><i class="fas fa-check-square">&nbsp;<span class="label label" style="color:brown">' + arr[i] + '</span></i></li></ul>';
                                }
                                return str;
                            }
                                    let tolisterusername = function(arr){
                                        let str = '';
                                        for(let i = 0; i < arr.length; i++){
                                            // str += '<div><br/>'+ arr[i] +'</div>';
                                            str += '<div><ul>'+ arr[i] +'</ul></div>';

                                            // str += '<ul class="fa-ul">&nbsp;<li><span class="fa-li"></span>'+ arr[i] +'</li></ul>';
                                            // str += '<ul class="fa-ul"><li><center>Username<br/></center><span class="fa-li"></span><i class="fas fa-check-square"><br/><span class="label label" style="color:brown">' + arr[i] + '</span></i></span></li></ul>';
                                        }
                                        return str;
                                    }

                                    let tolistwarehouse = function(arr){
                                        let str = '';
                                        for(let i = 0; i < arr.length; i++){
                                            // str += '<div><br/>'+ arr[i] +'</div>';
                                            str += '<div><ul>'+ arr[i] +'</ul></div>';

                                            // str += '<ul class="fa-ul">&nbsp;<li><span class="fa-li"></span>'+ arr[i] +'</li></ul>';
                                            // str += '<ul class="fa-ul"><li><center>Username<br/></center><span class="fa-li"></span><i class="fas fa-check-square"><br/><span class="label label" style="color:brown">' + arr[i] + '</span></i></span></li></ul>';
                                        }
                                        return str;
                                    }

                        for (i = 0; i < showingdatastatus.length; i++) {

                            arrfsc[i] = showingdatastatus[i];

                            }

                            let rdatatcxz3 = [];
                            let rdatatcxz0 = [];
                            let warehouse = [];
                            let rdatatcxz1 = [];
                            let rdatatcxz2 = [];
                            let dasdzsds = [];
                            let asdasd = Array();

                            for (i = 0; i < arrfsc.length; i++) {

                                rdatatcxz0.push(arrfsc[i]['order_id']);
                                rdatatcxz1.push(arrfsc[i]['status']);
                                rdatatcxz2.push(arrfsc[i]['datetime']);
                                rdatatcxz3.push(arrfsc[i]['user_order_history']['name']);
                                // warehouse.push(arrfsc[i]['order_id']);

                            }
                            // tolistnextcellsdasd(rdatatcxz0)
                            $('#modals').html('<td><div style="margin-left:92px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>')
                                // +'<td><hr/><center><label>Order ID</label></center><hr /><div>'+'&nbsp;'+tolistwarehouse(warehouse)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Fira Code">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });
  
</script>
@endsection

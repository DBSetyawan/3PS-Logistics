@extends('admin.layouts.master', array(['data_xml' => session()->get('data_xml')]))
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
    <a href="#">XML file details</a>
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
        <div class="widget-body">
            <div style="text-align:left;">
                <div style="text-align:right;">
                    </div>
                    @if ($data_table_xml->id_table == 0)
                    {{-- data for list warehouse --}}
                        <table class="table table-striped table-bordered table-striped" id="sample_1">
                            <thead>
                                <tr>
                                    <th bgcolor="#FAFAFA">[WHS]Order ID</th>
                                    <th bgcolor="#FAFAFA">Customer Name</th>
                                    <th bgcolor="#FAFAFA">Sub Services</th>
                                    <th bgcolor="#FAFAFA">Contract Number</th>
                                    <th bgcolor="#FAFAFA">Volume</th>
                                    <th bgcolor="#FAFAFA">Rate</th>
                                    <th bgcolor="#FAFAFA">Total Rate</th>
                                    {{-- <th bgcolor="#FAFAFA">Made by users</th> --}}
                                    <th bgcolor="#FAFAFA">Status Order</th>
                                    <th bgcolor="#FAFAFA">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            {{-- @for ($i = 0; $i < $id_auto; $i++) --}}
                            @foreach($warehouseTolist as $list_customer)
                                <tr class="odd gradeX">
                                    <td style="width: 11%;">{{$list_customer->order_id}}</td>
                                    {{-- <td style="width: 5%;"><div style="text-transform:uppercase">{{++$i}}</div></td> --}}
                                    <td style="width: 16%;">{{$list_customer->customers_warehouse->name}}</td>
                                    <td style="width: 12%;">{{$list_customer->sub_service->name}}</td>
                                    <td style="width: 10%;">{{$list_customer->contract_no}}</td>
                                    <td style="width: 7%;">{{$list_customer->volume}}</td>
                                    <td style="width: 7%;">{{$list_customer->rate}}</td>
                                    <td style="width: 7%;">{{number_format($list_customer->total_rate,0)}}</td>
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
                                            <button id="invoice" style="background-color:blue;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
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
                                            <button id="paidssx" style="background-color:green;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
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
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                    data-trigger="hover" data-placement="bottom" data-content="Maaf anda tidak punya akses menghubah statusnya">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'process')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                    data-target="#ModalShowDataHistoryOrder" data-toggle="modal" data-original-title="Status Order"
                                                    data-trigger="hover" data-placement="bottom" data-content="You can updated status order here">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                    data-target="#ModalShowDataHistoryOrder" data-toggle="modal" data-original-title="Status Order"
                                                    data-trigger="hover" data-placement="bottom" data-content="You can updated status order here">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'done')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                    data-trigger="hover" data-placement="bottom" data-content="Maaf anda tidak punya akses menghubah statusnya">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                    data-trigger="hover" data-placement="bottom" data-content="Maaf anda tidak punya akses menghubah statusnya">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'pod')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                    data-target="#ModalShowDataHistoryOrder" data-toggle="modal" data-original-title="Status Order"
                                                    data-trigger="hover" data-placement="bottom" data-content="You can updated status order here">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'paid')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                    data-trigger="hover" data-placement="bottom" data-content="Maaf anda tidak punya akses menghubah statusnya">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                            @else
                                        @endif
                                        @if ($list_customer->warehouse_o_status->status_name == 'upload')
                                        <div class="row-fluid">
                                            <div class="span4">
                                                <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'"
                                                data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                            </div>
                                            <div class="span5">
                                                <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                    data-trigger="hover" data-placement="bottom" data-content="Maaf anda tidak punya akses menghubah statusnya">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </div>
                                                {{-- <div class="span4">
                                                    <button class="btn popovers btn-small btn-success ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                        <i class="far fa-eye"></i>
                                                </button>
                                                </div> --}}
                                            </div>
                                        @else
                                    @endif
                                    </td>
                                </tr>
                            @endforeach()
                        {{-- @endfor --}}
                        </tbody>
                    </table>
                </form>
                @endif
                <div class="modal fade" id="ModalShowDataHistoryOrder" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Update your status order</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="update_data_status_whs">
                            <input type="hidden" class="input-block-level validate[required]" style="width:320px" id="id_xml" value="{{ $data_table_xml->id }}"  name="id_xml">
                        <br />
                        {{-- in progress updated vendor --}}
                        <div class="control-group">
                                <label class="control-label" style="text-align: end">Update Statussds</label>
                                <div class="controls">
                                    <select class="updatestatuswarehouse form-control validate[required]" style="width:250px;" id="updated_status_warehouse" name="updated_status_warehouse">
                               
                                </select>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                @if ($data_table_xml->id_table == 1)
                {{-- data for transports --}}
                <table class="table table-striped table-bordered table-striped" id="sample_1">
                    <thead>
                        <tr>
                            <th bgcolor="#FAFAFA">Code</th>
                            <th bgcolor="#FAFAFA">Customer</th>
                            <th bgcolor="#FAFAFA">Collie</th>
                            <th bgcolor="#FAFAFA">A.W(kg)</th>
                            <th bgcolor="#FAFAFA">C.W(kg)</th>
                            <th bgcolor="#FAFAFA">Origin Details</th>
                            <th bgcolor="#FAFAFA">Destination Details</th>
                            <th bgcolor="#FAFAFA">Date-Time</th>
                            <th bgcolor="#FAFAFA">status</th>

                            <th bgcolor="#FAFAFA">Created By</th>
                            <th bgcolor="#FAFAFA">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($data_transport as $transport_order_lists)
                        <tr class="odd gradeX">
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
                                    <span type="button" style="background-color:MIDNIGHTBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrdertc" 
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
                                    <span type="button" style="background-color:REBECCAPURPLE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrdertc" 
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
                                    <span type="button" style="background-color:CORAL;color:white" class="btn popovers btn-small ModalShowDataHistoryOrdertc" 
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
                                    <span type="button" style="background-color:DEEPSKYBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrdertc" 
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
                                    <span type="button" style="background-color:FORESTGREEN;color:white" class="btn popovers btn-small ModalShowDataHistoryOrdertc" 
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
                            <td style="width: 7%;">
                            <div class="row-fluid">
                                    <div class="span5">
                                            <button class="btn popovers btn-small btn-info ModalStatusAccoutingTC"  data-id="{{ $transport_order_lists->id }}" 
                                                data-target="#ModalStatusAccoutingTC" style data-toggle="modal" data-original-title="Pemberitahuan system"
                                                data-trigger="hover" data-placement="bottom" data-content="Update status ke [New]">
                                                <i class="icon-pencil"></i>
                                            </button>
                                        </div>
                                {{-- <div class="span5">
                                        <button onclick="location.href='{{ route('transport.show',$transport_order_lists->id) }}'"
                                             class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                        data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                         data-content="Detail data transport order">
                                           <i class="icon-file"></i>
                                       </button>
                                    {{-- <button  data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                {{-- </div> --}}
                                &nbsp;
                                {{-- <div class="span5">
                                        <a href="{{ route('surat_jalan_transports', $transport_order_lists->order_id) }}"
                                            target="_blank" class="btn popovers btn-small ColorsC ModalStatusClass" data-toggle="modal" 
                                           data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                            data-content="Reports Shipper IzzyTransport[ Progress ]">
                                            <i class="fas fa-road"></i>
                                          </a>
                                    {{-- <button onclick="location.href=''" data-original-title="Surat Jalan" data-placement="left" class="btn tooltips btn-small btn-success" type="button"><i class="icon-cloud-download"></i></button> --}}
                                {{-- </div>  --}}
                            </div>
                            </td>
                        </tr>
                        @endforeach()
                    </tbody>
                </table>
        </form>
        @endif
            <div class="modal fade" id="ModalStatusAccoutingTC" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Update your status order</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="update_data_transports">
                            <input type="hidden" class="input-block-level validate[required]" style="width:320px" id="id_xml" value="{{ $data_table_xml->id }}"  name="id_xml">
                               
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
@endsection
@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
 {{-- <script src="https://cdn.jsdelivr.net/jquery/1.11.3/jquery.min.js"></script> --}}

<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    @include('sweetalert::view')
   <!-- Load javascripts at bottom, this will reduce page load time -->
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
  <!--script for this page only-->
  <script src="{{ asset('js/data_xml_list.js') }}"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">

    $("#paids").css("background","#27AE60");
    $("#paidssx").css("background","#0E6655");
    $("#canceled").css("background","#E74C3C");
    $("#draftds").css("background","#808080");
    $("#drft").css("background","#808080");
    $("#dones").css("background","#F6CB2D");
    $("#processed").css("background","#F7DC6F");
    $("#processedx").css("background","#F7DC6F");
    $("#uploaded").css("background","#F39C12");
    $("#invoice").css("background","#3498DB");

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
        $(".ModalStatusAccoutingTC").click(function (e) {
        e.preventDefault();
            let id_shipment = $(this).data('id');
            $("#update_data_transports").attr('action', '/updated-transport-status-order/'+id_shipment);
            $.get('/get-val-status-shipments-find/shipment/'+id_shipment, function(xcx){
                let arrfsc = new Array();

                for (i = 0; i < xcx.length; i++) {

                    arrfsc[i] = xcx[i];

                    }

                    let rdatatcxz = [];
                    let status = [];

                    for (i = 0; i < arrfsc.length; i++) {

                        rdatatcxz.push(arrfsc[i]);

                    }
                    let populateList = function(arr){
                        let str = '';
                        
                            for(let iz = 0; iz < arr.length; iz++){

                                str += arr[iz]['cek_status_transaction']['status_name'];

                            }

                        return str;
                    
                    }
                    $('.updated_status_warehouse_whs').select2({
                        placeholder: 'Cari...',
                        "language": {
                            "noResults": function(){
                                
                                return 'Maaf data tidak ada, Hanya shipment yang berstatus upload yang dapat di'+populateList(rdatatcxz)

                            }

                        },
                             ajax: {
                                url: '/load-status-order-transport-perfiles/'+id_shipment,
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
            $(".ModalStatusClass").click(function (e) {
            e.preventDefault();
                let status_order_id = $(this).data('id');
                $.get('/updated-status-name-order-whs-ops/'+ status_order_id, function(showingdatastatus){
                $("#update_data_status_whs").attr('action', '/updated-status-order/'+status_order_id);

                        $('.updatestatuswarehouse').select2({
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
                                        // bs = dump(entry,"8","Transaksi sudah dilunasi")
                                        // let sdkos = ds,bs,his,dsko,dsjo,ketiga,pod,dh;
                                        let sd = dh.concat(ds,pod,ketiga,his,dsjo,dsko,sdasdf);
                                        let done = sd.replace(/[0-8]/g, '')
                                        // str += '<ul>' + sd + '</ul>';
                                        // for(let i = 0; i < sd.length; i++){
                                        // str += '<ul class="fa-ul"><br/><li><span class="fa-li"></span>'+ done +'</li></ul>';
                                        // str += '<ul class="fa-ul">&nbsp;<li><span class="fa-li"></span>'+ done +'</li></ul>';
                                        // str += '<ul class="fa-ul">'+ done +'</li></ul>';
                                        // str += '<div><ul>'+ done +'</ul></div>';
                                        str += '<ul style=""><li style="display:none"></li><div style="width:90px;z-index: -1;border-left: 1px dashed gray;height: 20px;">'+ done +'</div></ul>';
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

                        for (i = 0; i < showingdatastatus.length; i++) {

                            arrfsc[i] = showingdatastatus[i];

                            }

                            let rdatatcxz3 = [];
                            let rdatatcxz0 = [];
                            let rdatatcxz1 = [];
                            let rdatatcxz2 = [];
                            let dasdzsds = [];
                            let asdasd = Array();

                            for (i = 0; i < arrfsc.length; i++) {

                                rdatatcxz0.push(arrfsc[i]['order_id']);
                                rdatatcxz1.push(arrfsc[i]['status']);
                                rdatatcxz2.push(arrfsc[i]['datetime']);
                                rdatatcxz3.push(arrfsc[i]['user_order_history']['name']);

                            }
                            // console.log()
                            // tolistnextcellsdasd(rdatatcxz0)
                            $('#modals').html('<td><div style="margin-left:95px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Fira Code">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });


        $(function () {
            $(".ModalShowDataHistoryOrdertc").click(function (e) {
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
                                        ketiga = arrayTCstatus.replace("2","<center><span style='background-color:REBECCAPURPLE' class='label'>Proses</span></center>")
                                        pod = arrayTCstatus.replace("3","<center><span  class='label'>Invoice</span></center>")
                                        dh = arrayTCstatus.replace("4","<center><span style='background-color:FORESTGREEN' class='label'>done</span></center>")
                                        ds = arrayTCstatus.replace("5","<center><span style='background-color:red' class='label'>Canceled</span></center>")
                                        dsjo = arrayTCstatus.replace("6","<center><span style='background-color:CORAL' class='label'>Upload</span></center>")
                                        dsko = arrayTCstatus.replace("7","<center><span class='label btn-neutral'>POD</span></center>")
                                        sdasdf = arrayTCstatus.replace("8","<center><span style='background-color:DEEPSKYBLUE' class='label'>New</span></center>")
                                        let sd = dh.concat(ds,pod,ketiga,his,dsjo,dsko,sdasdf);
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

                        for (i = 0; i < showingdatastatus.length; i++) {

                            arrfsc[i] = showingdatastatus[i];

                            }
                            
                            let rdatatcxz3 = [];
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

                            }
                                        
                            $('#modals').html('<td><div style="margin-left:95px"><hr/><center><strong><label>Status Order</label></strong></center><hr /><div>'+'&nbsp;'+tolistnextcell(rdatatcxz1)+'</div></td>'
                                +'<td><hr/><center><label>Created Date at</label></center><hr /><div>'+'&nbsp;'+populateList(rdatatcxz2)+'</div></td>'
                                +'<td><hr/><center><label>Created By</label></center><hr /><div>'+'&nbsp;'+tolisterusername(rdatatcxz3)+'</div><div></div></div></td>')
                            } else {
                         
                                $('#modals').html('<img src="{{ asset("../img/empty.png")}}" style="display: block;margin-left: auto;margin-right: auto;"><br/><center><font face="Fira Code">Maaf history pada order ini masih kosong</font></center>')
                                
                        }
                    }
                );
            })
        });
</script>
@endsection

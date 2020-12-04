@extends('admin.layouts.master', array(['id_transport' => session()->get('id_transport')]))
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/nprogress.css') }}" rel="stylesheet" />
<link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/hunterPopup.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/like-yt.css') }}" />
<link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
<link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
<link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
<link href="{{ asset('css/datergpickercstm.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
@notifyCss
@endsection
@section('brand')

<a class="brand" href="/home">
    {{-- <img src="../img/logo.png" alt="Tiga Permata System" /> --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="/transport-list">Transport Order List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
    <span class="divider">/</span>

</li>
<li class="active">
    {{ $data_transport->customers->name }}
</li>
@endsection

@section('content')

<div id="main-content" style="height: 1321px;">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        {{-- <a href="javascript:;" class="btn btn-success" id="add-sticky">Sticky</a> --}}
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
        @include('flash::message')
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        @if (\Session::has('error'))
        <div class="alert alert-danger">
          <p>{{ \Session::get('error') }}</p>
        </div>
       @endif
        <div id="progress" class="waiting">
            <dt></dt>
            <dd></dd>
        </div>
{{-- <p class="animated infinite bounce delay-5s">ekodaskdoaskdo</p> --}}
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
                        <form action="{{route('transport.update', $transport_list->id)}}" class="form-horizontal" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                            <input type="hidden" name="code_id" value="{{ $transport_list->order_id }}" class="span12 " />
                            {{ method_field('PUT') }}
                            <div id="tabsleft" class="tabbable tabs-left">
                                <ul>
                                    <li><a href="#tabsleft-tab1" data-toggle="tab"><span class="strong">Transport Information</span> <span class="muted">Information Service<div>Service Customer Details</div></span></a></li>
                                    <li><a href="#tabsleft-tab2" data-toggle="tab"><span class="strong">Transport Registration</span> <span class="muted">Transport <div>Transport Order Details</div></span></a></a></li>
                                </ul>
                                <div class="progress progress-info progress-striped">
                                    <div class="bar"></div>
                                </div>
                                <div class="tab-content">
                                @if ($errors->any())
                                        <div class="alert alert-danger" id="inputDetailTransport">
                                            <strong>Terjadi kesalahan!</strong> Coba periksa kembali inputan anda.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="tab-pane" id="tabsleft-tab1">
                                    <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Company Branch</label>
                                                    <div class="controls">
                                                        <label style="color: black;font-family: Fira Code">{{ $prefix->branch}}</label>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span6">
                                            <div class="control-group">
                                                {{-- <label id="customers_errors" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Customer harus wajib diisi.." data-original-title="Informasi User" ></i></label> --}}
                                                <label class="control-label">Customer Name</label>
                                                <div class="controls">  
                                                    <select class="customer_names form-control validate[required]" id="customers_name" style="width:318px;" name="customers_name">
                                                        {{-- <option value="{{$data_transport->customers->id}}" selected="{{$data_transport->customers->id}}">{{$data_transport->customers->name}}</option> --}}
                                                        @foreach($customers as $a)
                                                            <option value="{{ $a->id }}" @if($a->id==$data_transport->customer_id) selected='selected' @endif >{{ $a->name }}</option>
                                                        @endforeach()
                                                    </select>
                                                    {{-- <div class="row-fluid">
                                                        <br />
                                                            <div class="span12">
                                                                <div style="text-align:end">
                                                                <a id="new_customer" type="button" class="btn btn-success popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a>
                                                         </div>
                                                       </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label"></label>
                                                <div class="controls controls-row">
                                                    <input type="hidden" class="input-block-level validate[required]" placeholder="Enter Origin PIC PHONE" id="id_project"  name="id_project" required>
                                                </div>
                                            </div>
                                        </div>
                                            {{-- <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Customer Name PIC</label>
                                                    <div class="controls"> 
                                                        <select class="customerpics_name form-control validate[required]" id="customerpics_name" style="width:280px;" name="customerpics_name">
                                                            {{-- <option value="{{$warehouseTolist->customers_warehouse->id}}"
                                                                selected="{{$warehouseTolist->customers_warehouse->director}}">{{$warehouseTolist->customers_warehouse->director}}</option>
                                                            --}}
                                                        {{-- </select>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <br> --}}
                                                                    {{-- @if ($errors->has('customers_name'))
                                                                <span id="customers_name_error" class="alert alert-danger span12" style="width:300px;text-align: center">{{ $errors->first('customerpics_name') }}</span>
                                                            @endif --}}
                                                        {{-- </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                <br />
                               {{--  --}}
                                </div>
                                <div class="tab-pane" id="tabsleft-tab2">
                                            <div class="row-fluid">
                                                    <div class="span12">
                                                        <hr>
                                                    </div>
                                                </div>
                                                 {{-- <div class="row-fluid">
                                                    <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label">Customer</label>
                                                                <div class="controls">
                                                                    <select class="form-control validate[required]" id="project_id" style="width:301px;" name="project_id">
                                                                      @foreach ($data_array as $item)
                                                                          <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                                      @endforeach
                                                                    </select>
                                                                    <div class="row-fluid">
                                                                        <div class="span8">
                                                                            <br>
                                                                    {{-- @if ($errors->has('items'))
                                                                            <span id="items_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('items') }}</span>
                                                                        @endif --}}
                                                                    {{-- </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <label class="control-label" style="font-family: 'Courier', monospace;font-size:16px;font: bold;"><strong>Detail&nbsp;Transport</strong></label>
                                                            <div class="controls">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Saved Origin</label>
                                                        <div class="controls">
                                                            {{-- {{ $data_transport->saved_origin_id }} --}}
                                                            <select data-placeholder="Saved Origin" style="width:304px" class="saved_origin" name="saved_origin" id="saved_origin">
                                                                @foreach($address as $a)
                                                                    <option value="{{ $a->id }}" @if($a->id==$data_transport->saved_origin_id) selected='selected' @endif >{{ $a->name }}</option>
                                                                @endforeach()
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="span4">
                                                    <div class="control-group">
                                                        <label class="control-label">Saved Destination</label>
                                                        <div class="controls">
                                                            <select data-placeholder="Saved Destination" style="width:304px" class="saved_destination validate[required]" tabindex="-1" name="saved_destination" id="saved_destination">
                                                                @foreach($address as $a)
                                                                    <option value="{{ $a->id }}" @if($a->id==$data_transport->saved_destination_id) selected='selected' @endif >{{ $a->name }}</option>
                                                                @endforeach()
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                           <label id="origin_error" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                           {{-- <label class="control-label" >Origin</label> --}}
                                                           <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" maxlength="40" value="{{ $data_transport->origin }}" placeholder="Enter Origin" id="origin" name="origin">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Origin</label>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                           <label id="destination_error" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            {{-- <label class="control-label" >Destination</label> --}}
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" maxlength="40" value="{{ $data_transport->destination }}" placeholder="Enter Destination" id="destination"  name="destination">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Destination</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Origin Details</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->origin_details }}" placeholder="Enter Origin Details" id="origin_detail"  name="origin_detail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Destination Details</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->destination_details }}" placeholder="Enter Destination Details" id="destination_detail"  name="destination_detail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="row-fluid">
                                                        <div class="span6">
                                                                <div class="control-group">
                                                                    {{-- <label class="control-label">Origin City</label> --}}
                                                                    <label style="position:absolute;margin:8px 14px">Origin City</label>
                                                                    {{-- <div class="controls controls-row">
                                                                        <input type="text" class="input-block-level" placeholder="Enter Origin City" id="origin_city" name="origin_city">
                                                                    </div> --}}
                                                                    @php
                                                                       $check_key = isset($data_transport->itemtransports->origin) ? $data_transport->itemtransports->origin : 0; 
                                                                    @endphp
                                                                    <div class="controls controls-row">
                                                                    <select class="loader_city validate[required]" id="origin_city" style="width:305px;" name="origin_city">
                                                                        @foreach($global_city as $a)
                                                                            <option value="{{ $a->id }}" @if($a->id==$check_key) selected='selected' @endif >{{ $a->name }}</option>
                                                                        @endforeach()
                                                                     </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                {{-- <label class="control-label" >Destination City</label> --}}
                                                                <label style="position:absolute;margin:5px 14px">Destination City</label>
                                                                @php
                                                                $check_keys = isset($data_transport->itemtransports->destination) ? $data_transport->itemtransports->destination : 0; 
                                                             @endphp
                                                                <div class="controls controls-row">
                                                                    <select class="loader_city validate[required]" id="destination_city" style="width:304px;" name="destination_city">
                                                                        @foreach($global_city as $a)
                                                                            <option value="{{ $a->id }}" @if($a->id==$check_keys) selected='selected' @endif >{{ $a->name }}</option>
                                                                        @endforeach()
                                                                    </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid" hidden>
                                                    <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label" >Id Origin City</label>
                                                                <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level" placeholder="Enter Origin City" id="id_origin_city" name="id_origin_city">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Id Destination City</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" placeholder="Enter Destination City" id="id_destination_city" name="id_destination_city">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label id="origin_address_error" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Adrress harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            {{-- <label class="control-label" >Origin Address</label> --}}
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->origin_address }}" placeholder="Enter Origin Address" id="origin_address"  name="origin_address">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Origin Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label id="destination_address_error" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Destination Adrress harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            {{-- <label class="control-label" >Destination Address</label> --}}
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->destination_address }}" placeholder="Enter Destination Address" id="destination_address"  name="destination_address">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Destination Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label" >Origin Contact</label>
                                                                <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->origin_contact }}" placeholder="Enter Contact Origin" id="origin_contact"  name="origin_contact">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label" >Destination Contact</label>
                                                                <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->destination_contact }}" placeholder="Enter Contact Destination" id="destination_contact"  name="destination_contact">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                {{-- <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label">Origin Phone</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->origin_phone }}" placeholder="Enter Origin Phone Number" id="origin_phone"  name="origin_phone">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Destination Phone</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->destination_phone }}" placeholder="Enter Destination Phone Number" id="destination_phone"  name="destination_phone">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label id="pic_phone_origin_errors" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Pic Phone harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                {{-- <label class="control-label">Origin Phone</label> --}}
                                                                <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->pic_phone_origin }}" placeholder="Enter Origin PIC PHONE" id="pic_phone_origin"  name="pic_phone_origin">
                                                                </div>
                                                                <label style="position: absolute;margin:-20px 13px;">Origin Phone</label>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                        <div class="control-group">
                                                            <label id="pic_phone_destination_errors" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Pic Phone harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            {{-- <label class="control-label">Destination Phone</label> --}}
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->pic_phone_destination }}" placeholder="Enter Destination PIC PHONE" id="pic_phone_destination"  name="pic_phone_destination">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Destination Phone</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label id="origin_pic_name_errors" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="PIC harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            {{-- <label class="control-label">Origin PIC Name</label> --}}
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->pic_name_origin }}" placeholder="Enter Origin PIC NAME" id="pic_name_origin"  name="pic_name_origin">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Origin PIC Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            {{-- <label class="control-label">Destination PIC Name</label> --}}
                                                            <label id="destination_pic_name_errors" class="control-label error"><i class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="PIC harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level validate[required]" value="{{ $data_transport->pic_name_destination }}" placeholder="Enter Destination PIC NAME" id="pic_name_destination"  name="pic_name_destination">
                                                            </div>
                                                            <label style="position: absolute;margin:-20px 13px;">Destination PIC Name</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <hr>
                                                    </div>
                                                </div>
                                                    <div class="row-fluid">
                                                            <div class="span12">
                                                                <div class="control-group">
                                                                    <label class="control-label" style="font-family: 'Courier', monospace;font-size:16px;font: bold;"> <strong>Detail&nbsp;Detail</strong></label>
                                                                    <div class="controls">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                                <div class="row-fluid">
                                                                        <div class="span9">
                                                                            <div class="control-group">
                                                                                <label class="control-label">Sub Service</label>
                                                                                    <div class="controls">
                                                                                        <select class="span12" data-placeholder="Sub Services" id="sub_servicess" selected="-1" style="width:320px;" name="sub_servicess">
                                                                                            @foreach($global_sub_services as $a)
                                                                                                <option value="{{ $a->id }}" @if($a->id==$data_transport->item_transport ) selected='selected' @endif >{{ $a->sub_services->name }}</option>
                                                                                            @endforeach()
                                                                                            {{-- <option value="{{$warehouseTolist->sub_service->id}}" selected="{{$warehouseTolist->sub_service->name}}">{{$warehouseTolist->sub_service->name}}</option>
                                                                                            --}}
                                                                                </select>
                                                                                {{-- <span class="add-on"><a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="" class="itemsadd btn btn-success"><i class="icon-plus"></i> Add Item</a></span> --}}
                                                                                {{-- <div class="row-fluid">
                                                                                    <div class="span8">
                                                                                        <br> --}}
                                                                                        {{-- @if ($errors->has('sub_services'))
                                                                                        <span id="ssrvcs_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('sub_services') }}</span>
                                                                                    @endif --}}
                                                                                {{-- </div>
                                                                            </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                    <div class="span8">
                                                                            <div class="control-group">
                                                                                <label class="control-label">Item</label>
                                                                                <div class="controls">
                                                                                    <select class="form-control itm" data-placeholder="Items" style="width:68%" id="items_tc" name="items_tc">
                                                                                        @foreach($global_sub_services as $a)
                                                                                            <option value="{{ $a->id }}" @if($a->id==$data_transport->item_transport ) selected='selected' @endif >{{ $a->itemovdesc }}</option>
                                                                                        @endforeach()
                                                                                    </select><span class="add-on"><a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="" class="itemsadd btn btn-success"><i class="icon-plus"></i> Add Item</a></span>
                                                                                    {{-- <span class="add-on"><a type="button" id="refresh" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Reload</a></span> --}}
                                                                                    <div class="row-fluid">
                                                                                        {{-- <div class="span8">
                                                                                            <br> --}}
                                                                                    {{-- @if ($errors->has('items'))
                                                                                            <span id="items_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('items') }}</span>
                                                                                        @endif --}}
                                                                                    {{-- </div> --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                    {{-- <div class="row-fluid">
                                                                            <div class="span6">
                                                                                    <div class="control-group">
                                                                                        <label class="control-label">Item</label>
                                                                                        <div class="controls controls-row">
                                                                                            <input type="text" id="items_tc" name="items_tc" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                    </div> --}}
                                                                </div>
                                                                <div class="row-fluid">
                                                                        <div class="span3">
                                                                            <div class="control-group">
                                                                                <label class="control-label">Quantity</label>
                                                                                <div class="controls">
                                                                                    <div class="input-prepend">
                                                                                        <input class="validate[required]" type="text" value="{{ $data_transport->quantity }}" style="width:135px;" placeholder="Enter Quantity" maxlength="5" id="qty" name="qty">
                                                                                        <span class="add-on">Pcs \ Unit \ Kg</i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                <div class="span3">
                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <div class="input-prepend input-append">
                                                                                    <span class="add-on">Rp</span><input class="validate[required]" type="text" value="{{ old('rate') }}" placeholder="Enter price" maxlength="14" id="rate" name="rate" style="width;235%">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span6">
                                                                            <div class="control-group">
                                                                                <div class="controls">
                                                                                    <div class="input-prepend">
                                                                                        <span class="add-on">Rp</i></span><input readonly="true" data-placement="top" class="popovers" data-trigger="hover" style="width:223px" data-content="Harga akhir" data-original-title="Informasi total harga"
                                                                                                type="text" maxlength="30" id="total_rate" name="total_rate" value="{{ $data_transport->total_cost }}" style="width;235%" placeholder="Total Harga" >
                                                                                            </div>
                                                                            </div>
                                                                      </div>
                                                                </div>
                                                                <b><span id="format"></span></b>
                                                            </div>
                                                    <div class="row-fluid">
                                                            <div class="span3">
                                                                <div class="control-group">
                                                                    <label class="control-label">ETD/ETA</label>
                                                                        <div class="controls">
                                                                            <div class="input-prepend">
                                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                                                <input readonly="enabled" class="etdrg validate[required]" type="text" value="{{ $data_transport->estimated_time_of_delivery }}" style="width:208px;" placeholder="Enter ETD" maxlength="5" id="etd" name="etd">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        <div class="span3">
                                                            <div class="control-group">
                                                                <div class="controls">
                                                                    <div class="input-prepend">
                                                                    <span class="add-on"><i class="icon-calendar" id="etdrange" onclick="rangedate()"></i></span>
                                                                    <input readonly="enabled" class="validate[required]" type="text" value="{{ $data_transport->estimated_time_of_arrival }}" maxlength="5" style="width:208px" placeholder="Enter ETA" id="eta" name="eta">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="span2">
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <select class="wibs input-small m-wrap" id="time_zone" name="time_zone">
                                                                            <option value="WIB">WIB</option>
                                                                            <option value="WITA">WITA</option>
                                                                            <option value="WIT">WIT</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">
                                                                <div class="span3">
                                                                    <div class="control-group">
                                                                        <label class="control-label">Information C\V\AW\CW</label>
                                                                            <div class="controls">
                                                                                <div class="input-prepend">
                                                                                    <input type="text" class="validate[required]" value="{{ $data_transport->collie }}" style="width:150px;" placeholder="Enter Collie" maxlength="5" id="collie" name="collie">
                                                                                    <span class="add-on">Unit</i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="span2">
                                                                            <div class="control-group">
                                                                                <div class="controls" style="margin-left:130px;margin-top: -0,5px;">
                                                                                    <div class="input-prepend">
                                                                                        <input type="text" class="validate[required]" value="{{ $data_transport->volume }}" maxlength="5" style="width:120px" placeholder="Enter Volume" id="volume" name="volume">
                                                                                    <span class="add-on">Volume</i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <div class="span2">
                                                                    <div class="control-group">
                                                                            <div class="controls" style="margin-left:157px;margin-top: -0,5px;">
                                                                            <div class="input-prepend">
                                                                                <input type="text" class="validate[required]" value="{{ $data_transport->actual_weight }}" maxlength="5" style="width:130px" placeholder="Enter Actual Weight" id="actual_weight" name="actual_weight">
                                                                            <span class="add-on">Kg</i></span>/
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="span2">
                                                                    <div class="control-group">
                                                                            <div class="controls" style="margin-left:165px;margin-top: -0,5px;">
                                                                            <div class="input-prepend">
                                                                            <input type="text" class="validate[required]" value="{{ $data_transport->chargeable_weight }}" maxlength="5" style="width:170px" placeholder="Enter Chargeable Weight" id="chargeable_weight" name="chargeable_weight">
                                                                            <span class="add-on">Kg</i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">
                                                                <div class="span11">
                                                                    <div class="control-group">
                                                                        <label class="control-label">
                                                                            Notes
                                                                        </label>
                                                                        <div class="controls">
                                                                            <textarea style="width:780px" id="notes" name="notes" rows="3">{{ $data_transport->notes }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12" style="text-align:right;">
                                                    <div class="form-actions" style="">
                                                        <button id="addorders" type="submit" class="btn btn-success">Update Your Order</button>
                                                        {{-- <a href="#myModal3" role="button" type="submit" class="btn btn-primary" data-toggle="modal">Confirm</a> --}}
                                                        <a class="btn btn-warning" href="{{ route('transport.static', $some) }}">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class=""></div>
                                            <ul class="pager wizard">
                                                <li class="previous first"><a href="javascript:;">First</a></li>
                                                <li class="previous"><a href="javascript:;">Previous</a></li>
                                                {{-- <li class="next last"><a href="javascript:;">Last</a></li> --}}
                                                <li class="next"><a href="javascript:;">Next</a></li>
                                                {{-- <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li> --}}
                                                <li style="display:none;"><a  href="javascript:;">Finish</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BEGIN FORM-->
                                </form>
                            </div>
                        </div>
                    </div>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
        <!-- END ADVANCED TABLE widget-->

        <!-- END PAGE CONTENT-->
    </div>
</div>
<div class="modal fade" id="add_item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
aria-labelledby="add_item" aria-hidden="true" style="margin:-10px -300px;width:600px;height:634px;display: none">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Add item sub services</h3>
</div>
        <div class="modal-body" style="max-height: 568px">
            <form class="form-horizontal" id="form_item_sub_services">
                <br />
                @php
                    $itemcode = isset($data_transport->itemtransports->item_code) ? $data_transport->itemtransports->item_code : null;
                @endphp
                {{-- in progress updated vendor --}}
                <div class="control-group hidden">
                    <label class="control-label" style="text-align: end"></label>
                    <div class="controls">
                            <input class="input-large validate[required]" readonly="enabled" type="hidden" maxlength="30" id="itemcode" name="itemcode" value="{{ $itemcode  }}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Customer</label>
                    <div class="controls">
                        <input class="input-large validate[required]" readonly="enabled" type="text" maxlength="30" value="{{ $data_transport->customers->name }}" id="customerx" name="customerx"/>
                        <input class="input-large validate[required]" readonly="enabled" type="hidden" maxlength="30" value="{{ $data_transport->customers->id }}" id="customerx_id" name="customerx_id"/>
                        {{-- <select class="dtcstmers input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="customerx" name="customerx">
                        </select> --}}
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
                    <select class="dtmoda input-large m-wrap validate[required]" style="width:224px" tabindex="-1" id="moda_x" name="moda_x">
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" style="text-align: end">Origin</label>
            <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="originx" name="originx">
            </select>
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" style="text-align: end">Destination</label>
        <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="destination_x" name="destination_x">
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" style="text-align: end">Item Description</label>
                <div class="controls">
                    <textarea class="input-large validate[required]" type="text" maxlength="200" id="itemovdesc" name="itemovdesc"></textarea>
                        {{-- <span class="help-inline">Some hint here</span> --}}
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Unit</label>
                    <div class="controls">
                    {{-- <input class="input-large validate[required]" type="text" maxlength="30" id="unit" name="unit" /> --}}
                        {{-- <span class="help-inline">Some hint here</span> --}}
                        <select class="input-small m-wrap" data-trigger="hover" style="width:223px" data-content="WOM" data-original-title="Information" id="unit" name="unit">
                            <option value="Rit">Rit</option>
                            <option value="M³">M³</option>
                            <option value="Kg">Kg</option>
                            <option value="Koli">Koli</option>
                        </select>
                </div>
            </div>
        <div class="control-group">
            <label class="control-label" style="text-align: end">Price</label>
            <div class="controls">
            <input class="input-large validate[required]" type="text" maxlength="30" id="price" name="price" />
                {{-- <span class="help-inline">Some hint here</span> --}}
        </div>
    </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button id="add_item_customer" type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@notifyJs
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/form-wizard.js')}}"></script>
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js" integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/input-errors-address-transport.js') }}"></script>
<script src="{{ asset('js/validation-detail-transport.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<!-- END JAVASCRIPTS -->
<script language="javascript" type="text/javascript">
// $("transport_order").validate();
async function getItemCustomerSync(name, origin, destination) 
    {
        let response = await fetch(`http://devyour-api.co.id/cari_subservice_without_customers/find/${name}/origin/${origin}/destination/${destination}`);
        let data = await response.json();

        return data;
    }
// $(".saved_origin").change(function () {
//     $("select option").prop("disabled", false);
//     $(".saved_origin").not($(this)).find("option[value='" + $(this).val() + "']").prop("disabled", true);
// });
//** https://github.com/rstacruz/nprogress **//
// NProgress.configure({ easing: 'ease', speed: 200 });
// NProgress.inc(true);
// $("#transport_order").validationEngine();

$('#inputDetailTransport').delay(9000).fadeOut('slow');

$("#add_item_customer").click(function(event) {

$("#add_item_customer").text('Wait processing..'); 
event.preventDefault();

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
    console.log(unit, gen_code)
    if(!shipment_category || !sub_service || !shipment_category || !moda || !origin || !destination || !itemovdesc || !unit || !gen_code || !price ) {
        
        swal("System Detects","Pastikan sudah terisi semua !","error");
        $("#add_item_customer").prop( "disabled", false)
        $("#add_item_customer").text('Save');
    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let Reqcustomer = customername;
        let Reqsubservice = sub_service;
        let Reqprice = price;
        let Reqshipment_category = shipment_category;
        let Reqmoda = moda;
        let Reqorigin = origin;
        let Reqdestination = destination;
        let Reqitemovdesc = itemovdesc;
        let Requnit = unit;

        let request = $.ajax({
        
            url: "/save-item-customer-ajax/saved",
            method: "GET",
            dataType: "json",
            data: {
                gen_code:gen_code,
                Reqcustomer:Reqcustomer,
                Reqsubservice:Reqsubservice,
                Reqshipment_category: Reqshipment_category,
                Reqmoda: Reqmoda,
                Reqorigin: Reqorigin,
                Reqdestination: Reqdestination,
                Reqitemovdesc: Reqitemovdesc,
                Reqprice: Reqprice,
                Requnit: Requnit
            },
            success: function (data) {

                Swal({
                    title: 'Successfully',
                    text: "You have done save Item Customers!",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Okay!',
                }).then((result) => {
                    if (result.value) {
                        
                        console.log(data.code_autogenerate)
                        $("#itemcode").val(data.code_autogenerate);
                    }
                    
                })
                       
        },
        complete:function(data){
            $("#add_item_customer").prop( "disabled", false)
            $("#add_item_customer").text('Save');
            
        // clear field after success saved data request!
        $("#customerx").empty();
        $("#sub_service_id").empty();
        $("#shipmentx").empty();
        $("#moda_x").empty();
        $("#originx").empty();
        $("#destination_x").empty();
        $("#itemovdesc").val('');
        $("#unit").val('');
        $("#price").val('');

        },
            error: function(){

                Swal({
                        title: 'Error',
                        text: "You have done save Item Customers!",
                        type: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                    }).then((result) => {
                        if (result.value) {
                            
                            $("#add_item_customer").prop( "disabled", false)
                             $("#add_item_customer").text('Save');
                        }
                        
                })
               
            }
        }
    );
}

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
            $(function(){
                $('#box_g1').change(function(){
                    if($(this).attr('id') == 'box_g1' && $(this).val() == 'Default'){
                        $('.box_g1').not(this).prop('disabled', true).val('Disabled');
                    } else {
                        $('.box_g1').not(this).removeProp('disabled');
                        
                        $('.box_g1 option').removeProp('disabled');
                        $('.box_g1').each(function(){
                            var val = $(this).val();
                            if(val != 'Default' || val != 'Disabled'){
                                $('.box_g1 option[value="'+val+'"]').not(this).prop('disabled', true);
                            }
                        });
                    }
                });
            });


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
                "startDate": "{{ $data_transport->estimated_time_of_delivery }}",
            }, function(start, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD HH:mm') +' (predefined range: ' + label + ')');
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
                "startDate": "{{ $data_transport->estimated_time_of_arrival }}",
            },function(start, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD HH:mm') +' (predefined range: ' + label + ')');
            });
        });

//  $(function() {
//         $("#etd").datepicker({
//             dateFormat: "yy-mm-dd",
//             onSelect: function(datetext){

//                 var d = new Date(); // for now

//                 var h = d.getHours();
//                 h = (h < 10) ? ("0" + h) : h ;

//                 var m = d.getMinutes();
//                 m = (m < 10) ? ("0" + m) : m ;

//                 var s = d.getSeconds();
//                 s = (s < 10) ? ("0" + s) : s ;

//                 datetext = datetext + " " + h + ":" + m + ":" + s;

//                 $('#etd').val(datetext);
//                 }
//         });
//     });
        // parsing value sub service inside moda
        $('#sub_service_id').on('change', function(e){
            let item_sub_service = e.target.value;
            $('#moda_x').prop("disabled", false);
            $('#moda_x').empty();
            // $.get('/load-sub-service-ex-md/find/'+ item_sub_service, function(data){
                $('#moda_x').select2({
                    placeholder: 'Cari...',
                    ajax: {
                    url: '/load-sub-service-ex-md/find/'+item_sub_service,
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
                });
            // });
        });

    
 $("#addcpics").click(function(event) {
    event.preventDefault();
    const name = $('#customer_namepp').val();
    const id = $('#id_customerd_pic').val();
    const statuspics = $('#statusid_pics').val();
    const id_customer = $('#id_customer').val();
    const position = $('#position_customer').val();
    const email = $('#email_customer').val();
    const phone = $('#phonepics').val();

    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                timeout: 1000,
                    cache: false,
                    error:function(x,e){
                        if(x.status==0){
                            alert('Anda sedang offline!\nSilahkan cek koneksi anda!');
                        }   else if(x.status==404){
                            alert('Permintaan URL tidak ditemukan!');
                        }   else if(x.status==500){
                                alert('Internal Server Error!');
                            }   else if(e=='parsererror'){
                                    alert('Error.\nParsing JSON Request failed!');
                        }   else if(e=='timeout'){
                                alert('Request Time out!');
                        }else {
                            alert('Error tidak diketahui: \n'+x.responseText);
                    }
                }
        });

    $.ajax({
        type: "post",
        url: "{{ url('customerpics') }}",
        dataType: "json",
        data: {
            id:id,
            customer_pic_status_id:statuspics,
            customer_id:id_customer,
            name:name,
            position:position,
            email:email,
            phone:phone
                  },
                    success: function (data) {
                        alert('Record updated successfully');
                            location.reload();
                    },
                // function( msg ) {
                // $("#ajaxResponse").append("<div>"+msg+"</div>");
            // },
        error: function(data){
             alert("Error")
        }
    });
});


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

 $("#refresh").click(function(event) {
    const customer = $('#customers_name').val();
    const sb = $('#sub_servicess').val();
    const origin = $('#id_origin_city').val();
    const destination = $('#id_destination_city').val();
    $('#items_tc').prop('disabled', false);
    if (sb==null) {
        $('#items_tc').prop("disabled", true);
        const toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 6500
                });
        // alert("sub_service belum diisi.");
        toast({
                title: 'Maaf permintaan anda tidak bisa diproses, Pastikan Sub Services tidak kosong!'
        })
    } else {
            // $.get('/search_by_customers_with_origin_destinations/find/'+customer+'/sb/'+sb+'/origin/'+origin+'/destination/'+destination, function(data){
            // $.each(data, function(index, Obj){
                $('#items_tc').select2({
                placeholder: 'Cari...',
                ajax: {
                        // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                        url: '/search_by_customers_with_origin_destinations/find/'+customer+'/sb/'+sb,
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
            });
        // });
    }
});

$('#items_tc').on('change', function(e){
    let items_index = e.target.value;
    $.get('/list-by-sub-services-price/find/'+ items_index, function(data){
        $.each(data, function(index, COL){
            $('#rate').val(COL.price);
        });
    });
});

function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#uom').bind('keypress', testInput);
$('#customers_pics_error').delay(2000).fadeOut('slow');
$('#customers_name_error').delay(2500).fadeOut('slow');
$('#ssrvcs_error').delay(3000).fadeOut('slow');
$('#items_error').delay(3500).fadeOut('slow');


function test(params) {
    test = $('#remark').val();
    // alert(test);
    $('#totest').val(test);
}

    $('.sub_services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_subservice/find',
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
    });

    $('#sub_servicess').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/cari_subservice_without_customers/find/'+ $("#customers_name").val() +'/origin/'+ $("#origin_city").val() + '/destination/' + $("#destination_city").val(),
                        dataType: 'json',
                        delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        if(item.customers == null){
                                            const publish = "PUBLISH";
                                            return {
                                                text: item.sub_services.name + ' - ' + publish,
                                                // id: item.origin
                                                id: item.id
                                            }
                                        } 
                                            else {
                                                const contracts = "CONTRACT";
                                            return {
                                                text: item.sub_services.name + ' - ' + contracts,
                                                // id: item.origin
                                                id: item.id
                                            }
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                     }).on('change', function (e){
                    $('#rate').val('');
                    $('#total_rate').val('');
                    $('#items_tc').prop("disabled", false);
                    $('#items_tc').empty();
                        let sub_services_id = e.target.value; 
                        $('#items_tc').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/search_by_customers_with_origin_destinations/find/'+ $("#customers_name").val()+'/sb/'+sub_services_id+'/origin/'+ $("#origin_city").val() +'/destination/' +  $("#destination_city").val(),
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
            });
        });  


    //progress parsing customer->sub_services->item_transports
    // $('#sub_service').on('change', function(e){
    //     let sub_service = e.target.value;
    //     $.get('/list_transport/find/'+ sub_service, function(data){
    //         $('#items_tc').empty();
    //         $.each(data, function(index, Obj){
    //             $('#items_tc').append($('<option>' ,{
    //                 value:Obj.id,
    //                 text:Obj.name
    //             }));
    //         });
    //         //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
    //         $('.items_tc').select2({
    //             placeholder: 'Cari...',
    //             ajax: {
    //                     url: '/list_transport/find/'+ sub_service,
    //                     dataType: 'json',
    //                     delay: 250,
    //                     processResults: function (data) {
    //                         return {
    //                             results: $.map(data, function (item) {
    //                                 return {
    //                                     text: item.itemovdesc,
    //                                     id: item.id
    //                                 }
    //                             })
    //                         };
    //                      },
    //                 cache: true
    //             }
    //         });
    //     });
    // });
    $.get('/search_by_customers_with_origin_destinations/find/'+ $("#customers_name").val()+'/sb/'+$("#sub_servicess").val()+'/origin/'+ $("#origin_city").val() +'/destination/' +  $("#destination_city").val(), function(data){
            $('#items_tc').select2({
                placeholder: 'Cari...',
                ajax: {
                url: '/search_by_customers_with_origin_destinations/find/'+ $("#customers_name").val()+'/sb/'+$("#sub_servicess").val()+'/origin/'+ $("#origin_city").val() +'/destination/' +  $("#destination_city").val(),
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
            });
            // }).on('change', function () {
            //     let props.me = e.target.value;

            // });

            $("#rate").val(''+data[0].price);
        
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
           $('#moda_x').select2({placeholder: 'Cari...'});
           $('#unit').select2({});
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
                     text: item.name+' - '+item.province.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

    //     $('#sub_service').on('change', function(e){
    //     let sub_service = e.target.value;
    //     $.get('/list_transport/find/'+ sub_service, function(data){
    //         $('#items_tc').empty();
    //         $.each(data, function(index, Obj){
    //             $('#items_tc').append($('<option>' ,{
    //                 value:Obj.id,
    //                 text:Obj.name
    //             }));
    //         });
    //         //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
    //         $('.items_tc').select2({
    //             placeholder: 'Cari...',
    //             ajax: {
    //                     url: '/list_transport/find/'+ sub_service,
    //                     dataType: 'json',
    //                     delay: 250,
    //                     processResults: function (data) {
    //                         return {
    //                             results: $.map(data, function (item) {
    //                                 return {
    //                                     text: item.itemovdesc,
    //                                     id: item.id
    //                                 }
    //                             })
    //                         };
    //                      },
    //                 cache: true
    //             }
    //         });
    //     });
    // });

    $('.customer_names').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_customers_transport/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        // if (item.suggestion = true) {
                            // $('#city_customer').val('' + item.city.name);
                            // $('#address').val('' + item.address);
                            // $('#phone_customer').val('' + item.phone);
                        // } else {
                                // $('#address').val('');
                                // $('#phone_customer').val('');
                            // }
                            return {
                                text: item.id+' - '+item.name,
                                id: item.id
                        }

                    })
                };
            },
            cache: true
        }
    }); 

    
    $('.customer_names').on('change', function(e){
        let tcs = e.target.value;
        $('.itemsadd').prop("disabled", false);
        $.get('/cari_customers_transport/find/'+ tcs, function(data){
            $('#id_project').val(''+data.project_id);
            $('#customerx').val(''+data.name);
            $('#customerx_id').val(''+data.id);
        });
    });

    $('#origin_city').on('change', function(e){
        let tcs = e.target.value;
        $.get('/load-city/find/'+ tcs, function(data){
            console.log(data)
            $('#id_origin_city').val(''+data.id);
            
        });
    });

    $('#destination_city').on('change', function(e){
        let tcs = e.target.value;
        $.get('/load-city/find/'+ tcs, function(data){
            console.log(data)
            $('#id_destination_city').val(''+data.id);
            
        });
    });

    $('.services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_service',
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
    });

    $('.saved_destination').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/search_by_value_selected_origin/find/'+$("#saved_origin_id").val()+'/customerid/'+ "{{ $data_transport->customer_id }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        // $('#origin').val(item.name);
                        // $('#origin_detail').val(item.details);
                        $('#origin_city').val(''+item.city_id);
                        // $('#origin_contact').val(''+item.contact);
                        return {
                            text: item.name + ' - ' + item.address,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

        $('#origin_city').on('change', function(e){
        let origin = e.target.value;
        $.get('/load-city/find/'+ origin, function(data){
            $('#id_origin_city').val(''+data.id);
        // $("#sub_servicess").empty();
        $("#sub_servicess").prop("disabled", false);
        $("#items_tc").prop("disabled", true);
        $("#items_tc").empty();
        $("#sub_servicess").empty();
        let destination = $("#destination_city").val();
        let customer_id = $("#customers_name").val();

        getItemCustomerSync(customer_id, data.id, destination)
                .then(originCitys => 
                    originCitys.forEach(function(entry) {
                    let arrCustomers = new Array();
                    let arrJSONID = new Array();
                    for (let i = 0; i < originCitys.length; i++) {
                        arrCustomers.push(originCitys[i]['customers']);
                    }

                    for (let i = 0; i < arrCustomers.length; i++) {
                        arrJSONID.push(JSON.stringify(arrCustomers[i]));
                        if(arrJSONID == "null"){
                            $('#sub_servicess').select2({
                            placeholder: 'Cari...',
                            "language": {
                            "noResults": function(){
                                    return "Sub service tidak ditemukan";
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            ajax: {
                            url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ data.id + '/destination/' + destination,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                                if(item.customers == null){

                                                } else {
                                                
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            });
                            break;
                        } 
                            else {
                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                    ajax: {
                                        url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + destination,
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }

                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            }).on('change', function (e){
                            $('#items_tc').prop("disabled", false);
                                let sub_services_id = e.target.value; 
                                // console.log($("#sub_servicess").val())
                                $('#items_tc').select2({
                                        placeholder: 'Cari...',
                                        ajax: {
                                            // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                                        url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ save_city +'/destination/' + destination,
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
                                });
                            });
                        }
                    }

                })
            );

        // $('#sub_servicess').select2({
        //             placeholder: 'Cari...',
        //             ajax: {
        //                 url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + destination,
        //                 dataType: 'json',
        //                 delay: 250,
        //                     processResults: function (data) {
        //                         return {
        //                             results: $.map(data, function (item) {
        //                                 if(item.customers == null){
        //                                     const publish = "PUBLISH";
        //                                     return {
        //                                         text: item.sub_services.name + ' - ' + publish,
        //                                         // id: item.origin
        //                                         id: item.id
        //                                     }

        //                                 } else {
        //                                     const contracts = "CONTRACT";
        //                                     return {
        //                                         text: item.sub_services.name + ' - ' + contracts,
        //                                         // id: item.origin
        //                                         id: item.id
        //                                     }
        //                                 }
        //                             })
        //                         };
        //                     },
        //                     cache: true
        //                 }
        //              }).on('change', function (e){
        //                 $('#items_tc').prop("disabled", false);
        //                 $('#rate').val('');
        //                 let sub_services_id = e.target.value; 
        //                 $('#items_tc').select2({
        //                 placeholder: 'Cari...',
        //                 ajax: {
        //                     // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
        //                     url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ origin +'/destination/' + destination,
        //                     dataType: 'json',
        //                     delay: 250,
        //                     processResults: function (data) {
        //                         return {
        //                             results: $.map(data, function (item) {
        //                                 return {
        //                                     text: item.itemovdesc,
        //                                     id: item.id
        //                                 }
        //                             })
        //                         };
        //                     },
        //             cache: true
        //         }
        //     });
        // });
        });
    });

    $('#destination_city').on('change', function(e){
        $("#items_tc").prop("disabled", true);
            $("#sub_servicess").empty();
            $("#sub_servicess").prop("disabled", false);
            $("#items_tc").empty();

            let destination = e.target.value;
            $.get('/load-city/find/'+ destination, function(data){
                $('#id_destination_city').val(''+data.id);
            });

            let tujuanAkhir = $("#destination_city").val();
            let origin = $("#origin_city").val();
            let customer_id = $("#customers_name").val();
            getItemCustomerSync(customer_id, origin, tujuanAkhir)
                    .then(destinationCity => 

                    destinationCity.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();

                        for (let i = 0; i < destinationCity.length; i++) {
                            arrCustomers.push(destinationCity[i]['customers']);
                        }

                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));
                            if(arrJSONID == "null"){
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    "language": {
                                    "noResults": function(){
                                            return "Sub services tidak ditemukan";
                                        }
                                    },
                                    escapeMarkup: function (markup) {
                                        return markup;
                                    },
                                    ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + tujuanAkhir,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        
                                                        } 
                                                            else {
                                                    
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    }
                                );
                                break;
                            } else {
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + tujuanAkhir,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }

                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            }).on('change', function (e){
                            $('#items_tc').prop("disabled", false);
                                let sub_services_id = e.target.value; 
                                    $('#items_tc').select2({
                                            placeholder: 'Cari...',
                                            ajax: {
                                            url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ origin +'/destination/' + tujuanAkhir,
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
                                    });
                                });
                            }
                        }
                    })
                );
        // $('#sub_servicess').select2({
        //             placeholder: 'Cari...',
        //             ajax: {
        //                 url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + destination,
        //                 dataType: 'json',
        //                 delay: 250,
        //                     processResults: function (data) {
        //                         return {
        //                             results: $.map(data, function (item) {
        //                                 if(item.customers == null){
        //                                     const publish = "PUBLISH";
        //                                     return {
        //                                         text: item.sub_services.name + ' - ' + publish,
        //                                         // id: item.origin
        //                                         id: item.id
        //                                     }
        //                                 } 
        //                                     else {
        //                                         const contracts = "CONTRACT";
        //                                     return {
        //                                         text: item.sub_services.name + ' - ' + contracts,
        //                                         // id: item.origin
        //                                         id: item.id
        //                                     }
        //                                 }
        //                             })
        //                         };
        //                     },
        //                     cache: true
        //                 }
        //              }).on('change', function (e){
        //             $('#items_tc').prop("disabled", false);
        //             $('#rate').val('');
        //             $('#total_rate').val('');
        //                 let sub_services_id = e.target.value; 
        //                 $('#items_tc').select2({
        //                 placeholder: 'Cari...',
        //                 ajax: {
        //                     // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
        //                     url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ origin +'/destination/' + destination,
        //                     dataType: 'json',
        //                     delay: 250,
        //                     processResults: function (data) {
        //                         return {
        //                             results: $.map(data, function (item) {
        //                                 return {
        //                                     text: item.itemovdesc,
        //                                 id: item.id
        //                             }
        //                         })
        //                     };
        //                 },
        //             cache: true
        //         }
        //     });
        // });    
    });
    $(".wibs").select2({});
    // $('.saved_destination').prop("disabled", true);
    $('#items_tc').prop("disabled", false);
    // $('.saved_origin').prop("disabled", true);
    $('#sub_servicess').prop("disabled", false);
    $('.customerpics_name').prop("disabled", true);
    // $('#customers_name').on('change', function(e){

    $('.customerpics_name').prop("disabled", false);
    // $('#sub_servicess').prop("disabled", false);
        // let customer_id = e.target.value;
        // $('#sub_servicess').empty();
        // $('.saved_origin').empty();
        $('.saved_destination').prop("disabled", false);
        // $('.saved_destination').empty();
            // $('#origin').val('');
            // $('#id_origin_city').val('');
            // $('#origin_city').empty();
            // $('#items_tc').val('');
            // $('#items_tcsd').val('');
            // $('#rate').val('');
            // $('#origin_detail').val('');
            // $('#origin_address').val('');
            // $('#origin_contact').val('');
            // $('#origin_phone').val('');
            // $('#destination').val('');
            // $('#destination_detail').val('');
            // $('#destination_city').val('');
            // $('#id_destination_city').val('');
            // $('#destination_address').val('');
            // $('#destination_contact').val('');
            // $('#destination_phone').val('');
    $('#customers_name').on('change', function(e){
        let customer_id = e.target.value;
        $('.saved_origin').prop("disabled", false);
        $('#sub_servicess').prop("disabled", false);
        $('#origin').val('');
                $('#id_origin_city').val('');
                $('#qty').val('');
                $('#total_rate').val('');
                $('#origin_city').empty();
                $('#sub_servicess').empty();
                $('#saved_origin').empty();
                $('#saved_destination').empty();
                $('#saved_destination').prop("disabled",  true);
                $('#items_tc').empty();
                $('#items_tcsd').val('');
                $('#pic_name_origin').val('');
                $('#pic_phone_origin').val('');
                $('#pic_name_destination').val('');
                $('#pic_phone_destination').val('');
                $('#rate').val('');
                $('#origin_detail').val('');
                $('#origin_address').val('');
                $('#origin_contact').val('');
                $('#origin_phone').val('');
                $('#destination').val('');
                $('#destination_detail').val('');
                $('#destination_city').empty();
                $('#id_destination_city').val('');
                $('#destination_address').val('');
                $('#destination_contact').val('');
                $('#destination_phone').val('');
        $.get('/search/list_customers_transports/'+ customer_id, function(data){
            $('#customerpics_name').empty();
            $.each(data, function(index, Obj){
                $('#customerpics_name').append($('<option>' ,{
                    value:Obj.id,
                    text:Obj.name
                }));
            });
            //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
            $('.customerpics_name').select2({
                placeholder: 'Cari...',
                ajax: {
                    url: '/list_cs_transports/find/'+ customer_id,
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
            });

            
            $('.saved_origin').select2({
                    placeholder: 'Cari...',
                    // allowClear: true,
                    "language": {
                    "noResults": function(){
                        return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                    }
                },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                        url: '/search_address_book_with_customers/find/'+ customer_id,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    // console.log(JSON.stringify(item));
                                    return {
                                        text: item.name + ' - ' +item.address,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true,
                    }
                }).on('change', function(e) {
                $('.items_tc').prop("disabled", true);
                $('#items_tc').empty();
                $('#sub_servicess').empty();
                $('#saved_destination').empty();
                $('#rate').val('');
                $('.saved_destination').prop("disabled", false);
                $('#destination_city_error').show();
                
                // hidden if value is exists
                $('#origin_city_error').hide();
                $('#origin_error').hide();
                $('#origin_detail_error').hide();
                $('#origin_address_error').hide();
                $('#origin_contact_errors').hide();
                $('#origin_phone_errors').hide();
                $('#origin_pic_name_errors').hide();
                $('#pic_phone_origin_errors').hide();

                $('.sd').empty();
                $('#destination').val('');
                $('#destination_detail').val('');
                $('#destination_city').empty();
                $('#id_destination_city').val('');
                $('#pic_name_destination').val('');
                $('#pic_phone_destination').val('');
                $('#destination_address').val('');
                $('#destination_contact').val('');
                $('#destination_phone').val('');
                $('#origin_phone').val('');
                // $('#items_tc').prop('disabled', false);
                    $('.saved_destination').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/search_by_value_selected_origin/find/'+$(this).val()+'/customerid/'+ customer_id,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        // $('#origin').val(item.name);
                                        // $('#origin_detail').val(item.details);
                                        $('#origin_city').val(''+item.city_id);
                                        // $('#origin_contact').val(''+item.contact);
                                        return {
                                            text: item.name + ' - ' + item.address,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                });

            // $('#saved_origin').select2({
            //         placeholder: 'Cari...',
            //         // allowClear: true,
            //         "language": {
            //         "noResults": function(){
            //             return "Tidak ada hasil yang ditemukan <a href='#' class='btn btn-danger'>Use it anyway</a>";
            //         }
            //     },
            //         escapeMarkup: function (markup) {
            //             return markup;
            //         },
            //         ajax: {
            //             url: '/search_address_book_with_customers/find/'+ "{{ $data_transport->customer_id }}",
            //             dataType: 'json',
            //             delay: 250,
            //             processResults: function (data) {
            //                 return {
            //                     results: $.map(data, function (item) {
            //                         // console.log(JSON.stringify(item));
            //                         return {
            //                             text: item.name + ' - ' +item.name,
            //                             id: item.city_id
            //                         }
            //                     })
            //                 };
            //             },
            //             cache: true,
            //         }
            //     }).on('change', function(e) {
            //     $('#items_tc').empty();
            //     $('#rate').val('');
            //     $('.saved_destination').prop("disabled", false);
            //     $('.saved_destination').empty();
            //     $('#destination').val('');
            //     $('#destination_detail').val('');
            //     $('#destination_city').empty('');
            //     $('#id_destination_city').val('');
            //     $('#pic_name_destination').val('');
            //     $('#pic_phone_destination').val('');
            //     $('#destination_address').val('');
            //     $('#destination_contact').val('');
            //     $('#destination_phone').val('');
            //     $('#origin_phone').val('');
            //     $('#items_tc').prop('disabled', true);
            //         $('.saved_destination').select2({
            //             placeholder: 'Cari...',
            //             ajax: {
            //                 url: '/search_by_value_selected_origin/find/'+$(this).val()+'/customerid/'+ customer_id,
            //                 dataType: 'json',
            //                 delay: 250,
            //                 processResults: function (data) {
            //                     return {
            //                         results: $.map(data, function (item) {
            //                             // $('#origin').val(item.name);
            //                             // $('#origin_detail').val(item.details);
            //                             $('#origin_city').val(''+item.city_id);
            //                             // $('#origin_contact').val(''+item.contact);
            //                             return {
            //                                 text: item.name + ' - ' + item.details,
            //                                 id: item.city_id
            //                             }
            //                         })
            //                     };
            //                 },
            //                 cache: true
            //             }
            //         });
            //     });
             
        });

        $('#sub_service_id').on('change', function(e){
            let item_sub_service = e.target.value;
            $('#moda_x').prop("disabled", false);
            $('#moda_x').empty();
            // $.get('/load-sub-service-ex-md/find/'+ item_sub_service, function(data){
                $('#moda_x').select2({
                    placeholder: 'Cari...',
                    ajax: {
                    url: '/load-sub-service-ex-md/find/'+item_sub_service,
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
                });
            // });
        });

    // $.get('/cari_subservice_without_customers/find/'+ customer_id, function(data){
            // $('#sub_servicess').empty();
            // $.each(data, function(index, Obj){
                // console.log(Obj.origin);

                // $('#test_sb_service').val('');
                // $('#test_sb_service').val(Obj['sub_services'].id);
                
                // $('#sub_servicess').append($('<option>' ,{
                //     value:Obj.origin,
                //     text:Obj['sub_services'].id +' '+Obj['sub_services'].name
                // }));
                    // $('.items_tcs').empty();
                        // $('#rate').val('');
                //         $('.items_tcs').select2({
                //             placeholder: 'Cari...',
                //             ajax: {
                //                 url: '/cari_subservice_without_customers/find/'+ customer_id,
                //                 dataType: 'json',
                //                 delay: 250,
                //                     processResults: function (data) {
                //                         return {
                //                             results: $.map(data, function (item) {
                //                                 return {
                //                                     text: item.itemovdesc + ' ' + item.price,
                //                                     id: item.id,
                //                             }
                //                         })
                //                     };
                //                 },
                //             cache: true
                //         }
                // });
            // });
        
        }); 
    // });
    //dynamic select search rate customers->sub_services->item_transport
    $('.saved_origin').select2({
                    placeholder: 'Cari...',
                    // allowClear: true,
                    "language": {
                    "noResults": function(){
                        return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                    }
                },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                        url: '/search_address_book_with_customers/find/'+ "{{ $data_transport->customer_id }}",
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    // console.log(JSON.stringify(item));
                                    return {
                                        text: item.name + ' - ' +item.address,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true,
                    }
                }).on('change', function(e) {
                $('.items_tc').prop("disabled", true);
                $('#items_tc').empty();
                $('#sub_servicess').empty();
                $('#saved_destination').empty();
                $('#rate').val('');
                $('.saved_destination').prop("disabled", false);
                $('#destination_city_error').show();
                
                // hidden if value is exists
                $('#origin_city_error').hide();
                $('#origin_error').hide();
                $('#origin_detail_error').hide();
                $('#origin_address_error').hide();
                $('#origin_contact_errors').hide();
                $('#origin_phone_errors').hide();
                $('#origin_pic_name_errors').hide();
                $('#pic_phone_origin_errors').hide();

                $('.sd').empty();
                $('#destination').val('');
                $('#destination_detail').val('');
                $('#destination_city').empty();
                $('#id_destination_city').val('');
                $('#pic_name_destination').val('');
                $('#pic_phone_destination').val('');
                $('#destination_address').val('');
                $('#destination_contact').val('');
                $('#destination_phone').val('');
                $('#origin_phone').val('');
                // $('#items_tc').prop('disabled', false);
                    $('.saved_destination').select2({
                        placeholder: 'Cari...',
                        ajax: {
                            url: '/search_by_value_selected_origin/find/'+$(this).val()+'/customerid/'+ "{{ $data_transport->customer_id }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        // $('#origin').val(item.name);
                                        // $('#origin_detail').val(item.details);
                                        $('#origin_city').val(''+item.city_id);
                                        // $('#origin_contact').val(''+item.contact);
                                        return {
                                            text: item.name + ' - ' + item.address,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                });


    $('#sub_servicess').on('change', function(e){
        let tcs = e.target.value;
        $.get('/search_by_items_tcss/find/'+ tcs, function(data){
            $.each(data, function(index, Obj){
                $('.saved_origin').empty();
                $('#origin').val('');
                $('#items_tc').val('');
                $('#total_rate').val('');
                $('#items_tcsd').val('');
                $('#rate').val('');
                $('#origin_detail').val('');
                $('#origin_address').val('');
                $('#origin_contact').val('');
                $('#origin_phone').val('');
                $('.saved_origin').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/search_by_origin_item_transport/find/'+ Obj.origin,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.name + ' - ' +item.details,
                                        id: Obj.origin
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
                $('#test_sb_service').val(''+Obj.sub_service_id);
            });
        });
    });

            $('.loader_city').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/load-city/find',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.id +' - '+item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

    $('.saved_destination').on('change', function(e){
        $('#items_tc').empty();
        $('#destination_city').empty();
        $('#rate').val('');
        $('#sub_servicess').empty();
        let saved_destination_id = e.target.value;
        $.get('/load_address_books_with_customersx/find/'+ saved_destination_id, function(data){
            $.each(data, function(index, Subj){
                // console.log(Subj);
                $('#destination').val(''+Subj.name);
                $('#destination_detail').val(Subj.details);
                // $('#destination_city').val(Subj['citys'].name);
                $('#id_destination_city').val(Subj['citys'].id);
                $('#destination_address').val(''+Subj.address);
                $('#pic_name_destination').val(''+Subj.pic_name_destination);
                $('#pic_phone_destination').val(''+Subj.pic_phone_destination);
                $('#destination_contact').val(''+Subj.contact);
                $('#destination_phone').val(''+Subj.phone);
                $('#destination_city').append($('<option>' ,{
                    value:Subj.id,
                    text:Subj.city_id +' - '+Subj.name
                }));
            });
            let origin = $("#origin_city").val();
            let tujuanAkhir = $("#id_destination_city").val();
            let customer_id = $("#customers_name").val();
            getItemCustomerSync(customer_id, origin, tujuanAkhir)
                    .then(SavedDestination =>
                    SavedDestination.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();
                        for (let i = 0; i < SavedDestination.length; i++) {
                            arrCustomers.push(SavedDestination[i]['customers']);
                        }

                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));
                            if(arrJSONID == "null"){
                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                "language": {
                                "noResults": function(){
                                        return "Sub services tidak ditemukan";
                                    }
                                },
                                escapeMarkup: function (markup) {
                                    return markup;
                                },
                                ajax: {
                                url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + tujuanAkhir,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        
                                                        } 
                                                            else {
                                                    
                                                        }
                                                    })
                                                };
                                            },
                                                cache: true
                                            }
                                        }
                                    );
                                break;
                            } else {
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    ajax: {
                                        // url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ Subj['citys'].id + '/destination/' + destination, 
                                        url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + tujuanAkhir,
                                        dataType: 'json',
                                        delay: 250,
                                            processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            if(item.customers == null){
                                                                const publish = "PUBLISH";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + publish,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }

                                                            } else {
                                                                const contracts = "CONTRACT";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + contracts,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                            }
                                                        })
                                                    };
                                                },
                                                cache: true
                                            }
                                    }).on('change', function (e){
                                    $('#items_tc').prop("disabled", false);
                                    let sub_services_id = e.target.value; 
                                        $('#items_tc').select2({
                                        placeholder: 'Cari...',
                                        ajax: {
                                        url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ origin  +'/destination/' + tujuanAkhir,
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
                                });
                            });
                        }
                    }
                })
            );
        });
    });

    $('#saved_origin').on('change', function(e){
        let saved_origin_id = e.target.value;
        $('#origin_city').empty();
        $.get('/load_address_books_with_customers/find/'+ saved_origin_id, function(data){
            $.each(data, function(index, Subj){
                $('#origin').val(''+Subj.name);
                $('#origin_detail').val(Subj.details);
                // $('#origin_city').val(Subj['citys'].name);
                $('#id_origin_city').val(Subj['citys'].id);
                $('#origin_address').val(''+Subj.address);
                $('#origin_contact').val(''+Subj.contact);
                $('#origin_phone').val(''+Subj.phone);
                $('#pic_name_origin').val(''+Subj.pic_name_origin);
                $('#pic_phone_origin').val(''+Subj.pic_phone_origin);
                $('#origin_city').append($('<option>' ,{
                    value:Subj['citys'].id,
                    text:Subj['citys'].id +' - '+Subj.name
                }));
            });
            let titikAwal = $("#id_origin_city").val();
            let destination = $("#destination_city").val();
            let customer_id = $("#customers_name").val();
            getItemCustomerSync(customer_id, titikAwal, destination)
                    .then(SavedOrigin =>
                    SavedOrigin.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();
                        for (let i = 0; i < SavedOrigin.length; i++) {
                            arrCustomers.push(SavedOrigin[i]['customers']);
                        }

                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));
                            if(arrJSONID == "null"){
                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                "language": {
                                "noResults": function(){
                                        return "Sub services tidak ditemukan";
                                    }
                                },
                                escapeMarkup: function (markup) {
                                    return markup;
                                },
                                ajax: {
                                url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ titikAwal + '/destination/' + destination,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        
                                                        } 
                                                            else {
                                                    
                                                        }
                                                    })
                                                };
                                            },
                                                cache: true
                                            }
                                        }
                                    );
                                break;
                            } else {
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    ajax: {
                                        // url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ Subj['citys'].id + '/destination/' + destination, 
                                        url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ titikAwal + '/destination/' + destination,
                                        dataType: 'json',
                                        delay: 250,
                                            processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            if(item.customers == null){
                                                                const publish = "PUBLISH";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + publish,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }

                                                            } else {
                                                                const contracts = "CONTRACT";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + contracts,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                            }
                                                        })
                                                    };
                                                },
                                                cache: true
                                            }
                                        }).on('change', function (e){
                                        $('#items_tc').prop("disabled", false);
                                        let sub_services_id = e.target.value; 
                                            $('#items_tc').select2({
                                            placeholder: 'Cari...',
                                            ajax: {
                                            url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ titikAwal  +'/destination/' + destination,
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
                                    });
                                });
                            }
                        }
                    })
                );
        });
    });

    $('.items').on('change', function(e){
        let items = e.target.value;
        $.get('/item_price/find/'+ items, function(data){
            $.each(data, function(index, Subj){
                $('#rate').val(''+Subj.price);
            });
        });
    });

    $('.company_braCH').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_cbrnch',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.branch,
                            id: item.id
                        }
                    })
                };
            },
            cache: false
        }
    });

     $(function() {
        $("#start_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

        $(function() {
            $("#end_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        // $(document).ready(function () {
        //     $("#rate").keyup(function (data) {
        //         const volume = parseInt(document.getElementById('volume').value);
        //         const rate = parseInt(document.getElementById('rate').value);

        //         let result_rate = parseInt(volume * rate);

        //         result_rate = result_rate.toString().replace(/\$|\,/g, '');

        //         sign = (result_rate == (result_rate = Math.abs(result_rate)));
        //         result_rate = Math.floor(result_rate * 100 + 0.50000000001);
        //         cents = result_rate % 100;
        //         result_rate = Math.floor(result_rate / 100).toString();

        //         if (cents < 10)
        //             cents = "0" + cents;

        //         for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
        //         result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                    
        //         if (isNaN(result_rate))

        //             document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

        //             if (!isNaN(result_rate))

        //                 document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

        //         });

        // });

        $(document).ready(function () {

            $("#rate").keyup(function (data) {
                const volume = parseInt(document.getElementById('qty').value);
                const rate = parseInt(document.getElementById('rate').value);

                let result_rate = parseInt(rate * volume);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

        $(document).ready(function () {
            $("#qty").keyup(function (data) {
                const volume = parseInt(document.getElementById('qty').value);
                const rate = parseInt(document.getElementById('rate').value);

                let result_rate = parseInt(rate * volume);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

    $(document).ready(function () {
        $("#volume").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#volume").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#qty").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#qty").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#actual_weight").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#actual_weight").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#chargeable_weight").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#chargeable_weight").html('errors')
                return false;
            }
        });
    });

      $(document).ready(function () {
        $("#rate").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#rate").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#collie").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#collie").html('errors')
                return false;
            }
        });
    });

    // $('.items_tc').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_item_transport/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.itemovdesc,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

    $("#since").datepicker({
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    // $('#saved_origin').select2({});
    // $('.saved_origin').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_address_book/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.name + ' - ' +item.details,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

 

    //    $('.saved_destination').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_address_book/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.name + ' - ' +item.details,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

    //  $('.saved_destination').on('change', function(e){
    //     let saved_destination_id = e.target.value;
    //     $.get('/load_address_book/find/'+ saved_destination_id, function(data){
    //         $.each(data, function(index, Subj){
    //             $('#destination').val(''+Subj.name);
    //             $('#destination_detail').val(Subj.details);
    //             $('#destination_address').val(''+Subj.address);
    //             $('#destination_contact').val(''+Subj.contact);
    //             $('#destination_phone').val(''+Subj.phone);
    //         });
    //     });
    // });

</script>

@endsection

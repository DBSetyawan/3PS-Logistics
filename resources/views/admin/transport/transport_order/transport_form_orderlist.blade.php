@extends('admin.layouts.master')
@section('head')
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('js/sweetalert-bootstrap.css') }}" rel="stylesheet" />
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
<link href="{{ asset('css/awesome/awesome-font.css') }}" rel="stylesheet" />
@notifyCss
<style>
        .collapsible {
        cursor: pointer;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        }

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
    <a href="{{ route('transport.static', $some) }}">Transport Order List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
</li>
@endsection

@section('content')

<div id="main-content" style="  overflow-y:auto;
height: 3000px;">
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
                    <div class="widget-body" id="transport-form">
                        <form id="transport_order" class="form-horizontal">
                            {{-- <form id="transport_order" action="{{ route('transport.stored.static', $some) }}" class="form-horizontal" method="POST"> --}}
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                            <div id="tabsleft" class="tabbable tabs-left">
                                <ul>
                                    <li><a href="#tabsleft-tab1" data-toggle="tab"><span class="strong">Transport Information</span> <span class="muted">Information Service<div>Service Customer Details</div></span></a></li>
                                    <li><a href="#tabsleft-tab2" data-toggle="tab"><span class="strong">Transport Registration</span> <span class="muted">Transport <div>Transport Order Details</div></span></a></a></li>
                                </ul>
                                <div class="progress progress-info progress-striped">
                                    <div class="bar"></div>
                                </div>
                                <div class="tab-content">
                                    <label class="control-label span12 error"><i class="icon-exclamation-sign popovers alert-danger"></i> Tanda ini harus wajib diisi..</label>
                                    <div class="tab-pane" id="tabsleft-tab1">
                                    <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Company Branch</label>
                                                    <div class="controls">
                                                        <label style="color: black;font-family: Quicksand">{{ $request_branchs->branch }}</label>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <br>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row-fluid">
                                            <div class="span5">
                                                <div class="control-group" style="position:relative">
                                                        <div class="controls controls-row">
                                                        <select class="regions form-control validate[required]" id="regions" style="width:318px;" name="regions" required>
                                                        </select><span class="add-on">
                                                            {{-- <a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_customer" data-whatever="" class="btn btn-success"><i class="icon-plus"></i> Add Customer</a> --}}
                                                            {{-- <a id="new_customer" type="button" class="btn btn-default popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a> --}}
                                                        </span>
                                                        <label style="position: stic;margin:-20px -180px;">Region</label>
                                                            <label id="regions_errors" class="control-label error">
                                                            <i style="position: absolute;margin:-5px -15px;" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Region harus wajib diisi.." data-original-title="Informasi User"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <div class="control-group" style="position:relative">
                                                        <div class="controls controls-row">
                                                        <select class="customer_names form-control validate[required]" id="customers_name" style="width:318px;" name="customers_name" required>
                                                        </select><span class="add-on">
                                                            {{-- <a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_customer" data-whatever="" class="btn btn-success"><i class="icon-plus"></i> Add Customer</a> --}}
                                                            {{-- <a id="new_customer" type="button" class="btn btn-default popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a> --}}
                                                        </span>
                                                        <label style="position: stic;margin:-20px -180px;">Customer Names</label>
                                                            <label id="customers_errors" class="control-label error">
                                                            <i style="position: absolute;margin:-5px -15px;" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Customer harus wajib diisi.." data-original-title="Informasi User"></i>
                                                        </label>
                                                    </div>
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
                                    </div>
                                <br />
                                </div>
                                <div class="tab-pane" id="tabsleft-tab2">
                                            <div class="row-fluid">
                                                    <div class="span12">
                                                        <hr>
                                                    </div>
                                                </div>
                                        <div style="text-align:right;"><a type="button" data-placement="top" id="modal_address_book" data-toggle="modal" href="#add" data-target="#add_address_book" data-whatever="" class="btn btn-success"><i class="icon-plus"></i> Address book</a></div>
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
                                                <div class="control-group" style="margin:0px -70px">
                                                        <label class="control-label" style="margin:0px 80px;position:absolute">Saved Origin</label>
                                                        <div class="controls">
                                                            <select data-placeholder="Saved Origin" style="width:335px;position:absolute;margin:0px" class="saved_origin" tabindex="-1" name="saved_origin" id="saved_origin">
                                                            </select>
                                                            <span class="add-on">
                                                                <a type="button" data-placement="top" id="modal_reset" data-toggle="modal_rest" href="#reset" data-target="#" data-whatever="" class="btn btn-danger"><i class="icon-remove"></i></a>
                                                                {{-- <a id="new_customer" type="button" class="btn btn-default popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a> --}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="span6">
                                                    <div class="control-group" style="margin:0px -40px">
                                                        <label class="control-label" style="margin:0px 50px;position:absolute">Saved Destination</label>
                                                        <div class="controls">
                                                            {{-- <select data-placeholder="Saved Destisnation" style="width:304px" class="saved_destination validate[required]" tabindex="-1" name="saved_destination" id="saved_destination"> --}}
                                                            <select data-placeholder="Saved Destination" style="width:300px;position:absolute;margin:0px" class="saved_destination" tabindex="-1" name="saved_destination" id="saved_destination">
                                                            </select>
                                                            <span class="add-on">
                                                                <a type="button" data-placement="top" id="modal_drest" data-toggle="reset-destination" href="#reset_destination" data-target="#" data-whatever="" class="btn btn-danger"><i class="icon-remove"></i></a>
                                                                {{-- <a id="new_customer" type="button" class="btn btn-default popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a> --}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            &nbsp;
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                            <label id="origin_error" class="control-label error"><i style="margin:0px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" style="width:374px;position:relative;margin:0px -70px" placeholder="Enter Origin" maxlength="40" id="origin"  name="origin" required>
                                                                <label style="position: absolute;margin:-20px -165px;">Shipper's</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                           <label id="destination_error" class="control-label error"><i style="margin:10px 127px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Destination harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" style="width:339px;position:relative;margin:0px -40px" placeholder="Enter Destination" maxlength="40" id="destination"  name="destination" required>
                                                                <label style="position: absolute;margin:-21px -165px;">Consignee</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label style="position:absolute;margin:8px 14px">Origin City</label>
                                                                <label id="origin_city_error" style="margin:0px;" class="control-label error"><i style="margin:0px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin City harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                    <div class="controls" style="position:absolute;margin:0px 110px">
                                                                        <select class="loader_city originloaders" style="width:374px" id="origin_city" name="origin_city" required>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                        <label style="position:absolute;margin:5px 14px">Destination City</label>
                                                        <label id="destination_city_error" class="control-label error"><i style="margin:0px 127px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin City harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                            <div class="controls" style="position:absolute;margin:0px 140px">  
                                                                <select class="loader_city destinationloaders" style="width:340px" id="destination_city" style="width:304px;" name="destination_city" required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- &nbsp; --}}
                                                <div class="append_this"></div>
                                                <div class="row-fluid hidden">
                                                    <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label" >Id Origin City</label>
                                                                <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level" placeholder="Enter Origin City" id="id_origin_city" name="id_origin_city" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Id Destination City</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" placeholder="Enter Destination City" id="id_destination_city" name="id_destination_city" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row-fluid">
                                                        <div class="span6">
                                                                <div class="control-group" style="position:relative">
                                                                    <label id="origin_address_error" class="control-label error"><i style="margin:0px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Adrress harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                        <div class="controls controls-row">
                                                                        <input type="text" class="input-block-level" style="width:374px;position:relative;margin:0px -70px"placeholder="Enter Address" id="origin_address"  name="origin_address" required>
                                                                        <label style="position: absolute;margin:-20px -165px;">Address</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="hidden">
                                                                <div class="control-group" style="position:relative">
                                                                    <label id="origin_address_error" class="control-label error"><i style="margin:0px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Adrress harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                        <div class="controls controls-row">
                                                                        <input type="text" class="input-block-level" style="width:374px;position:relative;margin:0px -70px"placeholder="Enter Address" value="5000" id="hrgatmbahan">
                                                                        <label style="position: absolute;margin:-20px -165px;">Address</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <div class="span6">
                                                            <div class="control-group" style="position:relative">
                                                                <label id="destination_address_error" class="control-label error"><i style="margin:0px 127px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Destination Adrress harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                    <div class="controls controls-row">
                                                                    <input type="text" class="input-block-level" style="width:339px;position:relative;margin:0px -40px" placeholder="Enter Address" id="destination_address"  name="destination_address" required>
                                                                <label style="position: absolute;margin:-20px -165px;">Address</label>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                            <label id="pic_phone_origin_errors" class="control-label error"><i style="margin:-20px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Origin Pic Phone harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level input-phone-origin" style="width:374px;position:relative;margin:0px -70px" placeholder="Enter Phone" id="pic_phone_origin"  name="pic_phone_origin" required>
                                                                <label style="position: absolute;margin:-20px -165px;">Phone</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                            <label id="pic_phone_destination_errors" class="control-label error"><i style="margin:0px 127px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Destination PIC PHONE harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level input-phone-destination" placeholder="Enter Phone" style="width:339px;position:relative;margin:0px -40px" id="pic_phone_destination"  name="pic_phone_destination" required>
                                                                <label style="position: absolute;margin:-20px -165px;">Phone</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                            <label id="origin_pic_name_errors" class="control-label error"><i style="margin:0px 96px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="PIC harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" style="width:374px;position:relative;margin:0px -70px" placeholder="Enter PIC NAME" id="pic_name_origin"  name="pic_name_origin"required>
                                                                <label style="position: absolute;margin:-20px -165px;">PIC NAME</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group" style="position:relative">
                                                            <label id="destination_pic_name_errors" class="control-label error"><i style="margin:0px 127px" class="icon-exclamation-sign popovers alert-danger" data-trigger="hover" data-content="Destination PIC NAME harus wajib diisi.." data-original-title="Informasi User" ></i></label>
                                                                <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" placeholder="Enter PIC NAME" style="width:339px;position:relative;margin:0px -40px" id="pic_name_destination"  name="pic_name_destination" required>
                                                                <label style="position: absolute;margin:-20px -165px;">PIC NAME</label>
                                                            </div>
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
                                                                    <label class="control-label" style="font-family: 'Courier', monospace;font-size:16px;font: bold;"> <strong>Detail&nbsp;Estimation</strong></label>
                                                                    <div class="controls">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <div class="row-fluid">
                                                    <div class="span3">
                                                        <div class="control-group">
                                                            <label class="control-label">ETD/ETA/Time Zone</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend">
                                                                    <span class="add-on" style="cursor: pointer" id="btnPickers_etd"><i class="icon-calendar" id="calenders_etd"></i></span>
                                                                        <input class="validate[required]" type="text" value="{{ old('etd') }}" style="width:208px;" placeholder="Enter ETD" id="etd" name="etd">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <div class="span3">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="input-prepend">
                                                            <span class="add-on" style="cursor: pointer"id="btnPickers_eta"><i class="icon-calendar" id="btnPickers_eta"></i></span>
                                                            <input class="validate[required]" type="text" value="{{ old('eta') }}" style="width:208px" placeholder="Enter ETA" id="eta" name="eta">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="span2">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                <select class="input-small m-wrap cusets" data-trigger="hover" style="width:223px" data-content="Data WOM" data-original-title="Information" id="time_zone" name="time_zone">
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
                                                                            <input type="text" class="validate[required]" value="{{ old('collie') }}" style="width:150px;" placeholder="Enter Collie" maxlength="5" id="collie" name="collie">
                                                                            <span class="add-on">Collie</i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="span2">
                                                                    <div class="control-group">
                                                                        <div class="controls" style="margin-left:140px;margin-top: -0,5px;">
                                                                            <div class="input-prepend">
                                                                                <input type="text" class="validate[required]" value="{{ old('volume') }}" maxlength="5" style="width:133px" placeholder="Enter Volume" id="volume" name="volume">
                                                                            <span class="add-on">m³</i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <div class="span2">
                                                            <div class="control-group">
                                                                    <div class="controls" style="margin-left:157px;margin-top: -0,5px;">
                                                                    <div class="input-prepend">
                                                                        <input type="text" class="validate[required]" value="{{ old('actual_weight') }}" maxlength="5" style="width:130px" placeholder="Enter Actual Weight" id="actual_weight" name="actual_weight">
                                                                    <span class="add-on">Kg</i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span2">
                                                            <div class="control-group">
                                                                    <div class="controls" style="margin-left:165px;margin-top: -0,5px;">
                                                                    <div class="input-prepend">
                                                                    <input type="text" class="validate[required]" value="{{ old('chargeable_weight') }}" maxlength="5" style="width:170px" placeholder="Enter Chargeable Weight" id="chargeable_weight" name="chargeable_weight">
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
                                                                    <textarea class="span12" style="width:109%" id="notes" name="notes" rows="3"></textarea>
                                                                </div>
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
                                                                    <label class="control-label" style="font-family: 'Courier', monospace;font-size:16px;font: bold;"> <strong>Detail&nbsp;Orders</strong></label>
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
                                                                            <select class="subs onchangeCustomer span12" data-placeholder="Sub Services" id="sub_servicess" style="width:320px;" name="sub_services" required>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                    <div class="span8">
                                                                            <div class="control-group">
                                                                                <label class="control-label">Item</label>
                                                                                <div class="controls">
                                                                                    <select class="form-control itm" data-placeholder="Items" style="width:68%" id="items_tc" name="items_tc" required>
                                                                                    </select>&nbsp;
                                                                                    {{-- <span class="add-on"> --}}
                                                                                        {{-- <a type="button" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="" class="itemsadd btn btn-success"> --}}
                                                                                    {{--</span> <i class="icon-plus"></i> Add Item</a></span> --}}
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
                                                                </div>
                                                            
                                                        <div class="row-fluid">
                                                                <div class="span3">
                                                                    <div class="control-group">
                                                                        <label class="control-label">Quantity/Rate/Total</label>
                                                                        <div class="controls">
                                                                            <div class="input-prepend">
                                                                                <input class="validate[required]" type="text" value="{{ old('qty') }}" style="width:135px;" placeholder="Enter Quantity" maxlength="5" id="qty" name="qty">
                                                                                <span class="add-on">Pcs \ Unit \ Kg</i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        <div class="span3">
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <div class="input-prepend input-append">
                                                                            <span class="add-on">Rp</span><input class="validate[required] input-element" type="text" value="{{ old('rate') }}" placeholder="Enter price" maxlength="14" id="rate" name="rate" style="width;235%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                    <div class="control-group">
                                                                        <div class="controls">
                                                                            <div class="input-prepend">
                                                                                <span class="add-on">Rp</i></span><input readonly="true" data-placement="top" class="popovers" data-trigger="hover" style="width:223px" data-content="Total harga item" data-original-title="Informasi"
                                                                                type="text" maxlength="30" id="total_rate" name="total_rate" style="width;235%" placeholder="Total Harga" >
                                                                                <a type="button" id="clickme" class="btn btn-primary popovers" data-trigger="hover" data-content="Tambahkan item disini" data-placement="left" data-original-title="Informasi"><i class="icon-plus"></i></a>
                                                                            </div>
                                                                    </div>
                                                              </div>
                                                        </div>
                                                        <b><span id="format"></span></b>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="span12">
                                                            {{--  <label class="control-label"></label>  --}}
                                                            {{--  <div class="controls">
                                                            </div>  --}}
                                                            <div class="control-group">
                                                                <label class="control-label"></label>
                                                                <div class="controls">
                                                                    <div style="text-align:right;">
                                                                        <a type="button" id="clicksOpenClosed" style="cursor: pointer">Show/hide list item</a>
                                                                        <div id="hint">
                                                                        <div class="contents">
                                                                            <input type="hidden" id="ID" value=0 />
                                                                            <table class="table table-striped table-bordered table-striped stripe" id="itemList">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <td style="width:7%">Sub service</td>
                                                                                        <td style="width:28%">Item</td>
                                                                                        <td style="width:3%">Qty</td>
                                                                                        <td style="width:5%">Price</td>
                                                                                        <td style="width:5%">Total Price</td>
                                                                                        <td style="width:5%">Action</td>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <td colspan="4" style="font-family: Quicksand;font-size:18px;padding-top:12px"><b><span id="method"></span></b></td>
                                                                                        <td>
                                                                                            <div class="Counter row-fluid">
                                                                                                <span style="font-size: 13px;font-family: Quicksand"><b>Menghitung...</b></span>
                                                                                            </div>
                                                                                            <span id="dataResults">
                                                                                                <b><span id="subtotal">0</span></b>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                            &nbsp;
                                                                        <span id="exp">
                                                                            <div class="row-fluid" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="span12">
                                                                                    <span>
                                                                                        Perhitungan detail transaksi pengiriman:
                                                                                    </span>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                            <div id="kgSL" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="kgFirst"></span>
                                                                                </div>  
                                                                            </div>
                                                                            <div id="sldKSL" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="SaldokgResults"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div id="rateSL" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="rateNexts"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="rateFirst"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div id="besidesID" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="besides"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div id="TotalRTID" style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="TotalRT"></span>
                                                                                </div>
                                                                            </div>
                                                                            {{-- <div class="row-fluid">
                                                                                <div class="span7">
                                                                                    <span id="chi" style="margin:1px 3px;position: absolute">&plusmn;</span>
                                                                                    <hr>
                                                                                </div>
                                                                            </div> --}}
                                                                            {{-- <div style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="tmbahan"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div style="text-align:left;font-family: Quicksand;font-size:14px">
                                                                                <div class="row-fluid span12">
                                                                                    <span id="spantyf"></span>
                                                                                </div>
                                                                            </div> --}}
                                                                            <div class="row-fluid">
                                                                                <div class="span12">
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                                <span class="hidden">
                                                                                    {{-- component render to detailOrders --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="pricesz" >
                                                                                    </select>
                                                                                    {{-- itemID save --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="itemID" >
                                                                                    </select>
                                                                                    {{-- qty save --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="qtyID" >
                                                                                    </select>
                                                                                    {{-- harga save --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="priceID" >
                                                                                    </select>
                                                                                    {{-- topup rate totals --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="topup" >
                                                                                    </select>
                                                                                    {{-- detailNote save --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="detailnotesID" >
                                                                                    </select>
                                                                                    {{-- itemDiscount save --}}
                                                                                    <select class="input-small m-wrap" data-trigger="hover" style="width:223px"
                                                                                        id="itemDiscount" >
                                                                                    </select>
                                                                                </span>
                                                                            </span>
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                            <div class="span6 hidden">
                                                                    <div class="control-group hidden">
                                                                        {{-- <label class="control-label" >Fetch Id Saved_origin</label> --}}
                                                                        <label class="control-label"></label>
                                                                        <div class="controls controls-row">
                                                                            <input type="hidden" class="input-block-level" placeholder="" id="test_sb_service"  name="test_sb_service">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            <div class="row-fluid">
                                                <div class="span12" style="text-align:right;">
                                                    <div class="form-actions" style="">
                                                        <button id="addorders" type="submit" class="btn btn-success">Order Now</button>
                                                        {{-- <a href="#myModal3" role="button" type="submit" class="btn btn-primary" data-toggle="modal">Confirm</a> --}}
                                                        <a class="btn btn-warning" href="{{ route('transport.static', $some) }}">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <ul class="pager wizard">
                                                        <li class="previous first"><a href="javascript:;">First</a></li>
                                                        <li class="previous"><a href="javascript:;">Previous</a></li>
                                                        {{-- <li class="next last"><a href="javascript:;">Last</a></li> --}}
                                                        <li class="next hover"><a href="javascript:;">Next</a></li>
                                                        {{-- <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li> --}}
                                                        <li style="display:none;"><a  href="javascript:;">Finish</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
$data=[

    'content' => $jobs_order_idx

];
@endphp
@include('admin.transport.transport_order.modal_customer', ['data' => $data])
@include('admin.transport.transport_order.modal_address_book')
@include('admin.transport.transport_order.modal_add_item_customer')
@endsection
@section('javascript')
<script src=" {{ asset('js/src-vue/vue-srcs.js')}}"></script>
<script src="{{ asset('js/src-vue/layers-form-transport.js') }}"></script>
<script src="{{ asset('js/cleave/cleaved.min.js') }}"></script>
<script src="{{ asset('js/cleave/cleaved-phone.{country}.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script> --}}
<script src=" {{ asset('js/sweet-alerts/sweet-alerts.min.js')}}"></script>
@include('sweetalert::view')
@include('notify::messages')
@notifyJs
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="{{ asset('js/sweetalert-bootstrap.js') }}"></script>
<script src="{{ asset('js/sweetalert-bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/form-wizard.js')}}"></script>
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/jqueryToCount.js') }}"></script>
<script src="{{ asset('js/jquery.animations.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/transport/itemDiscount.js') }}"></script>
<script src="{{ asset('js/transport/ItemWithoutDiscount.js') }}"></script>
<script src="{{ asset('js/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/form-validation-script.js') }}"></script>
<script src="{{ asset('js/input-errors-address-transport.js') }}"></script>
<script src="{{ asset('js/moduleTransport/ModuleTransportForms.js') }}"></script>
<script src="{{ asset('js/mod-validation-customer/mod-validate-field-customers.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script async language="javascript" type="text/javascript">
async function stall(stallTime = 3000) {
            await new Promise(resolve => setTimeout(resolve, stallTime));
        }

function formatMoney(amount, float = 2, decimal = ".", thousands = ",") {

try {
   
        float = Math.abs(float);
        float = isNaN(float) ? 2 : float;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(float)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (float ? "" : "");
    }
        catch (e) {
            swal("Something else!", "Number is not function")
            
    }
    
};

$(document).ready(function() {
    $("#rate").prop("disabled", false);
    $("#qty").prop("disabled", false);
    $("#eta").prop("disabled", false);
    $("#etd").prop("disabled", false);
    $("#time_zone").prop("disabled", false);
    $("#collie").prop("disabled", false);
    $("#volume").prop("disabled", false);
    $("#actual_weight").prop("disabled", false);
    $("#chargeable_weight").prop("disabled", false);
    $("#notes").prop("disabled", false);
  
    document.getElementById("pricesz").style.display ='none';
    $(".loaders").hide();
    $(".Counter").hide();
    $("#method").hide();
    $("#dataResults").hide();
    $("#spanText").attr('style', 'font-family:Quicksand');
    $("#itemList > TBODY").attr("class","tbodys");
    $("#itemList > TBODY").attr("styl","tbodys");
    $("#waitings").hide();
    $("#exp").hide();
    $("#clickme").hide()
    $('.parent').parent().append($('.parent').get().reverse());

    $( "#rate" ).keyup(function( event ) {
        // if (parseInt($(this).val()) == 0 || this.value.length === 0 || event.which === 48 || event.which == 13 || event.keyCode == 13) {
        if (this.value.length === 0 || event.which == 13 || event.keyCode == 13) {
            event.preventDefault();
            
                $("#clickme").hide()

            } else {
                $("#clickme").show()

            }

        });
    })


$('#plus').live('click', function(e){ 
e.preventDefault();
$(this).closest('tr').slideToggle(100);
});

function getObjectLength( obj )
{
  var length = 0;
  for ( var p in obj )
  {
    if ( obj.hasOwnProperty( p ) )
    {
      length++;
    }
  }
  return length;
}

$(function(){
    $('#addorders').click(function (e) {
        e.preventDefault();
        let customers = $("#customers_name").val();
            return new Promise((resolve, reject) => {
                bootbox.confirm({ 
                    size: "small",
                    message: "Apakah anda yakin untuk membuat order ini?",
                    callback: function(result){
                        if(result == false)
                        {
                            return;
                        } 
                        else 
                        {
                            $("#addorders").prop( "disabled", true );
                            $("#addorders").text('Please wait proccessing...');
                            setTimeout(() => resolve(StoreOrderTransport()), 3500)
                    }
                }
            });
        });
    });
});

let submit = document.querySelector("#clickme");

let promiseResolve = null;

if(submit){
    submit.addEventListener('click', onSubmitClick);
}

let totalCount = 0;

function DecrementLimit()
   {
      totalCount--;
   }

async function Limit(cabang, idItem, qty, price, totalHarga, topup) {

    /**
        Modal window position, can be 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', or 'bottom-end'.
    */
    const toast = Swal.mixin({
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 6000
            });

   if(totalCount >= 3)
   {
        $(".Counter").hide();
        $("#dataResults").show();

      toast.fire({    
                type: "error",
                title: "maaf anda tidak bisa menambahkan lagi.. "
            })
      return false;
   }
   else
        {
            totalCount++;
                if(qty < 1) {
                            toast.fire({    
                                type: "error",
                                title: "Maaf Qty minimal 1 (kg/koli/m3)?"
                            })
                                setTimeout(() =>$(".loaders").hide(), $(".waitings").hide(),1500);
                            return false;
                } else
                        {

                            $("#itemList > THEAD > TBODY").show()

                                const tBody = $("#itemList > TBODY")[0];
                                let rowIndex = document.getElementById("ID").rowIndex;
                                let rows = tBody.insertRow(rowIndex);
                                    rows = tBody.insertRow(rowIndex);
                                    $(rows.insertCell(0));
                                    let cell1 = $(rows.insertCell(1));
                                                rows.insertCell(2);
                                                rows.insertCell(3);
                                                rows.insertCell(4);
                                                rows.insertCell(5);

                                    cell1.attr("id","waitings");
                                    cell1.colSpan = "6";
                                    cell1.html(`<div class="loaders row-fluid">
                                        <img src="{{ asset('img/FhHRx.gif') }}" id="form_loading_img" alt="Sedang memuat history order" style="display:none;display: block;margin-left: auto;margin-right: auto;">
                                    </div>`);

                                return new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(FetchDetailItemCustomer(cabang, idItem, qty, price, totalHarga, topup)),3500)
                                }
                            );
                    }
                return true;
            }
    }

function startListening() {

    new Promise(function(resolve, reject) {
        promiseResolve = (error) => {
        if (error) { reject(error); } else { resolve(); }
        };
    }).then(onSubmit)
    .catch(error => onError(error));

}

function onSubmitClick() {
        
    $("#clickme").attr("disabled", false);
    $(".loaders").show();
    $("#dataResults").hide();
    $(".Counter").show();
    $("#method").hide();

    if (promiseResolve) promiseResolve();
            const id_sbservice = $("#sub_servicess").val();
            const idItem = $("#items_tc").val();
            const qty = $("#qty").val();
            const price = $("#rate").val();
            const totalHarga = $("#total_rate").val();
            const cabang = "{{ $some }}";
            const topup = $("#hrgatmbahan").val();
            let Quantity = $("#qty").val();
            let Prices = $("#rate").val();
            let TotalPrice = $("#total_rate").val();

            var table = document.getElementById('itemList');  
            var ArrY = new Array()  
            var count = table.rows.length;  
            for(var i=0; i<count; i++) {    
                ArrY.push(i);    
            }

            const sweeterArray = ArrY.map(sweetItem => {
                return sweetItem
            })

    Limit(cabang, idItem, qty, price, totalHarga, topup)

}


function stripquotes(a) {
    if (a.charAt(0) === '"' && a.charAt(a.length-1) === '"') {
        return a.substr(1, a.length-2);
    }
    return a;
}


function onSubmit() {
    console.log("Done");
}

    async function FetchDetailItemCustomer(cabang, idItem, qty, price, totalHarga, topup) {
        const test = `/dashboard/find-branch-with-branch/branch-id/${cabang}/viewDetailItemcustomer/`+idItem;
        const responsetest = await fetch(test, {

            method: 'GET',
            cache: 'no-cache',
            credentials: 'same-origin',
            redirect: 'follow',
            referrer: 'no-referrer',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }

            });

            if(!responsetest){  

                $(".loaders").show();
                $("#dataResults").hide();

                $(".Counter").show();
                $("#waitings").show();

                $(".parent").hide();

            } else {

                $(".loaders").hide();
                $("#dataResults").show();

                $(".Counter").hide();

                $(".parent").show();
                $("#itemList tr").find("#waitings").parent().each(function(){
                    $(this).closest("tr").hide();
                })

            }
            
            const dataJsons = await responsetest.json();

            const dataMinimumQty = JSON.stringify(dataJsons.data.batch_itemCustomer.itemMinimumQty);
            const dataRateSelanjutnya = JSON.stringify(dataJsons.data.batch_itemCustomer.rateKgFirst);
            const dataprice = JSON.stringify(dataJsons.data.price);
            const dataUnit = JSON.stringify(dataJsons.data.unit);

            let TotalPrice = $("#total_rate").val();
            let Rate = $("#rate").val();
            let tostal = TotalPrice.toString();
            let sd = tostal.replace('.', '');
            let harga = sd.replace('.', '');
            let total = 0;

            $('#pricesz').append($('<option>' ,{
                value:harga,
                text:harga
            }));
            $('#itemID').append($('<option>' ,{
                value:dataJsons.data.id,
                text:dataJsons.data.id
            }));

        let iArrays = new Array();
        let JArrays = new Array();
        let QArrays = new Array();
        let HargaArrays = new Array();
        let topArrays = new Array();
        let biayaTambahan = [topup];
        const tBody = $("#itemList > TBODY")[0];
        let rowIndex = document.getElementById("ID").rowIndex;
        let rows = tBody.insertRow(rowIndex + 1);
        let saldoakhir = 0;
        let Besides = 0;
        let StuckQty = 0;
        let StuckPrices = 0;
        let hasilRatedanMinimalRate = 0;
        let rateSelanjutnya = 0;
        let wom = 0;
        let leftQouter;
        let tambahanMinimalQty = 0;
        let resultCountRateCat1 = 0;
        let resultCountRate = 0;
        let SaldoBiayaTambahan = 0;
        let order_id_dumps = document.getElementById('pricesz');
        let Kuantitas = document.getElementById('qtyID');
        let pricesz = document.getElementById('pricesz');
        let topups = document.getElementById('topup');

            for (i = 0; i < order_id_dumps.options.length; i++) {

                iArrays[i] = order_id_dumps.options[i].value;

            }

                for (i = 0; i < iArrays.length; i++) {

                    total += parseInt(iArrays[i]);
                }  

                    for (i = 0; i < Kuantitas.options.length; i++) {

                        QArrays[i] = Kuantitas.options[i].value;

                    }

                        let fetchQTY = [];

                            for (i = 0; i < QArrays.length; i++) {

                                fetchQTY.push(QArrays[i]);
                            
                            }  

                            for (i = 0; i < pricesz.options.length; i++) {

                                    HargaArrays[i] = pricesz.options[i].value;

                                }

                                let fetchHarga = [];

                                    for (i = 0; i < pricesz.length; i++) {

                                        fetchHarga.push(HargaArrays[i]);
                                    
                                    }  
                                    
                            /**
                             * metode pertama
                            */
                            if(dataMinimumQty == 0 && dataRateSelanjutnya == 0){

                                $('#topup').append($('<option>' ,{
                                    value:totalHarga.replace(/\D/g, ''),
                                    text:totalHarga.replace(/\D/g, '')
                                }));
                                for (i = 0; i < topups.options.length; i++) {

                                    topArrays[i] = topups.options[i].value;

                                }

                                    for (i = 0; i < topArrays.length; i++) {

                                        resultCountRateCat1 += parseInt(topArrays[i]);

                                    }  

                                    total = parseFloat(resultCountRateCat1)
                                    StuckQty = qty;
                                    StuckPrices = Rate;

                            } 
                                else 
                                        {

                                            /**
                                            * metode kedua
                                            */
                                                if(dataMinimumQty > 0 && dataRateSelanjutnya == 0){

                                                        if(parseInt(qty) < parseInt(dataMinimumQty)){

                                                            tambahanMinimalQty = dataMinimumQty*parseInt(Rate);
                                                            StuckQty = dataMinimumQty;
                                                            StuckPrices = Rate;
                                                            wom = dataMinimumQty;
                                                                                        
                                                            $('#topup').append($('<option>' ,{
                                                                value:tambahanMinimalQty,
                                                                text:tambahanMinimalQty
                                                            }));

                                                            for (i = 0; i < topups.options.length; i++) {

                                                                topArrays[i] = topups.options[i].value;

                                                            }

                                                                for (i = 0; i < topArrays.length; i++) {

                                                                    resultCountRate = parseInt(topArrays[i]);
                                                                    saldoakhir += parseInt(topArrays[i]);
                                                                }  

                                                            totalcategory2 = parseFloat(saldoakhir)

                                                        } 
                                                            else 
                                                                    {

                                                                        tambahanMinimalQty = qty*parseInt(Rate);
                                                                        StuckQty = qty;
                                                                        StuckPrices = Rate;
                                                                        wom = qty;
                                                                        
                                                                        $('#topup').append($('<option>' ,{
                                                                            value:tambahanMinimalQty,
                                                                            text:tambahanMinimalQty
                                                                        }));

                                                                        for (i = 0; i < topups.options.length; i++) {

                                                                            topArrays[i] = topups.options[i].value;

                                                                        }

                                                                for (i = 0; i < topArrays.length; i++) {

                                                                    resultCountRate = parseInt(topArrays[i]);
                                                                    saldoakhir += parseInt(topArrays[i]);
                                                                }  

                                                            totalcategory2 = parseFloat(saldoakhir)
                                                        }
                                                } 
                                                    else 
                                                            {
                                                               
                                                                if(dataMinimumQty == 0 && dataRateSelanjutnya > 0){
                                                                    console.log("data rate selanjutnya ada")
                                                                }
                                                }

                                        /**
                                        * metode ketiga
                                        */
                                        if(dataMinimumQty > 0 && dataRateSelanjutnya > 0){

                                                tambahanMinimalQty = dataMinimumQty-qty;
                                                    StuckQty = tambahanMinimalQty;

                                                    if(tambahanMinimalQty == 0){

                                                                leftQouter = 0;
                                                                tambahanMinimalQty = qty;
                                                                StuckQty = tambahanMinimalQty;

                                                            } 
                                                                else {

                                                                    tambahanMinimalQty = Math.abs(tambahanMinimalQty)

                                                                    StuckQty = tambahanMinimalQty;

                                                            }

                                                                if(parseInt(dataMinimumQty) >= parseInt(qty)){
                                                                    if(parseInt(dataMinimumQty) == parseInt(qty)){

                                                                            leftQouter = 0;
                                                                                droppoint = parseFloat(dataRateSelanjutnya) * parseFloat(dataMinimumQty);
                                                                                ResultRate = parseFloat(droppoint);
                                                                                SaldoBiayaTambahan = parseFloat(droppoint);

                                                                                StuckPrices = parseFloat(ResultRate/tambahanMinimalQty)
                                                                                x = Math.ceil(StuckPrices)*parseFloat(tambahanMinimalQty)

                                                                                ResultRate = parseFloat(x);
                                                                                
                                                                                diskon = 0;

                                                                                $('#itemDiscount').append($('<option>' ,{
                                                                                            value:diskon,
                                                                                            text:diskon
                                                                                        }
                                                                                    )
                                                                                )
                                                                    } else 
                                                                            {

                                                                                leftQouter = 0;
                                                                                droppoint = parseFloat(dataRateSelanjutnya) * parseFloat(dataMinimumQty);

                                                                                StuckPrices = Math.ceil(parseFloat(droppoint)/(parseFloat(StuckQty)));
                                                                                ResultRate = parseFloat(droppoint);
                                                                                SaldoBiayaTambahan = parseFloat(droppoint);
                                                                                jumlahRate = Math.ceil(StuckPrices)*parseFloat(tambahanMinimalQty)

                                                                            diskon = Math.abs(ResultRate - jumlahRate);

                                                                        $('#itemDiscount').append($('<option>' ,{
                                                                                    value:diskon,
                                                                                    text:diskon
                                                                                }
                                                                            )
                                                                        )
                                                                    }

                                                                } 
                                                                    else 
                                                                            {

                                                                                leftQouter = 0;
                                                                                droppoint = parseFloat(dataRateSelanjutnya) * parseFloat(dataMinimumQty);
                                                                                StuckQty = qty
                                                                                StuckQtys = tambahanMinimalQty
                                                                                Besides = parseFloat(Rate)*tambahanMinimalQty
                                                                                ResultRate = parseFloat(Rate)*StuckQtys+parseFloat(droppoint);
                                                                                StuckPrices = Math.abs(Math.ceil(parseFloat(ResultRate)/parseFloat(qty)));
                                                                                jumlahRate = Math.ceil(StuckPrices)*parseFloat(qty)
                                                                                // SaldoBiayaTambahan = parseFloat(Rate)*StuckQtys+parseFloat(dataRateSelanjutnya);
                                                                                SaldoBiayaTambahan = parseFloat(Rate)*StuckQtys+parseFloat(droppoint);

                                                                                /**
                                                                                * development diskon on accurate
                                                                                */
                                                                                diskon = Math.abs(ResultRate - jumlahRate);

                                                                                $('#itemDiscount').append($('<option>' ,{
                                                                                            value:diskon,
                                                                                            text:diskon
                                                                                        }
                                                                                    )
                                                                                )
                                                                            }

                                                                $('#topup').append($('<option>' ,{
                                                                        value:ResultRate,
                                                                        text:ResultRate
                                                                    }));

                                                                        for (i = 0; i < topups.options.length; i++) {

                                                                                topArrays[i] = topups.options[i].value;

                                                                            }

                                                            for (i = 0; i < topArrays.length; i++) {

                                                                resultCountRate = parseInt(topArrays[i]);
                                                                saldoakhir += parseInt(topArrays[i]);
                                                            }  

                                                totalcategory2 = parseFloat(saldoakhir)

                                        }

                            }

                            /*
                            * stuck array here with component box for send to request back end server
                            */
                            $('#qtyID').append($('<option>' ,{
                                value:StuckQty,
                                text:StuckQty
                            }));
                            $('#priceID').append($('<option>' ,{
                                value:StuckPrices,
                                text:StuckPrices
                            }));


                    if(dataMinimumQty == 0 && dataRateSelanjutnya == 0){
                        /*
                        * metode pertama
                        */
                        const tBody = $("#itemList > TBODY")[0];
                        let row = tBody.insertRow(-1);
                                    
                        let Sub_services = $(row.insertCell(0));
                        let ItemList = $(row.insertCell(1));
                        let Qty = $(row.insertCell(2));
                        let Harga = $(row.insertCell(3));
                        let Price = $(row.insertCell(4));
                        let Actions = $(row.insertCell(5));
                        const djl = formatMoney(`${total}`);
                        const priceXV = formatMoney(`${price}`);

                        $("#itemList tr").each(function(){
                                $(this)
                                    .attr("class","parent")
                        });

                        let celluuid = $(row.insertCell(6));
                        let notes = $(row.insertCell(7));
                        
                        /**
                         * metode pertama [default] tidak ada nilai reduce value pada itemDiscount
                         **/

                        let btnRemovejc = $("<input />");
                            btnRemovejc.attr("style","cursor:pointer");
                            btnRemovejc.attr("type","button");
                            btnRemovejc.attr("class", "btn btn-danger");
                            btnRemovejc.attr("onclick", "RemoveDetailItemOrdersWithoutDiscount(this);");
                            btnRemovejc.val("-");
                            Actions.append(btnRemovejc);

                        Sub_services.html(dataJsons.data.sub_services.name)
                        celluuid.attr("id","uid_services");
                        celluuid.attr("class","hidden");
                        celluuid.html(dataJsons.data.id);
                        
                        ItemList.html('<span id="xxxx"></span>')

                        Qty.html(qty)
                        Harga.html("Rp. "+priceXV)
                        Price.html("Rp. "+totalHarga)
                        Actions.html(btnRemovejc)
                        $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                        $('#subtotal').each(function () {
                                $(this).prop('Counter',0).animate({
                                    Counter: total
                                }, {
                                    duration: 4000,
                                    easing: 'swing',
                                    step: function (now) {
                                        return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                    }
                                });
                            });

                            let codxxxx = `Rate          : Rp. ${Rate}  &chi;  ${qty} ${dataUnit}`+'<br/>'+`Total rate    : Rp. ${totalHarga}` 
                                  
                                    let arrLISTsQ = 
                                            'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                            'Rate (Normal) : '+`Rp. ${Rate} x ${qty} ${JSON.parse(dataUnit)}` +'\n'+
                                            'Total rate    : '+`Rp. ${totalHarga}`

                                            $('#detailnotesID').append($('<option>' ,{
                                                            value:arrLISTsQ,
                                                        text:arrLISTsQ
                                                    }
                                                )
                                            )

                                            notes.attr("id","detailnotes");
                                            notes.attr("class","hidden");
                                            notes.html(arrLISTsQ);

                                    $("#itemList tr").find("#xxxx").parent().each(function(){
                                        $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                        <div class="row-fluid">
                                                <div class="span12">
                                                    <hr>
                                                </div>
                                            </div>
                                        <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                    <div class="row-fluid">
                                                        <div class="span12">
                                                            <span style="font-size:15px;font-family:Quicksand">
                                                                Perhitungan detail transaksi pengiriman:
                                                            </span>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <span id="xxxzx">
                                                </span>
                                        </span>`
                                    )
                                }
                            );

                                $("#itemList tr").find("#xxxzx").parent().each(function(){
                                    
                                    let detail = codxxxx.replace(/"/g, '');
                                        
                                        $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
    
                                    }
                                );

                            $("#exp").hide();

                            await stall()

                            $("#method").show();

                            $("#method").html(`<span class="badge badge-info" style="position:relative">Model Rate - 1</span>`)

                            $('#method').animate('slideFromRight scaleTo', {
                                "custom": {
                                    "slideFromRight": {
                                    "duration": 4000,
                                    "direction": "normal"
                                    }
                                }
                            });

                        return

                    } 
                        else 
                                {
                                /*
                                * metode kedua
                                */
                                    if(dataMinimumQty > 0 && dataRateSelanjutnya == 0){

                                        const tBody = $("#itemList > TBODY")[0];
                                        let row = tBody.insertRow(-1);

                                        let Sub_services = $(row.insertCell(0));
                                        let ItemList = $(row.insertCell(1));
                                        let Qty = $(row.insertCell(2));
                                        let Harga = $(row.insertCell(3));
                                        let Price = $(row.insertCell(4));
                                        let Actions = $(row.insertCell(5));

                                        const djl = formatMoney(`${totalcategory2}`);
                                        const changeCuountRate = formatMoney(`${resultCountRate}`);
                                        const tmbn = formatMoney(`${saldoakhir}`);
                                        const funcPriceX = formatMoney(`${StuckPrices}`);
                                        const RateTwo = formatMoney(`${Rate}`);


                                        $("#itemList tr").each(function(){
                                                $(this)
                                                    .attr("class","parent")
                                        });

                                        let celluuid = $(row.insertCell(6));
                                        let notes = $(row.insertCell(7));

                                        /**
                                         * metode kedua ada nilai reduce value pada itemDiscount
                                         **/

                                        let btnRemovejc = $("<input />");
                                            btnRemovejc.attr("style","cursor:pointer");
                                            btnRemovejc.attr("type","button");
                                            btnRemovejc.attr("class", "btn btn-danger");
                                            btnRemovejc.attr("onclick", "RemoveDetailItemOrdersWithoutDiscount(this);");
                                            btnRemovejc.val("-");
                                            Actions.append(btnRemovejc);

                                        Sub_services.html(dataJsons.data.sub_services.name)
                                        celluuid.attr("id","uid_services")
                                        celluuid.attr("class","hidden")
                                        celluuid.html(dataJsons.data.id)
                                        ItemList.html('<span id="xxxx"></span>')

                                        Actions.html(btnRemovejc)

                                        Qty.html(StuckQty)
                                        Price.html("Rp. "+changeCuountRate)
                                        $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                                            $('#subtotal').each(function () {
                                                $(this).prop('Counter',0).animate({
                                                    Counter: totalcategory2
                                                }, {
                                                    duration: 4000,
                                                    easing: 'swing',
                                                    step: function (now) {
                                                        return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                    }
                                                });
                                            });

                                        let codxxxx = `Kg Minimal    : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                    +`Kg Actual     : ${qty} ${dataUnit}`+'<br/>'
                                                    +`Rate pertama  : Rp. ${RateTwo} &chi; ${wom} ${dataUnit}`+'<br/>'
                                                    +`Rate          : Rp. ${changeCuountRate}`

                                                    let arrLISTQx = 
                                                            'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                            'Kg Minimal    : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                            'Kg Actual     : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                            'Rate pertama  : '+`Rp. ${RateTwo} x ${wom} ${JSON.parse(dataUnit)}`+'\n'+
                                                            'Rate          : '+`Rp. ${changeCuountRate}`

                                                            $('#detailnotesID').append($('<option>' ,{
                                                                            value:arrLISTQx,
                                                                        text:arrLISTQx
                                                                    }
                                                                )
                                                            )

                                                            notes.attr("id","detailnotes")
                                                            notes.attr("class","hidden")
                                                            notes.html(arrLISTQx)
                                                                
                                                        $("#itemList tr").find("#xxxx").parent().each(function(){
                                                            $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                            <div class="row-fluid">
                                                                    <div class="span12">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                        <div class="row-fluid">
                                                                            <div class="span12">
                                                                                <span style="font-size:15px;font-family:Quicksand">
                                                                                    Perhitungan detail transaksi pengiriman:
                                                                                </span>
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                        <br/>
                                                                        <span id="xxxzx">
                                                                    </span>
                                                            </span>`
                                                        )
                                                    }
                                                );

                                                $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                    
                                                    let detail = codxxxx.replace(/"/g, '');
                                                        
                                                        $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                    }
                                                );

                                            $("#exp").hide();

                                            await stall()
                                            
                                            $("#method").show();
                                            
                                            $("#method").html(`<span class="badge badge-info">Model Rate - 2</span>`)
                                            
                                            $('#method').animate('slideFromRight scaleTo', {
                                                    "custom": {
                                                        "slideFromRight": {
                                                        "duration": 4000,
                                                        
                                                        "direction": "normal"
                                                        }
                                                    }
                                                });

                                        return

                                    } 
                                        else 
                                                {
                                                    /*
                                                    * metode ketiga
                                                    */
                                                if(dataMinimumQty > 0 && dataRateSelanjutnya > 0){

                                                    const tBody = $("#itemList > TBODY")[0];
                                                    let row = tBody.insertRow(-1);
                                                                
                                                    let Sub_services = $(row.insertCell(0));
                                                    let ItemList = $(row.insertCell(1));
                                                    let Qty = $(row.insertCell(2));
                                                    let Harga = $(row.insertCell(3));
                                                    let Price = $(row.insertCell(4));
                                                    let Actions = $(row.insertCell(5));

                                                    const djl = formatMoney(`${totalcategory2}`);
                                                    const totalQtyRate = formatMoney(`${Besides}`);
                                                    const tmbn = formatMoney(`${saldoakhir}`);
                                                    const TotalSaldoRate = formatMoney(`${SaldoBiayaTambahan}`);
                                                    const funcPrice = formatMoney(`${StuckPrices}`);
                                                    const dataRateSelanjutnyaX = formatMoney(`${dataRateSelanjutnya}`);
                                                    const hasilRatedanMinimalRateX = formatMoney(`${ResultRate}`);
                                                    const RateX = formatMoney(`${Rate}`);
                                                    
                                                    if(dataMinimumQty == qty){

                                                        $("#itemList tr").each(function(){
                                                                $(this)
                                                                    .attr("class","parent")
                                                        });

                                                        let celluuid = $(row.insertCell(6));
                                                        let notes = $(row.insertCell(7));

                                                        /**
                                                         * metode ketiga ada nilai reduce value pada itemDiscount
                                                         **/

                                                        let btnRemovejc = $("<input />");
                                                            btnRemovejc.attr("style","cursor:pointer");
                                                            btnRemovejc.attr("type","button");
                                                            btnRemovejc.attr("class", "btn btn-danger");
                                                            btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);");
                                                            btnRemovejc.val("-");
                                                            Actions.append(btnRemovejc);

                                                        Sub_services.html(dataJsons.data.sub_services.name)

                                                        celluuid.attr("id","uid_services")
                                                        celluuid.attr("class","hidden")
                                                        celluuid.html(dataJsons.data.id)

                                                        ItemList.html('<span id="xxxx"></span>')
                                                       
                                                        Qty.html(qty)
                                                        
                                                        Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                        
                                                        Actions.html(btnRemovejc)
                                                        
                                                        $("#kgSL").show();
                                                        $("#sldKSL").hide();
                                                        $("#rateSL").show();
                                                        $("#chi").show();

                                                        $('#subtotal').each(function () {
                                                            $(this).prop('Counter',0).animate({
                                                                Counter: totalcategory2
                                                            }, {
                                                                duration: 4000,
                                                                easing: 'swing',
                                                                step: function (now) {
                                                                    return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                                }
                                                            });
                                                        });

                                                        // datam minimum == qty
                                                        $("#subtotal").html(`<span id="subtotal">${djl}</span>`)
                                                        $("#rateFirst").html(`<span> Rate pertama <span style='margin:0px 58px'>: Rp. <span id='rtprtm' class='dds add-on'>${RateX}</span></span></span>`)
                                                        $("#rateNexts").html(`<span> Rate kg pertama <span style='margin:0px 33px'>: <span id='kgprtm' class='dds add-on'>Rp. ${dataRateSelanjutnyaX} x ${droppoint}</span></span></span>`)
                                                        $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit} - (Dikenakan kg pertama)</span></span></span>`)

                                                        $("#clickme").removeAttr('disabled');
                                                        $("#clickme").html("<i class='icon-plus'></i>");

                                                        let codxxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                    +`Kg Actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                    +`Rate kg pertama  : ${dataRateSelanjutnyaX}`+' x '+ `${dataMinimumQty}` +'<br/>'
                                                                    +`Rate             : Rp. ${TotalSaldoRate}` 

                                                        /** 
                                                        @arguments [Accurate online detail notes] 
                                                        @var arrLISTb == detail note ID
                                                        */
                                                            let arrLISTb = 
                                                                    'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                    'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                    'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                    'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX} `+' x '+` ${droppoint}`+'\n'+
                                                                    'Rate             : '+`Rp. ${TotalSaldoRate}`
                                                                    
                                                                    notes.attr("id","detailnotes")
                                                                    notes.attr("class","hidden")
                                                                    notes.html(arrLISTb)

                                                                        $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                            $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                            <div class="row-fluid">
                                                                                    <div class="span12">
                                                                                        <hr>
                                                                                    </div>
                                                                                </div>
                                                                            <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                        <div class="row-fluid">
                                                                                            <div class="span12">
                                                                                                <span style="font-size:15px;font-family:Quicksand">
                                                                                                    Perhitungan detail transaksi pengiriman:
                                                                                                </span>
                                                                                                <hr>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br/>
                                                                                        <span id="xxxzx">
                                                                                    </span>
                                                                            </span>`
                                                                        )
                                                                    }
                                                                );

                                                                $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                                    
                                                                    let detail = codxxxx.replace(/"/g, '');
                                                                        
                                                                        $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                            
                                                                        }
                                                                    );

                                                                        $('#detailnotesID').append($('<option>' ,{
                                                                                value:arrLISTb,
                                                                            text:arrLISTb
                                                                        }
                                                                    )
                                                                )

                                                            $("#exp").hide();

                                                            await stall()
                                                            
                                                            $("#method").show();
                                                            
                                                            $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)
                                                            
                                                            $('#method').animate('slideFromRight scaleTo', {
                                                                    "custom": {
                                                                        "slideFromRight": {
                                                                        "duration": 4000,
                                                                        
                                                                        "direction": "normal"
                                                                        }
                                                                    }
                                                                });

                                                        return

                                                    } 
                                                        else {

                                                            if(parseInt(dataMinimumQty) >= parseInt(qty)){

                                                                let celluuid = $(row.insertCell(6));
                                                                let notes = $(row.insertCell(7));

                                                                    $("#itemList tr").each(function(){
                                                                            $(this)
                                                                                .attr("class","parent")
                                                                    });

                                                                    /**
                                                                     * metode ketiga ada nilai reduce value pada itemDiscount
                                                                     **/

                                                                    let btnRemovejc = $("<input />");
                                                                        btnRemovejc.attr("style","cursor:pointer");
                                                                        btnRemovejc.attr("type","button");
                                                                        btnRemovejc.attr("class", "btn btn-danger");
                                                                        btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);")
                                                                        btnRemovejc.val("-");
                                                                        Actions.append(btnRemovejc);

                                                                    Sub_services.html(dataJsons.data.sub_services.name)

                                                                    celluuid.attr("id","uid_services")
                                                                    celluuid.attr("class","hidden")
                                                                    celluuid.html(dataJsons.data.id)

                                                                    ItemList.html('<span id="xxxx"></span>')
                                                                    Qty.html(qty)
                                                                    Price.html("Rp. "+hasilRatedanMinimalRateX)
                                                                    
                                                                    Actions.html(btnRemovejc)

                                                                    $("#besidesID").hide();
                                                                    $("#TotalRTID").hide();
                                                                    $("#kgSL").hide();
                                                                    $("#sldKSL").show();
                                                                    $("#rateSL").show();
                                                                    $("#chi").show();
                                                                    $("#subtotal").html(`<span id="subtotal">${djl}</span>`)

                                                                    $("#spantyf").html(`<span> Saldo Akhir <span style='margin:0px 69px'>: Rp. <span id='ttl' class='dds add-on'>${djl}</span></span></span>`)
                                                                    $("#SaldokgResults").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='SaldoResults' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                    $("#tmbahan").html(`<span> Total Rate <span style='margin:0px 76px'>: Rp. <span id='tmbhn' class='dds add-on'>${hasilRatedanMinimalRateX}</span></span></span>`)
                                                                    
                                                                    if(leftQouter == 0){
                                                                        $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                    } else {

                                                                        $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit} &minus; ${dataMinimumQty} (Minimal ${dataUnit}) = ${tambahanMinimalQty} ${dataUnit}</span></span></span>`)

                                                                    }

                                                                    $('#subtotal').each(function () {
                                                                        $(this).prop('Counter',0).animate({
                                                                            Counter: totalcategory2
                                                                        }, {
                                                                            duration: 4000,
                                                                            easing: 'swing',
                                                                            step: function (now) {
                                                                                return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                                            }
                                                                        });
                                                                    });
                                                                    
                                                                    // minimal < dataminimum 
                                                                    $("#rateNexts").html(`<span> Rate Selanjutnya  <span style='margin:0px 24px'>: <span id='kgprtm' class='dds add-on'>Rp. ${TotalSaldoRate} x ${dataMinimumQty}</span></span></span>`)
                                                                    $("#rateFirst").html(`<span> Rate Pertama <span style='margin:0px 58px'>: Rp. <span id='rtprtm' class='dds add-on'>${RateX}</span></span></span>`)
                                                                    $("#clickme").removeAttr('disabled');
                                                                    $("#clickme").html("<i class='icon-plus'></i>");

                                                                    let codxxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                                +`Kg actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                                +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX}`+' &chi; '+`${dataMinimumQty}`+'<br/>'
                                                                                +`Rate             : Rp. ${TotalSaldoRate}`

                                                                                /** 
                                                                                @arguments [Accurate online detail notes] 
                                                                                @var arrLISTx == detail note ID
                                                                                */
                                                                                let arrLISTx = 
                                                                                        'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                                        'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                        'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                        'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+' x '+`${dataMinimumQty}`+'\n'+
                                                                                        'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                        $('#detailnotesID').append($('<option>' ,{
                                                                                                        value:arrLISTx,
                                                                                                    text:arrLISTx
                                                                                                }
                                                                                            )
                                                                                        )

                                                                        notes.attr("id","detailnotes")
                                                                        notes.attr("class","hidden")
                                                                        notes.html(arrLISTx)

                                                                    $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                        $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                            <div class="row-fluid">
                                                                                        <div class="span12">
                                                                                            <hr>
                                                                                        </div>
                                                                                    </div>
                                                                                <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                            <div class="row-fluid">
                                                                                                <div class="span12">
                                                                                                    <span style="font-size:15px;font-family:Quicksand">
                                                                                                        Perhitungan detail transaksi pengiriman:
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </div>
                                                                                            </div>
                                                                                            <br/>
                                                                                            <span id="xxxzx">
                                                                                        </span>
                                                                                </span>`
                                                                            )
                                                                        }
                                                                    );

                                                                    $("#itemList tr").find("#xxxzx").parent().each(function(){
                                                                        
                                                                        let detail = codxxxx.replace(/"/g, '');
                                                                        
                                                                        $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                    }
                                                                );
                                                                
                                                            $("#exp").hide();
                                                            
                                                            await stall()

                                                            $("#method").show();

                                                            $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)
                                                            
                                                            $('#method').animate('slideFromRight scaleTo', {
                                                                    "custom": {
                                                                        "slideFromRight": {
                                                                        "duration": 4000,
                                                                        
                                                                        "direction": "normal"
                                                                        }
                                                                    }
                                                                });

                                                        return
                                                        
                                                    }  
                                                            else 
                                                                    {

                                                                        let celluuid = $(row.insertCell(6));
                                                                        let notes = $(row.insertCell(7));

                                                                        $("#itemList tr").each(function(){
                                                                                $(this)
                                                                                    .attr("class","parent")
                                                                        });

                                                                        /**
                                                                         * metode ketiga ada nilai reduce value pada itemDiscount
                                                                         **/

                                                                        let btnRemovejc = $("<input />");
                                                                            btnRemovejc.attr("style","cursor:pointer");
                                                                            btnRemovejc.attr("type","button");
                                                                            btnRemovejc.attr("class", "btn btn-danger");
                                                                            btnRemovejc.attr("onclick", "RemoveDetailItemOrdersDiscount(this);");
                                                                            btnRemovejc.val("-");
                                                                            Actions.append(btnRemovejc);

                                                                        Sub_services.html(dataJsons.data.sub_services.name)
                                                                      
                                                                        celluuid.attr("id","uid_services")
                                                                        celluuid.attr("class","hidden")
                                                                        celluuid.html(dataJsons.data.id)

                                                                        ItemList.html('<span id="xxxx"></span>')
                                                                        
                                                                        Qty.html(qty)

                                                                        Price.html("Rp. "+ hasilRatedanMinimalRateX)

                                                                        Actions.html(btnRemovejc)

                                                                        $("#kgSL").hide();
                                                                        $("#sldKSL").hide();
                                                                        $("#rateSL").show();
                                                                        $("#chi").show();

                                                                        $('#subtotal').each(function () {
                                                                            $(this).prop('Counter',0).animate({
                                                                                Counter: totalcategory2
                                                                            }, {
                                                                                duration: 4000,
                                                                                easing: 'swing',
                                                                                step: function (now) {
                                                                                    return $(this).text("Rp. "+Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                                                }
                                                                            });
                                                                        });

                                                                        // datam minimum > qty
                                                                        $("#subtotal").html(`<span id="subtotal">${djl}</span>`)
                                                                        $("#rateFirst").html(`<span> Rate Pertama <span style='margin:0px 58px'>: <span id='rtprtm' class='dds add-on'>${StuckQtys} ${dataUnit} &chi; Rp. ${RateX} = Rp. ${totalQtyRate}</span></span></span>`)
                                                                        $("#rateNexts").html(`<span> Rate kg pertama <span style='margin:0px 33px'>: <span id='kgprtm' class='dds add-on'>Rp. ${dataRateSelanjutnyaX} x ${dataMinimumQty}</span></span></span>`)
                                                                        $("#kgFirst").html(`<span> Kg Minimal <span style='margin:0px 74px'>: <span id='mnimalKG' class='dds add-on'>${dataMinimumQty} ${dataUnit}</span></span></span>`)
                                                                        $("#besides").html(`<span> Rate Selanjutnya <span style='margin:0px 24px'>: <span id='besideDD' class='dds add-on'>Rp. ${totalQtyRate} + Rp. ${droppoint}</span></span></span>`)
                                                                        // $("#besides").html(`<span> Rate Selanjutnya <span style='margin:0px 24px'>: <span id='besideDD' class='dds add-on'>Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}</span></span></span>`)
                                                                        $("#TotalRT").html(`<span> Total Rate <span style='margin:0px 76px'>: <span id='asdasdasd' class='dds add-on'>Rp. ${TotalSaldoRate}</span></span></span>`)

                                                                        $("#clickme").removeAttr('disabled');
                                                                        $("#clickme").html("<i class='icon-plus'></i>");

                                                                        let codxxx = `Kg Minimal       : ${dataMinimumQty} ${dataUnit}`+'<br/>'
                                                                                    +`Kg actual        : ${qty} ${dataUnit}`+'<br/>'
                                                                                    // +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX}`+'<br/>'
                                                                                    +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX} &chi; ${dataMinimumQty}`+'<br>' // modify rate drop point
                                                                                    // +`Rate kg pertama  : Rp. ${dataRateSelanjutnyaX} &chi; ${dataMinimumQty}` +'='+ `${droppoint}`+'<br>' // modify rate drop point
                                                                                    +`Rate pertama     : ${StuckQtys} ${dataUnit}  &chi;  Rp. ${RateX}`+'<br/>'
                                                                                    +`Rate selanjutnya : Rp. ${totalQtyRate} + Rp. ${droppoint}`+'<br/>'
                                                                                    // +`Rate selanjutnya : Rp. ${totalQtyRate} + Rp. ${dataRateSelanjutnyaX}`+'<br/>'
                                                                                    +`Rate             : Rp. ${TotalSaldoRate}` 

                                                                                /** 
                                                                                @arguments [Accurate online detail notes] 
                                                                                @var arrLISTsF == detail note ID
                                                                                */
                                                                                    let arrLISTsF = 
                                                                                        'Perhitungan detail transaksi pengiriman: '+`${dataJsons.data.sub_services.name}`+'\n'+
                                                                                        'Kg Minimal       : '+`${dataMinimumQty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                        'Kg Actual        : '+`${qty} ${JSON.parse(dataUnit)}`+'\n'+
                                                                                        'Rate kg pertama  : '+`Rp. ${dataRateSelanjutnyaX}`+' x '+ `${dataMinimumQty}` +'\n'+
                                                                                        'Rate Pertama     : '+`Rp. ${StuckQtys} ${JSON.parse(dataUnit)} x Rp. ${RateX}`+'\n'+
                                                                                        'Rate Selanjutnya : '+`Rp. ${totalQtyRate} + Rp. ${droppoint}`+'\n'+
                                                                                        'Rate             : '+`Rp. ${TotalSaldoRate}`

                                                                                        $('#detailnotesID').append($('<option>' ,{
                                                                                                        value:arrLISTsF,
                                                                                                    text:arrLISTsF
                                                                                                }
                                                                                            )
                                                                                        )

                                                                            notes.attr("id","detailnotes")
                                                                            notes.attr("class","hidden")
                                                                            notes.html(arrLISTsF)

                                                                        $("#itemList tr").find("#xxxx").parent().each(function(){
                                                                            $(this).html(`<span id="itemov" style="font-family:Quicksand">${dataJsons.data.itemovdesc}</span>
                                                                            <div class="row-fluid">
                                                                                    <div class="span12">
                                                                                        <hr>
                                                                                    </div>
                                                                                </div>
                                                                            <span id="detailnot" style="text-align:left;font-family: Quicksand;font-size:12px"
                                                                                        <div class="row-fluid">
                                                                                            <div class="span12">
                                                                                                <span style="font-size:15px;font-family:Quicksand">
                                                                                                    Perhitungan detail transaksi pengiriman:
                                                                                                </span>
                                                                                                <hr>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br/>
                                                                                        <span id="xxxz">
                                                                                    </span>
                                                                            </span>`
                                                                        )
                                                                    }
                                                                );

                                                                $("#itemList tr").find("#xxxz").parent().each(function(){
                                                                    
                                                                    let detail = codxxx.replace(/"/g, '');
                                                                        
                                                                        $(this).html('<pre><span style="font-size:15px;font-family:Quicksand">Perhitungan detail transaksi pengiriman:</span><br/><br/>'+`${detail}`+'</pre><hr>')
                                                                }
                                                            );

                                                    $("#exp").hide();
                                                    
                                                    await stall()

                                                    $("#method").show();

                                                    $("#method").html(`<span class="badge badge-info">Model Rate - 3</span>`)

                                                    $('#method').animate('slideFromRight scaleTo', {
                                                            "custom": {
                                                                "slideFromRight": {
                                                                "duration": 4000,
                                                                
                                                                "direction": "normal"
                                                                }
                                                            }
                                                        });

                                                return 

                                            }
                                    }
                            }
                    }
            }
    }
    
    $( "#clicksOpenClosed" ).click(function () {
        if ( $( "#hint" ).is( ":hidden" ) ) {
            $( "#hint" ).slideDown( "slow" );
        } else {
            $( "#hint" ).slideUp("slow");
        }
    });

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var contents = this.nextElementSibling;
    if (contents.style.display === "block") {
        setTimeout(function() {
            contents.style.display = "none";
        }, 1000);
    } else {
        setTimeout(function() {
            contents.style.display = "block";
        }, 1000);
    }
});
}

function sum(arrayData, total){
let data =0;
return arrayData.reduce((a,b) => {
    return data += a + b +total
})
}

async function StoreOrderTransport() {
    
    const SuccessAlertsTransportAPI = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 7500
    })

    let customers = $("#customers_name").val();
    let regions = $("#regions").val();
    let id_project = $("#id_project").val();
                
    // origin
    let saved_origin = $("#saved_origin").val();
    let origin = $("#origin").val();
    let origin_city = $("#origin_city").val();
    let origin_address = $("#origin_address").val();
    let pic_phone_origin = $("#pic_phone_origin").val();
    let pic_name_origin = $("#pic_name_origin").val();
    let id_origin_city = $("#id_origin_city").val();

    // destination
    let saved_destination = $("#saved_destination").val();
    let destination = $("#destination").val();
    let destination_city = $("#destination_city").val();
    let destination_address = $("#destination_address").val();
    let pic_phone_destination = $("#pic_phone_destination").val();
    let pic_name_destination = $("#pic_name_destination").val();
    let id_destination_city = $("#id_destination_city").val();

    // detail order
    let sub_servicess = $("#sub_servicess").val();
    let items_tc = $("#items_tc").val();
    let qty = $("#qty").val();
    let harga = $("#rate").val();
    let total_rate = $("#total_rate").val();
    let etd = $("#etd").val();
    let eta = $("#eta").val();
    let time_zone = $("#time_zone").val();

    let collie = $("#collie").val();
    let volume = $("#volume").val();
    let actual_weight = $("#actual_weight").val();
    let chargeable_weight = $("#chargeable_weight").val();
    let notes = $("#notes").val();

    let document_referenceArray = new Array();
    let document_referenceArrayQTY = new Array();
    let document_referenceArrayPRICE = new Array();
    let document_referenceArrayDETAILNOTE = new Array();
    let document_referenceArrayitemDiscount = new Array();
    let document_reference = document.getElementById('itemID');
    let document_referenceQTY = document.getElementById('qtyID');
    let document_referencePRICE = document.getElementById('priceID');
    let document_referenceDETAILNOTES = document.getElementById('detailnotesID');
    let document_referenceitemDiscount = document.getElementById('itemDiscount');

    for (i = 0; i < document_reference.options.length; i++) {

        document_referenceArray[i] = document_reference.options[i].value;

        }

            let itemID = [];

            for (i = 0; i < document_referenceArray.length; i++) {

                itemID.push(document_referenceArray[i]);

    }

    for (i = 0; i < document_referenceQTY.options.length; i++) {

        document_referenceArrayQTY[i] = document_referenceQTY.options[i].value;

        }

            let qtyID = [];

            for (i = 0; i < document_referenceArrayQTY.length; i++) {

                qtyID.push(document_referenceArrayQTY[i]);

        }

        for (i = 0; i < document_referencePRICE.options.length; i++) {

            document_referenceArrayPRICE[i] = document_referencePRICE.options[i].value;

            }

                let priceID = [];

                for (i = 0; i < document_referenceArrayPRICE.length; i++) {

                    priceID.push(document_referenceArrayPRICE[i]);

            }
            
            for (i = 0; i < document_referenceDETAILNOTES.options.length; i++) {

                document_referenceArrayDETAILNOTE[i] = document_referenceDETAILNOTES.options[i].value;

                    }

                        let detailNotesID = [];

                        for (i = 0; i < document_referenceArrayDETAILNOTE.length; i++) {

                            detailNotesID.push(document_referenceArrayDETAILNOTE[i]);

                    }

                    for (i = 0; i < document_referenceitemDiscount.options.length; i++) {

                            document_referenceArrayitemDiscount[i] = document_referenceitemDiscount.options[i].value;

                        }

                            let itemDiscount = [];

                            for (i = 0; i < document_referenceArrayitemDiscount.length; i++) {

                                itemDiscount.push(document_referenceArrayitemDiscount[i]);

                        }

        const apiTransports = "{{ route('transport.stored.static', $some ) }}";
        const dataTransports = { 

                    token : "{{ csrf_token() }}",
                    customers: customers,
                    id_project: id_project,
                    regionName: regions,

                    // origin
                    saved_origin: saved_origin,
                    origin: origin,
                    itemID: itemID,
                    priceID: priceID,
                    qtyID: qtyID,
                    origin_city: origin_city,
                    origin_address: origin_address,
                    pic_phone_origin: pic_phone_origin,
                    pic_name_origin: pic_name_origin,
                    id_origin_city: id_origin_city,

                    // destination 
                    saved_destination: saved_destination,
                    destination: destination,
                    destination_city: destination_city,
                    destination_address: destination_address,
                    pic_phone_destination: pic_phone_destination,
                    pic_name_destination: pic_name_destination,
                    id_destination_city: id_destination_city,

                    // detail order 
                    sub_servicess:sub_servicess, //array
                    items_tc:items_tc, //array
                    harga:harga, //array
                    qty:qty, //array
                    detailNotesID:detailNotesID,
                    itemDiscount:itemDiscount,
                    total_rate:total_rate,
                    eta:eta,
                    etd:etd,
                    time_zone:time_zone,
                    
                    collie:collie,
                    volume:volume,
                    actual_weight:actual_weight,
                    chargeable_weight:chargeable_weight,
                    notes:notes
                   
                };

try 
    {
        const responseTransport = await fetch(apiTransports, {

                method: 'GET',
                cache: 'no-cache',
                credentials: 'same-origin',
                redirect: 'follow',
                referrer: 'no-referrer',
                body: JSON.stringify(dataTransports),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
            }

        });

        const dataJson = await responseTransport.json();
        let TransportPromise = new Promise((resolve, reject) => {
            setTimeout(() => resolve(dataJson), 1000)
        });

            let transportPromises = await TransportPromise;

        //customer 
        $("#customers_name").empty();
        $("#regions").empty();
        // id_project ->  customer in izzy refs['customers_name']
        $("#id_project").val('');
        
        // origin detail
        $("#saved_origin").empty();
        $("#origin").val('');
        $("#origin_city").val('');
        $("#origin_address").val('');
        $("#origin_city").empty();
        $("#pic_phone_origin").val('');
        $("#pic_name_origin").val('');
        $("#id_origin_city").val('');

        // destination detail
        $("#saved_destination").empty();
        $("#destination_city").empty();
        $("#destination").val('');
        $("#destination_city").val('');
        $("#destination_address").val('');
        $("#pic_phone_destination").val('');
        $("#pic_name_destination").val('');
        $("#id_destination_city").val('');

        //detail order transport
        $("#sub_servicess").empty();
        $("#items_tc").empty();
        $("#qty").val('');
        $("#total_rate").val('');
        $("#eta").val('');
        $("#etd").val('');
        $("#time_zone").val('');
        $("#rate").val('');
        
        $("#collie").val('');
        $("#volume").val('');
        $("#actual_weight").val('');
        $("#chargeable_weight").val('');
        $("#notes").val('');
            
        $("#addorders").prop("disabled", false);
        $("#addorders").text("Order Now");

    } 
        catch (errors) {
          
            $.ajaxSetup(
                            {
                                    headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                    }
                )
            ;

            let request = $.ajax({
            
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: apiTransports,
            type: "GET",
            dataType: "json",
            data: dataTransports,
            success: function (data) {

                if(data){

                    let cabang = "{{ $some }}";
                        let link = '{!! route("transport.static", ":cabang")  !!}';
                        let redirect = link.replace(":cabang",cabang)

                        setTimeout(function(){ 

                            window.location.href = redirect;

                    }, 4500);

                } else {

                    const ErrorsAlertsTransportAPI = Swal.mixin({
                        toast: true,
                        position: 'bottom-top',
                        showConfirmButton: false,
                        timer: 7000
                    })

                        ErrorsAlertsTransportAPI.fire({
                            type: 'error',
                            title: `Data gagal disimpan `
                        })

                }
                    
        },
        complete:function(data){

            // TODO: do something with complete arguments
         
        },
            error: function(jqXhr, json, errorThrown){
             
                let responses = $.parseJSON(jqXhr.responseText).errors;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each( responses, function( key, value ) {
                        errorsHtml +=  value[0] +'<br/>';
                    }
                );
                    errorsHtml += '</ul></div>';
                    buttonconfirm = '<div class="badge badge-info closeme" style="font-size:14px;height:19px;width:40px;cursor: pointer">Okay</div>';
                    let TransportPromise = new Promise((resolve, reject) => {
                        setTimeout(() =>        
                                Swal({
                                title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                text: "Maaf proses upload gagal diproses !",
                                    confirmButtonColor: '#3085d6',
                                    html: errorsHtml +'<br/>'+ buttonconfirm,
                                    width: 'auto',
                                    showConfirmButton: false,
                                    // confirmButtonText: '<div class="badge badge-success">Ok</div>',
                                    type: 'error'
                                }).then((result) => {
                                if (result.value) {

                                        return false;
                            
                            }
                    }),
                                $("#addorders").prop("disabled", false),
                                $("#addorders").text("Order Now"), 1000)
                    });
                }
            }
        );

    }
}

function animateVal(obj, start=0, end=100, steps=100, duration=500) {   
    start = parseFloat(start)
    end = parseFloat(end)

    let stepsize = (end - start) / steps
    let current = start
    var stepTime = Math.abs(Math.floor(duration / (end - start)));
    let stepspassed = 0
    let stepsneeded = (end - start) / stepsize

    let x = setInterval( () => {
            current += stepsize
            stepspassed++
            obj.innerHTML = Math.round(current * 1000) / 1000 
        if (stepspassed >= stepsneeded) {
            clearInterval(x)
        }
    }, stepTime)
}   

</script>
@endsection 

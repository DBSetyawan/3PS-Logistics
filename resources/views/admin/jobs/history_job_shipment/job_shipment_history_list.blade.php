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
                                <form action="{{url('transport-list-daterange')}}">
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
                    </form>
                    {{-- <form action="{{url('/export_transport_order')}}"> --}}
                        {{-- <div style="text-align:right;">
                            <div class="form-actions" style="">
                                <button id="export_orders" type="submit" class="btn btn-success">Export To Accurate <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-info" onclick="location.href='{{ url('/transport-order-list') }}'">
                                    <i class="icon-plus"></i>
                                        Transport Order Registration
                                </button>
                            </div>
                        </div> --}}
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                <th bgcolor="#FAFAFA">Code Shipment</th>
                                <th bgcolor="#FAFAFA">Code Job Shipment</th>
                                <th bgcolor="#FAFAFA">Customer</th>
                                <th bgcolor="#FAFAFA">Collie</th>
                                <th bgcolor="#FAFAFA">A.W(kg)</th>
                                <th bgcolor="#FAFAFA">C.W(kg)</th>
                                <th bgcolor="#FAFAFA">Origin Details</th>
                                <th bgcolor="#FAFAFA">Destination Details</th>
                                <th bgcolor="#FAFAFA">Date-Time</th>
                                <th bgcolor="#FAFAFA">status</th>
                                <th bgcolor="#FAFAFA">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data_transport as $transport_order_lists)
                            <tr class="odd gradeX">
                                <td style="width: 13%;">{{ $transport_order_lists->order_id }}</td>
                                <td style="width: 13%;">{{ $transport_order_lists->order_id }}</td>
                                <td style="width: 11%;">{{ $transport_order_lists->customers->name }}</td>
                                <td style="width: 6%">{{ $transport_order_lists->collie }}</td>
                                <td style="width: 6%">{{ $transport_order_lists->actual_weight }}</td>
                                <td style="width: 6%;">{{ $transport_order_lists->chargeable_weight }}</td>
                                <td style="width: 11%;">{{ $transport_order_lists->origin_details }}</td>
                                <td style="width: 11%;">{{ $transport_order_lists->destination_details }}</td>
                                <td style="width: 8%;">{{ $transport_order_lists->created_at }}</td>
                                <td style="width: 5%;"><span class="label label-inverse">{{ $transport_order_lists->cek_status_transaction->status_name }}</span></td>
                                <td style="width: 6%;">
                                    {{ $transport_order_lists->by_users }}
                                </td>
                            </tr>
                            @endforeach()
                        </tbody>
                    </table>
                {{-- </form> --}}
                </div>
            </div>
        </div>
        </div>
    </div>
 </div>
@endsection
@section('javascript')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>

    <!-- BEGIN JAVASCRIPTS -->
    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    @include('sweetalert::view')
   <!-- Load javascripts at bottom, this will reduce page load time -->

   <script src="{{ asset('js/jquery-popup.js') }}"></script>
    {{-- <script src="{{ asset('js/dupselect.min.js') }}"></script> --}}
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

    
</script>
@endsection

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
    <a href="#">Google drive file list</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{-- {{ $menu }} --}}
    <a href="#">File list</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $datax->shipment_id }}
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
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                <th bgcolor="#FAFAFA">Filename</th>
                                <th bgcolor="#FAFAFA"><center>Download List File</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $files)
                          @foreach($files->file_list_pod as $filesx)
                            <tr class="odd gradeX">
                                {{-- <td style="width: 2%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="{{ $transport_order_lists->id}}"></td> --}}
                                <td style="width: 30%;">{{ $filesx }}</td>
                                {{-- <td style="width: 5%;"><div style="text-transform:uppercase">{{++$i}}</div></td> --}}
                                <td style="width: 7%;">
                                <div class="row-fluid">
                                    <div class="span5">
                                            <a href="{{ route('redirect.download.file', ['shipments'=> $files->id,'requestID'=> $filesx]) }}"
                                                 class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                             data-content="File data on server google drive">
                                             <center><i class="icon-file"></i></center>
                                            </a>
                                            {{-- &nbsp; --}}
                                            <a href="{{ route('redirect.preview.filename', ['requestID'=> $filesx]) }}" target="_blank"
                                                class="btn popovers btn-small btn-primary ModalStatusClass" data-toggle="modal" 
                                           data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                            data-content="Preview data on server google drive">
                                            <center><i class="fas fa-eye"></i></center>
                                           </a>
                                        {{-- <button data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button> --}}
                                    </div>
                                   
                                </div>
                            </tr>
                            @endforeach()
                        @endforeach()
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
        </div>
        </div>
    </div>
 </div>
@endsection
@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    @include('sweetalert::view')
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
   <script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
   <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
   <script src="{{ asset('js/jquery.blockui.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
   <!-- ie8 fixes -->   
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
   <script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
   <script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
   <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
   <script src="{{ asset('js/common-scripts.js') }}"></script>
   <!--script for this page only-->
   <script src="{{ asset('js/transport_t_list.js') }}"></script>
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

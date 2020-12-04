@extends('admin.layouts.master')
@section('head')
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <a href="#">Master Item Accurate Cloud</a>
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
       @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
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
                <div class="widget-body" id="app">
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>ItemID Accurate</th>
                                <th>#Item</th>
                                {{-- <th>Customer</th> --}}
                                {{-- <th>Sub service</th> --}}
                                {{-- <th>Moda</th> --}}
                                {{-- <th>Origin</th> --}}
                                {{-- <th>Destination</th> --}}
                                {{-- <th>Unit</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($tableMasterItem as $item_rows)
                            <tr class="odd gradeX">
                                <td aria-readonly="true" style="width: 10%;"><center>{{ $item_rows->item_code }}</center></td>
                                <td aria-readonly="true" style="width: 7%;"><center>{{ $item_rows->itemID_accurate }}</center></td>
                                <td aria-readonly="true" class="rights" style="width: 49%;">{{ $item_rows->itemovdesc }}</td>
                                {{-- <td aria-readonly="true" style="width: 7%;">{{ $item_rows->customers['name'] }}</td> --}}
                                {{-- <td aria-readonly="true" style="width: 8%;">{{ $item_rows->sub_services['name'] }}</td> --}}
                                {{-- <td aria-readonly="true" style="width: 8%;">{{ $item_rows->modas['name'] }}</td> --}}
                                {{-- <td aria-readonly="true" style="width: 17%;">{{ $item_rows->city_show_it_origin['name'] }}</td> --}}
                                {{-- <td aria-readonly="true" style="width: 17%;">{{ $item_rows->city_show_it_destination['name'] }}</td> --}}
                                {{-- <td aria-readonly="true" style="width: 10%;">{{ $item_rows->unit }}</td> --}}
                            </tr>
                          @endforeach()
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
 </div>
@endsection
@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://unpkg.com/vue@2.6.10/dist/vue.js"></script>
{{-- <script src="{{ asset('js/src-vue/layers-master-item-accurate-cloud.js') }}"></script> --}}
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
   @include('sweetalert::view')
 <script src="{{ asset('js/dupselect.min.js') }}"></script>
  <!-- Load javascripts at bottom, this will reduce page load time -->
  <script src="{{ asset('js/jquery-popup.js') }}"></script>
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
  <script src="{{ asset('js/masterItemAccurate.js') }}"></script>
    <script>

      $('#sub_service_id').select2({
            placeholder: 'Cari...',
            ajax: {
              url: '/loaded-items-list',
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
           $('#sample_1 td.rights').css('text-align', 'right');
    </script>
   <!-- END JAVASCRIPTS -->

@endsection

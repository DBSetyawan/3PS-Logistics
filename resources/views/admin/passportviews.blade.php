@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../img/logo.ico" />
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/style-responsive.css" rel="stylesheet" />
    <link href="../css/style-default.css" rel="stylesheet" id="style_color" />
    <link rel="stylesheet" type="text/css" href="../css/like-yt.css" />
    <link rel="stylesheet" type="text/css" href="../assets/select2.4.0.3/select2.min.css" />
    <link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
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
    <a href="#">Moda</a>
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
            <div class="widget red">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> {{ $menu }}</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
                <div class="app">
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </div>
                <div class="widget-body">
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                        <div style="text-align:right;">
                                <button type="button" class="btn btn-info" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="">
                                        <i class="icon-plus"></i>
                                            Add Moda
                                    </button>
                              
                        {{-- <input type="button" value="+ Customer Registration" onclick="location.href='{{ url('customer/registration') }}'"> --}}
                    </div>
                    <div>
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
            </div>
        </div>
        <div class="modal fade" id="add_item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Add Items</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_item" method="post" action="{{url('modasv')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        <br />
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Name</label>
                            <div class="controls">
                                <input class="input-large" type="text" maxlength="30" name="itemid">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Capacity</label>
                            <div class="controls">
                                <input class="input-large" type="text" maxlength="30" name="capc">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Tonase</label>
                            <div class="controls">
                                <input class="input-large" type="text" maxlength="30" name="ton">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <!-- END ADVANCED TABLE widget-->
       <!-- END PAGE CONTENT-->
 </div>
@endsection
@section('javascript')
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../js/jquery-1.8.3.min.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <script src="../js/select2.min.js" type="text/javascript"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>

   <!--common script for all pages-->
   <script src="../js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="../js/table_item_list.js"></script>
    <script>
      $('#compan').select2({
            placeholder: 'Cari...',
            ajax: {
              url: '/load-compan/find',
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

           $('#service').select2({
            placeholder: 'Cari...',
            ajax: {
              url: '/sub-services/find',
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
    
    
    </script>
   <!-- END JAVASCRIPTS -->

@endsection

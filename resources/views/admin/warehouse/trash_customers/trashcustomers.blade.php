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
    <a href="/home">Home</a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Customer</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>
<li class="pull-right search-wrap">
    <form action="search_result.html" class="hidden-phone">
        <div class="input-append search-input-area">
            <input class="" id="appendedInputButton" type="text">
            <button class="btn" type="button"><i class="icon-search"></i> </button>
        </div>
    </form>
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
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
       @endif
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
                  <div style="text-align:right;">
                      @if(count($trashlist))
                        <a onclick="return confirm('Are you sure you want to recover all data?')" style="margin:15px;font-family: courier;font-size: 13px;color:black;border-radius:20px;box-shadow: 0px 0px 10px #000000;" class="btn btn-success" href="{{url('restoreall_customer')}}">&nbsp;Restore all&nbsp;<span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></a>
                      @endif
                  </div>
                  <a class="btn btn-info" href="{{url('customer')}}">Back To Order Customer</a>
                    <div>
                        &nbsp;
                    </div>

                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Sub Services</th>
                                <th>Contract Number</th>
                                <th>SQ Number</th>
                                <th>SO Number</th>
                                <th>Status Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($trashlist as $list)
                          <tr class="odd gradeX">
                              <td style="width: 5%;">{{$list->id}}</td>
                              <td style="width: 5%;">{{$list->order_id}}</td>
                              <td style="width: 20%;">{{$list->customers_warehouse->director}}</td>
                              <td style="width: 15%;">{{$list->sub_service->name}}</td>
                              <td style="width: 20%;">{{$list->contract_no}}</td>
                              <td style="width: 20%;">{{$list->SQ_no}}</td>
                              <td style="width: 20%;">{{$list->SO_no}}</td>
                              <td style="width: 20px;"><span class="label label-inverse">{{$list->warehouse_o_status->status_name}}</span></td>
                              <td style="width: 20px;">
                                <form action="{{route('stored', $list->id)}}" method="post">
                                  <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" class="btn btn-small btn-danger">restore</button>
                                </form>
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
            </div>
        </div>

        <!-- END ADVANCED TABLE widget-->

       <!-- END PAGE CONTENT-->
 </div>
@endsection

@section('javascript')

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../js/jquery-1.8.3.min.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>

   <!--common script for all pages-->
   <script src="../js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="../js/dynamic-table.js"></script>

   <!-- END JAVASCRIPTS -->


@endsection

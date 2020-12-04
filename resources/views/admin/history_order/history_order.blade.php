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
    <a href="#">Sales Order</a>
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
                <div class="widget-body">
                        <div style="text-align:left;">
                        </div>
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th><center>Status</center></th>
                                <th><center>Date Time</center></th>
                                <th>Made By Users</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($history_order_list as $item_rows)
                            <tr class="odd gradeX">
                                <td style="width:6%;">{{ $item_rows->id }}</td>
                                <td style="width: 30%;">{{ $item_rows->order_id }}</td>
                                {{-- @if ($item_rows->status == '1')
                                <td style="width: 20%;"><span class="label label-success">active</span></td>
                                    @elses
                                @endif --}}
                                @if ($item_rows->status == '1')
                                <td style="width: 20%;"><center><span class="label label-inverse">draft</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '2')
                                <td style="width: 20%;"><center><span class="label label-warning">proses</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '3')
                                <td style="width: 20%;"><center><span class="label label-primary">invoice</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '4')
                                <td style="width: 20%;"><center><span class="label label-default">done</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '5')
                                <td style="width: 20%;"><center><span class="label label-important">cancel</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '6')
                                <td style="width: 20%;"><center><span class="label label-warning">upload</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '7')
                                <td style="width: 20%;"><center><span class="label label-info">pod</span></center></td>
                                    @else
                                @endif
                                @if ($item_rows->status == '8')
                                <td style="width: 20%;"><center><span class="label label-success">paid</span></center></td>
                                    @else
                                @endif
                                <td style="width: 20%;"><center>{{ $item_rows->datetime }}</center></td>
                                <td style="width: 20%;">{{ $item_rows->username }}</td>
                            </tr>
                          @endforeach()
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
            </div>
        </div>
        <div class="modal fade" id="add_item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Add Sales</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_item" method="post" action="{{url('sales_order_whs')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        <br />
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Sales order name</label>
                            <div class="controls">
                                <input class="input-large" type="text" maxlength="30" name="sales_name" />
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <div class="modal fade" id="ModalSales" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="add_item" aria-hidden="true" style="width:600px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Update sales</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="updated_sales">
                <br />
                {{-- in progress updated vendor --}}
                <div class="control-group">
                        <label class="control-label" style="text-align: end">Sales order name</label>
                        <div class="controls">
                            <input class="input-large" type="text" maxlength="30" id="sales_name" name="sales_name"/>
                        </div>
                    </div>
        </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
 </div>
@endsection
@section('javascript')

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
   <script src="../js/history_order_list.js"></script>
    <script>
    $(function () {
        $(".ModalSalesClass").click(function (e) {
        e.preventDefault();
            let sales_id = $(this).data('id');
            $.get('/sales-find/'+ sales_id, function(showingdatax){
                $('.modal-body #sales_name').val(''+showingdatax.sales_name);
                    $("#updated_sales").attr('action', '/sales-updated-named/'+showingdatax.id);

                }
            );
        })
    });
    </script>
   <!-- END JAVASCRIPTS -->

@endsection

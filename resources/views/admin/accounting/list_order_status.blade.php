@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../img/logo.ico" />
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/hunterPopup.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/like-yt.css" />
    <link href="../css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
    <link href="../css/style-default.css" rel="stylesheet" id="style_color" />
    <link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" href="../assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
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
                        {{-- <div style="text-align:left;">
                                <button type="button" class="btn btn-info" onclick="location.href='{{ url('warehouse/registration') }}'">
                                        <i class="icon-plus"></i>
                                            Warehouse Order Registration
                                    </button>
                                </div> --}}
                                <form action="{{url('/warehouse-daterange')}}">
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
                    <form action="{{url('/export_warehouse_order')}}">
                        <div style="text-align:right;">
                            <div class="form-actions" style="">
                                <button id="export_orders" type="submit" class="btn btn-success">Export To Accurate <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-info" onclick="location.href='{{ url('warehouse/registration') }}'">
                                    <i class="icon-plus"></i>
                                        Warehouse Order Registration
                                </button>
                            </div>
                        </div>
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                <th bgcolor="#FAFAFA" style="width: 10px;"> Check</th>
                                <th bgcolor="#FAFAFA">Order ID</th>
                                <th bgcolor="#FAFAFA">Customer Name</th>
                                <th bgcolor="#FAFAFA">Sub Services</th>
                                <th bgcolor="#FAFAFA">Contract Number</th>
                                <th bgcolor="#FAFAFA">Volume</th>
                                <th bgcolor="#FAFAFA">Rate</th>
                                <th bgcolor="#FAFAFA">Total Rate</th>
                                <th bgcolor="#FAFAFA">Made by users</th>
                                <th bgcolor="#FAFAFA">Status Order</th>
                                <th bgcolor="#FAFAFA">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @for ($i = 0; $i < $id_auto; $i++) --}}
                        @foreach($warehouseTolist as $list_customer)
                            <tr class="odd gradeX">
                                <td style="width: 6%;"><input type="checkbox" id="check_sales_order[]" name="check_sales_order[]" value="{{$list_customer->id}}"></td>
                                <td style="width: 11%;">{{$list_customer->order_id}}</td>
                                {{-- <td style="width: 5%;"><div style="text-transform:uppercase">{{++$i}}</div></td> --}}
                                <td style="width: 16%;">{{$list_customer->customers_warehouse->name}}</td>
                                <td style="width: 12%;">{{$list_customer->sub_service->name}}</td>
                                <td style="width: 10%;">{{$list_customer->contract_no}}</td>
                                <td style="width: 7%;">{{$list_customer->volume}}</td>
                                <td style="width: 7%;">{{$list_customer->rate}}</td>
                                <td style="width: 7%;">{{$list_customer->total_rate}}</td>
                                <td style="width: 7%;">{{$list_customer->users['name']}}</td>
                                @if ($list_customer->warehouse_o_status->status_name == 'draft')
                                <td style="width: 5%;"><span class="label label-inverse">{{$list_customer->warehouse_o_status->status_name}}</span></td>
                                    @else
                                @endif
                                @if ($list_customer->warehouse_o_status->status_name == 'proses')
                                <td style="width: 5%;"><span class="label label-info">{{$list_customer->warehouse_o_status->status_name}}</span></td>
                                    @else
                                @endif
                                @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                <td style="width: 5%;"><span class="label label-warning">{{$list_customer->warehouse_o_status->status_name}}</span></td>
                                    @else
                                @endif
                                @if ($list_customer->warehouse_o_status->status_name == 'done')
                                <td style="width: 5%;"><span class="label label-success">{{$list_customer->warehouse_o_status->status_name}}</span></td>
                                    @else
                                @endif
                                @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                <td style="width: 5%;"><span class="label label-important">{{$list_customer->warehouse_o_status->status_name}}</span></td>
                                    @else
                                @endif
                                <td style="width: 10%;">
                                    <div class="span5">
                                        <button onclick="location.href='{{ route('warehouse.show', $list_customer->id) }}'" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                    </div>
                                    <div class="span2">
                                        <button onclick="location.href='{{ route('xlsx', $list_customer->id) }}'" data-original-title="Export xml file" data-placement="top" class="btn tooltips btn-small btn-success" type="button"><i class="icon-large icon-cloud-download"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach()
                        {{-- @endfor --}}
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
 {{-- <script src="https://cdn.jsdelivr.net/jquery/1.11.3/jquery.min.js"></script> --}}

<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    @include('sweetalert::view')
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../js/jquery-1.8.3.min.js"></script>
   <script src="../js/jquery-popup.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/jquery.blockui.js"></script>
  <script type="text/javascript" src="../assets/jquery-ui/jquery-ui.js"></script>
   <!-- ie8 fixes -->   
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>

   <script src="../js/common-scripts.js"></script>
   <!--script for this page only-->
   <script src="../js/warehouse_t_list.js"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">
 $('#new_customer').on('click',function(e){
            $('<a href="#" class="show-pop data-placement="auto-bottom"  data-title="Dynamic Title" data-content="Dynamic content"> Dynamic created Pop </a>').appendTo('.pops');
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
    //弹出层中的事件
}

$('#popupReturn').hunterPopup({
    width: '90px',
    height: '40px',
    // title: "jQuery hunterPopup Demo",
    content: $('#tableContent'),
    event: popupEvent
});

});


  
</script>
@endsection

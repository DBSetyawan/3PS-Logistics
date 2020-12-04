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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

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
    <a href="#">Export List Order</a>
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
       @if (\Session::has('error'))
       <div class="alert alert-block alert-error fade in">
             <button data-dismiss="alert" class="close" type="button">×</button>
             <h4 class="alert-heading">Error!</h4>
             <p>{{ \Session::get('error') }}</p>
         </div>
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
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered table-striped" id="sample_1">
                        <thead>
                            <tr>
                                <th><center>URLs</center></th>
                                {{-- <th>Path</th> --}}
                                <th><center>Detail file</center></th>
                                <th><center>Export By</center></th>
                                <th><center>Status File</center></th>
                                <th>Created</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- in progress show it data with export to server --}}
                    @for ($i = 0; $i < $gens; $i++)
                        @foreach ($files as $item)
                            <tr class="odd gradeX">
                                {{-- <td style="width: 45%;"></td> --}}
                                <td>
                                    <a style="width: 43%;" class="{{++$i}}" href="{{ route('storage_path_download', array($some, $item->id)) }}" target="_blank">
                                        <center>Download link</center>
                                    </a>
                                </td>
                                {{-- <td style="wisdth: 12%;">{{$item->path}}<div style="text-transform:uppercase"></div></td> --}}
                                {{-- <td style="widths: 10%;">
                                  <button onclick="location.href='{{ route('storage_path_download', $item->id) }}'" class="btn btn-small btn-primary" type="button"><i class="icon-large icon-cloud-download"> Export</i></button><div><br />
                                </td> --}}
                                <td>
                                    <a style="width: 48%;" href="{{ route('show_it_xml_order_list', array($some, $item->fieldname)) }}">
                                        <center>{{$item->fieldname}}</center>
                                    </a>
                                </td>
                                <td style="width: 29%;"><center>{{$item->user_by}}</center></td>
                                @if ($item->status_download == '1')
                                <td style="width: 10%;"><center><i class="fas fa-check"></i></center></td>
                                    @else
                                     <td style="width: 12%;"><center><i class="fas fa-exclamation-circle label-danger"></i></center></td>
                                @endif
                                <td style="width: 14%;">{{ $item->created_at->diffForHumans() }}</td>
                                {{-- <td style="width: 3%;">
                                    <div class="span4">
                                        <a href="#" data-target="#ModalStatusOrder" data-toggle="modal" class="ModalStatusClass"
                                            data-id="{{ $item->id }}" ><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                        </div>
                                    </td> --}}
                            </tr>
                              @endforeach()
                          @endfor
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="ModalStatusOrder" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="add_item" aria-hidden="true" style="width:600px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Update your status order</h3>
                </div>
                <div id="modals" class="modal-body">
                    <form class="form-horizontal" id="update_data_status_whs">
                        <br />
                        {{-- in progress updated vendor --}}
                        {{-- <div class="control-group">
                                <label class="control-label" style="text-align: end">Update Status</label>
                                <div class="controls">
                                    <select class="updated_status_warehouse_whs form-control validate[required]" style="width:250px;" id="updated_status_warehouse" name="updated_status_warehouse">
                               
                                </select>
                            </div>
                        </div> --}}
                </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button id="asdzx" type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
              </div>
            </div>
        </div>
 </div>
@endsection
@section('javascript')
<script src="../js/select2.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
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
<script src="{{ asset('js/table_exportsx.js') }}"></script>
   <!--script for this page only-->
<script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">

        $(function () {
            $(".ModalStatusClass").click(function (e) {
            e.preventDefault();
                let status_order_id = $(this).data('id');
                $.get('/updated-status-name-order/'+ status_order_id, function(showingdatastatus){
                    // console.log(showingdatastatus)
                // $('.modal-body #cost').val(''+showingdata.cost);
                $("#update_data_status_whs").attr('action', '/updated-status-order/'+status_order_id+'/xml-file-id='+showingdatastatus);
                $('#modals').html('<label style="font-family:Fira Code">Proses -> Upload</label><br/>'+
                '<label style="font-family:Fira Code">Upload -> POD</label><br/>'+
                '<label style="font-family:Fira Code">POD -> Invoice</label><br/>'+
                '<label style="font-family:Fira Code">Invoice -> PAID</label><br/>'+
                '<label style="font-family:Fira Code">Jika status done, dan cancel maka tidak merubah status apapun.</label>&nbsp;'+
                '<label style="color:red">*</label><label style="font-family:Fira Code">Sistem akan membaca status secara otomatis dengan ketentuan diatas.</label><br/>');
                        //         $('.updated_status_warehouse_whs').select2({
                        //             placeholder: 'Cari...',
                        //             ajax: {
                        //                 url: '/load-status-order-warehouse-perfiles/'+showingdatastatus,
                        //                 dataType: 'json',
                        //                 delay: 250,
                        //                 processResults:   function (data) {
                        //                     return {
                        //                         results: $.map(data, function (item) {
                        //                             return {
                        //                                 text: item.status_name,
                        //                                 id: item.id
                        //                         }
                        //                     })
                        //                 };
                        //             },
                        //                 cache: true
                        //         }
                        //     }
                        // );
                    }
                );
            })
        });


</script>
@endsection

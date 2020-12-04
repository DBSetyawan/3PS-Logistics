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
    <a href="#">Warehouse Item List</a>
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
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                        <div style="text-align:right;">
                                <button type="button" class="btn btn-info" data-placement="top" id="modal" data-toggle="modal" data-target="#add_item" data-whatever="">
                                        <i class="icon-plus"></i>
                                            Add Item
                                    </button>
                        {{-- <input type="button" value="+ Customer Registration" onclick="location.href='{{ url('customer/registration') }}'"> --}}
                    </div>
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Sub Service</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Unit</th>
                                {{-- <th>Created By</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(Auth::User()->name == "Administrator")
                          @foreach($table_items_administrator as $item_rows)
                            <tr class="odd gradeX">
                                <td aria-readonly="true" style="width: 15%;">{{ $item_rows->itemno }}</td>
                                <td style="width: 26%;">{{ $item_rows->sub_service->name }}</td>
                                <td style="width: 30%;">{{ $item_rows->itemovdesc }}</td>
                                <td style="width: 10%;">{{ $item_rows->price }}</td>
                                <td style="width: 10%;">{{ $item_rows->unit }}</td>
                                {{-- <td style="width: 39%;">{{ $users->name }}</td> --}}
                                {{-- <td style="width: 60px;">
                                  <button onclick="location.href='{{ route('items.show', $item_rows->id) }}'" class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button>
                                </td> --}}
                                @php
                                    $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($item_rows->id);   
                                @endphp
                                <td style="width: 30px;">
                                        <a href="{{ route('items.show', $encrypts)}}"><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                  </td>
                            </tr>
                          @endforeach()
                            @else
                                @foreach($users as $item_rows)
                                <tr class="odd gradeX">
                                    <td style="width: 15%;">{{ $item_rows->itemno }}</td>
                                    <td style="width: 26%;">{{ $item_rows->sub_service->name }}</td>
                                    <td style="width: 30%;">{{ $item_rows->itemovdesc }}</td>
                                    <td style="width: 10%;">{{ $item_rows->price }}</td>
                                    <td style="width: 10%;">{{ $item_rows->unit }}</td>
                                    {{-- <td style="width: 39%;">{{ $users->name }}</td> --}}
                                    {{-- <td style="width: 60px;">
                                    <button onclick="location.href='{{ route('items.show', $item_rows->id) }}'" class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button>
                                    </td> --}}
                                    @php
                                        $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($item_rows->id);   
                                    @endphp
                                    <td style="width: 30px;">
                                        <a href="{{ route('update.item.service', array( $some, $encrypts))}}"><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                    </td>
                                </tr>
                            @endforeach()
                        @endif
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
                    <h3 id="myModalLabel1">Add Items</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_item" method="post" action="{{url('items')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        <br />
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Item ID</label>
                            <div class="controls">
                                <input readonly="true" class="input-large" type="text" maxlength="30" name="itemid" value="{{ $item_id }}" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Sub Service</label>
                            <div class="controls">
                                <select class="input-large m-wrap" style="width:224px" tabindex="1" id="sub_service_id" name="sub_service_id">
                                    @foreach($sub_service as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                    @endforeach()
                            </select>
                        </div>
                    </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Description</label>
                                <div class="controls">
                                    <input class="input-large" type="text" maxlength="30" name="itemovdesc" />
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                                </div>
                            </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Price</label>
                            <div class="controls">
                            <input class="input-large" type="text" maxlength="30" name="price" />
                                {{-- <span class="help-inline">Some hint here</span> --}}
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Unit</label>
                        <div class="controls">
                            <select class="input-large m-wrap" style="width:224px" tabindex="1" id="unitpcs" name="unitpcs">
                                <option value="m²">m²</option>
                                <option value="m³" selected="selected">m³</option>
                                <option value="pallet">Pallet</option>
                        </select>
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
 @foreach($users as $ist)
 <div class="modal fade" id="myModal1{{$ist->id}}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="edven" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Detail data item</h3>
        </div>
        <div class="modal-body{{$ist->id}}">
            <form class="form-horizontal" id="edven" method="post" action="{{route('items.update', $ist->id)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                {{ method_field('PUT') }}
                <br />
                <div class="control-group">
                        <label class="control-label" style="text-align: end">Description</label>
                        <div class="controls">
                            <input class="input-large" type="text" maxlength="30" value="{{$ist->itemovdesc}}" name="itemovdesc" />
                        </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label" style="text-align: end">Price</label>
                            <div class="controls">
                                <input class="input-large" type="text" maxlength="30" value="{{$ist->price}}" name="price" />
                            </div>
                        </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Sub Service</label>
                    <div class="controls">
                        <select class="input-large m-wrap" tabindex="1" id="sub_service_id" name="sub_service_id">
                            @foreach($sub_service as $a)
                                <option value="{{ $a->id }}" @if($a->id==$ist->sub_service_id) selected='selected' @endif >{{ $a->name }}</option>
                            @endforeach()
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
@endforeach
@endsection
@section('javascript')
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
  <script src="{{ asset('js/table_item_list.js') }}"></script>
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
    </script>
   <!-- END JAVASCRIPTS -->

@endsection

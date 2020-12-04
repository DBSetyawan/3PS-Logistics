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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css">
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
    <a href="#">Vehicle</a>
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
                        {{-- @if(count($trashlist))
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
                    @endif --}}
                        <div style="text-align:left;">
                        {{-- @if(count($trashlist))
                            <a onclick="location.href='{{url('customer_trashed')}}'"<i style="font-size:2pc" class="btn icon-trash"><span class="badge badge-warning" style="color:red">{{ count($trashlist) }}</span></i> </a>
                        @endif --}}
                        </div>
                        <div style="text-align:right;">
                                <button type="button" class="btn btn-info" onclick="location.href='{{ route('registration.vehicle', array($some)) }}'">
                                        <i class="icon-plus"></i>
                                            Vehicle Registration
                                    </button>
                        {{-- <input type="button" value="+ Customer Registration" onclick="location.href='{{ url('customer/registration') }}'"> --}}
                    </div>
                    <div>
                        &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Registration Number</th>
                                <th>Name Owner</th>
                                <th>Manufacture Year</th>
                                <th>Engine Number</th>
                                <th>Type</th>
                                <th>TypeFuel</th>
                                <th>Vehicle I/N</th>
                                {{-- <th>Made by users</th> --}}
                                <th>Created At</th>
                                <th>Date Expired</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($Vehicle as $list_vehicle)
                            <tr class="odd gradeX">
                                <td style="width: 9%;">{{ $list_vehicle->registrationNumberPlate }}</td>
                                <td style="width: 15%;">{{ $list_vehicle->nameOfOwner }}</td>
                                <td style="width: 13%;">{{ $list_vehicle->manufactureYear }}</td>
                                <td style="width: 11%;">{{ $list_vehicle->engineNumber }}</td>
                                <td style="width: 9%;">{{ $list_vehicle->type }}</td>
                                <td style="width: 11%;">{{ $list_vehicle->typeFuel }}</td>
                                <td style="width: 10%;">{{ $list_vehicle->vehicleIdentificationNumber }}</td>
                                <td style="width: 14%;">{{ $list_vehicle->created_at }}</td>
                                <td style="width: 19%;">{{ $list_vehicle->dateOfExpire }}</td>
                                @php
                                    $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($list_vehicle->id);   
                                @endphp
                                <td style="width: 18%;">
                                    <div class="span3">
                                      <button onclick="location.href='{{ route('update.master.vehicle', array( $some , $encrypts)) }}'" 
                                        class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button>
                                    </div>
                                </td>
                            </tr>
                          @endforeach()
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
            </div>
        </div>
        <!-- END ADVANCED TABLE widget-->
        {{-- @foreach($customerlist as $list_customer) --}}
        <div class="modal fade" id="add_item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="add_item" aria-hidden="true" style="width:600px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add Items</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="add_item" method="post" action="{{url('transport_item_customer')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                <br />
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Item Code</label>
                    <div class="controls">
                        <input class="input-larg validate[required]" type="text" maxlength="30" name="itemcode" />
                        {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Customer</label>
                    <div class="controls">
                    <select class="dtcstmers input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="customerx" name="customerx">
                    </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Sub Service</label>
                    <div class="controls">
                        <select class="dtsubservices input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="sub_service_id" name="sub_service_id">
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Shipment category</label>
                <div class="controls">
                    <select class="dtshipmentctgry input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="shipmentx" name="shipmentx">
                </select>
            </div>
        </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Moda</label>
                <div class="controls">
                    <select class="dtmoda input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="moda_x" name="moda_x">
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" style="text-align: end">Origin</label>
            <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="originx" name="originx">
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" style="text-align: end">Destination</label>
        <div class="controls">
                <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="destination_x" name="destination_x">
                </select>
            </div>
        </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Move Description</label>
                    <div class="controls">
                        <textarea class="input-large validate[required]" type="text" maxlength="105" id="itemovdesc" name="itemovdesc"></textarea>
                            {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Unit</label>
                        <div class="controls">
                        <input class="input-large validate[required]" type="text" maxlength="30" name="unit" />
                            {{-- <span class="help-inline">Some hint here</span> --}}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Price</label>
                    <div class="controls">
                    <input class="input-large validate[required]" type="text" maxlength="30" name="price" />
                        {{-- <span class="help-inline">Some hint here</span> --}}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>
{{-- @endforeach --}}
       <!-- END PAGE CONTENT-->
 </div>
@endsection

@section('javascript')

<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
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
<script src="{{ asset('js/dynamic-table.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>

   <!-- END JAVASCRIPTS -->
   <script type="text/javascript">
   window.history.forward();

   function noBack() { 
                  window.history.forward(); 
             }

   $('.citys').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_city',
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

           $('.dtcstmers').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_customer',
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

           $('.dtmoda').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_moda',
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
           
           $('.dtsubservices').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_sub_services',
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

           $('.dtshipmentctgry').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_shipments_category',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.nama,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           $('#destination_x').on('change', function(e){
                let destination = e.target.value;
                $.get('/loaded_auto_search_txt_cs/find/'+ destination, function(data){
                    $.each(data, function(ix, ox){
                        $.get('/loaded_auto_search_txt_cs/find/'+ $('#originx').val(), function(dax){
                            $.each(dax, function(ix, sdx){
                                $.get('/loaded_sub_services_idx/find/'+ $('#sub_service_id').val(), function(dxz){
                                    $.each(dxz, function(ix, sdc){
                                        $.get('/loaded_shipments_category_idx/find/'+ $('#shipmentx').val(), function(dsxz){
                                            $.each(dsxz, function(ix, sdzx){
                                                $.get('/loads_moda/find/'+ $('#moda_x').val(), function(modid){
                                                    $.each(modid, function(ix, idxkpmo){
                                                        $('#itemovdesc').val(''+sdc.name+' '+sdzx.nama+' '+idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name);
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    })
                });
           });
   
   </script>

@endsection

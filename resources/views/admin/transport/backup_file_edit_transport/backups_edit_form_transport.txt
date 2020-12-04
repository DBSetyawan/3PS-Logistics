@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../img/logo.ico" />
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    {{-- <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> --}}
    <link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel=”stylesheet” type=”text/css”>
    {{-- <link rel=”stylesheet” href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> --}}
    {{-- <link href="../assets/sweet-alert/css/sweetalert2.css" rel="stylesheet" /> --}}
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/style-responsive.css" rel="stylesheet" />
    <link href="../css/style-default.css" rel="stylesheet" id="style_color" />
    <link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="../assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="../assets/select2.4.0.3/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="../assets/clockface/css/clockface.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" href="../assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
    <a href="{{ URL::to('warehouse') }}">Warehouse Order List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
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
             <!-- BEGIN PAGE TITLE & BREADCRUMB -->
              <h3 class="page-title">
                   {{ $menu }}
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>
              <!-- END PAGE TITLE & BREADCRUMB -->
          </div>
       </div>
       <!-- END PAGE HEADER-->

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
                    @include('flash::message')
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                        </div><br/>
                    @endif
                        @if ($errors->any())
                          <div class="alert alert-danger">
                              <strong>Whoops!</strong> There were some problems with your input.<br><br>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                        @if (session('success'))
                            <div>
                                {{-- <p>{{ session('success')}}</p> --}}
                            </div>
                        @endif
                        <!-- BEGIN FORM-->
                        <form action="{{route('transport.update', $transport_list->id)}}" class="form-horizontal" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        <input type="hidden" name="code_id" value="{{ $transport_list->order_id }}" class="span12 " />
                        {{ method_field('PUT') }}
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Project</label>
                                            <div class="controls">
                                                <select class="chzn-select" id="project_id" style="width:317px;" name="project_id">
                                                    @foreach ($data_array2 as $item)
                                                        <option value="{{$item['id']}}" @if($item['id']==$data_array1['Project']['id']) selected='selected' @endif>{{$item['name']}}</option>
                                                    @endforeach
                                                    {{-- <option value="{{ $data_array1['Project']['id'] }}">{{  $data_array1['Project']['name'] }}</option> --}}
                                                 </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <hr>
                                        <br />
                                    </div>
                                </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Vendor</label>
                                        <div class="controls">
                                            <select class="chzn-select" id="vendor_id" style="width:317px;" name="vendor_id">
                                                 {{-- @foreach ($data_vendor as $item)
                                                    <option value="{{$item['id']}}" @if($item['id']==$data_array1['Vendor']['id']) selected='selected' @endif>{{$item['name']}}</option>
                                                @endforeach --}}
                                                 {{-- <option value="{{ $data_array1['Project']['id'] }}">{{  $data_array1['Project']['name'] }}</option> --}}
                                             </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Transport</label>
                                        <div class="controls">
                                            <select class="chzn-select" id="transport_id" style="width:317px;" name="transport_id">
                                                    <option value="{{$data_array1['Transporter']['id']}}">{{$data_array1['Transporter']['name']}}</option>
                                                {{-- <option value="{{ $data_array1['Project']['id'] }}">{{  $data_array1['Project']['name'] }}</option> --}}
                                             </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <hr>
                                    <br />
                                </div>
                            </div>
                                <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"> <strong>Informasi PO</strong></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Purchase Order</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="20" value="{{ $data_array1['poCodes']}}" id="purchase_order" name="purchase_order" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <hr>
                                            <br />
                                        </div>
                                    </div>
                                <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"><strong>Informasi Order</strong></label>
                                                <div class="controls">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">Information C\AW\CW</label>
                                                    <div class="controls">
                                                        <div class="input-prepend">
                                                            <input type="text" value="{{ $data_array1['collie'] }}" style="width:200px;" placeholder="Enter Collie" maxlength="5" id="collie" name="collie" required>
                                                            <span class="add-on">Unit</i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="input-prepend">
                                                        <input type="text" value="{{ $data_array1['actualWeight']  }}" maxlength="5" style="width:207px" placeholder="Enter Actual Weight" id="actual_weight" name="actual_weight" required>
                                                    <span class="add-on">Kg</i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="input-prepend">
                                                    <input type="text" value="{{ $data_array1['chargeableWeight'] }}" maxlength="5" style="width:180px" placeholder="Enter Chargeable Weight" id="chargeable_weight" name="chargeable_weight" required>
                                                    <span class="add-on">Kg</i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row-fluid">
                                            <div class="span12">
                                                <hr>
                                            </div>
                                        </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Loading Type</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" id="loadingType" value="{{ $data_array1['loadingType'] }}" name="loadingType" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Service</label>
                                                    <div class="controls">
                                                    <select class="customer_names form-control" id="services" style="width:330px;" name="services">
                                                        {{-- <option value="{{$transport_list->customers_warehouse->id}}" selected="{{$transport_list->customers_warehouse->director}}">{{$transport_list->customers_warehouse->director}}</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">ETD/ETA</label>
                                                    <div class="controls">
                                                        <div class="input-prepend">
                                                            {{-- {{ $data_array1['etd']  }} --}}
                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                            <input readonly="enabled" type="text" style="width:208px;" placeholder="Enter ETD" maxlength="5" id="etd" name="etd" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend">
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                <input readonly="enabled" type="text" maxlength="5" style="width:208px" placeholder="Enter ETA" id="eta" name="eta" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="span2">
                                            <div class="control-group">
                                                <div class="controls">
                                                    <select class="input-small m-wrap popovers" data-trigger="hover" style="width:223px" data-content="Data WOM" data-original-title="Information" id="time_zone" name="time_zone">
                                                        <option value="WIB">WIB</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Origin</label>
                                                    <div class="controls controls-row">
                                                        <input type="text" class="input-block-level" value="{{ $data_array1['Origin']['origin'] }}" placeholder="Enter Origin" id="origin"  name="origin" required>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Destination</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" placeholder="Enter Destination" value="{{ $data_array1['Destination']['destination'] }}" id="destination"  name="destination" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Origin Details</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" value="{{ $data_array1['Origin']['originCompany'] }}" placeholder="Enter Origin Details" id="origin_detail"  name="origin_detail" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Destination Details</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" placeholder="Enter Destination Details" value="{{ $data_array1['Destination']['destinationCompany'] }}" id="destination_detail"  name="destination_detail" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Origin Address</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" placeholder="Enter Origin Address" id="origin_address" value="{{ $data_array1['Origin']['originAddress'] }}" name="origin_address" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Destination Address</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" placeholder="Enter Destination Address" id="destination_address" value="{{ $data_array1['Destination']['destinationAddress'] }}" name="destination_address" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Origin Contact</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" value="{{ $data_array1['Origin']['originContact'] }}" placeholder="Enter Contact Origin" id="origin_contact"  name="origin_contact" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label" >Destination Contact</label>
                                                            <div class="controls controls-row">
                                                                <input type="text" class="input-block-level" placeholder="Enter Contact Destination" value="{{ $data_array1['Destination']['destinationContact'] }}" id="destination_contact"  name="destination_contact" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">Origin Phone</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" value="{{ $data_array1['Origin']['originPhone'] }}" placeholder="Enter Origin Phone Number" id="origin_phone"  name="origin_phone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" >Destination Phone</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" placeholder="Enter Destination Phone Number" id="destination_phone" value="{{ $data_array1['Destination']['destinationPhone'] }}"  name="destination_phone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span11">
                                                    <div class="control-group">
                                                        <label class="control-label">
                                                            Notes
                                                        </label>
                                                        <div class="controls">
                                                            <textarea class="span12" id="notes" name="notes" rows="3" required>{{$data_array1['notes']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                      <div class="form-actions" style="">
                                              {{-- <button type="submit" class="btn btn-success" value="PUT">Update Customer</button> --}}
                                               <button type="submit" class="btn btn-success" value="PUT">
                                                    <i class="icon-refresh"></i>
                                                    Update
                                                </button> 
                                                <a type="button" class="btn btn-primary" href="{{ route('send_invoice', $transport_list->id)}}">Process <i class="icon-circle-arrow-right"></i> <i class="icon-envelope"></i></a>
                                              {{-- <a class="btn btn-info" href="{{ redirect()->To('customer')->getTargetUrl() }}">Order Approved</a> --}}
                                              {{-- <a type="button" class="btn btn-warning" href="{{ route('xlsx', $transport_list->id)}}">Export <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></a> --}}
                                              {{-- <button onclick="location.href='{{ route('xlsx', $transport_list->id) }}'" class="btn btn-small btn-warning" value="RELOAD" type="button"><i class="icon-download-alt"></i></button></div> --}}
                                            </div>
                                    </div>
                                </div>
                            </form>
                            {{-- <form class="span6" action="{{route('customer.destroy', $customers->id)}}" method="post">
                              <!-- {{ method_field('DELETE') }} -->
                              <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                              <input type="hidden" name="_method" value="DELETE">
                              {{-- <button type="submit" class="btn btn-danger">Delete Customer</button> --}}
                              {{-- <button type="submit" class="btn btn-danger" value="PUT">
                                    <i class="icon-remove"></i>
                                    Delete Customer
                                </button>
                            </form> --}}
                         
                            </div>
                        </div>
                    </div>
                </div>
        <!-- END ADVANCED TABLE widget-->
       <!-- END PAGE CONTENT-->
 </div>
</div>
@endsection

@section('javascript')
    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   {{-- <link rel="stylesheet" href="../assets/sweet-alert/css/sweetalert2.min.css"> --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   <script src="../js/jquery-1.8.2.min.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    {{-- @include('sweetalert::view') --}}
   <script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
   <script type="text/javascript" src="../assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script src="../js/select2.min.js" type="text/javascript"></script>
   <script src="../js/jQuery.dualListBox-1.3.js" language="javascript" type="text/javascript"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]--> 
   <script type="text/javascript" src="../assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="../assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="../assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="../assets/typehead/typehead-bundle/typehead.bundle.js"></script>
   <script type="text/javascript" src="../assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="../assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>
  {{-- <script src="../assets/sweet-alert/sweetalert2.common.js"></script> --}}
  {{-- <script src="../assets/sweet-alert/sweetalert2.all.min.js"></script> --}}
  @include('sweetalert::view')
    {{-- @include('sweetalert::view') --}}
   <!--common script for all pages-->
   <script src="../js/common-scripts.js"></script>
   <!--script for this page only-->
   <script src="../js/dynamic-table.js"></script>
   <!--script for this page-->
   <script src="../js/form-component.js"></script>
  <!-- END JAVASCRIPTS -->
   <script language="javascript" type="text/javascript">
    $('.customer_names').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_customers/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        // if (item.suggestion = true) {
                            // $('#city_customer').val('' + item.city.name);
                            // $('#address').val('' + item.address);
                            // $('#phone_customer').val('' + item.phone);
                        // } else {
                                // $('#address').val('');
                                // $('#phone_customer').val('');
                            // }
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
     $('.sub_services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_sub_services',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
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
    $('#sub_services').on('change', function(e){
        let sub_service_id = e.target.value;
        $.get('/search/list_items/'+ sub_service_id, function(data){
            $('#items').empty();
            $.each(data, function(index, Subj){
                $('#items').append($('<option>' ,{
                    value:Subj.id,
                    text:Subj.itemovdesc
                }));
                // $('#rate').val(''+Subj.price);
            });
                $('.items').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/list_items/find/'+ sub_service_id,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.itemovdesc,
                                        id: item.id
                                    }
                                    
                                })
                            };
                        },
                   cache: true
                }
            });
        });
    });
    $('#customers_name').on('change', function(e){
        let customer_id = e.target.value;
        $.get('/search/list_customers/'+ customer_id, function(data){
            $('#customerpics_name').empty();
            $.each(data, function(index, Obj){
                $('#customerpics_name').append($('<option>' ,{
                    value:Obj.id,
                    text:Obj.name
                }));
            });
            //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
            $('.customerpics_name').select2({
                placeholder: 'Cari...',
                ajax: {
                        url: '/list_cs/find/'+ customer_id,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
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
        });
    });
$('#button').click(() => {
  swal({
    title: 'Input something',
    input: 'text',
    showCancelButton: true
  }).then(function(result) {
    if (result) {
      swal({
        type: 'success',
        html: 'You entered: <strong>' + result + '</strong>'
      });
    }
  }).done();
});
 function formatCurrency(nomer) {
            nomer = nomer.toString().replace(/\$|\,/g,'');
            if(isNaN(nomer))
            nomer = "0";
            sign = (nomer == (nomer = Math.abs(nomer)));
            nomer = Math.floor(nomer*100+0.50000000001);
            cents = nomer%100;
            nomer = Math.floor(nomer/100).toString();
            if(cents<10)
            cents = "0" + cents;
            for (var i = 0; i < Math.floor((nomer.length-(1+i))/3); i++)
            nomer = nomer.substring(0,nomer.length-(4*i+3))+'.'+nomer.substring(nomer.length-(4*i+3));
            return (((sign)?'':'-') + 'Rp. ' + nomer + ',' + cents);
        }
       $(function() {
           $.configureBoxes();
       });
            
            $("#addcpics").click(function (event) {
                event.preventDefault();
                const name = $('#customer_namepp').val();
                const id = $('#id_customerd_pic').val();
                const statuspics = $('#statusid_pics').val();
                const id_customer = $('#id_customer').val();
                const position = $('#position_customer').val();
                const email = $('#email_customer').val();
                const phone = $('#phonepics').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    timeout: 1000,
                    cache: false,
                    error: function (x, e) {
                        if (x.status == 0) {
                            alert('Anda sedang offline!\nSilahkan cek koneksi anda!');
                        } else if (x.status == 404) {
                            alert('Permintaan URL tidak ditemukan!');
                        } else if (x.status == 500) {
                            alert('Internal Server Error!');
                        } else if (e == 'parsererror') {
                            alert('Error.\nParsing JSON Request failed!');
                        } else if (e == 'timeout') {
                            alert('Request Time out!');
                        } else {
                            alert('Error tidak diketahui: \n' + x.responseText);
                        }
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ url('customerpics') }}",
                    dataType: "json",
                    data: {
                        id: id,
                        customer_pic_status_id: statuspics,
                        customer_id: id_customer,
                        name: name,
                        position: position,
                        email: email,
                        phone: phone
                    },
                    success: function (data) {
                        alert('Record updated successfully');
                        location.reload();
                    },
                    // function( msg ) {
                    // $("#ajaxResponse").append("<div>"+msg+"</div>");
                    // },
                    error: function (data) {
                        alert("Error")
                    }
                });
            });
                $('.company_braCH').select2({
                placeholder: 'Cari...',
                ajax: {
                    url: '/cari_cbrnch',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.branch,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
         
        $('.customer_names').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/cari_customers/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
             return {
               results:  $.map(data, function (item) {
                   if (item.suggestion=true) {
                    $('#address').val(''+item.address);
                    $('#phone_customer').val(''+item.phone);
                } else {
                    $('#address').val('');
                    $('#phone_customer').val('');
                }
                 return {
                   text: item.director,
                   id: item.id
                 }
               })
             };
            },
            cache: true
            }
         });
       $('.services').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/cari_service',
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
         
         $(document).ready(function(){
          $("#rate").keyup(function(data){
            const volume = parseInt(document.getElementById('volume').value);
             const rate = parseInt(document.getElementById('rate').value);
             let result_rate = parseInt(volume*rate);
                document.getElementById('total_rate').value = result_rate;
          });
        });
        $(document).ready(function() {
           var bloodhound = new Bloodhound({
               datumTokenizer: Bloodhound.tokenizers.whitespace,
               queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                   url: '/cari_customers/find?q=%QUERY%',
                   wildcard: '%QUERY%'
               },
           });
           $('#customer_name').typeahead({
               hint: true,
               highlight: true,
               minLength: 1
           }, {
               name: 'customers',
               source: bloodhound,
               display: function(data) {
                   return data.director
               },
               templates: {
                   empty: [
                       '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                   ],
                   suggestion: function(data) {
                       $('#phone_customer').val(''+data.phone);
                       $('#address').val(''+data.address);
                       return '<div class="dropdown-toggle"><div class="dropdown-menu">' + data.director +'</div></div>'
                   }
               }
           });
        });
          $(document).ready(function(){
              		$("#since").keypress(function(data){
              			if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
              			{
              				$("#since").html('errors')
              				return false;
              			}
              		});
            	});
              $(document).ready(function(){
                $("#tax_no").keypress(function(data){
                  if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                  {
                    $("#tax_no").html('errors')
                    return false;
                  }
                });
            });
            $(document).ready(function(){
              $("#tax_phone").keypress(function(data){
                if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                  $("#tax_phone").html('errors')
                  return false;
                }
              });
          });
          $(document).ready(function(){
            $("#tax_fax").keypress(function(data){
              if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
              {
                $("#tax_fax").html('errors')
                return false;
              }
            });
        });
        $(document).ready(function(){
          $("#phone").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#phone").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#fax").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#fax").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#no_pic").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#no_pic").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#norek").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#norek").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#ph").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#ph").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#rate").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#rate").html('errors')
              return false;
            }
          });
        });
        $(document).ready(function(){
          $("#mb").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#mb").html('errors')
              return false;
            }
          });
        });
        
        $(document).ready(function(){
          $("#term_of_payment").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
              $("#term_of_payment ").html('errors')
              return false;
            }
          });
        });
   </script>
@endsection
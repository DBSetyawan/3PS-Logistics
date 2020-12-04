@extends('admin.layouts.master')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
{{-- <link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" /> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css"
 integrity="sha256-zTY9D4Ql1rJxwU7l1qjWk8OqEyO2SXm2nGnSZmGScwM=" crossorigin="anonymous" />
@endsection
@section('brand')
<a class="brand" href="/home">
    {{-- <img src="../img/logo.png" alt="Tiga Permata System" /> --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="/warehouse">Warehouse Order List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
</li>
@endsection

@section('content')

<div id="main-content" style="height:1335px;">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        {{-- <a href="javascript:;" class="btn btn-success" id="add-sticky">Sticky</a> --}}
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
        @include('flash::message')
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        @if (\Session::has('warning'))
        <div class="alert alert-warning">
            <p>{{ \Session::get('warning') }}</p>
        </div>
        @endif
        @if (\Session::has('error'))
        <div class="alert alert-danger">
          <p>{{ \Session::get('error') }}</p>
        </div>
       @endif
       <div id="progress" class="waiting">
            <dt></dt>
            <dd></dd>
        </div>
{{-- <p class="animated infinite bounce delay-5s">ekodaskdoaskdo</p> --}}
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
                        <form id="warehouse_order" action="{{ url('warehouse') }}" class="form-horizontal" method="POST">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                            <input type="hidden" id="id_pics" name="id_pics" value="{{ $wrhouse_id }}" class="span12 " />
                            
                            <div id="tabsleft" class="tabbable tabs-left">
                                <ul>
                                    <li><a href="#tabsleft-tab1" data-toggle="tab"><span class="strong">Company Branch</span> <span class="muted">Company<div>Branchs Details</div></span></a></li>
                                    <li><a href="#tabsleft-tab2" data-toggle="tab"><span class="strong">Customer/PIC</span> <span class="muted">Customers <div>Details</div></span></a></a></li>
                                    <li><a href="#tabsleft-tab3" data-toggle="tab"><span class="strong">Order Registration</span> <span class="muted">Warehouse <div>Order Details</div></span></a></a></li>
                                </ul>
                                <div class="progress progress-info progress-striped">
                                    <div class="bar"></div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="tabsleft-tab1">
                                    <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Company Branch</label>
                                                    <div class="controls">
                                                        {{-- <select class="chzn-select validate[required]" id="cbrach" style="width:317px;" name="cbrach">
                                                           <option> -- Please Choosen first -- </option>
                                                            @foreach ($brnchs as $cabang)
                                                            <option value="{{ $cabang->id }}" @if($cabang->id==$getter_branch_user) selected="selected" @endif>{{ $cabang->branch }}</option>
                                                                {{-- <option value="{{$cabang->id}} {{(old('cbrach') == $cabang?'selected':'')}}">{{$cabang->branch}}</option> --}}
                                                            {{-- @endforeach
                                                        </select> --}} 
                                                        
                                                        <label style="color: black;font-family: Fira Code"> {{ $request_branch->branch }} </label>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <br>
                                                                    {{-- @if ($errors->has('cbrach'))
                                                                    <span class="alert alert-danger span12" style="width:300px;text-align: center">{{ $errors->first('cbrach') }}</span>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                    <div class="span12">
                                                        <br />
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                        <div class="span12">
                                                            <br />
                                                        </div>
                                                    </div>
                                                    <div class="row-fluid">
                                                            <div class="span12">
                                                                <br />
                                                            </div>
                                                        </div>
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsleft-tab2">
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Customer Name</label>
                                                    <div class="controls">  
                                                        <select class="customer_names form-control validate[required]" id="customers_name" style="width:329px;" name="customers_name" required>
                                                            {{-- <option value="{{$warehouseTolist->customers_warehouse->id}}"
                                                                selected="{{$warehouseTolist->customers_warehouse->director}}">{{$warehouseTolist->customers_warehouse->director}}</option>
                                                            --}}
                                                            @foreach($cshfasd as $data)
                                                            <option value="{{ $data->id }}" @if(old('customers_name') == $data->id) selected @endif> {{ $data->name }} </option>
                                                           @endforeach
                                                        </select>
                                                        <div class="row-fluid">
                                                            <br />
                                                                <div class="span12">
                                                                    <div style="text-align:end">
                                                                    <a id="new_customer" type="button" class="btn btn-success popovers" data-trigger="hover" data-content="Tambahkan, jika customer tidak ditemukan." data-original-title="Informasi User" onclick="location.href='{{ url('/customer/registration') }}'"><i class="icon-plus"></i> Add New Customer</a>
                                                             </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">Customer Name PIC</label>
                                                        <div class="controls">  
                                                            <select class="customerpics_name form-control" id="customerpics_name" style="width:280px;" name="customerpics_name">
                                                                {{-- <option value="{{$warehouseTolist->customers_warehouse->id}}"
                                                                    selected="{{$warehouseTolist->customers_warehouse->director}}">{{$warehouseTolist->customers_warehouse->director}}</option>
                                                                --}}
                                                            </select>
                                                            <div class="row-fluid">
                                                                <div class="span12">
                                                                    <br>
                                                                        {{-- @if ($errors->has('customers_name'))
                                                                    <span id="customers_name_error" class="alert alert-danger span12" style="width:300px;text-align: center">{{ $errors->first('customerpics_name') }}</span>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsleft-tab3">
                                            <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label">Sales Name</label>
                                                            <div class="controls">
                                                                <select class="sales_name_order form-control validate[required]" id="sales_name_order" style="width:330px;" name="sales_name_order" required>
                                                                    {{-- <option value="{{$warehouseTolist->sub_service->id}}" selected="{{$warehouseTolist->sub_service->name}}">{{$warehouseTolist->sub_service->name}}</option>
                                                                    --}}
                                                                    {{-- @foreach($subservices as $data)
                                                                    <option value="{{ $data->id }}" @if(old('sub_services') == $data->id) selected @endif> {{ $data->name }} </option>
                                                                   @endforeach --}}
                                                                </select>
                                                                <div class="row-fluid">
                                                                    <div class="span8">
                                                                        <br>
                                                                        {{-- @if ($errors->has('sub_services'))
                                                                        <span id="ssrvcs_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('sub_services') }}</span>
                                                                    @endif --}}
                                                                </div>
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
                                                    <div class="span12">
                                                        <div class="control-group">
                                                            <label class="control-label" style="font-family: 'Courier', monospace;font-size:15px;font: bold;"> <strong>Informasi Service</strong></label>
                                                            <div class="controls">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label">Sub Service</label>
                                                            <div class="controls">
                                                                <select class="sub_services form-control validate[required]" id="sub_services" value="{{ old('sub_services') }}" style="width:330px;" name="sub_services" required>
                                                                    {{-- <option value="{{$warehouseTolist->sub_service->id}}" selected="{{$warehouseTolist->sub_service->name}}">{{$warehouseTolist->sub_service->name}}</option>
                                                                    --}}
                                                                    {{-- @foreach($subservices as $data)
                                                                    <option value="{{ $data->id }}" @if(old('sub_services') == $data->id) selected @endif> {{ $data->name }} </option>
                                                                   @endforeach --}}
                                                                </select>
                                                                <div class="row-fluid">
                                                                    <div class="span8">
                                                                        <br>
                                                                        {{-- @if ($errors->has('sub_services'))
                                                                        <span id="ssrvcs_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('sub_services') }}</span>
                                                                    @endif --}}
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="control-group">
                                                                <label class="control-label">Item</label>
                                                                <div class="controls">
                                                                    <select class="items form-control validate[required]" id="items" style="width:330px;" name="items" required>
                                                                    </select>
                                                                    <div class="row-fluid">
                                                                        <div class="span8">
                                                                            <br>
                                                                            {{-- @if ($errors->has('items'))
                                                                            <span id="items_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('items') }}</span>
                                                                        @endif --}}
                                                                    </div>
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
                                                            <div class="span12">
                                                                <div class="control-group">
                                                                    <label class="control-label" style="font-family: 'Courier', monospace;font-size:14px;font: bold;"> <strong>Informasi Contract</strong></label>
                                                                    <div class="controls">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                          <div class="row_fuild">
                                                            <div class="span6">
                                                                <label class="control-label">Start Date/ End Date</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend">
                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                        <input id="start_date" class="validate[custom[date]]" value="{{ old('start_date') }}" name="start_date" type="text" placeholder="Choose Start Date" class="m-ctrl-medium" required>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                            <div class="span4">
                                                                <div class="control-group">
                                                                    <div class="input-prepend">
                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                        <input id="end_date" class="validate[custom[date]]" value="{{ old('start_date') }}" name="end_date" type="text" placeholder="Choose End Date" class="m-ctrl-medium" required>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row_fluid">
                                                        <div class="span4">
                                                                <div class="control-group">
                                                                    <label class="control-label">Contract Number#</label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="20" placeholder="if you establish a contract, fill in this menu" id="contract_no" name="contract_no" value="{{ old('contract_no') }}"  style="width:260%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <div class="control-group">
                                                                    <label class="control-label">
                                                                        <strong>Keterangan</strong>
                                                                    </label>
                                                                    <div class="controls">
                                                                        <textarea class="span12" id="remark" name="remark" value="{{ old('remark') }}" rows="3"></textarea>
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
                                                                <div class="span12">
                                                                    <div class="control-group">
                                                                        <label class="control-label" style="font-family: 'Courier', monospace;font-size:15px;font: bold;"> <strong>Informasi Details</strong></label>
                                                                        <div class="controls">
                                                                            <hr>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <div class="row-fluid">
                                                                <div class="span5">
                                                                    <div class="control-group">
                                                                        <label class="control-label">Volume</label>
                                                                        <div class="controls">
                                                                            <input type="text" class="validate[required,custom[onlyLetterNumber]]" style="width;320px" value="{{ old('volume') }}" maxlength="9" id="volume" placeholder="Enter volume" name="volume" required>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                    <div class="span7">
                                                                            <div class="control-group">
                                                                                <select class="input-small m-wrap popovers" data-trigger="hover" data-content="Data UOM" data-original-title="Information" id="uom" name="uom">
                                                                                    <option value="m²">m²</option>
                                                                                    <option value="m³" selected="selected">m³</option>
                                                                                    <option value="pallet">Pallet</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <div class="row-fluid">
                                                                    <div class="span3">
                                                                                <div class="control-group">
                                                                                        <label class="control-label">Rate Price/ Total Price</label>
                                                                                        <div class="controls">
                                                                                            <div class="input-prepend input-append">
                                                                                                <span class="add-on">Rp</span><input type="text" class="validate[required,custom[onlyLetterNumber]]" placeholder="Enter rate price" value="{{ old('rate') }}" maxlength="10" id="rate" name="rate" style="width;248%"
                                                                                                required>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- @if ($errors->has('rate')) --}}
                                                                                    {{-- <span class="alert alert-danger span12" style="width:230px;text-align: center">{{$errors->first('rate')}}</span> --}}
                                                                                {{-- @endif --}}
                                                                        </div>
                                                                    </div>
                                                                <b><span id="format"></span></b>
                                                            </div>
                                                            <div class="row-fluid">
                                                            <div class="span9">
                                                            <div class="control-group">
                                                                <label class="control-label">Result price</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                    <span class="add-on">Rp</span>
                                                                    <input readonly="enabled"
                                                                        type="text" id="total_rate" value="{{ old('total_rate') }}" name="total_rate" style="width;400px" required>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                            <div class="row-fluid">
                                                <div class="span12" style="text-align:right;">
                                                    <div class="form-actions" style="">
                                                        <button id="addorders" type="submit" class="btn btn-success">Submit Your Order</button>
                                                        {{-- <a href="#myModal3" role="button" type="submit" class="btn btn-primary" data-toggle="modal">Confirm</a> --}}
                                                        <a class="btn btn-warning" href="{{ route('accwhs.static', session()->get('id')) }}">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous first"><a href="javascript:;">First</a></li>
                                        <li class="previous"><a href="javascript:;">Previous</a></li>
                                        {{-- <li class="next last"><a href="javascript:;">Last</a></li> --}}
                                        <li class="next"><a href="javascript:;">Next</a></li>
                                        {{-- <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li> --}}
                                        <li style="display:none;"><a  href="javascript:;">Finish</a></li>
                                    </ul>
                                    {{-- <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel3">Confirm Header</h3>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>
                                                    <p>{{$modal_list->order_id}}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                                {{-- <button id="addorders" type="submit" class="btn btn-success">Submit Your Order</button> --}}
                                                {{-- <button type="button" class="btn">Cancel</button> --}}
                                            {{-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> --}}
                                            {{-- <button data-dismiss="modal" class="btn btn-primary">Confirm</button> --}}
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                             </div>
                            </div>
                        <!-- BEGIN FORM-->
                        </form>
                    </div>
                        </div>
                    </div>
                        <!-- END FORM-->
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>

<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>

<script src="{{ asset('assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/form-wizard.js')}}"></script>

<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>

<!--script for this page only-->
<!-- ie8 fixes -->
<!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js" integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>

<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>


<script language="javascript" type="text/javascript">
    window.history.forward();
                function noBack() { 
                    window.history.forward(); 
                }


// $("form").validate();
// $("#warehouse_order").validationEngine();
$(document).ready(function() {
    $('#contract_no').val('');
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

 $("#addcpics").click(function(event) {
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
            error:function(x,e){
                if(x.status==0){
                    alert('Anda sedang offline!\nSilahkan cek koneksi anda!');
                }   else if(x.status==404){
                      alert('Permintaan URL tidak ditemukan!');
                   }   else if(x.status==500){
                        alert('Internal Server Error!');
                       }   else if(e=='parsererror'){
                            alert('Error.\nParsing JSON Request failed!');
                }   else if(e=='timeout'){
                        alert('Request Time out!');
                }else {
                    alert('Error tidak diketahui: \n'+x.responseText);
                }
            }
        });

    $.ajax({
        type: "post",
        url: "{{ url('customerpics') }}",
        dataType: "json",
        data: {
            id:id,
            customer_pic_status_id:statuspics,
            customer_id:id_customer,
            name:name,
            position:position,
            email:email,
            phone:phone
                  },
                    success: function (data) {
                        alert('Record updated successfully');
                            location.reload();
                    },
                // function( msg ) {
                // $("#ajaxResponse").append("<div>"+msg+"</div>");
            // },
        error: function(data){
             alert("Error")
        }
    });
});

function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#uom').bind('keypress', testInput);
$('#customers_pics_error').delay(2000).fadeOut('slow');
$('#customers_name_error').delay(2500).fadeOut('slow');
$('#ssrvcs_error').delay(3000).fadeOut('slow');
$("#items").prop("disabled", true);
$('#items_error').delay(3500).fadeOut('slow');


function test(params) {
    test = $('#remark').val();
    // alert(test);
    $('#totest').val(test);
}

    // function formatCurrency(nomer) {

    //     nomer = nomer.toString().replace(/\$|\,/g, '');
    //     if (isNaN(nomer))

    //     nomer = "0";
    //     sign = (nomer == (nomer = Math.abs(nomer)));
    //     nomer = Math.floor(nomer * 100 + 0.50000000001);
    //     cents = nomer % 100;
    //     nomer = Math.floor(nomer / 100).toString();

    //     if (cents < 10)
    //         cents = "0" + cents;

    //     for (var i = 0; i < Math.floor((nomer.length - (1 + i)) / 3); i++)
    //         nomer = nomer.substring(0, nomer.length - (4 * i + 3)) + '.' + nomer.substring(nomer.length - (4 * i + 3));

    //     return (((sign) ? '' : '-') + 'Rp. ' + nomer + ',' + cents);

    // }

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
    
    $('.services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_service',
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

    $('.sales_name_order').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/search/loaded-sales',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.sales_name,
                            id: item.id
                        }
                        
                    })
                };
            },
            cache: true
        }
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

      $('#sub_services').on('change', function(e){
        let sub_service_id = e.target.value;
        $("#items").prop("disabled", false);
        $.get('/search/list_items/'+ sub_service_id, function(data){
            $('#items').empty();
            $.each(data, function(index, Subj){
                $('#items').append($('<option>' ,{
                    value:Subj.id,
                    text:Subj.itemovdesc
                }));
            });
            let idx = document.getElementById("items").value
                $.get('/item_price/find/'+ idx, function(data){
                    $.each(data, function(index, Subj){
                        $('#rate').val(''+Subj.price);
                    });
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

    $('.items').on('change', function(e){
        let items = e.target.value;
        $.get('/item_price/find/'+ items, function(data){
            $.each(data, function(index, Subj){
                $('#rate').val(''+Subj.price);
            });
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
            cache: false
        }
    });

     $(function() {
        $("#start_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

        $(function() {
            $("#end_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        $(document).ready(function () {
            $("#rate").keyup(function (data) {
                const volume = parseInt(document.getElementById('volume').value);
                const rate = parseInt(document.getElementById('rate').value);

                let result_rate = parseInt(volume * rate);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

        $(document).ready(function () {
            $("#volume").keyup(function (data) {
                const volume = parseInt(document.getElementById('volume').value);
                const rate = parseInt(document.getElementById('rate').value);

                let result_rate = parseInt(rate * volume);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

    $(document).ready(function () {
        $("#volume").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#volume").html('errors')
                return false;
            }
        });
    });

      $(document).ready(function () {
        $("#rate").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#rate").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#tax_no").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#tax_no").html('errors')
                return false;
            }
        });
    });
    $(document).ready(function () {
        $("#tax_phone").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#tax_phone").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#no_rek").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#no_rek").html('errors')
                return false;
            }
        });
    });
    $(document).ready(function () {
        $("#term_of_payment").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#term_of_payment").html('errors')
                return false;
            }
        });
    });
    $(document).ready(function () {
        $("#phone").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#phone").html('errors')
                return false;
            }
        });
    });
    $(document).ready(function () {
        $("#tax_fax").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#tax_fax").html('errors')
                return false;
            }
        });
    });
    $(document).ready(function () {
        $("#fax").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#fax").html('errors')
                return false;
            }
        });
    });

    $("#since").datepicker({
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    
    $('.type_of_business').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/search_type_of_business',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.industry,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

</script>

@endsection
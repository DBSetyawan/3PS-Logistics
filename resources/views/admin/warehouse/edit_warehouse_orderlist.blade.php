@extends('admin.layouts.master', array('order_id' => session()->get('order_id')))
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
                        <form id="updatewhs" class="form-horizontal" method="GET">
                            @method('post')
                            @csrf
                          {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " /> --}}
                        
                            {{-- <div class="row-fluid"> --}}
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Company Branch</label>
                                            <div class="controls">
                                                <select class="chzn-select" id="cbrach" style="width:317px;" name="cbrach">
                                                    <option> -- Please Choosen first -- </option>
                                                     @foreach ($brnchs as $cabang)
                                                     {{-- <option value="{{ $cabang->id }}" {{ old('cbrach') == $cabang->id ? 'selected' : '' }}>{{ $cabang->branch }}</option> --}}
                                              {{-- <option value="{{ $cabang->id }}"  @if($cabang->id==$warehouseTolist->company_branch_id) selected='selected' @endif >{{ $cabang->branch }}</option> --}}
                                              {{-- <option value="{{$cabang->id}} {{(old('cbrach') == $cabang?'selected':'')}}">{{$cabang->branch}}</option> --}}
                                                     {{-- @endforeach
                                                 </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Branch Name</label>
                                                    <div class="controls">
                                                        <label style="color: black;font-family: Fira Code">{{ $prefix->branch}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                <div class="row-fluid">
                                    <div class="span12">
                                        <hr>
                                        <br />
                                    </div>
                                </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Customer Name</label>
                                            <div class="controls">
                                            <select class="customer_names form-control" id="customers_name" style="width:330px;" name="customers_name">
                                                <option value="{{$warehouseTolist->customers_warehouse->id}}" selected="{{$warehouseTolist->customers_warehouse->id}}">{{$warehouseTolist->customers_warehouse->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Customer PIC</label>
                                            <div class="controls">
                                            <select class="customerpics_name form-control" id="customerpics_name" style="width:330px;" name="customerpics_name">
                                                <option value="{{$customerpics->id}}" selected="{{$customerpics->name}}">{{$customerpics->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row-fluid">
                                <div class="span12">
                                    <hr>
                                    <br />
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Sub Services</label>
                                            <div class="controls">
                                            <select class="sub_services form-control" id="sub_services" style="width:330px;" name="sub_services">
                                                <option value="{{$warehouseTolist->sub_service->id}}" selected="{{$warehouseTolist->sub_service->name}}">{{$warehouseTolist->sub_service->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Item</label>
                                            <div class="controls">
                                            <select class="items form-control" id="items" style="width:330px;" name="items">
                                                <option value="{{$warehouseTolist->item_t->id}}" selected="{{$warehouseTolist->item_t->itemovdesc}}">{{$warehouseTolist->item_t->itemovdesc}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row-fluid">
                                <div class="span12">
                                    <hr>
                                </div>
                            </div> -s-}}
                                {{-- <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"> <strong>Informasi PIC</strong></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                {{-- </div>
                                            </div>
                                        </div>
                                    </div> --}} 
                                    {{-- <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group"> --}}
                                                     <!-- BEGIN PAGE HEADER-->
                                                     <!-- <div class="row-fluid">
                                                        <div class="span12">
                                                           <!-BEGIN PAGE TITLE & BREADCRUMB-->
                                                            <!-- <ul class="breadcrumb">
                                                                {{-- @yield('breadcrumb') --}}
                                                            </ul> -->
                                                            <!-- END PAGE TITLE & BREADCRUMB-->
                                                        <!-- </div>
                                                     </div> - -->
                                                     <!-- END PAGE HEADER-->
                                                     <!-- BEGIN ADVANCED TABLE widget-->
                                                     {{-- <div class="row-fluid">
                                                          <div class="span12"> --}}
                                                          <!-- BEGIN EXAMPLE TABLE widget-->
                                                          {{-- <div class="widget red"> --}}
                                                              {{-- <div class="widget-title">
                                                                  <h4><i class="icon-reorder"></i> Table List Customer PIC</h4>
                                                                      <span class="tools">
                                                                          <a href="javascript:;" class="icon-chevron-down"></a>
                                                                          <a href="javascript:;" class="icon-remove"></a>
                                                                      </span>
                                                              </div> --}}
                                                            {{-- <div class="widget-body"> --}}
                                                                    {{-- <div style="text-align:right;">
                                                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addven" data-whatever="">
                                                                                <i class="icon-plus"></i>
                                                                                    Customer PIC Registration
                                                                            </button>
                                                                        {{-- <input type="button" value="+ Customer PIC Registration" data-toggle="modal" data-target="#addven" data-whatever=""> --}}
                                                                    {{-- </div> - --}}
                                                                    {{-- <div style="text-align:right;">
                                                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                                            data-target="#addven" data-whatever="">
                                                                            <i class="icon-plus"></i>
                                                                            Customer PIC Registration
                                                                        </button>
                                                                    </div> --}}
                        
                                                                    {{-- <input type="button" value="+ Customer PIC Registration"
                                                                        data-toggle="modal" data-target="#addven" data-whatever="">
                                                                    --}}
                        
                                                                    {{-- <div>
                                                                        &nbsp;
                                                                    </div> --}}
                                                                    {{-- <table class="table table-striped table-bordered" id="sample_1">
                                                                        <thead>
                                                                                <tr>
                                                                                    <th style="border-top:top;background-color:transparent"></th>
                                                                                    <th style="border-top:top;background-color:transparent">CSPICSID</th>
                                                                                    <th style="border-top:top;background-color:transparent">CustomerID</th>
                                                                                    <th style="border-top:top;background-color:transparent">Customer Name</th>
                                                                                    <th style="border-top:top;background-color:transparent">Position</th>
                                                                                    <th style="border-top:top;background-color:transparent">Email</th>
                                                                                    <th style="border-top:top;background-color:transparent">Phone</th>
                                                                                    <th style="border-top:top;background-color:transparent"></th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($warehouse_order_pic as $list)
                                                                            <tr class="odd gradeX">
                                                                                    <td style="width: 8%;"><input type="checkbox" id="check_customerpics[]" name="check_customerpics[]" value="{{$list->to_do_list_cspics->id}}"></td>
                                                                                    <td style="width: 8%;">{{$list->to_do_list_cspics->id}}</td>
                                                                                    <td style="width: 8%;">CS00{{$list->to_do_list_cspics->customer_id}}</td>
                                                                                    <td style="width: 8%;">{{$list->to_do_list_cspics->name}}</td>
                                                                                    <td style="width: 8%;"> {{$list->to_do_list_cspics->position}}</td>
                                                                                    <td style="width: 8%;"> {{$list->to_do_list_cspics->email}}</td>
                                                                                    <td style="width: 8%;"> {{$list->to_do_list_cspics->phone}}</td>
                                                                                    <td style="width: 8%;"> 
                                                                                        <a href="{{ route('customerpics.show', $list->to_do_list_cspics->id)}}" data-placement="top" id="modal" data-toggle="modal" data-target="#edven{{$list->to_do_list_cspics->id}}" data-whatever=""><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table> --}}
                                                                {{-- </div>
                                                          </div> --}}
                                                    {{-- </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    <div class="row-fluid">
                                            <div class="span12">
                                                <hr>
                                            </div>
                                        </div>
                                <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"> <strong>Informasi Order</strong></label>
                                                <div class="controls">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Contrack Number#</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="20" value="{{$warehouseTolist->contract_no}}" id="contract_no" name="contract_no" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                            <div class="span12">
                                                    <div class="control-group">
                                                        <label class="control-label">Remark</label>
                                                        <div class="controls">
                                                            <textarea id="editordata" name="editordata" value="{{$warehouseTolist->remark}}" data-validation="required" class="span12" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="10" col="200">{{$warehouseTolist->remark}}</textarea>
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
                                                <label class="control-label">Volume/Unit</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="9" id="volume" value="{{$warehouseTolist->volume}}" name="volume" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">UOM</label>
                                                <div class="controls">
                                                    <input type="text" id="uom" value="{{$warehouseTolist->wom}}"maxlength="2" name="uom" class="span2" />
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <div class="controls">
                                                    <select class="input-large m-wrap" style="width:224px" tabindex="1" id="uom" name="uom">
                                                    <option value="m²">m²</option>
                                                    <option value="m³" selected="selected">m³</option>
                                                    <option value="pallet">Pallet</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Rate</label>
                                                    <div class="controls">
                                                        <input type="text" maxlength="10" value="{{$warehouseTolist->rate}}" id="rate" name="rate" class="span12" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">Total Rate</label>
                                                        <div class="controls">
                                                        <div class="input-prepend span11">
                                                            <span class="add-on">Rp</span><input readonly="enabled" onkeyup="document.getElementById('format').innerHTML = formatCurrency(this.value);" type="text" maxlength="20" id="total_rate" name="total_rate" class="span12" />
                                                        <label></label><b><span id="format"></span></b>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <div class="row-fluid">
                                        <div class="span12" style="text-align:right;" >
                                            <div class="form-actions" style="">
                                                {{-- <button type="submit" class="btn btn-success" value="PUT">Update Customer</button> --}}
                                              @role('administrator|super_users|3PL - SURABAYA WAREHOUSE')
                                               <button type="submit" id="submit" class="btn btn-success" value="PUT">
                                                    <i class="icon-refresh"></i>
                                                    Update
                                                </button> 
                                                @endrole
                                                {{-- <a type="button" class="btn btn-primary" href="{{ route('send_invoice', $warehouseTolist->id)}}">Process <i class="icon-circle-arrow-right"></i> <i class="icon-envelope"></i></a> --}}
                                              {{-- <a class="btn btn-info" href="{{ redirect()->To('customer')->getTargetUrl() }}">Order Approved</a> --}}
                                              {{-- <a type="button" class="btn btn-warning" href="{{ route('xlsx', $warehouseTolist->id)}}">Export <i class="icon-circle-arrow-right"></i> <i class="icon-download-alt"></i></a> --}}
                                              {{-- <button onclick="location.href='{{ route('xlsx', $warehouseTolist->id) }}'" class="btn btn-small btn-warning" value="RELOAD" type="button"><i class="icon-download-alt"></i></button></div> --}}
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
                          @foreach($warehouse_order_pic as $list)
                          <!-- Modal edit customer_pics -->
                          <div class="modal fade" id="edven{{$list->to_do_list_cspics->id}}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                              aria-labelledby="edven" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <!-- Modal Header -->
                                     <div>
                                         &nbsp;
                                     </div>
                                     <div class="modal-header" style="color: #0000;">
                                         <span aria-hidden="true">&times;</span>
                                         <span class="close sr-only" style="font-family: courier;font-size:36px">Edit Customer PIC</span>
                                     </div>
                                 <!-- Modal Body -->
                        <div class="modal-body" style="height:230px;">
                            <form class="form-horizontal" style="height:250px" id="edven" method="post" action="{{route('customerpics.update', $list->to_do_list_cspics->id)}}">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                          {{ method_field('PUT') }}
                                    <div class="row-fluid">
                                        <div class="span11">
                                            <div class="control-group">
                                                    <label class="control-label">Nama</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{$list->to_do_list_cspics->name}}" name="name_customer" class="span12"></input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row-fluid">
                                  <div class="span11">
                                      <div class="control-group">
                                          <label class="control-label">Customer PIC Status</label>
                                          <div class="controls">
                                            <select class="span12 chzn-select" name="customer_pic_status_customer" style="width:100px" data-placeholder="Status" tabindex="1">
                                              @foreach($vstatuss as $a)
                                                <option value="{{ $a->id }}" @if($a->id==$list->to_do_list_cspics->customer_pic_status_id) selected='selected' @endif >{{ $a->name }}</option>
                                                @endforeach()
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                  <div class="row-fluid">
                                      <div class="span11">
                                          <div class="control-group">
                                              <label class="control-label">Posisi</label>
                                              <div class="controls">
                                                  <input type="text" maxlength="30" value="{{$list->to_do_list_cspics->position}}" name="position_customer" class="span12" />
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row-fluid">
                                      <div class="span8">
                                          <div class="control-group">
                                              <label class="control-label">Email</label>
                                              <div class="controls">
                                                <div class="input-prepend">
                                                    <span class="add-on">@</span><input type="text" maxlength="30" style="width:166%;" value="{{$list->to_do_list_cspics->email}}" name="email_customer" class="span12" />
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row-fluid">
                                          <div class="span11">
                                              <div class="control-group">
                                                  <label class="control-label">Phone</label>
                                                  <div class="controls">
                                                      <input type="text" maxlength="15" id="tax_phone" value="{{$list->to_do_list_cspics->phone}}" name="phone_customer" class="span12" />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  <div class="row-fluid">
                                      <div class="span11">
                                          <div class="control-group">
                                                  <label class="control-label">Phone Mobile</label>
                                                  <div class="controls">
                                                      <input type="text" maxlength="15" id="tax_fax" value="{{$list->to_do_list_cspics->mobile_phone}}" name="mobile_phone_customer" class="span12" />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                        <br>
                                         <div class="modal-footer">
                                          {{-- <button type="submit" class="btn btn-success" >Update Customer PIC</button> --}}
                                          <button type="submit" class="btn btn-success" value="PUT">
                                                  <i class="icon-refresh"></i>
                                                      Update Customer PIC
                                                  </button>
                                                      <button data-dismiss="modal" class="btn" href="#">Cancel</button>
                                                  </div>
                                    </form>
                                          </div>
                                      </div>
                            </div>
                        </div>
                                  {{-- End modal form edit customer pics --}}
                                  @endforeach()
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js" integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>

<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
  <!-- END JAVASCRIPTS -->
   <script language="javascript" type="text/javascript">

            $(document).ready(function () {

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                $("#submit").click(function(e) {
                    e.preventDefault();

                    const id = "{{ session()->get('order_id') }}";
                    const branch = "{{ $some }}";
                    let items = document.getElementById('items').value;
                    let customer_name = document.getElementById('customers_name').value;
                    let subservice = document.getElementById('sub_services').value;
                    let contract = document.getElementById('contract_no').value;
                    let remark = document.getElementById('editordata').value;
                    let volume = document.getElementById('volume').value;
                    let uom = document.getElementById('uom').value;
                    let sum_rate = document.getElementById('total_rate').value;
                    let harga = document.getElementById('rate').value;

                    let request = $.ajax({
                    
                    url: `{{ url('warehouse-list/find-branch-with-branch/branch-id/${branch}/update-detail-data/${id}/completed')}}`,
                    method: "GET",
                    dataType: "json",
                    data: {
                        items:items,
                        customer_name:customer_name,
                        subservice:subservice,
                        contract:contract,
                        remark:remark,
                        volume:volume,
                        uom:uom,
                        sum_rate:sum_rate,
                        harga:harga,
                    },
                    success: function (data) {

                        Swal({
                            title: 'Successfully',
                            text: "You have done update order!",
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Okay!',
                        }).then((result) => {
                            if (result.value) {
                                
                                console.log(data)
                            }
                            
                        })
                               
                },
                complete:function(data){
                 
                },
                error: function(){

                    Swal({
                        title: 'Error',
                        text: "Update can't access end point!",
                        type: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay!',
                        }).then((result) => {

                                    if (result.value) {
                                        
                                        $("#add_item_customer").prop( "disabled", false)
                                        $("#add_item_customer").text('Save');
                                    }
                                    
                                })
                            
                            }
                        }
                    );
                });
                
            });


    window.history.forward();

             function noBack() { 
                  window.history.forward(); 
             }
            
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
        $("#total_rate").val('');
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

        $('.items').on('change', function(e){
        let items = e.target.value;
        $.get('/item_price/find/'+ items, function(data){
            $.each(data, function(index, Subj){
                $('#rate').val(''+Subj.price);
                const volume = parseInt(document.getElementById('volume').value);

                let result_rate = parseInt(Subj.price*volume);
                if(isNaN(result_rate))
                result_rate ="invalid number";
                document.getElementById('total_rate').value = result_rate;
                
            });
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

    //     $(function () {
    //     $.configureBoxes();
    // });

   </script>
@endsection

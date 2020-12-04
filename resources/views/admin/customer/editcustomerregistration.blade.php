@extends('admin.layouts.master', array('id_master_customer'=>session()->get('id_master_customer')))
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
    <a href="{{ URL::to('customer') }}">Customer</a>
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
                    </br>
                        <!-- BEGIN FORM-->
                        <form class="form-horizontal">
                        {{ method_field('PUT') }}
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Nama Perusahaan</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" value="{{$customers->name}}" id="project_name" name="project_name" class="span12"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Direktur</label>
                                        <div class="controls">
                                            <input type="text" maxlength="40" value="{{$customers->director}}" id="director" name="director" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Jenis Usaha</label>
                                            <div class="controls">
                                              <select class="type_of_business form-control span12" id="type_of_business" name="type_of_business">
                                              <option value="{{$customers->industry->id}}" selected="{{$customers->industry->name}}">{{$customers->industry->industry}}</option>
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Tahun Berdiri</label>
                                            <div class="controls">
                                                <input type="text" maxlength="50" value="{{$customers->since}}" id="since" name="since" class="span12 " />
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
                                            <label class="control-label"> <strong>Informasi NPWP</strong></label>
                                            <div class="controls">
                                                {{--  <input type="text" class="span12 " />  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label"> No. NPWP</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{$customers->tax_no}}" id="no_npwp" name="no_npwp" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Provinsi</label>
                                            <div class="controls">
                                                <select class="provins" id="provincenpwp" style="width:385px;" name="province" data-placeholder="Choose a Province" tabindex="1">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Alamat</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{$customers->tax_address}}" id="tax_address" name="tax_address" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="span12 kotaNPWP chzn-select" id="tax_city" name="tax_city" data-placeholder="Choose a City" tabindex="1">
                                                    @foreach($city as $a)
                                                        <option value="{{ $a->id }}" @if($a->id==$customers->tax_city) selected='selected' @endif >{{ $a->name }}</option>
                                                    @endforeach()
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">No Telepon</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="15" id="tax_phone" value="{{$customers->tax_phone}}" name="tax_phone" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Fax</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="15" id="tax_fax" value="{{$customers->tax_fax}}" name="tax_fax" class="span12" />
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
                                            <label class="control-label"> <strong>Informasi Operasional</strong></label>
                                            <div class="controls">
                                                {{--  <input type="text" class="span12 " />  --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <div class="controls">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Provinsi</label>
                                                <div class="controls">
                                                  <div class="provinceopsss"></div>
                                                    <select class="provinsOps" id="provinceops" style="width:398px" name="provinceopsX" data-placeholder="Choose a Province" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Alamat</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{$customers->address}}" id="addressOPS" name="addressOPS" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                              <select class="span12 kotaOps chzn-select" name="cityOPS" id="cityOPS" data-placeholder="Choose a City" tabindex="1">
                                                @foreach($city as $a)
                                                    <option value="{{ $a->id }}" @if($a->id==$customers->city_id) selected='selected' @endif >{{ $a->name }}</option>
                                                @endforeach()
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">No Telepon</label>
                                            <div class="controls">
                                                <input type="text" maxlength="15" id="phoneOPS" value="{{$customers->phone}}" name="phoneOPS" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                      <label class="control-label">Fax</label>
                                                    <div class="controls">
                                                        <input type="text" maxlength="15" id="faxOPS" value="{{$customers->fax}}" name="fax" class="span12" />
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Email</label>
                                                <div class="controls">
                                                  <div class="input-prepend">
                                                      <span class="add-on">@</span><input type="text" id="opsemail" maxlength="20" style="width:160%;" value="{{$customers->email}}" name="email" class="span12" />
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Website</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="30" id="wbsiteOPS" value="{{$customers->website}}" name="wbsiteOPS" class="span12" />
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row-fluid">
                                            <div class="span12">
                                                <hr>
                                            </div>
                                        </div> --}}

                                <div class="row-fluid" style="display:none">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label class="control-label"> <strong>Informasi PIC</strong></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group" style="display:none">
                                                     <!-- BEGIN PAGE HEADER-->
                                                     <!-- <div class="row-fluid">
                                                        <div class="span12">
                                                           <!-BEGIN PAGE TITLE & BREADCRUMB-->
                                                            <!-- <ul class="breadcrumb">
                                                                @yield('breadcrumb')
                                                            </ul> -->
                                                            <!-- END PAGE TITLE & BREADCRUMB-->
                                                        <!-- </div>
                                                     </div> - -->
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
                                                                  <h4><i class="icon-reorder"></i> Table List Customer PIC</h4>
                                                                      <span class="tools">
                                                                          <a href="javascript:;" class="icon-chevron-down"></a>
                                                                          <a href="javascript:;" class="icon-remove"></a>
                                                                      </span>
                                                              </div>
                                                              <div class="widget-body">
                                                                <div style="text-align:right;">
                                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addven" data-whatever="">
                                                                            <i class="icon-plus"></i>
                                                                                Customer PIC Registration
                                                                        </button>
                                                                    {{-- <input type="button" value="+ Customer PIC Registration" data-toggle="modal" data-target="#addven" data-whatever=""> --}}
                                                                </div>

                                                                  <div>
                                                                      &nbsp;
                                                                  </div>
                                                                  <table class="table table-striped table-bordered" id="sample_1">
                                                                      <thead>
                                                                          <tr>
                                                                              <th>ID</th>
                                                                              <th>Customer ID</th>
                                                                              <th>Name</th>
                                                                              <th>Position</th>
                                                                              <th>Email</th>
                                                                              <th>Phone</th>
                                                                              <th>Mobile Phone</th>
                                                                              <th>created at</th>
                                                                              <th>updated at</th>
                                                                              <th>Action</th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                        @foreach($customers->customer_pic as $list)
                                                                          <tr class="odd gradeX">
                                                                              <td style="width: 8%;">PIC0000{{$list->id}}</td>
                                                                              <td style="width: 8%;">CS00{{$list->customer_id}}</td>
                                                                              <td style="width: 8%;">{{$list->name}}</td>
                                                                              <td style="width: 8%;">{{$list->position}}</td>
                                                                              <td style="width: 14%;">{{$list->email}}</td>
                                                                              <td style="width: 50px;">{{$list->phone}}</td>
                                                                              <td style="width: 20px;">{{$list->mobile_phone}}</td>
                                                                              <td style="width: 10px;">{{$list->created_at}}</td>
                                                                              <td style="width: 50px;">{{$list->updated_at}}</td>
                                                                              <td style="width: 30px;">
                                                                                    <a href="{{ route('customerpics.show', $list->id)}}" data-placement="top" id="modal" data-toggle="modal" data-target="#edven{{$list->id}}" data-whatever=""><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>
                                                                                    {{-- <button onclick="location.href='{{ route('customerpics.show', $list->id)}}'" class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button> --}}
                                                                              </td>
                                                                          </tr>
                                                                          @endforeach
                                                                      </tbody>
                                                                  </table>
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
                                                <label class="control-label"> <strong>Informasi Finance</strong></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Nama Bank</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="20" value="{{$customers->bank_name}}" id="bank_name" name="bank_name" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">No rekening</label>
                                                    <div class="controls">
                                                        <input type="text" id="norek" value="{{$customers->no_rek}}" name="norek" class="span12" />
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Atas Nama Rekening</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{$customers->an_bank}}" id="an_bank" name="an_bank" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Term Of Payment</label>
                                                        <div class="controls">
                                                            <input type="text" id="term_of_payment" value="{{$customers->term_of_payment}}" maxlength="2" name="term_of_payment" class="span2" /> Day(s)
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
                                                    <label class="control-label"> <strong>Informasi Status</strong></label>
                                                    <div class="controls">
                                                        {{--  <input type="text" class="span12 " />  --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                          <div class="span6">
                                              <div class="control-group">
                                                  <label class="control-label">Status Customer</label>
                                                  <div class="controls">
                                                    <select class="span12 sts_cstm chzn-select" name="status_id" id="status_id" style="width:100px" data-placeholder="Status" tabindex="1">
                                                      @foreach($vstatus as $a)
                                                        <option value="{{ $a->id }}" @if($a->id==$customers->cstatusid->id) selected='selected' @endif >{{ $a->status }}</option>
                                                        @endforeach()
                                                    </select>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                      <div class="form-actions" style="">
                                              {{-- <button type="submit" class="btn btn-success" value="PUT">Update Customer</button> --}}
                                              <button id="updatepelanggan" type="submit" class="btn btn-success" value="PUT">
                                                    <i class="icon-refresh"></i>
                                                    Update Customer
                                                </button>
                                              <a class="btn btn-info" href="{{ route('master.customer.list', session()->get('id')) }}">Cancel</a>
                                          </div>
                                    </div>
                                </div>
                            </form>

                            {{-- start delete form --}}
                            {{--  <form class="span6" action="{{route('customer.destroy', $customers->id)}}" method="post">
                              <!-- {{ method_field('DELETE') }} -->
                              <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                              <input type="hidden" name="_method" value="DELETE">
                              {{-- <button type="submit" class="btn btn-danger">Delete Customer</button> --}}
                              {{--  <button type="submit" class="btn btn-danger" value="PUT">
                                    <i class="icon-remove"></i>
                                    Delete Customer
                                </button>
                            </form>  --}}  
                            {{-- end delete form --}}

                            <!-- Modal add customer_pics -->
                            <div class="modal fade" id="addven" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                                 aria-labelledby="addven" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div>
                                            &nbsp;
                                        </div>
                                        <div class="modal-header" style="color: #0000;">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="close sr-only" style="font-family: courier;font-size:36px">Add Customer PIC</span>
                                        </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body" style="
                                    height: 300px;
                                ">
                                        <form class="form-horizontal" id="addvpics" method="post" action="{{url('customerpics')}}">
                                          <input type="hidden" maxlength="20" value="{{$customers->id}}" name="id_customer" class="span12" />
                                          <input type="hidden" name="customer_pic_status_customer" value="1" class="span12 " />
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                            <div class="modal-body">
                                                 <div class="modalError"></div>
                                                 <div id="modalMdContent"></div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Name</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="name_customer" value="{{ old('name_customer') }}" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <!-- <div class="span6">
                                                     <div class="control-group">
                                                         <label class="control-label">Customer PIC Status</label>
                                                         <div class="controls">
                                                           <select class="span12 chzn-select" name="customer_pic_status_customer" style="width:100px" data-placeholder="Status" tabindex="1">
                                                             @foreach($vstatus as $a)
                                                               <option value="{{ $a->id }}">{{ $a->status }}</option>
                                                               @endforeach()
                                                           </select>
                                                         </div>
                                                     </div>
                                                 </div> -->
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Position</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="position_customer" value="{{ old('position_customer') }}" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Email</label>
                                                         <div class="controls">
                                                           <div class="input-prepend">
                                                             <span class="add-on">@</span><input type="text" value="{{ old('email_customer') }}" style="width:133%" maxlength="20" name="email_customer" class="span12" />
                                                           </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Phone</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="phone_customer" id="ph" value="{{ old('phone_customer') }}" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Mobile Phone Number</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="mobile_phone_customer" id="mb" value="{{ old('mobile_phone_customer') }}" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                            <br>
                                            <div class="modal-footer">
                                              <button id="pushadd" type="submit" class="btn btn-primary">Add</button>
                                              <button data-dismiss="modal" class="btn btn-info" href="{{ route('master.customer.list', session()->get('id')) }}">Cancel</button>
                                                        </div>
                                                          </form>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                <!-- END FORM-->
                    @foreach($customers->customer_pic as $list)
                        <!-- Modal edit customer_pics -->
                        <div class="modal fade" id="edven{{$list->id}}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
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
                               <div class="modal-body" style="
                               height: 350px;
                           ">
                                   <form class="form-horizontal" id="edven" method="post" action="{{route('customerpics.update', $list->id)}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                        {{ method_field('PUT') }}
                                        <div class="row-fluid">
                                            <div class="span11">
                                                <div class="control-group">
                                                  <label class="control-label">Nama</label>
                                                    <div class="controls">
                                                <input type="text" maxlength="30" value="{{$list->name}}" name="name_customer" class="span12"></input>
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
                                              <option value="{{ $a->id }}" @if($a->id==$list->customer_pic_status_id) selected='selected' @endif >{{ $a->name }}</option>
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
                                                <input type="text" maxlength="30" value="{{$list->position}}" name="position_customer" class="span12" />
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
                                                  <span class="add-on">@</span><input type="text" maxlength="30" style="width:166%;" value="{{$list->email}}" name="email_customer" class="span12" />
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
                                                    <input type="text" maxlength="15" id="tax_phone" value="{{$list->phone}}" name="phone_customer" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row-fluid">
                                    <div class="span11">
                                        <div class="control-group">
                                                <label class="control-label">Phone Mobile</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="15" id="tax_fax" value="{{$list->mobile_phone}}" name="mobile_phone_customer" class="span12" />
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
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
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
<script language="javascript" type="text/javascript">

        $('.provins').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
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
           }).on('change', function(e){
               $('.kotaNPWP').empty();
                const id = e.target.value;
                    $('.kotaNPWP').select2({
                    placeholder: 'Cari...',
                    ajax: {
                    url: '/cari_province/find/'+ id,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return  {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    cache: true
                    }
                })
           });

           $('.sts_cstm').select2({})

           $('.provinsOps').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
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
           }).on('change', function(e){
               const id = e.target.value;
               $('.kotaOps').empty();
                $('.kotaOps').select2({
                placeholder: 'Cari...',
                ajax: {
                url: '/cari_province/find/'+ id,
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
                })
           });

           $('.kotaOps').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/load-city/find',
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
           })

        $('.kotaNPWP').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/load-city/find/',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return  {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                cache: true
            }
        })

        $(function(){
            $('#updatepelanggan').click(function (e) {
                e.preventDefault();
                // alert("dom");
                $("#updatepelanggan").prop( "disabled", true );

                // let customers = $("#customers_name").val();
                // $("#addorders").prop( "disabled", true );
                $("#updatepelanggan").text('process..');
                // // if(!$("#origin").val()) {
                // //     // do something else with empty data
                // // } else {
                    
                    let PromisesUpdateData = new Promise((resolve, reject) => {
                        setTimeout(() => resolve(UpdateDataPelanggan()), 3500)
                    });
                // }
            });
        });

        async function UpdateDataPelanggan() {
            
            const SuccessAlertsTransportAPI = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 7500
            })
            let project_name = $("#project_name").val();
            let director = $("#director").val();
                        
            // origin
            let type_of_business = $("#type_of_business").val();
            let since = $("#since").val();
            let no_npwp = $("#no_npwp").val();
            let tax_address = $("#tax_address").val();
            let tax_city = $("#tax_city").val();

            
            let tax_phone = $("#tax_phone").val();
            let tax_fax = $("#tax_fax").val();

            let addressOPS = $("#addressOPS").val();
            let phoneOPS = $("#phoneOPS").val();
            let faxOPS = $("#faxOPS").val();
            let cityOPS = $("#cityOPS").val();
            let opsemail = $("#opsemail").val();
            let wbsiteOPS = $("#wbsiteOPS").val();


            let bank_name = $("#bank_name").val();
            let norek = $("#norek").val();

            // detail order
            let an_bank = $("#an_bank").val();
            let term_of_payment = $("#term_of_payment").val();
            let status_id = $("#status_id").val();

                const apiTransports = "{{ route('update.data.cs', ['branch_id' => $some, 'id'=>$customers->id] ) }}";
                const dataTransports = { 

                            token : "{{ csrf_token() }}",
                            project_name: project_name,
                            director: director,
                            type_of_business: type_of_business,
                            since: since,
                            no_npwp: no_npwp,
                            tax_address: tax_address,
                            tax_city: tax_city,
                            tax_phone: tax_phone,
                            tax_fax: tax_fax,
                            addressOPS: addressOPS,
                            faxOPS: faxOPS,
                            cityOPS: cityOPS,
                            opsemail: opsemail,
                            phoneOPS: phoneOPS,
                            wbsiteOPS: wbsiteOPS,
                            bank_name: bank_name,
                            norek: norek,
                            an_bank: an_bank,
                            term_of_payment: term_of_payment,
                            status_id: status_id
                           
                        };

        try 
            {

                const responseTransport = await fetch(apiTransports, {

                        method: 'GET',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        body: JSON.stringify(dataTransports),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                    }

                });

                const dataJson = await responseTransport.json();
                let TransportPromise = new Promise((resolve, reject) => {
                    setTimeout(() => resolve(dataJson), 1000)
                });
    
                    let transportPromises = await TransportPromise;

                    $("#updatepelanggan").prop("disabled", false);
                    $("#updatepelanggan").text("Submit Your Order");

            } 
                catch (errors) {
                  
                    $.ajaxSetup(
                                    {
                                        headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                            }
                        )
                    ;

                    let request = $.ajax({
                    
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: apiTransports,
                    type: "GET",
                    dataType: "json",
                    data: dataTransports,
                    success: function (data) {
                        Swal({
                            title: 'Accurate Cloud',
                            text: 'CODE: '+ data.success,
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup',
                        }).then((result) => {
                            if (result.value) {
                                    
                                    $("#updatepelanggan").prop( "disabled", false );
                                    $("#updatepelanggan").text('Update Customer');

                            }
                            
                    })

                },
                complete:function(data){

                    // TODO: do something with complete arguments
                 
                },
                    error: function(jqXhr, json, errorThrown){
                     
                        let responses = $.parseJSON(jqXhr.responseText).errors;
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each( responses, function( key, value ) {
                                errorsHtml +=  value[0] +'<br/>';
                            }
                        );
                            errorsHtml += '</ul></div>';
                            buttonconfirm = '<div class="badge badge-info closeme" style="font-size:14px;height:19px;width:40px;cursor: pointer">Okay</div>';
                            let TransportPromise = new Promise((resolve, reject) => {
                                setTimeout(() =>        
                                        Swal({
                                        title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                        text: "Maaf proses upload gagal diproses !",
                                            confirmButtonColor: '#3085d6',
                                            html: errorsHtml +'<br/>'+ buttonconfirm,
                                            width: 'auto',
                                            showConfirmButton: false,
                                            type: 'error'
                                        }).then((result) => {
                                        if (result.value) {
                                            return false;
                                    }
                            }),
                                $("#updatepelanggan").prop("disabled", false),
                                $("#updatepelanggan").text("Udpate Customer"), 1000)
                        });
                    }
                }
            );
                    // const ErrorsAlertsTransportAPI = Swal.mixin({
                    //     toast: true,
                    //     position: 'bottom-end',
                    //     showConfirmButton: false,
                    //     timer: 7000
                    // })

                    // let TransportPromiseErrors = new Promise((resolve, reject) => {
                    //     setTimeout(() => reject(console.error('Error:', errors)), 2000)
                    // });

                        // ErrorsAlertsTransportAPI.fire({
                        //     type: 'error',
                        //     title: `Data gagal disimpan `+ errors
                        // })

                }

        }

       $('.type_of_business').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/search_type_of_business',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
             return {
               results:  $.map(data, function (item) {
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

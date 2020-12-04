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
    <a href="{{ URL::to('vendor-list') }}">Vendor</a>
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
                              <strong>Maaf system mendeteksi adanya kesalahan pada inputan user, silahkan periksa kembali!</strong><br><br>
                              <strong>
                                  Pesan system:
                              </strong>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                        <!-- BEGIN FORM-->
                        {{-- <form action="{{route('vendorx.update', $vst->id)}}" method="POST"> --}} 
                        <form class="form-horizontal">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Nama Perusahaan</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" value="{{$vst->company_name}}" id="company_name" name="company_name" class="span12"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Direktur</label>
                                        <div class="controls">
                                            <input type="text" maxlength="20" value="{{$vst->director}}" name="director" id="director" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Jenis Usaha</label>
                                            <div class="controls">
                                              <select class="type_of_business form-control" style="width:365px;" id="type_of_business" name="type_of_business">
                                              <option value="{{$vst->industry->id}}" selected="{{$vst->industry->name}}">{{$vst->industry->industry}}</option>
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Tahun Berdiri</label>
                                            <div class="controls">
                                                <input type="text" maxlength="4" value="{{$vst->since}}" id="since" name="since" class="span12 " />
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
                                                <input type="text" maxlength="30" value="{{$vst->tax_no}}" id="tax_no" name="tax_no" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Alamat</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{$vst->tax_address}}" name="tax_address" id="tax_address" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="span12 chzn-select" name="tax_city" id="tax_city" data-placeholder="Choose a City" tabindex="1">
                                                    <!-- <option value="{{$vst->city_npwp}}">{{$vst->city_npwp}}</option> -->
                                                    @foreach($city as $c)
                                                    <option value="{{$c->name}}">{{$c->name}}</option>
                                                    @endforeach
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
                                                    <input type="text" maxlength="15" id="tax_phone" value="{{$vst->tax_phone}}" name="tax_phone" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Fax</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="15" id="tax_fax" value="{{$vst->tax_fax}}" name="tax_fax" class="span12" />
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
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Alamat</label>
                                            <div class="controls">
                                                <input type="text" maxlength="50" value="{{$vst->address}}" name="addressOPS" id="addressOPS" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="span12 chzn-select" name="cityOPS" id="cityOPS" data-placeholder="Choose a City" tabindex="1">
                                                  @foreach($city as $cities)
                                                    <option value="{{$vst->city_id}}" selected="{{$vst->city->name}}">{{$vst->city->name}}</option>
                                                    <option value="{{$cities->id}}">{{ $cities->name }}</option>
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
                                                <input type="text" maxlength="15" id="phoneOPS" value="{{$vst->phone}}" name="phoneOPS" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                      <label class="control-label">Fax</label>
                                                    <div class="controls">
                                                        <input type="text" maxlength="15" id="faxOPS" value="{{$vst->fax}}" name="faxOPS" class="span12" />
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
                                                      <span class="add-on">@</span><input type="text" maxlength="20" style="width:160%;" value="{{$vst->email}}" id="opsemail" name="opsemail" class="span12" />
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Website</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="30" value="{{$vst->website}}" id="wbsiteOPS" name="wbsiteOPS" class="span12" />
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>
                                {{-- TABLE PIC --}}
                                    <div class="row-fluid">
                                            <div class="span12">
                                                <hr>
                                            </div>
                                        </div>
                                <div class="row-fluid">
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
                                            <div class="control-group">
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
                                                                  <h4><i class="icon-reorder"></i> Table List Vendor PIC</h4>
                                                                      <span class="tools">
                                                                          <a href="javascript:;" class="icon-chevron-down"></a>
                                                                          <a href="javascript:;" class="icon-remove"></a>
                                                                      </span>
                                                              </div>
                                                              <div class="widget-body">
                                                                <div style="text-align:right;">
                                                                    <input class="btn btn-primary" type="button" value="+ Vendor PIC Registration" data-toggle="modal" data-target="#addven" data-whatever="">
                                                                </div>

                                                                  <div>
                                                                      &nbsp;
                                                                  </div>
                                                                  <table class="table table-striped table-bordered" id="sample_1">
                                                                      <thead>
                                                                          <tr>
                                                                              <th>ID</th>
                                                                              <th>Vendor ID</th>
                                                                              <th>Name</th>
                                                                              <th>Vendor position</th>
                                                                              <th>Email</th>
                                                                              <th>Phone</th>
                                                                              <th>Mobile Phone</th>
                                                                              <th>created at</th>
                                                                              <th>updated at</th>
                                                                              <th>Action</th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                        @foreach($vst->vendor_pics as $pic)
                                                                          <tr class="odd gradeX">
                                                                              <td style="width: 8%;">PIC0000{{$pic->id}}</td>
                                                                              <td style="width: 8%;">VD00{{$pic->vendor_id}}</td>
                                                                              <td style="width: 8%;">{{$pic->name}}</td>
                                                                              <td style="width: 12%;">{{$pic->position}}</td>
                                                                              <td style="width: 14%;">{{$pic->email}}</td>
                                                                              <td style="width: 50px;">{{$pic->phone}}</td>
                                                                              <td style="width: 20px;">{{$pic->mobile_phone}}</td>
                                                                              <td style="width: 20px;">{{$pic->created_at}}</td>
                                                                              <td style="width: 50px;">{{$pic->updated_at}}</td>
                                                                              <td style="width: 5%;">
                                                                                    <a href="{{ route('vendorpics.show', $pic->id)}}" data-placement="top" id="modal" data-toggle="modal" data-target="#edven{{$pic->id}}" data-whatever=""><button class="btn btn-primary"><i class="icon-pencil"></button></i></a>

                                                                                  {{-- <button onclick="location.href='{{ route('vendorpics.show', $pic->id)}}'" class="btn btn-small btn-primary" type="button"><i class="icon-pencil"></i></button> --}}
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
                                        {{-- END TABLE PIC --}}
                                    {{-- <div class="row-fluid">
                                            <div class="span12">
                                                <hr>
                                            </div>
                                        </div> --}}
                        {{-- TABLE PIC --}}
                                  
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
                                                      {{-- <div class="widget red"> --}}
                                                          {{-- <div class="widget-title">
                                                              <h4><i class="icon-reorder"></i> Table List Vendor PIC</h4>
                                                                  <span class="tools">
                                                                      <a href="javascript:;" class="icon-chevron-down"></a>
                                                                      <a href="javascript:;" class="icon-remove"></a>
                                                                  </span>
                                                          </div> --}}
                                                          {{-- <div class="widget-body"> --}}
                                                            {{-- <div style="text-align:right;"> --}}
                                                                    {{-- <input type="button" value="+ Vendor Rate Registration" onclick="location.href='{{ url('/vendorrate/registration') }}'"> --}}
                                                                {{-- <input type="button" value="+ Vendor PIC Registration" data-toggle="modal" data-target="#addven" data-whatever=""> --}}
                                                            </div>

                                                              <div>
                                                                  {{-- &nbsp; --}}
                                                                  {{-- <h3>Judul Web</h3>
                                                                    @foreach($vendorrate_trucks->vendorrate_trucks as $trucks)
                                                                            <li>{{ $trucks->destinationable->name }}</li>
                                                                    @endforeach --}}
                                                            </div>
                                                              {{-- <table class="table table-striped table-bordered" id="sample_2">
                                                                  <thead>
                                                                      <tr>
                                                                          <th>Origin ID</th>
                                                                          <th>Destination ID</th>
                                                                          <th>Sub Services</th>
                                                                          <th>Type Rate</th>
                                                                          <th>Rate</th>
                                                                          <th>Vendor Name</th>
                                                                          <th>Vendor ID</th>
                                                                          <th>Action</th>
                                                                      </tr>
                                                                  </thead> --}}
                                                                  {{-- <tbody> --}}
                                                                {{-- @foreach($subservice as $srv)
                                                               <ul> {{$srv->sub_services->name}} </ul>
                                                                @endforeach() --}}
                                                                    {{-- @foreach($vendorrate_trucks->vendorrate_trucks as $trucks)
                                                                                 <tr class="odd gradeX">
                                                                                    <td style="width: 20%;">{{ $trucks->originable->name }}</td>
                                                                                    <td style="width: 17%;">{{ $trucks->destinationable->name }}</td>
                                                                                    <td style="width: 8%;">{{ $trucks->sub_services->name }}</td>
                                                                                    <td style="width: 12%;"></td>
                                                                                    <td style="width: 14%;"></td>
                                                                                    <td style="width: 50px;"></td>
                                                                                    <td style="width: 20px;"></td>
                                                                                    <td style="width: 5%;">
                                                                                        <button onclick="location.href='{{ route('vendorpics.show', $pic->id)}}'" class="btn btn-small btn-primary" type="button">Detail</button>
                                                                                    </td>
                                                                                </tr>
                                                                        @endforeach
                                                                  </tbody> --}}
                                                              {{-- </table> --}}
                                                          {{-- </div> --}}
                                                      {{-- </div> --}}
                                                    </div>
                                                </div>
                                    {{-- END TABLE PIC --}}
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
                                                    <input type="text" maxlength="20" value="{{$vst->bank_name}}" id="bank_name" name="bank_name" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">No rekening</label>
                                                    <div class="controls">
                                                        <input type="text" maxlength="20" id="norek" value="{{$vst->norek}}" name="norek" class="span12" />
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Atas Nama Rekening</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{$vst->an_bank}}" id="an_bank" name="an_bank" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Term Of Payment</label>
                                                        <div class="controls">
                                                            <input type="text" id="term_of_payment" value="{{$vst->term_of_payment}}" maxlength="2" name="term_of_payment" class="span2" /> Day(s)
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
                                                  <label class="control-label">Status Vendor</label>
                                                  <div class="controls">
                                                    <select class="span12 chzn-select" id="status_id" name="status_id" style="width:100px" data-placeholder="Status" tabindex="1">
                                                      @foreach($vstatus as $a)
                                                        <option value="{{ $a->id }}"  @if($a->id==$vst->status->id) selected='selected' @endif >{{ $a->name }}</option>
                                                        @endforeach()
                                                    </select>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                      <div class="form-actions" style=""   >
                                    <button id="pemasoksbm" class="btn btn-success">
                                        <i class="icon-refresh"></i>
                                        Update Vendor
                                    </button>
                                              <a class="btn btn-info" href="{{ route('master.vendor.list', session()->get('id')) }}">Cancel</a>
                                          </div>
                                    </div>
                                </div>
                            </form>
                            
                            {{-- start form delete  --}}
                            {{--  <form class="span6" ction="{{route('vendorx.destroy', $vst->id)}}" method="post">
                              <!-- {{ method_field('DELETE') }} -->
                              <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                              <input type="hidden" name="_method" value="DELETE">
                              {{-- <button type="submit" class="btn btn-danger">Delete Vendor</button> --}}
                              {{--  <button type="submit" class="btn btn-danger" value="PUT">
                                    <i class="icon-remove"></i>
                                    Delete Vendor
                                </button>
                            </form>  --}}
                            {{-- end delete form --}}

                            <!-- Modal add vendor_pics -->
                            <div class="modal fade" id="addven" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                                 aria-labelledby="addven" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header" style="color: #0000;">
                                            <span aria-hidden="true">&times;</span>
                                            <span data-dismiss="modal" class="close sr-only" style="font-family: courier;font-size:36px">Add Vendor PIC</span>
                                        </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="addvpics" method="post" action="{{url('vendorpics')}}">
                                          <input type="hidden" maxlength="20" value="{{$vst->id}}" name="vendor_id_customer" class="span12" />
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                            <input type="hidden" name="vendor_pic_status_customer" value="1" class="span12 " />
                                            <div class="modal-body">
                                                 <div class="modalError"></div>
                                                 <div id="modalMdContent"></div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Name</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="name_customer" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <!-- <div class="span6">
                                                     <div class="control-group">
                                                         <label class="control-label">Vendor PIC Status</label>
                                                         <div class="controls">
                                                           <select class="span12 chzn-select" name="vendor_pic_status_customer" style="width:100px" data-placeholder="Status" tabindex="1">
                                                             @foreach($vstatus as $a)
                                                               <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                               @endforeach()
                                                           </select>
                                                         </div>
                                                     </div>
                                                 </div> -->
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Position</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" name="position_customer" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Email</label>
                                                         <div class="controls">
                                                           <div class="input-prepend">
                                                             <span class="add-on">@</span><input type="text" maxlength="20" style="width:138%;" name="email_customer" class="span12" />
                                                           </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Phone</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" id="pc" name="phone_customer" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="span12">
                                                     <div class="control-group">
                                                         <label class="control-label">Mobile Phone Number</label>
                                                         <div class="controls">
                                                             <input type="text" maxlength="20" id="mbc" name="mobile_phone_customer" class="span12" />
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                            <br>
                                            <div class="modal-footer">
                                              <button id="pushadd" type="submit" class="btn btn-primary">Add</button>
                                              <button data-dismiss="modal" class="btn" href="#">Cancel</button>
                                                        </div>
                                                          </form>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                            <!-- END FORM-->
                            @foreach($vst->vendor_pics as $pic)

                              <!-- Modal edit vendor_pics -->
                              <div class="modal fade" id="edven{{$pic->id}}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                              aria-labelledby="edven" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <!-- Modal Header -->
                                     <div class="modal-header" style="color: #0000;">
                                         <span aria-hidden="true">&times;</span>
                                         <span data-dismiss="modal" class="close sr-only" style="font-family: courier;font-size:36px">Edit Vendor PIC</span>
                                     </div>
                                 <!-- Modal Body -->
                                 <div class="modal-body">
                                        <form action="{{route('vendorpics.update', $pic->id)}}" class="form-horizontal" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                              {{ method_field('PUT') }}
                                                      <div class="span6">
                                                          <div class="control-group">
                                                              <label class="control-label">Nama PIC</label>
                                                              <div class="controls">
                                                                  <input type="text" maxlength="30" value="{{$pic->name}}" name="name_customer" class="span12"></input>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="span6">
                                                          <div class="control-group">
                                                              <label class="control-label">Vendor PIC Status</label>
                                                              <div class="controls">
                                                                <select class="span12 chzn-select" name="vendor_pic_status_customer" style="width:100px" data-placeholder="Status" tabindex="1">
                                                                  @foreach($vstatus as $a)
                                                                    <option value="{{ $a->id }}"  @if($a->id==$pic->vendor_pic_status_id) selected='selected' @endif >{{ $a->name }}</option>
                                                                    @endforeach()
                                                                </select>
                                                              </div>
                                                          </div>
                                                      </div>
                                                          <div class="span6">
                                                              <div class="control-group">
                                                                  <label class="control-label">Posisi</label>
                                                                  <div class="controls">
                                                                      <input type="text" maxlength="30" value="{{$pic->position}}" name="position_customer" class="span12" />
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="span6">
                                                              <div class="control-group">
                                                                  <label class="control-label">Email Customer</label>
                                                                  <div class="controls">
                                                                    <div class="input-prepend">
                                                                        <span class="add-on">@</span><input type="text" maxlength="30" style="width:160%;" value="{{$pic->email}}" name="email_customer" class="span12" />
                                                                    </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                              <div class="span6">
                                                                  <div class="control-group">
                                                                      <label class="control-label">Phone PIC</label>
                                                                      <div class="controls">
                                                                          <input type="text" maxlength="15" id="tax_phone" value="{{$pic->phone}}" name="phone_customer" class="span12" />
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                        <div class="span6">
                                                              <div class="control-group">
                                                                      <label class="control-label">Phone Mobile</label>
                                                                      <div class="controls">
                                                                          <input type="text" maxlength="15" id="tax_fax" value="{{$pic->mobile_phone}}" name="mobile_phone_customer" class="span12" />
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                      <div class="span9" style="text-align:right;" >
                                                                  {{-- <button type="submit" class="btn btn-success" value="PUT"></button> --}}
                                                                  <button id="vendorpic_sbumit" class="btn btn-success">
                                                                          <i class="icon-refresh"></i>
                                                                          Update Vendor PIC
                                                                      </button>
                                                                    </div>
                                                            </form>
                                                        </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       {{-- end --}}
                                </div>
                                @endforeach
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   <script src="../js/jquery-1.8.2.min.js">

   $("#pushadd").click(function(e){
            e.preventDefault()
           var $form = $("#addvpics");
           $.ajax({
               type: $form.attr('method'),
               url: $form.attr('action'),
               data: $form.serialize(),
               success: function (data, status) {
                   // alert(data.success); // THis is success message
                   // $('#addven').modal('hide');  // Your modal Id
               },
               error: function (result) {

               }
             });
         });
       </script>

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
<script src="{{ asset('js/dynamic-table-rates.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
<script async language="javascript" type="text/javascript">

        $(function(){
            $('#pemasoksbm').click(function (e) {
                e.preventDefault();
                $("#pemasoksbm").prop( "disabled", true );
                $("#pemasoksbm").text('process..');
                return new Promise((resolve, reject) => {
                    setTimeout(() => resolve(UpdateDataPemasok()), 3500)
                });
            });
        });

        async function UpdateDataPemasok() {
            
            const SuccessAlertsTransportAPI = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 7500
            })

            let company_name = $("#company_name").val();
            let director = $("#director").val();
            let type_of_business = $("#type_of_business").val();
            let since = $("#since").val();
            let no_npwp = $("#tax_no").val(); //npwp
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
            let an_bank = $("#an_bank").val();
            let term_of_payment = $("#term_of_payment").val();
            let status_id = $("#status_id").val();

                const apiPemasok = "{{ route('update.detail.d.pmsk', ['branch_id' => $some, 'id' => $vst->id] ) }}";
                const dataPemasok = { 

                            company_name: company_name,
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

                const responsePemasok = await fetch(apiPemasok, {

                        method: 'GET',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        body: JSON.stringify(dataPemasok),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                    }

                });

                const dataJSONpemasok = await responsePemasok.json();
                let TransportPromise = new Promise((resolve, reject) => {
                    setTimeout(() => resolve(dataJSONpemasok), 1000)
                });
    
                    let PemasokPromises = await TransportPromise;

                    $("#pemasoksbm").prop("disabled", false);
                    $("#pemasoksbm").text("Submit Your Order");

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
                    url: apiPemasok,
                    type: "GET",
                    dataType: "json",
                    data: dataPemasok,
                    success: function (data) {
                        Swal({
                            title: 'Accurate Cloud',
                            text: 'RESPONSE: '+ data.res,
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup',
                        }).then((result) => {
                            if (result.value) {
                                    
                                    $("#pemasoksbm").prop( "disabled", false );
                                    $("#pemasoksbm").html("<i class='icon-refresh'></i> Update Vendor");

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
                                $("#pemasoksbm").prop("disabled", false),
                                $("#pemasoksbm").text("Udpate Customer"), 1000)
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
            url: '/carikan_branch_bos',
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
              		$("#pc").keypress(function(data){
              			if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
              			{
              				$("#pc").html('errors')
              				return false;
              			}
              		});
            	});
          $(document).ready(function(){
              		$("#mbc").keypress(function(data){
              			if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
              			{
              				$("#mbc").html('errors')
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

@extends('admin.layouts.master', array('id_master_vendor' => session()->get('id_master_vendor')))
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
    <a href="{{ URL::to('vendorlist') }}">Vendor</a>
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
                              <strong>Whoops!</strong> There were some problems with your input.<br><br>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      @include('flash::message')
                      @if (\Session::has('success'))
                       <div class="alert alert-success">
                         <p>{{ \Session::get('success') }}</p>
                       </div><br />
                      @endif
                        <!-- BEGIN FORM-->
                        <form action="{{ url('vendorx') }}" class="form-horizontal" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                          <input type="hidden" name="vendorid" value="{{$vendorss}}" class="span12 " />
                          <input type="hidden" name="id_v" value="{{$vendors}}" class="span12 " />
                          <input type="hidden" name="statusid" value="1" class="span12 " />
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Nama Perusahaan</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" value="{{ old('company_name') }}" name="company_name" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Direktur</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" name="director" value="{{ old('director') }}" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Jenis Usaha</label>
                                            <div class="controls">
                                              <select class="type_of_business form-control" maxlength="20" style="width:398px;" value="{{ old('type_of_business') }}" name="type_of_business"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Tahun Berdiri</label>
                                            <div class="controls">
                                                <input type="text" maxlength="4" value="{{ old('since') }}" name="since" id="since" class="span12 " />
                                            </div>
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Zip Code</label>
                                            <div class="controls">
                                                <input type="text" maxlength="4" value="{{ old('zip_code') }}" name="zip_code" id="since" class="span12 " />
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
                                                <input type="text" maxlength="30" value="{{ old('tax_no') }}" name="tax_no" id="tax_no" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Alamat</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{ old('tax_address') }}" name="tax_address" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="Citys span12" name="tax_city" data-placeholder="Choose a City" tabindex="1">
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
                                                    <input type="text" maxlength="15" name="tax_phone" value="{{ old('tax_phone') }}" id="tax_phone" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Fax</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="16" value="{{ old('tax_fax') }}" name="tax_fax" id="tax_fax" class="span12" />
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
                                                <input type="text" maxlength="30" value="{{ old('address') }}" name="address" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="Citys span12" name="kota" data-placeholder="Choose a City" tabindex="1">
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
                                                <input type="text" value="{{ old('phone') }}" maxlength="15" name="phone" id="phone" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Fax</label>
                                                <div class="controls">
                                                    <input type="text"value="{{ old('fax') }}" maxlength="15" name="fax" id="fax" class="span12" />
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
                                                    <span class="add-on">@</span><input type="text" maxlength="20" style="width:160%;" name="email" value="{{ old('email') }}" class="span12" />
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Website</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{ old('website') }}" name="website" class="span12" />
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
                                                <label class="control-label"> <strong>Informasi PIC</strong></label>
                                                <div class="controls">
                                                    {{--  <input type="text" class="span12 " />  --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Nama</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{ old('nama_pic') }}" name="nama_pic" class="span12" />
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Jabatan</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{ old('title_name_pic') }}" name="title_name_pic" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">No Telepon</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="15" value="{{ old('no_pic') }}" name="no_pic" id="no_pic" class="span12" />
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
                                                    <input type="text" maxlength="30" name="bank_name" value="{{ old('bank_name') }}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">No rekening</label>
                                                    <div class="controls">
                                                        <input type="text" maxlength="30" value="{{ old('norek') }}" name="norek" id="norek" class="span12" />
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Atas Nama Rekening</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" value="{{ old('an_bank') }}" name="an_bank" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                        <label class="control-label">Term Of Payment</label>
                                                        <div class="controls">
                                                            <input type="text" maxlength="3" value="{{ old('term_of_payment') }}" name="term_of_payment" id="term_of_payment" class="span2" /> Day(s)
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>


                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                            <div class="form-actions" style=""   >
                                                    <button type="submit" class="btn btn-success">Register Vendor</button>
                                                    {{--  <button type="button" class="btn">Cancel</button>  --}}
                                                </div>
                                    </div>
                                </div>

                                </form>
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



   <script language="javascript" type="text/javascript">


   $("#since").datepicker( {
       format: " yyyy",
       viewMode: "years",
       minViewMode: "years"
   });

     $('.type_of_business').select2({
          placeholder: 'Cari...',
          ajax: {
          url: '/cari_usaha',
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
       $("#term_of_payment").keypress(function(data){
         if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
         {
           $("#term_of_payment ").html('errors')
           return false;
         }
       });
     });

     $('.Citys').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari-kota',
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


@endsection

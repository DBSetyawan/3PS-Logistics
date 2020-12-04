@extends('admin.layouts.master', array('id_vehicle'=> session()->get('id_vehicle')))
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css"
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
    {{ $menu}}
</li>
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
                <div class="widget blue">
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
                        <!-- BEGIN FORM-->
                        <form action="{{route('vehicle_accociate.update', $vehicle_find->id )}}" class="form-horizontal" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                          {{ method_field('PUT') }}
                          <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label"><pre><strong>Information Vehicle</strong></pre></label>
                                    <div class="controls">
                                        {{--  <input type="text" class="span12 " />  --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Registration Number Plate</label>
                                    <div class="controls">
                                        <input type="text" name="registrationNumberPlate" value="{{ $vehicle_find->registrationNumberPlate}}" class="span12 " />
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
                                    <label class="control-label"><pre><strong>Information<br/>Owner</strong></pre></label>
                                    <div class="controls">
                                        {{--  <input type="text" class="span12 " />  --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Nama Of Owner</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" name="nameOfOwner" value="{{ $vehicle_find->nameOfOwner}}" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Owner Address</label>
                                        <div class="controls">
                                            <input type="text" name="ownerAddress" value="{{ $vehicle_find->ownerAddress}}" class="span12 " />
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
                                            <label class="control-label"><pre><strong>Information<br/>Manufacture<br/>Vehicle</strong></pre></label>
                                            <div class="controls">
                                                {{--  <input type="text" class="span12 " />  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Manufacture Year</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="4" id="manufactureYear" name="manufactureYear" value="{{ $vehicle_find->manufactureYear}}" class="span12 " />
                                                </div>
                                            </div>
                                        </div>
                                    <div class="span6">
                                        <div class="control-group">
                                        <label class="control-label">Vehicle Identification Number</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" name="vehicleIdentificationNumber" value="{{ $vehicle_find->vehicleIdentificationNumber}}" class="span12 " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row-fluid">
                                       
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Cylinder Capacity</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" name="cylinderCapacity" value="{{ $vehicle_find->cylinderCapacity}}" id="tax_no" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Brand</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" name="brand" value="{{ $vehicle_find->brand}}" class="span12 " />
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Engine Number</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" name="engineNumber" value="{{ $vehicle_find->engineNumber}}" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Type</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" name="type" value="{{ $vehicle_find->type}}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="span12 chzn-select" value="{{old('tax_city')}}" name="tax_city" data-placeholder="Choose a City" tabindex="1">
                                                    @foreach($city as $cities)
                                                    <option value=""></option>
                                                    <option value="{{$cities->name}}" >{{$cities->name}}</option>
                                                    @endforeach()
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Model</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="30" name="model" value="{{ $vehicle_find->model}}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">No Telepon</label>
                                                <div class="controls">
                                                    <input type="text" id="tax_phone" name="tax_phone" value="{{ old('tax_phone') }}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Fax</label>
                                                <div class="controls">
                                                    <input type="text" id="tax_fax" name="tax_fax" value="{{ old('tax_fax') }}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <hr>
                                        </div>
                                    </div>
                            <div class="row-fluid">
                                    <div class="span11">
                                        <div class="control-group">
                                            <label class="control-label"><pre><strong>Information Types</strong></pre></label>
                                            <div class="controls">
                                                {{--  <input type="text" class="span12 " />  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Registration Year</label>
                                            <div class="controls">
                                                <input type="text" maxlength="4" id="registrationYear" value="{{ $vehicle_find->registrationYear}}" name="registrationYear" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Vehicle Ownership #Doc Number</label>
                                                <div class="controls">
                                                    <input type="text" name="vehicleOwnershipDocumentNumber" value="{{ $vehicle_find->vehicleOwnershipDocumentNumber}}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Kota</label>
                                            <div class="controls">
                                                <select class="span12 chzn-select" name="kota" data-placeholder="Choose a City" tabindex="1">
                                                  @foreach($city as $cities)
                                                  <option value=""></option>
                                                  <option value="{{$cities->id}}">{{$cities->name}}</option>
                                                  @endforeach()
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Color</label>
                                            <div class="controls">
                                                <input type="text" id="color" name="color" value="{{ old('color') }}" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                    <div class="control-group">
                                            <label class="control-label">License Plate Color</label>
                                            <div class="controls">
                                                <input type="text" id="licensePlateColor" name="licensePlateColor" value="{{ $vehicle_find->licensePlateColor}}" class="span12" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                    <label class="control-label">Type Fuel</label>
                                                    <div class="controls">
                                                        <input type="text" id="typeFuel" name="typeFuel" value="{{ $vehicle_find->typeFuel}}" class="span12" />
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Location Code</label>
                                                <div class="controls">
                                                    <input type="text" id="locationCode" name="locationCode" value="{{ $vehicle_find->locationCode}}" class="span12" />
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
                                                <label class="control-label"><pre><strong>Information<br/>Que Number</strong></pre></label>
                                                <div class="controls">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Registraion Que Number</label>
                                                <div class="controls">
                                                    <input type="text" name="registrationQueNumber" value="{{ $vehicle_find->registrationQueNumber}}" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Date Of Expired</label>
                                                    <div class="controls">
                                                            <div class="input-prepend">
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                        <input id="dateOfExpire" name="dateOfExpire" value="{{ $vehicle_find->dateOfExpire}}" type="text" class="m-ctrl-medium" />
                                                    </div>
                                                </div>
                                                    {{-- <div class="controls">
                                                        <input type="text" name="dateOfExpire" value="{{ old('dateOfExpire') }}"  class="span12" />
                                                    </div> --}}
                                                </div>
                                            </div>
                                    </div>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                        <div class="form-actions" style=""   >
                                            <button type="submit" class="btn btn-primary">Update information</button>
                                            {{--  <button type="button" class="btn">Cancel</button>  --}}
                                        <a class="btn btn-warning" href="{{ route('list.master.vehicle', session()->get('id')) }}">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>

   <script language="javascript" type="text/javascript">
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
             $("#no_rek").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#no_rek").html('errors')
                 return false;
               }
             });
         });

         $(function() {
        $("#dateOfExpire").datepicker({
            format: "yyyy-m-d"
        });
    });

           $(document).ready(function(){
             $("#term_of_payment").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#term_of_payment").html('errors')
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
             $("#tax_fax").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#tax_fax").html('errors')
                 return false;
               }
             });
         });
         $(document).ready(function(){
             $("#manufactureYear").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#tax_fax").html('errors')
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
                   $("#registrationYear").keypress(function(data){
                     if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                     {
                       $("#registrationYear").html('errors')
                       return false;
                     }
                   });
               });
               $("#registrationYear").datepicker( {
           format: " yyyy",
           viewMode: "years",
           minViewMode: "years"
       });
       $("#manufactureYear").datepicker( {
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
   </script>


@endsection

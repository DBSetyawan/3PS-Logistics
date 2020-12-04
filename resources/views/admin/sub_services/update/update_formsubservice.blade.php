@extends('admin.layouts.master', array('mastersubserviceid' => session()->get('mastersubserviceid')))
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
    <a href="#">Sub Service List</a>
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
                      <div class="modal-footer">
                          FORM DETAIL SUB SERVICE: <strong>{{ $lm->name }}</strong>
                        </div>
                        <!-- BEGIN FORM-->
                <form class="form-horizontal" id="add_item" method="POST" action="{{route('subservice.update', $lm->id)}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <br />
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Service</label>
                                <div class="controls">
                                    <select enabled="true" class="input-large m-wrap" style="width:224px" tabindex="1" id="sb_service" name="sb_service">
                                        @foreach($sub_service as $a)
                                        <option value="{{ $a->id }}"@if($a->id==$lm->service_id) selected='selected' @endif>{{ $a->name }}</option>
                                        @endforeach()
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Company</label>
                            <div class="controls">
                                <select class="input-large m-wrap" style="width:224px" tabindex="1" id="companys_id" name="companys_id">
                                    @foreach($srvc as $a)
                                    <option value="{{ $a->id }}"@if($a->id==$lm->company_id) selected='selected' @endif>{{ $a->name }}</option>
                                    @endforeach()
                            </select>
                        </div>
                    </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Name</label>
                                    <div class="controls">
                                        <input class="input-large" type="text" maxlength="30" name="name" value="{{ $lm->name }}" />
                                    </div>
                                </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Remark</label>
                                <div class="controls">
                                <input class="input-large" type="text" maxlength="30" name="remark" value="{{ $lm->remark }}" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Prefix</label>
                            <div class="controls">
                            <input readonly="true" class="input-large" type="text" maxlength="30" name="prefix" value="{{ $lm->prefix }}" />
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-success" href="{{ route('master.sub_services.list', session()->get('id')) }}">Back To List</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
<script src="{{ asset('js/table_item_list.js') }}"></script>
<!--script for this page only-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
   <script language="javascript" type="text/javascript">
       $('#destination_x').on('change', function(e){
                let destination = e.target.value;
                $.get('/loaded_auto_search_txt/find/'+ destination, function(data){
                    $.each(data, function(ix, ox){
                        $.get('/loaded_auto_search_txt/find/'+ $('#originx').val(), function(dax){
                            $.each(dax, function(ix, sdx){
                                $('#itemovdesc').val(''+'pengiriman'+' dari '+sdx.name+' ke '+ox.name);
                            });
                        });
                    })
                });
           });

           $('#companys_id').select2({
            placeholder: 'Cari...',
            ajax: {
              url: '/load-compan/find',
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
           $('#sb_service').select2({
            placeholder: 'Cari...',
            ajax: {
              url: '/sub-services/find',
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

@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../../img/logo.ico" />

    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="../../assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/style-responsive.css" rel="stylesheet" />
    <link href="../../css/style-default.css" rel="stylesheet" id="style_color" />

    <link href="../../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../../assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">

    <link rel="stylesheet" type="text/css" href="../../assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/select2.4.0.3/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/clockface/css/clockface.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" href="../../assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

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
    <a href="{{ url('users') }}">Users List</a>
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
                        <!-- BEGIN FORM-->
                        <form action="{{ route('Companys.update', $data_company->id) }}" class="form-horizontal" method="PUT">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        {{-- {{ method_field('PUT') }} --}}
                          <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label"><strong>Informasi Edit Company</strong></label>
                                    <div class="controls">
                                        {{--  <input type="text" class="span12 " />  --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Company</label>
                                    <div class="controls">
                                        <input type="text" maxlength="30" value="{{ $data_company->name }}" id="name" name="name" class="span12 " />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="row-fluid">
                                <div class="span12" style="text-align:right;" >
                                    <div class="form-actions" style=""   >
                                        <button type="submit" class="btn btn-success">Update</button>
                                        {{--  <button type="button" class="btn">Cancel</button>  --}}
                                        <a class="btn btn-warning" href="{{ route('Companys.index') }}">Cancel</a>
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

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
   @include('sweetalert::view')
   <script src="../../js/jquery-1.8.2.min.js"></script>
   <script src="../../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="../../assets/ckeditor/ckeditor.js"></script>
   <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../../js/select2.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="../../assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="../../js/jquery.blockui.js"></script>
   
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

   <script src="../../js/jQuery.dualListBox-1.3.js" language="javascript" type="text/javascript"></script>


   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="../../assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="../../assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../../assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="../../assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="../../assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="../../assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="../../assets/fancybox/source/jquery.fancybox.pack.js"></script>
   {{-- <script src="../../js/jquery.scrollTo.min.js"></script> --}}



   <!--common script for all pages-->
   <script src="../../js/common-scripts.js"></script>

   <!--script for this page-->
   <script src="../../js/form-component.js"></script>
  <!-- END JAVASCRIPTS -->

   <script language="javascript" type="text/javascript">
    
       $(function() {

           $.configureBoxes();

       });

    function show() {
    var p = document.getElementById('asd');
    p.setAttribute('type', 'text');
}

function hide() {
    var p = document.getElementById('asd');
    p.setAttribute('type', 'password');
}

var pwShown = 0;

document.getElementById("eye").addEventListener("click", function () {
    if (pwShown == 0) {
        pwShown = 1;
        show();
    } else {
        pwShown = 0;
        hide();
    }
}, false);
$(document).on('click', '.toggle-password', function() {

$(this).toggleClass("fa-eye fa-eye-slash");

    $('#asd').getAttribute('type') === 'password' ? $('#asd').getAttribute('type','text') : $('#asd').attr('type','password');
});

   </script>
@endsection

@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="../img/logo.ico" />

    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/style-responsive.css" rel="stylesheet" />
    <link href="../css/style-default.css" rel="stylesheet" id="style_color" />
    <link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />

    <link rel="stylesheet" type="text/css" href="../assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="../assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="../assets/clockface/css/clockface.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" href="../assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

@endsection
@section('brand')
<a class="brand" href="/home">
    {{--  <img src="../img/logo.png" alt="Tiga Permata System" />  --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home">Home</a>
    <span class="divider">/</span>
</li>
<li>
    <a href="{{ URL::to('customer') }}">Customer</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
</li>
<li class="pull-right search-wrap">
    <form action="search_result.html" class="hidden-phone">
        <div class="input-append search-input-area">
            <input class="" id="appendedInputButton" type="text">
            <button class="btn" type="button"><i class="icon-search"></i> </button>
        </div>
    </form>
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
                      @include('flash::message')
                      @if (\Session::has('success'))
                       <div class="alert alert-success">
                         <p>{{ \Session::get('success') }}</p>
                       </div><br />
                      @endif
                        <!-- BEGIN FORM-->
                        <form action="{{route('customerpics.update', $customerpics->id)}}" class="form-horizontal" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        {{ method_field('PUT') }}
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Nama</label>
                                        <div class="controls">
                                            <input type="text" maxlength="30" value="{{$customerpics->name}}" name="name_customer" class="span12"></input>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Customer PIC Status</label>
                                        <div class="controls">
                                          <select class="span12 chzn-select" name="customer_pic_status_customer" style="width:100px" data-placeholder="Status" tabindex="1">
                                            @foreach($vstatus as $a)
                                                <option value="{{ $a->id }}"  @if($a->id==$customerpics->customer_pic_status_id) selected='selected' @endif >{{ $a->name }}</option>
                                            @endforeach()
                                          </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Posisi</label>
                                            <div class="controls">
                                                <input type="text" maxlength="30" value="{{$customerpics->position}}" name="position_customer" class="span12" />
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
                                                  <span class="add-on">@</span><input type="text" maxlength="30" style="width:160%;" value="{{$customerpics->email}}" name="email_customer" class="span12" />
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Phone</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="15" id="tax_phone" value="{{$customerpics->phone}}" name="phone_customer" class="span12" />
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="row-fluid">

                                        <div class="span6">
                                        <div class="control-group">
                                                <label class="control-label">Phone Mobile</label>
                                                <div class="controls">
                                                    <input type="text" maxlength="15" id="tax_fax" value="{{$customerpics->mobile_phone}}" name="mobile_phone_customer" class="span12" />
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
                                                     <!-- BEGIN ADVANCED TABLE widget-->
                                                     <div class="row-fluid">
                                                          <div class="span12">
                                                          <!-- BEGIN EXAMPLE TABLE widget-->
                                                          <!-- END EXAMPLE TABLE widget-->
                                                        </div>
                                                      <!-- END ADVANCED TABLE widget-->

                                                     <!-- END PAGE CONTENT-->
                                                    </div>
                                        </div>
                                    </div>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                      <div class="form-actions" style="">
                                              {{-- <button type="submit" class="btn btn-success" >Update Customer PIC</button> --}}
                                              <button type="submit" class="btn btn-success" value="PUT">
                                                    <i class="icon-refresh"></i>
                                                    Update Customer PIC
                                                </button>
                                              <a class="btn btn-info" href="{{ route('master.customer.list', session()->get('id')) }}">Cancel</a>
                                          </div>
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

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
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

   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../assets/boot#strap/js/bootstrap-fileupload.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
   <script type="text/javascript" src="../assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="../assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="../assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>



   <!--common script for all pages-->
   <script src="../js/common-scripts.js"></script>

   <!--script for this page-->
   <script src="../js/form-component.js"></script>
  <!-- END JAVASCRIPTS -->

   <script language="javascript" type="text/javascript">

       $(function() {

           $.configureBoxes();

       });

       $('.type_of_business').select2({
            placeholder: 'Cari...',
            ajax: {
            url: '/cari',
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
   </script>


@endsection

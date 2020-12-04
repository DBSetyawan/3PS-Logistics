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
{{-- <link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" /> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
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
    <a href="#">Cash Advanced</a>
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
                        @role('super_users|administrator|3PL SURABAYA ALL PERMISSION')
                        <!-- BEGIN FORM-->
                        {{-- <form action="{{url('cash_advanced')}}" class="form-horizontal" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " /> --}}
                    <div style="text-align:left;">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Driver Name</label>
                                    <div class="controls">
                                        <select style="width:398px" class="cash_advanx" tabindex="-1" name="drivers_x" id="drivers_x">
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                <label class="control-label" >Amount </label>
                                    <div class="controls controls-row">
                                        <input type="text" maxlength="15" style="width:398px" class="input-block-level" placeholder="Enter Amount" id="amounts" name="amounts" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div style="text-align:right;">
                                        {{-- <a class="btn btn-info" href="{{ redirect()->Back()->getTargetUrl() }}">Cancel</a> --}}
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <button id="add_cash" value="Add" style="margin: 1px 180px" class="btn btn-success">Submit <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <hr>
                                <br/>
                            </div>
                        </div>
                        @endrole
                        <table class="table table-striped table-bordered table-striped" id="sample_1">
                                <thead>
                                    <tr>
                                        <th bgcolor="#FAFAFA"><i class="icon-question-sign"></i> Name</th>
                                        <th bgcolor="#FAFAFA"><center><i class="icon-money"></i> Amount</center></th>
                                        <th bgcolor="#FAFAFA"><center><i class="icon-money"></i> Selisih</th>
                                        <th bgcolor="#FAFAFA"><center><i class="icon-bullhorn"></i> Report Amount</center></th>
                                        <th bgcolor="#FAFAFA"><center><i class="icon-file"></i> Status</center></th>
                                        <th bgcolor="#FAFAFA"><center><i class="icon-edit"></i> Action</center></th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    @foreach($cashadvance as $data_cash_advance)
                                        <tr class="odd gradeX">
                                            <td style="width:19%;">{{ $data_cash_advance->drivers_master["name"] }}</td>
                                            <td style="width:23%;"><center>Rp. {{ number_format($data_cash_advance->amount,0) }}, -</center></td>
                                            <td style="width:11%;"><center>Rp. {{ number_format($data_cash_advance->selisih,0) }}, -</center></td>
                                            <td style="width:22%;"><center><span class="badge badge-success"> {{ $data_cash_advance->report_amount }} </span></center></td>
                                            @if ($data_cash_advance->status_advanced->name == "create")
                                            <td style="width: 20%;"><center><span class="label btn btn-primary ">created</span></center></td>
                                        @endif
                                        @if ($data_cash_advance->status_advanced->name == "report")
                                        <td style="width: 20%;"><center><span class="label btn btn-warning ">report</span></center></td>
                                    @endif
                                    @if ($data_cash_advance->status_advanced->name == "check")
                                    <td style="width: 20%;"><center><span class="label btn btn-info ">check</span></center></td>
                                @endif
                                @if ($data_cash_advance->status_advanced->name == "approve")
                                <td style="width: 20%;"><center><span class="label btn btn-success ">approved</span></center></td>
                            @endif
                            @if ($data_cash_advance->status_advanced->name == "reject")
                                    <td style="width: 20%;"><center><span class="label btn btn-danger ">reject</span></center></td>
                                        @endif @if ($data_cash_advance->status_advanced->name == "closed")
                                        <td style="width: 20%;"><center><span class="label btn label-danger ">closed</span></center></td>
                                    @endif
                                    <td style="width:30%;">
                                        @can('driver')
                                            <button onclick="location.href='{{ route('cash_advanced.show', $data_cash_advance->id) }}'"
                                            class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                    data-content="Report cash drivers">
                                                    <i class="icon-file"></i>
                                                    </button>
                                        @endcan
                                            @can('operasional')
                                                <button onclick="location.href='{{ route('cash_advanced.show', $data_cash_advance->id) }}'"
                                                    class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                    data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                    data-content="Report cash Cashier">
                                                    <i class="icon-file"></i>
                                                </button>
                                            @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        {{-- </form> --}}
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
<!--script for this page only-->
<script src="{{ asset('js/transport_t_list.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
   <!-- END JAVASCRIPTS -->
   <script language="javascript" type="text/javascript">

    $("#add_cash").click(function(event) {
        event.preventDefault();
        const driver = $('#drivers_x').val();
        const amount = $('#amounts').val();
        if (! amount || !driver) {

            swal("System Detects","Maaf inputan tidak ada yang boleh kosong","error");

        } else {

            // swal("System Detects","test successfully","success");

            let request = $.ajax({
                    
                    url: "{{ url('/add-cash-advanced-r')}}",
                    method: "GET",
                    dataType: "json",
                    data: { 
                        driver:driver,
                        amount:amount
                    },
                    success: function (data) {
                        Swal({
                            title: 'Successfully',
                            text: "You have done Added Cash on Driver!", //this function in progress deploy ...
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Okay!',
                        }).then((result) => {
                            if (result.value) {
                                // let total = 0;
                                location.reload();
                                $('#driver_x').empty();
                                $('#amounts').val('');
                                // $('#spanty').each(function(){
                                //   total += parseFloat(this.innerHTML)
                                // });
                                // $('#spanty').text(total+data.total_amount);

                            }
                        })
                    },
                        error: function(data){
                            Swal({
                                type: 'error',
                                title: 'Terjadi kesalahan sistem..',
                                text: 'Maaf anda tidak bisa melanjutkan proses, sedang terjadi kesalahan sistem!',
                                footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                    }
                );
            }
    });

    let total =0;
    $('#spanty').each(function(){
        total = this.innerHTML
    });

    // console.log(parseFloat(total.replace(/,/g, '')))


    $('.cash_advanx').select2({
           placeholder: 'Cari...',
           ajax: {
           url: '/load-drivers-names',
           dataType: 'json',
           delay: 250,
                processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                    text: item.id +' - '+ item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                        cache: true
                }
            }
        );
        
    $('.jobshipments').select2({
           placeholder: 'Cari...',
           ajax: {
           url: '/load-job-shipment-find',
           dataType: 'json',
           delay: 250,
                processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                    text: item.id +' - '+ item.job_no,
                                    id: item.id
                                }
                            })
                        };
                    },
                        cache: true
                }
            }
        );

        $('.cost_categorys').select2({
           placeholder: 'Cari...',
           ajax: {
           url: '/load-cost-cateogys-find',
           dataType: 'json',
           delay: 250,
                processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                    return {
                                    text: item.id +' - '+ item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                        cache: true
                }
            }
        );

          
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

   </script>


@endsection

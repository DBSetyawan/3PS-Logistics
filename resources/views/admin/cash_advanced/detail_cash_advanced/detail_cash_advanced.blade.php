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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="../assets/select2.4.0.3/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="../assets/clockface/css/clockface.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" href="../assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-daterangepicker/daterangepicker.css" />
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
    <a href="#">Cash Advanced List</a>
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
                        {{-- <form action="{{url('cash_advanced')}}" class="form-horizontal" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " /> --}}
                    <div style="text-align:left;">
                        <div class="row-fluid">
                            <div class="span6">
                                @can('driver')
                                    <div class="control-group">
                                        <label class="control-label">Category</label>
                                        <div class="controls">
                                            <select style="width:398px" class="asddasdasd" tabindex="-1" name="categorys" id="categorys">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                    <label class="control-label" >Amount</label>
                                        <div class="controls controls-row">
                                            <input type="text" maxlength="15" style="width:398px" class="input-block-level" placeholder="Enter Amount" id="amounc" name="amounc" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                    <label class="control-label" >Jobs</label>
                                        <div class="controls controls-row">
                                            <select style="width:398px" class="jobshipments" tabindex="-1" name="jobsuid" id="jobsuid">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group hidden">
                                            <label class="control-label" >Job shipments</label>
                                                <div class="controls controls-row">
                                                    <input type="text" maxlength="15" style="width:398px" class="input-block-level" placeholder="Enter Amount" id="jobidinc" name="jobidinc" required>
                                                </div>
                                            </div>
                                          
                                    <div class="control-group">
                                        <div style="text-align:right;">
                                            {{-- <a class="btn btn-info" href="{{ redirect()->Back()->getTargetUrl() }}">Cancel</a> --}}
                                            <div class="controls controls-row">
                                                <button id="add_transaction" value="Add" style="margin: 1px 180px" class="btn btn-success">Submit <i class="fas fa-plus-circle"></i> <i class=""></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                <div class="control-group hidden">
                                    <label class="control-label" >id cash advanced</label>
                                        <div class="controls controls-row">
                                            <input type="text" maxlength="15" style="width:398px" class="input-block-level" value="{{ $id }}" id="id_cash" name="id_cash" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <div style="text-align:right;">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <span> Total Amount : Rp.</span><span id="spanty"> {{number_format($datacount->amount,0)}}</span>
                                                        </div>
                                                        <div class="controls">
                                                            <span> Report Amount :</span><span id="reports"> {{ $count_report_amount }}</span>
                                                        </div>
                                                        @if ($count_report_amount <= $hasil_selisih)
                                                        <div class="controls">
                                                            <span> Selisih : - Rp.</span><span id="reportsdas"> {{number_format($hasil_selisih,0)}}</span>
                                                        </div>
                                                        @else
                                                        <div class="controls">
                                                            <span> Selisih : Rp.</span><span id="reports"> {{number_format($hasil_selisih,0)}}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="control-group hidden">
                                    <label class="control-label" >cash advanced</label>
                                    <div class="controls controls-row">
                                        <input type="text" maxlength="15" style="width:398px" class="input-block-level" value="{{ $datacount->id }}" id="advncd" name="advncd" required>
                                    </div>
                                </div>
                            </div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span12">
                                            <hr>
                                        </div>
                                    </div>
                                <table class="table table-striped table-bordered table-striped" id="transaction_cash_advanced">
                                        <thead>
                                            <tr>
                                                <th bgcolor="#FAFAFA"><i class="icon-question-sign"></i> Category</th>
                                                <th bgcolor="#FAFAFA"><center><i class="icon-bookmark"></i> Job ID</center></th>
                                                <th bgcolor="#FAFAFA"><center><i class="icon-money"></i> Amount</th>
                                                <th bgcolor="#FAFAFA"><center><i class="icon-file"></i> Status</th>
                                                <th bgcolor="#FAFAFA"><center><i class="icon-edit"></i> Action</center></th>
                                            </tr>  
                                        </thead>
                                        <tbody>
                                        @foreach($datadtl as $list_cash_advanced)
                                            <tr class="odd gradeX">
                                                <td style="width:19%;">{{ $list_cash_advanced->categorys->name }}</td>
                                                <td style="width:19%;"><center>{{ $list_cash_advanced->jobs_shipments->job_no }}</center></td>
                                                <td style="width:23%;"><center>Rp. {{ number_format($list_cash_advanced->amount,0) }}, -</center></td>
                                                @if ($list_cash_advanced->status_cash_advanced->name == "create")
                                                <td style="width: 20%;"><center><span class="label btn btn-primary ">created</span></center></td>
                                            @endif
                                            @if ($list_cash_advanced->status_cash_advanced->name == "report")
                                            <td style="width: 20%;"><center><span class="label btn btn-warning ">report</span></center></td>
                                        @endif
                                        @if ($list_cash_advanced->status_cash_advanced->name == "check")
                                        <td style="width: 20%;"><center><span class="label btn btn-info ">check</span></center></td>
                                    @endif
                                    @if ($list_cash_advanced->status_cash_advanced->name == "approve")
                                    <td style="width: 20%;"><center><span class="label btn btn-success ">approved</span></center></td>
                                @endif
                                @if ($list_cash_advanced->status_cash_advanced->name == "reject")
                                        <td style="width: 20%;"><center><span class="label btn btn-danger ">reject</span></center></td>
                                            @endif @if ($list_cash_advanced->status_cash_advanced->name == "closed")
                                            <td style="width: 20%;"><center><span class="label btn label-danger ">closed</span></center></td>
                                        @endif
                                                {{-- <td style="width:19%;">{{ $list_cash_advanced->status_cash_advanced->name }}</td> --}}
                                                <td style="width:20%;">
                                                    <button class="btn popovers btn-small btn-info ModalStatusClassOPS" data-toggle="modal" 
                                                        data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="bottom"
                                                        data-content="Update status" data-target="#ModalStatusOPS" data-id="{{ $list_cash_advanced->id }}">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                        <div class="row-fluid">
                            <div class="span12">
                                <hr>
                            </div>
                        </div>
                        <div class="modal fade" id="ModalStatusOPS" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                        aria-labelledby="changed_status_adv" aria-hidden="true" style="width:600px">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel1">Update Cash Detail</h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="update_list_cash_advancedd">
                                <br />
                                <div class="control-group">
                                        <label class="control-label" style="text-align: end">Update Status</label>
                                        <div class="controls">
                                            <select class="update_status_advcd form-control validate[required]" style="width:250px;" id="update_status_ca" name="update_status_ca">
                                        </select>
                                    </div>
                                </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    <button id="update_status_adv" type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        {{-- </form> --}}
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
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
   @include('sweetalert::view')
   <script src="../js/jquery-1.8.2.min.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/select2.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
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
   <script src="../js/cash_advanced_list.js"></script>
   {{-- <script src="../js/offline.js"></script> --}}
   <script src="../js/transaction_cash_advanced.js"></script>
  <!-- END JAVASCRIPTS -->
   <script language="javascript" type="text/javascript">

    // this handle request if connection error
        //     $.ajax({
        //     url: /your_url,
        //     type: "POST or GET",
        //     data: your_data,
        //     success: function(result){
        //     //do stuff
        //     },
        //     error: function(xhr, status, error) {

        //     //detect if user is online and avoid the use of async
        //         $.ajax({
        //             type: "HEAD",
        //             url: document.location.pathname,
        //             error: function() { 
        //             //user is offline, do stuff
        //             console.log("you are offline"); 
        //             }
        //         });
        //     }   
        // });

        //this connection by variable ajax response if done or fail
        // request.done(function( msg ) {
        //     $( "#log" ).html( msg );
        // });
        
        // request.fail(function( jqXHR, textStatus ) {
        //     alert( "Request failed: " + textStatus );
        // });

        // this function check connection untuk 5 detik per hit
        // var interval = null;
        //     var xhr = null;

        //     $.ajax({
        //         beforeSend: function(jqXHR, settings) {  
        //             xhr = jqXHR;  // To get the ajax XmlHttpRequest 
        //         },
        //         url:'server.php',
        //         data:'lots of data from 200KB to 5MB',
        //         type:'post',
        //         success: function(data)
        //                     {
        //                         alert('Success');
        //                     //some stuff on success

        //                     },
        //         error: function(XMLHttpRequest, textStatus, errorThrown)
        //                     {
        //                         alert('Failure');
        //                     //some stuff on failure
        //                     },
        //         complete: function(data)
        //                     {
        //                         alert('Complete');
        //                         //To clear the interval on Complete
        //                         clearInterval(interval);
        //                     },
        //         });

        //     interval = setInterval(function() {
        //         var isOnLine = navigator.onLine;
        //             if (isOnLine) {
        //                 // online
        //             } else {
        //                 xhr.abort();
        //             }
        //         }, 5000);

        // handle request per 2 detik sekali
        // function myAjaxMethod()
        // {
        // try 
        // {
        //     $.ajax({ ... });
        // } catch (err) 
        // { 
        //     console.log(err.message); 
        //     setTimeout(function(){myAjaxMethod(),2000});
        // }
        // }

    $("#add_transaction").click(function(event) {
        event.preventDefault();
        const category = $('#categorys').val();
        const cash_advid = $('#advncd').val();
        const job_no = $('#jobidinc').val();
        const amouns = $('#amounc').val();
        const jobs = $('#jobsuid').val();
        let total = 0;
        $('#reportsdas').each(function(){
            total = this.innerHTML
        });
        const reports_mounts = parseFloat(total.replace(/,/g, ''))

        if (! category || !amouns || !jobs) {

            swal("System Detects","Maaf inputan tidak ada yang boleh kosong","error");

        } else {
            console.log(reports_mounts)

            // swal("System Detects","test successfully","success");

            let request = $.ajax({
                    
                    url: "{{ url('/add-cash-of-drivers')}}",
                    method: "GET",
                    dataType: "json",
                    data: { 
                        category:category,
                        amouns:amouns,
                        jobs:jobs,
                        cash_advid:cash_advid,
                        job_no:job_no,
                        reports_mounts:reports_mounts
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
                                location.reload();
                                $('#categorys').empty();
                                $('#amounc').val('');
                                $('#jobsuid').empty();

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

    $(function () {
        $(".ModalStatusClassOPS").click(function (e) {
        e.preventDefault();
            let status_order_id = $(this).data('id');
            const cashid = $('#id_cash').val();
            // $.get('/updated-status-cash-advanced/'+ cashid, function(showingdatastatus){
                // console.log(showingdatastatus.id)
            $("#update_list_cash_advancedd").attr('action', '/update-status-ca/find/'+ cashid +'/before/'+status_order_id);
                            $('.update_status_advcd').select2({
                                placeholder: 'Cari...',
                                "language": {
                                "noResults": function(){
                                    // <a href='/transport-order-list' class='btn btn-success'>Create Transport Order</a> thhis button, if you want add button on select2
                                        return "Maaf data gagal diproses ...";

                                    }

                                },
                                ajax: {
                                    url: '/load-status-cash-master/'+status_order_id,
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
                        }
                //     );
                // }
            );
        })
    });

    // let total =0;
    // $('#spanty').each(function(){
    //     total = this.innerHTML
    // });

    // console.log(parseFloat(total.replace(/,/g, '')))
        $('#jobsuid').on('change', function(e){
            let id_jobs = document.getElementById("jobsuid").value;
                    $.get('/find-cash-advanced-transaction-reports/id/'+ id_jobs, function(data){
                            $.each(data, function(index, Obj){
                                $('#jobidinc').val(''+Obj.job_no);
                            }   
                        );
                    }
                );
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

        $('.asddasdasd').select2({
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

       $(function() {

           $.configureBoxes();

       });
   </script>
@endsection

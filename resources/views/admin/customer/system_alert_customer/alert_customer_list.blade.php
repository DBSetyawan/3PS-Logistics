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
    <a href="#">Customer</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
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
       @include('flash::message')
       @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
       @endif
       <div class="row-fluid">
            <div class="span12">
            <div class="widget red">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> {{ $menu }}</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
            <div class="widget-body">
                <div>
                    &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>#NO ID</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($cstatusid as $list_customer)
                            <tr class="odd gradeX">
                                <td style="width: 6%;">{{$list_customer->customer_id}}</td>
                                <td style="width: 20%;">{{$list_customer->name}}</td>
                                <td style="width: 40%;">{{$list_customer->address}}</td>
                                <td style="width: 10%;">{{$list_customer->phone}}</td>
                                <td style="width: 17%;">{{$list_customer->email}}</td>
                                <td style="width: 2%;"><span class="label label-inverse">{{$list_customer->cstatusid->status}}</span></td>
                                <td style="width: 6%;"><input type="checkbox" id="check_alert_item" name="check_alert_item[]" value="{{$list_customer->id}}"></td>
                            </tr>
                          @endforeach()
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
 </div>
@endsection

@section('javascript')
   <script src="../js/jquery-1.8.3.min.js"></script>
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
   <script src="{{ asset('js/system_alert_customerlist.js') }}"></script>
   <script type="text/javascript">
    $("#check_alert_item").on("click", function() {
    let state = $(this).is(':checked');
    const id_item = $('#check_alert_item').val();
   if (!state==false) {
        let flag=1; 
        Swal({
        title: 'Pemberitahuan system',
        text: "Pastikan file sudah terupdate di program accurate, setelah anda berhasil mengupdate data ini!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya Mengerti!',
        cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ url('/alert-customer-update') }}/"+id_item,
                    dataType: "json",
                    data: {
                        id:id_item,
                        flag:flag,
                            },
                            success: function (data) {
                                Swal(
                                    'Updated!',
                                    'Your file has been updated to ready transcation.',
                                    'success'
                                )
                                    setTimeout(function () {
                                        location.reload()
                                    }, 5000);
                                },
                                    error: function(data){
                                        swal("Error Exception!", "Gagal mengupdate data, cek koneksinya!", "error");
                            }
                        });
                    }
                })
            }
                else {
                swal("Uncheck detected!", 'Gagal mengupdate, check kembali jika ingin mengupdate dan tekan tombol <button id="increase" class="btn btn-cont" style="background:#3085d6;color:white">Ya, Saya Mengerti', "warning");
            }
        });
   </script>
@endsection

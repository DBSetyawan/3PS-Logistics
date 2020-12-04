@extends('admin.layouts.master')
@section('head')
    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/like-yt.css') }}" />
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
    <link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
    <link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-chrome-indicator.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-language-english.css') }}" rel="stylesheet"> --}}
    <style>
        .empty-state {
            width: 95%;
            position: relative;
            -webkit-border-radius: 4px;
            border-radius: 6px;
            border: 2px dashed #eee;
            text-align: center;
            padding: 10px 14px;
            margin: 10px 0
        }
        </style>
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
    <a href="#">Application Program Interface</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>
@endsection
@section('content')
<div id="progress" class="waiting">
    <dt></dt>
    <dd></dd>
</div>
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
       {{-- <div class="row-fluid">
            <div class="span12">
            <div class="widget" style="color:GRAY">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> {{ $menu }}</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div> --}}
                <div class="empty-state">
                        This application is already connected, and integrated automatically with other applications.
                  </div>
            {{-- <div class="widget-body">
                <div>
                    &nbsp;
                    </div>
                    <table class="table table-striped table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>API interface</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @role('administrator')
                                <tr class="odd gradeX">
                                    <td style="width: 6%;"><input type="checkbox" id="izzy" name="izzy" value="api_izzy" {{ isset($api_v1) ? $api_v1 == 'true' ? 'checked' :'' :'' }}/><span> </span>Izzy Transport</td>
                                    <td style="width: 6%;">Mengintegrasikan koneksi data dengan Izzy transport</td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td style="width: 6%;"><input type="checkbox" id="api_accurate" name="api_accurate" value="api_accurate" {{ isset($api_v2) ? $api_v2 == 'true' ? 'checked' :'' :'' }}/><span> Accurate desktop</span></td>
                                    <td style="width: 6%;">Mengimport format data ke XML untuk Accurate Desktop</td>
                                </tr>
                            @endrole
                                @can('superusers')
                                    <tr class="odd gradeX">
                                        <td style="width: 6%;"><input type="checkbox" id="izzy" name="izzy" value="api_izzy" {{ isset($api_v1) ? $api_v1 == 'true' ? 'checked' :'' :'' }}/><span> </span>Izzy Transport</td>
                                        <td style="width: 6%;">Mengintegrasikan koneksi data dengan Izzy transport</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td style="width: 6%;"><input type="checkbox" id="api_accurate" name="api_accurate" value="api_accurate" {{ isset($api_v2) ? $api_v2 == 'true' ? 'checked' :'' :'' }}/><span> Accurate desktop</span></td>
                                        <td style="width: 6%;">Mengimport format data ke XML untuk Accurate Desktop</td>
                                    </tr>
                                @elsecan('warehouse')
                                    <tr class="odd gradeX">
                                        <td style="width: 6%;"><input type="checkbox" id="api_accurate" name="api_accurate" value="api_accurate" {{ isset($api_v2) ? $api_v2 == 'true' ? 'checked' :'' :'' }}/><span> Accurate desktop</span></td>
                                        <td style="width: 6%;">Mengimport format data ke XML untuk Accurate Desktop</td>
                                    </tr>
                                @endcan
                            @role('3PL - BANDUNG TRANSPORT')
                                <tr class="odd gradeX">
                                    <td style="width: 6%;"><input type="checkbox" id="izzy" name="izzy" value="api_izzy" {{ isset($api_v1) ? $api_v1 == 'true' ? 'checked' :'' :'' }}/><span> </span>Izzy Transport</td>
                                    <td style="width: 6%;">Mengintegrasikan koneksi data dengan Izzy transport</td>
                                </tr>
                            @endrole
                            @role('3PL[OPRASONAL][WHS]')
                                <tr class="odd gradeX">
                                    <td style="width: 6%;"><input type="checkbox" id="api_accurate" name="api_accurate" value="api_accurate" {{ isset($api_v2) ? $api_v2 == 'true' ? 'checked' :'' :'' }}/><span> Accurate desktop</span></td>
                                    <td style="width: 6%;">Mengimport format data ke XML untuk Accurate Desktop</td>
                                </tr>
                            @endrole
                            @role('3PL[ACCOUNTING][TC]')
                            <tr class="odd gradeX">
                                <td style="width: 6%;"><input type="checkbox" id="api_accurate" name="api_accurate" value="api_accurate" {{ isset($api_v2) ? $api_v2 == 'true' ? 'checked' :'' :'' }}/><span> Accurate desktop</span></td>
                                <td style="width: 6%;">Mengimport format data ke XML untuk Accurate Desktop</td>
                            </tr>
                        @endrole
                        </tbody>
                    </table>
                </div> --}}
            {{-- </div>
            </div>
        </div>
 </div> --}}
 <div id="result"></div>
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
<script src="{{ asset('js/system_alert_customerlist.js') }}"></script>
   
   <script type="text/javascript">
        function noBack() { 
                  window.history.forward(); 
             }
             
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
   
        function ajax(url) {
            return new Promise(function(resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                resolve(this.responseText);
                };
                xhr.onerror = reject;
                xhr.open('GET', url);
                xhr.send();
            });
        }

    $(document).ready(function(){
        const branch_id = "{{ $some }}";

        $('input[type="checkbox"]').click(function(e){
            if($(this).prop("checked") == true){
                let izzy = [];
                izzy.push($(this).val());
                $.ajax({
                    type: "get",
                    url: `{{ url('/dashboard/find-branch-with-branch/branch-id/${branch_id}/API-activation') }}`,
                    dataType: "json",
                    data: {
                        izzy:izzy
                    },
                        success: function (data) {
                        let arrpush = new Array();

                        for (let index = 0; index < data.length; index++) {
                            arrpush.push(data[index])
                            
                        }

                        let fetch_json = arrpush[0]['check_is'];
                        const data_izzy = fetch_json.replace("api_izzy","Izzy Transports");
                        const data_accurate = fetch_json.replace("api_accurate","Accurate Accounting System");
                        const toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    showConfirmButton: false,
                                    timer: 6000
                            });

                            if(data_izzy == "Izzy Transports"){
                                toast({

                                      title: `<div><i class="fa fa-circle text-success"></i></div>&nbsp;Anda terhubung dengan API ${data_izzy} !`

                                })  

                            } 
                                else if(data_accurate == "Accurate Accounting System"){

                                    toast({

                                          title: `<div><i class="fa fa-circle text-success"></i></div>&nbsp;Anda terhubung dengan API ${data_accurate} !`


                                    })

                            }

                            setTimeout(() => {

                                let isAdmin = "{{ $auths }}"; //assignwithroles

                                        if (isAdmin == '3PL[ACCOUNTING][TC]') {
                                        let loadUrl = 'http://devyour-api.co.id/transport-order-accounting';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }
                                            
                                        } 
                                        
                                        if (isAdmin == '3PL[OPRASONAL][TC]') {
                                            let loadUrl = 'http://devyour-api.co.id/transport-list';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }

                                        }

                                        if (isAdmin == '3PL[OPRASONAL][WHS]') {
                                            let loadUrl = 'http://devyour-api.co.id/transport-list';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }

                                        }

                            me = window.self;
                            me.location.reload();
                                     
                        }, 3100);

                    },
                        error: function(data){
                            toast({

                                title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Unknown API error!`

                        })

                    }

                });

            }

                else if($(this).prop("checked") == false){
                    let accurate = [];

                    accurate.push($(this).val());

                        $.ajax({
                            type: "get",
                            url: `{{ url('/dashboard/find-branch-with-branch/branch-id/${branch_id}/API-unactive') }}`,
                            dataType: "json",
                            data: {
                                accurate:accurate,
                            },

                                success: function (datax) {

                                    let fetch_uncheckjson = datax['check_is'];
                                    const datauncheck = fetch_uncheckjson.replace("api_izzy","Izzy Transports");
                                    const data_accurate = fetch_uncheckjson.replace("api_accurate","Accurate Accounting System");

                                    const toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    showConfirmButton: false,
                                    timer: 6000
                                });

                                if(datauncheck == "Izzy Transports"){

                                    toast({

                                        title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Anda telah terputus dengan koneksi ${datauncheck} !`


                                    })  

                                } 
                                    else if(data_accurate == "Accurate Accounting System")
                                    
                                        {

                                            toast({

                                            title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Anda telah terputus dengan koneksi ${data_accurate} !`



                                            })

                                        }
                            
                                    setTimeout(() => {

                                            let isAdmin = "{{ $auths }}"; //assignwithroles

                                            if (isAdmin == '3PL[ACCOUNTING][TC]') {
                                                let loadUrl = 'http://devyour-api.co.id/transport-order-accounting';
                                                // console.log('ACCOUNTING')
                                                window.location.reload();
                                                let hWndA = window.open(loadUrl),
                                                Me = window.self;
                                                Me.onunload = function()
                                                { 
                                                    hWndA.location.reload(); 
                                                }
                                            
                                            } 
                                        
                                        if (isAdmin == '3PL[OPRASONAL][TC]') {
                                            let loadUrl = 'http://devyour-api.co.id/transport-list';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }

                                        }

                                        if (isAdmin == '3PL[OPRASONAL][WHS]') {
                                            let loadUrl = 'http://devyour-api.co.id/transport-list';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }

                                        }

                                    me = window.self;
                                    me.location.reload();

                                }, 3100);

                            },
                                error: function(data){

                                    toast({

                                        title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Unknown API error!`

                            })

                        }

                    });

                }

            });

        });

   </script>
@endsection

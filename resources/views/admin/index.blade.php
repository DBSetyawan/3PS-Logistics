@inject('Contracts','warehouse\Http\Controllers\Services\Apiopentransactioninterface')
@php
    $roles_branch = isset($choosen_user_with_branch) ? $choosen_user_with_branch : null;
    $rebranch = $Contracts->getBranchIdWithdynamicChoosenBrach($roles_branch);
@endphp
@extends('admin.layouts.master', array('some'=>$roles_branch))
@section('title','Dashboard')
@section('head')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
{{-- <link href="{{ asset('css/empty-val/emptys.css') }}" rel="stylesheet" /> --}}
<link href="{{ asset('css/hunterPopup.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/like-yt.css') }}" />
<link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
<link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
<link rel="stylesheet" href="{{ asset('js/wdtLoading.css') }}" />
<link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
{{-- <link rel="stylesheet" href="{{ asset('css/sweet-alert2/sweet-alert2.min.css') }}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<link rel="stylesheet" href="{{ asset('css/allowed-all-css/all-alias-css.css') }}">
<link href="{{ asset('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Quicksand" />
<link href="{{ asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" rel="stylesheet" type="text/css" media="screen"/>
{{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}

<link href="https://pdfmatrix.com/theme/js/prism/prism.css" rel="stylesheet">
<style>
.empty-state {
    width: 96%;
    position: relative;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 2px dashed #eee;
    text-align: center;
    padding: 10px 20px;
    position: relative;
    margin: 10px 0
}
</style>
@notifyCss
@endsection
@section('brand')
<a class="brand" href="{{url('home_admin')}}">
    <img src="../img/logo.png" alt="Metro Lab" />
</a>
@endsection
@section('breadcrumb')
 <li>
    <a href="/dashboard"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>Branch, scope place :
    <strong class="cabang">{{ isset($rebranch->branch) ? $rebranch->branch : "Not found branch, (404)" }}</strong>
    <span class="divider">/</span>
</li> 
<li>Privacy, access point :
    @if(!$rolesv1)
    @foreach (Auth::User()->roles as $role_users)
        <a href="#"> [ <strong class="roles">{{$role_users->name}}</strong> ]</a>
    @endforeach
        @else
        @foreach ($rolesv1 as $role_users)
            <a href="#"> [ <strong class="roles">{{$role_users}}</strong> ]</a>
        @endforeach
    @endif
        <span class="divider">/</span>
    </li> 
<li class="active">
    @if(Auth::User()->email_verified_at)
        {{ __('Login as:') }} <strong>{{Auth::user()->name}} - <span class="badge badge-success">verified</span></strong> <span class="badge badge-important">Accurate</span> Expired in : {{ isset(session()->all()['AccountAccurate']) ? session()->all()['AccountAccurate'][0]['accessibleUntil'] : "-" }}, DB connected for access: {{ isset(session()->all()['AccountAccurate']) ? session()->all()['AccountAccurate'][1]['alias']  : "-" }} & {{ isset(session()->all()['AccountAccurate']) ? session()->all()['AccountAccurate'][0]['alias'] : "-"  }}
        @else
            {{ __('Login as:') }} <strong>{{Auth::user()->name}} - <span class="badge badge-danger">un-verified</span></strong>
    @endif
</li>
@endsection
@section('content')
@include('flash::message')
{{-- {{ dd() }} --}}

@php $ses__ = session()->get('id'); @endphp
@if($ses__ == null)
@else
{{-- @include('cookieConsent::index') --}}
@endif

    @if(session('AccountAccurate') == null && session()->get('id'))
        @include('API_integration.moduleAccurateCloud')
    @else
    
    @endif
    {{-- {{ dd(session()->all()) }} --}}
@inject('branchs', 'warehouse\Models\company_branchs')
@php $cabang = $branchs->whereIn('company_id',[])->first(); $rollback = $cabang['branch']; @endphp
{{-- {{ isset($choosen_user_with_branch) ? $choosen_user_with_branch : null; }} --}}
<div id="main-content">
    {{-- <div id="progress" class="waiting">
        <dt></dt>
        <dd></dd>
    </div> --}}
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
       <!-- BEGIN PAGE HEADER-->
       <div class="row-fluid">
          <div class="span12">
              <!-- BEGIN THEME CUSTOMIZER-->
              {{--  <div id="theme-change" class="hidden-phone">
                  <i class="icon-cogs"></i>
                   <span class="settings">
                       <span class="text">Theme Color:</span>
                       <span class="colors">
                           <span class="color-default" data-style="default"></span>
                           <span class="color-green" data-style="green"></span>
                           <span class="color-gray" data-style="gray"></span>
                           <span class="color-purple" data-style="purple"></span>
                           <span class="color-red" data-style="red"></span>
                       </span>
                   </span>
              </div>  --}}
              <!-- END THEME CUSTOMIZER-->
             <!-- BEGIN PAGE TITLE & BREADCRUMB-->
              <h3 class="page-title">
                   @yield('title')
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>

              <div id="ht-preloader" style="display: none;">
                <div class="loader clear-loader">
                    <div class="loader-inner">
                        <svg viewBox="0 0 80 80">
                            <rect x="8" y="8" width="64" height="64"></rect>
                        </svg>
                    </div>
                </div>
            </div>

                <div class="flash-message">
                {{-- @if(Session::has('alert-success'))
                    <p class="alert alert-success">{{ Session::get('alert-success')  }}</p>
                @endif
                  @if(Session::has('alert-danger'))
                    <p class="alert alert-danger">{{ Session::get('alert-danger')  }}</p>
                @endif
                @if(\Session::has('redirect_url_not_found'))
                {{ dd(Session::get('redirect_url_not_found')) }}
                    <p class="alert alert-danger">{{ Session::get('redirect_url_not_found')  }}</p>
                @endif
                @if(session('TokenExpiredEventAccessAccurate'))
                    <p class="alert alert-danger">{{ Session::get('TokenExpiredEventAccessAccurate')  }}</p>
                @endif
                @if(session('oauth_verify'))
                    <p class="alert alert-warning">{!! __("Accurate :") !!} {{ Session::get('oauth_verify')  }} {!! __("has been actived") !!}</p>
                @endif
                @if(Session::has('alert-oauth-access-denied'))
                    <p class="alert alert-danger">{!! __("OAUTH-forbidden :") !!} {{ Session::get('alert-oauth-access-denied')  }}</p>
                @endif
                @if(session('alert-invalid-parameter'))
                    <p class="alert alert-danger">{!! __("OAUTH-InvalidArgumentException :") !!} {{ Session::get('alert-invalid-parameter')  }}</p>
                @endif
                @if(session('alert-success-db-accurate-index'))
                    <p class="alert alert-success">{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-success-db-accurate-index')  }} {!! __("Available now") !!}</p>
                @endif
                 @if(session('alert-db-access-denied'))
                    <p class="alert alert-danger">{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-db-access-denied')  }}</p>
                @endif
                @if(session('alert-oauth-sso-invalid_client'))
                    <p class="alert alert-danger">{!! __("OAUTH-Invalid Client Access :") !!} {{ Session::get('alert-oauth-sso-invalid_client')  }}</p>
                @endif
                @if(session('alert-oauth-sso-already-exists'))
                    <p class="alert alert-warning">{!! __("OAUTH-Already Exists Client Token Access :") !!} {{ Session::get('alert-oauth-sso-already-exists')  }}</p>
                @endif
                @if(session('alert-oauth-sso-expired-token'))
                    <p class="alert alert-danger">{!! __("OAUTH-Expired :") !!} {{ Session::get('alert-oauth-sso-expired-token')  }}</p>
                @endif
                @if(session('alert-db-access-not-allowed'))
                    <p class="alert alert-danger">{!! __("OAUTH-DB-NULL :") !!} {{ Session::get('alert-db-access-not-allowed')  }}</p>
                @endif --}}
                 {{-- @if(Session::has('alert-invalid-token'))
                    <p class="alert alert-danger">{{ Session::get('alert-invalid-token')  }}</p>
                @endif --}}

                @if(session('branchNotfound'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Branch not found(404)!</h4>
                    <p>{{ Session::get('branchNotfound')  }}</p>
                </div>
                @endif

                @if(Session::has('alert-success'))
                <div class="alert alert-block alert-success fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Berhasil!</h4>
                    <p>{{ Session::get('alert-success')  }}</p>
                </div>
                @endif
                @if(Session::has('alert-danger'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{{ Session::get('alert-danger')  }}</p>
                </div>
                @endif
                @if(Session::has('redirect_url_not_found'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p >{{ Session::get('redirect_url_not_found')  }}</p>
                </div>
                @endif
                @if(session('TokenExpiredEventAccessAccurate'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{{ Session::get('TokenExpiredEventAccessAccurate')  }}</p>
                </div>
                @endif
                @if(session('oauth_verify'))
                <div class="alert alert-block alert-warning fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>{!! __("Accurate :") !!} {{ Session::get('oauth_verify')  }} {!! __("has been actived") !!}</p>
                </div>
                @endif
                @if(session('alert-oauth-access-denied'))
                <div class="alert alert-block alert-warning fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>{!! __("Accurate :") !!} {{ Session::get('oauth_verify')  }} {!! __("has been actived") !!}</p>
                </div>
                @endif
                @if(session('alert-invalid-parameter'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{!! __("OAUTH-InvalidArgumentException :") !!} {{ Session::get('alert-invalid-parameter')  }}</p>
                </div>
                @endif
                @if(session('alert-success-db-accurate-index'))
                <div class="alert alert-block alert-success fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Berhasil!</h4>
                    <p>{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-success-db-accurate-index')  }} {!! __("Available now") !!}</p>
                </div>
                @endif
                 @if(session('alert-db-access-denied'))
                 <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-db-access-denied')  }}</p>
                </div>
                @endif
                @if(session('alert-oauth-sso-invalid_client'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{!! __("OAUTH-Invalid Client Access :") !!} {{ Session::get('alert-oauth-sso-invalid_client')  }}</p>
                </div>
                @endif
                @if(session('alert-oauth-sso-already-exists'))
                <div class="alert alert-block alert-warning fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>{!! __("OAUTH-Already Exists Client Token Access :") !!} {{ Session::get('alert-oauth-sso-already-exists')  }}</p>
                </div>
                @endif
                @if(session('alert-oauth-sso-expired-token'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{!! __("OAUTH-Expired :") !!} {{ Session::get('alert-oauth-sso-expired-token')  }}</p>
                </div>
                @endif
                @if(session('alert-db-access-not-allowed'))
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <h4 class="alert-heading">Gagal!</h4>
                    <p>{!! __("OAUTH-DB-NULL :") !!} {{ Session::get('alert-db-access-not-allowed')  }}</p>
                </div>
                @endif
               
              {{-- <div class="empty-state">
                  <img src="{{ asset('img/fc172f6.svg') }}" alt="" style=" object-fit: none;object-position: 100% 65%;object-position: 0 -20;">
                <div class="span8">This application is connected to each other as a transportation information management and is significantly integrated
             {{-- </div><pre id="json"> --}}
            {{-- </pre></div> --}} 
            
              <div class="wdt-loading-screen">
                <div class="wdt-loading-phrases">
                    <div class="wdt-loading-phrase-category" data-category="default">
                        <div class="wdt-loading-phrase">Fetching data...</div>
                    </div>
                    <div class="wdt-loading-phrase-category" data-category="fetching">
                        <div class="wdt-loading-phrase">Verify data...</div>
                    </div>
                    <div class="wdt-loading-phrase-category" data-category="pleasewait">
                        <div class="wdt-loading-phrase">Opening application...</div>
                    </div> 
                </div>
            </div>    

            {{-- <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN TRACKING CURVES PORTLET-->
                    <div class="widget purple">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Tracking Chart</h4>
                        <span class="tools">
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div id="chart-1" class="chart"></div>
                        </div>
                    </div>
                    <!-- END TRACKING CURVES PORTLET-->
                </div>
                </div>
                
            </div> --}}
               
              {{-- @if ($roles_branch == null)
             
                <div>Grafing </div>
                  
              @else 
              <div class="span5">
                    <canvas id="myChart" width="400" height="400"></canvas>
                  </div>
              @endif --}}
              <!-- END PAGE TITLE & BREADCRUMB-->
              {{-- {{ $d }} --}}

          </div>
       </div>
       {{-- {{ $time_settings['company_timezone'] }} --}}
    </div>
 </div>
</div>
@endsection
@section('javascript')
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}
{{-- <script src="https://unpkg.com/vue@2.6.10/dist/vue.js"></script> --}}
{{-- <script src="{{ asset('js/src-vue/layers-runner.js') }}"></script>
{{-- <script src=" {{ asset('js/sweet-alerts/sweet-alerts.min.js')}}"></script> --}}
@include('sweetalert::view')
@include('notify::messages')
@notifyJs
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
{{-- <script src="{{ asset('js/flot/jquery.flot.js')}}"></script> --}}
{{-- <script src="{{ asset('js/flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('js/flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('js/flot/jquery.flot.stack.js')}}"></script>
<script src="{{ asset('js/flot/jquery.flot.crosshair.js')}}"></script> --}}
{{-- <script src="{{ asset('js/flot/flot-chart.js')}}"></script>
<script src="{{ asset('js/flot/custom-flot-chart.js')}}"></script> --}}
{{-- <script src="{{ asset('js/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script> --}}
<script src="{{ asset('js/common-scripts.js') }}"></script>
<script src="{{ asset('js/wdtLoading.js') }}"></script>
   {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script> --}}
   {{--  <script src="{{ asset('js/warehouse_t_list.js') }}"></script>  --}}
   <script src="https://pdfmatrix.com/theme/js/prism/prism.js"></script>
   {{-- https://www.chartjs.org/ https://www.chartjs.org/samples/latest/ --}}
   {{-- <script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script> --}}
   {{-- <script src="http://127.0.0.1:4200/socket.io/socket.io.js"></script> --}}
	
   <script language="javascript" type="text/javascript">

        // swal({
        //         //whatever you want
        // },
        // function() {
        //     $.ajax({
        //         type: "post",
        //         url: "url",
        //         data: "data",
        //         success: function(data) {}
        //     })
        //     .done(function(data) {
        //         swal("Deleted!", "Data successfully Deleted!", "success");
        //     })
        //     .error(function(data) {
        //         swal("Oops", "We couldn't connect to the server!", "error");
        //     });
        // }
        // );

    //  let user={
    //     name:"{{$name}}",
    //     username:"{{$username}}",
    // };

    // let auth=defineIsAuth(user,{
    //     texts:{
    //         placeholder:"Type Your Password",
    //         wrong:"Wrong Password",
    //         error:"Error",
    //         button:"Login"
    //     },
    //     loginField:"username"
    // });

    /**
     * Documentation bootbox.js
     * http://bootboxjs.com/documentation.html
    */
    // bootbox.alert("welcome user...");
    // bootbox.alert({
    // size: "small",
    // title: "Your Title",
    // message: "Your message here…",
    // callback: function(){ /* your callback code */ }
    $(window).resize();
// })
$('.plots').css('width','100%');

   var code = { 
     
                "username": "davids@programmer.net",
                "password": "123456",
                "TrialEnd": "30 days",
            }

    // document.getElementById("json").innerHTML = JSON.stringify(code, undefined, 2[0]);

    // ScrollReveal({ reset: true });
    // ScrollReveal().reveal(target, options);
//     var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [   
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });

   
   </script>
@endsection 
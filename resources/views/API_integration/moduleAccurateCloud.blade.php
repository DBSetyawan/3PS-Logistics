@extends('admin.layouts.master')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
<style>
.empty-state {
    width: 93%;
    position: relative;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 2px dashed #eee;
    text-align: center;
    padding: 15px 20px;
    position: relative;
    margin: 10px 19px
}
</style>
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
    <a href="#">Integration</a>
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
<div id="main-content" style="overflow-y:auto;height: 200%;">
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
       <div class="flash-message">
           
            @if(Session::has('alert-success'))
            <div class="alert alert-block alert-success fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process success!</h4>
                <p>{{ Session::get('alert-success')  }}</p>
            </div>
            @endif
            @if(Session::has('alert-danger'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{{ Session::get('alert-danger')  }}</p>
            </div>
            @endif
            @if(Session::has('redirect_url_not_found'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p >{{ Session::get('redirect_url_not_found')  }}</p>
            </div>
            @endif
            @if(session('TokenExpiredEventAccessAccurate'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{{ Session::get('TokenExpiredEventAccessAccurate')  }}</p>
            </div>
            @endif
            @if(session('oauth_verify'))
            <div class="alert alert-block alert-warning fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Attention!</h4>
                <p>{!! __("Accurate :") !!} {{ Session::get('oauth_verify')  }} {!! __("session accurate has been active now.") !!}</p>
            </div>
            @endif
            @if(session('alert-oauth-access-denied'))
            <div class="alert alert-block alert-warning fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Attention!</h4>
                <p>{!! __("Accurate :") !!} {{ Session::get('oauth_verify')  }} {!! __("has been actived") !!}</p>
            </div>
            @endif
            @if(session('alert-invalid-parameter'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{!! __("OAUTH-InvalidArgumentException :") !!} {{ Session::get('alert-invalid-parameter')  }}</p>
            </div>
            @endif
            @if(session('alert-success-db-accurate-index'))
            <div class="alert alert-block alert-success fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process success!</h4>
                <p>{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-success-db-accurate-index')  }} {!! __("Available now") !!}</p>
            </div>
            @endif
             @if(session('alert-db-access-denied'))
             <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{!! __("ACCURATE-DB-Access :") !!} {{ Session::get('alert-db-access-denied')  }}</p>
            </div>
            @endif
            @if(session('alert-oauth-sso-invalid_client'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{!! __("OAUTH-Invalid Client Access :") !!} {{ Session::get('alert-oauth-sso-invalid_client')  }}</p>
            </div>
            @endif
            @if(session('alert-oauth-sso-already-exists'))
            <div class="alert alert-block alert-warning fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Attention!</h4>
                <p>{!! __("OAUTH-Already Exists Client Token Access :") !!} {{ Session::get('alert-oauth-sso-already-exists')  }}</p>
            </div>
            @endif
            @if(session('alert-oauth-sso-expired-token'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{!! __("OAUTH-Expired :") !!} {{ Session::get('alert-oauth-sso-expired-token')  }}</p>
            </div>
            @endif
            @if(session('alert-db-access-not-allowed'))
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4 class="alert-heading">Process failed!</h4>
                <p>{!! __("OAUTH-DB-NULL :") !!} {{ Session::get('alert-db-access-not-allowed')  }}</p>
            </div>
            @endif

        <div class="empty-state">
            @if(!empty(Auth::User()->date_die_at))
                <span>User account <p style="font-size: larger;font-family: Quicksand">[ {{ Auth::User()->name }} ]</p> sudah terhubung dengan accurate & sudah terverifikasi oleh <span class="badge btn-primary">OAUTH VERIFY</span><br/> silahkan verifikasi access untuk add/update data pada kredential accurate online.</span><br/>
                {{-- <span>[*] jika sudah memverifikasi aplikasi accurate & OV abaikan pesan diatas.</span><br/> --}}
        </div>
        &nbsp;
            @else
            <div class="span5">
                This application is connected to oauth-verify for access token to access api accurate, your first create account in : <br/><a href="https://your-third-party/" target="_blank">Authentication Verify Account Using accurate.</a>
            </div>  
            &nbsp;
                <form action="/authorization/token" method="post">
                        @csrf
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Key :</label>
                                    <div class="controls">
                                        <input type="text" id="client_id" name="client_id" class="span12 " />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Client Secret</label>
                                    <div class="controls">
                                        <input type="text" name="client_sc" class="span12 " />
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row-fluid">
                                <div class="row-fluid">
                                    <div class="span12" style="text-align:center;">
                                        <button type="submit" class="btn btn-info">Authorized</button>
                                </div>
                            </div>
                        </form>
                    @endif
                @if(!session('AccountAccurate'))
                    <form action="/authorization/accurate-db-list" method="get">
                        @csrf
                        <div class="row-fluid">
                            <div class="row-fluid">
                                <div class="span12" style="text-align:justify;">
                                @if(Auth::User()->oauth_accurate_token && Auth::User()->oauth_token_third_party && session()->get('id'))
                                        <button type="submit" class="badge badge-default btn-danger">Unactive, activation your account accurate online now</button>
                                    @else
                                    <p>
                                        Berikan akses untuk user ini terlebih dahulu.
                                    </p>
                                    {{-- <button type="submit" class="badge badge-default btn-success popovers" data-trigger="hover" data-content="Jika pertama masuk kedalam aplikasi 3PS, aktifkan semua session untuk melakukan Transaksi/berpindah cabang." data-original-title="Informasi User">Activation application</button> --}}
                                @endif
                            </div>
                        </div>
                </form>
                @else
                    <p>Your account is active.</p>
                @endif
            </div>
            <div class="widget blue">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i>Your Credentials accurate online</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
                <div class="widget-body">
                    <form action="/authorization/accurate-account" method="post" style="text-align:justify;">
                        @csrf
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Client ID</label>
                                    <div class="controls">
                                        <input type="text" name="accurate_client_id" class="span12 " />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">REPONSE TYPE</label>
                                    <div class="controls">
                                        <input type="input" name="response_type" class="span12 "/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">REDIRECT URL</label>
                                        <div class="controls">
                                            <input type="input" name="redirect_uri" class="span12" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Scope</label>
                                            <div class="controls">
                                                <input type="text" name="scope" id="scope" class="span12 " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @if(!session()->get('id') && !session()->get('AccountAccurate') || ! Auth::User()->oauth_accurate_token && ! Auth::User()->oauth_token_third_party)
                            <p>
                                Berikan akses untuk user ini terlebih dahulu.
                            </p>
                        @else
                            <div class="row-fluid">
                                <div class="row-fluid">
                                    <div class="span12" >
                                        <button type="submit" class="btn btn-success">Verify API Key Accurate</button>
                                        {{-- <button id="authorized" class="btn btn-info">Authorized</button> --}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>  
            </div>
 </div>
 </div>
 </div>
 </div>
</div>
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

   <script async type="text/javascript">
  
   </script>
@endsection

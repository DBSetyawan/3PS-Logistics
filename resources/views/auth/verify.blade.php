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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
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
    <a href="#">System new user</a>
    <span class="divider">/</span>
</li>
<li class="active">
    hello, {{ Auth::User()->name }}
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Privacy, access point : [ <strong>{{ __('Please Verify your account to be actived your access') }}</strong> ]</a>
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
                {{ Auth::User()->name }}
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>
              <!-- END PAGE TITLE & BREADCRUMB-->
          </div>
       </div>
     <div id="progress" class="waiting">
        <dt></dt>
        <dd></dd>
    </div>
        @if (session('resent'))
        <div class="alert alert-success">
            {{ _('A fresh verification link has been sent to your email address.') }}
        </div>
        
        {{-- {{ __('before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }} --}}

        @endif

        @if (session('success-verify'))
        <div class="alert alert-success">
            {{ _('New account verification has been successful..') }}
        </div>

        @endif
        @if (Auth::User()->parent_id == 1)
            <a href="{{ route('verification.resend') }}"><div class="btn btn-large btn-group-lg btn-primary">{{ __('You must verify your email so that it can still be used as a user in this application. By [ DEVELOPER ]') }}</div></a>. 
        @else
            <a href="{{ route('verification.resend') }}"><div class="btn btn-large btn-group-lg btn-primary">{{ __('You must verify your email so that it can still be used as a user in this application. By [ SUPER USER ]') }}</div></a>. 
        @endif
    </div>
@endsection

@section('javascript')
 <!-- BEGIN JAVASCRIPTS -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
 @include('sweetalert::view')
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<!-- ie8 fixes -->   
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/common-scripts.js') }}"></script>
   <!-- END JAVASCRIPTS -->
<script type="text/javascript">
   
</script>
@endsection

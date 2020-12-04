<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="{{ Config::get('app.locale') }}" class="sr"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{ $menu }} - {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
    {{-- https://github.com/HubSpot/offline --}}
    <link rel="stylesheet" href="{{ asset('css/sweet-alert2/sweet-alert2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-chrome.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-chrome-indicator.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-default-indicator.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-language-english.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/spinnercustom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/loadingrequest.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/editorcss.css') }}" />
    <link href="{{ asset('css/alwtop.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/load-awesome.css') }}" />
    {{--  <link rel="stylesheet" href="{{ asset('css/bots2019.css') }}" />  --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-language-english-indicator.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-default.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-hubspot.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-slide.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/themes_offline/offline-theme-slide-indicator.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet"> --}}
</head>
<style>

.emptys-state {
    width: 93%;
    position: relative;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 2px dashed LINEN;
    text-align: center;
    padding: 10px 20px;
    margin: 10px 0
}
html.sr .roles .cabang {
    visibility: hidden;
}

html.sr .sub-menu {
  visibility: hidden;
}
</style>
{{-- setting set session for global scope or use macro::GlobalMethod [OPTIONAL] --}}
@php 
    
    if(Auth::User()->email_verified_at == null)
        {
            # ===========================================================================================
            # reules = false;
            # ===========================================================================================
            # ==>>> logic ini untuk mendeteksi apakah usernya baru ? apakah user ini sudah diverifikasi atau belum ?
            /*
            * session memiliki pengaruh disemua load master ataupun transaksi
            */

            $order_id = session()->get('order_id') ?? session()->get('order_id') ?? null;
            $item_id_customer = session()->get('item_id_customer') ?? session()->get('item_id_customer') ?? null;
            $id_vehicle = session()->get('id_vehicle') ?? session()->get('id_vehicle') ?? null;
            $id_address_book = session()->get('id_address_book') ?? session()->get('id_address_book') ?? null;
            $id_master_customer = session()->get('id_master_customer') ?? session()->get('id_master_customer') ?? null;
            $redirects_to_whs = session()->get('redirects_to_whs') ?? session()->get('redirects_to_whs') ?? null;
            $id_master_vendor = session()->get('id_master_vendor') ?? session()->get('id_master_vendor') ?? null;
            $item_vendor_id = session()->get('idx_item_vendor') ?? session()->get('idx_item_vendor') ?? null;
            $detail_data_item_V = session()->get('detail_data_item_V') ?? session()->get('detail_data_item_V') ?? null;
            $mastersubserviceid = session()->get('mastersubserviceid') ?? session()->get('mastersubserviceid') ?? null;
            $shipmentcategoriesid = session()->get('shipmentcategoriesid') ?? session()->get('shipmentcategoriesid') ?? null;
            $modaid = session()->get('modaid') ?? session()->get('modaid') ?? null;
            $usersid = session()->get('usersid') ?? session()->get('usersid') ?? null;
            $indexorderid = session()->get('indexorderid') ?? session()->get('indexorderid') ?? null;
            $data_xml = session()->get('data_xml') ?? session()->get('data_xml') ?? null;
            $stored_id_jobs = session()->get('stored_id_jobs') ?? session()->get('stored_id_jobs') ?? null;
            $id_transport = session()->get('id_transport') ?? session()->get('id_transport') ?? null;
            $item_warehouse_id = session()->get('item_warehouse_id') ?? session()->get('item_warehouse_id') ?? null;
        } 
            else
                    {
                        # ===========================================================================================
                        # reules = true;
                        # ===========================================================================================
                        # ==>>>jika user sudah memilih cabang fitur akan diaktifkan, diteruskan dengan sessionnya etc...
                        /*
                        * session memiliki pengaruh disemua load master ataupun transaksi
                        */

                        $order_id = session()->get('order_id') ?? session()->get('order_id') ?? null;
                        $item_id_customer = session()->get('item_id_customer') ?? session()->get('item_id_customer') ?? null;
                        $id_vehicle = session()->get('id_vehicle') ?? session()->get('id_vehicle') ?? null;
                        $id_address_book = session()->get('id_address_book') ?? session()->get('id_address_book') ?? null;
                        $id_master_customer = session()->get('id_master_customer') ?? session()->get('id_master_customer') ?? null;
                        $redirects_to_whs = session()->get('redirects_to_whs') ?? session()->get('redirects_to_whs') ?? null;
                        $id_master_vendor = session()->get('id_master_vendor') ?? session()->get('id_master_vendor') ?? null;
                        $item_vendor_id = session()->get('idx_item_vendor') ?? session()->get('idx_item_vendor') ?? null;
                        $detail_data_item_V = session()->get('detail_data_item_V') ?? session()->get('detail_data_item_V') ?? null;
                        $mastersubserviceid = session()->get('mastersubserviceid') ?? session()->get('mastersubserviceid') ?? null;
                        $shipmentcategoriesid = session()->get('shipmentcategoriesid') ?? session()->get('shipmentcategoriesid') ?? null;
                        $modaid = session()->get('modaid') ?? session()->get('modaid') ?? null;
                        $usersid = session()->get('usersid') ?? session()->get('usersid') ?? null;
                        $indexorderid = session()->get('indexorderid') ?? session()->get('indexorderid') ?? null;
                        $data_xml = session()->get('data_xml') ?? session()->get('data_xml') ?? null;
                        $stored_id_jobs = session()->get('stored_id_jobs') ?? session()->get('stored_id_jobs') ?? null;
                        $id_transport = session()->get('id_transport') ?? session()->get('id_transport') ?? null;
                        $item_warehouse_id = session()->get('item_warehouse_id') ?? session()->get('item_warehouse_id') ?? null;

                    }


@endphp
{{-- <div id="atlwdg-trigger" class="atlwdg-trigger atlwdg-TOP">
    <div class="badge badge-secondary" style="color:cyan">BUG FIX SYSTEM</div><p style="font-style: italic">&nbsp; Perbaikan add item customer/vendor.</p>
</div> --}}
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    {{-- <body @if(session()->exists('id') == true) ? onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="" : @endif  class="fixed-top"> --}}
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner" id="master-blade-page">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               <!-- BEGIN LOGO -->

               {{--  @yield('brand')  --}}


               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
              
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                       <!-- BEGIN SUPPORT -->
                       {{-- <li class="dropdown mtop5">
                           <a class="dropdown-toggle element" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Help">
                               <i class="icon-headphones"></i>
                           </a>
                       </li> --}}
                       <!-- END SUPPORT -->
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a style="cursor: pointer" class="dropdown-toggle" data-toggle="dropdown">
                               {{-- <img src="img/avatar1_small.jpg" alt=""> --}}
                               @if (Auth::guest())
                                    <p>User tidak diketahui</p>
                               @else

                               @php
                               $ap = array();
                                    // ini untuk memberikan semua roles tanpa ada batasan akses    
                                     foreach (Spatie\Permission\Models\Role::all() as $value => $data) {
                                            # code...
                                        $ap[$value] = $data;
                                    }
                                @endphp
                               {{-- @if (!empty($prefix->branch)) --}}
                                {{-- @if($reules == "super_users") --}}
                                {{-- @hasanyrole($roles) --}}
                                {{-- @role($roles) --}}
                                @hasanyrole($ap)

                                        <span class="username"><label style="color: linen;font-family: Quicksand">{{__('User :')}} {{ Auth::User()->email }} - {{ Auth::User()->name }}</label></span>
                                 
                                @endhasanyrole
                                {{-- @can('developer')
   
                                    <span class="username"><label style="color: linen;font-family: Quicksand">{{__('Developer :')}} {{ Auth::User()->email }} - {{ Auth::User()->name }}</label></span>
                               
                                @endcan --}}
                                {{-- check user after registration --}}
                                {{-- @if($reules == null)
                                    <span class="username"><label style="color: linen;font-family: Quicksand">{{__('this scope are developer:')}} {{ Auth::User()->email }} - {{ Auth::User()->name }}</label></span>

                                @endif --}}
                                {{-- @endhasanyrole --}}
                                {{-- @endif --}}
                                  {{-- @else
                                  <span class="username"><label style="color: linen;font-family: Quicksand">{{ Auth::User()->name }}</label></span>

                                @endif --}}
                                {{-- {{e($loop)}} --}}
                                        {{-- <span class="username"><label style="color: linen;font-family: Quicksand"> - {{ Auth::user()->name}}</label></span>

                                    @else
                                    
                                        <span class="username"><label style="color: linen;font-family: Quicksand">  {{ $prefix->branch }} - {{ Auth::user()->name}}</label></span>

                                  @endif --}}
                                    {{-- @else --}}
                               {{-- @endif --}}
                                {{-- @foreach (Auth::User()->roles as $role_users)
                                    @if ($role_users->name == "3PL") --}}
                                        {{-- @else
                                    @endif --}}
                                    {{-- @if ($role_users->name == "3PE") --}}
                                        {{-- <span class="username"><label style="color: limegreen;font-family: Quicksand">{{ $prefix->branch }} - {{ Auth::user()->name}}</label></span> --}}
                                    {{-- @else
                                    @endif --}}
                                    {{-- @if ($role_users->name == "administrator") --}}
                                        {{-- <span class="username"><label style="color: linen;font-family: Quicksand">{{ $prefix->branch }} - {{ Auth::user()->name}}</label></span> --}}
                                    {{-- @else
                                    @endif
                                @endforeach --}}
                            @endif
                           </a>
                           <ul class="dropdown-menu extended logout">
                               <li><a href="#"><i class="fa fa-circle text-success"></i> Online</a></li>
                             
                               {{-- <li><a href="#">Action</a></li>
                               <li><a href="#">Another action</a></li>
                               <li><a href="#">Something else here</a></li>
                               <li class="divider"></li>
                               <li class="nav-header">Nav header</li>
                               <li><a href="#">Separated link</a></li>
                               <li><a href="#">One more separated link</a></li> --}}
                               {{-- <li><a href="#"><i class="icon-user"></i> My Profile</a></li> --}}
                               {{-- <li><a href="#"><i class="icon-cog"></i> My Settings</a></li> --}}
                               <li> <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                onclick="return logout(event);"><i class="fas fa-power-off"></i>
                                {{--  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i>  --}}
                            Sign Out</a></li>
                            <form id="logout-form" action="{{ url('/auth/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                                </li>
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
               @inject('query', 'Illuminate\Database\Eloquent\Builder')
               @inject('companies', 'warehouse\Models\Companies')
               @inject('users', 'warehouse\User')
               @inject('izin', 'warehouse\Models\Roles')
               @inject('branchs', 'warehouse\Models\company_branchs')

               @php
                $roles = $izin->get();
                foreach ($roles as $key => $jalur) {
                    # code...
                    $access[] = $jalur->name; 
                }
                //  $cek_company_by_owner = warehouse\Models\Companies::where('owner_id', Auth::User()->id )->get();
                 $cek_company_by_owner = $companies->where('owner_id', Auth::User()->id )->get();

                    if ($cek_company_by_owner->isEmpty()) {
                        # code...
                        $cek_super_user_by_owner = 'undefined';
                    } else {
                        $cek_super_user_by_owner = 'available';

                    }   

                    $fetch_users =$companies->whereIn('owner_id',[Auth::User()->id])->get();
                    $fetch_response = $users->with(['company','company_branchs'])->where('id','=',Auth::User()->id)->first();

                    foreach($fetch_users as $comp){
                        $company_id[] = $comp->id;
                    }

                    // this if company null as default by developer
                    $data_company_developer = isset($company_id) ? $company_id : null;
                    // this method to check the user whether has been assigned a role by the company branch after / before the user registered at the trial
                    $data_company = isset($fetch_response->company->name) ? $fetch_response->company->name : null;
                    $data_company_id = isset($fetch_response->company->id) ? $fetch_response->company->id : null;
                    $data_branch = isset($fetch_response->company_branchs->branch) ? $fetch_response->company_branchs->branch : null;
                    $data_branch_id = isset($fetch_response->company_branchs->id) ? $fetch_response->company_branchs->id : null;

                    $testing_query = $branchs->with('company')->where(function ($query) use($data_company_developer) {
                                        return $query->whereIn('company_id', [$data_company_developer]);
                                    })->get();

               @endphp
               {{-- optional jika super user belum setting rolenya bisa di hide menu choose company/branch --}}
                    @role($access)
                    @if ($data_branch_id ==null)
                        {{-- check the user has set a branch or not  --}}
                        @hasanyrole($access){{-- TODO: INITIALIZE ROLE AFTER REGISTER ADD HERE --}}
                        <div style="position: relative;display: flex;justify-content: left;align-items: center;" class="top-nav">
                                <ul class="nav pull-left top-menu">
                                    <!-- BEGIN SUPPORT -->
                                    <div class="row-fluid">
                                        <div class="span6">
                                    <div class="control-group">
                                            <div class="controls">
                                                <select class="dtcompanychoosen input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="companychoose" name="companychoose">
                                                    {{-- @if($fetch_users == null)

                                                        @else
                                                        @foreach($fetch_users as $data_fetch)
                                                            <option value="{{$data_fetch->id}}" selected="{{$data_fetch->name}}">{{$data_fetch->name}}</option> 
                                                        @endforeach
                                                    @endif --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="span1">
                                <div class="control-group">
                                        <div class="controls">
                                            <select class="dtbranchchoosen input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="branchchoose" name="branchchoose">
                                                {{-- @if($fetch_branchs == null)

                                                @else
                                                @foreach($fetch_branchs as $data_branch)
                                                    <option value="{{$data_branch->id}}" selected="{{$data_branch->branch}}">{{$data_branch->branch}}</option> 
                                                    @endforeach
                                            @endif --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    @endhasanyrole
                            @else
                                @if ($cek_super_user_by_owner == 'undefined')
                                {{-- this feature for child parent user of super users --}}
                                <div class="top-nav" style="position: relative;display: flex;justify-content: left;align-items: center;">
                                    <ul class="nav pull-left top-menu" >
                                        <!-- BEGIN SUPPORT -->
                                        <div class="row-fluid">
                                            <div class="span6">
                                        <div class="control-group">
                                                <div class="controls">
                                                    <select class="dtcompany input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="company_child" name="company_child">
                                                        {{-- @if($fetch_users == null)
        
                                                            @else
                                                            @foreach($fetch_users as $data_fetch)
                                                                <option value="{{$data_fetch->id}}" selected="{{$data_fetch->name}}">{{$data_fetch->name}}</option> 
                                                            @endforeach
                                                        @endif --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span1">
                                        <div class="control-group">
                                                <div class="controls">
                                                    <select class="dtbranchs input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="company_branchs_child" name="company_branchs_child">
                                                        {{-- @if($fetch_branchs == null)
        
                                                        @else
                                                        @foreach($fetch_branchs as $data_branch)
                                                            <option value="{{$data_branch->id}}" selected="{{$data_branch->branch}}">{{$data_branch->branch}}</option> 
                                                            @endforeach
                                                    @endif --}}
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END USER LOGIN DROPDOWN -->
                                    </ul>
                                    <!-- END TOP NAVIGATION MENU -->
                                </div>        
                                @else 
                                    <div style="position: relative;display: flex;justify-content: left;align-items: center;" class="top-nav">
                                        <ul class="nav pull-left top-menu" >
                                            <!-- BEGIN SUPPORT -->
                                            <div class="row-fluid">
                                                <div class="span6">
                                            <div class="control-group">
                                                    <div class="controls">
                                                        <select class="dtcompanychoosen input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="companychoose" name="companychoose">
                                                            {{-- @if($fetch_users == null)
    
                                                                @else
                                                                @foreach($fetch_users as $data_fetch)
                                                                    <option value="{{$data_fetch->id}}" selected="{{$data_fetch->name}}">{{$data_fetch->name}}</option> 
                                                                @endforeach
                                                            @endif --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="span1">
                                        <div class="control-group">
                                                <div class="controls">
                                                    <select class="dtbranchchoosen input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="branchchoose" name="branchchoose">
                                                        {{-- @if($fetch_branchs == null)

                                                        @else
                                                        @foreach($fetch_branchs as $data_branch)
                                                            <option value="{{$data_branch->id}}" selected="{{$data_branch->branch}}">{{$data_branch->branch}}</option> 
                                                            @endforeach
                                                    @endif --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        @endif
                    @endif
                @endrole
           </div>
       </div>
   </div>
   @php
   $data = [
      'mainTitle' => "404, page not found",
      'mainContent' => "sorry, but the requested page does not exist.."];
      $parsingTosidebar = $some;
      $Access = Auth::User()->roles;
    //   dd($Access);
@endphp
   <div id="container" class="row-fluid">
      <div class="sidebar-scroll">
        <div id="sidebar" class="nav-collapse collapse">
         <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
               <input type="text" class="search-query" placeholder="Search" />
            </form>
         </div>
            @include('admin.layouts.sidebar', array('cek_role_branch' => $parsingTosidebar))
      </div>
      </div>
        @yield('content')
   </div>
   <div id="footer">
       <label style="font-family: Quicksand">@ TIGA PERMATA SYSTEM</label>
   </div>
@yield('javascript')
<script src=" {{ asset('js/sweet-alerts/sweet-alerts.min.js')}}"></script>
@include('sweetalert::view')
<script src=" {{ asset('js/adminlte/adminlte.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script src="{{ asset('js/offline/offline.min.js') }}"></script>
<script src="{{ asset('js/select2-4-0-5.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/offline/offline.js') }}"></script>
<script src="{{ asset('js/pusher.js') }}"></script>
<script src="{{ asset('js/several/several.js') }}"></script>
<script src="{{ asset('js/obfuscator.js') }}"></script>
<script src="{{ asset('js/input-mask/inputmasks.js') }}"></script>
<script src="{{ asset('assets/bootbox/botbox.js') }}"></script>
<script async type="text/javascript" language="javascript">

function isEmptyObject(obj){
    return JSON.stringify(obj) === '{}';
}

function logout(event){
    event.preventDefault();
        bootbox.confirm("Apa anda yakin ingin keluar aplikasi?", function(event){
                if(event){ 
                    document.getElementById('logout-form').submit();
                }
        })
        
     }
// function loadScript(url) {

// return new Promise(function(resolve, reject) {

//   var script = document.createElement("script")
//   script.type = "text/javascript";

//   if (script.readyState) { //IE
//     script.onreadystatechange = function() {
//       if (script.readyState == "loaded" ||
//         script.readyState == "complete") {
//         script.onreadystatechange = null;
//         resolve();
//       }
//     };
//   } else { //Others
//     script.onload = function() {
//       resolve();
//     };
//   }

//   script.src = url;
//   document.getElementsByTagName("head")[0].appendChild(script);

// });
// }

// var resources = [
// "https://code.jquery.com/jquery-2.2.3.min.js",
// "https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"
// ]

// function loadAllResources() {
// return resources.reduce(function(prev, current) {

//   return prev.then(function() {
//     return loadScript(current);
//   });

// }, Promise.resolve());
// }

// loadAllResources().then(function() {
// $('#result').text('Everything loaded');
// $('#datepicker').datepicker();
// });

   $('#success').delay(10000).fadeOut('slow');
   $('#error').delay(10000).fadeOut('slow');
    // # ===================================================================================================
    // # fitur untuk pemilihan perusahaan dan cabang secara dinamis ^high priority [branch][roles][username]
    // # ===================================================================================================

   $( document ).ready(function() {
 
        $({property: 0}).animate({property: 110}, {
            duration: 5000,
            step: function() {
                var _percent = Math.round(this.property);
                $('#progress').css('width',  _percent+"%");
                if(_percent == 200) {
                    $("#progress").addClass("done");
                }
            },
            complete: function() {
                $("#progress").hide();
            }
        });
    });

    $(document).ready(()=>{ 
             
        let branch_id = "{{$some}}";
        var url = '{{ route("showit.find", ":id") }}';

        url = url.replace(':id', branch_id);
        $.get(url, function(data){
            $.each(data, function(index, Obj){
                    var $option_brnch = $("<option selected></option>").val(Obj.id).text(Obj.branch);
                    var $option_cmp = $("<option selected></option>").val(Obj.company.id).text(Obj.company.name);
                    // for parent
                    $('#companychoose').append($option_cmp).trigger('load');
                    $('#branchchoose').append($option_brnch).trigger('load');

                    // for child
                    $('#company_child').append($option_cmp).trigger('load');
                    $('#company_branchs_child').append($option_brnch).trigger('load');

                }   
            );
        });

        $('.dtcompanychoosen').select2({
            placeholder: 'Choose Company',
            "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
            url: '/load-company-for-super-user', 
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

           $('.dtcompany').select2({
            placeholder: 'Choose Company child',
            "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
            url: '/load-company-for-super-user', 
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

    /** 
    * Mixed roles opened super users
    */
    $('#companychoose').on('change', function(ex){
            const thisval = ex.target.value;

                    $('.dtbranchchoosen').select2({
                            placeholder: 'Choose Branch',
                            "language": {
                                    "noResults": function(){
                                        return "Maaf, Silahkan isikan role anda terlebih dahulu";
                                    }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            ajax: {
                            url: '/load-company-branch-with-super-user/find/'+`${thisval}`,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                        results:  $.map(data, function (item) {
                                            return {
                                                text: item.branch,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                            cache: true
                        }

                    }).on('change', function(es){
                        const branch = es.target.value;
                        let user = "{{Auth::User()->roles[0]->name}}";
                        let timerInterval
                            Swal.fire({
                            title: '<div class="row-fluid form-control-label" style="font-family: Quicksand;font-size:18px;">3PS Are looking for Authentication companies and branches in the system, please wait..</div>',
                            // text: 'Currently matching system data.',
                            imageUrl: '{{ asset("img/giphy.gif")}}',
                            imageWidth: 340,
                            background: 'none',
                            imageHeight: 90,
                            imageClass:"",
                            imageAlt: 'Processing',
                            // html:
                            // "<div style='color: #9787ea' class='la-ball-scale-pulse la-3x'><div></div><div></div><div></div><div></div></div>" +
                                // ""+
                            // JSON.stringify(user) +
                            // background: 'rgba(0,0,0,0) linear-gradient(#444,#111) repeat scroll 0 0',
                            // html: `<div class="vertical-center"><div class="w-100"><div class="w-100 d-flex justify-content-center ldlz" style="opacity: 1; visibility: visible;"><div class="rounded-lg m-4 ld ld-heartbeat" style="width:48px;height:48px;animation-delay:0s;background:#e15b64"></div><div class="rounded-lg m-4 ld ld-flip" style="width:48px;height:48px;animation-delay:.3s;background:#f8b26a"></div><div class="rounded-lg m-4 ld ld-metronome" style="width:48px;height:48px;animation-delay:.6s;background:#abbd81"></div></div></div></div>`,
                            // // html: '<strong>SYSTEM AUTHENTICATIONsdasdasdas</strong><br/> The system is processing your request'+'<br/>'+'&nbsp;<div class="lds-dual-ring"></div>',
                            timer: 12000,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer
                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://your-api.co.id/updated-api-setting-branch/find/${thisval}/find-branch/${branch}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    if(isEmptyObject(responseJsonData)){

                                                        window.location = "{{ route('dashboard') }}";
                                                        
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        var value = url.substring(url.lastIndexOf('/') + 1);
                                                        url = url.replace(value, responseJsonData)
                                                        

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "API-integration"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/API-integration')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "dashboard"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                                 let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                                 let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "history-job-shipments"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000); 

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')

                                                            let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-permissions"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-permissions")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-roles"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-roles")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-permissions"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-permissions")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                            
                                                        } 

                                                    }

                                                resolve();

                                            }, 5000);
                                        })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();
                             
                            }
                        })
                           
                    });

                }
            );

            ScrollReveal().reveal('.sub-menu', { interval: 425 });
            ScrollReveal().reveal('.cabang', { delay: 500 });
            ScrollReveal().reveal('.roles', { delay: 800 });
            ScrollReveal().reveal('.permission', { delay: 2000 });

            /**
             * Halaman utama user masuk. 
             **/
            $('.dtbranchchoosen').select2({
                    placeholder: 'Pilih Branch',
                    "language": {
                        "noResults": function(){
                            return "Maaf, Silahkan isikan role anda terlebih dahulu";
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.branch,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    cache: true
                }
            })

            $('.dtbranchs').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                                results:  $.map(data, function (item) {
                                    return {
                                        text: item.branch,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    cache: true
                }
            })
    
    $('#branchchoose').prop("disabled", false);
   
    /**
     * Halaman pertama kali user masuk.
     **/
    $('.dtcompanychoosen').select2({
        placeholder: 'Pilih Company',
        "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        // containerCssClass: "background-color: blue !important",
        ajax: {
        url: '/load-company-for-super-user',
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
           }).on('load', function(e){
            const company = e.target.value;
            $('#branchchoose').empty();
                $('.dtbranchchoosen').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                                    return markup;
                                },
                    ajax: {
                    url: '/load-company-branch-with-super-user/find/'+`${company}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                            return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.branch,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        cache: true
                    }
                }).on('change', function(es){
                        const thisval = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html:'<strong>super users</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5300,
                            showConfirmButton: false, 
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://your-api.co.id/updated-api-setting-branch/find/${company}/find-branch/${thisval}`);
                                            let responseJsonData = await response.json();
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    
                                                    if(isEmptyObject(responseJsonData)){

                                                        window.location = "{{ route('dashboard') }}";
                                                    
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        let urls = current_origin_url+current_pathname_url;

                                                        let value = url.substring(url.lastIndexOf('/') + 1);
                                                        let values = urls.substring(urls.lastIndexOf('/') + 1);

                                                        url = url.replace(value, responseJsonData)
                                                        urls = urls.replace(values, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "API-integration"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/API-integration')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "history-job-shipments"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "create-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "list-job-shipment"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-modsa')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-roles"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-roles")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-permissions"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-permissions")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                            
                                                        } 

                                                    }

                                                   resolve();

                                                }, 5000);
                                            })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();
                                
                            }
                        })

                    });

           });
           
        });    

        $(document).ready(()=>{ 
        // this child parent
        $('#company_child').on('change', function(ex){
            const thisval = ex.target.value;

                    $('.dtbranchs').select2({
                            placeholder: 'Choose Branch',
                            "language": {
                                    "noResults": function(){
                                        return "Maaf, Silahkan isikan role anda terlebih dahulu";
                                    }
                            },
                            escapeMarkup: function (markup) {
                                            return markup;
                                        },
                            ajax: {
                            url: '/load-company-branch-with-super-user/find/'+`${thisval}`,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                        results:  $.map(data, function (item) {
                                            return {
                                                text: item.branch,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                            cache: true
                        }

                    }).on('change', function(es){
                        const branch = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html: '<strong>SYSTEM AUTHENTICATION</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5200,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://your-api.co.id/updated-api-setting-branch/find/${thisval}/find-branch/${branch}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    if(isEmptyObject(responseJsonData)){

                                                        window.location = "{{ route('dashboard') }}";
                                                        
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        var value = url.substring(url.lastIndexOf('/') + 1);
                                                        url = url.replace(value, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "API-integration"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/API-integration')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "dashboard"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "history-job-shipments"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            url = url.replace(url, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000); 

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        

                                                        if(value == "detail-data-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-order-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-roles"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-roles")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-permissions"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-permissions")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
    
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                            
                                                        }
                                                        
                                                    }
                                                 
                                               resolve();

                                            }, 5000);
                                        })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                                SettingUp();

                            }
                        })

                    });

                }
            );

        // this load change branch for child parent
    
        $('.dtcompany').select2({
        placeholder: 'Choose Company',
        "language": {
                "noResults": function(){
                    return "Maaf, Silahkan isikan role anda terlebih dahulu";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        // containerCssClass: "background-color: blue !important",
        ajax: {
        url: '/load-company-for-super-user',
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
           }).on('load', function(e){
            const company = e.target.value;
            $('#company_branchs_child').empty();
                $('.dtbranchs').select2({
                    placeholder: 'Choose Branch',
                    "language": {
                            "noResults": function(){
                                return "Maaf, Silahkan isikan role anda terlebih dahulu";
                            }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },          
                    ajax: {
                    url: '/load-company-branch-with-super-user/find/'+`${company}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                            return {
                                    results:  $.map(data, function (item) {
                                        return {
                                            text: item.branch,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        cache: true
                    }
                }).on('change', function(es){
                        const thisval = es.target.value;

                        let timerInterval
                            Swal.fire({
                            html:'<strong>child of super users</strong><br/> The system is processing your request'+'<br/>'+'<div class="lds-dual-ring"></div>',
                            timer: 5300,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                let loading = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'default',
                                        speed: 3100
                                    })), 3500)
                                });

                                let fetching = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'fetching',
                                        speed: 4000
                                    })), 4900)
                                });

                                let pleasetwait = new Promise((resolve, reject) => {
                                    setTimeout(() => resolve(wdtLoading.start({
                                        category: 'pleasewait',
                                        speed: 4500
                                    })), 6600)
                                });
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {

                                if (

                                    result.dismiss === Swal.DismissReason.timer

                                ) 
                                
                                    {

                            async function SettingUp(){

                                try {

                                    let response = await fetch(`http://your-api.co.id/updated-api-setting-branch/find/${company}/find-branch/${thisval}`);
                                            let responseJsonData = await response.json();
                                            // console.log(responseJsonData, 'response');
                                            await new Promise((resolve, reject) => {
                                                setTimeout(() => {

                                                    
                                                    if(isEmptyObject(responseJsonData)){

                                                        window.location = "{{ route('dashboard') }}";
                                                    
                                                    } else {

                                                        let current_origin_url = window.location.origin;
                                                        let current_pathname_url = window.location.pathname;
                                                        let url = current_origin_url+current_pathname_url;
                                                        let urls = current_origin_url+current_pathname_url;

                                                        let value = url.substring(url.lastIndexOf('/') + 1);
                                                        let values = urls.substring(urls.lastIndexOf('/') + 1);

                                                        url = url.replace(value, responseJsonData)
                                                        urls = urls.replace(values, responseJsonData)

                                                        if(value == "list-master-item-accurate-cloud"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-item-accurate-cloud')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "API-integration"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/API-integration')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "detail-job-shipments"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment/'+"{{ $stored_id_jobs }}"+'/detail-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }
                                                        
                                                        if(value == "transport-list-daterange-accounting"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "update-detail-warehouse-item"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-service-item/"+"{{$item_warehouse_id}}"+"/update-detail-warehouse-item")
                                                                 let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "edit-order-transaction"){
                                                                
                                                                url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-transaction/"+"{{$id_transport}}"+"/edit-order-transaction")
                                                                 let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "history-job-shipments"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/history-job-shipments')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "list-job-shipment"){
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "create-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-order-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "verified-transaction"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/user-role-branch/"+responseJsonData+'/verified-transaction')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 
                                                        
                                                        if(value == "create-job-shipment"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-job-shipment')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "opened-detail-order-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/warehouse-data-detail/'+"{{ $order_id }}"+'/opened-detail-order-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        } 

                                                        if(value == "list-order-for-accounting"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-order-for-accounting-view-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-order-for-accounting-view-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-service-items-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-service-items-warehouse')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        
                                                        if(value == "update-item-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/detail-data-item-customer/'+"{{ $item_id_customer }}"+'/update-item-customer')

                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-item-transport-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-item-transport-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);

                                                        }

                                                        if(value == "list-master-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                            
                                                        }

                                                        if(value == "update-data-vehicle"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vehicle/"+ "{{ $id_vehicle }}"+'/update-data-vehicle')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/list-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+'/create-master-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-address-book"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-address-book/"+ "{{ $id_address_book }}"+'/update-data-address-book')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-master-customer/"+ "{{ $id_master_customer }}"+'/update-data-customer')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "customer-warehouse-orders"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-order-id/"+ "{{ $redirects_to_whs }}"+'/customer-warehouse-orders')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "create-master-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-master-vendor")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sub-services")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-vendor/"+ "{{ $id_master_vendor }}"+'/update-data-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "detail-file-item-vendor"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/added-item-vendor/"+"{{ $item_vendor_id }}"+'/detail-file-item-vendor')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-item-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-item-vendor/"+"{{ $detail_data_item_V }}"+'/update-data-item-vendor-transport')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-sub-services"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-sub-services/"+"{{ $mastersubserviceid }}"+'/update-data-sub-services')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-moda/"+"{{ $modaid }}"+'/update-data-moda')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "update-data-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-shipment-category/"+"{{ $shipmentcategoriesid }}"+'/update-data-shipment-category')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "detail-data-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/edit-users/"+"{{ $usersid }}"+'/detail-data-users')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "list-master-shipment-category"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-shipment-category")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-moda"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-moda")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-master-sales-order"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-master-sales-order")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-roles"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-roles")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "manage-permissions"){
                                                            
                                                            url = url.replace(url, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/manage-permissions")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "async-integrator-3permata"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/API-integration/v1/async-integrator-3permata")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-warehouse"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-warehouse")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-customer-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-customer-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "list-item-alerts-vendor-transport"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/list-item-alerts-vendor-transport")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "transport-list-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/transport-list-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-result"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/xml/"+"{{ $indexorderid }}"+'/xml-result')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "xml-file"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/detail-data-order-xml/"+"{{ $data_xml }}"+'/xml-file')
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        if(value == "warehouse-daterange"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/warehouse-daterange")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }

                                                        
                                                        if(value == "create-users"){
                                                            
                                                            urls = urls.replace(urls, "/dashboard/find-branch-with-branch/branch-id/"+responseJsonData+"/create-users")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                                                        }
                                                        
                                                        if(value == "master-cashbon"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/master-cashbon")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                
                                                        } 

                                                        if(value == "registration-vehicle"){
                                                                        
                                                            url = url.replace(url, "/cash-advanced-list/branchs-id/"+responseJsonData+"/registration-vehicle")
                                                             let cabang = "{{ $some }}";
                                                            let link = '{!! route("dashboard")  !!}';
                                                            let redirect = link;

                                                                setTimeout(function(){ 

                                                                        window.location.href = redirect;

                                                            }, 1000);
                            
                                                        } 

                                                    }

                                                    resolve();

                                                }, 5000);
                                            })

                                    } catch (e) {
                                        
                                            console.log(e, 'error')

                                        }

                                    };

                            SettingUp();
                        }
                    })

                });

            });
        });

            // check when all ajax load completed
            function get_ajax(link, data, callback) {
                $.ajax({
                    url: link,
                    type: "GET",
                    data: data,
                    dataType: "json",
                    success: function (data, status, jqXHR) {
                        callback(jqXHR.status, data)
                    },
                    error: function (jqXHR, status, err) {
                        callback(jqXHR.status, jqXHR);
                    },
                    complete: function (jqXHR, status) {
                    }
                })
            }

            function run_list_ajax(callback){
                var size=0;
                var max= 10;
                for (let index = 0; index < max; index++) {
                    var link = 'this url';
                    var data={i:index}
                    get_ajax(link,data,function(status, data){
                        console.log(index)
                        if(size>max-2){
                            callback('done')
                        }
                        size++
                        
                    })
                }
            }   

            // run this function --
            // run_list_ajax(function(info){
            //     console.log(info)
            // })


    // let run = function(){
    //     const check_connection = new XMLHttpRequest();
    //     check_connection.timeout = 6500;
    //     check_connection.open('GET', 'http://your-api.co.id/home', true);
    //     check_connection.send();
    // }

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
    $('#asdzx').click(function(){
        $('#asdzx').prop('disabled','disabled');
    })

    // var pusher = new Pusher('f12e5f39bac5511f72a0', {
    //   cluster: 'us3'
    // });

    // var channel = pusher.subscribe('webhooks-channel');
    let pusher = new Pusher('6a4b776ed61d138178ef', {
        cluster: 'ap1',
        forceTLS: true,
        encrypted: true
    });

    pusher.connection.bind('state_change', function(states) {
        $('div#status').html('<div>&nbsp;<i class="fa fa-circle text-success"></i>' + " Channels current state is " + states.current + '</div>');
    });

    pusher.connection.bind('error', function( err ) {
        if( err.error.data.code === 4004 ) {
            $('div#status').html('<div> >>> limit sudah habis silahkan untuk mengupgrade limit billing anda..&nbsp;<i class="fa fa-circle" style="color:red"></i></div>');
        }
    });

        const check = "{{$some}}";

    let channel = pusher.subscribe('live-webhooks-production');
        channel.bind('production-webhooks-event-live', function(data) {
            WebhookEventSync(data.webhooks);
    });

    //   var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {

    //         cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
    //         useTLS: true,
    //         authEndpoint: '/broadcasting/auth',
    //         disableStats: true,
    //             auth: {
    //                 headers: {

    //                         'X-CSRF-Token': '{{ csrf_token() }}'

    //                 }
    //             }

    //         }
    //     ); 
    // const check = "{{$some}}";

    // channel.bind('webhooks-event', function(data) {
    // //   alert(JSON.stringify(data));
    //     if(check == ''){

    //         // do something with user not choose branch first

    //         } 
    //         else {

    //             WebhookEventSync(data.webhooks);

    //         }

    // });

        
        // const channel = pusher.subscribe('webhooks-channel');

        // channel.bind('warehouse\\Events\\WebhookEvents', function(data) {
            
          
            
        // });

        async function WebhookEventSync(response) {

    // TODO: progres sync to update [3PS][POP]() to process with accurate to create SO.IT-SH....
    // TODO: progres sync to update [3PS][POD]() to done with accurate to create DO.IT-SH....
        $("#asdzx").text("Processing status");
        
        let promise = new Promise((resolve, reject) => {
                        setTimeout(() => resolve(response), 2000);
                    });

                    const results = await promise;
                    let timerInterval
                    let method = results.method;
                    let shipment_code = results.shipment;

                    if(shipment_code){
                        $('#ModalStatusAccoutingTC').modal('hide')
                    }

                    // =>>> webhook accurate cloud
                    //     let warehouseID = results[0].data[0].warehouseId;
                    //     let itemNo = results[0].data[0].itemNo;
                    //     let Quantity = results[0].data[0].quantity;
                    //     Swal({
                    //             title:"IzzyTransport Webhook Notification",
                    //             text: "Notification",
                    //             confirmButtonColor: '#3085d6',
                    //             html: "Information method :" +method+ '</br>' + "shipment code :" +shipment_code,
                    //             width: 'auto',
                    //             // showConfirmButton: true,
                    //             confirmButtonText: '<div class="badge badge-success">Ok</div>',
                    //             type: 'info'
                    //         }).then((result) => {
                    //             if (result.value) {
                    //                 return true;
                    //     }
                    // })
                    // =>>> webhook accurate cloud

                        Swal.fire({
                        title: 'Processing Requests',
                        html:"Synchronize data <img src='{!! asset('img/pre-loader/loader3.gif') !!}'></br>"+"<div class='emptys-state'><span style='color: DARKSLATEGRAY;font-family: Quicksand'><b>"+shipment_code+"</b></span></div><br/><br/><span class='form-control' style='color: DARKSLATEGRAY;font-family: Quicksand'>Shipment["+method+"] sedang diproses..<br/>"+"<br/><img src='{!! asset('img/pre-loader/Preloader_7d5d.gif') !!}'></span>",
                        timer: 5000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                        },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                                if (
                                        result.dismiss === Swal.DismissReason.timer
                                    ) {
                                        setTimeout(() => {
                                                AsyncData(method, shipment_code)
                                            }, 
                                        5000
                                    );
                                }
                            }
                        );
             
                // console.log(method)
                
                // console.log(results[0].data[0]);
            }

    // =>>> testing socker webhook accurate cloud
    // var socket = io.connect('http://127.0.0.1:4200');

	// socket.on('connect', function(data) {
    // 	socket.emit('join', 'Socket from handle request');
    // });

    // socket.on('messages', function(data) {
    //           $(".test").append(data);
    //     });

        // socket.on('call progress event', function(data) {
        //       $(".test").append(data);
        // });
                async function AsyncData(response,shipment_code) 
                {
                    const toast = Swal.mixin({
                                            toast: true,
                                            position: 'right',
                                            showConfirmButton: false,
                                            timer: 6500
                                         });
                    try 
                            {
                                await fetch(`http://your-api.co.id/3PS-received-webhooks/${response}/${shipment_code}`).then(async (ResponseString)=> {
                                    
                                    let received_webhook = await ResponseString.json()

                                    let current_origin_url = window.location.origin;
                                    let current_pathname_url = window.location.pathname;
                                    let url = current_origin_url+current_pathname_url;

                                    let cabang = "{{ $some }}";
                                    let transport_order = '{{ route("transport.static", ":id") }}';

                                    if(current_pathname_url == '/dashboard/find-branch-with-branch/branch-id/'+cabang+'/list-order-transport') {
                
                                        transport_order = transport_order.replace(':id', cabang);

                                            setTimeout(function(){ 


                                                window.location.href = transport_order;

                                            }, 8000);

                                    } 
                                            else 
                                                    {
                                                        toast({
                                                            title:"Mohon maaf data anda belum berhasil dibuat di sistem."
                                                        })
                                                    }
                                    }
                                );

                                    toast({
                                        title:"Data berhasil disinkronkan dengan Izzy Transports."
                                    })

                                let id = "{{ session()->get('id') }}";

                                if(!id){

                                            toast({
                                                        title:"Kode cabang tidak ditemukan."
                                                    })
                                    } 
                                        else
                                                {

                                                    let cabang = "{{ $some }}";
                                                    let link = '{!! route("transport.static", ":cabang")  !!}';
                                                    let redirect = link.replace(":cabang",cabang)

                                        setTimeout(function(){ 

                                                window.location.href = redirect;

                                    }, 8000);
                            }

                    } 
                        catch {

                            const toast = Swal.mixin({
                                            toast: true,
                                            position: 'bottom',
                                            showConfirmButton: false,
                                            timer: 6500
                                         }
                                    );
                            toast({
                                title:"Waiting request from server, try it again !"
                            }
                        )
                    }
                
                }


            $(document).ready(function () {
                Inputmask("99.999.999.9-999.999").mask("#tax_no");
                // (.999){+|1},00 Inputmask("/[^0-9.]+").mask("#ttlQty");
                Inputmask("99.999.999.9-999.999").mask("#no_npwp");
                $("#since").inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy" });
                $("#email").inputmask({ alias: "email"});
                $("#ttlQty").inputmask({ alias: "currency"});
                // $('#tax_no').keypress((e) => {

                    // const data = e.currentTarget.value;
                        // if (typeof data === 'string') {
                        //    let format = data.replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})(\d{3})/, '$1.$2.$3.$4-$5.$6');
                        //    $(".npwps").val(format);
                        //    return true;
                        // }
                // });
            });
        
        </script>
    </body>
</html>
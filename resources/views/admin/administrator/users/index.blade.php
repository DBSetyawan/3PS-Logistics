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
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Users</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu }}
</li>
@endsection
@section('content')
<div id="main-content">
    <div class="container-fluid">
       <div class="row-fluid">
          <div class="span12">
              <h3 class="page-title">
                   {{ $menu }}
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>
          </div>
       </div>
       @include('flash::message')
       @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div>
        <br />
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
                        <div style="text-align:left;">
                        </div>
                        <div style="text-align:right;">
                            <button type="button" class="btn btn-info" onclick="location.href='{{ route('users.create.index', array($some)) }}'">
                                    <i class="icon-plus"></i>
                                        Add New
                            </button>
                            <button type="button" class="btn btn-warning" onclick="location.href='{{ route('users.trashed', array($some)) }}'">
                                <i class="fas fa-window-restore"></i>
                                    User Unactive
                        </button>
                        </div>
                    <div>
                        &nbsp;
                    </div>
                <table class="table table-striped table-bordered {{ count($users) > 0 ? 'datatable' : '' }} dt-select" id="{{ count($users) > 0 ? 'sample_1' : 'emptyrow' }}">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                            <tr class="odd gradeX">
                                <td style="width: 22%;">{{ $user->name }}</td>
                                <td style="width: 31%;">{{ $user->email }}</td>
                                <td style="width: 37%;"> 
                                    @foreach ($user->roles()->pluck('name') as $role)
                                        <span class="label label-info label-many">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td style="width: 16px;">
                                    <div class="span5">
                                      <button onclick="location.href='{{ route('edit.master.users', array($some, $user->id)) }}'" class="btn btn-xs btn-primary" type="button"><i class="fas fa-user-cog"></i></button>
                                    </div>
                                <form class="span6" action="{{route('users.destroy', $user->id)}}" method="post">
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="span5">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-user-times"></i></button>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach()
                         @else
                            @foreach ($users as $user)
                            <tr class="odd gradeX">
                                <td style="width: 22%;">{{ $user->name }}</td>
                                <td style="width: 31%;">{{ $user->email }}</td>
                                <td style="width: 37%;"> 
                                    @foreach ($user->roles()->pluck('name') as $role)
                                        <span class="label label-info label-many">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td style="width: 16px;">
                                    <div class="span5">
                                    <button onclick="location.href='{{ route('edit.master.users', array($some, $user->id)) }}'" class="btn btn-xs btn-primary" type="button"><i class="fas fa-user-cog"></i></button>
                                    </div>
                                <form class="span6" action="{{route('users.destroy', $user->id)}}" method="post">
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="_token" value="{{ @csrf_token()}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="span5">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-user-times"></i></button>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach()
                         @endif 
                        </tbody>
                    </table>
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
<script src="{{ asset('js/user-management-list.js') }}"></script>
<script src="{{ asset('js/user-list-is-empty.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
@endsection

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
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
                            <button type="button" class="btn btn-info" onclick="location.href='{{ route('Branchs.create') }}'">
                                    <i class="icon-plus"></i>
                                        Add New
                            </button>
                        </div>
                    <div>
                        &nbsp;
                    </div>
                <table class="table table-striped table-bordered {{ count($companysbranch) > 0 ? 'datatable' : '' }} dt-select" id="sample_1">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Branch</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @if (count($users) > 0) --}}
                            @foreach ($companysbranch as $cabang)
                            <tr class="odd gradeX">
                                <td style="width: 50%;">{{ $cabang->company->name }}</td>
                                <td style="width: 40%;">{{ $cabang->branch }}</td>
                                <td style="width: 23%;">
                                    <div class="span5">
                                      <button onclick="location.href='{{ URL::to('Branchs/' . $cabang->id . '/edit')}}'" class="btn btn-xs btn-primary" type="button"><i class="fas fa-user-cog"></i></button>
                                    </div>
                                <form class="span6" action="{{route('Branchs.destroy', $cabang->id)}}" method="post">
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
                        {{-- @else
                            <tr>
                                <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                            </tr> --}}
                        {{-- @endif --}}
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
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/jquery.blockui.js"></script>
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
   <script src="../js/jquery.scrollTo.min.js"></script>
   <script src="../js/common-scripts.js"></script>
   <script src="../js/user-management-list.js"></script>
@endsection

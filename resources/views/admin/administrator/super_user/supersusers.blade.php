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
    <a href="#">Settings </a>
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
                <div class="widget red">
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
                    <form class="form-horizontal" method="POST" onSubmit="JavaScript:disableRefreshDetection()">
                        <span id="stepone" style="display:inline;">
                        <h3 style="font-family: Fira Code">Company</h3>
                    <br/>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                          <div class="row-fluid">
                                <div class="span7">
                                        <div class="control-group">
                                                <label class="control-label span1">Company</label>
                                                <div class="controls">
                                                        {{-- <input type="input" id="companystechs" class="span8" name="companystechs" ><span class="add-on"><a type="button" onclick="AddCompany()" id="Addcompanies" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Company</a></span> --}}
                                                    <select class="form-control span7" id="companystechs" name="companystechs">
                                                    </select><span class="add-on"><a type="button" onclick="AddCompany()" id="Addcompanies" class="btn btn-primary"><i class="fas fa-sync-alt"></i>Add Company</a></span>
                                                    <div class="row-fluid">
                                                        {{-- <div class="span8">
                                                            <br> --}}
                                                    {{-- @if ($errors->has('items'))
                                                            <span id="items_error" class="alert alert-danger span10" style="width:300px;text-align: center">{{ $errors->first('items') }}</span>
                                                        @endif --}}
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <div class="span6 hidden">
                            <div class="control-group hidden">
                                <label class="control-label">get value companys</label>
                                <div class="controls controls-row">
                                    <select class="form-control validate[required]" style="width:320px;" id="company_vals" name="company_vals">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-striped" id="companys" name="ajax_comps">
                                <thead>
                                    <tr>
                                        <th class="hidden" style="width:100px" bgcolor="#FAFAFA">UUID</th>
                                        <th style="width:200px" bgcolor="#FAFAFA">Company</th>
                                        {{-- <th style="width:50px" bgcolor="#FAFAFA">Logo</th> --}}
                                        {{-- <th style="width:50px" bgcolor="#FAFAFA">Action</th> --}}
                                        {{-- <th bgcolor="#FAFAFA"><center>Action</center></th> --}}
                                    </tr>  
                                </thead>
                                {{-- <button onclick="upNdown('up');">&ShortUpArrow;</button>&NonBreakingSpace;
                                <button onclick="upNdown('down');">&ShortDownArrow;</button> --}}
                                <tbody id="tbods">
                            {{-- @foreach($Joblistview as $jobs_field)
                                    <tr class="odd gradeX">
                                        <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                        <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                        <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                        <td style="width:2%;">
                                            <div class="span3">
                                                <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                            </div> 
                                        </td>
                                    </tr>
                                @endforeach() --}}
                                </tbody>
                            </table>
                            <div class="row-fluid">
                                    <div class="span12" style="text-align:right;" >
                                            <div class="form-actions" style="">
                                                    <button type="submit" class="btn btn-success" id="nextstep1">Next</button>
                                                    {{--  <button type="button" class="btn">Cancel</button>  --}}
                                              {{-- <a class="btn btn-warning">Cancel</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </span>
                            {{-- step 2 --}}
                            <span id="steptwo" style="display:none;">
                                <h3 style="font-family: Fira Code">Company Branch</h3>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                    <div class="row-fluid">
                                          <div class="span7">
                                                <div class="control-group">
                                                    <label class="control-label">Company</label>
                                                    <div class="controls">
                                                        <select class="form-control" id="companytechs" name="companytechs" required>
                                                        </select>
                                                        {{-- <span class="help-inline">Give your First Name</span> --}}
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                        <label class="control-label">Branch</label>
                                                        <div class="controls">
                                                                {{-- <input type="input" id="compnybranchs" class="compnybranchssearch span8" name="compnybranchs" ><span class="add-on"><a type="button" onclick="AddBranch()" id="Addcompanies" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Branch</a></span> --}}
                                                            <select class="form-control span7" id="compnybranchs" name="compnybranchs" required>
                                                            </select><span class="add-on"><a type="button" onclick="AddBranch()" id="Addcompanies" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Branch</a></span>
                                                            {{-- <span class="help-inline">Give your First Name</span> --}}
                                                    </div>
                                                </div>
                                          </div>
                                      </div>
                                      <div class="span6 hidden">
                                            <div class="control-group hidden">
                                                <label class="control-label">get value Branch</label>
                                                <div class="controls controls-row">
                                                    <select class="form-control validate[required]" style="width:320px;" id="compbranchs" name="compbranchs">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6 hidden">
                                            <div class="control-group hidden">
                                                <label class="control-label">get value Company</label>
                                                <div class="controls controls-row">
                                                    <select class="form-control validate[required]" style="width:320px;" id="compny" name="compny">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                  <table class="table table-striped table-bordered table-striped" id="branchs" name="ajax_branchs">
                                          <thead>
                                              <tr>
                                                  {{-- <th bgcolor="#FAFAFA">check</th> --}}
                                                    <th class="hidden" style="width:100px" bgcolor="#FAFAFA">UUID</th>
                                                    <th style="width:200px" bgcolor="#FAFAFA">Company</th>
                                                    <th style="width:200px" bgcolor="#FAFAFA">Branch</th>
                                                  {{-- <th style="width:50px" bgcolor="#FAFAFA">Logo</th> --}}
                                                    {{-- <th style="width:50px" bgcolor="#FAFAFA">Action</th> --}}
                                                  {{-- <th bgcolor="#FAFAFA"><center>Action</center></th> --}}
                                              </tr>  
                                          </thead>
                                          {{-- <button onclick="upNdown('up');">&ShortUpArrow;</button>&NonBreakingSpace;
                                          <button onclick="upNdown('down');">&ShortDownArrow;</button> --}}
                                          <tbody id="tbods">
                                      {{-- @foreach($Joblistview as $jobs_field)
                                              <tr class="odd gradeX">
                                                  <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                                  <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                                  <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                                  <td style="width:2%;">
                                                      <div class="span3">
                                                          <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                      </div> 
                                                  </td>
                                              </tr>
                                          @endforeach() --}}
                                          </tbody>
                                      </table>
                                      <div class="row-fluid">
                                              <div class="span12" style="text-align:right;" >
                                                      <div class="form-actions" style="">
                                                              <button type="submit" class="btn btn-success" id="nextstep2">Next</button>
                                                              {{--  <button type="button" class="btn">Cancel</button>  --}}
                                                        {{-- <a class="btn btn-warning">Cancel</a> --}}
                                                  </div>
                                              </div>
                                          </div>
                                      </span>
                                      {{-- step 3 --}}
                                <span id="stepthree" style="display:none;">
                                    <h3 style="font-family: Fira Code">Create Module</h3>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                                    <div class="control-group">
                                        <label class="control-label">Company</label>
                                        <div class="controls">
                                            <select class="form-control cmp" id="fetch_company" name="fetch_company" required>
                                            </select>
                                            {{-- <span class="help-inline">Give your First Name</span> --}}
                                        </div>
                                     </div> 
                                    <div class="control-group">
                                        <label class="control-label">Branch</label>
                                        <div class="controls">
                                            <select class="form-control brnch" id="fetch_branch" name="fetch_branch" required>
                                            </select>
                                             {{-- <span class="help-inline">Give your First Name</span> --}}
                                       </div>
                                    </div> 
                                    <div class="row-fluid">
                                            <div class="span7">
                                                <div class="control-group">
                                                <label class="control-label">Roles Name</label>
                                                    <div class="controls">
                                                            <input type="input" maxlength="25" id="fetch_roles" class="fetch_roles span8" name="fetch_roles" >
                                                            {{-- <input type="input" id="fetch_roles" class="fetch_roles span6" name="fetch_roles" > --}}
                                                            {{-- <select class="form-control" style="width:30%" id="fetch_roles" name="fetch_roles" required>
                                                            </select> --}}
                                                            {{-- <span class="help-inline">Give your First Name</span> --}}
                                                        </div>
                                                    </div>
                                                    {{-- <div class="control-group">
                                                            <div class="controls">
                                                                   <label class="control-label"> Permission </label>
                                                                </div>
                                                            </div> --}}
                                                    {{-- <div class="control-group">
                                                            <div class="controls">
                                                                    <input type="checkbox" id="transport" name="transport" value="transport"><span class="add-on"> Transport</span>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                    <div class="controls">
                                                                        <input type="checkbox" id="warehouse" name="warehouse" value="warehouse"><span class="add-on"> Warehouse</span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                        <div class="controls">
                                                                            <input type="checkbox" id="accounting" name="accounting" value="accounting"><span class="add-on"> Accounting</span>
                                                                        </div>
                                                                    </div> --}}
                                                </div>
                                            </div>
                                    <div class="row-fluid">
                                            <div class="span7">
                                                        <div class="control-group">
                                                            <label class="control-label">Permission</label>
                                                            <div class="controls">
                                                            <select class="chzn-select permiss" maxlength="20" style="width:315px" id="permission" name="permission[]" multiple="multiple">
                                                                <option value="warehouse">warehouse</option>
                                                                <option value="transport">transport</option>
                                                                <option value="accounting">accounting</option>
                                                            </select><span class="add-on"><a type="button" onclick="SettingUpModule()" id="Addcompanies" style="margin-bottom: 23px;" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Module</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                              
                                                {{-- <div class="span4">
                                                        <div class="control-group">
                
                                                                    {{-- <div class="controls"> --}}
                                                                       
                                                                        {{-- </div> --}}
                                                                    {{-- </div>
                                                                </div> --}}
                                          
                                {{-- </div> --}}
                                    {{-- <div class="control-group">
                                        <label class="control-label">Passing user new</label>
                                        <div class="controls">
                                            <select class="form-control" id="user_news" name="user_news" required>
                                            </select>
                                            <span class="help-inline">Give your First Name</span> 
                                         </div>
                                    </div> --}}
                                    {{-- <div class="row-fluid">
                                        <div class="span12" style="text-align:right;" >
                                                <div class="form-actions" style="">
                                                        <button type="submit" class="btn btn-success" id="finish">Finish</button>
                                                        {{--  <button type="button" class="btn">Cancel</button>  --}}
                                                  {{-- <a class="btn btn-warning">Cancel</a> --}}
                                            {{-- </div>
                                        </div>
                                    </div> --}}
                                    <table class="table table-striped table-bordered table-striped" id="settingupmodul" name="ajax_comps">
                                            <thead>
                                                <tr>
                                                    {{-- <th class="" style="width:100px" bgcolor="#FAFAFA">UUID</th> --}}
                                                    {{-- <th style="width:200px" bgcolor="#FAFAFA">company</th> --}}
                                                    {{-- <th style="width:200px" bgcolor="#FAFAFA">Branch</th> --}}
                                                    <th style="width:200px" bgcolor="#FAFAFA"><center>Roles</center></th>
                                                    <th style="width:220px" bgcolor="#FAFAFA"><center>Permission</center></th>
                                                    <th class="hidden" bgcolor="#FAFAFA"><center>ID</center></th>
                                                    <th style="width:10px" bgcolor="#FAFAFA">Action</th>
        
                                                    {{-- <th style="width:50px" bgcolor="#FAFAFA">Logo</th> --}}
                                                    {{-- <th style="width:50px" bgcolor="#FAFAFA">Action</th> --}}
                                                    {{-- <th bgcolor="#FAFAFA"><center>Action</center></th> --}}
                                                </tr>  
                                            </thead>
                                            {{-- <button onclick="upNdown('up');">&ShortUpArrow;</button>&NonBreakingSpace;
                                            <button onclick="upNdown('down');">&ShortDownArrow;</button> --}}
                                            <tbody id="tbodsrole"> 
                                        {{-- @foreach($Joblistview as $jobs_field)
                                                <tr class="odd gradeX">
                                                    <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                                    <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                                    <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                                    <td style="width:2%;">
                                                        <div class="span3">
                                                            <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                        </div> 
                                                    </td>
                                                </tr>
                                            @endforeach() --}}
                                            </tbody>
                                        </table>
                                    <div class="span6 hidden">
                                    <div class="control-group hidden">
                                        <label class="control-label">get value Branch</label>
                                        <div class="controls controls-row">
                                            <select class="form-control validate[required]" style="width:320px;" id="fetch_sync_role" name="fetch_sync_role">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <div class="modal fade" id="ModalAccountBilling" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
                            aria-labelledby="ModalAccountBillinglabelID" aria-hidden="true"
                            style="margin:60px -625px;width:1275px;">
                            <p>{{ \Session::get('errors') }}</p>
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel1">Create User </h3>
                            </div>
                            <div class="messages"></div>
                            <div id="modal_tc" class="modal-body">
                                <label class="control-label" id="header_waiting_list_user" style="text-align: end"></label>
                                <div class="modal-body">
                                    <form class="form-horizontal" id="form_register_user">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12" />
                                        {{-- <input type="hidden" id="token_register" name="token_register" class="span12 " /> --}}
                                        <input type="hidden" id="roles" name="roles" class="span12 " />
                                        {!! csrf_field() !!}
                                        <br />
                                        <div class="control-group">
                                            <label class="control-label" style="text-align: left">Name</label>
                                            <div class="controls">
                                                <input  class="span4" style="margin-right:120px" type="text" maxlength="30" id="name" name="name"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" style="text-align: left">Email</label>
                                        <div class="controls">
                                            <input  class="span4" style="margin-right:120px" type="email" maxlength="30" id="email" name="email"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Password</label>
                                        <div class="controls">
                                            <input type="password" id="password" class="span4" name="password" ><span class="add-on"><a type="button" onclick="registerUsers()" id="registerUsers" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Register</a></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="span6 hidden">
                                    <div class="control-group hidden">
                                        <label class="control-label">get value Branch</label>
                                        <div class="controls controls-row">
                                            <select class="form-control validate[required]" style="width:320px;" id="fetchidbranch" name="fetchidbranch">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-striped" id="supersuserlist" name="ajax_users">
                                    <thead>
                                        <tr>
                                            {{-- <th class="" style="width:100px" bgcolor="#FAFAFA">UUID</th> --}}
                                            <th style="width:200px" bgcolor="#FAFAFA">ID</th>
                                            <th style="width:200px" bgcolor="#FAFAFA">Name</th>
                                            <th style="width:200px" bgcolor="#FAFAFA">Email</th>
                                            {{-- <th style="width:200px" bgcolor="#FAFAFA"><center>Roles</center></th> --}}
                                            {{-- <th class="hidden" bgcolor="#FAFAFA"><center>ID</center></th> --}}
                                            {{-- <th style="width:50px" bgcolor="#FAFAFA">Logo</th> --}}
                                            <th style="width:50px" bgcolor="#FAFAFA">Action</th>
                                            {{-- <th bgcolor="#FAFAFA"><center>Action</center></th> --}}
                                        </tr>  
                                    </thead>
                                    {{-- <button onclick="upNdown('up');">&ShortUpArrow;</button>&NonBreakingSpace;
                                    <button onclick="upNdown('down');">&ShortDownArrow;</button> --}}
                                    <tbody id="tbodyusers"> 
                                {{-- @foreach($Joblistview as $jobs_field)
                                        <tr class="odd gradeX">
                                            <td style="width: 5%;"><input type="checkbox" id="check_data_transport_id[]" name="check_data_transport_id[]" value="" checked></td>
                                            <td style="width: 60px;">{{ $jobs_field->id }}</td>
                                            <td style="width: 90px;">{{ $jobs_field->transport_orders['order_id'] }}</td>
                                            <td style="width:2%;">
                                                <div class="span3">
                                                    <button onclick="location.href=''" data-original-title="On Progress" data-placement="top" class="btn tooltips btn-small btn-primary" type="button"><i class="icon-file"></i></button>
                                                </div> 
                                            </td>
                                        </tr>
                                    @endforeach() --}}
                                    </tbody>
                                </table>
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                        {{-- <button id="dpnts" type="submit" class="btn btn-primary">Update</button> --}}
                                        {{-- <div class="row-fluid"> --}}
                                                {{-- <div class="span12" style="text-align:right;" >
                                                        <div class="form-actions" style=""> --}}
                                    {{-- <button type="submit" class="btn btn-success" id="nextstep3">Submit</button> --}}
                                                        {{--  <button type="button" class="btn">Cancel</button>  --}}
                                                {{-- <a class="btn btn-warning">Cancel</a> --}}
                                            {{-- </div> --}}
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ADVANCED TABLE widget-->

       <!-- END PAGE CONTENT-->
   </div>
</div>
@endsection

@section('javascript')

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->

   <script src="../js/jquery-1.8.2.min.js"></script>
   <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../js/select2.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="../assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="../js/jquery.blockui.js"></script>

   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script src="../js/jQuery.dualListBox-1.3.js" language="javascript" type="text/javascript"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
   @include('sweetalert::view')
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
  <!-- END JAVASCRIPTS -->

   <script language="javascript" type="text/javascript">


function preventBack(){window.history.forward();}
  setTimeout("preventBack()", 0);
  window.onunload=function(){null};

  
    function registerUsers(){

        $("#registerUsers").text('Processing...'); 

                let ddlArray= new Array();
                    let ddl = document.getElementById('company_vals');
                    
                    for (i = 0; i < ddl.options.length; i++) {

                        ddlArray[i] = ddl.options[i].value;

                    }

                        let datazx = [];

                            for (i = 0; i < ddlArray.length; i++) {

                                datazx.push(ddlArray[i]);
                            
                            }  

                        let rdatatcxz0 = [];

                            for (i = 0; i < datazx.length; i++) {

                                rdatatcxz0.push(datazx[i]);

                            }

                    let branchsLL = new Array();
                    let branchID = document.getElementById('fetchidbranch');

                    
                    for (i = 0; i < branchID.options.length; i++) {

                        branchsLL[i] = branchID.options[i].value;

                    }

                        let databranch = [];

                            for (i = 0; i < branchsLL.length; i++) {

                                databranch.push(branchsLL[i]);
                            
                            }  

                        let databrnchfetch = [];

                            for (i = 0; i < databranch.length; i++) {

                                databrnchfetch.push(databranch[i]);

                            }
                            
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let roles = document.getElementById('roles').value;

            // let name = $("#name").val();
            // let email = $("#email").val();
            // let password = $("#password").val();
            // let roles = $("#roles").val();
            let cabang = databrnchfetch;
            let perusahaan = rdatatcxz0;

            $.ajax({

                url: "{{ url('registerUsers') }}",
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'JSON',
                data : {
                    cabang: cabang,
                    name: name, 
                    email: email,
                    password: password,
                    perusahaan: perusahaan,
                    roles: roles
                },
                    success: function (data){
                         
                        // if(data.success == 'Berhasil'){
                              

                                $('#register_berhasil').html('<div class="alert alert-success"><p>User berhasil didaftarkan</p></div>');
                                
                                $("#name").val('');
                                $("#email").val('');
                                $("#password").val('');
                                $("#registerUsers").text('Register'); 
                                var messages = $('.messages');

                                var successHtml = '<div class="alert alert-success">'+
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                                '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> '+ data.success +
                                '</div>';
                                // $("#removemod").prop("disabled", true);
                                $(messages).html(successHtml);

                                const tBody = $("#supersuserlist > TBODY")[0];
                                    row = tBody.insertRow(-1);

                                    let cellone = $(row.insertCell(0));
                                    let celltwo = $(row.insertCell(1));
                                    let cellthree = $(row.insertCell(2));
                                    // let cellthree = $(row.insertCell(2));
                                        cellone.attr("id","userid");
                                        // cellone.attr("class","hidden");
                                        cellone.html(data.user_news);
                                        celltwo.html(data.names);
                                        cellthree.html(data.user_email);
                                        // cellthree.html(data.user_news);
                        
                                        celljc = $(row.insertCell(-1));
                                        let btnRemovejc = $("<input />");   
                                            btnRemovejc.attr("type", "button");
                                            btnRemovejc.attr("id", "userid");
                                            btnRemovejc.attr("class", "btn btn-danger");
                                            btnRemovejc.attr("onclick", "RemoveUsers(this);"); //progress
                                            btnRemovejc.val("Remove");
                                        // let adasdxzcz = $("<input />");
                                        //     adasdxzcz.attr("type", "button");
                                        //     adasdxzcz.attr("id", ajax.role);
                                        //     adasdxzcz.attr("class", "btn btn-primary ModalAccountBillingClass");
                                        //     adasdxzcz.attr("data-target", "#ModalAccountBilling");
                                        //     adasdxzcz.attr("data-toggle", "modal");
                                        //     adasdxzcz.attr("onclick", "ModalSetting(this.id);");
                                        //     adasdxzcz.val("Users");

                                            // celljc.append(btnRemovejc);

                                            // celljc.append(btnRemovejc);

                            // $('.messages').delay(3500).fadeOut('slow');

                            
                        // $('tbodsrole tr td').ready(function(ds){
                        //     $('registerUsers').click(function(e){
                        //         // $(this).parents('tr').find('input').prop('disabled', true);
                        //         console.log((this).parents('tr').find('#removemod'));
                        //         $(this).closest('tr').find('#removemod').prop('disabled', true);
                        //     });
                        // });

                    },
                    complete: function (data) {
                        // $('#removemod').button('disable');
                        // var button = $('#removemod');
                        // $(button).attr('disabled', 'disabled');
                        // printWithAjax(); 
                        //  let uid_stop = $('tr').find('td').html();


                    }
            });

    };

    function ModalSetting(v){
        // console.log(v)
            $(function () {
                $(".ModalAccountBillingClass").click(function (e) {
                    e.preventDefault();

                        // $('#header_waiting_list_user').text(v);
                      
                        let ddlArray= new Array();
                        let ddl = document.getElementById('user_news');
                        
                        for (i = 0; i < ddl.options.length; i++) {

                            ddlArray[i] = ddl.options[i].value;

                        }

                            let datazx = [];

                                for (i = 0; i < ddlArray.length; i++) {

                                    datazx.push(ddlArray[i]);
                                
                                }  

                        $.ajax({

                            url: "get-users/find/"+ datazx,
                            dataType: 'json',
                            success: function (detil) {

                                $('.messages').delay(3500).fadeOut('slow');

                                $('#supersuserlist tr').not(':first').remove();

                                let html = '';
                                let htmlxbefore = '';
                                let asdasd = new Array();
                                let datausers = [];
                                let asdxczxf = [];

                                    for (i = 0; i < detil.length; i++) {

                                        datausers.push(detil[i]);

                                    }

                                //     // debug file dynamic and develop file upload

                                        // datausers.forEach(element => {
                                            $.each(datausers, function(idx, datausersfetch){

                                            html += '<tr>'+
                                                        // '<td style="width:350px">' + asdasd['id'] + '</td>' + in 
                                                        '<td >' + datausersfetch.id + '</td>' +
                                                        '<td >' +  datausersfetch.name + '</td>' +
                                                        '<td >' +  datausersfetch.email + '</td>' +
                                                        '<td ><button class="btn btn-danger" id="process-file-button">Remove</button></td>'

                                                        // '<td style="width:240px"><input style="width:190px" type="file" onclick="myfunction('+datausers.email+')" id="file"></td>' +
                                                        // '<td style="width:100px"><label style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;"><input data-icon="false" style="width:190px;display: none;" type="file" class="Uploaded" data-id="'+ Values['id'] +'" id="file" enctype="multipart/form-data" multiple="true"/><i class="fas icon-large fa-cloud-upload-alt"></i>&nbsp; Stuck File</label></td>' +
                                                    // '<td style="width:200px"><a href="/download-path-file-shipment/'+asdasd['id']+'/requestFILE/'+ sadsd[i] +'"><center>'+ arrx +'</center></td>' +s
                                                    // '<td style="width:50px"><a href="/google-drive-file-list/'+ Values['shipment_id'] +'/find-file/'+ Values['id'] +'" target="_blank"><center>Download File ('+ Values['file_list_pod'].length +')</center></td>' +
                                                    '</tr>';

                                            });

                                            $('#supersuserlist tr').first().after(html);
                                            
                                        // });

                                        // url.split('php')[1]

                                    },
                                    error: function (data) {
                                        alert(data)
                                    }

                            });
                    });
            });
        };

        $('#companystechs').select2({
                placeholder: 'Cari...',
                "language": {
                "noResults": function(){
                        return "Company not found.";
                    }
                },
                ajax: {
                    url: 'company-object',
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

        });

    function RemoveUsers(user) {

        let rowx = $(user).closest("TR");
        const userid = $("TD", rowx).eq(0).html();
        const cmpny = $("TD", rowx).eq(1).html();
        const branch = $("TD", rowx).eq(2).html();

        Swal({
                title: 'Successfully Deleted',
                text: "Your file has been deleted.!",
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Okay!',
            }).then((result) => {
                if (result.value) {

                    $.ajax({

                            url: "request-deleted-supers-users/find/"+userid,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const tables = $("#supersuserlist")[0];
                                    tables.deleteRow(rowx[0].rowIndex);

                            }

                    });
            
                }

            })

            const tables = $("#branchs")[0];
            tables.deleteRow(rowx[0].rowIndex);
            
        document.getElementsByName("compbranchs")[0].remove(0);

    };


    function AddCompany() {
        AddRowCompany($("#companystechs").val());
        // console.log($("#companystechs").val())
        // $("#companystechs").val('');
    };

 

    $(document).ready(function() {
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
    });
 

    $(document).ready(function() { 

        $("button[id='nextstep1']").click(function(e) {
            e.preventDefault();
         
                const vals = $('#company_vals').val();
                // alert(vals);
                // console.log(vals)
                if (vals == null){

                        const alerts = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6000
                        });

                        alerts({

                            title: 'Maaf anda belum mengisi company, silahkan isi terlebih dahulu. untuk ke step berikutnya !'

                        })  

                } else {
                    // Swal("Berhasil","oke anda boleh ke step berikutnya","success");
                    document.getElementById('stepone').style.display ='none';
                    document.getElementById('steptwo').style.display ='inline';
                }
        });
        
        $("button[id='nextstep2']").click(function(e) {

               const alerts = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6000
                        });

            e.preventDefault();
                // const companytechs = $('#companytechs').val();
                const branchs = $('#compbranchs').val();
                // alert(vals);
                if (branchs == null ){

                    alerts({

                        title: 'Maaf inputannya masih kosong !'

                    })  

                } else {
                    // Swal("Berhasil","oke anda boleh ke step berikutnya","success");
                    document.getElementById('steptwo').style.display ='none';
                    document.getElementById('stepthree').style.display ='inline';
                    // document.getElementById('warehouse').checked = true;
                    // document.getElementById('transport').checked = true;
                    // document.getElementById('accounting').checked = true;
                }
        });


        
        // $('input[type="checkbox"]').click(function(e){
        //     let type = [];
        //     let box1 = document.getElementById('wh');
        //     let box2 = document.getElementById('tc');

        //     var urls = [];

        //         if (box1.checked) {
        //             urls.push(box1.value);
        //         }
                
        //         if (box2.checked) {
        //             urls.push(box2.value);

        //         }
                 
        // });

        $("button[id='nextstep3']").click(function(e) {
            e.preventDefault();
           const alerts = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 6000
            });

            alerts({

                title: 'Hay step 3 Maaf anda belum mengisi company, silahkan isi terlebih dahulu. untuk ke step berikutnya !'

            })  
        });
    });

    $(function() {
        $('#fetch_roles').keyup(function() {
            this.value = this.value.toUpperCase();
        });
    });
    function companyfalse(shipment) {  

        if (! shipment) {
                Swal({
                    type: 'error',
                    title: 'Peringatan System',
                    text: 'Maaf, inputannya masih kosong. coba pilih company-nya!',
                    footer: '<===[ 3 Permata System ]===>'
                })
            } else {
                
                // do something

            }
    }
    $('#fetch_branch').prop("disabled",true);
    // $('#fetch_roles').prop("disabled",true);

        function comod() {  
            $('#branch').prop("disabled",true)
            $('#modules').prop("disabled",true)
        }   

        // $('#fetch_roles').select2({
        //     placeholder: 'Cari...',
        //     ajax: {
        //             url: "{{ url('roles-load') }}",
        //             dataType: 'json',
        //             delay: 250,
        //             processResults: function (data) {
        //                 return {
        //                     results: $.map(data, function (item) {
        //                         return {
        //                             text: item.id +' - '+item.name,
        //                             id: item.id
        //                     }
                            
        //                 })
        //             };

        //         },

        //             cache: true
        //     }

        // })
         
        function AddRowCompany(shipment) {
            if (! shipment) {
                // Swal({
                //     type: 'error',
                //     title: 'Peringatan System',
                //     text: 'Maaf, inputannya masih kosong. coba pilih company-nya!',
                //     footer: '<===[ 3 Permata System ]===>'
                // })
                const alerts = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 6000
                    });

                    alerts({

                        title: 'Maaf inputannya masih ada yang kosong!'

                    })  
            } else {
              
            const tBody = $("#companys > TBODY")[0];
            row = tBody.insertRow(-1);
                let arrShipmentJ = new Array();

                let txt;
                let i;

                            let company = shipment;
                            let request = $.ajax({
                                url: "{{ url('add-company-request') }}"+'/'+company,
                                method: "GET",
                                dataType: "json",
                                data: { 
                                    company:company
                                },
                                success: function (dataifsuccess) {
                                    Swal({
                                        title: 'Successfully',
                                        text: "Data Company has been saved !",
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        allowOutsideClick: false,
                                        confirmButtonText: 'Okay!',
                                    }).then((result) => {
                                        if (result.value) {
                                            $('#company_vals').append($('<option>' ,{
                                                    value:dataifsuccess.company_ID,
                                                    text:dataifsuccess.company_ID
                                                }));

                                                let ddlArray= new Array();
                                                let ddl = document.getElementById('company_vals');
                                                
                                                for (i = 0; i < ddl.options.length; i++) {

                                                    ddlArray[i] = ddl.options[i].value;

                                                }

                                                    let datazx = [];

                                                        for (i = 0; i < ddlArray.length; i++) {

                                                            datazx.push(ddlArray[i]);
                                                        
                                                        }  

                                                    let asdasd = Array();
                                                    let rdatatcxz0 = [];

                                                        for (i = 0; i < datazx.length; i++) {

                                                            rdatatcxz0.push(datazx[i]);

                                                        }

                                            let cellone = $(row.insertCell(0));
                                            let celltwos = $(row.insertCell(1));
                                        
                                            cellone.attr("id","company");
                                            cellone.attr("class","hidden");
                                            cellone.html(dataifsuccess.company_ID);
                                            celltwos.html(dataifsuccess.company_N);
                                        
                                            // celljc = $(row.insertCell(-1));
                                            // let btnRemovejc = $("<input />");
                                            //     btnRemovejc.attr("type", "button");
                                            //     btnRemovejc.attr("class", "btn btn-primary");
                                            //     btnRemovejc.attr("onclick", "RemoveCompany(this);");
                                            //     btnRemovejc.val("Remove");
                                            //     celljc.append(btnRemovejc);

                                                $('#fetch_company').select2({
                                                        placeholder: 'Cari...',
                                                        ajax: {
                                                            url: 'create-object-company/find/'+ rdatatcxz0,
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

                                                }).on('change', function(e) {
                                                    $('#fetch_branch').empty();
                                                    $('#fetch_roles').val('');
                                                    $('#fetch_branch').prop("disabled", false);

                                                    let me = e.target.value;
                                                    let company_name = e.target.innerText;
                                                        $('#fetch_branch').select2({
                                                            placeholder: 'Cari...',
                                                            ajax: {
                                                                url: 'company-branchs-fetch/find/'+ me,
                                                                dataType: 'json',
                                                                delay: 250,
                                                                processResults: function (data) {
                                                                    return {
                                                                        results: $.map(data, function (item) {
                                                                            return {
                                                                                text: item.branch,
                                                                                id: item.id
                                                                        }
                                                                        
                                                                    })
                                                                };

                                                            },

                                                            cache: true
                                                        }

                                                    }).on('change', function(e){
                                                        let brnch_id = e.target.value;
                                                        $.get('/request-find-company-branchs/find/'+ brnch_id, function(data_company){
                                                            $.each(data_company, function (x, company) { 

                                                                    $('#fetch_roles').val(''+company.company['name']+' - '+company.branch);

                                                            });
                                                        });
                                                    });
                                                });

                                                        //  let is = e.target.value;

                                                // const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                                    // $(document).ready(function(){

                                                    // $( "#fetch_roles" ).autocomplete({

                                                    //     source: function( request, response ) {
                                                    //         $.ajax({
                                                    //                 // url:"{{ url('companies-automatics/search') }}/",
                                                    //                 url:"{{ url('roles-fetch-all') }}",
                                                    //                 type: "get",
                                                    //                 dataType: "json",
                                                    //                 data: {
                                                    //                 _token: CSRF_TOKEN,
                                                    //                 search: request.term
                                                    //             },

                                                    //                 success: function( data ) {
                                                    //                     response( data );
                                                    //                 }
                                                                
                                                    //             });
                                                    //         },
                                                    //         select: function (event, ui) {
                                                
                                                    //             $('#fetch_roles').val(ui.item.value); 
                                                    //             return false;
                                                            
                                                    //         }

                                                    //     });

                                                    // });
                     

                                            $('#companytechs').select2({
                                                    placeholder: 'Cari...',
                                                    ajax: {
                                                        url: 'create-object-company/find/'+ rdatatcxz0,
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

                                            // });
                                            }).on('change', function(e) {
                                                let is = e.target.value;

                                                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                                    $(document).ready(function(){

                                                    // $( "#compnybranchs" ).autocomplete({

                                                    //     source: function( request, response ) {
                                                    //         $.ajax({
                                                    //                 url:"{{ url('companies-automatics/search') }}/"+is,
                                                    //                 type: "get",
                                                    //                 dataType: "json",
                                                    //                 data: {
                                                    //                 _token: CSRF_TOKEN,
                                                    //                 search: request.term
                                                    //             },

                                                    //                 success: function( data ) {
                                                    //                     response( data );
                                                    //                 }
                                                                
                                                    //             });
                                                    //         },
                                                    //         select: function (event, ui) {
                                                
                                                    //             $('#compnybranchs').val(ui.item.value); 
                                                    //             return false;
                                                            
                                                    //         }

                                                    //     });
                                                                $('#compnybranchs').select2({
                                                                placeholder: 'Cari...',
                                                                "language": {
                                                                "noResults": function(){
                                                                        return "Branch not found.";
                                                                    }
                                                                },
                                                                ajax: {
                                                                    url: "{{ url('companies-automatics/search') }}"+'/'+ is,
                                                                    dataType: 'json',
                                                                    delay: 250,
                                                                    processResults: function (data) {
                                                                        return {
                                                                            results: $.map(data, function (item) {
                                                                                return {
                                                                                    text: item.branch,
                                                                                    id: item.id
                                                                            }
                                                                            
                                                                        })
                                                                    };

                                                                },

                                                                    cache: true
                                                            }

                                                        // });
                                                        })

                                                    });
                                                });
                     
                                       
                                      
                                        }
                                    })
                                },
                                error: function(data){
                                    Swal({
                                        type: 'error',
                                        title: 'Terjadi kesalahan sistem..',
                                        // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                        text: 'Try again, please check correct data!',
                                        footer: '<a href>Why do I have this issue?</a>'
                                })
                            }
                        }
                    );

                };
            };  

        function AddBranch() {
            AddRowBranchs($("#companytechs").val(),$("#compnybranchs").val());
            // $("#companytech").empty();
            // $("#compnybranchs").val('');
        };
               
        function AddRowBranchs(company, branchs) {

            if (! company || ! branchs) {
               const alerts = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6000
                        });

                        alerts({

                            title: 'Maaf masih inputannya masih ada yang kosong !'

                        })  
            } else {
              
            const tBody = $("#branchs > TBODY")[0];
            row = tBody.insertRow(-1);
                let arrShipmentJ = new Array();

                let txt;
                let i;

                    let brnch = branchs;
                    let company_id = company;

                            let request = $.ajax({
                                url: "{{ url('add-branch-request') }}",
                                method: "GET",
                                dataType: "json",
                                data: { 
                                    company_id:company_id,
                                    brnch:brnch
                                },
                                success: function (dataifsuccess) {
                                    // console.log(dataifsuccess.errors)
                                    if(dataifsuccess.errors == "failed"){

                                        Swal({
                                            type: 'error',
                                            title: 'Asynchronous failed..',
                                            text: "Try again, please check correct data, roles can't be same!",
                                            footer: '<label href>Why do I have this issue?</label>'
                                        })

                                    } else {
                                    //     Swal({
                                    //     title: 'Successfully',
                                    //     text: "Data branch has been saved !",
                                    //     type: 'success',
                                    //     allowOutsideClick: false,
                                    //     confirmButtonColor: '#3085d6',
                                    //     confirmButtonText: 'Okay!',
                                    // }).then((result) => {

                                    //     if (result.value) {
                        
                                            let cellone = $(row.insertCell(0));
                                            let celltwo = $(row.insertCell(1));
                                            let celltre = $(row.insertCell(2));
                                            cellone.attr("id","branch");
                                            cellone.attr("class","hidden");
                                            cellone.html(dataifsuccess.branch_id);
                                            celltwo.html(dataifsuccess.c_name);
                                            celltre.html(dataifsuccess.branch_name);
                                
                                                $('#compny').append($('<option>' ,{
                                                    value:dataifsuccess.c_name+' '+dataifsuccess.branch_name+' ALL PERMISSION',
                                                    text:dataifsuccess.c_name+' '+dataifsuccess.branch_name+' ALL PERMISSION'
                                                }));

                                                let ddlArray= new Array();
                                                let ddl = document.getElementById('compny');
                                                    
                                                    for (i = 0; i < ddl.options.length; i++) {

                                                        ddlArray[i] = ddl.options[i].value;

                                                    }

                                                        let dataSyncCompanyDefault = [];

                                                            for (i = 0; i < ddlArray.length; i++) {

                                                                dataSyncCompanyDefault.push(ddlArray[i]);
                                                            
                                                            }  
                                                
                                                SyncRolesCompany(dataSyncCompanyDefault,dataifsuccess.c_name+' '+dataifsuccess.branch_name+' ALL PERMISSION', dataifsuccess.branch_id);

                                                // celljc = $(row.insertCell(-1));
                                                // let btnRemovejc = $("<input />");
                                                //     btnRemovejc.attr("type", "button");
                                                //     btnRemovejc.attr("class", "btn btn-primary");
                                                //     btnRemovejc.attr("onclick", "RemoveBranch(this);");
                                                //     btnRemovejc.val("Remove");
                                                //     celljc.append(btnRemovejc);
                                        
                                            // }
                                        // })
                                    }
                                },
                                error: function(data){
                                    Swal({
                                        type: 'error',
                                        title: 'Terjadi kesalahan sistem..',
                                        // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                        text: "Try again, please check correct data, company can't be same!",
                                        footer: '<label href>Why do I have this issue?</label>'
                                })
                            }
                        }
                    );

                };
            }; 

            function SyncRolesCompany(dataCompanyRole, role, branchid){

                $.ajax({
                    url: "Async-super-company-all/roles/"+dataCompanyRole+'/find/'+role,
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data){
                        // Swal("Sync","Sync for user this success","success");
                         let dataxz = data.SyncRoles['permissions'];

                        // console.log(data.SyncRoles.name)
                        // console.log(data.SyncRoles['permissions'])
                        // const datax = data.SyncRoles['permissions']
                        // $.each(dataxz, function(idx, asdasd){
                            
                            // console.log(asdasd.name)
                            let datarole = [];

                            for (i = 0; i < dataxz.length; i++) {

                            datarole.push(dataxz[i]);

                            }  
                            let dataloop = [];

                            for (i = 0; i < datarole.length; i++) {

                                dataloop.push(datarole[i]);

                            } 

                            const tBody = $("#settingupmodul > TBODY")[0];
                            row = tBody.insertRow(-1);
                            let arrShipmentJ = new Array();
                            // let name_role = asdasd.name;
                            let fetch_roles = data.SyncRoles.name;

                                const convertString = fetch_roles.toString();
                                let results = convertString.replace(fetch_roles,'<center><span style="background-color:green" class="label">'+ fetch_roles +'</span></center>')

                                let tolistnextcell = function(dataloop){

                                let str = '';

                                    dataloop.forEach(function(entry) {
                                        // console.log(entry)
                                        let entrysName = entry.name;
                                        const arrayStatus = entrysName.toString();
                                            if(arrayStatus == "transport"){
                                                results = arrayStatus.replace("transport","<center><span style='background-color:blue' class='label'>TRANSPORT</span></center>")

                                            }

                                            if(arrayStatus == "warehouse"){
                                                results = arrayStatus.replace("warehouse","<center><span style='background-color:red' class='label'>WAREHOUSE</span></center>")

                                            }

                                            if(arrayStatus == "accounting"){
                                                results = arrayStatus.replace("accounting","<center><span style='background-color:green' class='label'>ACCOUNTING</span></center>")

                                            }

                                        str += '<center><ul>'+ results +'</ul></center>';

                                    });

                                return str;
                                
                            }

                                let cellrole = $(row.insertCell(0));
                                let cellidpermission = $(row.insertCell(1));
                                let cellidrole = $(row.insertCell(2));

                                // cellone.html(datacmp.name);
                                // celltwo.html(databrnch.branch);
                                cellrole.html(results);      
                                cellidpermission.html(tolistnextcell(dataloop));      
                                cellidrole.attr("id","roless");
                                cellidrole.attr("class","hidden");
                                cellidrole.html(data.RolesID);
                                
                                celljc = $(row.insertCell(-1));
                                let btnRemovejc = $("<input />");   
                                    btnRemovejc.attr("type", "button");
                                    btnRemovejc.attr("id", "removemod");
                                    btnRemovejc.attr("class", "btn btn-danger");
                                    btnRemovejc.attr("onclick", "RemoveThisModule(this);"); //belum selesai
                                    btnRemovejc.val("Remove");
                                    celljc.append(btnRemovejc);
                                    $('#fetch_sync_role').append($('<option>' ,{
                                        value:data.RolesName,
                                        text:data.RolesName
                                    }));

                                    let role_id = data.RolesID;
                                    let branch_id = branchid;
                                    let reqRolebranch = $.ajax({
                                    url: "{{ url('add-role-branch-request') }}",
                                    method: "GET",
                                    dataType: "json",
                                    data: { 
                                        role_id:role_id,
                                        branch_id:branch_id
                                    },
                                    success: function (datarolebranch) {
                                        Swal({
                                            title: 'Successfully',
                                            text: "Role branch Sync for user this success !",
                                            type: 'success',
                                            allowOutsideClick: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Okay!',
                                        }).then((result) => {
                                            if (result.value) {
                                                $('#compbranchs').append($('<option>' ,{
                                                    value:branchs,
                                                    text:branchs
                                                }));
                                            }
                                        })
                                    },
                                    error: function(data){
                                        Swal({
                                            type: 'error',
                                            title: 'Terjadi kesalahan sistem..',
                                            // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                            text: "Try again, please check correct data, company can't be same!",
                                            footer: '<label href>Why do I have this issue?</label>'
                                    })
                                }
                            }
                        );
                        // });
                    },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                            text: 'Try again, sync data Unsuccessfully!',
                            footer: '<label href>Why do I have this issue?</label>'
                        })
                        // const tables = $("#branchs")[0];
                        //         tables.deleteRow(0);
                        document.getElementsByName("compbranchs")[0].remove(0);
                        
                    }

                });

            }


    $(function () {
        $.configureBoxes();
    });

    function SettingUpModule() {

        // let type = [];
        //     let box2 = document.getElementById('warehouse');
        //     let box3 = document.getElementById('accounting');

        //     var urls = [];

        //     if (box1.checked) {
        //         urls.push(box1.value);
        //     }
            
        //     if (box2.checked) {
        //         urls.push(box2.value);
        //     }

        //     if (box3.checked) {
        //         urls.push(box3.value);
        //     }
        const setPermissionTo = $('#permission').val();
                 
        AddModules($("#fetch_company").val(),$("#fetch_branch").val(),$("#fetch_roles").val(), setPermissionTo);
            $(".cmp").empty();
            $(".fetch_roles").val('');
            $(".brnch").empty();
            $(".permiss").val('');

        };
               
        function AddModules(company, branchs, roles, permissions) {

            let cek_objects;

            // if(permissions.length !== 0){
                
            //     cek_objects = 'available';
            // } else {
            //     cek_objects = 'undefined';

            // }
                // console.log(permissions)
            // cek_objects == 'undefined'

            if (! roles || ! permissions)  {

               const alerts = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6000
                        });

                alerts({

                    title: 'Maaf masih inputannya masih ada yang kosong !'

                })  

            } else {
       
                let fetch_roles = roles;
                let giveToPermission = permissions;
             
                    $.ajax({
                        url: "{{url('request-form-roles-users')}}",
                        headers:
                        {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            fetch_roles:fetch_roles,
                            giveToPermission:giveToPermission
                        },
                        type: 'GET',
                        dataType: 'JSON',
                        success: function (ajax){

                    const tBody = $("#settingupmodul > TBODY")[0];
                        row = tBody.insertRow(-1);
                            let arrShipmentJ = new Array();
                                $('#fetch_roles').val('');

                                // $.get('find-request-companies/find/'+ company, function(datacmp){
                                //     $.get('find-request-branchs/find/'+ branchs, function(databrnch){

                                    // $.get('find-request-roles/find/'+ roles, function(datarls){
                                        let roles = fetch_roles; 
                                        let Permissions = giveToPermission;
                                    $('#fetch_sync_role').append($('<option>' ,{
                                        value:roles,
                                        text:roles
                                    }));

                                    let ddlArray= new Array();
                                    let ddl = document.getElementById('fetch_sync_role');
                                    
                                    for (i = 0; i < ddl.options.length; i++) {

                                        ddlArray[i] = ddl.options[i].value;

                                    }

                                        let datarole = [];

                                            for (i = 0; i < ddlArray.length; i++) {

                                                datarole.push(ddlArray[i]);
                                            
                                            }  

                                        // console.log(datarole)
                                        // let names = datarls.name; 
                                        const convertString = roles.toString();
                                        let results = convertString.replace(fetch_roles,'<center><span style="background-color:green" class="label">'+ fetch_roles +'</span></center>')

                                        // const convertgiving = Permissions.toString();
                                        // let givePermissionTo = convertgiving.replace(giveToPermission,'<center><span style="background-color:blue" class="label">'+ Permissions +'</span></center>')

                                        let tolistnextcell = function(Permissions){
                                        let str = '';
                                        let ds, bs, dh;
                                        let arrays = [];
                                        let arraysx = [];
                                        Permissions.forEach(function(entry) {

                                            const arrayStatus = entry.toString();

                                                // let results = arrayStatus.replace(fetch_roles,'<center><span style="background-color:green" class="label">'+ Permissions +'</span></center>')
                                                // let done = results.replace(/[0-8]/g, '')

                                                if(arrayStatus == "transport"){
                                                    results = arrayStatus.replace("transport","<center><span style='background-color:blue' class='label'>TRANSPORT</span></center>")

                                                }

                                                if(arrayStatus == "warehouse"){
                                                    results = arrayStatus.replace("warehouse","<center><span style='background-color:red' class='label'>WAREHOUSE</span></center>")

                                                }

                                                if(arrayStatus == "accounting"){
                                                    results = arrayStatus.replace("accounting","<center><span style='background-color:green' class='label'>ACCOUNTING</span></center>")

                                                }

                                            str += '<center><ul>'+ results +'</ul></center>';

                                        });

                                        return str;
                                    }
                                        // const convertString = id.toString();
                                        // if(convertString == "15"){
                                        //     results = convertString.replace("15","<center><span style='background-color:green' class='label'>[3PL] OPRASONAL TRANSPORT</span></center>")

                                        // }

                                        // if(convertString == "2"){
                                        //     results = convertString.replace("2","<center><span style='background-color:green' class='label'>[3PL] OPRASONAL TC & WHS</span></center>")

                                        // }

                                        // if(convertString == "14"){
                                        //     results =  convertString.replace("14","<center><span style='background-color:green' class='label'>[3PL] OPRASONAL WAREHOUSE</span></center>")

                                        // }

                                        // if(convertString == "16"){
                                        //     results = convertString.replace("16","<center><span style='background-color:green' class='label'>[3PL] ACCOUNTING WHS & TC</span></center>")

                                        // }

                                        // if(convertString == "12"){
                                        //     results = convertString.replace("12","<center><span style='background-color:green' class='label'>[3PL] ACCOUNTING WAREHOUSE</span></center>")

                                        // }

                                        // if(convertString == "17"){
                                        //     results = convertString.replace("17","<center><span style='background-color:green' class='label'>[3PL] ACCOUNTING TC</span></center>")

                                        // }

                                        // if(convertString == "18"){
                                        //     results = convertString.replace("18","<center><span style='background-color:green' class='label'>[3PE] OPRASONAL TRANSPORT</span></center>")

                                        // }

                                        // if(convertString == "19"){
                                        //     results = convertString.replace("19","<center><span style='background-color:green' class='label'>[3PL] OPRASONAL KASIR</span></center>")

                                        // }

                                        // if(convertString == "20"){
                                        //     results = convertString.replace("20","<center><span style='background-color:green' class='label'>[3PE] OPRASONAL KASIR</span></center>")

                                        // }

                                        // if(convertString == "21"){
                                        //     results = convertString.replace("21","<center><span style='background-color:green' class='label'>[3PL] DRIVER</span></center>")

                                        // }

                                        // if(convertString == "22"){
                                        //     results = convertString.replace("22","<center><span style='background-color:green' class='label'>[3PE] DRIVER</span></center>")

                                        // }

                                        // if(convertString == "23"){
                                        //     results = convertString.replace("23","<center><span style='background-color:green' class='label'>[3PL] SUPERVISOR</span></center>")

                                        // }

                                        // if(convertString == "24"){
                                        //     results = convertString.replace("24","<center><span style='background-color:green' class='label'>[3PE] SUPERVISOR</span></center>")

                                        // }

                                        // let cellone = $(row.insertCell(0));
                                        // let celltwo = $(row.insertCell(1));
                                        let cellrole = $(row.insertCell(0));
                                        let cellidpermission = $(row.insertCell(1));
                                        let cellidrole = $(row.insertCell(2));

                                        // cellone.html(datacmp.name);
                                        // celltwo.html(databrnch.branch);
                                        cellrole.html(results);      
                                        cellidpermission.html(tolistnextcell(permissions));      
                                        cellidrole.attr("id","roless");
                                        cellidrole.attr("class","hidden");
                                        cellidrole.html(ajax.role);
                                        SyncRole(datarole,ajax.role,company, branchs)
                                        
                                        celljc = $(row.insertCell(-1));
                                        let btnRemovejc = $("<input />");   
                                            btnRemovejc.attr("type", "button");
                                            btnRemovejc.attr("id", "removemod");
                                            btnRemovejc.attr("class", "btn btn-danger");
                                            btnRemovejc.attr("onclick", "RemoveThisModule(this);"); //belum selesai
                                            btnRemovejc.val("Remove");
                                        // let adasdxzcz = $("<input />");
                                        //     adasdxzcz.attr("type", "button");
                                        //     adasdxzcz.attr("id", ajax.role);
                                        //     adasdxzcz.attr("value", );
                                        //     adasdxzcz.attr("class", "btn btn-primary ModalAccountBillingClass");
                                        //     adasdxzcz.attr("data-target", "#ModalAccountBilling");
                                        //     adasdxzcz.attr("data-toggle", "modal");
                                        //     adasdxzcz.attr("onclick", "ModalSetting(this.id);");
                                        //     adasdxzcz.val("Users");

                                            // celljc.append(adasdxzcz);
                                            celljc.append(btnRemovejc);
                                            $("#roles").val(ajax.role);


                                    // });
                            //     });
                            // });

                        },
                        error: function(data){
                                Swal({
                                    type: 'error',
                                    title: 'Error system..',
                                    // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                                    text: 'Try again, The system detects duplicate data flows!',
                                    footer: 'Contact Developer for help you !'
                            })
                            $('#fetch_roles').val('');
                        }
                    });
                };
            }; 

            function SyncRole(Roles, role_id, perusahaan, cabang){

                $.ajax({
                    url: "Async-super-user-roles/roles/"+Roles+"/role/"+role_id+"/branch/"+cabang,
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data){

                       Swal("Sync","Sync for user this success","success");

                    },
                    error: function(data){
                        Swal({
                            type: 'error',
                            title: 'Terjadi kesalahan sistem..',
                            // text: 'Anda tidak bisa menambahkan shipment pada vendor ini, silahkan tambahkan data pada Vendor Item Transport!',
                            text: 'Try again, please check correct data!',
                            footer: '<label href>Why do I have this issue?</label>'
                        })
                    }

                });
            }

        function RemoveCompany(button) {

            let rowx = $(button).closest("TR");
            const id = $("TD", rowx).eq(0).html();
            const Company = $("TD", row).eq(1).html();
 
            Swal({
            title: 'Successfully Deleted',
            text: "Your file has been deleted.!",
            type: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Okay!',
                }).then((result) => {

                    if (result.value) {

                    $.ajax({

                            url: "request-deleted-companies/find/"+id,
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'JSON',
                            success: function (){

                                const tables = $("#companys")[0];
                                tables.deleteRow(rowx[0].rowIndex);

                            }

                    });

                }

            })
                   
            document.getElementsByName("company_vals")[0].remove(0);
     
        };


        function RemoveThisModule(button) {

            let rowx = $(button).closest("TR");
            const roleid = $("TD", rowx).eq(2).html();
            const ROLE_NAME = $("TD", rowx).eq(0).html();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "find-request-deleted-roles/find/"+roleid,
                        headers:
                        {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'GET',
                        dataType: 'JSON',
                        success: function (data){
                            const tables = $("#settingupmodul")[0];
                            if(data.response == "true"){
                                tables.deleteRow(rowx[0].rowIndex);
                                $("#fetch_sync_role option[value='" + data.success_deleted + "']").remove();
                                Swal.fire(
                                    'Success !',
                                    'This roles has been remove.',
                                    'success'
                                )
                            } 
                                else {
                                Swal({
                                        type: 'error',
                                        title: 'Error delete roles..',
                                        text: "You you cannot delete all initials!",
                                        footer: '<label>Why do I have this issue?</label>'
                                })
                            }
                        }
                    });
                }
            })
        };

        function RemoveBranch(button) {

            let rowx = $(button).closest("TR");
            const id = $("TD", rowx).eq(0).html();
            const cmpny = $("TD", rowx).eq(1).html();
            const branch = $("TD", rowx).eq(2).html();
   
            Swal({
                    title: 'Successfully Deleted',
                    text: "Your file has been deleted.!",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Okay!',
                }).then((result) => {
                    if (result.value) {

                        $.ajax({

                                url: "request-deleted-companies/find/"+id,
                                headers:
                                {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: 'GET',
                                dataType: 'JSON',
                                success: function (){

                                    const tables = $("#companys")[0];
                                        tables.deleteRow(rowx[0].rowIndex);

                                }

                        });
                
                    }

                })

                const tables = $("#branchs")[0];
                tables.deleteRow(rowx[0].rowIndex);
                
            document.getElementsByName("compbranchs")[0].remove(0);
     
        };
   </script>
@endsection

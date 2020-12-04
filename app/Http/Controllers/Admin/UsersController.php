<?php

namespace warehouse\Http\Controllers\Admin;

use Auth;
use Hash;
use Carbon\Carbon;
use warehouse\User;
use warehouse\Models\Item;
use Illuminate\Support\Str;
use warehouse\Models\Roles;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Companies;
use warehouse\Models\Role_branch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Requests\Admin\StoreUsersRequest;
use warehouse\Http\Requests\Admin\UpdateUsersRequest;
use warehouse\Http\Requests\Admin\SavedRolesSuperUser;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class UsersController extends Controller
{
    protected $APIusers;
    protected $jagal_squad;
    protected $perusahaan;
    
    public function __construct(RESTAPIs $apiusers, Companies $perusahaantbl, Request $REST)
    {
        $this->perusahaan = $perusahaantbl;
        $this->APIusers = $apiusers;
        $this->jagal_squad = $REST;
    }
    
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
    {
        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        if ($results == "administrator") {

            // if (! Gate::denies('warehouse') || ! Gate::denies('transport') || ! Gate::denies('accounting')) {
            //     return abort(401);
            // }
        
            $users = User::all();
            $alert_items = Item::where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
            $system_alert_item_vendor = Vendor_item_transports::with(
                'vendors',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            // if($AUht)
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                'customers',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
    
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
    
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
    
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
    
            return view('admin.administrator.users.index', [
                'menu'=>'Users List',
                'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                'some' => $this->jagal_squad->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_items' => $alert_items,
                'apis' => $results,
                'alert_customers' => $alert_customers])
                ->with(compact('users', 'prefix'));
        } else {

                 
                        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || !Gate::denies('accounting')) {
            //     return abort(401);
            // }

            // if($results == "super_users"){
                
            // $users = User::whereIn('parent_id', [Auth::User()->id])->orWhere('company_branch_id', $branch_id)->get();
            $users = User::whereIn('parent_id', [Auth::User()->id])->get();
            // dd($users);
            $alert_items = Item::where('flag', 0)->get();
            $prefix = Company_branchs::users($branch_id)->first();
            $system_alert_item_vendor = Vendor_item_transports::with(
                            'vendors',
                            'city_show_it_origin',
                            'city_show_it_destination'
                        )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                            'customers',
                            'city_show_it_origin',
                            'city_show_it_destination'
                        )->where('flag', 0)->get();
                
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
                
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
                
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
                
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
                
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                            
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();

            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
                
            return view('admin.administrator.users.index', [
                            'menu'=>'Create User Role',
                            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                            'some' => $this->jagal_squad->session()->get('id'),
                            'api_v1' => $responsecallbackme['api_v1'],
                            'api_v2' => $responsecallbackme['api_v2'],
                            'system_alert_item_vendor' => $system_alert_item_vendor,
                            'system_alert_item_customer' => $data_item_alert_sys_allows0,
                            'alert_items' => $alert_items,
                            'apis' => $results,
                            'alert_customers' => $alert_customers])
                            ->with(compact('users', 'prefix', 'cek_super_user_by_owner'));
        }
    }


    public function loadcompanies($id)
    {
        $dumpid = explode(",", $id);
        $tempArray = array();
        foreach ($dumpid as $key=>$value) {
            $tempArray[$key] = $value;
        }

        $data = Companies::select('id', 'name')->whereIn('name', $tempArray)->get();
        //   dd($data);die;

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($results);
    }

    public function loadbyfindcompanies($id)
    {
        $data = Companies::select('id', 'name')->where('id', $id)->get();

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($data);
    }

    public function loadbyfindbranch($id)
    {
        $data = Company_branchs::with('company')->where('id', $id)->get();

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($data);
    }

    public function searchbranchautomatic(Request $request, Int $id)
    {
        $search = $request->q;

        // $companysbranch = Company_branchs::orderby('branch','asc')->whereHas('company', function (Builder $query) use($search, $id){
        //     $query->where('name', '=', $id)->where('branch', 'like', '%' .$search. '%')->limit(7);
        // })->get();

        $companysbranch = Company_branchs::orderby('branch', 'asc')->whereIn('company_id', [$id])->where('branch', 'LIKE', "%$search%")->get();

        $response = array();

        foreach ($companysbranch as $cabang) {
            // $response[] = array("value"=>$cabang->branch);
            $response[] = $cabang;

        }
        
        return response()->json($response);

        // echo json_encode($response);
        // exit;
    }

    public function searchroles(Request $request)
    {
        $search = $request->search;

        // $companysbranch = Company_branchs::orderby('branch','asc')->whereHas('company', function (Builder $query) use($search, $id){
        //     $query->where('name', '=', $id)->where('branch', 'like', '%' .$search. '%')->limit(7);
        // })->get();

        $roles = Role::orderby('name', 'asc')->where('name', 'like', '%' .$search. '%')->get();

        $response = array();

        foreach ($roles as $term) {
            $response[] = array("value"=>$term->name);
        }
  
        echo json_encode($response);
        exit;
    }

    public function deletecompanies(Companies $cmp, $id)
    {
        $dml = $cmp->findOrFail($id);
        $dml->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function superusersdeleteusers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'success' => 'User deleted successfully!'
        ]);
    }

    public function getUser(User $model_roles, $id)
    {
        $fetchOd = explode(",", $id);

        // $userDetail = $model_roles->find(1)->goals();
        // $model_roles->goals();
        // $roles =find(1);
        $comment =  $model_roles->find(80);

        $commentable = $comment->modelsgetch;
        // foreach ($comment->modelsgetch as $comment) {
        //     //
        //     $fetch_role = $comment->model_id;
        //     echo
        // }
        // $posts = $model_roles->has('modelsgetch')->get();
        // dd($commentable);
        // $user_test = $model_roles->find($fetch_role);
// echo $fetch_role
        // dd($commentable);

// $team = $user->goals->first();
// $teamRole = $team->pivot->teamRole;
        //   $model_roles->with(array('modelhasrole'=>function($query) use ($fetchOd){
        //     $query->whereIn('model_id', $fetchOd);
        // }))->first();
        // $userDetail = $model_roles->with('modelhasrole' function (Builder $query) use($fetchOd){
        // $query->whereIn('model_id', $fetchOd);
        // })->get();
        // dd($user);die;
        // foreach ($roles->hasRolesdxc as $role) {
        //     echo $role->pivot->created_at;
        // }
        // dd($commentable);
        // dd($roles);die;

        // foreach ($user->hasRole as $role)
        //     {
        //        $dasd = $role;

        //     }
        // return response()->json($dasd);
    }

    public function create_object_company($id)
    {
        $foo = [];

        $datax = explode(",", $id);
        // dd($datax);die;
        //     foreach($datax as $key => $data_object){

        //             array_push($foo, (object)[
        //                 'id'=> $key,
        //                 'company' => $data_object
                    
        //         ]);
        //     }
        $data = Companies::select('id', 'name')->whereIn('id', $datax)->get();

        foreach ($data as $query) {
            $results[] = $query;
        }

        return response()->json($results);
        // return response()->json($foo);

            // make company and branch exists
        //     foreach($foo as $key => $arr){
        //         $self[] = $arr->company;
        // }
        // $sdxc = ",", $self);
        // if (in_array("asdasd", $self)) {
        //     echo "found";
        // } else {
        //     echo "not found";
        // }
            // die;
    }

    public function CompanyObj(Request $r)
    {
        $data = Companies::select('id', 'name')->where('name', 'LIKE', "%$r->q%")->get();


        foreach ($data as $query) {
            $results[] = $query;
        }

        if(!isset($results)){
            $results = [];
        }

        return response()->json($results);
    }

    public function add_companyenv__(Request $request, Companies $comp, $id)
    {
        // $company = $comp->firstOrcreate([
        //     'name' => $request->get('company'),
        //     'owner_id' => Auth::User()->id,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // $update = User::findOrFail(Auth::User()->id);
        // $update->company_id = $company->id;
        // $update->save();
        $searchcompany = $comp->findOrFail($id);


        return response()->json(
            [
                'company_N' => $searchcompany->name,
                'company_ID' => $searchcompany->id
            ]
        );
    }

    public function add_branchenv__(Request $request, Company_branchs $brnch)
    {

        // CHECK ROLE UNIQUE WITH BRANCH [ PROGRESS ] -> ROLE -> BRANCH -> COMPANY
        $searchcompany = Companies::findOrFail($request->get('company_id'));
        $companysbranch = Company_branchs::findorFail($request->get('brnch'));


        $cek_roles = ($searchcompany->name.' '.$companysbranch->branch.' '.'ALL PERMISSION');
        // $cek_roles = ($searchcompany->name.' '.$request->get('brnch').' '.'ALL PERMISSION');
        // dd($cek_roles);die;

        // if (Roles::where('name', $cek_roles)->count() > 0) {
        //     // return "ada";
        //     return response()->json(
        //         [
        //             'errors' => 'failed'
        //         ]
        //     );
        // } else {
            // return "ga ada";
            // $branch = $brnch->firstOrcreate([
            //     'branch' => $request->get('brnch'),
            //     'company_id' => $request->get('company_id'),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]);
    
            $data = Companies::where('id', $request->get('company_id'))->first();
    
    
            foreach ($data as $query) {
                $results[] = $query;
            }
    
            // $update = User::findOrFail(Auth::User()->id);
            // $update->company_branch_id = $companysbranch->id;
            // $update->save();
    
            return response()->json(
                [
                    'branch_id' => $companysbranch->id,
                    'branch_name' => $companysbranch->branch,
                    'c_name' => $data->name,
                ]
            );
        // }
        // die;
        // dd($request->get('brnch'),$request->get('company_id'));die;
    }

    public function add_role_branch(Request $request, Role_branch $brnch)
    {
        $branch = $brnch->firstOrcreate([
            'user_id' => Auth::User()->id,
            'branch_id' => $request->get('branch_id'),
            'role_id' => $request->get('role_id')
        ]);

        return response()->json(
            [
                'role_branch' => $branch
            ]
        );
    }

    public function registerUsers(Request $request)
    {
        
       
        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || Gate::denies('accounting')) {
        //     return abort(401);
        // }

        $dataARR = implode(",", $request->get('perusahaan'));
        $dataALL = implode(",", $request->get('cabang'));
        $ConvertsArrayString = explode(",", $dataARR);
        $ConvertArrayBranch = explode(",", $dataALL);

            
        foreach ($ConvertsArrayString as $key => $value) {
            $tempArray = $value;
        }
         
        $ConvertsArrayString = $tempArray;

        foreach ($ConvertArrayBranch as $key => $value) {
            $tempArray0 = $value;
        }
        
        $ConvertArrayBranch = $tempArray0;
        
        $expired = date('Y-m-d H:i:s', strtotime('+1 day'));

        // $user = New User();
        // $user->name = $request->get('name');
        // $user->email =$request->get('email');
        // $user->company_id =$ConvertsArrayString;
        // $user->company_branch_id = $ConvertArrayBranch;
        // $user->password = app('hash')->needsRehash($request->get('password')) ? Hash::make($request->get('password')) : $request->get('password');
        // $user->active = 1;
        // $user->token_register = $request->get('token');
        // $user->parent_id = Auth::User()->id;
        // $user->expired_at = $expired;
        // $user->save();
        $user = User::create([

            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'company_id' => $ConvertsArrayString,
            'company_branch_id' => $ConvertArrayBranch,
            'password' => app('hash')->needsRehash($request->get('password')) ? Hash::make($request->get('password')) : $request->get('password'),
            'active' => 1,
            // 'token_register' => $request->get('token'),
            'token_register' => Str::random(100),
            'parent_id' => Auth::User()->id,
            'expired_at' => $expired


        ]);
        $roles = $request->input('roles') ? $request->input('roles') : [];

        // dd($roles);die;
        $user->assignRole($roles);

        return response()->json([
                'success' => "User ". $request->get('email') ." berhasil didaftarkan, silahkan login untuk verifikasi",
                'users' => $user,
                'user_news' => $user->id,
                'names' => $user->name,
                'user_email' => $user->email
            ]);

        // foreach($ConvertsArrayString as $elx =>$kantor) {
        //     $dataregister[] = [
        //         'name' => $request->get('name'),
        //         'email' =>  $request->get('email'),
        //         'company_id' => $kantor,
        //         'company_branch_id' => $ConvertArrayBranch[$elx],
        //         'password' => app('hash')->needsRehash($request->get('password')) ? Hash::make($request->get('password')) : $request->get('password'),
        //         'token_register' => $request->get('token'),
        //         'parent_id' => Auth::User()->id,
        //         'expired_at' => $expired
        //     ];
        // }

        // $user = User::create($dataregister);
    }

    public function byfindbranchsftech($id)
    {
        $data = Company_branchs::select('id', 'branch')->where('company_id', $id)->get();

        foreach ($data as $query) {
            $results[] = $query;
        }

        return response()->json($data);
    }

    public function loadcompanybranch()
    {
        $data = Company_branchs::select('id', 'branch')->get();

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($data);
    }

    public function findcompanyId($compid)
    {
        $data = Companies::select('id', 'name')->where('id', $compid)->first();

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($data);
    }

    public function findrolesId($roleId)
    {
        $data = Roles::select('id', 'name')->where('id', $roleId)->first();

        foreach ($data as $query) {
            $results[] = $query;
        }
        return response()->json($data);
    }

    public function findbranchId($brnchid)
    {
        $data = Company_branchs::select('id', 'branch')->where('id', $brnchid)->first();

        foreach ($data as $query) {
            $results[] = $query;
        }

        return response()->json($data);
    }

    public function LoadBranchwithcompanysuperuser($id)
    {
        session(['company_id' => $id]);
        foreach (Auth::User()->roles as $name_roles) {
            $names[] = $name_roles->id;
            $role[] = $name_roles->name;
        }
                $companysbranch = Role_branch::with('modelhasbranch.company')->whereHas('modelhasbranch.company', function (Builder $query) {
                    return $query->where('user_id', Auth::User()->id)->addSelect('branch_id');
                })->get();

        if ($companysbranch->isEmpty()) {
            $companysbranchs = Company_branchs::with('company')->where(function (Builder $query) use ($id) {
                return $query->whereIn('company_id', [$id]);
            })->get();

                return response()->json($companysbranchs);
        
            } 
                else {

                    foreach ($companysbranch as $names_branch) {
                        $company_branch[] = $names_branch->modelhasbranch->id;
                    }
                
                $companysbranchx = Company_branchs::with('company')->where(function (Builder $query) use ($id, $company_branch) {
                    return $query->whereIn('company_id', [$id])
                    ->whereIn('id', $company_branch);
                })->get();
            
            return response()->json($companysbranchx);
        }
        
    }

    public function updateSettingUserBranch(User $pengguna, $company, $branch, Role_branch $role_branch)
    {
        $InterfaceRepository = app(AccuratecloudInterface::class)->FuncOpenmoduleAccurateCloudUsersBranchId();
        if(isset($InterfaceRepository["s"]) == true) {

            if(Auth::User()->oauth_accurate_company == "146583"){

                $branchAccruateId = $InterfaceRepository['d'][0]['id']; //Surabaya
                $branchAccruateIdJKT = $InterfaceRepository['d'][1]['id']; //Jakarta
                $branchAccruateIdKPG = $InterfaceRepository['d'][2]['id']; //Kupang
                $branchAccruateIdLodi = $InterfaceRepository['d'][3]['id']; //Lodi
                $branchAccruateIdSMG = $InterfaceRepository['d'][4]['id']; //Semarang
                $branchAccruateIdPusat = $InterfaceRepository['d'][5]['id']; //Pusat
                session(['UserMultiBranchAccurate' => $branchAccruateId]);
                session(['UserMultiBranchAccurateJKT' => $branchAccruateIdJKT]);
                session(['UserMultiBranchAccurateKPG' => $branchAccruateIdKPG]);
                session(['UserMultiBranchAccurateSMG' => $branchAccruateIdSMG]);
                session(['UserMultiBranchAccuratePusat' => $branchAccruateIdPusat]);
                session(['UserMultiBranchAccurateLodi' => $branchAccruateIdLodi]);

            }

            if(Auth::User()->oauth_accurate_company == "146584"){

                    $branchAccruateId = $InterfaceRepository['d'][0]['id']; //Surabaya
                    $branchAccruateIdJKT = $InterfaceRepository['d'][1]['id']; //Jakarta
                    $branchAccruateIdSMG = $InterfaceRepository['d'][2]['id']; //Semarang
                    $branchAccruateIdKPG = $InterfaceRepository['d'][3]['id']; //Kupang
                    $branchAccruateIdPusat = $InterfaceRepository['d'][4]['id']; //Pusat
                    session(['UserMultiBranchAccurate' => $branchAccruateId]);
                    session(['UserMultiBranchAccurateJKT' => $branchAccruateIdJKT]);
                    session(['UserMultiBranchAccurateKPG' => $branchAccruateIdKPG]);
                    session(['UserMultiBranchAccurateSMG' => $branchAccruateIdSMG]);
                    session(['UserMultiBranchAccuratePusat' => $branchAccruateIdPusat]);

                }

            $fetch_users = $role_branch->where('branch_id', $branch)->first(); 
            if(!isset($fetch_users->branch_id)){
                
                $branchsInternal = null;
                session(['branchNotfound' => "branch can't found in your company"]);
                
            } else {
                $branchsInternal = $fetch_users->branch_id;
                session()->forget('branchNotfound');

                session(['id' => $branchsInternal]);
            }

        } else 
                {

                    if(json_decode($InterfaceRepository, JSON_PRETTY_PRINT)['error'] == "invalid_token"){

                        $fetch_users = $role_branch->where('branch_id', $branch)->first(); $branchsInternal = $fetch_users->branch_id;
                        session(['id' => $branchsInternal]);
                
                        \Session::flash('alert-invalid-token', "akun tidak teridentifikasi.");
        
                    } 
            }
        return response()->json($branchsInternal);
    }

    public function load_with_roles(Roles $role, Request $request)
    {
        $cari = $request->q;

        $data = $role->select('id', 'name')->where('name', 'LIKE', "%".$cari."%")->WhereNotIn('id', [1,25])->get();

        foreach ($data as $query) {
            $results[] = $query;
        }
            
        return response()->json($data);
    }

    public function superuser()
    {

       
        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || Gate::denies('accounting')) {
        //     return abort(401);
        // }

        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        if ($results == "administrator") {
            $users = User::all();
            $alert_items = Item::where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
            $system_alert_item_vendor = Vendor_item_transports::with(
                'vendors',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            // if($AUht)
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                'customers',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
    
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
    
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
    
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
    
            return view('admin.administrator.super_user.supersusers', [
                'menu'=>'Users List',
                'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                'some' => $this->jagal_squad->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_items' => $alert_items,
                'apis' => $results,
                'alert_customers' => $alert_customers])
                ->with(compact('users', 'prefix'));
        } else {


            // if($results == "super_users"){
        
            $users = User::whereIn('parent_id', [Auth::User()->id])->get();
                
            $alert_items = Item::where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
            $system_alert_item_vendor = Vendor_item_transports::with(
                    'vendors',
                    'city_show_it_origin',
                    'city_show_it_destination'
                )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                    'customers',
                    'city_show_it_origin',
                    'city_show_it_destination'
                )->where('flag', 0)->get();
        
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
        
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
        
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                    
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();

            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
        
            return view('admin.administrator.super_user.supersusers', [
                    'menu'=>'Setting Up Role',
                    'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                    'some' => $this->jagal_squad->session()->get('id'),
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'system_alert_item_customer' => $data_item_alert_sys_allows0,
                    'alert_items' => $alert_items,
                    'apis' => $results,
                    'alert_customers' => $alert_customers])
                    ->with(compact('users', 'prefix', 'cek_super_user_by_owner'));
        }
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id, Role $Spatie_role, Role_branch $roleBranch)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        
        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || !Gate::denies('accounting')) {
        //     return abort(401);
        // }


        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        // $roles = Role::get();
        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        if ($results=="administrator") {
            $roles = $Spatie_role->select('id', 'name')->get();

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
    
            $system_alert_item_vendor = Vendor_item_transports::with(
                'vendors',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $alert_items = Item::where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                'customers',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
            
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
    
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
    
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }
    
            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();
    
            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }
    
            return view('admin.administrator.users.create', [
                'menu'=>'Create User List',
                'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                'some' => $this->jagal_squad->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'alert_items' => $alert_items,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers])
            ->with(compact('roles', 'prefix', 'cek_super_user_by_owner'));
        } else {
            // if($results=="super_users")
            $id = Auth::User()->id;
            
            $role_branch = $roleBranch->with('modelhasuser', 'modelhasrole', 'modelhasbranch.company')->where(function (Builder $query) use ($id) {
                return $query->whereIn('user_id', [$id]);
            })->get();

            // $roles = $roleBranch->select('id','name')->get();
            foreach ($role_branch as $role_as_branch) {
                # code...
                            $fetch_roles[] = $role_as_branch->modelhasrole; //this fetch role name
                            $fetch_branch[] = $role_as_branch->modelhasbranch->branch; // this fetch branch name
                            $fetch_company[] = $role_as_branch->modelhasbranch->company->name; // this fetch company name
            }

            $roles = $fetch_roles;
            // dd($roles);die;

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
                
            $system_alert_item_vendor = Vendor_item_transports::with(
                            'vendors',
                            'city_show_it_origin',
                            'city_show_it_destination'
                        )->where('flag', 0)->get();
            $alert_items = Item::where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                            'customers',
                            'city_show_it_origin',
                            'city_show_it_destination'
                        )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
                        
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
                
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
                
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
                
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
                
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                            
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }
                
            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();
                
            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }
                
            return view('admin.administrator.users.create', [
                            'menu'=>'Create User List',
                            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                            'some' => $this->jagal_squad->session()->get('id'),
                            'api_v1' => $responsecallbackme['api_v1'],
                            'api_v2' => $responsecallbackme['api_v2'],
                            'system_alert_item_vendor' => $system_alert_item_vendor,
                            'alert_items' => $alert_items,
                            'system_alert_item_customer' => $data_item_alert_sys_allows0,
                            'alert_customers' => $alert_customers])
                        ->with(compact('roles', 'prefix', 'cek_super_user_by_owner'));
        }
    }

    public function loaded_company_branch(Request $request, Company_branchs $cabang)
    {
        $cari = $request->q;

        $data = $cabang->select('id', 'branch')->where('branch', 'LIKE', "%".$cari."%")->groupBy('branch')->get();
        
        foreach ($data as $query) {
            $results[] = ['value' => $query];
        }
        
        return response()->json($data);
    }

    public function GetClientToken()
    {
        $alert_items = Item::where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with(
            'vendors',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with(
            'customers',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        return view('admin.passportviews', [
            'menu' => 'Personal Client',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers
        ])->with(compact('user', 'role', 'prefix'));
    }

    public function load_uuid_company_branch(Company_branchs $cb, $id)
    {
        $data = $cb->findOrFail($id);
        foreach ($data as $query) {
            $results[] = ['value' => $query];
        }
        return response()->json($data);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request, Role_branch $brnch, $branch_id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

       
        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || Gate::denies('accounting')) {
        //     return abort(401);
        // }

        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }

        $expired = date('Y-m-d H:i:s', strtotime('+1 day'));
        
        if (Auth::User()->id === Auth::User()->id) {
            $Authorized = Auth::User()->roles;

            foreach ($Authorized as $key => $checkaccess) {
                # code...
                $results = $checkaccess->name;
            }

            if ($results == "administrator") {
                /*
                | administrator akan memberikakn user secara default alias masih kosongan.
                */
                $user = User::create($request->all());

                $user->expired_at = $expired;
                $user->parent_id = Auth::User()->id;
                $user->save();
                $roles = array('super_users');
                $user->assignRole($roles);

                swal()
                    ->toast()
                        ->autoclose(9000)
                            ->message("Success Created", "[DEVELOPER] Congratulation You create new user !", 'success');
            }

            // else {

                // // if($results == "super_users"){

                //     // foreach ((array)$request->input('roles') as $key => $roles) {
                //     //     # code...
        
                //     //         if($roles == "1"){
                //     //             swal()
                //     //             ->toast()
                //     //                     ->autoclose(9000)
                //     //                 ->message("Danger", "Sorry you can't role administrator !", 'error');
                                
                //     //         }
                //     //             else {
                //             // dd();die;
                //                 $user = User::create($request->all());
                //                 $user->expired_at = $expired;
                //                 $user->parent_id = Auth::User()->id;
                //                 $user->save();
                //                 $roles = $request->input('roles') ? $request->input('roles') : [];
                //                 $user->assignRole($roles);
                //                 // optional
                //                 // $user->save();
                //                 // $cek_super_user = $brnch->with(['modelhasrole','modelhasbranch.modeltorolebranch'])->whereIn('role_id', $roles)->get();

                //                 // foreach($cek_super_user as $fetchBranch){

                //                 //     $data_branch[] = $fetchBranch->modelhasbranch->id;
                //                 //     $data_branch_id_default = $fetchBranch->modelhasbranch->id;
                //                 //     $data_company_id_default = $fetchBranch->modelhasbranch->company_id;

                //                 // }

                //                 // foreach($data_branch as $fooindex => $arrayBRANCH) {
                //                 //     $brnch->firstOrcreate([
                //                 //         'user_id' => $user->id,
                //                 //         'branch_id' => $arrayBRANCH,
                //                 //         'role_id' => $roles[$fooindex]
                //                 //     ]);
                //                 // }

                //                 // $setBranchbyDefault = User::findOrFail($user->id);
                //                 // $setBranchbyDefault->company_branch_id = $data_branch_id_default;
                //                 // $setBranchbyDefault->company_id = $data_company_id_default;
                //                 // $setBranchbyDefault->save();

                //                 swal()
                //                 ->toast()
                //                     ->autoclose(9000)
                //                         ->message("Success Created", "[SUPER USER] Congratulation You create new user !", 'success');
                //         // }
                //     }
        }
        // }

        return redirect()->route('users.create.index', $branch_id);
    }

    public function createUserNew($branch_id, Request $request, Role_branch $branch)
    {

              // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

       
        // if (! Gate::denies('transport') || ! Gate::denies('warehouse') || Gate::denies('accounting')) {
        //     return abort(401);
        // }

        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        // optional
        // $user->save();
       

        // $setBranchbyDefault = User::findOrFail($user->id);
        // $setBranchbyDefault->company_branch_id = $data_branch_id_default;
        // $setBranchbyDefault->company_id = $data_company_id_default;
        // $setBranchbyDefault->save();

        $expired = date('Y-m-d H:i:s', strtotime('+1 day'));

        $user = User::create($request->all());
        $user->expired_at = $expired;
        $user->parent_id = Auth::User()->id;
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
        $user->update();

         $cek_super_user = $branch->with(['modelhasrole','modelhasbranch.modeltorolebranch'])->whereIn('role_id', $roles)->get();

        foreach($cek_super_user as $fetchBranch){

            $data_branch[] = $fetchBranch->modelhasbranch->id;
            $data_branch_id_default = $fetchBranch->modelhasbranch->id;
            $data_company_id_default = $fetchBranch->modelhasbranch->company_id;

        }

        foreach($data_branch as $index => $arrayBRANCH) {
            $branch->firstOrcreate([
                'user_id' => $user->id,
                'branch_id' => $arrayBRANCH,
                'role_id' => $roles[$index]
            ]);
        }

        swal()
            ->toast()
                ->autoclose(9000)
                    ->message("Success Created", "[SUPER USER] Congratulation You create new user !", 'success');
        return redirect()->route('users.create.index', $branch_id);
    }

    public function AddRolesAccessSuperusers(SavedRolesSuperUser $request)
    {
        $role = Role::create(['name' => $request->get('fetch_roles')]);
        $permissions = $request->get('giveToPermission');
        $role->givePermissionTo($permissions);


        return response()->json([
            'role' => $role->id
        ]);
    }

    public function SuperUserDeletedRole($id)
    {
        $role = Role::findOrFail($id);
        $string = 'ALL PERMISSION';
        $REGEX = strpos((string)$role->name, $string);

        if ($REGEX !== false) {
            return response()->json([
                'response' => 'false',
            ]);
        } else {
           
           /**
            * @method SuperUserDeletedRole($id)->$role->delete();
            * cek jika yang dipilih non all permission maka boleh dihapus
            */

            $role->delete(); //this just removed roles not remove permission [fix]
            return response()->json([
                'response' => 'true',
                'success_deleted' => $role->name,
            ]);
        }
        return response()->json([
            'role_deleted' => $role->name,
            'role_name' => $REGEX
        ]);
    }

    public function loopdataCompany($indexid)
    {
        $data = Companies::where('id', $indexid)->first();
        // dd($data);
        foreach ($data as $query) {
            $results[] = ['value' => $query];
        }
     
        return response()->json($data);
    }

    public function loopdataBranch($indexid)
    {
        $data = Company_branchs::with('company')->where('id', $indexid)->get();
        // dd($data);
        foreach ($data as $query) {
            $results[] = ['value' => $query];
        }
    
        return response()->json($data);
    }

    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($branch_id, $id, Role_branch $roleBranch)
    {
        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        if ($results == "administrator") {
            $role = Role::get();
            $user = User::findOrFail($id);
            $alert_items = Item::where('flag', 0)->get();
            $system_alert_item_vendor = Vendor_item_transports::with(
                'vendors',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                'customers',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();

            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();

            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }

            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();

                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }

                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
            
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);

            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();

            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }

            session(['usersid'=> $id]);

            return view('admin.administrator.users.edit', [
            'menu' => 'Edit Users',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']
        ])->with(compact('user', 'role', 'prefix', 'cek_super_user_by_owner'));
        } else {
            $idx = Auth::User()->id;
                
            $role_branch = $roleBranch->with('modelhasuser', 'modelhasrole', 'modelhasbranch.company')->where(function (Builder $query) use ($idx) {
                return $query->whereIn('user_id', [$idx]);
            })->get();

            // $roles = $roleBranch->select('id','name')->get();
            foreach ($role_branch as $role_as_branch) {
                # code...
                            $fetch_roles[] = $role_as_branch->modelhasrole; //this fetch role name
                            $fetch_branch[] = $role_as_branch->modelhasbranch->branch; // this fetch branch name
                            $fetch_company[] = $role_as_branch->modelhasbranch->company->name; // this fetch company name
            }

            $role = $fetch_roles;
            $user = User::findOrFail($id);
            // dd($user);die;
            $alert_items = Item::where('flag', 0)->get();
            $system_alert_item_vendor = Vendor_item_transports::with(
                        'vendors',
                        'city_show_it_origin',
                        'city_show_it_destination'
                    )->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                        'customers',
                        'city_show_it_origin',
                        'city_show_it_destination'
                    )->where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $prefix = Company_branchs::users($branch_id)->first();
        
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
        
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
        
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                    
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }
        
            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
        
            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();
        
            if ($cek_company_by_owner->isEmpty()) {
                # code...
                $cek_super_user_by_owner = 'undefined';
            } else {
                $cek_super_user_by_owner = 'available';
            }

            session(['usersid'=> $id]);
        
            return view('admin.administrator.users.edit', [
                    'menu' => 'Edit Users',
                    'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                    'some' => $this->jagal_squad->session()->get('id'),
                    'alert_items' => $alert_items,
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'system_alert_item_customer' => $data_item_alert_sys_allows0,
                    'alert_customers' => $alert_customers,
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2']
                    ])->with(compact('user', 'role', 'prefix', 'cek_super_user_by_owner'));
        }
    }

    public function loadCompanyReleatedSuperuser(Request $request, Role_branch $rbranch)
    {
        $cari = $request->q;
        if (Gate::allows('developer')) {
            $data = $this->perusahaan->select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
            return response()->json($data);
            } 
                else {

                    $data = $this->perusahaan->select('id', 'name')->whereIn('owner_id', [Auth::User()->id])->where('name', 'LIKE', "%$cari%")->get();

                    if ($data->isEmpty()) {
                        $y_column_branch = array();

                        foreach (Auth::User()->roles as $name_role => $l) {
                            $prefixRoles[$name_role] = $l->id;
                        }
                        $prefixRole = array_slice($prefixRoles, 1);
                        $ambil_branch_id_users = $rbranch->with('modelhasbranch.company')->whereIn('user_id', [Auth::User()->id])->get();

                        foreach ($ambil_branch_id_users as $row_role_branch) {
                            $y_column_branch[] = $row_role_branch->modelhasbranch->company['id'];
                        }

                        $datax = Companies::where(function (Builder $query) use ($cari, $y_column_branch) {
                            return $query
                            ->whereIn('id', $y_column_branch)
                            ->where('name','LIKE', "%$cari%")
                            ->addSelect('id', 'name');
                        })->get();

                        return response()->json($datax);

                    } 
                        else {

                return response()->json($data);
            }
        }
    }

    public function SettingSyncRoles($Roles, $role, $branch, Role_branch $brnch)
    {
        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }
        
        // if ($results == "administrator") {
            
        //     $role = Role::get();
        //     $user = User::findOrFail($id);
        //     $user->update($request->all());
        //     $roles = $request->input('roles') ? $request->input('roles') : [];
        //     $user->syncRoles($roles);

        // } else {
        $dataSyncRole = explode(",", $Roles);
        $data_role = array_push($dataSyncRole, "super_users");
        $user = User::findOrFail(Auth::User()->id);
        $user->syncRoles($dataSyncRole);

        $branch = $brnch->firstOrcreate([
                    'user_id' => Auth::User()->id,
                    'branch_id' => $branch,
                    'role_id' => $role
                ]);


        return response()->json([
                'dataSync' => $user
            ]);
        //
    }

    public function SyncRoleCompanies($companyroles, $role)
    {
        // dd($companyroles);die;
        $permissions = ['transport','warehouse','accounting'];
        // dd($companyroles);die;
        $plus = count(Role::get()->toArray())+1;
        $role = Role::create(['name'=>$role.'-'.Str::random(9).$plus]);
        $role->givePermissionTo($permissions);

        $user = User::findOrFail(Auth::User()->id);
        $dataSyncRole = explode(",", $role->name);
        // $dataSyncRole = explode(",", $companyroles);

        array_push($dataSyncRole, "super_users");
        $user->syncRoles($dataSyncRole);
        
        return response()->json([
            'dataSync' => $user,
            'SyncRoles' => $role,
            'RolesID' => $role->id,
            'RolesName' => $role->name
        ]);
    }

    public function show(Role_branch $roleBranch, UpdateUsersRequest $request, $id)
    {
        if (Auth::User()->id === Auth::User()->id) {
            $Authorized = Auth::User()->roles;

            foreach ($Authorized as $key => $checkaccess) {
                # code...
                $results = $checkaccess->name;
            }

            if ($results == "administrator") {
                $role = Role::get();
                $user = User::findOrFail($id);
                $user->update($request->all());
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->syncRoles($roles);

                    
                swal()
                    ->toast()
                        ->autoclose(9000)
                            ->message("Success Upated", "[Developer] Congratulation User has been update roles !", 'success');
            } else {
                $iduser = Auth::User()->id;
            
                $role_branch = $roleBranch->with('modelhasuser', 'modelhasrole', 'modelhasbranch.company')->where(function (Builder $query) use ($iduser) {
                    return $query->whereIn('user_id', [$iduser]);
                })->get();
        
                // $roles = $roleBranch->select('id','name')->get();
                foreach ($role_branch as $role_as_branch) {
                    # code...
                                $fetch_roles[] = $role_as_branch->modelhasrole; //this fetch role name
                                $fetch_branch[] = $role_as_branch->modelhasbranch->branch; // this fetch branch name
                                $fetch_company[] = $role_as_branch->modelhasbranch->company->name; // this fetch company name
                }
        
                $role = $fetch_roles;
                $user = User::findOrFail($id);

                $user->update($request->all());
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->syncRoles($roles);

                swal()
                        ->toast()
                            ->autoclose(9000)
                                ->message("Success Upated", "[Super users] Congratulation User has been update roles !", 'success');
            }
        }

        $system_alert_item_vendor = Vendor_item_transports::with(
            'vendors',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with(
            'customers',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $alert_items = Item::where('flag', 0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
        $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();

        $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        }

        if (isset($fetchArrays) != null) {
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            }

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            }
        }

        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id)->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';
        }

        return view('admin.administrator.users.edit', [
            'menu' => 'Edit Users',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers
        ])->with(compact('user', 'role', 'prefix', 'cek_super_user_by_owner'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $branch_id, $id)
    {
        if (Auth::User()->id === Auth::User()->id) {
            $Authorized = Auth::User()->roles;

            foreach ($Authorized as $key => $checkaccess) {
                # code...
                $results = $checkaccess->name;
            }

            if ($results == "administrator") {
                $user = User::findOrFail($id);
                $user->update($request->all());
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->syncRoles($roles);

                swal()
                    ->toast()
                        ->autoclose(9000)
                            ->message("Success Created", "[Developer] Congratulation User has been update roles !", 'success');
            } else {
                foreach ((array)$request->input('roles') as $key => $roles) {
                    # code...
        
                    if ($roles == "administrator") {
                        swal()
                                ->toast()
                                        ->autoclose(9000)
                                    ->message("Danger", "Sorry you can't update role administrator !", 'error');
                    } else {
                        $role = Role::get();
                        $user = User::findOrFail($id);
                        $user->update($request->all());
                        $roles = $request->input('roles') ? $request->input('roles') : [];
                        $user->syncRoles($roles);

                        swal()
                                ->toast()
                                    ->autoclose(9000)
                                        ->message("Success Created", "[Super users] Congratulation User has been update roles !", 'success');
                    }
                }
            }
        }

        return redirect()->route('edit.master.users', array($branch_id, $id));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        if ($results == "administrator") {
            $user = User::findOrFail($id);
            $user->delete();
            $alert_items = Item::where('flag', 0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $users = User::all();
            $system_alert_item_vendor = Vendor_item_transports::with(
            'vendors',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
            'customers',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();

        
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();

            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }

            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();

                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }

                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
            
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }

            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
        
            // return view('admin.administrator.users.index', [
            // 'menu'=>'Users List',
            // 'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            // 'some' => $this->jagal_squad->session()->get('id'),
            // 'api_v1' => $responsecallbackme['api_v1'],
            // 'api_v2' => $responsecallbackme['api_v2'],
            // 'system_alert_item_vendor' => $system_alert_item_vendor,
            // 'system_alert_item_customer' => $data_item_alert_sys_allows0,
            // 'alert_items' => $alert_items,
            // 'alert_customers' => $alert_customers])
            // ->with(compact('users', 'prefix'));
            return redirect()->back()->withSuccess("User berhasil dinonaktifkan");

        } else {
            $alert_items = Item::where('flag', 0)->get();
            $user = User::findOrFail($id);
            $user->delete();
            $users = User::whereIn('parent_id', [Auth::User()->id])->get();
            $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
            $system_alert_item_vendor = Vendor_item_transports::with(
                    'vendors',
                    'city_show_it_origin',
                    'city_show_it_destination'
                )->where('flag', 0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                    'customers',
                    'city_show_it_origin',
                    'city_show_it_destination'
                )->where('flag', 0)->get();
            $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
                
            $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
            foreach ($fetch_izzy as $value) {
                # code...
                $fetchArrays[] = $value->check_is;
            }
        
            if (isset($fetchArrays) != null) {
                $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
        
                foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                    # code...
                    $fetchArray1 = $operationz->operation;
                }
        
                $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                    
                foreach ($operations_api_izzy_is_true_v2 as $operations) {
                    # code...
                    $fetchArray2 = $operations->operation;
                }
            }
        
            $APIs = $this->APIusers::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
                
            // return view('admin.administrator.users.index', [
            //         'menu'=>'Users List',
            //         'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            //         'some' => $this->jagal_squad->session()->get('id'),
            //         'api_v1' => $responsecallbackme['api_v1'],
            //         'api_v2' => $responsecallbackme['api_v2'],
            //         'system_alert_item_vendor' => $system_alert_item_vendor,
            //         'system_alert_item_customer' => $data_item_alert_sys_allows0,
            //         'alert_items' => $alert_items,
            //         'alert_customers' => $alert_customers])
            //         ->with(compact('users', 'prefix'));
            return redirect()->back()->withSuccess("User berhasil dinonaktifkan");
        }
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    // fixed active or unactive user
    public function userUnactived()
    {
        $users = User::onlyTrashed()->get();
        $alert_items = Item::where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with(
                'vendors',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with(
                'customers',
                'city_show_it_origin',
                'city_show_it_destination'
            )->where('flag', 0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
            
        $fetch_izzy = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        }
    
        if (isset($fetchArrays) != null) {
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is', '=', 'api_izzy')->get();
    
            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            }
    
            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is', '=', 'api_accurate')->get();
                
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            }
        }
    
        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
            
        return view('admin.administrator.users.UserUnactived.userunactivedlist', [
                'menu'=>'Users List',
                'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
                'some' => $this->jagal_squad->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_items' => $alert_items,
                'alert_customers' => $alert_customers])
                ->with(compact('users', 'prefix'));

    
    }
    
    public function restoreUsers($branch_id, $id)
    {
        $usr = User::onlyTrashed()->where('id',$id)->restore();
        return redirect()->back()->withSuccess("user berhasil diaktifkan");

    }

    public function restoreAllUser($branch_id)
    {
        $cek_unactive = User::onlyTrashed()->get();
        $usr = User::onlyTrashed();
        $inf = ($cek_unactive->isEmpty())
        ? "not found"
        : $usr->restore();

        if($inf == "not found"){
            return redirect()->back()->witherror("Maaf user yang anda restore tidak ditemukan.. [revert]");
        }
        return redirect()->back()->withSuccess("Semua user berhasil diaktifkan");

    }

}

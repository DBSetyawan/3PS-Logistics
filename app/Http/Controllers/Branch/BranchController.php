<?php

namespace warehouse\Http\Controllers\Branch;

use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Companies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Requests\Branch\StoreBranchRequest;
use warehouse\Http\Requests\Branch\UpdateBranchRequest;
use warehouse\Http\Requests\Companies\StoreRequestCompanies;
use warehouse\Http\Requests\Companies\UpdateCompaniesRequest;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class BranchController extends Controller
{

    protected $APIusers;
    protected $perusahaan;
    private $rest;

    public function __construct(RESTAPIs $apiusers, Request $REST, Companies $perusahaantbl)
    {
        $this->perusahaan = $perusahaantbl;
        $this->APIusers = $apiusers;
        $this->rest = $REST;

        $this->middleware(['verified','CekOpenedTransaction','BlockedBeforeSettingUser','permission:developer|superusers|warehouse|accounting|transport']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::User()->id;
        $data_company_of_superuser = $this->perusahaan->whereIn('owner_Id', [$id])->get();

        foreach($data_company_of_superuser as $key => $id_comp){
            $ambil_id_company[] = $id_comp->id;
         
    }

    $companysbranch = Company_branchs::with('company')->where(function (Builder $query) use($ambil_id_company) {
                                        return $query->whereIn('company_id', $ambil_id_company);
                                    })->get();

        $cek_company_by_owner = $this->perusahaan->whereIn('owner_id', [Auth::User()->id] )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';
        }

        $prefix = Company_branchs::branchname(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with(
            'vendors',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $system_alert_item_customers = Customer_item_transports::with(
            'customers',
            'city_show_it_origin',
            'city_show_it_destination'
        )->where('flag', 0)->get();
        $alert_items = Item::where('flag', 0)->get();
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

        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }


        return view('admin.Branch.index', [
            'menu' => 'Company List',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $system_alert_item_customers,
            'alert_items' => $alert_items,
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2,
            'apis' => $results,
            'alert_customers' => $alert_customers,
            'companysbranch' => $companysbranch,
            'prefix' => $prefix,
            'cek_super_user_by_owner' => $cek_super_user_by_owner
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }
        
        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();
        
        $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        } 

        if(isset($fetchArrays) != null){
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            } 

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            } 

        } 

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }

        return view('admin.Branch.create',[
            'menu'=>'Create User List',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_items' => $alert_items,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers])
        ->with(compact('roles','prefix','cek_super_user_by_owner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }

        $branch = Company_branchs::create($request->all());

        swal()
        ->toast()
            ->autoclose(9000)
                ->message("Success Created", "Congratulation You create Branch !", 'success');
        return redirect()->route('Branchs.create');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UpdateBranchRequest $request, $id)
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }
   
        $data_company = Company_branchs::findOrFail($id);
        $data_company->update($request->all());

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();

        $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        } 

        if(isset($fetchArrays) != null){
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            } 

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            } 

        } 

        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }

        return view('admin.Branch.edit',[
            'menu' => 'Edit Company',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']
        ])->with(compact('data_company', 'role', 'prefix','cek_super_user_by_owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }
        // $roles = Role::get()->pluck('name', 'name');
   
        $data_company = Company_branchs::findOrFail($id);

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();

        $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        } 

        if(isset($fetchArrays) != null){
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            } 

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            } 

        } 

        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }

        return view('admin.Branch.edit',[
            'menu' => 'Edit Company',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']
        ])->with(compact('data_company', 'role', 'prefix','cek_super_user_by_owner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }
        
        $hapus_cabang = Company_branchs::findOrFail($id);
        $hapus_cabang->delete();
        
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        
        $id = Auth::User()->id;
        $data_company_of_superuser = $this->perusahaan->whereIn('owner_Id', [$id])->get();

            foreach($data_company_of_superuser as $key => $id_comp){
                $ambil_id_company[] = $id_comp->id;
            
            }

        $companysbranch = Company_branchs::with('company')->where(function (Builder $query) use($ambil_id_company) {
                                        return $query->whereIn('company_id', $ambil_id_company);
                                    })->get();

        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::users(Auth::User()->company_branch_id)->first();

        
        $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        } 

        if(isset($fetchArrays) != null){
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            } 

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            } 

        } 

        $APIs = $this->APIusers::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }
        
        return view('admin.Branch.index',[
            'menu'=>'Users List',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_items' => $alert_items,
            'alert_customers' => $alert_customers])
            ->with(compact('users','prefix','companysbranch','cek_super_user_by_owner'));
    }

    public function loaded_company_branch(Request $request, Companies $cabang){

        $cari = $request->q;

        $data = $cabang->select('id','name')->where('name', 'LIKE', "%".$cari."%")->Where('owner_id', Auth::User()->id )->groupBy('name')->get();
        
        foreach ($data as $query) {
            $results[] = ['value' => $query];
            }
        
        return response()->json($data);

    }
}

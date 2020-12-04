<?php

namespace warehouse\Http\Controllers\Company;

use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Companies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Requests\Companies\StoreRequestCompanies;
use warehouse\Http\Requests\Companies\UpdateCompaniesRequest;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class CompaniesController extends Controller
{

    protected $APIusers;
    protected $perusahaan;
    private $rest;

    public function __construct(RESTAPIs $apiusers, Companies $perusahaantbl, Request $REST)
    {
        $this->perusahaan = $perusahaantbl;
        $this->APIusers = $apiusers;
        $this->jagal_squad = $REST;
        $this->middleware(['verified','permission:developer|superusers|warehouse|accounting|transport','CekOpenedTransaction','BlockedBeforeSettingUser']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cek_company_by_owner = $this->perusahaan->whereIn('owner_id', [Auth::User()->id] )->get();
        
        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }

        $prefix = Company_branchs::branchname(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_customers = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

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

        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        $data_company = $this->perusahaan->whereIn('owner_id', [Auth::User()->id])->get();

        return view('admin.Company.index',[
            'menu' => 'Company List',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $system_alert_item_customers,
            'alert_items' => $alert_items,
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2,
            'apis' => $results,
            'alert_customers' => $alert_customers,
            'data_company' => $data_company,
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

        return view('admin.Company.create',[
            'menu'=>'Create User List',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
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
    public function store(StoreRequestCompanies $request)
    {
        
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }

        $companies = $this->perusahaan->create($request->all());

        swal()
        ->toast()
            ->autoclose(9000)
                ->message("Success Created", "Congratulation You create Company !", 'success');
        return redirect()->route('Companys.create');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UpdateCompaniesRequest $request, $id)
    {
        if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
            return abort(401);
        }
        // $roles = Role::get()->pluck('name', 'name');
   
        $data_company = $this->perusahaan->findOrFail($id);
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

        return view('admin.Company.edit',[
            'menu' => 'Edit Company',
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
   
        $data_company = $this->perusahaan->findOrFail($id);

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

        return view('admin.Company.edit',[
            'menu' => 'Edit Company',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
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
    public function update($id)
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
   
        $data_company_after_del = $this->perusahaan->findOrFail($id);
        $data_company_after_del->delete();
        $data_company = $this->perusahaan->whereIn('owner_id', [Auth::User()->id] )->get();
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

        return view('admin.Company.index',[
            'menu' => 'Edit Company',
            'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
            'some' => $this->jagal_squad->session()->get('id'),
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']
        ])->with(compact('data_company', 'role', 'prefix','cek_super_user_by_owner'));

    }

}

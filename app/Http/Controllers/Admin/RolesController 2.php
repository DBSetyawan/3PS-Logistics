<?php

namespace warehouse\Http\Controllers\Admin;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Companies;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use Spatie\Permission\Models\Permission;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Requests\Admin\StoreRolesRequest;
use warehouse\Http\Requests\Admin\UpdateRolesRequest;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class RolesController extends Controller
{

    protected $APIroles;
    protected $apirestroles;
    protected $perusahaan;
    
    
    public function __construct(RESTAPIs $apirestroles, Companies $perusahaantbl)
    {
        $this->middleware(['verified','auth']);
        $this->APIroles = $apirestroles;
        $this->perusahaan = $perusahaantbl;
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        $APIs = $this->APIroles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $roles = Role::all();

        $alert_items = Item::where('flag',0)->get();
        $prefix = Company_branchs::roles(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

        if ($cek_company_by_owner->isEmpty()) {
            # code...
            $cek_super_user_by_owner = 'undefined';
        } else {
            $cek_super_user_by_owner = 'available';

        }


        return view('admin.administrator.roles.index',[
            'menu' => 'Roles List',
            'alert_items' => $alert_items,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'prefix' => $prefix,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers
        ])->with(compact('roles','cek_super_user_by_owner'));

    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }

        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        $APIs = $this->APIroles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::roles(Auth::User()->company_branch_id)->first();
        $permissions = Permission::get();
        $roles = Role::all();
        $alert_items = Item::where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        return view('admin.administrator.roles.create',[
            'menu' => 'Create Roles',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_items' => $alert_items,
            'alert_customers' => $alert_customers
        ])->with(compact('permissions','roles','prefix'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }

        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }

        $permissions = Permission::get();
        $roles = Role::all();

        $role = Role::create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);

        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        return redirect()->route('roles.index');

    }

    public function show(UpdateRolesRequest $request, $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }
        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        // $permissions = Permission::get()->pluck('name', 'name');
        $permissions = Permission::get();

        $role = Role::findOrFail($id);
        $roles = Role::all();
        $APIs = $this->APIroles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $role->update($request->except('permission'));
        $permission = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permission);
        $alert_items = Item::where('flag',0)->get();
        $prefix = Company_branchs::roles(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        return view('admin.administrator.roles.index',[
            'menu' => 'Edit Roles',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_items' => $alert_items,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers
        ])->with(compact('role','permissions','roles','prefix'));
    }

    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (! Gate::allows('administrator')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }
        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        // $permissions = Permission::get()->pluck('name', 'name');
        $permissions = Permission::get();

        $role = Role::findOrFail($id);

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::roles(Auth::User()->company_branch_id)->first();
        $APIs = $this->APIroles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        return view('admin.administrator.roles.edit',[
            'menu' => 'Edit Roles',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers
        ])->with(compact('role','permissions','prefix'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }
        if (! Gate::denies('superusers')) {
            return abort(401);
        }
        $role = Role::findOrFail($id);
        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }
        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        $role = Role::findOrFail($id);
        $role->delete();
        $roles = Role::all();

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::roles(Auth::User()->company_branch_id)->first();
        $APIs = $this->APIroles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        return view('admin.administrator.roles.index',[
            'menu' => 'Edit Roles',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_items' => $alert_items,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers
        ])->with(compact('roles','prefix'));
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        // if (! Gate::allows('administrator') && ! Gate::allows('superusers')) {
        //     return abort(401);
        // }
        // if (! Gate::denies('superusers')) {
        //     return abort(401);
        // }
        
        if ($request->input('ids')) {
            $entries = Role::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}

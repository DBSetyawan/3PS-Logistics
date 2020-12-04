<?php

namespace warehouse\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Customer;
use warehouse\Models\Company_branchs;
use warehouse\Models\Item;
use Auth;
use warehouse\Http\Controllers\Controller;
use warehouse\Http\Requests\Admin\StorePermissionsRequest;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Requests\Admin\UpdatePermissionsRequest;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;


class PermissionsController extends Controller
{

    protected $APIpermission;
    
    public function __construct(RESTAPIs $apisrestpermissions)
    {
        $this->middleware(['verified','auth']);
        $this->APIpermission = $apisrestpermissions;
    }
    
    /**
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
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

        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        $permissions = Permission::all();
        $alert_items = Item::where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        return view('admin.administrator.permission.index',[
            'menu' => 'Permissions List',
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers
        ])->with(compact('permissions','prefix'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id)
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

        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        return view('admin.administrator.permission.create',[
            'menu' => 'Create Add Permission',
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'alert_items' => $alert_items,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers
        ])->with(compact('permissions','prefix'));
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionsRequest $request)
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

        Permission::create($request->all());
        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        return view('admin.administrator.permission.create',[
            'menu' => 'Permission List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0, 
            'alert_customers' => $alert_customers,
            'prefix' =>  $prefix
        ]);
    }


    public function show(UpdatePermissionsRequest $request, $id)
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

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();

        return view('admin.administrator.permission.edit',[])->with(compact('permission'));

    }
    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($branch_id, $id)
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
        
        $permission = Permission::findOrFail($id);

        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        return view('admin.administrator.permission.edit',[
                'menu' => 'Permission Edit',
                'alert_items' => $alert_items,
                'permission' => $permission,
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'alert_customers' => $alert_customers,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
            ])->with(compact('permission','prefix')
        );
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request, $id)
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

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        return view('admin.administrator.permission.edit',[
            'menu' => 'Permission Edit',
            'alert_items' => $alert_items,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers
        ])->with(compact('permission','prefix'));
    }


    /**
     * Remove Permission from storage.
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

        if (! Gate::denies('superusers')) {
            return abort(401);
        }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        $permissions = permission::all();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $APIs = $this->APIpermission::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        return view('admin.administrator.permission.index',[
            'menu' => 'Permission List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers
        ])->with(compact('permissions','prefix'));
    }

    /**
     * Delete all selected Permission at once.
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
        if (! Gate::denies('superusers')) {
            return abort(401);
        }

        if ($request->input('ids')) {
            $entries = Permission::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}

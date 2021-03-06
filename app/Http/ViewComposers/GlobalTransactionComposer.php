<?php

namespace warehouse\Http\ViewComposers;

use Illuminate\View\View;
use warehouse\Models\Item;
use warehouse\Models\Customer;
use warehouse\Models\Role_branch;
use Illuminate\Support\Facades\Auth;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Companies as perusahaan;
use Illuminate\Foundation\Auth\RedirectsUsers;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Models\Item_transport as Customer_item_transports;

class GlobalTransactionComposer
{

    use RedirectsUsers, CallSignature;

    public function __construct()
    {
        // parent::__construct();
        
    }

    public function compose(View $view)
    {

        $branch_id=session()->get('id');

        $openedIdUser = isset(Auth::User()->id) ? Auth::User()->id : $this->redirectPath();

        // cek jika session/cookie telah bersih/kosong pada posisi user masih membuka transaksi
        // user akan  dikembalikan ke login
        if($openedIdUser == "/dashboard")

                return $this->redirectPath();

            else

                $cek_company_by_owner = perusahaan::where('owner_id', $openedIdUser)->get();

                if ($cek_company_by_owner->isEmpty()) {
                    # code...
                        $cek_super_user_by_owner = 'undefined';
                } 
                    else 
                            {

                                $cek_super_user_by_owner = 'available';
                }

        $permissions = permission::all();
        $prefix = Company_branchs::branchpermission(Auth::User()->company_branch_id)->first();
        // $prefix = Company_branchs::branchname($branch_id)->first();

        $system_alert_item_vendor = Vendor_item_transports::with('vendors','city_show_it_origin','city_show_it_destination')
                                                        ->where('flag', 0)->get();

        $system_alert_item_customers = Customer_item_transports::with('customers','city_show_it_origin','city_show_it_destination')
                                                            ->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')
                                    ->where('flag',0)->get();

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

        // $request_branchs = $this->Apiopentransaction->getBranchIdWithdynamicChoosenBrach($branch_id);

        $results = null;
        $Authorized = Auth::User()->roles;
        $id = Auth::User()->id;

        foreach ($Authorized as $checkaccess) {
            # code...
            $results[] = $checkaccess->name;
        }

        $companysbrancs = Role_branch::with('modelhasrole')->whereHas('modelhasrole', function (Builder $query) use ($id) {
            return $query->whereIn('user_id', [$id]);
        })->groupBy('branch_id')->get();

        $companysbranch = null;

        foreach ($companysbrancs as $rm) {
            # code...
            $companysbranch[] = $rm->modelhasrole->name;
        }

        if(!$results){
            $view->with([
                // 'cek_super_user_by_owner', $cek_super_user_by_owner
                'menu' => 'Admin Dashboard',
                'system_alert_item_vendor' => $system_alert_item_vendor,    
                'system_alert_item_customer' => $system_alert_item_customers,
                'alert_items' => $alert_items,
                'username' => Auth::User()->email,
                'name' => Auth::User()->name,
                'api_v1' => $fetchArray1,
                'rolesv1' => $companysbranch,
                'choosen_user_with_branch' => $branch_id,
                'some' => $branch_id,
                'api_v2' => $fetchArray2,
                'apis' => $results,
                'choosen_user_with_branch' => $branch_id,
                'alert_customers' => $alert_customers,
                'prefix' => $prefix,
                'cek_super_user_by_owner' => $cek_super_user_by_owner,
                'check_expired_session' => session()->get('session_users')
            ]);
        } 
            else {
                // $getCloudAccurate = $this->openModulesAccurateCloud
                // ->FuncModuleReceivedWebhook();
                // $i = 0;

                // foreach (Transport_orders::cursor() as $flight) {
                //     // foreach (User::query()->get() as $flight) {
                //     //
                //     // return $flight;
                //     $i++;

                // }

                // $data = "<h1>Iterated through ".$i." are using ".(round(memory_get_peak_usage() / 1024 / 1024))." MB of memory</h1>";

                // $movieList = $this->movies->getMovieList();

                $view->with([
                    // 'cek_super_user_by_owner', $cek_super_user_by_owner
                    'menu' => 'Admin Dashboard',
                    'system_alert_item_vendor' => $system_alert_item_vendor,    
                    'system_alert_item_customer' => $system_alert_item_customers,
                    'alert_items' => $alert_items,
                    'username' => Auth::User()->email,
                    'name' => Auth::User()->name,
                    'api_v1' => $fetchArray1,
                    'api_v2' => $fetchArray2,
                    'permissions' => $permissions,
                    'rolesv1' => $companysbranch,
                    'apis' => $results,
                    'choosen_user_with_branch' => $branch_id,
                    'some' => $branch_id,
                    // 'd' => $data,
                    // 'movieList' => $movieList,
                    'choosen_user_with_branch' => $branch_id,
                    'alert_customers' => $alert_customers,
                    'prefix' => $prefix,
                    'cek_super_user_by_owner' => $cek_super_user_by_owner,
                    'check_expired_session' => session()->get('session_users')
                ]);
            }
            
    }

}
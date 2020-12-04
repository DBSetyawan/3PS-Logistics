<?php

namespace warehouse\Providers;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use warehouse\Models\Company_branchs;
use Illuminate\Support\Facades\Schema;
use warehouse\Models\Transport_orders;
use Illuminate\Support\ServiceProvider;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Companies as perusahaan;
use Illuminate\Foundation\Auth\RedirectsUsers;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Http\Controllers\API\SettingBranch;
use warehouse\Http\Controllers\Interfaces\CekBranch;
use warehouse\Http\Controllers\ManagementController;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Repositories\AccurateCloudRepositoryEloquent;
use warehouse\Http\Controllers\Services\IzzytransportsHooks;
use warehouse\Http\Controllers\Services\AccurateCloudmodules;
use warehouse\Http\Controllers\Services\IzzyTransportModules;
use warehouse\Http\Controllers\transport\TransportController;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Services\Cekmodeluserbranchservices;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;

class AppServiceProvider extends ServiceProvider
{

    use RedirectsUsers, CallSignature;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // View::share(['cek_super_user_by_owner', $cek_super_user_by_owner, 'branch_id', Session()->all()]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Apiopentransactioninterface::class,Cekmodeluserbranchservices::class);
        $this->app->singleton(AccuratecloudInterface::class,AccurateCloudmodules::class);
        $this->app->singleton(IzzytransportsHooks::class,IzzyTransportModules::class);
        $this->app->bind(
            AccurateCloudRepos::class,
            AccurateCloudRepositoryEloquent::class
        );
    }

}

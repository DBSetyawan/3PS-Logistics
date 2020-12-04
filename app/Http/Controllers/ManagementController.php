<?php

namespace warehouse\Http\Controllers;

use Auth;
use warehouse\User;
use GuzzleHttp\Client;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Companies;
use warehouse\Models\Company_branchs;
use warehouse\Models\Transport_orders;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Models\Vendor_item_transports;
use Illuminate\Foundation\Auth\RedirectsUsers;
use warehouse\Repositories\MovieRepository;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Http\Controllers\warehouse\WarehouseController;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;

class ManagementController extends Controller
{

    use RedirectsUsers, CallSignature;

    protected $perusahaan;
    public $movies;
    protected $warehouse;
    protected $jagal;
    private $Apiopentransaction;
    protected $cek_sesi;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MovieRepository $movies,
                                AccuratecloudInterface $clouds,
                                Apiopentransactioninterface $APInterface,
                                Companies $perusahaantbl,
                                WarehouseController $whs,
                                Request $requested
                            )
    {
        $this->perusahaan = $perusahaantbl;
        $this->warehouse = $whs;
        $this->jagal = $requested;
        $this->movies = $movies;
        $this->Apiopentransaction = $APInterface;
        $this->openModulesAccurateCloud = $clouds;
        $this->middleware(['auth','CekOpenedTransaction','verified']);

    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

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

        $results = null;
        $Authorized = Auth::User()->roles;
        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }
        
        if($results == null){
            return view('admin.index');
        } else {
              return view('admin.index');
        }

    }

    public function Reacts(){
            return view('react.reacts');
    }
    
    public function findbranchWithRoleBranchId($id)
    {
        $companysbranch = Company_branchs::with('company')->where(function (Builder $query) use($id) {
            return $query->where('id', $id);
        })->get();

        if($id == "41"){ //3PE
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccurate')
            ]);
        }

        if($id == "42"){
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccurate')
            ]);
        }   

        #GATE Surabaya
        /**
         * branch company id : 43 === 3PL
         */
        if($id == "43"){ 
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateJKT')
            ]);
        }

         /**
         * branch company id : 44 === 3PE
         */
        if($id == "44"){
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateJKT')
            ]);
        }
        ################

        #GATE Kupang
         /**
         * branch company id : 45 === 3PE
         */
        if($id == "45"){
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateKPG')
            ]);
        }

         /**
         * branch company id : 46 === 3PL
         */
        if($id == "46"){
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateKPG')
            ]);
        }
        ################

        #GATE Lodi
         /**
         * branch company id : 47 === 3PL
         */
        if($id == "53"){ //3PE
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateLodi')
            ]);
        }

         /**
         * branch company id : 48 === 3PE
         */
        if($id == "54"){ //3PL
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateLodi')
            ]);
        }
        ################

        #GATE Semarang
         /**
         * branch company id : 49 === 3PE
         */
        if($id == "49"){ 
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateSMG')
            ]);
        }

         /**
         * branch company id : 50 === 3PL
         */
        if($id == "50"){ 
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccurateSMG')
            ]);
        }
        ################

        #GATE Pusat
         /**
         * branch company id : 51 === 3PL
         */
        if($id == "51"){
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                'oauth_accurate_branch' =>session('UserMultiBranchAccuratePusat')
            ]);
        }

         /**
         * branch company id : 52 === 3PE
         */
        if($id == "52"){ 
            $user = User::findOrFail(Auth::User()->id);
            $user->update([
                'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                'oauth_accurate_branch' =>session('UserMultiBranchAccuratePusat')
            ]);
        }
        ################

        return response()->json($companysbranch);
    }

    public function OpenTransaction($branch_id)
    {
        return view('admin.index');
    }

    public function storeValue()
    {   
        $this->jagal->session()->put('branch_id', $this->jagal->responseJsonData);
    }


    public static function callbackme(){
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

        return response()->json([
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2
        ]);

    }

    public function spa()
    {
        return view('spa.file');
    }

}

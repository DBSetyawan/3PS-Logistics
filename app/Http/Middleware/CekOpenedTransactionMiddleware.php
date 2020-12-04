<?php

namespace warehouse\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use warehouse\Models\Role_branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use warehouse\Http\Controllers\ManagementController;

class CekOpenedTransactionMiddleware
{
    use AuthenticatesUsers;

    private $role_branchs;
    private $companibrnch;
    private $reqs;
    public $branchid;

    public function __construct(    
                                    ManagementController $mgm, 
                                    Role_branch $BRANCHSROLE,
                                    Company_branchs $comps,
                                    Request $req
                                )
    {
        $this->managements = $mgm;
        $this->role_branchs = $BRANCHSROLE;
        $this->companibrnch = $comps;
        $this->reqs = $req;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $regex = preg_replace('/^([^0-9]+)??/','',$request->path());
        $exct = substr($regex, 0, 10);
        $uri = preg_replace('/[^0-9]/', '', $exct);
        $this->managements->OpenTransaction($uri);
  
            /** @var Response $response */
            $response = $next($request);

            // return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            // ->header('Pragma','no-cache') //HTTP 1.0
            // ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT');

            if($request->session()->exists('id') == false){

                if ($request->path() == "dashboard"){
    
                    return $response;
    
                }

                // return abort(403);
                return redirect('/dashboard')->withError("Anda harus memilih cabang untuk membuka transaksi \n [System Rollback]");

            }

        if($request->session()->exists('id') == true){


            if ($request->path() == "dashboard"){

                if(session()->exists('id') == true);

                    return redirect()->route('role_branch_allowed.open',
                        session()->get('id'))->with(
                            [
                                'redirect_url_not_found'=>session()->get('redirect_url_not_found'),
                                'alert-success'=>session()->get('alert-success'),
                                'alert-danger'=>session()->get('alert-danger'),
                                'TokenExpiredEventAccessAccurate'=>session()->get('TokenExpiredEventAccessAccurate'),
                                'alert-oauth-sso-expired-token'=>session()->get('alert-oauth-sso-expired-token'),
                                'alert-db-access-not-allowed'=>session()->get('alert-db-access-not-allowed'),
                                'oauth_verify'=>session()->get('oauth_verify'),
                                'alert-oauth-sso-already-exists'=>session()->get('alert-oauth-sso-already-exists'),
                                'alert-oauth-sso-invalid_client'=>session()->get('alert-oauth-sso-invalid_client'),
                                'alert-invalid-parameter'=>session()->get('alert-invalid-parameter'),
                                'alert-success-db-accurate-index'=>session()->get('alert-success-db-accurate-index'),
                                'alert-db-access-denied'=>session()->get('alert-db-access-denied'),
                                'alert-oauth-access-denied'=>session()->get('alert-oauth-access-denied')
                            ]
                    );

            }

            foreach(Auth::User()->roles as $name_roles){

                $names[] = $name_roles->id;
                
            }

            $id = session()->get('id');

            if(Gate::allows('developer')){

                $companysbranch = $this->role_branchs->with('modelhasbranch.company')->whereHas('modelhasbranch.company',function (Builder $query) use($id) {
                    return $query->whereIn('branch_id', [$id]);

                })->groupBy('branch_id')->get();

            } 
                else {

                        $companysbranch = $this->role_branchs->with('modelhasbranch.company')->whereHas('modelhasbranch.company',function (Builder $query) use($id, $names) {
                            return $query->whereIn('branch_id', [$id])
                            ->whereIn('role_id', [$names]);

                        })->groupBy('branch_id')->get();
                }
            
            $company_branch = array();

            foreach($companysbranch as $names_branch)
            {

                $company_branch[] = $names_branch->modelhasbranch->id;
              
            }

                if (!$company_branch) {

                    $ambil_branch_id_users = Role_branch::with('modelhasbranch.company')->whereHas('modelhasbranch',function (Builder $query) { 
                        return $query
                        ->whereIn('user_id', [Auth::User()->id]);

                    })->groupBy('branch_id')->get();

                        foreach($ambil_branch_id_users as $names_branch)
                        {
                            $company_branchx[] = $names_branch->modelhasbranch->id;
                            
                        }   
                        
                        // dd(in_array($uri, $company_branchx));
                        if (in_array($uri, $company_branchx)) {

                            return $response;
                            
                        } else {

                            // ini adalah response jika branchnya bukan yang dimilikinya, maka user ini tidak dapat mengakses halaman yang dituju
                            // return response()->json(in_array($uri, $company_branchx), 403);
                            return redirect()->back()->withError("Maaf cabang yang anda pilih, tidak tersedia pada list cabang. \n [System Rollback]");

                        }

                    }

                if (in_array($uri, $company_branch))
            
                    return $response;
            
                 else
                    
                    return redirect()->back()->withError("Maaf cabang yang anda pilih, tidak tersedia pada list cabang. \n [System Rollback]");
          
                        $routes = ["admin.index"];
                        $route = $request->route('branch_id');

                if (in_array($route, $routes)) {
                    return new Response(view($route));
                }

            return $response;
            
        }
             
    }

}
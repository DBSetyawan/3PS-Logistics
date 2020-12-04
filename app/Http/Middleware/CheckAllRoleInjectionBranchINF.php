<?php

namespace warehouse\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;

class CheckAllRoleInjectionBranchINF
{

    public function __construct(Apiopentransactioninterface $API)
    {
        $this->managements = $API;
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
            
       $this->managements->cekAllRoleBranchAccessPoint(session()->get('id'));
            /** @var Response $response */
            $response = $next($request);

            if($request->session()->exists('id') == false){

                if ($request->path() == "home"){
    
                    return $response;
    
                }

                return abort(403);

            }

    }

}
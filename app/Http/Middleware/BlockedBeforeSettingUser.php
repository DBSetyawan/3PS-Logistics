<?php

namespace warehouse\Http\Middleware;

use Closure;
use warehouse\User;
use warehouse\Models\Companies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;

class BlockedBeforeSettingUser
{
    public function __construct(Companies $perusahaantbl)
    {
        $this->perusahaan = $perusahaantbl;
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
        $response = $next($request);

            if(Gate::allows('superusers')){

                $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();

            }

                if(Gate::allows('developer')){

                    $cek_company_by_owner = $this->perusahaan->get();
                    if ($cek_company_by_owner->isEmpty())
                    # code...
                    return abort(403);

                }

                    $fetch_response = User::with(['company','company_branchs'])->where('id','=',Auth::User()->id)->first();

                    if($fetch_response->company == null)

                        if(! Gate::allows('superusers')){
                            $companysbranchs = Company_branchs::with('company')->where(function (Builder $query){
                                return $query->whereIn('id', [session()->get('id')]);
                            })->first();

                                if($companysbranchs !== null){

                                    return $response;

                                }
                                    else
                                {
                                    return abort(403);
                                }
                        } 

                return $response;
    }

}
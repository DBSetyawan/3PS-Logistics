<?php

namespace warehouse\Http\Middleware;

use Closure;
use warehouse\Models\Companies;
use Illuminate\Support\Facades\Auth;
class CekSettingUser
{
    private $name_role;
    public function __construct(Companies $perusahaantbl)
    {
        $this->perusahaan = $perusahaantbl;
        $this->name_role = null;
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
            // Perform action
            
            // this cek user roles
            $Authorized = Auth::User()->roles;
            
                foreach($Authorized as $fetch_roles){
                    
                    $this->name_role = $fetch_roles->name;

                }

            $cek_company_by_owner = $this->perusahaan->where('owner_id', Auth::User()->id )->get();
            
            // cek user company, apakah sudah ada apa belum berdasarkan owner_id di tabel company
            if ($cek_company_by_owner->isEmpty()) 
                # code...
                // cek user role, apakah dia administrator
                // administrator tidak boleh masuk module setting role, karena di module setting role
                // terdapat sync role otomatis pada setiap step user menginput company -> company_branch -> automatically create permission all permission [ default ] 
                if($this->name_role == "administrator")
                    return abort(403);

                else 

                    return $response;
            
            else 
                // cek user company, jika sudah ada user akan masuk kedalam module setting roles ( ini khusus untuk user access [ SUPER USER ] )
                return abort(403);
            

    }

}
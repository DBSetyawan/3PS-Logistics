<?php

namespace warehouse\Http\Controllers\Services;

use warehouse\Models\Role_branch;
use Illuminate\Support\Facades\Auth;
use warehouse\Models\Company_branchs;
use warehouse\Models\Warehouse_order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;

class Cekmodeluserbranchservices implements Apiopentransactioninterface
{

    private $model;
    private $cabang;
    private $role_branchs;
    
    public function __construct(Warehouse_order $model, Company_branchs $branchs, Role_branch $rolebranch)
    {
        $this->model = $model;
        $this->cabang = $branchs;
        $this->role_branchs = $rolebranch;
    }

    public function getOpenWarehouseWithBranchId($id)
    {
        return $this->model->with('warehouse_o_status','customers_warehouse','sub_service.remarks','sub_service.item','users')
      ->whereIn('company_branch_id', [$id])
      ->orderBy('updated_at', 'DESC')->get();
    }
    
    public function getBranchIdWithdynamicChoosenBrach($id)
    {
        try {
            return $this->cabang->findOrFail($id);

          } catch (ModelNotFoundException $e) {
                return $e->getMessage();
          }
    }

    public function cekAllRoleBranchAccessPoint($id)
    {
        foreach(Auth::User()->roles as $name_roles){

            $names[] = $name_roles->id;
            
        }

        $companysbranch = $this->role_branchs->with('modelhasbranch.company')->whereHas('modelhasbranch.company',function (Builder $query) use($id, $names) {
            return $query->whereIn('id', [$id])
            ->whereIn('role_id', [$names]);
        })->groupBy('branch_id')->get();

        foreach($companysbranch as $names_branch)
        {
            $company_branch[] = $names_branch->modelhasbranch;
        }

        if($companysbranch->isEmpty()){

              $companysbranchs = $this->cabang->with('company')->where(function (Builder $query) use($id) {
                                        return $query->whereIn('company_id', [$id]);
                                    })->get();

            return response()->json($companysbranchs);

        } 
            else
                {

                    return response()->json($company_branch);

                }

    }

}

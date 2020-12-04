<?php

namespace warehouse\Http\Controllers\API;

use warehouse\User;
use warehouse\Models\Role_branch;
use warehouse\Http\Controllers\Interfaces\CekBranch;

class SettingBranch implements CekBranch 
{
    private $cabang;
    private $user;
    private $role_branch;

    public function __construct($branch = 8)
    {
      $this->cabang = $branch;
      $this->user = new User();
      $this->role_branch = new Role_branch();
    }

    public function CekBranch()
    {
      // return $this->cabang . 'pulsa tersisa.';
      // public function updateSettingUserBranch(User $pengguna, $company, $branch, Role_branch $role_branch){
       
        $fetch_users = $this->role_branch->where('branch_id', $this->ambil_branch())->first();
        // $data = WarehouseController::index($fetch_users->branch_id);
        // return $data;
        // $warehouseTolist = WarehouseController::with('warehouse_o_status','customers_warehouse','sub_service.remarks','sub_service.item','users')
        // ->where('company_branch_id', $fetch_users->branch_id)
        // ->orderBy('updated_at', 'DESC')->get();
        // $fetch_users->company_id = $company;
        // $fetch_users->company_branch_id = $branch;
        // $fetch_users->save();

        return $fetch_users;

    // }
    }

    private function ambil_branch(){
      
        // fo stuff

    }
}

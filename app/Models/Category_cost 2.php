<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Category_cost extends Model
{
    protected $table = "cost_categories";
    
    public function jobs_costs(){
        return $this->hasMany(Jobs_cost::class, 'cost_id');
    }
    public function cash_transaction_rpt(){
        return $this->hasMany(Cash_transaction_rpt::class, 'category_cost_id');
    }
}

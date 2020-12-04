<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Exports_list extends Model
{
    protected $table = "log_history_export_so";
    protected $fillable = ["status_download","fieldname","path","id_table","user_by","json_file","company_branch_id"];
    protected $dates = ["created_at","update_at"];
    protected $casts = [
      'json_file' => 'array',
  ];
    
    public function company_branch(){
      return $this->hasMany('warehouse\Models\Company_branchs','id');
    }
    
}

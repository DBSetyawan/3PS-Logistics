<?php

namespace warehouse\Http\Controllers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use warehouse\Models\Transport_orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use warehouse\Http\Controllers\Controller;

class UpdateOrCreatedHelpers 
{
    
    public static function DataTransportID($shipment_code){

        $fetch_data = Transport_orders::whereIn('order_id', [$shipment_code])
                                ->with(['customers','itemtransports.masteritemtc'])
                                    ->get();
                
                return collect($fetch_data->toArray())->map(function ($data){

                    return $data;
                
                }
            )
        ;

	}
	
	public static function attrunique($array,$key){
		$temp_array = array();
			foreach ($array as &$v) {
				if (!isset($temp_array[$v[$key]]))
				$temp_array[$v[$key]] =& $v;
			}
		
			$array = array_values($temp_array);
		return $array;
	}
	
}

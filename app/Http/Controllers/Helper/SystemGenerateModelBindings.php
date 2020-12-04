<?php

namespace warehouse\Http\Controllers\Helper;

use Illuminate\Http\Request;
use warehouse\Http\Controllers\Controller;

class SystemGenerateModelBindings extends Controller
{
	protected function isDuplicateEntryException(Illuminate\Database\QueryException $e){
		$errorCode  = $e->errorInfo[1];
		if ($errorCode === 1062) { // Duplicate Entry error code
			return true;
		}
		return false;
	}

	public static function firstOrCreate(array $attributes, array $values = [])
	{
		try {    		
			$static = (new static);
			return $static->create($attributes + $values);
		} catch (Illuminate\Database\QueryException $e){
			if($static->isDuplicateEntryException($e)) {
				return $static->where($attributes)->first();
			}
		}
	}
}

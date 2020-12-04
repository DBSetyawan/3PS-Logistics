<?php
namespace warehouse\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestCompanies extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'owner_id' => 'required',
        ];
    }
}

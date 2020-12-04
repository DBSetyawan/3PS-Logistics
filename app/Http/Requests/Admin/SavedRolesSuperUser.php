<?php
namespace warehouse\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SavedRolesSuperUser extends FormRequest
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
            'fetch_roles' => 'required',
            'giveToPermission' => 'required',
        ];
    }
}

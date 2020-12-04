<?php
namespace warehouse\Http\Requests\TransportOrder_validation;

use Illuminate\Foundation\Http\FormRequest;

class RequestUpdateDetailsTransport extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    // TODO: custom from request
    // public function attributes()
    // {
    //     return [
            /**
             *  @method custome attribute
             */ 
    //     ];
    // }
    
    public function messages()
    {
        return [
                'sub_services.required' => 'Sub services Tidak boleh kosong',
                'items_tc.required' => 'Item customer Tidak boleh kosong',

                'customers_name.required' => 'Customer Tidak boleh kosong',
                'origin_detail.required' => 'Origin Tidak boleh kosong',
                'destination_detail.required' => 'Destination Tidak boleh kosong',

                'origin_address.required' => '[ORIGIN] Origin address Tidak boleh kosong',
                'destination_address.required' => '[DESTINATION] Destination address Tidak boleh kosong',

                'pic_phone_origin.required' => '[ORIGIN] Destination address Tidak boleh kosong',
                'pic_phone_destination.required' => '[DESTINATION] Destination address Tidak boleh kosong',

                'pic_name_origin.required' => '[ORIGIN] Destination address Tidak boleh kosong',
                'pic_name_destination.required' => '[DESTINATION] Destination address Tidak boleh kosong',
            ];
    }

    public function rules(){

        return [
                 'customers_name' => 'required',
                 'origin_detail' => 'required',
                 'destination_detail' => 'required',

                 'origin_address' => 'required',
                 'destination_address' => 'required',

                 'pic_phone_origin' => 'required',
                 'pic_phone_destination' => 'required',

                 'pic_name_origin' => 'required',
                 'pic_name_destination' => 'required',
                 
                 'items_tc' => 'required',
                 'sub_services' => 'required',
            ];
    }
   
}

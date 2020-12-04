<?php
namespace warehouse\Http\Requests\TransportOrder_validation;

use Illuminate\Foundation\Http\FormRequest;

class RequestTransportOrdersValidation extends FormRequest
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
            'customers.required' => 'Customer Tidak boleh kosong',
            'origin.required'  => 'Origin Tidak boleh kosong',
            'origin_city.required'  => '[ORIGIN] City Tidak boleh kosong',
            'origin_address.required'  => '[ORIGIN] Address Tidak boleh kosong',
            'pic_phone_origin.required'  => '[ORIGIN] PIC PHONE Tidak boleh kosong',
            'pic_name_origin.required'  => '[ORIGIN] PIC NAME Tidak boleh kosong',

            'destination.required'  => 'Destination Tidak boleh kosong',
            'destination_city.required'  => '[DESTINATION] City Tidak boleh kosong',
            'destination_address.required'  => '[DESTINATION] Address Tidak boleh kosong',
            'pic_phone_destination.required'  => '[DESTINATION] PIC PHONE Tidak boleh kosong',
            'pic_name_destination.required'  => '[DESTINATION] PIC NAME Tidak boleh kosong',
          
            // 'sub_servicess.required'  => 'Sub service ',
            'items_tc.required'  => 'Items Tidak boleh kosong',
        ];
    }

    public function rules(){

        return [
                 'customers' => 'required',
                 
                 'origin' => 'required',
                 'origin_city' => 'required',
                 'origin_address' => 'required',
                 'pic_phone_origin' => 'required',
                 'pic_name_origin' => 'required',

                 'destination' => 'required',
                 'destination_city' => 'required',
                 'destination_address' => 'required',
                 'pic_phone_destination' => 'required',
                 'pic_name_destination' => 'required',
                 
                //  'sub_servicess' => 'required',
                 'items_tc' => 'required',
         ];
    }
   
}

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
            //custom incoming handle request
            'detailNotesID.required' => 'Detail Notes Tidak boleh kosong',
            'itemID.required' => 'ID item tidak teridentifikasi',
            'priceID.required' => 'Detail harga Tidak boleh kosong',
            'qtyID.required' => 'Detail quantity Tidak boleh kosong',

            'customers.required' => 'Customer Tidak boleh kosong',
            'regionName.required' => 'Region Tidak boleh kosong',
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
                 'regionName' => 'required',
                 
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

                 //handle custom request
                 'detailNotesID' => 'required',
                 'itemID' => 'required',
                 'priceID' => 'required',
                 'qtyID' => 'required'
         ];
    }
   
}

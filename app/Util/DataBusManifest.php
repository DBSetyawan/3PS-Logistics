<?php

namespace warehouse\Util;

class DataBusManifest
{
    private static $data = [];

    public static function setData($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function getData($key)
    {
        if(isset(self::$data[$key]))
        {
            return self::$data[$key];
        }

        throw new \Exception("kunci belum disetkan.. dalam indexs");
    }
}


/**
 * Use function @method DataBusManifest
 * everhere you want to use..
 */
/**
 *  function setData()
 *  {
 *      $data= DB::table('A')->where('id', '2')->first();
 *
 *       DataBus::setData('B', $data->product); 
 *
 *       // dapatkan data dengan code di bawah ini di mana saja dalam aplikasi setelah pengaturan data.
 *
 *       DataBus::getData('B'); --> dapatkan dari ref Setter
 *          
 *      //awesome
 *   }
 */
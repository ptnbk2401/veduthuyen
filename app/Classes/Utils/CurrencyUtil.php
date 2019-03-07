<?php
/**
 * Created by PhuT.
 * User: PhuT
 * Date: 03/01/2019
 * Time: 12:44 SA
 */

namespace App\Classes\Utils;


class CurrencyUtil
{
    public static function  convertCurrency($from, $to, $amount){
        $url = file_get_contents('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra');
        $json = json_decode($url, true);
        $rate = implode(" ",$json);
        $total = $rate * $amount;
        $rounded = round($total); //optional, rounds to a whole number
        return $total; //or return $rounded if you kept the rounding bit from above
    }
}
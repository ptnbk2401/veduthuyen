<?php
namespace App\Classes;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;

class Accesstrade
{

    public function __construct( )
    {
    }
    
    public static function getChiendich()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://api.accesstrade.vn/v1/campaigns',[
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'Token n9hCM0f2Jb24AKX3pTLoNHCoT8GyD2E3',
            ],
            'form_params' => [
                
            ],
            'decode_content' => false,
        ]);
        $body = $res->getBody();
        $data = json_decode($body, true);
        $arChienDich = array();
        foreach ($data['data'] as $chiendich) {
            $description = $chiendich['description'];
            $id = $chiendich['id'];
            $commission_policy = $description['commission_policy'];
            if( strpos($commission_policy, 'base64') ) {
                $commission_policy = Accesstrade::anhChinhsachHH($id, $commission_policy) ;
                $description['commission_policy'] = $commission_policy;
            }
            $str_desc = implode(' <hr/> ', array_map(
                function ($v, $k) {
                    return $k.':'.$v.'<br>';
                },
                $description,
                array_keys($description)
            ));

            $arChienDich[] = [
                'id'        => $chiendich['id'],
                'name'      => $chiendich['name'],
                'category'  => $chiendich['category'],
                'url'       => $chiendich['url'],
                'approval'  => $chiendich['approval'],
                'merchant'  => $chiendich['merchant'],
                'description'  => $str_desc,

            ];
        }
        // View::share('arChienDich', $arChienDich);
        return $arChienDich;
    }

    public static function getDataFeed($arQuery)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://api.accesstrade.vn/v1/datafeeds',[
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'Token n9hCM0f2Jb24AKX3pTLoNHCoT8GyD2E3'
            ],
            'query' => $arQuery,
            'decode_content' => false,
        ]);
        $body = $res->getBody();
        $data = json_decode($body, true);
        // dd($data);
        $arData = $data['data'];
        $count = count($data['data'])-1;
        for ($i=0;$i <= $count; $i++) {
            for ($j=$i+1; $j <= $count; $j++) {
                $img1 = $arData[$i]['image'];
                $img2 = $arData[$j]['image'];
                if( $img1 == $img2 ) {
                    $arKey[] = $j;
                }
            }
        }
        // View::share('arChienDich', $arChienDich);
        $arKey = array_unique($arKey, 0);
        foreach ($arKey as $value) {
            unset($arData[$value]);
        }
        return $arData;
    }

    public static function anhChinhsachHH($id,$commission_policy) {
        
        $data = $commission_policy ;
        $str = explode('<img src=', $data);
        $str1 = explode('"', $str[1]);
        $base64string = $str1[1];
        $filename = $id.'.png';
        $path = storage_path().'/app/media/files/accesstrade/hoahong/';
        // dd($path.$filename);
        $img = str_replace('data:image/png;base64,', '', $base64string);
        file_put_contents($path.$filename, base64_decode($img));
        $img = "<br><img src='/storage/app/media/files/accesstrade/hoahong/".$filename."' ><br>";
        return $img;
        // $offset = 1;
        // if(isset($str[$offset]))
        //   {
        //     $b = $str[$offset];
        //     dd($b);
        //   }
        // else
        //     dd($str);
        //   echo "Notice: Undefined offset: ".$offset;
    }

}
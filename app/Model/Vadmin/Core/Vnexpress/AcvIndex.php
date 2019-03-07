<?php

namespace App\Model\Vadmin\Core\Vnexpress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcvIndex extends Model
{
    protected $table = "vnexpress";
    protected $primaryKey = "id";
    public    $timestamps = true;

    public function getItemByStt($stt) {
        return DB::table('vnexpress')
            ->where('Stt',$stt)
            ->orderBy('id','DESC')
            ->first();
    }


    public static function addItem($arItem){
        return DB::table('vnexpress')->insert($arItem);
    }

    public  function getItem($id){
        return $this->findOrFail($id);
    }

    public function delItem($id){
        $objItem = $this->findOrFail($id);
        return $objItem->delete();
    }

}

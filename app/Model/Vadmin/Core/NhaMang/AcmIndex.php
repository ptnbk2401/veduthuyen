<?php

namespace App\Model\Vadmin\Core\NhaMang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcmIndex extends Model
{
    protected $table = "nha_mang";
    protected $primaryKey = "mang_mang_id";
    public    $timestamps = false;
    protected $fillable = ['name'];


    public static function getArItems() {
        return DB::table('nha_mang as a')
            ->get()->toArray();
    }
    public static function getItems() {
        return DB::table('nha_mang as a')
            ->get();
    }
    public static function getIDByName($name) {
        return DB::table('nha_mang as a')
        ->where('name','LIKE','%'.$name.'%')
        ->select('a.mang_id')
        ->first();
    }
    

    public static function addItem($arItem){
        return DB::table('nha_mang')->insert($arItem);
    }

    public function getItem($mang_id){
        return $this->findOrFail($mang_id);
    }

    public function editItem($mang_id, $arItem){
        try {
            DB::table('nha_mang')
                ->where('mang_id', $mang_id)
                ->update($arItem);
        } catch(\Exception $e) {
            return false;
        }
        return true;
    }

    
    public function delItem($mang_id){
        $objItem = $this->findOrFail($mang_id);
        return $objItem->delete();
    }


    public function delItems($arId){
        return DB::table('nha_mang')->whereIn('mang_id', $arId)->delete();
    }

    public function updateStatus($mang_id){
        $objItem = $this->findOrFail($mang_id);
        if ($objItem->active == 1) {
            $objItem->active = 0;
            $objItem->save();
            return 1;
        } else {
            $objItem->active = 1;
            $objItem->save();
            return 0;
        }
    }
}

<?php

namespace App\Model\Vadmin\Core\Sim;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcsIndex extends Model
{
    protected $table = "vne_sim";
    protected $primaryKey = "id";
    public    $timestamps = false;
    protected $fillable = ['pnumber', 'nha_mang', 'active'];


    public static function getItemsAll() {
        return DB::table('vne_sim as a')
            ->join('nha_mang as n','a.nha_mang', 'n.mang_id' )
            ->get()->toArray();
    }
    public static function getItemsByMang($mang_id) {
        return DB::table('vne_sim as a')
            ->join('nha_mang as n','a.nha_mang', 'n.mang_id' )
            ->where('a.nha_mang',$mang_id)
            ->get()->toArray();
    }
    public static function getItems() {
        return DB::table('vne_sim as a')
            ->join('nha_mang as n','a.nha_mang', 'n.mang_id' )
            ->paginate(getenv('USER_PAGE'));
    }
    

    public static function addItem($arItem){
        return DB::table('vne_sim')->insert($arItem);
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function editItem($id, $arItem){
        try {
            DB::table('vne_sim')
                ->where('id', $id)
                ->update($arItem);
        } catch(\Exception $e) {
            return false;
        }
        return true;
    }

    
    public function delItem($id){
        $objItem = $this->findOrFail($id);
        return $objItem->delete();
    }


    public function delItems($arId){
        return DB::table('vne_sim')->whereIn('id', $arId)->delete();
    }

    public function updateStatus($id){
        $objItem = $this->findOrFail($id);
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

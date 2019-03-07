<?php

namespace App\Model\Vadmin\Core\Donhang;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcdIndex extends Model
{
    protected $table = "donhang";
    protected $primaryKey = "id";
    public    $timestamps = false;

    public static function getItems() {
        return DB::table('donhang as d')
            ->join('vne_product as p', 'p.product_id', '=', 'd.id_tour')
            ->select('d.*','p.pname','p.giave')
            ->orderBy('d.id', 'DESC')
            ->paginate(getenv('ADMIN_PAGE'));
    }

    public function addItem($arItem){
        return DB::table('donhang')->insertGetId($arItem);
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function editItem($id, $arItem){
        try {
            DB::table('donhang')
                ->where('id', $id)
                ->update($arItem);
        } catch(\Exception $e) {
            return false;
        }
        return true;
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

    public function delItem($id){
        $objItem = $this->findOrFail($id);
        return $objItem->delete();
    }

    public function delItems($arId){
        return DB::table('donhang')->whereIn('id', $arId)->delete();
    }


}

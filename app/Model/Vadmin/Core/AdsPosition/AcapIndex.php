<?php

namespace App\Model\Vadmin\Core\AdsPosition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcapIndex extends Model
{
    protected $table = "vne_ads_position";
    protected $primaryKey = "position_id";
    public $timestamps = false;

    public static function getItems()
    {
        return AcapIndex::all();
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }

    public function editItem($id, $arItem)
    {
        try {
            DB::table('vne_ads_position')
                ->where('position_id', $id)
                ->update($arItem);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function addItem($arItem)
    {
        return DB::table('vne_ads_position')->insertGetId($arItem);
    }

    public function delItem($id)
    {
        return DB::table('vne_ads_position')->where('position_id', $id)->delete();
    }
}

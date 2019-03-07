<?php

namespace App\Model\Vadmin\Core\Advertisement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcaIndex extends Model
{
    protected $table = "vne_ads";
    protected $primaryKey = "ads_id";
    public $timestamps = false;

    public static function getItems()
    {
        return DB::table('vne_ads as a')
            ->join('vne_ads_position as p', 'a.position_id', '=', 'p.position_id')
            ->select('a.*', 'p.name')
            ->orderBy('a.ads_id', 'DESC')
            ->paginate(getenv('ADMIN_PAGE'));
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }

    public function editItem($id, $arItem)
    {
        try {
            DB::table('vne_ads')
                ->where('ads_id', $id)
                ->update($arItem);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function addItem($arItem)
    {
        return DB::table('vne_ads')->insertGetId($arItem);
    }

    public function delItem($id)
    {
        return DB::table('vne_ads')->where('ads_id', $id)->delete();
    }

    public function getItemPl($code) {
        $now = date('Y-m-d');
        return DB::table('vne_ads as a')
            ->join('vne_ads_position as ap','ap.position_id','a.position_id')
            ->where('ap.code',$code)
            ->where('a.begin_at','<=',$now)
            ->where('a.end_at','>=',$now)
            ->orderBy('a.ads_id','DESC')
            ->select('a.*')
            ->first();
    }
}

<?php

namespace App\Model\Vadmin\Core\About;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcaIndex extends Model
{
    protected $table = "vne_about";
    protected $primaryKey = "about_id";
    public $timestamps = false;

    public static function getItems()
    {
        return AcaIndex::all();
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }

    public function editItem($id, $arItem)
    {
        try {
            DB::table('vne_about')
                ->where('about_id', $id)
                ->update($arItem);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}

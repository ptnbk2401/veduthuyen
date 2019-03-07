<?php

namespace App\Model\Vadmin\Core\ArticleTabs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcaIndex extends Model
{
    protected $table = "article_tabs";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function article()
    {
        return $this->hasOne('App\Model\Vadmin\Core\Article\AcaIndex');
    }

    public static function getItems()
    {
        return AcaIndex::all();
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }

    public function getItemByArticle($article_id)
    {
        return DB::table('article_tabs')
        ->where('article_id',$article_id)->first();
    }
    public function addItem($arItem)
    {
        return DB::table('article_tabs')
        ->insert($arItem);
    }

    public function editItem($id, $arItem)
    {
        try {
            DB::table('article_tabs')
                ->where('id', $id)
                ->update($arItem);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}

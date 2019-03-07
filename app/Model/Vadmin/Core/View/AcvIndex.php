<?php

namespace App\Model\Vadmin\Core\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcvIndex extends Model
{
    protected $table = "count_view";
    protected $primaryKey = "id";
    public $timestamps = false;

    public static function getItems()
    {
        return AcvIndex::all();
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }
    public function countItem($article_id)
    {
        $CKview = 'luotxem_'.$article_id;
        if(!isset($_COOKIE[$CKview])){
            setcookie("$CKview","1",time()+1800);
            $objItem = AcvIndex::where('article_id',$article_id)->first();
            if(empty($objItem)){
                AcvIndex::insert(['article_id' => $article_id,'view' => 1]);
            } else {
                $objItem->increment('view', 1);
            }
        }
    }

    public function editItem($id, $arItem)
    {
        try {
            DB::table('count_view')
                ->where('id', $id)
                ->update($arItem);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}

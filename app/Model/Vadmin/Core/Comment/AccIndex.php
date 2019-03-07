<?php

namespace App\Model\Vadmin\Core\Comment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccIndex extends Model
{
    protected $table = "vne_comment";
    protected $primaryKey = "fcomment_id";
    public $timestamps = true;

    public static function getItems($id = 0)
    {
        return DB::table('vne_comment as cm')
            ->leftjoin('users as u', 'cm.user_id', '=', 'u.id')
            ->join('vne_article as a', 'a.article_id', '=', 'cm.article_id')
            ->select('cm.*', 'u.first_name', 'u.last_name', 'a.aname')
            ->where('parent_id', '=', $id)
            ->orderBy('fcomment_id', 'DESC')
            ->paginate(getenv('ADMIN_PAGE'));
    }
    public static function getItemsByPost($article_id,$parent_id)
    {
        return DB::table('vne_comment as cm')
            ->leftJoin('users as u', 'cm.user_id', '=', 'u.id')
            ->join('vne_article as a', 'a.article_id', '=', 'cm.article_id')
            ->select('cm.*', 'u.username','u.avatar')
            ->where('cm.active', '=', 1)
            ->where('cm.parent_id', '=', $parent_id)
            ->where('cm.article_id', '=', $article_id)
            ->orderBy('fcomment_id', 'DESC')
            ->take(10)->get();
    }
    public static function getItemsNew()
    {
        return DB::table('vne_comment as cm')
            ->leftjoin('users as u', 'cm.user_id', '=', 'u.id')
            ->join('vne_article as a', 'a.article_id', '=', 'cm.article_id')
            ->select('cm.*','u.email','u.avatar','a.aname')
            ->where('cm.active', '=', 1)
            ->orderBy('fcomment_id', 'DESC')
            ->take(5)->get();
    }
    public static function coutItemsByPost($article_id)
    {
        return DB::table('vne_comment as cm')
            ->select('cm.fcomment_id')
            ->where('cm.article_id',$article_id)
            ->where('cm.active', '=', 1)
            ->get()->count();
    }

    public function getItemsAll()
    {
        return DB::table('vne_comment')->orderBy('fcomment_id', 'DESC')
            ->where('active', 1)->get()->toArray();
    }

    public function updateStatus($id)
    {
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

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }

    public function delItem($id)
    {
        $objItem = $this->findOrFail($id);
        return $objItem->delete();
    }

    public function delItems($arId)
    {
        return DB::table('vne_comment')->whereIn('fcomment_id', $arId)->delete();
    }
    public function addItem($arItem)
    {
        return DB::table('vne_comment')->insert($arItem);
    }

    public function getItemsByArticleId($articleId)
    {
        return DB::table('vne_comment')->where('article_id', $articleId)->get();
    }

    public function getItemsSearch($arItem = array())
    {
        $objQuery = DB::table('vne_comment as cm')
            ->join('users as u', 'cm.user_id', '=', 'u.id')
            ->join('vne_article as a', 'a.article_id', '=', 'cm.article_id')
            ->select('cm.*', 'u.first_name', 'u.last_name', 'a.aname');

        if ($arItem['aname'] != '' && $arItem['aname'] != null) {
            $objQuery->where('a.aname', 'like', '%' . $arItem['aname'] . '%');
        }

        if ($arItem['active'] != '' && $arItem['active'] != null) {
            $objQuery->where('cm.active', '=', $arItem['active']);
        }
        return $objQuery->orderBy('fcomment_id', 'DESC')->paginate(getenv('ADMIN_PAGE'));
    }
}

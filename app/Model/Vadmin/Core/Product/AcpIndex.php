<?php

namespace App\Model\Vadmin\Core\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcpIndex extends Model
{
    protected $table = "vne_product";
    protected $primaryKey = "product_id";
    public    $timestamps = true;

    public function getItems() {
        return DB::table('vne_product as a')
            ->join('vne_pcat as c', 'c.cat_id', '=', 'a.cat_id')
            ->select('a.*', 'c.cname')
            ->orderBy('a.product_id', 'DESC')
            ->paginate(getenv('ADMIN_PAGE'));
    }
    public function getItemsByCat($cat_id) {
        return DB::table('vne_product as a')
            ->join('vne_pcat as c', 'c.cat_id', '=', 'a.cat_id')
            ->select('a.*', 'c.cname')
            ->where('a.active', '=', 1)
            ->where('a.cat_id', '=', $cat_id)
            ->orderBy('a.product_id', 'DESC')
            ->get();
    }

    public function addItem($arItem){
        return DB::table('vne_product')->insertGetId($arItem);
    }

    public function addItemProductImages($arItem){
        return DB::table('product_image')->insert($arItem);
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }
    public function getItemCode($codetour){
        return DB::table('vne_product as a')
            ->where('a.active', '=', 1)
            ->where('a.code', '=', $codetour)
            ->first();
    }
    public function getImages($product_id){
        return DB::table('product_image')
            ->where('product_id', $product_id)
            ->get();
    }

    public function editItem($id, $arItem){
        try {
            DB::table('vne_product')
                ->where('product_id', $id)
                ->update($arItem);
        } catch(\Exception $e) {
            dd($e);
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

    public function delItemByCatId($catId)
    {
        return DB::table('vne_product')->where('cat_id', '=', $catId)->delete();
    }

    public function getItemsByCatId($catId)
    {
        return DB::table('vne_product')->where('cat_id', '=', $catId)->get();
    }

    public function delItems($arId){
        return DB::table('vne_product')->whereIn('product_id', $arId)->delete();
    }

    public function getItemsSearch($arItem = array()){
        $objQuery =DB::table('vne_product as a')
            ->join('vne_pcat as c', 'c.cat_id', '=', 'a.cat_id')
            ->select('a.*', 'c.cname');
        if ($arItem['name'] != '' && $arItem['name'] != null) {
            $objQuery->where('a.pname', 'like', '%'.$arItem['name'].'%');
        }

        if ($arItem['cat_id'] != '' && $arItem['cat_id'] != null) {
            $objQuery->where('a.cat_id', '=', $arItem['cat_id']);
        }

        if ($arItem['active'] != '' && $arItem['active'] != null) {
            $objQuery->where('a.active', '=', $arItem['active']);
        }

        return $objQuery->orderBy('a.product_id', 'DESC')->paginate(getenv('ADMIN_PAGE'));
    }
    public function getItemsBySearch($search)
    {
        return DB::table('vne_product as a')
        ->join('vne_pcat as c','c.cat_id','a.cat_id')
        ->select('a.pname','a.product_id')
        ->where(function($query) use ($search) {
            return $query->where('a.pname', 'LIKE','%'.$search.'%')
                        ->orWhere('c.cname', 'LIKE','%'.$search.'%');
        })
        ->where('a.active', '=', 1)
        ->orderBy('a.product_id', 'DESC')
        ->take(10)
        ->get();
    }
    public function getItemsTourPopular($count,$id_parent) {
        $arIDCat = $this->getArIDCat($id_parent);
        return DB::table('vne_product as a')
            ->join('vne_pcat as c', 'c.cat_id', '=', 'a.cat_id')
            ->select('a.*', 'c.cname')
            ->whereIn('c.cat_id',$arIDCat )
            ->orderBy('a.product_id', 'DESC')
            ->limit($count)->get();
    }
    public function getItemsTourPL($id_cat) {
        $arIDCat = $this->getArIDCat($id_cat);
        return DB::table('vne_product as a')
            ->join('vne_pcat as c', 'c.cat_id', '=', 'a.cat_id')
            ->select('a.*', 'c.cname')
            ->whereIn('c.cat_id',$arIDCat )
            ->where('a.active', '=', 1)
            ->orderBy('a.product_id', 'DESC')
            ->get();
    }
    public function getArIDCat($id_parent){
        $arId[] = $id_parent;
        $objID = DB::table('vne_pcat as c')->select('cat_id')->orWhere('parent_id',$id_parent)
        ->get()->toArray();
        if(!empty($objID)){
            foreach ($objID as  $value) {
                $arId[] = $value->cat_id;
            }
        }
        return  $arId;
    }
}

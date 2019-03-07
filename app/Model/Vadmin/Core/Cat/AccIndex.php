<?php
namespace App\Model\Vadmin\Core\Cat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Nestable\NestableTrait;

class AccIndex extends Model
{
    protected $table = "vne_cat";
    protected $primaryKey = "cat_id";
    protected $parent = 'parent_id';
    public $timestamps = false;
    use NestableTrait;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('vne_cat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->paginate(getenv('USER_PAGE'));
    }
    public function getItemsActive(){
        return DB::table('vne_cat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->where('active', 1)
            ->get();
    }
    public function getSubCatActive($cat_id){
        return DB::table('vne_cat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->where('active', 1)
            ->where('parent_id', $cat_id)
            ->get();
    }


    public function getItemsAll(){
        return DB::table('vne_cat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->get()->toArray();
    }


    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function addItem($arItem){
        return DB::table('vne_cat')->insertGetId($arItem);
    }

    public function delItem($id){
        return DB::table('vne_cat')->where('cat_id', $id)->delete();
    }
    public function delItems($arId){
        return DB::table('vne_cat')->whereIn('cat_id', $arId)->delete();
    }

    public function editItem($id, $arItem){
        return DB::table('vne_cat')->where('cat_id', $id)->update($arItem);
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

    public function getArItemsAll(){
        return $this->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')->get()->toArray();
    }

    //for nested
    public function ntGetItems(){
        return $this->nested()->orderBy('sort', 'DESC')->get();
    }
    public function ntGetItemsOfParent($parent_id){
        return $this->nested()->parent($parent_id)->orderBy('sort', 'DESC')->get();
    }

    public function getItemByCode($code){
        return DB::table('vne_cat as a')
            ->where('a.active', '=', 1)
            ->where('a.code', '=', $code)
            ->first();
    }


}



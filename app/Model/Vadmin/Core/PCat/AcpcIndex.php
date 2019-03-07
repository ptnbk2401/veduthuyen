<?php
namespace App\Model\Vadmin\Core\PCat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Nestable\NestableTrait;

class AcpcIndex extends Model
{
    protected $table = "vne_pcat";
    protected $primaryKey = "cat_id";
    protected $parent = 'parent_id';
    public $timestamps = false;
    use NestableTrait;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('vne_pcat')->orderBy('sort', 'DESC')->orderBy('active', 'DESC')->orderBy('cat_id', 'DESC')
            ->get();
    }
    public function getItemsActive(){
        return DB::table('vne_pcat as pc')
            ->leftjoin('cat_url as cu','cu.cat_id','pc.cat_id')
            ->select('pc.*','cu.url')
            ->orderBy('sort', 'DESC')->orderBy('pc.cat_id', 'DESC')
            ->where('active', 1)
            ->get();
    }
    public function getParentActive(){
        return DB::table('vne_pcat as pc')
            ->leftjoin('cat_url as cu','cu.cat_id','pc.cat_id')
            ->select('pc.*','cu.url')
            ->orderBy('sort', 'DESC')->orderBy('pc.cat_id', 'DESC')
            ->where('active', 1)
            ->where('pc.parent_id', 0)
            ->get();
    }
    public function getSubActive($parent_id){
        return DB::table('vne_pcat as pc')
            ->leftjoin('cat_url as cu','cu.cat_id','pc.cat_id')
            ->select('pc.*','cu.url')
            ->orderBy('sort', 'DESC')->orderBy('pc.cat_id', 'DESC')
            ->where('active', 1)
            ->where('parent_id', $parent_id)
            ->get();
    }
    public function checkParent($cat_id){
        $a = DB::table('vne_pcat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->where('parent_id', $cat_id)
            ->count();
        return $a;    
    }

    public function getItemsAll(){
        return DB::table('vne_pcat')->orderBy('sort', 'DESC')->orderBy('cat_id', 'DESC')
            ->get()->toArray();
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }
    
    public function getItemByCode($code){
        return DB::table('vne_pcat as a')
            ->where('a.active', '=', 1)
            ->where('a.code', '=', $code)
            ->first();
    }
    

    public function addItem($arItem){
        return DB::table('vne_pcat')->insertGetId($arItem);
    }

    public function delItem($id){
        return DB::table('vne_pcat')->where('cat_id', $id)->delete();
    }
    public function delItems($arId){
        return DB::table('vne_pcat')->whereIn('cat_id', $arId)->delete();
    }

    public function editItem($id, $arItem){
        return DB::table('vne_pcat')->where('cat_id', $id)->update($arItem);
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


    public function getURLCat($cat_id){
        return DB::table('cat_url')->where('cat_id',$cat_id)->get();
    }
    public function addURLCat($arItem){
        return DB::table('cat_url')->insertGetId($arItem);
    }
    public function editURLCat($id, $arItem){
        return DB::table('cat_url')->where('cu_id', $id)->update($arItem);
    }
    public function findURLCat($cat_id,$th_id){
        return DB::table('cat_url as cu')
        ->join('thuonghieu as th','th.th_id','cu.th_id')
        ->select('cu.*','th.code','th.picture','th.domain')
        ->where('cu.cat_id',$cat_id)
        ->where('cu.th_id',$th_id)
        ->first();
    }


}



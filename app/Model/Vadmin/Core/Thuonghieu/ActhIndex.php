<?php
namespace App\Model\Vadmin\Core\Thuonghieu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActhIndex extends Model
{
    protected $table = "thuonghieu";
    protected $primaryKey = "th_id";
    public $timestamps = false;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('thuonghieu')->orderBy('sort', 'ASC')->orderBy('th_id', 'DESC')
            ->get();
    }
    public function getItemsAuto(){
        return DB::table('thuonghieu')
        ->where('autoSP',1)
        ->orderBy('sort', 'ASC')
        ->orderBy('th_id', 'DESC')
            ->get();
    }

    public function getItemsAll(){
        return DB::table('thuonghieu')->orderBy('sort', 'ASC')->orderBy('th_id', 'DESC')
            ->get()->toArray();
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function addItem($arItem){
        return DB::table('thuonghieu')->insert($arItem);
    }

    public function delItem($id){
        return DB::table('thuonghieu')->where('th_id', $id)->delete();
    }
    public function delItems($arId){
        return DB::table('thuonghieu')->whereIn('th_id', $arId)->delete();
    }

    public function editItem($id, $arItem){
        return DB::table('thuonghieu')->where('th_id', $id)->update($arItem);
    }

    public function updateStatus($id){
        $objItem = $this->findOrFail($id);
        if ($objItem->autoSP == 1) {
            $objItem->autoSP = 0;
            $objItem->save();
            return 1;
        } else {
            $objItem->autoSP = 1;
            $objItem->save();
            return 0;
        }
    }

}



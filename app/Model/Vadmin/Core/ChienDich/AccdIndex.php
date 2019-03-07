<?php
namespace App\Model\Vadmin\Core\ChienDich;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccdIndex extends Model
{
    protected $table = "chiendich";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('chiendich')
            ->orderBy('active', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getArItems(){
        return DB::table('chiendich')
            ->orderBy('active', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();
    }
   
    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function addItems($arChienDich){
        foreach ($arChienDich as $arItem) {
            if( DB::table('chiendich')->find($arItem['id']) ) {
                DB::table('chiendich')->whereId( $arItem['id'] )->update($arItem);
            } else {
                DB::table('chiendich')->insert($arItem);
            }
        }
        return 1;
    }

    public function editItem($id, $arItem){
        return DB::table('chiendich')->whereId($id)->update(['name' => $arItem['name'] ,'domain' =>$arItem['domain'] ,]);
    }

    public function updateActive($id, $active){
        return DB::table('chiendich')->whereId($id)->update(['active' => $active]);
    }

}



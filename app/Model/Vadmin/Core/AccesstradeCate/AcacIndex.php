<?php
namespace App\Model\Vadmin\Core\AccesstradeCate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AcacIndex extends Model
{
    protected $table = "accesstrade_cate";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('accesstrade_cate')
            ->orderBy('cate', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
    }
    
    public function findItem($cate){
        return DB::table('accesstrade_cate')
            ->whereCate($cate)
            ->first();
    }

    public function addItem($cate){
        if( $this->findItem($cate) ) {
            return 1 ;
        } else {
            DB::table('accesstrade_cate')->insert(['cate' => $cate]);
        }
        return 1;
    }


}



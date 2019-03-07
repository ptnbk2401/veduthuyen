<?php
namespace App\Model\Vadmin\Core\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Nestable\NestableTrait;

class AcpiIndex extends Model 
{
    protected $table = "product_image";
    protected $primaryKey = "pi_id";
    public $timestamps = false;
    use NestableTrait;

    public function __construct(){

    }

    public function getItems(){
        return DB::table('product_image')->orderBy('sort', 'ASC')->orderBy('id', 'DESC')
            ->paginate(getenv('USER_PAGE'));
    }
    

    public function getItem($id){
        return $this->findOrFail($id);
    }
    
    public function getItemByProduct($id){
        return DB::table('product_image')->where('product_id', $id)->get();
    }

    public function addItem($arItem){
        return DB::table('product_image')->insertGetId($arItem);
    }

    public function delItem($id){
        return DB::table('product_image')->where('id', $id)->delete();
    }
    public function delItemByProduct($product_id){
        return DB::table('product_image')->where('product_id', $product_id)->delete();
    }
    public function editItem($id, $arItem){
        return DB::table('product_image')->where('id', $id)->update($arItem);
    }

    

}



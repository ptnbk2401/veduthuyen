<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\Slide;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Article\AcaIndex;
use App\Model\Vadmin\Core\Product\AcpIndex;
use App\Model\Vadmin\Core\Slide\AcsIndex;
use Illuminate\Http\Request;


class AcsIndexController extends Controller
{
    public function __construct(AcsIndex $objmAcsIndex)
    {
        $this->objmAcsIndex = $objmAcsIndex;
    }

    public function activeStatus(Request $request)
    {
        $id = $request->aid;
        if ($this->objmAcsIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>';
        }
    }
    public function searchArticle(AcpIndex $objmAcpIndex,Request $request)
    {
        $search = $request->search;
        $Items =  $objmAcpIndex->getItemsBySearch($search);
        return response()->json(['items'=>$Items]);
    }
    public function getData(AcpIndex $objmAcpIndex,Request $request)
    {
        $product_id = $request->product_id;
        $Item =  $objmAcpIndex->getItem($product_id);
        $link = route('vpublic.core.pcbloglist.detail',[$Item->product_id,str_slug($Item->pname)]);
        $picture = $Item->picture;
        $data = ['link'=>$link,'picture'=>$picture];
        return $data;
    }
}

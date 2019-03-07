<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\Thuonghieu;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use Illuminate\Http\Request;


class ActhIndexController extends Controller
{
    public function __construct(ActhIndex $objmActhIndex)
    {
        $this->objmActhIndex = $objmActhIndex;
    }

    public function activeStatus(Request $request)
    {
        $id = $request->aid;
        if ($this->objmActhIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>';
        }
    }
}

<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\Product;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Product\AcpIndex;
use Illuminate\Http\Request;


class AcpIndexController extends Controller
{
    public function __construct(AcpIndex $objmAcpIndex)
    {
        $this->objmAcpIndex = $objmAcpIndex;
    }

    public function activeStatus(Request $request)
    {
        $id = $request->aid;
        if ($this->objmAcpIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>';
        }
    }
}

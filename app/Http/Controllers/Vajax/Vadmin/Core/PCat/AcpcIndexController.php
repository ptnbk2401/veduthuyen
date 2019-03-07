<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\PCat;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\PCat\AcpcIndex;
use Illuminate\Http\Request;


class AcpcIndexController extends Controller
{
    public function __construct(AcpcIndex $objmAcpcIndex)
    {
        $this->objmAcpcIndex = $objmAcpcIndex;
    }

    public function activeStatus(Request $request) {
        $id = $request->aid;
        if ($this->objmAcpcIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #26b99a;"></i>';
        }
    }
}

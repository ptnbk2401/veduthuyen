<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\Cat;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Cat\AccIndex;
use Illuminate\Http\Request;


class AccIndexController extends Controller
{
    public function __construct(AccIndex $objmAccIndex)
    {
        $this->objmAccIndex = $objmAccIndex;
    }

    public function activeStatus(Request $request) {
        $id = $request->aid;
        if ($this->objmAccIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #26b99a;"></i>';
        }
    }
}

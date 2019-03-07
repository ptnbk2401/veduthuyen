<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\Sim;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Sim\AcsIndex;
use Illuminate\Http\Request;


class AcsIndexController extends Controller
{
    public function __construct(AcsIndex $objmAcsIndex)
    {
        $this->objmAcsIndex = $objmAcsIndex;
    }

    public function activeSim(Request $request)
    {
        $id = $request->aid;        
        if ($this->objmAcsIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #26b99a;"></i>';
        }
    }
}

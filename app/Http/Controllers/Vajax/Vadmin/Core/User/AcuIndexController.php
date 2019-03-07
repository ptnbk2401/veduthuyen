<?php
namespace App\Http\Controllers\Vajax\Vadmin\Core\User;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Group\AcgIndex;
use App\Model\Vadmin\Core\User\User;
use Illuminate\Http\Request;


class AcuIndexController extends Controller
{
    public function __construct(User $objmUser  ,AcgIndex $objmVNEGroup)
    {
        $this->objmUser = $objmUser;
        $this->objmVNEGroup = $objmVNEGroup;
    }

    public function activeUser(Request $request)
    {
        $id = $request->aid;
        if ($this->objmUser->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #26b99a;"></i>';
        }
    }
}

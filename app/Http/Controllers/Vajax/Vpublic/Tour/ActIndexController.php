<?php

namespace App\Http\Controllers\Vajax\Vpublic\Tour;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vpublic\Core\DatVe\DatVeRequest;
use App\Model\Vadmin\Core\Donhang\AcdIndex;
use Illuminate\Http\Request;

class ActIndexController extends Controller
{
    public function __construct(AcdIndex $objmAcdIndex)
    {
        $this->objmAcdIndex = $objmAcdIndex;
    }

    public function getDatVe(DatVeRequest $request)
    {
        $id = $request->id;
        $captchaDatVe=$request->captchaDatVe;
        $fullname=$request->fullname;
        $email=$request->email;
        $diachi=$request->diachi;
        $phone=$request->phone;
        $NgayKH=date('Y-m-d',strtotime($request->NgayKH));
        $NL=$request->NL;
        $TE=$request->TE;
        $gia=$request->gia;
        $arOrder = [
        	'id_tour' => $id,
        	'hoten' => $fullname,
        	'email' => $email,
        	'diachi' => $diachi,
        	'dienthoai' => $phone,
        	'ngaykhoihanh' => $NgayKH,
        	'venguoilon' => $NL,
        	'vetreem' => $TE,
        	'giave' => $gia,
        ];
        if( $this->objmAcdIndex->addItem($arOrder) ) {
        	return 1;
        }
        return 0;
    }


}



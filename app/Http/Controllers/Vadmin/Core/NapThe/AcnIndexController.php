<?php

namespace App\Http\Controllers\Vadmin\Core\NapThe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcnIndexController extends Controller
{


    public function __construct(){
 		
    }

    public function index(Request $request){
        return view('vadmin.core.napthe.acnindex.index');
    }

    public function postCard(Request $request){
    	$trumthe247 = new Trumthe247C();
		$note = 'noi dung';
		
		$charge_result = $trumthe247->ChargeCard($type, $seri, $pin, $amount, $note); //thực hiện đẩy thẻ lên hệ thống TrumThe247.Com
		
		if($charge_result == false) { //Có lỗi trong quá trình đẩy thẻ.
			$err = 'Có lỗi trong quá trình xử lý, xin thử lại hoặc liên hệ Admin';
		} else if(is_string($charge_result)) { //Có lỗi trả về của hệ thống TRUMTHE247.COM.
			$err = $charge_result;
		} else if(is_object($charge_result)) { //Gửi thẻ thành công lên hệ thống.
			$success = 'Gửi thẻ thành công!';
		} else {
			$err = 'Có lỗi trong quá trình xử lý';
		}
    }

    public function callBack(){
    	
    }


}

<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

class Trumthe247 {
	private $API_KEY = 'fe997932a723a336422b6fae47b96b42'; //Api Key của tài khoản quý khách trên hệ thống TRUMTHE247.COM
	private $API_SECRET = '5d8a14f8ec5076dd32894a77a2d7657d'; //Api Serect của tài khoản quý khách trên hệ thống TRUMTHE247.COM
	private $URL_CHARGE_API = 'https://trumthe247.com/restapi/charge'; //Url post nạp thẻ. Không đổi.
	private $DEBUG_FILE_LOG = true; // True nếu cần ghi log, false nếu ko cần.
	private $FILE_LOG_SUCCESS = 'trumthe247_success.txt'; //Tên file logs thành công.
	private $FILE_LOG_ERROR = 'trumthe247_error.txt'; //Tên file logs thất bại.
	
	public function ValidateCallback() { //Hàm kiểm tra callback từ trumthe247.com
		if(isset(
			$_POST['api_key'],
			$_POST['api_secret'],
			$_POST['status'],
			$_POST['desc'],
			$_POST['card_data']['serial'],
			$_POST['card_data']['pin'],
			$_POST['card_data']['card_type'],
			$_POST['card_data']['amount'],
			$_POST['card_data']['real_amount'],
			$_POST['card_data']['charge_time']
		)) {
			if($_POST['api_key'] == $this->API_KEY && $_POST['api_secret'] == $this->API_SECRET) { //Xác thực API, tránh kẻ lạ gửi dữ liệu ảo.
				return $_POST; //xác thực thành công, return mảng dữ liệu từ TRUMTHE247.COM trả về.
			}
		}
		
		return false; //Xác thực callback thất bại.
	}
	
	public function ChargeCard($telco, $serial, $pin, $amount, $note) { //Hàm gửi dữ liệu thẻ lên hệ thống trumthe247.com
		/*
			$telco: nhà mạng. Vd: VTT, VMS, VNP.
			$serial: số seri của thẻ.
			$pin: mã thẻ.
			$amount: mệnh giá thẻ.
			$note: ghi chú. Quý khách có thể thêm giá trị để xác thực giao dịch cho khách hàng của quý khách. Ví dụ: User ID khách hàng của quý khách, Mã GD, ...
		*/
		$validate = $this->ValidateCard($telco, $serial, $pin); //Xác thực định dạng thẻ.
		if($validate != true) {
			if($this->DEBUG_FILE_LOG == true) //Kiểm tra nếu Debug ghi file log = true thì thực hiện ghi dữ liệu đẩy thẻ vào file log.
				$this->WriteLog($this->FILE_LOG_ERROR, $validate);
				
			return $validate;
		}
		
		$dataPost = array( //Mảng chứa dữ liệu đẩy thẻ lên server TrumThe247.Com
			'card' => $telco,
			'amount' => $amount,
			'serial' => $serial,
			'pin' => $pin,
			'api_key' => $this->API_KEY,
			'api_secret' => $this->API_SECRET,
			'content' => $note
		);
		
		$charge_response = $this->CurlPost($this->URL_CHARGE_API, $dataPost); //Thực hiện POST cURL dữ liệu lên Server.
		$response_object = json_decode($charge_response, false); //Parse kết quả đẩy thẻ về dạng đối tượng Object.
		if(empty($response_object->status)) { //Kiểm tra nếu không tồn tại Response Status, thì là kết quả đẩy thẻ lên Server TrumThe247 bị lỗi. Thực hiện ghi vào file logs, theo dõi file để kiểm tra lỗi.
			if($this->DEBUG_FILE_LOG == true)
				$this->WriteLog($this->FILE_LOG_ERROR, $charge_response);
			
			return false;
		}
		
		if($response_object->status != 1) { //Kiểm tra nếu Response Status khác 1, tức là thẻ đẩy lên bị sai hoặc cấu hình dữ liệu sai, theo dõi mô tả lỗi hoặc so sánh Status Code trong bảng mã lỗi ở file Document hướng dẫn.
			if($this->DEBUG_FILE_LOG == true) //Kiểm tra nếu Debug ghi file log = true thì thực hiện ghi dữ liệu đẩy thẻ vào file log.
				$this->WriteLog($this->FILE_LOG_ERROR, $charge_response);
			
			return $response_object->desc;
		}
		
		if($this->DEBUG_FILE_LOG == true) //Kiểm tra nếu Debug ghi file log = true thì thực hiện ghi dữ liệu đẩy thẻ vào file log.
			$this->WriteLog($this->FILE_LOG_SUCCESS, $charge_response); //Ghi kết quả đẩy thẻ thành công vào file log thành công.
				
		return $response_object; //Trả về kết đối tượng Object.
	}
	
	private function ValidateCard($telco, $serial, $pin) { //Hàm kiểm tra định dạng thẻ.
		$s_length = strlen($serial);
		$p_length = strlen($pin);
		
		if($telco == 'VTT' || $telco == 'VTT2') {
			if($s_length != 11 && $s_length != 14)
				return 'Số serial thẻ không đúng.';
			
			if($p_length != 13 && $p_length != 15)
				return 'Mã thẻ không đúng.';
		}
		
		if($telco == 'VMS' || $telco == 'VMS2') {
			if($s_length != 15)
				return 'Số serial thẻ không đúng.';
			
			if($p_length != 12)
				return 'Mã thẻ không đúng.';
		}
		
		if($telco == 'VNP' || $telco == 'VNP2') {
			if($s_length != 14)
				return 'Số serial thẻ không đúng.';
			
			if($p_length != 14)
				return 'Mã thẻ không đúng.';
		}
		
		return true;
	}
	
	private function CurlPost($url, $dataPost) { //Hàm cURL POST dữ liệu.
		if(!is_array($dataPost))
			return false;
		
		$dataPost = http_build_query($dataPost);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
		$ref = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Nếu kết quả cURL bị lỗi xác thực tên miền, thử thay thế $ref = tên miền của bạn. Ví dụ: $ref = 'https://trumthe247.com';
		curl_setopt($ch, CURLOPT_REFERER, $ref);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		
		if(curl_error($ch))
			$error_msg = curl_error($ch);
		
		curl_close($ch);
		
		if(isset($error_msg))
			return $error_msg;
		
		return $result;
	}
	
	public function WriteLog($file_name, $content) { //Hàm xử lý việc ghi file log.
		if(empty($file_name))
			return false;
		
		$fp = fopen($file_name, 'a');
		if(fwrite($fp, date('H:i:s d/m/Y', time()).' - '.$content.PHP_EOL) == false)
			return false;
		fclose($fp);
		
		return true;
	}
}

?>
<?php
namespace App\Helpers\Core;

use Illuminate\Support\Facades\DB;

class CoreHelper{

	public static function getCat(){

	}	


	function ordered_menu($array,$parent_id = 0) {
	  $temp_array = array();
	  foreach($array as $element)
	  {
	    if($element['parent_id']==$parent_id)
	    {
	      $element['subs'] = ordered_menu($array,$element['id']);
	      $temp_array[] = $element;
	    }
	  }
	  return $temp_array;
	}
	
	static function getArIdFromTreeArray($array, $id_name='id', &$result=array()) {
		//dd($array);
	  foreach($array as $element) {
		$result[] = $element[$id_name];
	    $array = CoreHelper::getArIdFromTreeArray($array, $id_name, $result);
	      
	    die($result);
	  }
	  return $result;
	}

	function getDataByCurlOrFGC($url) {
	    // is curl installed?
		if (function_exists('curl_init')){
			// create a new curl resource
			$ch = curl_init(); 
			// set URL to download
			curl_setopt($ch, CURLOPT_URL, $url); 
			// set referer:
			curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/"); 
			// user agent:
			curl_setopt($ch, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5))); 
			// remove header? 0 = yes, 1 = no
			curl_setopt($ch, CURLOPT_HEADER, 0);
			// should curl return or print the data? true = return, false = print
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// timeout in seconds
			curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
			// no ssl
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			// download the given URL, and return output
			$output = curl_exec($ch); 
			// close the curl resource, and free system resources
			curl_close($ch); 
			// print output
			return $output;
		} else {
			$output = @file_get_contents($url); 
			return $output;
		}    
	}
	

}

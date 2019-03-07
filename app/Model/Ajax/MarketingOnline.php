<?php

namespace App\Model\Ajax;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarketingOnline extends Model
{
    public function addFriendNumber($id, $number){
		$current_time = date('Y-m-d H:i:s');

    	DB::table('moaccount_active')->insert(['accountId' => $id, 'friend_number' => $number, 'created_at' => $current_time]);
        $id = DB::getPdo()->lastInsertId();
        $arItem = [
        	'id' => $id,
        	'accountId' => $id,
        	'friend_number' => $number,
        	'created_at' => $current_time
        ];

        return $arItem;
    }
}

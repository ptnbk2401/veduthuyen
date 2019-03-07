<?php

namespace App\Model\Vadmin\Core\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

	public function getItems(){
        return $this->orderBy('id', 'DESC')->paginate(getenv('USER_PAGE'));
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function addItem($arItem){
        try {
            DB::beginTransaction();
            $arGroups = $arItem['vgroup'];
            unset($arItem['vgroup']);



            DB::table('users')->insert($arItem);
            $uid = DB::getPdo()->lastInsertId();

            //chèn vào vusers_groups

            foreach ($arGroups as $gid) {
                if ($gid > 0) {
                    try{
                        DB::table('vne_user_group')->insert(['userId' => $uid, 'groupId' => $gid]);
                    } catch (\Exception $e2) {  
                        print_r($e2->getMessage());
                        break;
                    }
                }
            }
            DB::commit();
            return $uid;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            DB::rollback();
        }
        return false;
    }

    public function delItem($id){
        try {
            $objItem = $this->findOrFail($id);
            $uid = $objItem->id;
            $avatar = $objItem->avatar;

            $objItem->delete();
            //xoa tai bang vusers_groups
            DB::table('vne_user_group')->where('userId', $uid)->delete();
            //xoa tai bang vneusers_position
            DB::table('vneusers_position')->where('userId', $uid)->delete();
            return true;
        } catch (\Exception $e) {
            print_r($e->getMessage()); 
        }
        return false;
    }

    public function editItem($id, $arItem){
        try {
            DB::beginTransaction();

            $objItem = $this->findOrFail($id);
            $objItem->username = trim($arItem['username']);
            if (isset($arItem['password'])) {
                $objItem->password = trim($arItem['password']);
            }
            $objItem->first_name = trim($arItem['first_name']);
            $objItem->last_name = trim($arItem['last_name']);
            $objItem->email = trim($arItem['email']);
            $objItem->phone = trim($arItem['phone']);
            $objItem->address = trim($arItem['address']);
            $objItem->avatar = $arItem['avatar'];
//            $objItem->uid = $arItem['uid'];
//            $objItem->access_token = trim($arItem['access_token']);

            // xử lý hình ảnh
            if ($arItem['avatar'] != '') {
                $objItem->avatar = trim($arItem['avatar']);
            }

            $arGroups = $arItem['vgroup'];
            unset($arItem['vgroup']);
//            $arPosition = $arItem['position'];
//            unset($arItem['position']);
            try{
                $result = $objItem->save();
            } catch (\Exception $e3) {  
                print_r($e3->getMessage());
                $result = false;
            }

            //xử lý bảng vusers_groups
            //xóa các record cũ
            DB::table('vne_user_group')->where(['userId' => $id])->delete();
            //tạo các record mới
            foreach ($arGroups as $gid) {
                if ($gid > 0) {
                    try{
                        DB::table('vne_user_group')->insert(['userId' => $id, 'groupId' => $gid]);
                    } catch (\Exception $e2) {  
                        print_r($e2->getMessage());
                        break;
                    }
                }
            }

            //xử lý bảng vneusers_position
            //xóa các record cũ

            //tạo các record mới


            DB::commit();
            return $result;
        } catch (\Exception $e) {
            print_r($e->getMessage()); 
            DB::rollback();
            die();
        }
        return false;

            
    }

    public function editProfile($id, $arItem){
        try {
            DB::beginTransaction();

            $objItem = $this->findOrFail($id);

            $objItem->fullname = trim($arItem['fullname']);
            $objItem->phone = trim($arItem['phone']);
            $objItem->address = trim($arItem['address']);
            $objItem->gender = $arItem['gender'];
            $objItem->birthday = $arItem['birthday'];
            $objItem->avatar = $arItem['avatar'];
            $objItem->uid = $arItem['uid'];
            $objItem->access_token = trim($arItem['access_token']);
			if (isset($arItem['password'])) {
				$objItem->password = $arItem['password'];
			}
            // xử lý hình ảnh
            if ($arItem['avatar'] != '') {
                $objItem->avatar = trim($arItem['avatar']);
            }

            try{
                $result = $objItem->save();
            } catch (\Exception $e3) {  
                print_r($e3->getMessage());
                $result = false;
            }

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            print_r($e->getMessage()); 
            DB::rollback();
            die();
        }
        return false;

            
    }

    /////////////////////////////////
    public function getItemsVne(){
        return DB::table('users as u')
            ->join('vne_user_group as ug', 'u.id', '=', 'ug.userId')
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->where('g.companyId', '>', 0)
            ->orderBy('id', 'ASC')
            ->groupBy('username')
            ->get();
    }
    public static function getCapbacUser($id_user){
        return DB::table('vne_user_group as ug')
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->where('ug.userId', $id_user)
            ->first();
    }

    //lấy list user theo phòng ban của userId
    public function getItemsPositionByUserId($uid){
		//lấy các group(phòng ban) của user
		$arGroupId = array();
        $arGroupCode = array();
        $arGroupsTmp = DB::table('vne_groups as g')->join('vne_user_group as ug', 'g.groupId', '=', 'ug.groupId')
            ->orderBy('sort', 'ASC')
            ->where('ug.userId', $uid)->get()->toArray();

        if (count($arGroupsTmp) > 0) {
            foreach ($arGroupsTmp as $key => $group) {
                $arGroupId[] = $group->groupId;
                $arGroupCode[] = $group->code;
            }
        }
		
        $arResult = array();
        $arGroups = DB::table('vne_groups as g')->join('vne_user_group as ug', 'g.groupId', '=', 'ug.groupId')
            ->orderBy('sort', 'ASC');
		$arGroups->groupBy('ug.groupId');
		
		if (!in_array('admin', $arGroupCode)) {
			$arGroups->where('ug.userId', $uid);
		}
			
		$arGroups = $arGroups->get();
            
        if (!empty($arGroups)) {
            foreach ($arGroups as $key => $arGroup) {
                $gid = $arGroup->groupId;
                $arResult[$key]['gid'] = $arGroup->groupId;
                $arResult[$key]['name'] = $arGroup->name;
                $arUsers = DB::table('users as u')->join('vne_user_group as ug', 'u.id', '=', 'ug.userId')
                    ->orderBy('u.sort', 'ASC')->orderBy('u.id', 'ASC')
                    ->where('ug.groupId', $gid)
                    ->get();
                $arResult[$key]['objUser'] = $arUsers;
            }
        } else {
            return false;
        }

        return $arResult;
    }

    //kiểm tra user có thực hiện công việc của groupid, taskid, userid
    public function checkWorkByGTU($userid, $taskid, $positionid){
        return DB::table('vneusers_task_position')->where('userid', $userid)->where('taskid', $taskid)->where('positionid', $positionid)->first();
    }

    public function updateStatus($id){
        $objItem = $this->findOrFail($id);
        if ($objItem->active == 1) {
            $objItem->active = 0;
            $objItem->save();
            return 1;
        } else {
            $objItem->active = 1;
            $objItem->save();
            return 0;
        }
    }
}

<?php

namespace App\Model\Vadmin\Core\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcgIndex extends Model
{
    protected $table = "vne_groups";
    protected $primaryKey = "groupId";
    public $timestamps = false;

    public function getItems(){
        return $this->orderBy('sort', 'ASC')->orderBy('groupId', 'DESC')->paginate(getenv('USER_PAGE'));
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }

    public function addItem($arItem){
        return DB::table('vne_groups')->insertGetId($arItem);
    }

    public function delItem($id){
        try {
            DB::beginTransaction();
            $this->destroy($id);

            //chuyển người dùng thuộc nhóm này sang nhóm có id=0
            DB::table('vne_user_group')->where('groupId', $id)->update(['groupId' => 0]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            DB::rollback();
        }
        return false;
    }

    public function editItem($id, $arItem){
        return DB::table('vne_groups')->where('groupId', $id)->update($arItem);
    }


    //các function khác
    public function getItemsAll(){
        return $this->orderBy('sort', 'ASC')->orderBy('groupId', 'DESC')->get();
    }
    public function getItemsAllForCompany(){
        return $this->orderBy('sort', 'ASC')->orderBy('groupId', 'DESC')->where('companyid', '>', 0)->get();
    }

    public function getItemsByUid($uid){
        return DB::table('vne_user_group')->where('userId', $uid)->pluck('groupId')->toArray();
    }

    //lấy mảng các group khi có uid
    public function getItemsAllByUid($uid){
        return DB::table('users as u')->join('vne_user_group as ug', 'u.id', '=', 'ug.userId')
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->select('g.*', 'g.sort as sort')
            ->where('ug.userId', $uid)
            ->orderBy('g.sort', 'ASC')->orderBy('g.groupId', 'DESC')->get()->toArray();

    }
}



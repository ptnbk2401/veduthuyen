<?php
namespace App\Helpers\TmpVinaEnter;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VneHelper {

	public static function getPhongBan(){
        $objUser = Auth::user();
        $uid = $objUser->id;
        
        $arGroups = DB::table('vneusers_groups as ug')
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->where('ug.userId', $uid)->get()->toArray();
        return $arGroups;
    }

    public static function getArIdPhongBan(){
        $objUser = Auth::user();
        $uid = $objUser->id;
        $arResult = array();
        $arGroups = DB::table('vneusers_groups as ug')
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->where('ug.userId', $uid)->get()->toArray();
        foreach ($arGroups as $key => $arGroup) {
            $gid = $arGroup->groupId;
            $arResult[] = $gid;
        }

        return $arResult;
    }

    public static function getChucVu(){
        $objUser = Auth::user();
        $uid = $objUser->id;

        $arCVs = DB::table('vneusers_position as up')
            ->join('vneposition as p', 'up.pid', '=', 'p.pid')
            ->where('up.userId', $uid)->get()->toArray();
        return $arCVs;
    }
    public static function getArIdChucVu(){
        $objUser = Auth::user();
        $uid = $objUser->id;
        $arResult = array();
        $arCVs = DB::table('vneusers_position as up')
            ->join('vneposition as p', 'up.pid', '=', 'p.pid')
            ->where('up.userId', $uid)->get()->toArray();
        foreach ($arCVs as $key => $arCV) {
            $id = $arCV->pid;
            $arResult[] = $id;
        }

        return $arResult;
    }
    public static function getArCodeChucVu(){
        $objUser = Auth::user();
        $uid = $objUser->id;
        $arResult = array();
        $arCVs = DB::table('vneusers_position as up')
            ->join('vneposition as p', 'up.pid', '=', 'p.pid')
            ->where('up.userId', $uid)->get()->toArray();
        foreach ($arCVs as $key => $arCV) {
            $code = $arCV->code;
            $arResult[] = $code;
        }

        return $arResult;
    }

    public static function getPhanLoaiCongViec(){
        $arChucVu = VneHelper::getArCodeChucVu();
        if (in_array('admin', $arChucVu) || in_array('gd', $arChucVu)) {
            return DB::table('tatasktype')->orderBy('sort', 'asc')->get();
        }
        return DB::table('tatasktype')->orderBy('sort', 'asc')->whereIn('groupId', VneHelper::getArIdPhongBan())->get();
    }

    public static function isQuanLy(){
        $arChucVu = VneHelper::getArCodeChucVu();
        if (in_array('gd', $arChucVu) || 
            in_array('ppmo', $arChucVu) || 
            in_array('ppcn', $arChucVu) || 
            in_array('pphckt', $arChucVu))
        {
            return true;
        }
        return false;
    }

}

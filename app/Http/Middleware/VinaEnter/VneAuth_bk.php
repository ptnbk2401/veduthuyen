<?php

namespace App\Http\Middleware\VinaEnter;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VneAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $objUser = Auth::user();
        $uid = $objUser->id;
        $username = $objUser->username;
        $fullname = $objUser->fullname;
        $arCodePhongBan = $arCodeChucVu = array();

        //lấy và kiểm tra các phòng ban của user
        $objGroups = DB::table('vneusers_groups as ug') //tabble ny mình có ko ta, có
            ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
            ->where('ug.userId', $uid)
            ->get();

        $is_admin = false;
        foreach ($objGroups as $key => $objGroup) {
            $gcode = $objGroup->code;
            if ('admin' == $gcode) {
                $is_admin = true;
                break;
            }
        } 

        //lấy và kiểm tra các chức vụ của user
        $objCVs = DB::table('vneusers_position as up')
            ->join('vneposition as p', 'up.pid', '=', 'p.pid')
            ->where('up.userId', $uid)->get();

        //lấy các quyền từ route
        $arRoleTmp = explode('|', $role);
        $str_pb = $str_cv = '';
        if ((count($arRoleTmp) > 0) && (!$is_admin)) { //có check quyền
            $str_pb = $arRoleTmp[0];
            if (isset($arRoleTmp[1])) {
                $str_cv = $arRoleTmp[1];
            }   
            $checkPb = false;
            
            if (($str_pb != '') && ($str_pb != '*')) { //kiểm tra phòng ban
                foreach ($objGroups as $key => $objGroup) {
                    $gcode = $objGroup->code;
                    if (strpos($str_pb, $gcode) !== false) {
                        $checkPb = true;
                        break;
                    }
                } 
            } else {
                $checkPb = true;
            }

            $checkCv = false;

            if (($str_cv != '') && ($str_cv != '*')) { //kiểm tra chức vụ
                foreach ($objCVs as $key => $objCV) {
                    $ccode = $objCV->code;
                
                    if (strpos($str_cv, $ccode) !== false) {
                        $checkCv = true;
                        break;
                    }
                }
            } else {
                $checkCv = true;
            }

            if ($checkPb && $checkCv) {
                //do some thing
            } else {
                return redirect()->route('vinaenter.vneindex.index', ['msg' => 'Bạn chưa có quyền truy cập vào tài nguyên này']);
            }
            
        }
        return $next($request);
    }
}

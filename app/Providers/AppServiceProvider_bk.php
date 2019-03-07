
<?php

namespace App\Providers;

use App\Services\VinaEnter\VneSharingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //compose all the views....
        view()->composer('*', function ($view)
        {
            if (Auth::check()) {
                $objUser = Auth::user();
                $uid = $objUser->id;
                $view->with('objUser', $objUser);

                ///////KIỂM TRA PHÂN QUYỀN
                //lấy và kiểm tra các phòng ban của user
                $objGroups = DB::table('vne_user_group as ug')
                    ->join('vne_groups as g', 'ug.groupId', '=', 'g.groupId')
                    ->where('ug.userId', $uid)
                    ->get();

                $is_admin = $is_quanly = $is_gd = false;
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

                //kiểm tra quyền admin
                View::share('isAdmin', $is_admin);
                //phòng ban
                $arCodePhongBan = $arIdPhongBan = array();
                foreach ($objGroups as $key => $objGroup) {
                    $gid = $objGroup->groupId;
                    $gcode = $objGroup->code;
                    $arCodePhongBan[] = $gcode;
                    $arIdPhongBan[] = $gid;
                }
                View::share('arCodePhongBan', $arCodePhongBan);
                View::share('arIdPhongBan', $arIdPhongBan);
                //chức vụ
                foreach ($objCVs as $key => $objCV) {
                    $ccode = $objCV->code;
                    $arCodeChucVu[] = $ccode;

                    if ($ccode == 'gd' || $ccode == 'ppmo' || $ccode == 'ppcn' || $ccode == 'pphckt' ) {
                        $is_quanly = true;
                    }
                }
                //phải giám đốc ko
                foreach ($objCVs as $key => $objCV) {
                    $ccode = $objCV->code;
                    if ($ccode == 'gd') {
                        $is_gd = true;
                    }
                }
                View::share('arCodeChucVu', $arCodeChucVu);
                View::share('isQuanLy', $is_quanly);
                View::share('isGiamDoc', $is_gd);
                ///////END KIỂM TRA PHÂN QUYỀN

                //tạo session để dùng tại các controller
                if (!Session::has('arCodePhongBan')) {
                    Session::put('arCodePhongBan', $arCodePhongBan);
                }
                if (!Session::has('arIdPhongBan')) {
                    Session::put('arIdPhongBan', $arIdPhongBan);
                }
                if (!Session::has('objUser')) {
                    Session::put('objUser', $objUser);
                }
                if (!Session::has('arCodeChucVu')) {
                    Session::put('arCodeChucVu', $arCodeChucVu);
                }
                if (!Session::has('isQuanLy')) {
                    Session::put('isQuanLy', $is_quanly);
                }
                if (!Session::has('isGiamDoc')) {
                    Session::put('isGiamDoc', $is_gd);
                }
            }
        });

        //trạng thái công việc
        $arStatus = array(1=>'Chưa bắt đầu',  2 => 'Đang thực hiện', 3 => 'Đang thực hiện lại', 4 => 'Đã hoàn thành', 5 => 'Đã nhận việc', 6 => 'Không thực hiện được');
        View::share('arStatus', $arStatus);

        //lập kế hoạch làm việc theo
        $arFortime = array(1 => 'Kế hoạch làm việc tuần', 2 => 'Kế hoạch làm việc ngày', 3 => 'Kế hoạch làm việc tháng');
        View::share('arFortime', $arFortime);

        View::share('publicUrl', getenv('PUBLIC_URL'));
        View::share('adminUrl', getenv('ADMIN_URL'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

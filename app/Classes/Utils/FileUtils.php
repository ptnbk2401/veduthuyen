<?php
/**
 * Created by PhuT.
 * User: PhuT
 * Date: 03/01/2019
 * Time: 2:21 CH
 */

namespace App\Classes\Utils;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class FileUtils  extends Controller
{
    /*
     * @param $pic: name picture resize
     * @param $dir: name directory of file resize
     * @param $width: width file resize
     * $param height: height file resize
     * @result: path file name display picture at view
     */
    public static function resizeResultPathFile($pic, $dir, $width, $height) {
        if($pic != '' && $dir != '' && $width > 0 &&  $height > 0) {
            $dir_resize = $dir . '/' . $width . 'x' . $height;
            if ($pic != '') {
                if (!file_exists(storage_path("app/media/thumb/{$dir_resize}/{$pic}"))) {
                    Storage::makeDirectory('media/thumb/' . $dir_resize, $mode = 0777, true, true);
                    Image::make(storage_path("app/media/files/{$dir}/{$pic}"))
                        ->resize($width, $height)
                        ->save(storage_path("app/media/thumb/{$dir_resize}/{$pic}"));
                }
            }
            return '/storage/app/media/thumb/'.$dir_resize.'/'.$pic;
        }
        return "";
    }

    public static function getFileName($path) {
        $fileName = '';
        if($path != '') {
            $arName = explode("/", $path);
            $fileName = end($arName);
        }
        return $fileName;
    }
}
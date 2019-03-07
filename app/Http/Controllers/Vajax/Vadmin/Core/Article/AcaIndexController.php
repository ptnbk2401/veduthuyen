<?php

namespace App\Http\Controllers\Vajax\Vadmin\Core\Article;
use App\Classes\TwoSaoData;
use App\Classes\LaoDongData;
use App\Classes\VnexpressData;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Article\AcaIndex;
use App\Model\Vadmin\Core\Vnexpress\AcvIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class AcaIndexController extends Controller
{
    public function __construct(AcaIndex $objmAcaIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
    }

    public function activeStatus(Request $request)
    {
        $id = $request->aid;
        if ($this->objmAcaIndex->updateStatus($id) == 1) {
            return '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>';
        }
    }
    public function saveTinAuto( AcaIndex $objmAcaIndex,AcvIndex $objmAcvIndex,Request $request)
    {
        $cat_id = $request->cat_id;
        $index = $request->index;
        $arItem = $objmAcvIndex->getItemByStt($index);
        if(empty($arItem)) {
            return $index;
        }
        // dd($arItem);
        $id = $arItem->id;
        $srcImage = $arItem->img;
        $title = $arItem->title;
        $code = str_slug($title);
        // kiểm tra tin đã tồn tại thì k lưu nữa
        if( !empty($objmAcaIndex->checkCode($code)) ) {
            $objmAcvIndex->delItem($id);
            return $index;
        }
        $description = $arItem->description;
        $href = $arItem->href;
        $tmp = explode('.', $srcImage);
        $duoifile = end($tmp);
        $filename = str_slug($arItem->title).'-'.time().'.'.$duoifile;
        $path = storage_path('/app/media/files/article/' . $filename );
        Image::make($srcImage)->save($path);
        $arItem = [
            'aname' => $title,
            'code' =>  str_slug($title),
            'cat_id' => ($cat_id),
            'has_video' => 0,
            'ID_video' => '',
            'preview_text' => $description,
            'linknguon' => $href,
            'detail_text' => '',
            'sort' => 500,
            'status' => 0,
            'active' => 0,
            'picture' => $filename,
            'user_id' => Auth::id(),
        ];
        if($objmAcaIndex->addItem($arItem)){
            $objmAcvIndex->delItem($id);
        }
        // sleep(0.2);

        return $index;  
    }
    public function getDetailEdit(VnexpressData $Vnexpress, Request $request)
    {   
        $url = $request->url;
        if(strpos($url, 'vnexpress')){
            $Vnexpress = new VnexpressData() ;
            $detail = $Vnexpress->getDetail($url);
        } else if(strpos($url, '2sao')){
            $TwoSao = new TwoSaoData(); 
            $detail = $TwoSao->getDetail($url);
        } else if(strpos($url, 'vietgiaitri')){
            $LaoDong = new LaoDongData(); 
            $detail = $LaoDong->getDetail($url);
        } else {
            return 0;
        }
        
        return $detail;
    }
    public function getPosts(Request $request)
    {   
        $url = $request->url;
        $webname = $request->webname;
        switch ($webname) {
            case 'vnexpress':
                $Vnexpress = new VnexpressData() ;
                $arData = $Vnexpress->getItems($url);
                break;
            case '2sao':
                $TwoSao = new TwoSaoData(); 
                $arData = $TwoSao->getItems($url);
                break;
            case 'laodong':
                $LaoDong = new LaoDongData(); 
                $arData = $LaoDong->getItems($url);
                break;
            default:
                $arData=[];
                break;
        }
        // dd($arData);
        return view('ajax.article.getposts',compact('arData'));
    }
    public function detailtext(Request $request)
    {   
        $article_id = $request->article_id;
        $index = $request->index;
        $objArticle = AcaIndex::find($article_id);
        $linknguon = $objArticle->linknguon;
        if(empty($objArticle->detail_text)) {
            if(strpos($linknguon, 'vnexpress')) {
                $Vnexpress = new VnexpressData() ;
                $detail = $Vnexpress->getDetail($linknguon);
            } else if(strpos($linknguon, '2sao')) {
                $TwoSao = new TwoSaoData(); 
                $detail = $TwoSao->getDetail($linknguon);
            } else if(strpos($linknguon, 'laodong')) {
                $LaoDong = new LaoDongData(); 
                $detail = $LaoDong->getDetail($linknguon);
            } else {
                $detail= '';
            }
            AcaIndex::where('article_id',$article_id)->update(['detail_text' => $detail,'status'=>1]);
        }
        return $index;
        // dd($arData);
        // return view('ajax.article.getposts',compact('arData'));
    }
}



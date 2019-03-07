<?php

namespace App\Http\Controllers\Vadmin\Core\Article;

use App\Classes\NewszingData;
use App\Classes\SimpleHTMLDOM;
use App\Classes\VnexpressData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Article\AcaIndexRequest;
use App\Model\Vadmin\Core\ArticleTabs\AcaIndex as Tags;
use App\Model\Vadmin\Core\Article\AcaIndex;
use App\Model\Vadmin\Core\Cat\AccIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Sunra\PhpSimple\HtmlDomParser;


class AcaIndexController extends Controller
{
    public function __construct(Request $request, AcaIndex $objmAcaIndex, AccIndex $objmAccIndex, \App\Model\Vadmin\Core\Comment\AccIndex $objmAccommentIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
        $this->objmAccIndex = $objmAccIndex;
        $this->objmAccommentIndex = $objmAccommentIndex;
        // send data list cat for views in this controller
        $catId = $request->cat_id;
        if (!is_null($request->id)) {
            $arItem = $this->objmAcaIndex->getItem($request->id);
            $catId = $arItem->cat_id;
        }
        $arItems = $this->objmAccIndex->getItemsAll();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree, 0, $catId);
        view()->share('strOption', $strOption);
    }

    public function index()
    {
        $objItems = $this->objmAcaIndex->getItems();
        return view('vadmin.core.article.acaindex.index', compact('objItems'));
    }

    public function getDetailAuto()
    {
        return view('vadmin.core.article.acaindex.getDetail');
    }
    public function getDetailText()
    {
        $objItems = $this->objmAcaIndex->getItemsNone();
        return view('vadmin.core.article.acaindex.getDetailText', compact('objItems'));
    }

    // public function postDetailAuto(VnexpressData $Vnexpress,Request $request)
    // {
    //     $url = trim($request->url);
    //     $type = trim($request->type);
    //     $divcontent = trim($request->divcontent);
    //     $arData = $Vnexpress->getItems($url);
    //     return view('vadmin.core.article.acaindex.getDetail',compact('arData'));
    // }
    public function postDetailAuto(NewszingData $Newszing,Request $request)
    {
        $url = trim($request->url);
        $type = trim($request->type);
        $divcontent = trim($request->divcontent);
        $arData = $Newszing->getItems($url);
        // dd($arData);
        return view('vadmin.core.article.acaindex.getDetail',compact('arData'));
    }
    public function AddTags(Tags $Tags, Request $request)
    {
        $article_id = $request->article_id;
        $tags = $request->tags;
        $arItem = [
            'article_id' => $article_id,
            'tags'      => $tags,
        ];
        if( $ItemTags = $Tags->getItemByArticle($article_id) ) {
            $Tags->editItem($ItemTags->id,$arItem);
        }
        else {
            $Tags->addItem($arItem);
        }
        $arTags = explode(',', $tags);
        $html = '';
        foreach ($arTags as $tag){
            $html .= ' <span class="label label-success" title="'.$tag.'">'.str_limit($tag,10) .'</span> ';
        }
        return $html;
    }
    public function getAdd()
    {
        return view('vadmin.core.article.acaindex.add');
    }

    public function postAdd(AcaIndexRequest $request)
    {
        $arItem = [
            'aname' => trim($request->aname),
            'code' => trim($request->code),
            'cat_id' => trim($request->cat_id),
            'has_video' => trim($request->has_video),
            'ID_video' => empty(trim($request->ID_Video))? '' : trim($request->ID_Video),
            'preview_text' => trim($request->preview_text),
            'detail_text' => trim($request->detail_text),
            'sort' => trim($request->sort),
            'picture' => trim($request->picture),
            'user_id' => Auth::id(),
        ];
        // dd($arItem);

        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture',str_slug($request->aname));
        }

        if ($this->objmAcaIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.article.add');
        }
        return redirect()->route('vadmin.core.article.index');
    }


    public function getEdit($id,$page, Request $request)
    {
        $objItemOld = $this->objmAcaIndex->getItem($id);
        return view('vadmin.core.article.acaindex.edit', compact('objItemOld','page'));
    }

    public function postEdit($id,$page, AcaIndexRequest $request)
    {
        $objNewsOld = $this->objmAcaIndex->getItem($id);
        $arItem = [
            'aname' => trim($request->aname),
            'code' => trim($request->code),
            'cat_id' => trim($request->cat_id),
            'has_video' => trim($request->has_video),
            'ID_video' => empty(trim($request->ID_Video))? '' : trim($request->ID_Video),
            'preview_text' => trim($request->preview_text),
            'detail_text' => trim($request->detail_text),
            'sort' => trim($request->sort),
            'status' => 1,
            'active' => 1,
            'picture' => $objNewsOld->picture,
            'user_id' => Auth::id(),
        ];
        if (!is_null($request->delPic) && !empty($request->delPic)) {
            $this->delFile($request->delPic);
            $arItem['picture'] = null;
        }
        if (!is_null($request->picture) && !empty($request->picture)) {
            $this->delFile($objNewsOld->picture);
            $arItem['picture'] = $this->saveOneFile($request, 'picture',str_slug($request->aname));
        }
        if ($this->objmAcaIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->back();
        }
        return redirect('/vadmin/core/article/index?page='.$page);
    }

    public function del($id, Request $request)
    {
        try {
            $arIdComment = array();
            // list id comment by article
            $arComments = $this->objmAccommentIndex->getItemsByArticleId($id);
            foreach ($arComments as $comment) {
                $arIdComment[] = $comment->fcomment_id;
            }
            $this->objmAccommentIndex->delItems($arIdComment);

            $objItemOld = $this->objmAcaIndex->getItem($id);
            $fileNameOld = $objItemOld->picture;
            if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                $this->delFile($fileNameOld);
            }
            $this->objmAcaIndex->delItem($id);
            $request->session()->flash('msg', 'Xóa thành công');
        } catch (\Exception $e) {
            $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
            dd($e->getMessage());
        }
        return redirect()->back();
    }

    public function delAll(Request $request)
    {
        if(!empty($request->vnedel)) {
        if (count($request->vnedel) > 0) {
            $arIdComment = array();
            foreach ($request->vnedel as $key => $id) {
                try {
                    $arComments = $this->objmAccommentIndex->getItemsByArticleId($id);
                    foreach ($arComments as $comment) {
                        $arIdComment[] = $comment->fcomment_id;
                    }
                    $objItemOld = $this->objmAcaIndex->getItem($id);
                    $fileNameOld = $objItemOld->picture;
                    // xóa sản phẩm (xóa hỉnh ảnh của sản phẩm đó)
                    if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                        $this->delFile($fileNameOld);
                    }
                    $this->objmAcaIndex->delItem($id);
                } catch (\Exception $e) {
                    $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
                    dd($e->getMessage());
                }
            }
            $this->objmAccommentIndex->delItems($arIdComment);
        }
        $request->session()->flash('msg', 'Xóa thành công');
        }
        return redirect()->back();
    }
    public function ActiveAll(Request $request)
    {
        if(!empty($request->vnedel)) {
            $arID = $request->vnedel;
            $this->objmAcaIndex->activeAll($arID,1);
            $request->session()->flash('msg', 'Active thành công');
        }
        return redirect()->back();
    }
    public function DisAll(Request $request)
    {
        if(!empty($request->vnedel)) {
            $arID = $request->vnedel;
            $this->objmAcaIndex->activeAll($arID,0);
            $request->session()->flash('msg', 'Huỷ Active thành công');
        }
        return redirect()->back();
    }
    public function changeCat(Request $request)
    {
        if(!empty($request->vnedel)) {
            $arID = $request->vnedel;
            $cat_id = $request->cat_id;
            $this->objmAcaIndex->changeCat($arID,$cat_id);
            $request->session()->flash('msg', 'Đổi danh mục thành công');
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $cat_id = $request->cat_id;
        $active = $request->active;
        $arItem = array(
            'name' => $name,
            'cat_id' => $cat_id,
            'active' => $active
        );
        $objItems = $this->objmAcaIndex->getItemsSearch($arItem);
        return view('vadmin.core.article.acaindex.search', compact('objItems', 'arItem'));
    }

    public function buildOption($arr, $parent = 0, $target = 0, &$indent = 0)
    {
        $html = "";
        $selected = '';
        foreach ($arr as $key => $v) {
            $id = $v->cat_id;
            $sort = $v->sort;
            $name = $v->cname;
            $child = null;
            if (isset($v->child)) {
                $child = $v->child;
            }
            if ($v->parent_id == 0) {
                $indent = 0;
            }
            if ($target != $id) {
                $html .= '<option value="' . $id . '">' . str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)) . $name . '</option>';
            } else {
                $html .= '<option value="' . $id . '" selected="selected">' . str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)) . $name . '</option>';
            }
            if (!is_null($child)) {
                $indent += 2;
                $html .= $this->buildOption($child, $parent, $target, $indent);
                $indent -= 2;
            }
        }

        return $html;
    }

    function buildTreeHard(&$elements, $parentId = 0)
    {
        $arCat = array();
        foreach ($elements as &$element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTreeHard($elements, $element->cat_id);
                if ($children) {
                    $element->child = $children;
                }
                $arCat[$element->cat_id] = $element;
                unset($element);
            }
        }
        return $arCat;
    }

    public function saveOneFile($request, $inputName,$slugname)
    {
        if (Input::hasFile($inputName)) {
            $extension = Input::file($inputName)->getClientOriginalExtension();
            $fileName = $slugname . '-' . time() . '.' . $extension;
            $request->file($inputName)->move(storage_path('app/media/files/article'), $fileName);
        }
        return $fileName;
    }

    public function delFile($fileName)
    {
        if (!is_null($fileName) && !empty($fileName)) {
            Storage::delete("media/files/article/" . $fileName);
        }
    }
}


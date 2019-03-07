<?php

namespace App\Http\Controllers\Vadmin\Core\Cat;

use App\Exports\CatExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\PCat\AcpcIndexRequest;
use App\Model\Vadmin\Core\Cat\AccIndex;
use App\Model\Vadmin\Core\Article\AcaIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class AccIndexController extends Controller
{
    public function __construct(Request $request, AccIndex $objmAccIndex, AcaIndex $objmAcaIndex , \App\Model\Vadmin\Core\Comment\AccIndex $objmAccommentIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
        $this->objmAccIndex = $objmAccIndex;
        $this->objmAccommentIndex = $objmAccommentIndex;
    }

    public function index()
    {
        $arItems = $this->objmAccIndex->getItems();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strHtml = $this->buildHtml($arItemsTree);
        return view('vadmin.core.cat.accindex.index', compact('strHtml'));
    }

    public function getAdd()
    {
        $arItems = $this->objmAccIndex->getItemsAll();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree);
        return view('vadmin.core.cat.accindex.add', compact('strOption'));
    }

    public function postAdd(AcpcIndexRequest $request)
    {
        $arItem = [
            'cname' => trim($request->name),
            'code' => trim($request->code),
            'sort' => trim($request->sort),
            'parent_id' => trim($request->parent_id),
        ];
        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        if ($this->objmAccIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.cat.add');
        }
        return redirect()->route('vadmin.core.cat.index');
    }

    public function del($id, Request $request)
    {
        $objAll = $this->objmAccIndex->getItemsAll();
        $arTree = $this->buildTree($objAll, $id);
        // list id category
        $arTree[] = (int)$id;
        // delete all article of cat_id
        // list id article
        $arIdArticle = array();
        $arIdComment = array();
        foreach ($arTree as $catId) {
            $arProducts = $this->objmAcaIndex->getItemsByCatId($catId);
            foreach ($arProducts as $article) {
                $arIdArticle[] = $article->article_id;
            }
        }
        // list id comment by article
        foreach ($arIdArticle as $articleId) {
            $arComments = $this->objmAccommentIndex->getItemsByArticleId($articleId);
            foreach ($arComments as $comment) {
                $arIdComment[] = $comment->fcomment_id;
            }
        }
        // delete comment -> article -> category
        $this->objmAccommentIndex->delItems($arIdComment);
        foreach ($arIdArticle as $articleId) {
            $objItem = $this->objmAcaIndex->getItem($articleId);
            $fileName = $objItem->picture;
            if (!is_null($fileName) && !empty($fileName)) {
                $this->delFile($fileName);
            }
            $this->objmAcaIndex->delItem($articleId);
        }
        $this->objmAccIndex->delItems($arTree);
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.cat.index');
    }

    public function getEdit($id)
    {
        $arItem = $this->objmAccIndex->getItem($id);
        $parent_id = $arItem->parent_id;
        $arItems = $this->objmAccIndex->getItemsAll();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree, 0, $parent_id);
        return view('vadmin.core.cat.accindex.edit', compact('arItem', 'strOption'));
    }

    public function postEdit($id, AcpcIndexRequest $request)
    {
        $arItem = [
            'cname' => trim($request->name),
            'code' => trim($request->code),
            'sort' => trim($request->sort)
        ];
        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        if (!is_null($request->parent_id)) {
            $arItem['parent_id'] = $request->parent_id;
        }
        if ($this->objmAccIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.cat.edit', [$id]);
        }
        return redirect()->route('vadmin.core.cat.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            $arIdArticle = array();
            $arIdComment = array();
            $arTree = array();
            $arCatId = array();
            foreach ($request->vnedel as $key => $cid) {
                $objAll = $this->objmAccIndex->getItemsAll();
                $arTree = $this->buildTree($objAll, $cid);
                // list id category
                $arCatId[] = (int)$cid;
                foreach ($arTree as $id){
                    $arCatId[] = $id;
                }
            }
            $arCatId = array_unique($arCatId);
            // delete all article of cat_id
            // list id article
            foreach ($arCatId as $catId) {
                $arProducts = $this->objmAcaIndex->getItemsByCatId($catId);
                foreach ($arProducts as $article) {
                    $arIdArticle[] = $article->article_id;
                }
            }
            // list id comment by article
            foreach ($arIdArticle as $articleId) {
                $arComments = $this->objmAccommentIndex->getItemsByArticleId($articleId);
                foreach ($arComments as $comment) {
                    $arIdComment[] = $comment->fcomment_id;
                }
            }
            // delete comment -> article -> category
            $this->objmAccommentIndex->delItems($arIdComment);
            foreach ($arIdArticle as $articleId) {
                $objItem = $this->objmAcaIndex->getItem($articleId);
                $fileName = $objItem->picture;
                if (!is_null($fileName) && !empty($fileName)) {
                    $this->delFile($fileName);
                }
                $this->objmAcaIndex->delItem($articleId);
            }
            $this->objmAccIndex->delItems($arCatId);
        }
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.cat.index');
    }


    public function buildHtml($arr, $parent = 0, &$indent = 0)
    {
        $html = "";
        foreach ($arr as $key => $v) {
            $id = $v->cat_id;
            $sort = $v->sort;
            $name = $v->cname;
            $active = $v->active;
            $child = null;
            if (isset($v->child)) {
                $child = $v->child;
            }

            if ($v->parent_id == 0) {
                $indent = 0;
            }
            $urlEdit = route('vadmin.core.cat.edit', [$id]);
            $urlDel = route('vadmin.core.cat.del', [$id]);
            $html .= '<tr class="even pointer">
              <td class="a-center ">
                <input type="checkbox" class="flat vnedel" name="vnedel[]" value="' . $id . '">
              </td>
              <td>' . str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)) . '' . $name . '</td>
              <td>' . $sort . '</td>
               <td class="active-cat-' . $id . '">';
            if ($active == 0) {
                $html .= '<a href = "javascript:void(0)" onclick = "return active(' . $id . ')" style = "" > <i class="glyphicon glyphicon-remove" style = "color: #f1635f;" ></i ></a >';
            } else {
                $html .= '<a href = "#" onclick = "return active(' . $id . ')" style = "" > <i class="glyphicon glyphicon-ok" style = "color: #26b99a;" ></i ></a >';
            }
            $html .= '</td>
                 <td>' . $id . '</td>
              <td class="last"><a href="' . $urlEdit . '"><i class="fa fa-edit"></i> Sửa</a> | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')" href="' . $urlDel . '">'.'<i class="fa fa-trash"></i> Xóa</a>
              </td>
            </tr>';

            if (!is_null($child)) {
                $indent += 2;
                $html .= $this->buildHtml($child, $parent, $indent);
                $indent -= 2;
            }
        }

        return $html;
    }

    public function buildOption($arr, $parent = 0, $target = 0, &$indent = 0)
    {
        $html = "";
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

    public function buildTree(&$elements, $parentId = 0, &$resultId = array())
    {
        $branch = array();
        foreach ($elements as &$element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->cat_id, $resultId);
                if ($children) {
                    $element->arChild = $children;
                }
                $branch[$element->cat_id] = $element;
                $resultId[] = $element->cat_id;

                unset($element);
            }
        }
        return $resultId;
    }

    public function saveOneFile($request, $inputName)
    {
        if (Input::hasFile($inputName)) {
            $extension = Input::file($inputName)->getClientOriginalExtension();
            $fileName = getenv('BASE_FILE_NAME') . '-' . time() . '.' . $extension;
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

    public function export() 
    {
        return new CatExport();
    }

}


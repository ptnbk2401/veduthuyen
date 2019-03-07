<?php

namespace App\Http\Controllers\Vadmin\Core\PCat;

use App\Exports\PCatExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\PCat\AcpcIndexRequest;
use App\Model\Vadmin\Core\PCat\AcpcIndex;
use App\Model\Vadmin\Core\Product\AcpIndex;
use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class AcpcIndexController extends Controller
{
    public function __construct(Request $request, AcpcIndex $objmAcpcIndex, AcpIndex $objmAcpIndex, ActhIndex $objmActhIndex, \App\Model\Vadmin\Core\Comment\AccIndex $objmAccommentIndex)
    {
        $this->objmAcpIndex = $objmAcpIndex;
        $this->objmActhIndex = $objmActhIndex;
        $this->objmAcpcIndex = $objmAcpcIndex;
        $this->objmAccommentIndex = $objmAccommentIndex;

        $arItems = $this->objmAcpcIndex->getItemsAll();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree);
        $this->strOption = $strOption;
    }

    public function index()
    {
        $arItems = $this->objmAcpcIndex->getItems();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strHtml = $this->buildHtml($arItemsTree);
        return view('vadmin.core.pcat.acpcindex.index', compact('strHtml'));
    }

    public function getCLink( $idcat, Request $request)
    {
        $objmAcpcIndex = $this->objmAcpcIndex;
        $objItem = $this->objmAcpcIndex->getItem($idcat);
        $ThuongHieuItems = $this->objmActhIndex->getItemsAuto();
        return view('vadmin.core.pcat.acpcindex.caturl', compact('ThuongHieuItems','objItem','objmAcpcIndex'));
    }
    public function postCLink( $idcat, Request $request)
    {
        $arUrl = $request->url;
        foreach ($arUrl as $th_id => $url) {
            if(!empty($url)) {
                $arItem = [
                    'cat_id'   => $idcat,
                    'th_id'    => $th_id,
                    'url'      => $url,
                ];
                $objItem = $this->objmAcpcIndex->findURLCat($idcat,$th_id);
                if ( $objItem ) {
                    $this->objmAcpcIndex->editURLCat($objItem->cu_id,$arItem);
                } else {
                    $this->objmAcpcIndex->addURLCat($arItem);
                }
            }
            
        }    
        $request->session()->flash('msg', 'Cập nhật thành công');    
        return redirect()->route('vadmin.core.pcat.caturl',$idcat);
    }
    public function getAdd()
    {
        $strOption = $this->strOption;
        return view('vadmin.core.pcat.acpcindex.add', compact('strOption'));
    }

    public function postAdd(AcpcIndexRequest $request)
    {
        $arItem = [
            'cname' => trim($request->name),
            'code' => trim($request->code),
            'sort' => trim($request->sort),
            'parent_id' => trim($request->parent_id),
        ];

        if (!is_null($request->icon)) {
            $arItem['icon'] = $this->saveOneFile($request, 'icon');
        }
        if ($this->objmAcpcIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.pcat.add');
        }
        return redirect()->route('vadmin.core.pcat.index');
    }

    public function del($id, Request $request)
    {
        $objAll = $this->objmAcpcIndex->getItemsAll();
        $arTree = $this->buildTree($objAll, $id);
        // list id category
        $arTree[] = (int)$id;
        // delete all product of cat_id
        // list id product
        $arIdArticle = array();
        $arIdComment = array();
        foreach ($arTree as $catId) {
            $arProducts = $this->objmAcpIndex->getItemsByCatId($catId);
            foreach ($arProducts as $product) {
                $arIdArticle[] = $product->product_id;
            }
            $objItem = $this->objmAcpcIndex->getItem($catId);
            $fileName = $objItem->icon;
            if (!is_null($fileName) && !empty($fileName)) {
                $this->delFile($fileName);
            }

        }
        // list id comment by product
        foreach ($arIdArticle as $productId) {
            $arComments = $this->objmAccommentIndex->getItemsByArticleId($productId);
            foreach ($arComments as $comment) {
                $arIdComment[] = $comment->fcomment_id;
            }

        }
        // delete comment -> product -> category
        $this->objmAccommentIndex->delItems($arIdComment);
        foreach ($arIdArticle as $productId) {
            $objItem = $this->objmAcpIndex->getItem($productId);
            $fileName = $objItem->picture;
            if (!is_null($fileName) && !empty($fileName)) {
                $this->delFile($fileName);
            }
            $this->objmAcpIndex->delItem($productId);
        }
        $this->objmAcpcIndex->delItems($arTree);
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.pcat.index');
    }

    public function getEdit($id)
    {
        $arItem = $this->objmAcpcIndex->getItem($id);
        $parent_id = $arItem->parent_id;
        $arItems = $this->objmAcpcIndex->getItemsAll();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree, 0, $parent_id);
        return view('vadmin.core.pcat.acpcindex.edit', compact('arItem', 'strOption'));
    }

    public function postEdit($id, AcpcIndexRequest $request)
    {
        $objCatOld = $this->objmAcpcIndex->getItem($id);
        $arItem = [
            'cname' => trim($request->name),
            'sort' => trim($request->sort),
            'code' => trim($request->code)
        ];
        if (!is_null($request->delPic) && !empty($request->delPic)) {
            $this->delFile($request->delPic);
            $arItem['icon'] = null;
        }
        if (!is_null($request->icon) && !empty($request->icon)) {
            $this->delFile($objCatOld->icon);
            $arItem['icon'] = $this->saveOneFile($request, 'icon');
        }
        if (!is_null($request->parent_id)) {
            $arItem['parent_id'] = $request->parent_id;
        }
        if ($this->objmAcpcIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.pcat.edit', [$id]);
        }
        return redirect()->route('vadmin.core.pcat.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            $arIdArticle = array();
            $arIdComment = array();
            $arTree = array();
            $arCatId = array();
            foreach ($request->vnedel as $key => $cid) {
                $objAll = $this->objmAcpcIndex->getItemsAll();
                $arTree = $this->buildTree($objAll, $cid);
                // list id category
                $arCatId[] = (int)$cid;
                foreach ($arTree as $id){
                    $arCatId[] = $id;
                }
            }
            $arCatId = array_unique($arCatId);
            // delete all product of cat_id
            // list id product
            foreach ($arCatId as $catId) {
                $arProducts = $this->objmAcpIndex->getItemsByCatId($catId);
                foreach ($arProducts as $product) {
                    $arIdArticle[] = $product->product_id;
                }
                $objItem = $this->objmAcpcIndex->getItem($catId);
                $fileName = $objItem->icon;
                if (!is_null($fileName) && !empty($fileName)) {
                    $this->delFile($fileName);
                }
            }
            // list id comment by product
            foreach ($arIdArticle as $productId) {
                $arComments = $this->objmAccommentIndex->getItemsByArticleId($productId);
                foreach ($arComments as $comment) {
                    $arIdComment[] = $comment->fcomment_id;
                }
            }
            // delete comment -> product -> category
            $this->objmAccommentIndex->delItems($arIdComment);
            foreach ($arIdArticle as $productId) {
                $objItem = $this->objmAcpIndex->getItem($productId);
                $fileName = $objItem->picture;
                if (!is_null($fileName) && !empty($fileName)) {
                    $this->delFile($fileName);
                }
                $this->objmAcpIndex->delItem($productId);
            }
            $this->objmAcpcIndex->delItems($arCatId);
        }
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.pcat.index');
    }


    public function buildHtml($arr, $parent = 0, &$indent = 0)
    {
        $html = "";
        foreach ($arr as $key => $v) {
            $id = $v->cat_id;
            $sort = $v->sort;
            $name = $v->cname;
            $active = $v->active;
            $icon = $v->icon;
            $url = '/storage/app/media/files/product/'.$icon;

            $child = null;
            if (isset($v->child)) {
                $child = $v->child;
            }

            if ($v->parent_id == 0) {
                $indent = 0;
            }
            $urlCat = route('vadmin.core.pcat.caturl',$id);
            $urlEdit = route('vadmin.core.pcat.edit', [$id]);
            $urlDel = route('vadmin.core.pcat.del', [$id]);
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
           
                      if(!empty($icon)){
                         $html .= '</td><td class="text-center " ><a href="'.$url.'" target="_blank"><img height="30px" src="'.$url.'" alt=""/></a>';
                      } else {
                        $html .= '</td><td class=" ">';
                      }
                  $html .= '</td>
                 <td class="text-center ">
                     <a href="'. $urlCat .'">Xem</a>
                  </td> 
                <td class="last"><a href="' . $urlEdit . '"><i class="fa fa-edit"></i> Sửa</a> | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')" href="' . $urlDel . '">'.'<i class="fa fa-trash"></i> Xóa</a></td>
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
            $request->file($inputName)->move(storage_path('app/media/files/product'), $fileName);
        }
        return $fileName;
    }

    public function delFile($fileName)
    {
        if (!is_null($fileName) && !empty($fileName)) {
            Storage::delete("media/files/product/" . $fileName);
        }
    }

    public function export() 
    {
        $arData = $this->objmAcpcIndex->getItemsAll();
        // dd($arData[0]);
        return (new PCatExport($arData));
    }


}


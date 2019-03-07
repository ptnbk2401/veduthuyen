<?php

namespace App\Http\Controllers\Vadmin\Core\Product;

use App\Classes\SimpleHTMLDOM;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Product\AcpIndexRequest;
use App\Model\Vadmin\Core\PCat\AcpcIndex;
use App\Model\Vadmin\Core\ProductImage\AcpiIndex;
use App\Model\Vadmin\Core\Product\AcpIndex;
use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class AcpIndexController extends Controller
{
    public function __construct(Request $request, AcpIndex $objmAcpIndex, AcpcIndex $objmAcpcIndex, AcpiIndex $objmAcpiIndex,ActhIndex $objmActhIndex, \App\Model\Vadmin\Core\Comment\AccIndex $objmAccommentIndex)
    {
        $this->objmAcpIndex = $objmAcpIndex;
        $this->objmAcpcIndex = $objmAcpcIndex;
        $this->objmActhIndex = $objmActhIndex;
        $this->objmAcpiIndex = $objmAcpiIndex;
        $this->objmAccommentIndex = $objmAccommentIndex;
        // send data list cat for views in this controller
        $catId = $request->cat_id;
        if (!is_null($request->id)) {
            $arItem = $this->objmAcpIndex->getItem($request->id);
            $catId = $arItem->cat_id;
        }
        $arItems = $this->objmAcpcIndex->getItemsActive();
        $arItemsTree = $this->buildTreeHard($arItems);
        $strOption = $this->buildOption($arItemsTree, 0, $catId);
        view()->share('strOption', $strOption);
    }

    public function index()
    {
        $objItems = $this->objmAcpIndex->getItems();
        return view('vadmin.core.product.acpindex.index', compact('objItems'));
    }

    public function getAdd()
    {
        return view('vadmin.core.product.acpindex.add');
    }

    public function postAdd(AcpIndexRequest $request)
    {
        $arItem = [
            'pname' => trim($request->pname),
            'code' => trim($request->code),
            'cat_id' => trim($request->cat_id),
            'preview_text' => trim($request->preview_text),
            'diachi' => trim($request->diachi),
            'lichtrinh' => trim($request->lichtrinh),
            'detail_text' => trim($request->detail_text),
            'sort' => trim($request->sort),
            'danhgia' => trim($request->danhgia),
            // 'picture' => trim($request->picture),
            'giave' => trim(str_replace('.', '', $request->giave)),
            'user_id' => Auth::id(),
        ];
        if(!empty(trim($request->star))) {
            $arItem['star'] = trim($request->star);
        }
        if(!empty(trim($request->link))) {
            $arItem['link'] = trim($request->link);
        }
        if(!empty(trim($request->giakhuyenmai))) {
            $arItem['giakhuyenmai'] = trim(str_replace('.', '', $request->giakhuyenmai));
        }
        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        $product_id = $this->objmAcpIndex->addItem($arItem);
        // slide 
        foreach ($request->slide as $sl) {
            if ($request->hasFile('slide')) {
                if ($sl->isValid()) {
                    $path = $sl->store('media/files/product');
                    $tmp = explode('/', $path);
                    $fileName = end($tmp);
                    $arSlide = ['product_id' => $product_id, 'picture' => $fileName];
                    $this->objmAcpiIndex->addItem($arSlide);
                }
            }
        }
        return redirect()->route('vadmin.core.product.index')->with('msg', 'Thêm thành công');

        
    }


    public function getEdit($id, Request $request)
    {
        $objItemOld = $this->objmAcpIndex->getItem($id);
        $objSlideOld = $this->objmAcpiIndex->getItemByProduct($id);
        return view('vadmin.core.product.acpindex.edit', compact('objItemOld','objSlideOld'));
    }

    public function postEdit($id, AcpIndexRequest $request)
    {
        // dd($request->all());
        $objNewsOld = $this->objmAcpIndex->getItem($id);
        $arItem = [
            'pname' => trim($request->pname),
            'code' => trim($request->code),
            'cat_id' => trim($request->cat_id),
            'preview_text' => trim($request->preview_text),
            'diachi' => trim($request->diachi),
            'lichtrinh' => trim($request->lichtrinh),
            'detail_text' => trim($request->detail_text),
            'sort' => trim($request->sort),
            'danhgia' => trim($request->danhgia),
            // 'picture' => trim($request->picture),
            'giave' => trim(str_replace('.', '', $request->giave)),
            'user_id' => Auth::id(),
        ];
        if(!empty(trim($request->star))) {
            $arItem['star'] = trim($request->star);
        }
        if(!empty(trim($request->link))) {
            $arItem['link'] = trim($request->link);
        }
        if(!empty(trim($request->giakhuyenmai))) {
            $arItem['giakhuyenmai'] = trim(str_replace('.', '', $request->giakhuyenmai));
        }
        if (!is_null($request->picture) && !empty($request->picture)) {
            $this->delFile($objNewsOld->picture);
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        if (!is_null($request->slide) && !empty($request->slide)) {
            $arSlideOld = $this->objmAcpiIndex->getItemByProduct($id);
            if(!empty($arSlideOld)) {
                foreach ($arSlideOld as $img) {
                    $this->delFile($img->picture);
                }
            }
            // dd($arSlideOld);
            $this->objmAcpiIndex->delItemByProduct($id);
            foreach ($request->slide as $sl) {
                if ($request->hasFile('slide')) {
                    if ($sl->isValid()) {
                        $path = $sl->store('media/files/product');
                        $tmp = explode('/', $path);
                        $fileName = end($tmp);
                        $arSlide = ['product_id' => $id, 'picture' => $fileName];
                        $this->objmAcpiIndex->addItem($arSlide);
                    }
                }
            }
        }
        if ($this->objmAcpIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            dd($arItem);
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->back();
        }
        return redirect()->route('vadmin.core.product.index');
    }

    public function del($id, Request $request)
    {
        try {
            $arIdComment = array();
            // list id comment by product
            $arComments = $this->objmAccommentIndex->getItemsByArticleId($id);
            foreach ($arComments as $comment) {
                $arIdComment[] = $comment->fcomment_id;
            }
            $this->objmAccommentIndex->delItems($arIdComment);

            $objItemOld = $this->objmAcpIndex->getItem($id);
            $fileNameOld = $objItemOld->picture;
            if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                $this->delFile($fileNameOld);
            }
            $this->objmAcpIndex->delItem($id);
            $arPictureOld = $this->objmAcpiIndex->getItemByProduct($id);
            foreach ($arPictureOld as $v) {
                if (!empty($v)) {
                    Storage::delete('media/files/product/'.$v);
                }
            }
            $this->objmAccsIndex->delItemByCourse($id);
            $request->session()->flash('msg', 'Xóa thành công');
        } catch (\Exception $e) {
            $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
            dd($e->getMessage());
        }
        return redirect()->route('vadmin.core.product.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            $arIdComment = array();
            foreach ($request->vnedel as $key => $id) {
                try {
                    $arComments = $this->objmAccommentIndex->getItemsByArticleId($id);
                    foreach ($arComments as $comment) {
                        $arIdComment[] = $comment->fcomment_id;
                    }
                    $objItemOld = $this->objmAcpIndex->getItem($id);
                    $fileNameOld = $objItemOld->picture;
                    // xóa sản phẩm (xóa hỉnh ảnh của sản phẩm đó)
                    if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                        $this->delFile($fileNameOld);
                    }
                    $this->objmAcpIndex->delItem($id);
                } catch (\Exception $e) {
                    $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
                    dd($e->getMessage());
                }
            }
            $this->objmAccommentIndex->delItems($arIdComment);
        }
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.product.index');
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
        $objItems = $this->objmAcpIndex->getItemsSearch($arItem);
        return view('vadmin.core.product.acpindex.search', compact('objItems', 'arItem'));
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

    
    public function getDom()
    {
        $objTH = $this->objmActhIndex->getItemsAuto();
        return view('vadmin.core.product.acpindex.htmldom',compact('objTH'));
    }
    
    public function postDom(Request $request)
    {
        $objTH = $this->objmActhIndex->getItemsAuto();
        $cat_id = $request->cat_id;
        $th_id  = $request->th_id;
        $objCURL = $this->objmAcpcIndex->findURLCat($cat_id,$th_id);
        if ( $objCURL ) {
            $url = $objCURL->url ;
            $picture = $objCURL->picture;
            $domain = $objCURL->domain;
            switch ($objCURL->code) {
                case 'adayroi':
                    $articles = SimpleHTMLDOM::adayroi($url);
                    break;
            }
            
        } else {
            $request->session()->flash('msg', 'Danh mục chưa tạo đường dẫn');
            return redirect()->route('vadmin.core.product.htmldom');
        }
        
       return view('vadmin.core.product.acpindex.htmldom',compact('domain','picture','articles','objPcat','objTH'));
    }
}


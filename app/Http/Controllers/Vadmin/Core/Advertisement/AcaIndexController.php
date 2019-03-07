<?php

namespace App\Http\Controllers\Vadmin\Core\Advertisement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Advertisement\AcapIndexRequest;
use App\Http\Requests\Vadmin\Core\Article\AcaIndexRequest;
use App\Model\Vadmin\Core\AdsPosition\AcapIndex;
use App\Model\Vadmin\Core\Advertisement\AcaIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AcaIndexController extends Controller
{
    public function __construct(AcaIndex $objmAcaIndex, AcapIndex $objmAcapIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
        $this->objmAcapIndex = $objmAcapIndex;
        $objItemsByPosition = $this->objmAcapIndex->getItems();
        view()->share('objItemsByPosition', $objItemsByPosition);
    }

    public function index()
    {
        $objItems = $this->objmAcaIndex->getItems();
        return view('vadmin.core.ads.acaindex.index', compact('objItems'));
    }

    public function getAdd()
    {
        return view('vadmin.core.ads.acaindex.add');
    }

    public function postAdd(AcapIndexRequest $request)
    {
        $arItem = [
            'aname' => trim($request->aname),
            'code_adsense' => trim($request->code_adsense),
            'banner' => null,
            'position_id' => trim($request->position_id),
            'url' => trim($request->url),
            'begin_at' => trim($request->begin_at),
            'end_at' => trim($request->end_at),
        ];
        if (!is_null($request->banner)) {
            $arItem['banner'] = $this->saveOneFile($request, 'banner');
        }

        if ($this->objmAcaIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.ads.add');
        }
        return redirect()->route('vadmin.core.ads.index');
    }

    public function getEdit($id, Request $request)
    {
        $objItemOld = $this->objmAcaIndex->getItem($id);
        return view('vadmin.core.ads.acaindex.edit', compact('objItemOld'));
    }

    public function postEdit($id, AcapIndexRequest $request)
    {
        $objNewsOld = $this->objmAcaIndex->getItem($id);
        $arItem = [
            'aname' => trim($request->aname),
            'code_adsense' => trim($request->code_adsense),
            'banner' => $objNewsOld->banner,
            'position_id' => trim($request->position_id),
            'url' => trim($request->url),
            'begin_at' => trim($request->begin_at),
            'end_at' => trim($request->end_at),
        ];

        if (!is_null($request->delPic) && !empty($request->delPic)) {
            $this->delFile($request->delPic);
            $arItem['banner'] = null;
        }
        if (!is_null($request->banner) && !empty($request->banner)) {
            $this->delFile($objNewsOld->banner);
            $arItem['banner'] = $this->saveOneFile($request, 'banner');
        }
        if ($this->objmAcaIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.ads.edit', $id);
        }
        return redirect()->route('vadmin.core.ads.index');
    }

    public function del($id, Request $request)
    {
        try {
            $objItemOld = $this->objmAcaIndex->getItem($id);
            $fileNameOld = $objItemOld->banner;

            if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                $this->delFile($fileNameOld);
            }
            $this->objmAcaIndex->delItem($id);
            $request->session()->flash('msg', 'Xóa thành công');
        } catch (\Exception $e) {
            $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
            dd($e->getMessage());
        }
        return redirect()->route('vadmin.core.ads.index');
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
        return view('vadmin.core.ads.acaindex.search', compact('objItems', 'arItem'));
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
            $request->file($inputName)->move(storage_path('app/media/files/ads'), $fileName);
        }
        return $fileName;
    }

    public function delFile($fileName)
    {
        if (!is_null($fileName) && !empty($fileName)) {
            Storage::delete("media/files/ads/" . $fileName);
        }
    }
}


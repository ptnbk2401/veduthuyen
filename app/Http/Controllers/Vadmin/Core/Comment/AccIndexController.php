<?php

namespace App\Http\Controllers\Vadmin\Core\Comment;

use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Comment\AccIndex;
use Illuminate\Http\Request;

class AccIndexController extends Controller
{
    public function __construct(AccIndex $objmAccIndex)
    {
        $this->objmAccIndex = $objmAccIndex;
    }

    public function index()
    {
        $objItems = $this->objmAccIndex->getItems();
        return view('vadmin.core.comment.accindex.index', compact('objItems'));
    }

    public function parent(Request $request)
    {
        $objItems = $this->objmAccIndex->getItems($request->id);
        return view('vadmin.core.comment.accindex.parent', compact('objItems'));
    }

    public function del($id, Request $request)
    {
        if ($this->objmAccIndex->delItem($id)) {
            $objAll = $this->objmAccIndex->getItemsAll();
            $arTree = $this->buildTree($objAll, $id);
            $this->objmAccIndex->delItems($arTree);
            $request->session()->flash('msg', 'Xóa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi xóa');
        }
        return redirect()->route('vadmin.core.comment.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            foreach ($request->vnedel as $key => $id) {
                $this->objmAccIndex->delItem($id);
                $objAll = $this->objmAccIndex->getItemsAll();
                $arTree = $this->buildTree($objAll, $id);
                $this->objmAccIndex->delItems($arTree);
            }
        }
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.comment.index');
    }

    public function search(Request $request)
    {
        $aname = $request->aname;
        $active = $request->active;
        $arItem = array(
            'aname' => $aname,
            'active' => $active
        );
        $objItems = $this->objmAccIndex->getItemsSearch($arItem);
        return view('vadmin.core.comment.accindex.search', compact('objItems', 'arItem'));
    }

    public function buildTree(&$elements, $parentId = 0, &$resultId = array())
    {
        $branch = array();
        foreach ($elements as &$element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->fcomment_id, $resultId);
                if ($children) {
                    $element->arChild = $children;
                }
                $branch[$element->fcomment_id] = $element;
                $resultId[] = $element->fcomment_id;

                unset($element);
            }
        }
        return $resultId;
    }
}


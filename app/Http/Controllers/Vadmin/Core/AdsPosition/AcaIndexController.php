<?php

namespace App\Http\Controllers\Vadmin\Core\AdsPosition;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\AdsPosition\AcaIndexRequest;
use App\Model\Vadmin\Core\AdsPosition\AcapIndex;
use Illuminate\Http\Request;

class AcaIndexController extends Controller
{
    public function __construct(AcapIndex $objmAcaIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
    }

    public function index()
    {
        $objItems = $this->objmAcaIndex->getItems();
        return view('vadmin.core.adsposition.acapindex.index', compact('objItems'));
    }

    public function getEdit($id, Request $request)
    {
        $objItemOld = $this->objmAcaIndex->getItem($id);
        return view('vadmin.core.adsposition.acapindex.edit', compact('objItemOld'));
    }

    public function postEdit($id, AcaIndexRequest $request)
    {
        $arItem = [
            'name' => trim($request->name),
            'code' => trim($request->code),
            'note' => trim($request->note)
        ];
        if ($this->objmAcaIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.adsposition.edit', $id);
        }
        return redirect()->route('vadmin.core.adsposition.index');
    }

    public function getAdd()
    {
        return view('vadmin.core.adsposition.acapindex.add');
    }

    public function postAdd(AcaIndexRequest $request)
    {
        $arItem = [
            'name' => trim($request->name),
            'code' => trim($request->code),
            'note' => trim($request->note)
        ];
        if ($this->objmAcaIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.adsposition.add');
        }
        return redirect()->route('vadmin.core.adsposition.index');
    }

    public function del($id, Request $request)
    {
        if ($this->objmAcaIndex->delItem($id)) {
            $request->session()->flash('msg', 'Xóa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi xóa');
        }
        return redirect()->route('vadmin.core.adsposition.index');
    }
}


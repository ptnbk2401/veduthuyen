<?php

namespace App\Http\Controllers\Vadmin\Core\About;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\About\AcaIndexRequest;
use App\Model\Vadmin\Core\About\AcaIndex;
use Illuminate\Http\Request;

class AcaIndexController extends Controller
{
    public function __construct(AcaIndex $objmAcaIndex)
    {
        $this->objmAcaIndex = $objmAcaIndex;
    }

    public function index()
    {
        $objItems = $this->objmAcaIndex->getItems();
        return view('vadmin.core.about.acaindex.index', compact('objItems'));
    }

    public function getEdit($id, Request $request)
    {
        $objItemOld = $this->objmAcaIndex->getItem($id);
        return view('vadmin.core.about.acaindex.edit', compact('objItemOld'));
    }

    public function postEdit($id, AcaIndexRequest $request)
    {
        $arItem = [
            'name' => trim($request->name),
            'content' => trim($request->content),
        ];
        if ($this->objmAcaIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.about.edit', $id);
        }
        return redirect()->route('vadmin.core.about.index');
    }
}


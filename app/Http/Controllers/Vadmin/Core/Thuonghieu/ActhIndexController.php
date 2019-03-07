<?php

namespace App\Http\Controllers\Vadmin\Core\Thuonghieu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Thuonghieu\ActhIndexRequest;
use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ActhIndexController extends Controller
{
    public function __construct(Request $request, ActhIndex $objmActhIndex)
    {
        $this->objmActhIndex = $objmActhIndex;
    }

    public function index()
    {
        $objItems = $this->objmActhIndex->getItems();
        return view('vadmin.core.thuonghieu.acthindex.index', compact('objItems'));
    }

    public function getAdd()
    {
        return view('vadmin.core.thuonghieu.acthindex.add');
    }

    public function postAdd(ActhIndexRequest $request)
    {
        $arItem = [
            'name' => trim($request->name),
            'domain' => trim($request->domain),
            'sort' => trim($request->sort),
            'code' => trim($request->code),
        ];

        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        if ($this->objmActhIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.thuonghieu.add');
        }
        return redirect()->route('vadmin.core.thuonghieu.index');
    }
    

    public function getEdit($id)
    {
        $arItem = $this->objmActhIndex->getItem($id);
        return view('vadmin.core.thuonghieu.acthindex.edit', compact('arItem'));
    }

    public function postEdit($id, ActhIndexRequest $request)
    {
        $objTHOld = $this->objmActhIndex->getItem($id);
        $arItem = [
            'name' => trim($request->name),
            'sort' => trim($request->sort),
            'domain' => trim($request->domain),
            'code' => trim($request->code),
        ];
        if (!is_null($request->delPic) && !empty($request->delPic)) {
            $this->delFile($request->delPic);
            $arItem['picture'] = null;
        }
        if (!is_null($request->picture) && !empty($request->picture)) {
            $this->delFile($objTHOld->picture);
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        }
        
        if ($this->objmActhIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.thuonghieu.edit', [$id]);
        }
        return redirect()->route('vadmin.core.thuonghieu.index');
    }

    public function del($id, Request $request)
    {
        try {
            $this->objmAccIndex->delItem($id);
            $request->session()->flash('msg', 'Xóa thành công');
        } catch (\Exception $e) {
            $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
            dd($e->getMessage());
        }
        return redirect()->route('vadmin.core.thuonghieu.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            foreach ($request->vnedel as $key => $id) {
                try {
                    $this->objmAccIndex->delItem($id);
                } catch (\Exception $e) {
                    $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
                    dd($e->getMessage());
                }
            }
        }
        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.thuonghieu.index');
    }


    
    public function saveOneFile($request, $inputName)
    {
        if (Input::hasFile($inputName)) {
            $extension = Input::file($inputName)->getClientOriginalExtension();
            $fileName = getenv('BASE_FILE_NAME') . '-' . time() . '.' . $extension;
            $request->file($inputName)->move(storage_path('app/media/files/thuonghieu'), $fileName);
        }
        return $fileName;
    }

    public function delFile($fileName)
    {
        if (!is_null($fileName) && !empty($fileName)) {
            Storage::delete("media/files/thuonghieu/" . $fileName);
        }
    }

    

}


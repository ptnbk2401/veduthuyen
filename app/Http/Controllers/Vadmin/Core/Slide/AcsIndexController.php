<?php

namespace App\Http\Controllers\Vadmin\Core\Slide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Slide\AcsIndexRequest;
use App\Model\Vadmin\Core\Slide\AcsIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AcsIndexController extends Controller
{
    public function __construct(AcsIndex $objmAcsIndex)
    {
        $this->objmAcsIndex = $objmAcsIndex;
    }

    public function index()
    {
        $objItems = $this->objmAcsIndex->getItems();
        $objItemsLeft = $this->objmAcsIndex->getItemsLeft();
        return view('vadmin.core.slide.acsindex.index', compact('objItems','objItemsLeft'));
    }

    public function getAdd()
    {
        return view('vadmin.core.slide.acsindex.add');
    }

    public function postAdd(AcsIndexRequest $request)
    {
        $arItem = [
            'sort' => $request->sort,
            'vitri' => $request->vitri,
            'active' => 1,
            'product_id' => trim($request->product_id)
        ];
        if (!is_null($request->picture)) {
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        } else {
            $image = trim($request->picture_old);
            if(!file_exists(storage_path('app/media/files/slide/'))) {
                Storage::makeDirectory('media/files/slide');
            }
            Image::make(storage_path('app/media/files/product/'.$image))->save(storage_path('app/media/files/slide/'.$image));
            $arItem['picture'] = $image;
        }
        
        if ($this->objmAcsIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.slide.add');
        }
        return redirect()->route('vadmin.core.slide.index');
    }

    public function getEdit($id)
    {
        $objItemOld = $this->objmAcsIndex->getItem($id);
        // dd($objItemOld);
        return view('vadmin.core.slide.acsindex.edit', compact('objItemOld'));
    }

    public function postEdit($id, AcsIndexRequest $request)
    {
        $objNewsOld = $this->objmAcsIndex->getItem($id);
        $arItem = [
            'sort' => $request->sort,
            'vitri' => $request->vitri,
            'product_id' => trim($request->product_id)
        ];
        if (!is_null($request->picture) && !empty($request->picture)) {
            $this->delFile($objNewsOld->picture);
            $arItem['picture'] = $this->saveOneFile($request, 'picture');
        } else if (!empty(($request->picture_old))){
            $image = trim($request->picture_old);
            if(!file_exists(storage_path('app/media/files/slide/'))) {
                Storage::makeDirectory('media/files/slide');
            }
            Image::make(storage_path('app/media/files/product/'.$image))->save(storage_path('app/media/files/slide/'.$image));
            $arItem['picture'] = $image;
            $this->delFile($objNewsOld->picture);
        } else {
            $arItem['picture'] = $objNewsOld->picture;
        }
        
        if ($this->objmAcsIndex->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.slide.edit', $id);
        }
        return redirect()->route('vadmin.core.slide.index');
    }

    public function del($id, Request $request)
    {
        try {
            $objItemOld = $this->objmAcsIndex->getItem($id);
            $fileNameOld = $objItemOld->picture;
            if (!is_null($fileNameOld) && !empty($fileNameOld)) {
                $this->delFile($fileNameOld);
            }
            $this->objmAcsIndex->delItem($id);
            $request->session()->flash('msg', 'Xóa thành công');
        } catch (\Exception $e) {
            $request->session()->flash('msg', 'Có lỗi trong quá trình xóa!');
            dd($e->getMessage());
        }
        return redirect()->route('vadmin.core.slide.index');
    }

    public function saveOneFile($request, $inputName)
    {
        if (Input::hasFile($inputName)) {
            $extension = Input::file($inputName)->getClientOriginalExtension();
            $fileName = getenv('BASE_FILE_NAME') . '-' . time() . '.' . $extension;
            $request->file($inputName)->move(storage_path('app/media/files/slide'), $fileName);
        }
        return $fileName;
    }

    public function delFile($fileName)
    {
        if (!is_null($fileName) && !empty($fileName)) {
            Storage::delete("media/files/slide/" . $fileName);
        }
    }
}


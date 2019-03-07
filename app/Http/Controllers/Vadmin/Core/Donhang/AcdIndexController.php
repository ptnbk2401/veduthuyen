<?php

namespace App\Http\Controllers\Vadmin\Core\Donhang;

use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Donhang\AcdIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AcdIndexController extends Controller
{
    
    public function __construct(AcdIndex $objmAcdIndex)
    {
        $this->objmAcdIndex = $objmAcdIndex;        
    }

    public function index() 
    {
    	$objItems = $this->objmAcdIndex->getItems();
        return view('vadmin.core.donhang.acdindex.index',compact('objItems'));

    }
    public function getAdd() 
    {
    	$objItemsNhaMang = $this->objmAcmIndex->getItems();
        return view('vadmin.core.sim.acsindex.add',compact('objItemsNhaMang'));

    }
    public function postAdd(AcsIndexRequest  $request) 
    {
    	$arItem = [
            'nha_mang'         => trim($request->nha_mang),
            'pnumber'          => trim($request->pnumber),
        ];
    	if ($this->objmAcdIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi thêm');
        	return redirect()->route('vadmin.core.group.index');
        }
        return redirect()->route('vadmin.core.sim.index');
    }

    public function getEdit($id) 
    {
    	$objOld = $this->objmAcdIndex->getItem($id);
    	$objItemsNhaMang = $this->objmAcmIndex->getItems();
        return view('vadmin.core.sim.acsindex.edit',compact('objItemsNhaMang','objOld'));

    }
    public function postEdit($id,AcsIndexRequest  $request) 
    {
    	$arItem = [
            'nha_mang'         => trim($request->nha_mang),
            'pnumber'          => trim($request->pnumber),
        ];
    	if ($this->objmAcdIndex->editItem($id,$arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi Sửa');
        	return redirect()->route('vadmin.core.sim.index');
        }
        return redirect()->route('vadmin.core.sim.index');
    }

    public function del($id, Request $request)
    {
        if ($this->objmAcdIndex->delItem($id)) {
            $request->session()->flash('msg', 'Xóa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi xóa');
        }
        return redirect()->route('vadmin.core.sim.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            foreach ($request->vnedel as $key => $uid) {
                $this->objmAcdIndex->delItem($uid);
            }
        }

        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.sim.index');
    }

}


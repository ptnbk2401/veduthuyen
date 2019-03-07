<?php

namespace App\Http\Controllers\Vadmin\Core\Group;

use App\Http\Requests\Vadmin\Core\Group\AcgIndexRequest;
use App\Model\Vadmin\Core\Group\AcgIndex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class AcgIndexController extends Controller
{
    public function __construct(AcgIndex $objmVNEGroup){
        $this->objmVNEGroup = $objmVNEGroup;
    }

    public function index(){
        $objItems = $this->objmVNEGroup->getItems();

        return view('vadmin.core.group.acgindex.index', compact('objItems'));
    }

    public function getAdd(){
    	return view('vadmin.core.group.acgindex.add');
    }
    public function postAdd(AcgIndexRequest $request){
    	$arItem = [
            'name'          => trim($request->name),
//            'companyid'     => $request->companyid,
            'code'          => trim($request->code),
            'sort'          => trim($request->sort),
        ];

    	if ($this->objmVNEGroup->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi thêm');
        	return redirect()->route('vadmin.core.group.index');
        }
        return redirect()->route('vadmin.core.group.index');
    }

    public function del($id, Request $request){
		if ($this->objmVNEGroup->delItem($id)) {
            $request->session()->flash('msg', 'Xóa thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi xóa');
        }
        return redirect()->route('vadmin.core.group.index');
    }

    public function getEdit($id){
    	$arItem = $this->objmVNEGroup->getItem($id);
    	return view('vadmin.core.group.acgindex.edit', compact('arItem'));
    }
    public function postEdit($id, AcgIndexRequest $request){
    	$arItem = [
            'name'         => trim($request->name),
            'code'          => trim($request->code),
//            'companyid'     => $request->companyid,
            'sort'       => trim($request->sort),
        ];
    	if ($this->objmVNEGroup->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi sửa');
        	return redirect()->route('vadmin.core.group.index');
        }
        return redirect()->route('vadmin.core.group.index');
    }

}

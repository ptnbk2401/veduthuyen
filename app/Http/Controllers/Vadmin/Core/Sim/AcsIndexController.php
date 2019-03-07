<?php

namespace App\Http\Controllers\Vadmin\Core\Sim;

use App\Exports\MulSheetsExport;
use App\Exports\SimExport;
use App\Imports\SimImport;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\Sim\AcsIndexRequest;
use App\Model\Vadmin\Core\NhaMang\AcmIndex;
use App\Model\Vadmin\Core\Sim\AcsIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;



class AcsIndexController extends Controller
{
    
    public function __construct(AcsIndex $objmAcsIndex,AcmIndex $objmAcmIndex)
    {
        $this->objmAcsIndex = $objmAcsIndex;
        $this->objmAcmIndex = $objmAcmIndex;
        
    }

    public function index() 
    {
    	$objItems = $this->objmAcsIndex->getItems();
        return view('vadmin.core.sim.acsindex.index',compact('objItems'));

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
    	if ($this->objmAcsIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi thêm');
        	return redirect()->route('vadmin.core.group.index');
        }
        return redirect()->route('vadmin.core.sim.index');
    }

    public function getEdit($id) 
    {
    	$objOld = $this->objmAcsIndex->getItem($id);
    	$objItemsNhaMang = $this->objmAcmIndex->getItems();
        return view('vadmin.core.sim.acsindex.edit',compact('objItemsNhaMang','objOld'));

    }
    public function postEdit($id,AcsIndexRequest  $request) 
    {
    	$arItem = [
            'nha_mang'         => trim($request->nha_mang),
            'pnumber'          => trim($request->pnumber),
        ];
    	if ($this->objmAcsIndex->editItem($id,$arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
        	$request->session()->flash('msg', 'Lỗi khi Sửa');
        	return redirect()->route('vadmin.core.sim.index');
        }
        return redirect()->route('vadmin.core.sim.index');
    }


    public function getImport() 
    {
        return view('vadmin.core.sim.acsindex.import');
    }


    public function postImport(Request $request) 
    {
    	if ($request->hasFile('file')) {
            
            $path = $request->file->store('media/files/excel');
            $tmp = explode('/', $path);
            $fileName = end($tmp);
            $url = '/media/files/excel/'.$fileName ;
            if ( Excel::import(new SimImport, $url) ) {
	            $request->session()->flash('msg', 'Thêm thành công');
	        } else {
	        	$request->session()->flash('msg', 'Lỗi khi Thêm');
	        	return redirect()->route('vadmin.core.sim.import');
	        }
            Storage::delete('media/files/excel/' . $fileName);
    		return redirect()->route('vadmin.core.sim.index');
        }
        
    }

    public function del($id, Request $request)
    {
        if ($this->objmAcsIndex->delItem($id)) {
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
                $this->objmAcsIndex->delItem($uid);
            }
        }

        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.sim.index');
    }
    public function export() 
    {
    	// $arData = $this->objmAcsIndex->getItemsAll();
        // dd($arData[0]);
        // return (new SimExport($arData));
    	return (new MulSheetsExport());
    }

}


<?php

namespace App\Http\Controllers\Vadmin\Core\Contact;

use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\Contact\AccIndex;
use App\Model\Vadmin\Core\Contact\AcrIndex;
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
        return view('vadmin.core.contact.accindex.index', compact('objItems'));
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
        return redirect()->route('vadmin.core.contact.index');
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
        return redirect()->route('vadmin.core.contact.index');
    }

    public function search(Request $request)
    {
        $name = $request->fullname;
        $cat_id = $request->email;
        $active = $request->phone;
        $arItem = array(
            'fullname' => $name,
            'email' => $cat_id,
            'phone' => $active
        );
        $objItems = $this->objmAccIndex->getItemsSearch($arItem);
        return view('vadmin.core.contact.accindex.search', compact('objItems', 'arItem'));
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $objItem = $this->objmAccIndex->getItem($id);
        return view('vadmin.core.contact.accindex.view', compact('objItem'));
    }
}


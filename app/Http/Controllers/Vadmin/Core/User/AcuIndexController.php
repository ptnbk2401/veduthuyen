<?php

namespace App\Http\Controllers\Vadmin\Core\User;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vadmin\Core\User\AcuIndexRequest;
use App\Model\Vadmin\Core\Company\AccIndex;
use App\Model\Vadmin\Core\Group\AcgIndex;
use App\Model\Vadmin\Core\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class AcuIndexController extends Controller
{
    public function __construct(User $objmUser, AcgIndex $objmVNEGroup, AccIndex $objmCompany)
    {
        $this->objmUser = $objmUser;
        $this->objmVNEGroup = $objmVNEGroup;

        $this->objmCompany = $objmCompany;
    }

    public function index()
    {
        $objItems = $this->objmUser->getItems();
        View::share('objmVNEGroup', $this->objmVNEGroup);

        return view('vadmin.core.user.acuindex.index', compact('objItems'));
    }

    public function getAdd()
    {
        $objItemsGroup = $this->objmVNEGroup->getItemsAll();

        return view('vadmin.core.user.acuindex.add', compact('objItemsGroup'));
    }

    public function postAdd(AcuIndexRequest $request)
    {
        $arItem = [
            'username' => trim($request->username),
            'password' => bcrypt(trim($request->password)),
            'first_name' => trim($request->ho),
            'last_name' => trim($request->ten),
            'phone' => trim($request->phone),
            'address' => trim($request->address),
            'avatar' => trim($request->avatar),
            'email' => trim($request->email),
            'vgroup' => $request->vgroup,
        ];
        //xử lý up hình
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $path = $request->avatar->store('media/files/users');
                $tmp = explode('/', $path);
                $fileName = end($tmp);
                $arItem['avatar'] = $fileName;
            }
        }
        $resultId = $this->objmUser->addItem($arItem);
        if ($resultId > 0) {
            $request->session()->flash('msg', 'Thêm thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            return redirect()->route('vadmin.core.user.add');
        }
        return redirect()->route('vadmin.core.user.index');
    }

    public function del($id, Request $request)
    {
        //xóa hình ảnh nếu có
        $arItem = $this->objmUser->getItem($id);
        $avatar = $arItem->avatar;
        if ($avatar != "") {
            Storage::delete('media/files/users' . $avatar);
        }
        if ($this->objmUser->delItem($id)) {
            $request->session()->flash('msg', 'Xóa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi xóa');
        }
        return redirect()->route('vadmin.core.user.index');
    }

    public function getEdit($id)
    {
        $arItem = $this->objmUser->getItem($id);
        $objItemsGroup = $this->objmVNEGroup->getItemsAll();

        //lấy các group của $uid=$id này
        $arGroupOld = $this->objmVNEGroup->getItemsByUid($id);

        return view('vadmin.core.user.acuindex.edit', compact('arItem', 'objItemsGroup', 'arGroupOld'));
    }

    public function postEdit($id, AcuIndexRequest $request)
    {
        $arItem = [
            'username' => trim($request->username),
            'password' => bcrypt(trim($request->password)),
            'first_name' => trim($request->ho),
            'last_name' => trim($request->ten),
            'phone' => trim($request->phone),
            'address' => trim($request->address),
            'avatar' => trim($request->avatar),
//            'sort'          => trim($request->sort),
            'email' => trim($request->email),
//            'uid'           => trim($request->uid),
//            'access_token'  => trim($request->access_token),
            'vgroup' => $request->vgroup,
//            'position'      => $request->position,
        ];
        //xử lý up hình
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                try {
                    $path = $request->avatar->store('media/files/users');
                } catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }
                $tmp = explode('/', $path);
                $fileName = end($tmp);
                $arItem['avatar'] = $fileName;
            }
            //xử lý xóa hình cũ nếu có
            $arItemOld = $this->objmUser->getItem($id);

            $avatar = $arItemOld->avatar;
            if ($avatar != "") {
                Storage::delete('media/files/users/' . $avatar);
            }
        }
        if (trim($request->password) != "") {
            $arItem['password'] = bcrypt(trim($request->password));
        }

        if ($this->objmUser->editItem($id, $arItem)) {
            $request->session()->flash('msg', 'Sửa thành công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi sửa');
            return redirect()->route('vadmin.core.user.edit', [$id]);
        }
        return redirect()->route('vadmin.core.user.index');
    }

    public function delAll(Request $request)
    {
        if (count($request->vnedel) > 0) {
            foreach ($request->vnedel as $key => $uid) {
                //xóa hình ảnh nếu có
                $arItem = $this->objmUser->getItem($uid);
                $avatar = $arItem->avatar;
                if ($avatar != "") {
                    Storage::delete('media/files/users' . $avatar);
                }
                $this->objmUser->delItem($uid);
            }
        }

        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('vadmin.core.user.index');
    }
    public function export() 
    {
        return new UsersExport();
    }
}

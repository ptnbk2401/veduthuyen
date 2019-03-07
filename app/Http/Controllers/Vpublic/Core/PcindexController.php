<?php

namespace App\Http\Controllers\Vpublic\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vpublic\Core\Contact\ContactRequest;
use App\Http\Requests\Vpublic\Core\Register\AcrIndexRequest;
use App\Model\Vadmin\Core\Article\AcaIndex;
use App\Model\Vadmin\Core\Contact\AccIndex;
use App\Model\Vadmin\Core\Cat\AccIndex as Cat;
use App\Model\Vadmin\Core\PCat\AcpcIndex;
use App\Model\Vadmin\Core\Product\AcpIndex;
use App\Model\Vadmin\Core\User\User;
use Illuminate\Http\Request;

class PcindexController extends Controller
{
    public function __construct(User $objmUser,AcpcIndex $objmAcpcIndex, AcaIndex $objmAcaIndex, AcpIndex $objmAcpIndex, AccIndex $objmAccIndex, Cat $objmCat )
    {
        $this->objmUser = $objmUser;
        $this->objmAcaIndex = $objmAcaIndex;
        $this->objmAcpIndex = $objmAcpIndex;
        $this->objmAcpcIndex = $objmAcpcIndex;
        $this->objmAccIndex = $objmAccIndex;
        $this->objmCat = $objmCat;

    }

    public function index()
    {
        $idDuThuyen = 48;
        $idHotel = 49;
        $objTourItems = $this->objmAcpIndex->getItemsTourPopular(6,$idDuThuyen);
        $objHotelItems = $this->objmAcpIndex->getItemsTourPopular(4,$idHotel);
        $objTourItems2 = $this->objmAcpIndex->getItemsTourPopular(12,$idDuThuyen);
        $objNewsItems = $this->objmAcaIndex->getItemsPLIndex(4);
        // dd($objNewsItems);
        return view('vpublic.core.pcindex.index',compact('objTourItems','objHotelItems','objTourItems2','objNewsItems'));
    }

    public function contact()
    {
        return view('vpublic.core.pccontact.index');
    }
    public function postContact(ContactRequest $request)
    {
        // dd($request->all());
        $fullname = trim($request->fullname);
        $email = trim($request->email);
        $phone = trim($request->phone);
        $content = trim($request->content);
        $arItem = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'content' => $content,
        ];
        if ($this->objmAccIndex->addItem($arItem)) {
            $request->session()->flash('msg', 'Gửi thành công');
        } else {
            $request->session()->flash('msg-er', 'Lỗi khi Gửi liên hệ');
            return redirect()->back();
        }
        return redirect()->route('vpublic.core.pccontact.index');
    }
    public function detail($cat,$codetour,Request $request)
    {
        $objItemTour = $this->objmAcpIndex->getItemCode($codetour);
        $objImages = $this->objmAcpIndex->getImages($objItemTour->product_id);
        return view('vpublic.core.pcdetail.index',compact('objItemTour','objImages'));
    }
    
    
    public function postRegister(AcrIndexRequest $request)
    {
        $middle_name = empty(trim($request->middle_name))? trim($request->middle_name) : '' ;
        $arItem = [
            'username' => trim($request->username),
            'password' => bcrypt(trim($request->password)),
            'first_name' => trim($request->first_name),
            'last_name' => $middle_name.' '.trim($request->last_name),
            'phone' => trim($request->phone),
            'address' => trim($request->address),
            'avatar' => ' ',
            'vgroup' => [getenv('ID_GR_KHACHHANG')],
            'email' => trim($request->email),
        ];
        // dd($arItem);
        //xử lý up hình
        // if ($request->hasFile('avatar')) {
        //     if ($request->file('avatar')->isValid()) {
        //         $path = $request->avatar->store('media/files/users');
        //         $tmp = explode('/', $path);
        //         $fileName = end($tmp);
        //         $arItem['avatar'] = $fileName;
        //     }
        // }
        $resultId = $this->objmUser->addItem($arItem);
        if ($resultId > 0) {
            $request->session()->flash('msg', 'Đăng Ký Thành Công');
        } else {
            $request->session()->flash('msg', 'Lỗi khi thêm');
            // dd($arItem);
            return redirect()->back();
        }
        return redirect()->route('vpublic.core.pclogin.index');
        
    }
    public function gridCat($code,Request $request)
    {
        $objCat = $this->objmAcpcIndex->getItemByCode($code);
        $objTours = $this->objmAcpIndex->getItemsTourPL($objCat->cat_id);
        return view('vpublic.core.pcgridcat.index',compact('objTours','objCat'));
    }
    public function Blog($code,Request $request)
    {
        $objCat = $this->objmCat->getItemByCode($code);
        $objArticle = $this->objmAcaIndex->getItemsPLByCat($objCat->cat_id);
        $objItemsNew = $this->objmAcaIndex->getItemsNew(5);
        $objBlogCat = $this->objmCat->getItemsActive();
        return view('vpublic.core.pcblog.index',compact('objArticle','objCat','objItemsNew','objBlogCat'));
    }
    public function singleDetail($code,Request $request)
    {
        $objItem = $this->objmAcaIndex->getItemCode($code);
        $objItemsNew = $this->objmAcaIndex->getItemsNew(5);
        $objBlogCat = $this->objmCat->getItemsActive();
        return view('vpublic.core.pcsingle.index',compact('objItem','objItemsNew','objBlogCat'));
    }
}

<?php

namespace App\Http\Controllers\Vadmin\Core\ApiAccesstrade;

use App\Classes\Accesstrade;
use App\Classes\SimpleHTMLDOM;
use App\Http\Controllers\Controller;
use App\Model\Vadmin\Core\AccesstradeCate\AcacIndex;
use App\Model\Vadmin\Core\ChienDich\AccdIndex;
use App\Model\Vadmin\Core\PCat\AcpcIndex;
use App\Model\Vadmin\Core\Thuonghieu\ActhIndex;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Sunra\PhpSimple\HtmlDomParser;


class AcaaIndexController extends Controller
{
    public function __construct(AcpcIndex $objmAcpcIndex,AccdIndex $objmAccdIndex,AcacIndex $objmAcacIndex)
    {
        $this->objmAcpcIndex = $objmAcpcIndex;
        $this->objmAccdIndex = $objmAccdIndex;
        $this->objmAcacIndex = $objmAcacIndex;
        
    }

    public function chiendich()
    {
        $arChienDich = $this->objmAccdIndex->getArItems();
        return view('vadmin.core.accesstrade.acaindex.chiendich',compact('arChienDich'));
    }
    public function saveCD(Request $request)
    {
        $arChienDich = Accesstrade::getChiendich();
        $this->objmAccdIndex->addItems($arChienDich);
        $request->session()->flash('msg', 'Cập nhật thành công');
        return redirect()->route('vadmin.core.accesstrade.chiendich');
    }

    public function edit($id,Request $request)
    {
        $name= $request->name ;
        $domain= $request->domain ;
        $this->objmAccdIndex->editItem($id,['name' => $name,'domain' => $domain]);
        $request->session()->flash('msg', 'Cập nhật thành công');
        return redirect()->route('vadmin.core.accesstrade.chiendich');
    }

    public function getKhuyenmai($merchant)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://api.accesstrade.vn/v1/offers_informations',[
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'Token n9hCM0f2Jb24AKX3pTLoNHCoT8GyD2E3'
            ],
            'query' => [
                'merchant'  => $merchant, //merchant lazada
            ],
            'decode_content' => false,
        ]);
        $body = $res->getBody();
        $data = json_decode($body, true);
        $arKhuyenMai = $data['data'];
         // dd($arKhuyenMai);
        return view('vadmin.core.accesstrade.acaindex.khuyenmai',compact('merchant', 'arKhuyenMai'));
    }
    public function postKhuyenmai($merchant,Request $request)
    {
        $scope= $request->scope ;
        $merchant = $merchant;
        $coupon= $request->scope;
        $client = new Client();
        $res = $client->request('GET', 'https://api.accesstrade.vn/v1/offers_informations',[
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'Token n9hCM0f2Jb24AKX3pTLoNHCoT8GyD2E3'
            ],
            'query' => [
                'scope'     => $scope, // expiring: sắp hết hạn  , còn lại lấy hết
                'merchant'  => $merchant, //merchant lazada
                'coupon'    => $coupon, // 1: có mã giảm giá - 0: không có - mặc định lấy all
            ],
            'decode_content' => false,
        ]);
        $body = $res->getBody();
        $data = json_decode($body, true);
        $arKhuyenMai = $data['data'];
        return view('vadmin.core.accesstrade.acaindex.khuyenmai',compact('merchant', 'arKhuyenMai'));
    }
    public function getTop()
    {
        $objCD = $this->objmAccdIndex->getItems();
        $arTop = [];
         // dd($arTop);
        return view('vadmin.core.accesstrade.acaindex.topproducts',compact('arTop','objCD'));
    }
    public function postTop(Request $request)
    {
        $merchant  = $request->merchant ;
        $date_from = date('d-m-Y', strtotime($request->date_from));
        $date_to = date('d-m-Y', strtotime($request->date_to));
        // dd($date_from);
        $objCD = $this->objmAccdIndex->getItems();
        $client = new Client();
        $res = $client->request('GET', 'https://api.accesstrade.vn/v1/top_products',[
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'Token n9hCM0f2Jb24AKX3pTLoNHCoT8GyD2E3'
            ],
            'query' => [
                'date_from' => $date_from,
                'date_to'   => $date_to,
                'merchant'  => $merchant, //merchant lazada
                'price_from'  =>  90000000, //merchant lazada
            ],
            'decode_content' => false,
        ]);
        $body = $res->getBody();
        $data = json_decode($body, true);
        $arTop = $data['data'];
         // dd($arTop);
        return view('vadmin.core.accesstrade.acaindex.topproducts',compact('merchant','date_to','date_from','arTop','objCD'));
    }

    public function getDatafeeds()
    {
        $objCD = $this->objmAccdIndex->getItems();
        $objCate = $this->objmAcacIndex->getItems();
        $arData = array();
        return view('vadmin.core.accesstrade.acaindex.datafeeds',compact('arData','objCD','objCate'));
    }
    public function postDatafeeds(Request $request)
    {
        $query= array();
        if(!empty($request->domain)){
            $query['domain'] = $request->domain;
        }
        if(!empty($request->discount_rate_from)){
            $query['discount_rate_from'] = $request->discount_rate_from;
        }
        if(!empty($request->limit)){
            $query['limit'] = $request->limit;
        }
        if(!empty($request->price_from)){
            $query['price_from'] = $request->price_from;
        }
        if(!empty($request->price_to)){
            $query['price_to'] = $request->price_to;
        }
        if(!empty($request->page)){
            $query['page'] = $request->page;
        }
        if(!empty($request->cate)){
            $query['cate'] = $request->cate;
        }
        // dd($query['cate']);
        $objCD = $this->objmAccdIndex->getItems();
        $objCate = $this->objmAcacIndex->getItems();
        $arData = Accesstrade::getDataFeed($query);
        // dd($arData);
        return view('vadmin.core.accesstrade.acaindex.datafeeds',compact('query','arData','objCD','objCate'));
    }
    

    public function activeStatus(Request $request) {
        $cid = $request->cid;
        $objCD = $this->objmAccdIndex->getItem($cid);
        $active = $objCD->active;
        if( $active == 0 ) {
            $this->objmAccdIndex->updateActive($cid, 1);
            return '<i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>';
        } else {
            $this->objmAccdIndex->updateActive($cid, 0);
            return   '<i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>';
        }
    }





















    public function findSaveSate(Request $request)
    {

        for ($page = 3745 ; $page <= 3756; $page += 5) {
            $query= [
                'limit'=> 200,
                'domain'=> 'tiki.vn',
                'page'=> $page,
            ];
            $arData = Accesstrade::getDataFeed($query);
            foreach ($arData as $product){
                $category = $product['cate'];
                  if(!empty($category)) {
                    $this->objmAcacIndex->addItem($category);
                }

            }

            echo $page."- OK <br>";
            // if($page==2) die();
        }
        
        $objCate = $this->objmAcacIndex->getItems();
        dd($objCate);
        // return view('vadmin.core.accesstrade.acaindex.datafeeds',compact('query','arData','objCD','objCate'));
    }

}


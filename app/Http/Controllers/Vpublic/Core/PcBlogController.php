<?php

namespace App\Http\Controllers\Vpublic\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vpublic\Core\Comment\CommentRequest;
use App\Http\Requests\Vpublic\Core\Register\AcrIndexRequest;
use App\Model\Vadmin\Core\Article\AcaIndex;
use App\Model\Vadmin\Core\Cat\AccIndex;
use App\Model\Vadmin\Core\Comment\AccIndex as Comments;
use App\Model\Vadmin\Core\User\User;
use App\Model\Vadmin\Core\View\AcvIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PcBlogController extends Controller
{
    public function __construct(User $objmUser,AcaIndex $objmAcaIndex ,AccIndex $objmAccIndex,Comments $objmComments )
    {
        $this->objmUser = $objmUser;
        $this->objmAcaIndex = $objmAcaIndex;
        $this->objmAccIndex = $objmAccIndex;
        $this->objmComments = $objmComments;

    }
    public function BlogCat($cat_id,$slugname,Request $request)
    {
        $objItems = $this->objmAcaIndex->getItemsByCatId($cat_id);
        $CatItem = AccIndex::find($cat_id);
        if(!empty($CatItem)){
            $cname = $CatItem->cname;
        } else {
            $cname = 'Danh mục';
        }
        return view('vpublic.core.pcbloglist.index',compact('objItems','cat_id','cname'));
    }
    public function BlogDetail($id,$slugname,AcvIndex $AcvIndex,Request $request)
    {

        $objItem = $this->objmAcaIndex->getItemPL($id);
        $cat_id = $objItem->cat_id;
        $objItemLQ = $this->objmAcaIndex->getItemsLienQuan($cat_id,$id);
        // dd($objItemLQ);
        $objItemsCmtCha = $this->objmComments->getItemsByPost($id,0);
        $AcvIndex->countItem($id);
        return view('vpublic.core.pcblogsingle.index',compact('objItem','objItemsCmtCha','objItemLQ'));
    }

    public function BlogComment($article_id,CommentRequest $request)
    {
        $arItem = [
            'fullname' => trim($request->fullname),
            'email' => trim($request->email),
            'sdt' => trim($request->numberphone),
            'website' => trim($request->website),
            'content' => trim($request->content),
            'user_id' => Auth::id(),
            'article_id' => $article_id,
            'parent_id' => isset($request->parent_id)?$request->parent_id : 0 ,
        ];
        if ($this->objmComments->addItem($arItem)) {
            $request->session()->flash('msg', 'Bình luận của bạn đã được đăng');
        } else {
            $request->session()->flash('msg-er', 'Đăng bình luận thất bại');
        }
        return redirect()->back();
    }

}

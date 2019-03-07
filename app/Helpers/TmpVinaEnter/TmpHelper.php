<?php
namespace App\Helpers\TmpVinaEnter;

use Illuminate\Support\Facades\DB;

class TmpHelper {

	public function buildAdminLeftBar($arr, $parent = 0) {
          $html = ""; 
          foreach ( $arr as $key => $v ) {
            $id = $v['id'];
            $name = $v['name'];
            if ($parent == $v['parent_id']) {
                $html .= '<li><a>'.$name.'<span class="fa fa-chevron-down"></span></a>';
            } else {
                $html .= '<li class="sub_menu"><a href="'.route('business.bnaccount.accountList', $id).'">'.$name.'</a></li>';
            }

            if (array_key_exists('child', $v)) {
                $html .= '<ul class="nav child_menu">';

                $html .= $this->buildAdminLeftBar($v['child'], $parent);
                
                $html .= '</ul>';
            } else {
                $html .= '<li class="sub_menu"><a href="'.route('business.bnaccount.accountList', $id).'">'.$name.'</a></li>';
            }

            if ($parent == $v['parent_id']) {
              $html .= '</li>'; 
            }
          }


          return $html;
    }

    public function buildUserLeftBar($arr, $parent = 0) {
          $html = ""; 
          foreach ( $arr as $key => $v ) {
            $id = $v['id'];
            $name = $v['name'];
            if ($parent == $v['parent_id']) {
                $html .= '<li><a>'.$name.'<span class="fa fa-chevron-down"></span></a>';
            } else {
                $html .= '<li><a>'.$name.'<span class="fa fa-chevron-down"></span></a>';
                $html .= '<ul class="nav child_menu">';
                    $html .= '<li><a href="'.route('mybusiness.bnmyaccount.accountList', $id).'">List</a></li>';
                    $html .= '<li><a href="'.route('mybusiness.bnmyaccount.add', $id).'">Add</a></li>';
                $html .= '</ul>';

                $html .= '</li>';
            }

            if (array_key_exists('child', $v)) {
                $html .= '<ul class="nav child_menu">';

                $html .= $this->buildUserLeftBar($v['child'], $parent);

                $html .= '</ul>';
            } else {
                $html .= '<li class="sub_menu"><a href="'.route('mybusiness.bnmyaccount.accountList', $id).'">'.$name.'</a></li>';
            }

            if ($parent == $v['parent_id']) {
              $html .= '</li>'; 
            }
          }


          return $html;
    }

   
    public static function getParents($cid, &$arResult = array()) {
        $objItem = DB::table('bnsourcecat')->where('id', $cid)->first();
        $arResult[] = $objItem;
        $parent_id = $objItem->parent_id;
        if ($parent_id > 0) {
            TmpHelper::getParents($objItem->parent_id, $arResult);
        }
        return $arResult;
    }

    public static function getParentString($cid){
        $str = "";
        $arItems = TmpHelper::getParents($cid);
        $arItems = array_reverse($arItems);
        foreach ($arItems as $key => $arItem) {
            if (($key+1) != count($arItems)) {
                $str .= $arItem->name.' > ';
            } else {
                $str .= $arItem->name;
            }
        }
        return $str;
    }

    public static function getIdsChild($cid, &$arResult = array()) {
        $arResult[] = $cid;

        $objItems = DB::table('bnsourcecat')->where('parent_id', $cid)->get();
        if (!is_null($objItems)) {
            foreach ($objItems as $key => $objItem) {
                $ncid = $objItem->id;
                $arResult[] = $ncid;
                TmpHelper::getIdsChild($ncid, $arResult);
            }
        }
        $arResult = array_unique($arResult, 0);
        return $arResult;
    }


}

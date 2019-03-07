<?php
namespace App\Helpers\Core;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class CoreMultiLevelHelper {
    protected $idName = 'id';
    protected $parentIdName = 'parent_id';
    protected $arChildName = 'arChild';

    public function getIdName() {
        return $this->idName;
    }
    public function getParentIdName() {
        return $this->parentIdName;
    }
    public function getArChildName() {
        return $this->arChildName;
    }

    public function getArIdsFromParent($arTree, $idName='id', $arChildName='child', $parentId = 0, &$arId = array()) {
        foreach ($arTree as $key => $v ) {
            $id = $v[$idName];
            $arId[] = $id;

            if (array_key_exists($arChildName, $v)) {
                $this->getArIdsFromParent($v[$arChildName],$idName,$arChildName,$parentId,$arId);
            } 
        }
        return $arId;
    }


    public function buildTree(&$elements, $parentId = 0) {
	    $branch = array();
	    foreach ($elements as &$element) {
	        if ($element[$this->getParentIdName()] == $parentId) {
	            $children = CoreMultiLevelHelper::buildTree($elements, $element[$this->getIdName()]);
	            if ($children) {
	                $element[$this->getArChildName()] = $children;
	            }
	            $branch[$element[$this->getIdName()]] = $element;
	            unset($element);
	        }
	    }
	    return $branch;
	}

	

	public function buildHtmlExample($arr, $parent = 0, &$indent = 0) {
          $html = ""; 
          foreach ( $arr as $key => $v ) {
            $id = $v['id'];
            $sort = $v['sort'];

            if ($v['parent_id'] == 0) {
                $indent = 0;
            }
            $urlEdit = route('business.bnsourcecat.edit', [$id]);
            $urlDel  = route('business.bnsourcecat.del', [$id]);

            $html .= '<tr class="even pointer">
              <td class="a-center ">
                <input type="checkbox" class="flat vnedel" name="vnedel[]" value="id">
              </td>
              <td>'.str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)).''.$v['name'].'</td>
              <td>'.$sort.'</td>
              <td>'.$id.'</td>
              <td class="last"><a href="'.$urlEdit.'">Sửa</a> | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')" href="d'.$urlDel.'el">Xóa</a>
              </td>
            </tr>';

            if (array_key_exists('arChild', $v)) {
                $indent+=2;
                $html .= $this->buildHtml($v['arChild'], $parent, $indent);
                $indent-=2;
            } 
          }

          return $html;
    }

    //ok
    public function buildOption($arr, $parent = 0, $target=0, &$indent = 0) {
          $html = ""; 
          foreach ( $arr as $key => $v ) {
            $id = $v['id'];
            $name = $v['name'];

            if ($v['parent_id'] == 0) {
                $indent = 0;
            }
            if ($target != $id) {
                $html .= '<option value="'.$id.'">'.str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)).$name.'</option>';
            } else {
                $html .= '<option value="'.$id.'" selected="selected">'.str_repeat('&nbsp;&nbsp;&nbsp;', ($indent)).$name.'</option>';
            }
            if (array_key_exists('child', $v)) {
                $indent+=2;
                $html .= $this->buildOption($v['child'], $parent, $target, $indent);
                $indent-=2;
            } 
          }

          return $html;
    }


}

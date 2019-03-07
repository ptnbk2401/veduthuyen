<?php

namespace App\Model\Vadmin\Core\Contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccIndex extends Model
{
    protected $table = "vne_contact";
    protected $primaryKey = "contact_id";
    public $timestamps = true;

    public static function getItems()
    {
        return DB::table('vne_contact')
            ->orderBy('contact_id', 'DESC')
            ->paginate(getenv('ADMIN_PAGE'));
    }

    public function addItem($arItem)
    {
        return DB::table('vne_contact')->insert($arItem);
    }

    public function getItem($id)
    {
        return $this->findOrFail($id);
    }


    public function delItem($id)
    {
        $objItem = $this->findOrFail($id);
        return $objItem->delete();
    }

    public function getItemsSearch($arItem = array())
    {
        $objQuery = DB::table('vne_contact');

        if ($arItem['fullname'] != '' && $arItem['fullname'] != null) {
            $objQuery->where('fullname', '=', $arItem['fullname']);
        }

        if ($arItem['email'] != '' && $arItem['email'] != null) {
            $objQuery->where('email', '=', $arItem['email']);
        }

        if ($arItem['phone'] != '' && $arItem['phone'] != null) {
            $objQuery->where('phone', '=', $arItem['phone']);
        }
        return $objQuery->orderBy('contact_id', 'DESC')->paginate(getenv('ADMIN_PAGE'));
    }
}

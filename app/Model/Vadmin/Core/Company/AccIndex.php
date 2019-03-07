<?php

namespace App\Model\Vadmin\Core\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccIndex extends Model
{
    protected $table = "vnecompany";
    protected $primaryKey = "companyid";
    public $timestamps = false;

    public function getItems(){
        return $this->orderBy('companyid', 'ASC')->paginate(getenv('USER_PAGE'));
    }

    public function getItem($id){
        return $this->findOrFail($id);
    }


    //các function khác
    public function getItemsAll(){
        return $this->orderBy('companyid', 'ASC')->get();
    }

}



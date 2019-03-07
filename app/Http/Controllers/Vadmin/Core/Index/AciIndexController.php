<?php

namespace App\Http\Controllers\Vadmin\Core\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AciIndexController extends Controller
{

    public function __construct(){
 		
    }

    public function index(Request $request){
        return view('vadmin.core.index.aciindex.index');
    }


}

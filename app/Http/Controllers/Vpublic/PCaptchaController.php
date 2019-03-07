<?php

namespace App\Http\Controllers\Vpublic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PCaptchaController extends Controller
{
    public function __construct()
    {
    }

    public function create()
    {
        return view('captchacreate');
    }
    public function captchaValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha'
        ]);
    }
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('flat')]);
    }
}

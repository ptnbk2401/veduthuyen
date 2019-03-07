<?php

namespace App\Http\Requests\Vpublic\Core\DatVe;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class DatVeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Route $route, Request $request)
    {
        return [
            'fullname'         => 'required|max:250',
            'email'            => 'required|email|max:250',      
            'phone'            => 'required|max:20',
            'diachi'            => 'required|max:250',
            'captchaDatVe'     => 'required|captcha',
        ];    
    }
    public function messages()
    {
        return [
            'fullname.required'       => 'Nhập họ tên',            
            'fullname.max'            => 'Nhập họ tên không quá :max ký tự',                   
            'email.required'          => 'Nhập Email',    
            'diachi.required'          => 'Nhập địa chỉ không quá :max ký tự',    
            'diachi.max'          => 'Nhập địa chỉ',    
            'email.email'             => 'Nhập Email không đúng định dạng',    
            'email.max'                 => 'Nhập Email không quá :max ký tự',   
            'phone.required'            => 'Nhập Số điện thoại',    
            'phone.max'                 => 'Nhập Số điện thoại không quá :max ký tự',  
            'captchaDatVe.required'   => 'Nhập Mã Captcha',    
            'captchaDatVe.captcha'    => 'Mã Captcha không đúng',    
            
        ];
    }
}

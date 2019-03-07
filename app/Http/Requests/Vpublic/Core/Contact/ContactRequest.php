<?php

namespace App\Http\Requests\Vpublic\Core\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ContactRequest extends FormRequest
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
            'email'            => 'required|max:250',      
            'content'          => 'required|min:15',
            'phone'            => 'required|max:20',
            'captchaContact'   => 'required|captcha',
        ];    
    }
    public function messages()
    {
        return [
            'fullname.required'       => 'Nhập họ tên',            
            'fullname.max'            => 'Nhập họ tên không quá :max ký tự',                
            'content.required'          => 'Nhập nội dung liên hệ',    
            'content.min'               => 'Nhập nội dung liên hệ ít nhất :min ký tự',    
            'email.required'            => 'Nhập Email',    
            'email.max'                 => 'Nhập Email không quá :max ký tự',   
            'phone.required'            => 'Nhập Số điện thoại',    
            'phone.max'                 => 'Nhập Số điện thoại không quá :max ký tự',  
            'captchaContact.required'   => 'Nhập Mã Captcha',    
            'captchaContact.captcha'    => 'Mã Captcha không đúng',    
            
        ];
    }
}

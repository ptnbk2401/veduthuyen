<?php

namespace App\Http\Requests\Vpublic\Core\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class CommentRequest extends FormRequest
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
            'fullname'     => 'required|max:250',
            'email'        => 'required|max:250|email',      
            'content'      => 'required',  
        ];    
    }
    public function messages()
    {
        return [
            'fullname.required'       => 'Nhập họ tên',            
            'fullname.max'            => 'Nhập họ tên không quá :max ký tự',                
            'email.required'          => 'Nhập Email',    
            'email.max'               => 'Nhập Email không quá :max ký tự',    
            'email.email'             => 'Nhập Email chưa đúng định dạng',    
            'content.required'        => 'Nhập Nội dung bình luận',    
        ];
    }
}

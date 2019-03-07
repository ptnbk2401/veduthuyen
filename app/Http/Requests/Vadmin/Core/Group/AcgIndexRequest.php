<?php

namespace App\Http\Requests\Vadmin\Core\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class AcgIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //chính là chỗ này
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Route $route)
    {
        $unique = (strpos($route->getName(),"add")) ? "|unique:vne_groups,code" : "";
        return [
            'name' => 'required',
            'code' => "required{$unique}",       
            'sort' => 'required',         
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'code.required' => 'Mã code không được để trống',
            'code.unique' => 'Mã code đã tồn tại',
            'sort.required' => 'Sắp xếp không được để trống',
        ];
    }
}

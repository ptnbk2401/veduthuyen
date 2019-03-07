<?php

namespace App\Http\Requests\Vadmin\Core\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AccIndexRequest extends FormRequest
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
       // $unique = (strpos($route->getName(),"add")) ? "|unique:vne_cat,code" : '';
        $id =  $request->id;
        $required = (strpos($route->getName(),"add")) ? "required" : "";
        $unique = (strpos($route->getName(),"add")) ? "vne_cat" : "vne_cat,code,".$id.",cat_id";

        return [
            'name' => 'required',
            'code' => "$required|unique:{$unique}",
            'sort' => $required,
        ];
    }
    public function messages()
    {
        return [
            'name.required'          => 'Tên danh mục không được trống',
            'sort.required'    => 'Sắp xếp không được để trống',
            'code.required'        => 'Mã code không được để trống',
            'sort.int'        => 'Sắp xếp phải là số',
            'code.unique'  => 'Mã code đã tồn tại',
        ];
    }
}

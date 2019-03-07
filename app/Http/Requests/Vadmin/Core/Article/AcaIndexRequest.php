<?php

namespace App\Http\Requests\Vadmin\Core\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AcaIndexRequest extends FormRequest
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
        $id =  $request->id;
        $required = (strpos($route->getName(),"add")) ? "required" : "";
        $unique = (strpos($route->getName(),"add")) ? "vne_article" : "vne_article,code,".$id.",article_id";
        $has_video = $request->has_video;
        $requiredId = empty($has_video)? '' : 'required';
        return [
            'aname' => 'required',
            'ID_Video' => $requiredId,
            'code' => "$required|unique:{$unique}",
            'sort' => $required,
            'cat_id' => 'required|integer|min:1',
            'detail_text' => 'required',
            'preview_text' => 'required',
        ];

    }
    public function messages()
    {
        return [
            'aname.required'   => 'Tên bài viết không được trống',
            'code.required'    => 'Mã code không được để trống',
            'code.unique'      => 'Mã code đã tồn tại',
            'sort.required'    => 'Sắp xếp không được để trống',
            'sort.int'         => 'Sắp xếp phải là số',
            'cat_id.min'       => 'Danh mục phải chọn',
            'ID_Video.required' => 'Thêm link Video hợp lệ',
            'preview_text.required' => 'Mô tả bài viết không được để trống',
            'detail_text.required' => 'Chi tiết bài viết không được để trống',
        ];
    }
}

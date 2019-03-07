@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Danh mục sản phẩm <small>Sửa</small></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          <div class="x_content">
            <br>
            <form action="{{ route('vadmin.core.pcat.edit', $arItem['cat_id']) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên danh mục</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="name" value="{{ old('name', $arItem['cname']) }}" class="form-control" placeholder="Nhập tên danh mục"  onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" >
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-12">Danh mục cha</label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select name="parent_id" size="20" class="form-control">
                        <option value="0" selected="selected">--Chọn danh mục cha--</option>
                        {!! $strOption !!}
                    </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="file" name="icon" value="Upload file" class="form-control">
                       @if(!empty($arItem->icon))
                          <a href="{{asset('/storage/app/media/files/product/'.$arItem->icon)}}" target="_blank"><img height="100px" src="{{asset('/storage/app/media/files/product/'.$arItem->icon)}}" alt=""></a>
                          <input type="checkbox" name="delPic" value="{{$arItem->icon}}"> Delete icon
                      @else
                          <input type="hidden" name="delPic" value="">
                      @endif
                  </div>
              </div>
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã code</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input readonly type="text" id="slug-text" value="{{ $arItem['code'] }}"  name="code" class="form-control" placeholder="Nhập mã code">
                    </div>
                </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sắp xếp</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="sort" value="{{ old('name', $arItem['sort']) }}" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Thực hiện</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary">Quay lại</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
</div>
@endsection
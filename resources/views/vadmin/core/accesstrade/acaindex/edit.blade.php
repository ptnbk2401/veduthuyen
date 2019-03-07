@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Thương hiệu <small>Sửa</small></h3>
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
            <form action="{{ route('vadmin.core.thuonghieu.edit', $arItem['th_id']) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên Thương hiệu</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="name" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" value="{{ old('name', $arItem['name']) }}" class="form-control" placeholder="Nhập tên thương hiệu">
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="text" name="code"  id="slug-text" value="{{ old('code', $arItem['code'])}}" class="form-control" placeholder="Code" readonly>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Domain</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="domain" value="{{ old('domain', $arItem['domain']) }}" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
                </div>
              </div>
              
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sắp xếp</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="sort" value="{{ old('sort', $arItem['sort']) }}" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="file" name="picture" value="Upload file" class="form-control">
                        @if(!empty($arItem['picture']))
                          <a href="{{asset('/storage/app/media/files/thuonghieu/'.$arItem['picture'])}}" target="_blank"><img height="100px" src="{{asset('/storage/app/media/files/thuonghieu/'.$arItem['picture'])}}" alt=""></a>
                      @endif
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
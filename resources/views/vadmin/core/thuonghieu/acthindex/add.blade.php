@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Thương hiệu <small>Thêm</small></h3>
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
            <form action="{{ route('vadmin.core.thuonghieu.add') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên Thương hiệu</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="name" class="form-control" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" placeholder="Nhập tên thương hiệu">
                </div>
              </div>
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input readonly type="text" name="code"  id="slug-text" value="{{ old('code')}}" class="form-control" placeholder="Code">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Domain</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="domain" class="form-control" placeholder="Nhập domain">
                    </div>
                </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sắp xếp</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="sort" value="500" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="file" name="picture" value="Upload file" class="form-control">
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
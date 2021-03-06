@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Quản lí Sim <small>Thêm</small></h3>
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
            <form action="{{ route('vadmin.core.sim.add') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-12">Nhà Mạng</label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select name="nha_mang" class="form-control" >
                        <option value="" >--Chọn nhà Mạng--</option>
                        @foreach ($objItemsNhaMang as $mang)
                        <option value="{{ $mang->mang_id }}" >{{ $mang->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Số Thuê Bao</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="text" name="pnumber" value="{{ old('pnumber')}}" class="form-control" placeholder="Nhập Số Thuê Bao" >
                  </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Thực hiện</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary">Quay lại</a>
                  <a href="{{ route('vadmin.core.sim.import') }} " class="btn btn-success">Nhập từ Excel</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
    
</div>
@endsection
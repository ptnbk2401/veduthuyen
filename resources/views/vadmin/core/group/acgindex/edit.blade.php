@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Nhóm người dùng <small>Sửa</small></h3>
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
            <form action="{{ route('vadmin.core.group.edit', [$arItem->groupId]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="name" value="{{ old('name', $arItem->name) }}" class="form-control" placeholder="Nhập tên nhóm người dùng">
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã code</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="code" value="{{ old('code', $arItem->code) }}" class="form-control" placeholder="Nhập mã code. Ví dụ: tech hay mo">
                </div>
              </div>
              {{--<div class="form-group">--}}
                {{--<label class="control-label col-md-3 col-sm-3 col-xs-12">Thuộc công ty</label>--}}
                {{--<div class="col-md-9 col-sm-9 col-xs-12">--}}
                  {{--<select name="companyid" class="form-control">--}}
                    {{--<option value="0">--Công ty--</option>--}}
                    {{--@foreach ($objCompanys as $objCompany)--}}
                        {{--@if ((old('companyId') == $objCompany->groupId) || ($objCompany->groupId == $objItem->companyid) )--}}
                            {{--<option value="{{ $objCompany->companyid }}" selected="selected">{{ $objCompany->name }}</option>--}}
                        {{--@else--}}
                            {{--<option value="{{ $objCompany->companyid }}">{{ $objCompany->name }}</option>--}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                  {{--</select>--}}
                {{--</div>--}}
              {{--</div>--}}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sắp xếp</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="sort" value="{{old('sort', $arItem->sort) }}" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off">
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
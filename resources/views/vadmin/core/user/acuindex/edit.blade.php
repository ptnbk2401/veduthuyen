@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Người dùng <small>Sửa</small></h3>
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
          @if (Request::has('msg'))
          <div class="alert alert-danger">
              <ul>
                  <li>{{ Request::get('msg') }}</li>
              </ul>
          </div>
          @endif

          <div class="x_content">
            <br>
            @php
                $id = $arItem->id;
            @endphp
            <form action="{{ route('vadmin.core.user.edit', [$id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="username" value="{{ old('username', $arItem->username)}}" class="form-control" placeholder="Nhập tên người dùng">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Họ</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="ho" value="{{ old('username', $arItem->last_name)}}" class="form-control" placeholder="Nhập tên người dùng">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="ten" value="{{ old('username', $arItem->first_name)}}" class="form-control" placeholder="Nhập tên người dùng">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nhóm người dùng</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select name="vgroup[]" size="4" multiple="multiple" class="form-control">
                    <option value="0">--Nhóm người dùng--</option>
                    @if (old('vgroup'))
                        @php
                            $arGroupOld = old('vgroup');
                        @endphp
                    @endif
                    @foreach ($objItemsGroup as $objGroup)
                        @if (in_array($objGroup->groupId, $arGroupOld))
                            <option value="{{ $objGroup->groupId }}" selected="selected">{{ $objGroup->name }}</option>
                        @else
                            <option value="{{ $objGroup->groupId }}">{{ $objGroup->name }}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="email" value="{{ old('email', $arItem->email)}}" class="form-control" placeholder="Nhập email">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="phone" value="{{ old('phone', $arItem->phone)}}" class="form-control" placeholder="Nhập số phone">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Địa chỉ</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="address" value="{{ old('address', $arItem->address)}}" class="form-control" placeholder="Nhập địa chỉ">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ảnh đại diện</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <input type="file" name="avatar" class="form-control col-md-10">
                </div>
                @if ($arItem->avatar != "")
                    @php
                        $urlPic = Storage::url('app/media/files/users/'.$arItem->avatar);
                    @endphp
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <a href="{{ $urlPic }}" target="_blank"><img src="{{ $urlPic }}" alt="" style="border-radius: 4px; width: 120px; height: 90px" /></a>
                </div>
                @endif
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-success">Thực hiện</button>
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
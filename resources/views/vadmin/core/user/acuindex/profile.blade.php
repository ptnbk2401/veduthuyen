@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Trang cá nhân <small>Profile</small></h3>
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
          @endif		  		  @if (Session::has('msg'))          <div class="alert alert-success">              <ul>                  <li>{{ Session::get('msg') }}</li>              </ul>          </div>          @endif

          <div class="x_content">
            <br>
            @php
                $id = $arItem->id;
            @endphp
            <form action="{{ route('vinaenter.vneuser.profile', [$id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="username" value="{{ old('username', $arItem->username)}}" class="form-control" placeholder="Nhập tên người dùng" disabled="disabled">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                </div>
              </div>
   
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Họ và tên</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="fullname" value="{{ old('fullname', $arItem->fullname)}}" class="form-control" placeholder="Nhập họ và tên">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="email" value="{{ old('email', $arItem->email)}}" class="form-control" placeholder="Nhập email" disabled="disabled">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Giới tính</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  @if (old('gender'))
                      @php
                          $oldGender = old('gender');
                      @endphp
                  @else
                      @php
                          $oldGender = $arItem->gender;
                      @endphp
                  @endif

                  @if ($oldGender==1)
                    Nam <input type="radio" name="gender" value="1" checked="checked" />
                    Nữ <input type="radio" name="gender" value="0" />
                  @else
                    Nam <input type="radio" name="gender" value="1" />
                    Nữ <input type="radio" name="gender" value="0" checked="checked" />
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ngày sinh</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="date" value="{{ old('birthday', $arItem->birthday)}}" name="birthday" class="form-control" placeholder="Nhập ngày sinh dd/mm/yyyy">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nhóm người dùng</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select name="vgroup[]" size="4" multiple="multiple" class="form-control" disabled="disabled">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Thuộc công ty</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select name="companyId" size="1" class="form-control" disabled="disabled">
                    <option value="0">--Chọn công ty--</option>
                    @foreach ($objItemsCompany as $objCompany)
                        @if ((old('companyId') == $objCompany->companyid) || ($arItem->companyId == $objCompany->companyid))
                            <option value="{{ $objCompany->companyid }}" selected="selected">{{ $objCompany->name }}</option>
                        @else
                            <option value="{{ $objCompany->companyid }}">{{ $objCompany->name }}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Chức vụ</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select name="position[]" size="4" multiple="multiple" class="form-control" disabled="disabled">
                    <option value="0">--Chọn chức vụ--</option>
                    @if (old('position'))
                        @php
                            $arPositionOld = old('position');
                        @endphp
                    @endif
                    @foreach ($objItemsPosition as $objPosition)
                        @if (in_array($objPosition->pid, $arPositionOld))
                            <option value="{{ $objPosition->pid }}" selected="selected">{{ $objPosition->name }}</option>
                        @else
                            <option value="{{ $objPosition->pid }}">{{ $objPosition->name }}</option>
                        @endif
                    @endforeach
                  </select>
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

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook ID</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="uid" value="{{ old('uid', $arItem->uid)}}" id="autocomplete-custom-append" class="form-control col-md-10" autocomplete="off" placeholder="Nhập UID facebook">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook Token</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="access_token"  value="{{ old('access_token', $arItem->access_token)}}" class="form-control col-md-10" placeholder="Nhập access token facebook">
                </div>
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
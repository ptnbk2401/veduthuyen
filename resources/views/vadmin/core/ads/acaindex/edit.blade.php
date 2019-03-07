@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Advertisement <small>Edit</small></h3>
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
            <form action="{{ route('vadmin.core.ads.edit', $objItemOld->ads_id) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Advertisement name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="aname" value="{{ old('aname', $objItemOld->aname)}}" class="form-control" placeholder="Advertisement name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Code adsense</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea  class="form-control" rows="5" name="code_adsense" placeholder="Enter code adsense">{{old('code_adsense', $objItemOld->code_adsense)}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Banner</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="file" name="banner" value="Upload banner" class="form-control">
                        @if(!empty($objItemOld->banner))
                            <img width="150px" height="100px" src="{{asset('/storage/app/media/files/ads/'.$objItemOld->banner)}}" alt="">
                            <input type="checkbox" name="delPic" value="{{$objItemOld->banner}}"> Delete banner picture
                        @else
                            <input type="hidden" name="delPic" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Advertisement Position</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select name="position_id" class="form-control">
                            <option value="0" selected="selected">--Select ad position--</option>
                            @foreach($objItemsByPosition as $adsposition)
                                @php
                                    $selected = ($objItemOld->position_id == $adsposition->position_id) ? 'selected' : '';
                                @endphp
                                <option {{$selected}} value="{{$adsposition->position_id}}" >{{$adsposition->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Url</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="url" value="{{ old('url', $objItemOld->url)}}" class="form-control" placeholder="url">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date begin at</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="date" name="begin_at"  value="{{ old('begin_at', date("Y-m-d", strtotime( $objItemOld->begin_at)))}}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date end at</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="date" name="end_at"  value="{{ old('end_at', date("Y-m-d", strtotime( $objItemOld->end_at)))}}" class="form-control">
                    </div>
                </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-success">Save</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
</div>
@endsection

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('#lfm').filemanager('image');

    CKEDITOR.replace( 'ckeditor', {
          height: 350,   
          entities: false,
          basicEntities: false,
          // Pressing Enter will create a new &lt;div&gt; element.
          enterMode: CKEDITOR.ENTER_BR,
          // Pressing Shift+Enter will create a new &lt;p&gt; element.
          shiftEnterMode: CKEDITOR.ENTER_P,

          filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
          filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
          filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
          filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    });

    function convertToSlug( str ) {
        //Đổi chữ hoa thành chữ thường
        slug = str.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('slug-text').value = slug;
    }
</script>
@stop

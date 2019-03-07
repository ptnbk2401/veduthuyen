@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Contact <small>View</small></h3>
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
            <form action="javascript:void(0)" method="post"  class="form-horizontal form-label-left">
              {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Họ tên</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="fullname"  value="{{$objItem->fullname}}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Số điện thoại</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="phone"  value="{{$objItem->phone}}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="email"  value="{{$objItem->email}}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Họ tên</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="subject"  value="{{$objItem->subject}}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nội dung</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea disabled name="detail_text" id="ckeditor">{{$objItem->content}}</textarea>
                    </div>
                </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
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

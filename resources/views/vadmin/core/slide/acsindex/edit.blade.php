@extends('templates.admin.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  .select2 {
    width: 100%;
  }
</style>
@stop
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Slide Trang chủ <small>Sửa</small></h3>
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
            <form action="{{ route('vadmin.core.slide.edit', $objItemOld->slide_id) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Hình ảnh cũ<span class="required">*</span></label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <img src="/storage/app/media/files/slide/{{ $objItemOld->picture }}" width="100px" alt="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Hình ảnh<span class="required">*</span></label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="file" name="picture" class="form-control">
                    <a id="picture" href="" target="_blank"><img  width="100px" src="" ></a>
                    <input type="hidden" name="picture_old" id="picture_old" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">ID bài viết<span class="required">*</span></label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <select name="article_id" class="select2" id="article_id" >
                        <option ></option>
                        <option value="{{ $objItemOld->article_id }}" selected>{{ $objItemOld->aname }}</option>
                      </select> 
                  </div>
                </div>
                <div class="form-group">
                  @php
                    $link = route('vpublic.core.pcbloglist.detail',[$objItemOld->article_id,str_slug($objItemOld->aname)]);
                  @endphp
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Link bài viết:</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <a id="link" target="_blank" href="{{ $link  }}">{{ $link  }}</a>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-6">Sắp xếp<span class="required">*</span></label>
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <input type="number" name="sort" value="{{ old('sort', $objItemOld->sort)}}" class="form-control" placeholder="" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-6">Vị trí<span class="required">*</span></label>
                  <div class="col-md-3 col-sm-3 col-xs-6">
                      <select name="vitri"  class="form-control">
                        @if ($objItemOld->vitri == 'slide')
                          <option value="slide" selected>Slide</option>
                          {{-- <option value="left">Left</option> --}}
                        @else
                          <option value="slide" >Slide</option>
                          {{-- <option value="left" selected>Left</option> --}}
                        @endif
                      </select>
                  </div>
                </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-success">Lưu</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary">Trở lại</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2({
      placeholder: 'Nhập tên bài viết',
      allowClear: true,
      ajax: {
        url: "{{ route('vadmin.core.slide.searchArticle') }}",
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: function (params) {
          var query = {
            search: params.term,
          }
          return query;
        },
        processResults: function (data) {
          return {
              results: $.map(data.items,function(val,i){
                  return { id:val.article_id, text: val.aname };
              })
          }
        },
      }
    });


  $('.select2').change(function(){
      var article_id = $('#article_id').val() ;
      $.ajax({
          url: "{{ route('vadmin.core.slide.getData') }}",
          type: 'GET',
          cache: false,
          data: {article_id:article_id},
          success: function(data){
              $('#link').html(data['link']);
              $('#link').attr('href',data['link']);
              $('#picture img').attr('src','/storage/app/media/files/article/'+data['picture']);
              $('#picture').attr('href','/storage/app/media/files/article/'+data['picture']);
              $('#picture_old').val(data['picture']);
          },
          error: function (){
              alert('Có lỗi xảy ra');
          }
      });
        
  });

</script>

@stop

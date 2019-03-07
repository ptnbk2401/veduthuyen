@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Lấy tin Online <small>Add</small></h3>
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
            $arWebsite = [
              'vnexpress'=>['img'=>'vnexpress.png','domain'=>'https://vnexpress.net/the-thao'],
              '2sao'=>['img'=>'2sao.ico','domain'=>'https://2sao.vn/nhac-c-aap/'],
              'laodong'=>['img'=>'laodong.png','domain'=>'https://laodong.vn/van-hoa'],
            ];
          @endphp
          <center>
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <img id="img_website" src="/templates/admin/images/vnexpress.png" height="50px" alt="">
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select name="webstite" id="inputWebstite" class="form-control" onchange="changeWebstite(this)">
                @foreach ($arWebsite as $name=>$webstite)
                  <option value="{{ $name }}" data-img="{{ $webstite['img'] }}" data-domain="{{ $webstite['domain'] }}" >{{ ucwords($name) }}</option>
                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </center>  
          <form action="{{ route('vadmin.core.article.getDetail') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Url</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="url" value="{{ old('url','https://vnexpress.net/the-thao')}}" class="form-control" id="domain_website">
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <span id="loading1" style="display: none; color: red" >
                  <img src="/images/loading.gif" style="width: 35px;" >Loading...
                </span>
                {{-- <button type="submit" name="submit" class="btn btn-success">Lấy Tin</button> --}}
                <a href="javascript:void(0)" class="btn btn-success" onclick="getPosts()">Lấy Tin Ajax</a>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

              </div>
            </div>
          </form>
          <div class="ln_solid"></div>
          <div style="display: none;" id="dataShow">          
            <div id="table_data"></div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Danh mục</label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select name="cat_id" class="form-control">
                    {!! $strOption !!}
                  </select>
                </div>
              </div>
              @php
                $index = 0;
              @endphp
              <div class="col-md-6 col-sm-6 col-xs-12">
              <a href="javascript:void(0)" class="btn btn-info" onclick="saveTin({{$index}})">Lưu Thành Bảng Tạm</a>
              <span >
                <img id="loading" style="display: none;width: 35px;" src="/images/loading.gif"  >
                <div class="progress"  style="width: 100%;display: none;"  >
                    <div class="progress-bar progress-bar-success" role="progressbar" style="width:0%">
                    </div>
                </div>
              </span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script src="/js/core.js"></script>
<script src="/js/ckeditor/ckeditor.js"></script>
<script>

  var ajax_sendding = false;
  function saveTin(index){
    var cat_id = $('select[name=cat_id]').val();
    var num = $('input[name=countData]').val();
    // alert(index);
    if (index > num){
      ajax_sendding = false;
      $('#loading').hide();
      alert('Hoàn Thành');
      $('.progress-bar').html('');
      location.reload();
      return false;
    }
    $('#loading').show();
    $('.progress').show();
    $.ajax({
      url: "{{ route('vadmin.core.article.saveTinAuto') }}",
      type: 'GET',
      cache: false,
      data: {cat_id:cat_id,index:index},
      success: function(data){
          // $('#success').html(++data+'/'+num);
           var width = data*100/(num-1);
           width = width.toFixed(2);
          $('.progress-bar').attr('style','width:'+width+'%');
          $('.progress-bar').html(width+'%');

      },
      error: function (){
        console.log('Có lỗi khi lưu tin thứ '+index);
      }
    }).always(function(){
        saveTin(++index);
    });
    
    return false;
  };

  function changeWebstite(element){
    var val = $(element).val();
    var img = $('option[value='+val+']').attr("data-img");
    var domain =$('option[value='+val+']').attr("data-domain");
    $('#img_website').attr('src','/templates/admin/images/'+img);
    $('#domain_website').val(domain);
  }

  var my_data=[];
  function getPosts(){
      if (ajax_sendding == true){
        alert('Vui lòng chờ trong giây lát!');
        return false;
      }
      ajax_sendding = true;
      $('#loading1').show();
      var url = $('#domain_website').val();
      var webname = $('#inputWebstite').val();
      $.ajax({
        url: "{{ route('vadmin.core.article.getPosts') }}",
        type: 'GET',
        cache: false,
        data: {url:url,webname:webname},
        success: function(data){
          $('#dataShow').show();
          $('#table_data').html(data);
          my_data = data;
        },
        error: function (){
          alert('Có lỗi');
        }
      }).always(function(){
          $('#loading1').hide();
          ajax_sendding = false;
          // alert('Hoàn Thành')
      });
      return false;
  };


</script>
@stop

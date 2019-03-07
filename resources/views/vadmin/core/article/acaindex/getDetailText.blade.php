@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Các Tin chưa có nội dung <small>Detail text</small></h3>
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
      </div>
      <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>



        @if (Session::has('msg'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong>{{ Session::get('msg') }}</strong>
        </div>
        @endif
      

        <form action="{{ route('vadmin.core.article.delall') }}" method="post" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 10;
            @endphp
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" name="del" class="btn btn-success" onclick="return confirm('Are you sure?')">Xóa</button>
                <button type="button" name="del" class="btn btn-info" onclick="getDetailText(0)">Lấy chi tiết</button>
                <span >
                  <img id="loading" style="display: none;width: 35px;" src="/images/loading.gif"  >
                  <div class="progress"  style="width: 100%;display: none; margin-top: 10px"  >
                      <div class="progress-bar progress-bar-danger" role="progressbar" style="width:0%">
                      </div>
                  </div>
                </span>
              </div>
            </div>
            <table class="table table-striped jambo_table bulk_action" id="tabledata" style="font-size: 12px">
              <thead>
                <tr class="headings  text-center">
                  <th>
                    <input type="checkbox" id="check-all-vne" class="flat">
                  </th>
                  <th class="column-title text-center">STT</th>
                  <th class="column-title text-center" style="width: 150px">Tiêu đề</th>
                  <th class="column-title text-center">Danh mục</th>
                  <th class="column-title text-center">Hình ảnh</th>
                  <th class="column-title text-center">Hoạt động</th>
                  <th class="column-title text-center">Trạng thái</th>
                  <th class="column-title text-center">Có Video</th>
                  <th class="column-title text-center">Ngày đăng</th>
                  <th class="column-title text-center" style="width: 100px"><span class="nobr">Action</span></th>
                  <th class="bulk-actions" colspan="{{ $colspan }}">
                    <a class="antoo" style="color:#fff; font-weight:500;">Choose ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody>
              @if (!$objItems->first())
                <tr class="even pointer">
                  <td class="text-center " colspan="{{ $colspan }}">
                     <p>No data</p>
                  </td>
                </tr>
              @else
                @foreach ($objItems as $key => $objItem)
                    @php
                        $article_id = $objItem->article_id;
                        $aname = $objItem->aname;
                        $code = $objItem->code;
                        $status = $objItem->status;
                        $cat_id = $objItem->cat_id;
                        $picture = $objItem->picture;
                        $preview_text = $objItem->preview_text;
                        $detail_text = $objItem->detail_text;
                        $active = $objItem->active;
                        $has_video = $objItem->has_video;
                        $created_at = $objItem->created_at;
                        $cname = $objItem->cname;
                        $page = isset($_REQUEST['page'])? $_REQUEST['page'] : 1 ;
                        $urlEdit = route('vadmin.core.article.edit', [$article_id,$page]);
                        $urlDel  = route('vadmin.core.article.del', $article_id);
                        $trrow = "odd";
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="text-center ">
                    <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $article_id }}">
                  </td>
                  <td class="text-center">{{ $key+1 }}</td>
                  <td class=" ">
                      <a href="" title="" rel="nofollow">{{ $aname }}</a>
                  </td>
                    <td class=" ">
                        {{ $cname }}
                    </td>
                  <td class="text-center">
                      @if(!empty($picture))
                        <a href="{{asset('/storage/app/media/files/article/'.$picture)}}" target="_blank"><img height="60px" width="90px" src="{{asset('/storage/app/media/files/article/'.$picture)}}" alt=""/></a>
                      @endif
                  </td>
                    <td class="active-article-{{ $article_id }} text-center" >
                        @if ($active == 0)
                            <a href="#" onclick="return active('{{ $article_id }}')" style="font-size: 15px;"> <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i></a>
                        @else
                            <a href="#" onclick="return active('{{ $article_id }}')" style="font-size: 15px;"> <i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i></a>
                        @endif
                    </td>
                    <td class="text-center" >
                        @if ($status == 0)
                           <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i>
                        @else
                            <i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i>
                        @endif
                    </td>
                    <td class="text-center" >
                        @if ($has_video == 0)
                            {{-- <a href="javascript:void(0)" style="font-size: 15px;"> <i class="fa fa-file-video-o" style="color: #f1635f;"></i></a> --}}
                        @else
                            <a href="javascript:void(0)" style="font-size: 15px;"> <i class="fa fa-file-video-o" style="color: #3795f4;"></i></a>
                        @endif
                    </td>
                  <td class="text-center ">
                      {{ date('d/m/Y',strtotime($created_at))}}
                  </td>
                    <td class="text-center">       
                    <a href="{{$urlEdit}}"><i class="fa fa-edit"></i> Sửa | </a>
                     <a onclick="return confirm('Bạn có chắc muốn xóa?')" href="{{$urlDel}}"><i class="fa fa-trash"></i> Xóa </a>
                  </td>
                </tr>
                @endforeach
              @endif
              </tbody>
            </table>

            
          </div>
          <div class="row">
                <div class="col-sm-12">
                    <div class="dataTables_paginate paging_simple_numbers" id="datatable-responsive_paginate">
                        {{ $objItems->links() }}
                    </div>
                </div>
            </div>
        </div>
        </form>

      </div>
    </div>
  </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  function getDetailText(index){
    var arArticle_id = getArCat();
    var num = arArticle_id.length;
    if (index >= num){
      $('#loading').hide();
      // alert('Hoàn Thành');
      $('.progress-bar').html('Hoàn Thành');
      $('.progress-bar').removeClass('progress-bar-danger');
      $('.progress-bar').addClass('progress-bar-success');
      location.reload();
      return false;
    }
    $('#loading').show();
    $('.progress').show();
    $.ajax({
        url: "{{ route('vadmin.core.article.detailtext') }}",
        type: 'GET',
        cache: false,
        data: {article_id:arArticle_id[index],index:index},
        success: function(data){
            i = parseInt(data) +1;
            var width = i*100/(num);
            width = width.toFixed(2);
            $('.progress-bar').attr('style','width:'+width+'%');
            $('.progress-bar').html(i+'/'+num);
        },
        error: function (){
          console.log('Có lỗi khi lưu tin thứ '+index);
        }
    }).always(function(){
        getDetailText(++index);
    });
  };
  function getArCat(){
    var article_id = [];
    $('input.vnedel:checked').each(function(i){
        article_id[i] = $(this).val();
    });
    return article_id;
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

 function active(id){
  $.ajax({
      url: "{{ route('vadmin.core.article.activestatus') }}",
      type: 'GET',
      cache: false,
      data: {aid:id},
      success: function(data){
          $('.active-article-'+id+' a').html(data);
      },
      error: function (){
          alert('Có lỗi xảy ra');
      }
  });
  return false;
};
</script>
@stop

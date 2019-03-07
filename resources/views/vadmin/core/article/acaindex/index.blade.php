@extends('templates.admin.master')
@section('css')
<link rel="stylesheet" href="/templates/admin/css/bootstrap-tagsinput.css">
<style>
  
</style>
@stop
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Article <small>List</small></h3>
    </div>
    <div class="title_right">
        @include('templates.admin.topsearch')
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2><a href="{{ route('vadmin.core.article.add') }}"><i class="fa fa-plus-square"></i> Thêm</a> {{-- | <a href="{{ route('vadmin.core.article.getDetail') }}"><i class="fa fa-plus-square"></i> Lấy Tin</a> --}}</h2>
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
      <div class="x_content">
          <br>
          <form action="{{ route('vadmin.core.article.search') }}" method="get" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên tin</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" name="name" value="" class="form-control" placeholder="Nhập tên tin">
              </div>
            </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Danh mục</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <select name="cat_id" class="form-control">
                          <option value="">--Chọn danh mục--</option>
                          {!! $strOption !!}
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng thái</label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <select name="active" class="form-control">
                          <option value="">--Chọn trạng thái--</option>
                          <option value="-1">Không kích hoạt</option>
                          <option value="1">Kích hoạt</option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="submit" name="search"  value="Search" />
                  </div>
              </div>
          </form>
        </div>

        <form action="{{ route('vadmin.core.article.delall') }}" method="post" class="form-horizontal form-label-left" id="formtacvu" name="formtacvu">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 9;
            @endphp
            <div class="form-group">
              <div class="col-md-2 col-sm-2 col-xs-12">
                <select name="tacvu" class="form-control" onchange="setaction(this.value)">
                  <option value="1">Xóa bài viết</option>
                  <option value="2">Active</option>
                  <option value="3">Hủy Active</option>
                  <option value="4">Thay đổi danh mục</option>
                </select>
              </div>
              <div id="newcat" class="col-md-2 col-sm-2 col-xs-12" style="display: none;">
                <select name="cat_id" class="form-control">
                  {!! $strOption !!}
                </select>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input type="button" value="Submit" class="btn btn-success" onclick="submitform()"> 
              </div>
            </div>
            <table class="table table-striped jambo_table bulk_action" id="tabledata" style="font-size: 12px">
              <thead>
                <tr class="headings">
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
                  <th class="column-title text-center">Từ Khóa</th>
                  <th class="column-title text-center" style="width: 80px"><span class="nobr">Action</span></th>
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
                        $tags = $objItem->tags;
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
                  <td class="text-center ">
                    <span id="content-tags{{ $article_id }}">
                      @php
                        $arTags = explode(',', $tags);
                      @endphp
                      @foreach ($arTags as $tag)
                         <span class="label label-success" title="{{ $tag }}">{{ str_limit($tag,10) }}</span>
                      @endforeach
                    </span>
                    <br><a data-toggle="modal" href='#tabs{{ $article_id }}'><i class="fa fa-tags"></i> add </a>
                    <div class="modal fade" id="tabs{{ $article_id }}">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Bài viết: {{ $aname }}</h4>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <legend>Thêm thẻ Tags</legend>
                            </div>
                            <div class="form-group">
                              <input type="text" name="tags" id="inputTags{{ $article_id }}" class="form-control"  data-role="tagsinput" value="{{ $tags }}">
                            </div>
                            <div class="form-group">
                              <a href="javascript:void(0)" onclick="removeAll({{ $article_id }})">Xóa tags</a>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="addTags({{ $article_id }})">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
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
@endsection

@section("js")
    <script src="/templates/admin/js/bootstrap-tagsinput.js"></script>
    <script>
    $(document).ready(function() {
      $('#tabledata').DataTable({
      "order": [
      ],
      select: true,
      paging: false,
      ordering:  false
      });

    }); 

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

    function submitform(){
      
      var tacvu = $('select[name=tacvu]').val();
      if ( confirm('Are you sure?') ) {
        $('#formtacvu').submit();
      }
    }
    function setaction(tacvu){
      $('#newcat').hide();
      if(tacvu==1) {
        $('#formtacvu').attr('action','{{ route('vadmin.core.article.delall') }}');
      } else if(tacvu == 2){
        $('#formtacvu').attr('action','{{ route('vadmin.core.article.activeall') }}');
      } else if(tacvu == 3){
        $('#formtacvu').attr('action','{{ route('vadmin.core.article.disall') }}');
      }else if(tacvu == 4){
        $('#newcat').show();
        $('#formtacvu').attr('action','{{ route('vadmin.core.article.changeCat') }}');
      }
      
    }
    function addTags(article_id) {
      var tags = $('#inputTags'+article_id).val();
      $.ajax({
        url: "{{ route('vadmin.core.article.AddTags') }}",
        type: 'GET',
        cache: false,
        data: {article_id:article_id,tags:tags},
        success: function(data){
          $('#content-tags'+article_id).html(data);
          alert('Thêm từ khóa thành công!');
          $('#tabs'+article_id).modal('hide');
        },
        error: function (){
            alert('Có lỗi xảy ra');
        }
      });
      return false;
      // alert(tags);
    }
    function removeAll(article_id) {
      $('#inputTags'+article_id).tagsinput('removeAll');
    }
    </script>
@stop
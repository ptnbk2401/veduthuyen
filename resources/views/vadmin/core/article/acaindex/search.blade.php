@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Article <small>List search</small></h3>
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
                      <input type="text" name="name" value="{{$arItem['name']}}" class="form-control" placeholder="Nhập tên tin">
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
                          <option value="-1" @if($arItem['active'] == -1) selected @endif>Không kích hoạt</option>
                          <option value="1" @if($arItem['active'] == 1) selected @endif>Kích hoạt</option>
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

        <form action="{{ route('vadmin.core.article.delall') }}" method="post" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 9;
            @endphp
            <table class="table table-striped jambo_table bulk_action" id="tabledata" style="font-size: 12px">
              <thead>
                <tr class="headings">
                  <th>
                    <input type="checkbox" id="check-all-vne" class="flat">
                  </th>
                  <th class="column-title text-center">STT</th>
                  <th class="column-title text-center" style="width: 150px">Tiêu đề</th>
                  <th class="column-title text-center">Danh mục</th>
                  <th class="column-title text-center" >Hình ảnh</th>
                  <th class="column-title text-center">Hoạt động</th>
                  <th class="column-title text-center">Trạng thái</th>
                  <th class="column-title text-center">Có Video</th>
                  <th class="column-title text-center">Ngày đăng</th>
                  <th class="column-title text-center" style="width: 80px"><span class="nobr">Action</span></th>
                  <th class="bulk-actions" colspan="{{ $colspan }}">
                    <a class="antoo" style="color:#fff; font-weight:500;">Choose ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody>
              @if (!$objItems->first())
                <tr class="even pointer">
                  <td class="text-center" colspan="{{ $colspan }}">
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
                        $has_video = $objItem->has_video;
                        $detail_text = $objItem->detail_text;
                        $active = $objItem->active;
                        $created_at = $objItem->created_at;
                        $cname = $objItem->cname;
                        $urlEdit = route('vadmin.core.article.edit', [$article_id,1]);
                        $urlDel  = route('vadmin.core.article.del', $article_id);
                        $trrow = "odd"
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="text-center">
                    <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $article_id }}">
                  </td>
                  <td class="text-center">{{ $key+1 }}</td>
                  <td class=" ">
                      <a href="" target="_blank" title="" rel="nofollow">{{ $aname }}</a>
                  </td>
                    <td class="text-center">
                        {{ $cname }}
                    </td>
                  <td class="text-center">
                      @if(!empty($picture))
                        <img height="60px" width="90px" src="{{asset('/storage/app/media/files/article/'.$picture)}}" alt=""/>
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
                  <td class="text-center">
                       {{ date('d/m/Y',strtotime($created_at))}}
                  </td>
                    <td class="text-center">
                    <a href="{{$urlEdit}}"><i class="fa fa-edit"></i> Edit | </a>
                     <a onclick="return confirm('Are you sure?')" href="{{$urlDel}}"><i class="fa fa-trash"></i> Delete </a>
                  </td>
                </tr>
                @endforeach
              @endif
              </tbody>
            </table>

            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" name="del" class="btn btn-success" onclick="return confirm('Are you sure?')">Xóa</button>
                <a class="btn btn-info" href="{{ route('vadmin.core.article.index') }}" >Quay về</a>
              </div>
            </div>
          </div>

          <div class="row">
                <div class="col-sm-12">
                    <div class="dataTables_paginate paging_simple_numbers" id="datatable-responsive_paginate">
                        {{ $objItems->appends(request()->input())->links() }}
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
</script>
@stop
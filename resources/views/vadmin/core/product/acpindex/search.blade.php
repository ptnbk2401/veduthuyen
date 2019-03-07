@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Product <small>List search</small></h3>
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
          <form action="{{ route('vadmin.core.product.search') }}" method="get" class="form-horizontal form-label-left">
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
                          <option value="0" @if($arItem['active'] == 0) selected @endif>Không kích hoạt</option>
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

        <form action="{{ route('vadmin.core.product.delall') }}" method="post" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 8;
            @endphp
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th>
                    <input type="checkbox" id="check-all-vne" class="flat">
                  </th>
                  <th class="column-title">ID</th>
                  <th class="column-title">Article Name</th>
                  <th class="column-title">Category Name</th>
                  <th class="column-title" style="text-align: center;">Picture</th>
                  <th class="column-title">Active</th>
                  <th class="column-title">Created_at</th>
                  <th class="column-title"><span class="nobr">Action</span></th>
                  <th class="bulk-actions" colspan="{{ $colspan }}">
                    <a class="antoo" style="color:#fff; font-weight:500;">Choose ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody>
              @if (!$objItems->first())
                <tr class="even pointer">
                  <td class="a-center " colspan="{{ $colspan }}">
                     <p>No data</p>
                  </td>
                </tr>
              @else
                @foreach ($objItems as $key => $objItem)
                    @php
                        $product_id = $objItem->product_id;
                        $pname = $objItem->pname;
                        $code = $objItem->code;
                        $cat_id = $objItem->cat_id;
                        $picture = $objItem->picture;
                        $preview_text = $objItem->preview_text;
                        $detail_text = $objItem->detail_text;
                        $active = $objItem->active;
                        $created_at = $objItem->created_at;
                        $cname = $objItem->cname;
                        $urlEdit = route('vadmin.core.product.edit', $product_id);
                        $urlDel  = route('vadmin.core.product.del', $product_id);
                        $trrow = "odd"
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="a-center ">
                    <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $product_id }}">
                  </td>
                  <td class=" "><a href="" target="_blank" title="" rel="nofollow">{{ $product_id }}</a></td>
                  <td class=" ">
                      <a href="" target="_blank" title="" rel="nofollow">{{ $pname }}</a>
                  </td>
                    <td class=" ">
                        <a href="" target="_blank" title="" rel="nofollow">{{ $cname }}</a>
                    </td>
                  <td class=" " align="center">
                      @if(!empty($picture))
                        <img width="150px" height="100px" src="{{asset('/storage/app/media/files/product/'.$picture)}}" alt=""/>
                      @endif
                  </td>
                    <td class="active-product-{{ $product_id }}" >
                        @if ($active == 0)
                            <a href="#" onclick="return active('{{ $product_id }}')" style="font-size: 23px;"> <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i></a>
                        @else
                            <a href="#" onclick="return active('{{ $product_id }}')" style="font-size: 23px;"> <i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i></a>
                        @endif
                    </td>
                  <td class="a-center ">
                      {{$created_at}}
                  </td>
                    <td>
                    <a onclick="return confirm('Are you sure?')" href="{{$urlDel}}">Delete | </a>
                    <a href="{{$urlEdit}}">Edit</a>
                  </td>
                </tr>
                @endforeach
              @endif
              </tbody>
            </table>

            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" name="del" class="btn btn-success" onclick="return confirm('Are you sure?')">Xóa</button>
              </div>
            </div>
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
    <script>
        function active(id){
            $.ajax({
                url: "{{ route('vadmin.core.product.activestatus') }}",
                type: 'GET',
                cache: false,
                data: {aid:id},
                success: function(data){
                    $('.active-product-'+id+' a').html(data);
                },
                error: function (){
                    alert('Có lỗi xảy ra');
                }
            });
            return false;
        };
    </script>
@stop
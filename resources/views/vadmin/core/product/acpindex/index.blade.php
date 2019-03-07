@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Product <small>List</small></h3>
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
            <h2>
              <a href="{{ route('vadmin.core.product.add') }}"><i class="fa fa-plus-square"></i> Thêm</a> 
              {{-- <a href="{{ route('vadmin.core.product.htmldom') }}"><i class="fa fa-plus-square"></i> Lấy tự động</a> --}}
            </h2>
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
        <form action="{{ route('vadmin.core.product.delall') }}" method="post" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 7;
            @endphp
            <table id="sanpham"  class="table table-striped jambo_table bulk_action ">
              <thead>
                <tr class="headings">
                  <th>
                    <input type="checkbox" id="check-all-vne" class="flat">
                  </th>
                  <th class="column-title">Tên Tour</th>
                  <th class="column-title">Danh mục</th>
                  <th class="column-title">Giá vé</th>
                  <th class="column-title" style="text-align: center;">Picture</th>
                  <th class="column-title">Active</th>
                  <th class="column-title"><span class="nobr">Action</span></th>
                  <th class="bulk-actions" colspan="{{ $colspan }}">
                    <a class="antoo" style="color:#fff; font-weight:500;">Choose ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody>
                @foreach ($objItems as $item)
                    @php
                        $id = $item->product_id;
                        $pname = $item->pname;
                        $cname = $item->cname;
                        $giave = $item->giave;
                        $picture = $item->picture;
                        $active = $item->active;
                        $urlEdit = route('vadmin.core.product.edit', [$id]);
                        $urlDel  = route('vadmin.core.product.del', $id);
                    @endphp
                  <tr class="even pointer">
                    <td class="a-center ">
                      <input type="checkbox" class="flat vnedel" name="vnedel[]"  value="{{$id}}">
                    </td>
                    <td class="a-center ">
                       <p>{{$pname}}</p>
                    </td>
                    <td class="a-center ">
                       <p>{{ $cname }}</p>
                    </td>
                    <td class="a-center ">
                       <p>{{ $giave }}</p>
                    </td>
                    <td class="a-center ">
                       <p><img width="50px" src="/storage/app/media/files/product/{{ $picture }}" alt=""></p>
                    </td>
                   <td class="active-article-{{ $id }} text-center" >
                        @if ($active == 0)
                            <a href="#" onclick="return active('{{ $id }}')" style="font-size: 23px;"> <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i></a>
                        @else
                            <a href="#" onclick="return active('{{ $id }}')" style="font-size: 23px;"> <i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i></a>
                        @endif
                    </td>
                    <td>       
                    <a href="{{$urlEdit}}"><i class="fa fa-edit"></i> Edit | </a>
                     <a onclick="return confirm('Are you sure?')" href="{{$urlDel}}"><i class="fa fa-trash"></i> Delete </a>
                  </td>
                  </tr>
                @endforeach
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
        $(document).ready(function() {
          $('#sanpham').DataTable({
            "language": {
            "lengthMenu": "Hiển thị _MENU_ một trang",
            "zeroRecords": "Không có dữ liệu !",
            "search": '<button type="button" style="margin: 0px" class="btn btn-primary">Tìm kiếm</button>',
            "info": "Trang _PAGE_ / _PAGES_",
            "infoEmpty": "Không có dữ liệu !",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "first":      "Đầu",
                "last":       "Cuối",
                "next":       ">",
                "previous":   "<"
            },
        }
          });
      });
      function active(id){
            $.ajax({
                url: "{{ route('vadmin.core.product.activestatus') }}",
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
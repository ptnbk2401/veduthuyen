@extends('templates.admin.master')
@section('content')
<form action="{{ route('vadmin.core.user.delall') }}" method="post" class="form-horizontal form-label-left">
{{ csrf_field() }}
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Người dùng <small>Danh sách</small></h3>
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
          <h2><a href="{{ route('vadmin.core.user.add') }}"><i class="fa fa-plus-square"></i> Thêm</a></h2>
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
          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th>
                    <input type="checkbox" id="check-all-vne" class="flat">
                  </th>
                  <th class="column-title">Tên(username) </th>
                  <th class="column-title">Nhóm </th>
                  <th class="column-title">Email </th>
                  <th class="column-title">Phone </th>
                  <th class="column-title">Active </th>
                  <th class="column-title">ID </th>
                  <th class="column-title no-link last" width="105px"><span class="nobr">Chức năng</span></th>
                  <th class="bulk-actions" colspan="7">
                    <a class="antoo" style="color:#fff; font-weight:500;">Chọn ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody id="doithay" >
              @if (!$objItems->first())
                @php
                    $colspan = 7;
                @endphp
                <tr class="even pointer">
                  <td class="a-center " colspan="{{ $colspan }}">
                     <p>Chưa có dữ liệu</p>
                  </td>
                </tr>
              @else
                @foreach ($objItems as $key => $objItem)
                    @php
                        $id = $objItem->id;
                        $arGroup = $objmVNEGroup->getItemsAllByUid($id);
                        //dd($arGroup);
                        $username = $objItem->username;
                        $active = $objItem->active;
                        $fullname = $objItem->fullname;
                        $urlEdit = route('vadmin.core.user.edit', [$id]);
                        $urlDel  = route('vadmin.core.user.del', [$id]);

                        $trrow = "odd";
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="a-center ">
                    <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $id }}">
                  </td>
                  <td class=" ">{{ $fullname }}({{ $username }})</td>
                  <td class=" ">
                      @if (count($arGroup) > 0)
                          @foreach ($arGroup as $key => $arV)
                              {{$arV->name}} {{ ($key+1) != count($arGroup)?'|':'' }}
                          @endforeach
                      @endif
                  </td>
                  <td class=" ">{{ $objItem->email }}</td>
                  <td class=" ">{{ $objItem->phone }}</td>
                  <td class="active-user-{{ $id }}" >
                    @if ($active == 0)
                        <a href="#" onclick="return active('{{ $id }}')" style=""> <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i></a>
                    @else
                        <a href="#" onclick="return active('{{ $id }}')" style=""> <i class="glyphicon glyphicon-ok" style="color: #26b99a;"></i></a>
                    @endif
                  </td>
                  <td class=" ">{{ $id }}</td>
                  <td class=" last"><a href="{{ $urlEdit }}"><i class="fa fa-edit"></i> Sửa</a> | <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="{{ $urlDel }}"><i class="fa fa-trash"></i> Xóa</a>
                  </td>
                </tr>
                @endforeach
              @endif
              </tbody>              
            </table>

            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" name="del" class="btn btn-success" onclick="return confirm('Bạn thực sự muốn xóa các bản ghi đã chọn?')">Xóa</button>
                <a href="{{ route('vadmin.core.user.export') }}" class="btn btn-info">Xuất Excel</a>
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
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('js')
  <script type="text/javascript">
      function active(id){
          $.ajax({
              url: "{{route('vadmin.core.user.activeuser')}}",
              type: 'get',
              cache: false,
              data: {aid:id},
              success: function(data){
                  $('.active-user-'+id+' a').html(data);
              },
              error: function (){
                  alert('Có lỗi xảy ra');
              }
          });
          return false;
      };
  </script>
@endsection
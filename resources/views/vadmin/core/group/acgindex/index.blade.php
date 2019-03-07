@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Nhóm người dùng <small>Danh sách</small></h3>
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
          <h2><a href="{{ route('vadmin.core.group.add') }}"><i class="fa fa-plus-square"></i> Thêm</a></h2>
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
                    <input type="checkbox" id="check-all" class="flat">
                  </th>
                  <th class="column-title">Tên </th>
                  <th class="column-title">Code </th>
                  <th class="column-title">Sắp xếp </th>
                  <th class="column-title">Số người dùng </th>
                  <th class="column-title">ID </th>
                  <th class="column-title no-link last"><span class="nobr">Chức năng</span></th>
                  <th class="bulk-actions" colspan="7">
                    <a class="antoo" style="color:#fff; font-weight:500;">Chọn ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>

              <tbody>
              @if (!$objItems->first())
                @php
                    $colspan = 6;
                @endphp
                <tr class="even pointer">
                  <td class="a-center " colspan="{{ $colspan }}">
                     <p>Chưa có dữ liệu</p>
                  </td>
                </tr>
              @else
                @foreach ($objItems as $key => $objItem)
                    @php
                        $id = $objItem->groupId;
                        $name = $objItem->name;
                        $code = $objItem->code;
                        $urlEdit = route('vadmin.core.group.edit', [$id]);
                        $urlDel  = route('vadmin.core.group.del', [$id]);
                      //  $urlList = route('vinaenter.vnegroup.edit', [$id]);

                        $trrow = "odd";
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="a-center ">
                    <input type="checkbox" class="flat" name="table_records" value="{{$id}}">
                  </td>
                  <td class=" ">{{ $name }}</td>
                  <td class=" ">{{ $code }}</td>
                  <td class=" ">{{ $objItem->sort }}</td>
                  <td class="a-right a-right ">12</td>
                  <td class=" ">{{ $id }}</td>
                  <td class=" last"><a href="{{ $urlEdit }}"><i class="fa fa-edit"></i> Sửa</a> | <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="{{ $urlDel }}"><i class="fa fa-trash"></i> Xóa</a>
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
      </div>
    </div>
  </div>
</div>
@endsection
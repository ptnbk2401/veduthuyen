@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Advertisement <small>List</small></h3>
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
            <h2><a href="{{ route('vadmin.core.ads.add') }}"><i class="fa fa-plus-square"></i> Thêm</a></h2>
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
        <form action="javascript:void(0)" method="post" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          <div class="table-responsive">
            @php
                $colspan = 8;
            @endphp
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title">ID</th>
                  <th class="column-title">Tên quảng cáo</th>
                  <th class="column-title">Vị trí quảng cáo</th>
                  <th class="column-title">Ngày tạo</th>
                  <th class="column-title">Ngày bắt đầu</th>
                  <th class="column-title">Ngày kết thúc</th>
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
                        $ads_id = $objItem->ads_id;
                        $aname = $objItem->aname;
                        $code_adsense = $objItem->code_adsense;
                        $banner = $objItem->banner;
                        $url = $objItem->url;
                        $created_at = $objItem->created_at;
                        $begin_at = $objItem->begin_at;
                        $end_at = $objItem->end_at;
                        $namePosition = $objItem->name;
                        $urlEdit = route('vadmin.core.ads.edit', $ads_id);
                        $urlDel  = route('vadmin.core.ads.del', $ads_id);
                        $trrow = "odd"
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class=" "><a href="" target="_blank" title="" rel="nofollow">{{ $ads_id }}</a></td>
                  <td class=" ">
                      <a href="" target="_blank" title="" rel="nofollow">{{ $aname }}</a>
                  </td>
                  <td class=" ">
                    <a href="" target="_blank" title="" rel="nofollow">{{ $namePosition }}</a>
                  </td>
                  <td class="a-center ">
                      {{$created_at}}
                  </td>
                  <td class="a-center ">
                    {{$begin_at}}
                  </td>
                  <td class="a-center ">
                    {{$end_at}}
                  </td>
                  <td>
                   
                    <a href="{{$urlEdit}}"><i class="fa fa-edit"></i> Edit </a>|
                     <a onclick="return confirm('Are you sure?')" href="{{$urlDel}}"><i class="fa fa-trash"></i> Delete</a>
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
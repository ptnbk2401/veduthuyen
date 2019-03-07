@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Contact <small>List</small></h3>
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
          <form action="{{ route('vadmin.core.contact.search') }}" method="get" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Họ tên</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="fullname" value="" class="form-control" placeholder="Nhập tên tin">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="email" value="" class="form-control" placeholder="Nhập email">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="phone" value="" class="form-control" placeholder="Nhập số điện thoại">
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

        <form action="{{ route('vadmin.core.contact.delall') }}" method="post" class="form-horizontal form-label-left">
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
                  <th class="column-title">Fullname</th>
                  <th class="column-title">Email</th>
                    <th class="column-title">Phone</th>
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
                        $contact_id = $objItem->contact_id;
                        $fullname = $objItem->fullname;
                        $email = $objItem->email;
                        $phone = $objItem->phone;
                        $subject = $objItem->subject;
                        $urlDel  = route('vadmin.core.contact.del', $contact_id);
                        $urlView = route('vadmin.core.contact.view', $contact_id);
                        $trrow = "odd"
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="a-center ">
                    <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $contact_id }}">
                  </td>
                  <td class=" "><a href="" target="_blank" title="" rel="nofollow">{{ $contact_id }}</a></td>
                  <td class=" ">
                      <a href="" target="_blank" title="" rel="nofollow">{{ $fullname }}</a>
                  </td>
                  <td class=" ">
                    <a href="" target="_blank" title="" rel="nofollow">{{ $email }}</a>
                  </td>
                  <td class=" ">
                    <a href="" target="_blank" title="" rel="nofollow">{{ $phone }}</a>
                  </td>
                    <td>
                    <a onclick="return confirm('Are you sure?')" href="{{$urlDel}}"><i class="fa fa-trash"></i> Delete</a> |
                    <a href="{{$urlView}}"><i class="fa fa-eye"></i> View</a>
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
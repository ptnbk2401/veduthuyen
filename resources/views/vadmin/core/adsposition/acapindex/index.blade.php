@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Ads position <small>List</small></h3>
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
          {{-- @if(getenv('OFF_ADD_DEL_POS_ADS') == 'true') --}}
             <h2><a href="{{ route('vadmin.core.adsposition.add') }}"><i class="fa fa-plus-square"></i> Thêm</a></h2>
          {{-- @endif --}}
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

        <form action="" method="post" class="form-horizontal form-label-left">
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
                  <th class="column-title">Name</th>
                  <th class="column-title">Code</th>
                  <th class="column-title">Note</th>
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
                        $position_id = $objItem->position_id	;
                        $name = $objItem->name;
                        $code = $objItem->code;
                        $note = $objItem->note;
                        $urlEdit = route('vadmin.core.adsposition.edit', $position_id);
                        $urlDel = route('vadmin.core.adsposition.del', $position_id);
                        $trrow = "odd"
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class=" ">
                    <a href="javascript:void(0)"  title="" rel="nofollow">{{ $position_id }}</a>
                  </td>
                  <td class=" ">
                      <a href="javascript:void(0)"  title="" rel="nofollow">{{ $name }}</a>
                  </td>

                  <td class=" ">
                    <a href="javascript:void(0)"  title="" rel="nofollow">{{ $code }}</a>
                  </td>

                  <td class=" ">
                    <a href="javascript:void(0)"  title="" rel="nofollow">{{ $note }}</a>
                  </td>
                    <td>
                    <a href="{{$urlEdit}}"><i class="fa fa-edit"></i> Edit</a>
                    @if(getenv('OFF_ADD_DEL_POS_ADS') == 'true')|
                      <a href="{{$urlDel}}"><i class="fa fa-trash"></i>  Del</a>
                    @endif
                  </td>
                </tr>
                @endforeach
              @endif
              </tbody>
            </table>
          </div>
        </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
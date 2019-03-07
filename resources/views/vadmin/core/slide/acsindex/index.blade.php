@extends('templates.admin.master')
@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Slide trang chủ <small>Danh sách</small></h3>
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
          <h2><a href="{{ route('vadmin.core.slide.add') }}"><i class="fa fa-plus-square"></i> Thêm</a></h2>
          <div class="clearfix"></div>
        </div>

        @if (Session::has('msg'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong>{{ Session::get('msg') }}</strong>
        </div>
        @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="table-responsive">
            @php
                $colspan = 8;
            @endphp
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title text-center">STT</th>
                  <th class="column-title text-center">ID</th>
                  <th class="column-title text-center">Tour</th>
                  <th class="column-title text-center">Hình ảnh</th>
                  <th class="column-title text-center" style="width: 100px"></th>
                  <th class="column-title text-center">Trạng thái</th>
                  <th class="column-title text-center">Sắp xếp</th>
                  <th class="bulk-actions text-center" colspan="{{ $colspan }}">
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
                        $slide_id = $objItem->slide_id;
                        $product_id = $objItem->product_id;
                        $pname = $objItem->pname;
                        $sort = $objItem->sort;
                        $active = $objItem->active;
                        $picture = $objItem->picture;
                        $urlEdit = route('vadmin.core.slide.edit', $slide_id);
                        $urlDel  = route('vadmin.core.slide.del', $slide_id);
                        $trrow = "odd";
                    @endphp
                    @if ($key % 2 == 0)
                        @php
                            $trrow = "even";
                        @endphp
                    @endif
                <tr class="{{ $trrow }} pointer">
                  <td class="text-center">
                    {{ $key + 1 }}
                  </td>
                  <td class="text-center">
                    ##{{ $slide_id }}
                  </td>
                  <td class=" ">
                    <a target="_blank" href="{{ route('vpublic.core.pcbloglist.detail',[$product_id,str_slug($pname)]) }}">{{ $pname }}</a>
                  </td>
                  <td class="text-center">
                    @if (!empty($picture))
                      @php
                        $path = storage_path('app/media/files/slide/'.$picture );
                      @endphp
                      @if( file_exists( $path ) ) 
                        <img src="/storage/app/media/files/slide/{{ $picture }}" alt="img" style="width: 100px; " title="Ảnh sản phẩm" >           
                      @else
                        <img class="anh_sp" data-u="image" src="/storage/app/media/files/display/nopicture.jpg" alt="img"  style="width: 100px; ">
                      @endif
                    @else
                      <img class="anh_sp" data-u="image" src="/storage/app/media/files/display/nopicture.jpg" alt="img"  style="width: 100px; ">
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="{{$urlEdit}}" title="Chỉnh Sửa"><i class="fa fa-edit"></i></a> | 
                    <a title="Xóa" onclick="return confirm('Are you sure?')" href="{{$urlDel}}"><i class="fa fa-trash"></i></a>
                  </td>
                  
                  <td class="active-{{ $slide_id }} text-center">
                      @if ($active == 0)
                          <a href="javascript:void(0)" onclick="return active({{ $slide_id }})" style=""> <i class="glyphicon glyphicon-remove" style="color: #f1635f;"></i></a>
                      @else
                          <a href="javascript:void(0)" onclick="return active({{ $slide_id }})" style=""> <i class="glyphicon glyphicon-ok" style="color: #3795f4;"></i></a>
                      @endif
                  </td>
                  <td>
                    {{ $sort }}
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
</div>
@endsection

@section("js")
    <script>
        function active(id){
            $.ajax({
                url: "{{ route('vadmin.core.slide.activestatus') }}",
                type: 'GET',
                cache: false,
                data: {aid:id},
                success: function(data){
                    $('.active-'+id+' a').html(data);
                },
                error: function (){
                    alert('Có lỗi xảy ra');
                }
            });
            return false;
        };
    </script>
@stop
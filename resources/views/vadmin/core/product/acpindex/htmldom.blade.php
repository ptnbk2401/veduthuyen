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
        <center>
          <form class="form-inline" action="{{ route('vadmin.core.product.htmldom') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <select name="cat_id" class="form-control" >
                <option value="0" selected="selected">--Chọn danh mục--</option>
                {!! $strOption !!}
              </select>
              <select name="th_id" class="form-control" >
                <option value="0" selected="selected">--Chọn thương hiệu--</option>
                @foreach ($objTH as $th)
                  <option value="{{ $th->th_id }}" >{{ $th->name }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        
        </center>
        
        @if (isset($picture))
        <center>
          <a href="javascript:void(0)" target="_blank"><img width="150px" src="{{asset('/storage/app/media/files/thuonghieu/'.$picture)}}" alt="{{ $picture }}"/></a>
        </center>
        @endif
        @if (Session::has('msg'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <strong>{{ Session::get('msg') }}</strong>
        </div>
        @endif
        <div class="x_content">
          
          <div class="table-responsive">           
            <table id="sanpham"  class="table table-striped jambo_table">
              <thead>
                <tr class="headings">
                  <th class="column-title">Tên Sản Phẩm</th>
                  <th class="column-title">Đường dẫn</th>
                  <th class="column-title">Giá</th>
                  <th class="column-title" style="text-align: center;">Picture</th>
                </tr>
              </thead>

              <tbody>
                @if (isset($articles))
                @foreach ($articles as $item)
                    @php
                        $title = $item['title'];
                        $href = $item['href'];
                        $giacu = isset($item['giacu']) ? $item['giacu'] : '' ;
                        $giahientai = $item['giahientai'];
                        $picture = $item['img'];
                        $url = $domain.$href;
                    @endphp
                  <tr class="even pointer">
                    <td class="a-center ">
                       <p>{{$title}}</p>
                    </td>
                    <td class="a-center ">
                       <p><a href="{{ $url }}" target="_blank">{{ $url }}</a></p>
                    </td>
                    <td class="a-center ">
                       <p>{{ $giahientai }} - {{ $giacu  }}</p>
                    </td>
                    <td class="a-center ">
                       <p><img src="{{$picture}}" alt="" width="60px"></p>
                    </td>
                   
                  </tr>
                @endforeach
                @endif

              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section("js")
    <script>
        $(document).ready(function() {
          $('#sanpham').DataTable({
            
          });
      });
      
    </script>
@stop
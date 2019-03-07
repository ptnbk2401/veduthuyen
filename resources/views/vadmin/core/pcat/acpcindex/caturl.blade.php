@extends('templates.admin.master')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Link Danh mục  <small>Các thương hiệu</small></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif
          <center>
            <h1>{{$objItem->cname}}</h1>
          </center>
          <div class="x_content">
            <br>
            @if (Session::has('msg'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <strong>{{ Session::get('msg') }}</strong>
            </div>
            @endif
            <form action="{{ route('vadmin.core.pcat.caturl',$objItem->cat_id) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              @foreach ($ThuongHieuItems as $item)
                <div class="form-group">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    @if(!empty($item->picture))
                        <a href="{{ $item->domain }}" target="_blank"><img width="150px" src="{{asset('/storage/app/media/files/thuonghieu/'.$item->picture)}}" alt="{{ $item->name }}"/></a>
                    @endif
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    @php
                      $objURL = $objmAcpcIndex->findURLCat($objItem->cat_id,$item->th_id);
                      if($objURL) {
                        $url = $objURL->url;
                      } else {
                        $url = '';
                      }
                    @endphp
                    <input type="text" name="url[{{$item->th_id}}]" class="form-control" placeholder="Nhập URL" value="{{ $url }}" >
                  </div>
                </div>
              @endforeach
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Thực hiện</button>
                  <a href="{{ route('vadmin.core.pcat.index') }}" class="btn btn-primary">Quay lại</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
</div>
@endsection



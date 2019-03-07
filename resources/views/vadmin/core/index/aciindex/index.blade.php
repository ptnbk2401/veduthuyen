@extends('templates.admin.master')
@section('content')
@if (Request::get('msg'))
<div class="row tile_count">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{ Request::get('msg') }}
      </div>
  </div>
</div> 
@endif 
<!-- /top tiles --> 
  <div class="row">
           <div class="x_content">
              <div class="col-md-4 col-sm-3 col-xs-6">
               <a class="btn btn-app icon-index" href="{{route('vadmin.core.about.index')}}">
                      <i class="fa fa-building-o"></i> Giới thiệu
                    </a>
                       <a class="btn btn-app icon-index"href="{{route('vadmin.core.contact.index')}}">
                      <i class="fa fa-phone"></i> Liên hệ
                    </a>
                     <a class="btn btn-app icon-index" href="">
                      <i class="fa fa-list-alt"></i> Tin tức
                    </a>
                      <a class="btn btn-app icon-index" href="{{route('vadmin.core.comment.index')}}">
                      <i class="fa fa-comment"></i> Danh mục Tin tức
                    </a>                   
            </div>
            
            <div class="col-md-4 col-sm-3 col-xs-6">
               <a class="btn btn-app icon-index" href="{{route('vadmin.core.article.index')}}">
                      <i class="fa fa-newspaper-o"></i> Sản phẩm
                    </a>
                      <a class="btn btn-app icon-index" href="{{route('vadmin.core.article.add')}}">
                      <i class="fa fa-plus-circle"></i> Thêm Sản phẩm
                    </a>
                     <a class="btn btn-app icon-index" href="{{route('vadmin.core.cat.index')}}">
                      <i class="fa fa-book"></i> Danh mục Sản phẩm
                    </a>
                     <a class="btn btn-app icon-index" href="{{route('vadmin.core.cat.add')}}">
                      <i class="fa fa-plus"></i> Thêm danh mục
                    </a>
            </div>
              <div class="col-md-4 col-sm-3 col-xs-6">
                  <a class="btn btn-app icon-index" href="{{route('vadmin.core.ads.index')}}">
                      <i class="fa fa-image"></i>Quảng cáo
                    </a>
                    <a class="btn btn-app icon-index" href="{{route('vadmin.core.adsposition.index')}}">
                      <i class="fa fa-arrows"></i>Vị trí quảng cáo
                    </a>
               </div> 
             <div class="col-md-4 col-sm-3 col-xs-6">
                <a class="btn btn-app icon-index" href="{{route('vadmin.core.user.index')}}">
                  <i class="fa fa-user"></i>Người dùng
                </a>
                  <a class="btn btn-app icon-index" href="{{route('vadmin.core.user.add')}}">
                  <i class="fa fa-plus-square"></i>Thêm người dùng
                </a>
          
            </div>
                       
                  </div>
          </div>
        
@endsection
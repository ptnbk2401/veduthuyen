@extends('templates.core.master')
@section('css')
<!-- SPECIFIC CSS -->
<link href="/templates/core/css/blog.css" rel="stylesheet">
<style>
.hero_in.general:before {
    background: url(/storage/app/media/files/article/{{ $objItem->cpicture }}) center center no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
.post-content img {
  width: 90% !important;
}
.post-content {
  text-align: justify;
}
</style>
@stop
@section('main')
  <main>
    <section class="hero_in general">
      <div class="wrapper">
        <div class="container">
          <h1 class="fadeInUp"><span></span>{{ $objItem->cname }}</h1>
        </div>
      </div>
    </section>
    <!--/hero_in-->

    <div class="container margin_60_35">
      <div class="row">
        <div class="col-lg-9">
          <div class="bloglist singlepost">
            <p><img alt="" class="img-fluid" src="{{ $objItem->picture }}"></p>
            <h1>{{ $objItem->aname }}</h1>
            <div class="postmeta">
              <ul>
                <li><a href="#"><i class="icon_clock_alt"></i> {{ date('d-m-Y',strtotime($objItem->created_at)) }} </a></li>
                <li><a href="#"><i class="icon_pencil-edit"></i> {{ $objItem->username }}</a></li>
              </ul>
            </div>
            <!-- /post meta -->
            <div class="post-content">
              <div>
                {!!  $objItem->detail_text !!}
              </div>
            </div>
            <!-- /post -->
          </div>
          <!-- /single-post -->
          <hr>
        </div>
        <!-- /col -->
        <aside class="col-lg-3">
                
                <!-- /widget -->
                <div class="widget">
                    <div class="widget-title">
                        <h4>Bài biết gần đây</h4>
                    </div>
                    <ul class="comments-list">
                        @foreach ($objItemsNew as $item)
                        @php
                           $path = storage_path('app/media/files/article/'.$item->picture );
                           if( !empty( $item->picture ) && (file_exists( $path )) ) {
                              $picture = \App\Classes\Utils\FileUtils::resizeResultPathFile($item->picture, 'article', 100, 100);
                          }
                          else {
                              $picture = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  100, 100);
                          }
                          $href = route('vpublic.core.pcsingle.index',[$item->code]);
                        @endphp
                           <li>
                                <div class="alignleft">
                                    <a href="{{ $href }}"><img src="{{ $picture }}" alt="{{ $item->aname }}" title="{{ $item->aname }}"></a>
                                </div>
                                <small>{{ date('d.m.Y',strtotime($item->created_at)) }}</small>
                                <h3><a href="{{ $href }}" title="{{ $item->aname }}">{{ str_limit($item->aname,50) }}</a></h3>
                            </li>  
                        @endforeach
                        

                    </ul>
                </div>
                <!-- /widget -->
                <div class="widget">
                    <div class="widget-title">
                        <h4>Danh mục</h4>
                    </div>
                    <ul class="cats">
                        @foreach ($objBlogCat as $cat)
                            <li>
                                <a href="{{ route('vpublic.core.pcblog.index',str_slug($cat->cname)) }}">{{ $cat->cname }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /widget -->
                <div class="widget">
                    <div class="widget-title">
                        <h4>Tags Phổ Biến</h4>
                    </div>
                    <div class="tags">
                        @php
                          
                          $arTags = ['Du lịch Đà Nẵng','Du thuyền Đà Nẵng','Khách sạn giá rẻ nhất','Thuê xe Taxi','Thuê xe tự lái','Tour du lịch giá rẻ']
                        @endphp
                        @foreach ($arTags as $tag)
                            <a href="javascript:void(0)">{{ $tag }}</a>
                        @endforeach
                        @if (!empty($objItem->tags))
                          @php
                            $tagsPost = $objItem->tags;
                            $tmp = explode(',', $tagsPost);
                          @endphp
                          @foreach ($tmp as $tag)
                            <a href="javascript:void(0)">{{ $tag }}</a>
                          @endforeach
                        @endif
                        
                    </div>
                </div>
                <!-- /widget -->
            </aside>
            <!-- /aside -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </main>
  <!--/main-->
@stop
@section('js')        

@stop

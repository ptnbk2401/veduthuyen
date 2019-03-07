@extends('templates.core.master')
@section('css')
<!-- SPECIFIC CSS -->
<link href="/templates/core/css/blog.css" rel="stylesheet">
<style>
.hero_in.general:before {
    background: url(/storage/app/media/files/article/{{ $objCat->picture }}) center center no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
</style>
@stop
@section('main')
<main>
    <section class="hero_in general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>{{ $objCat->cname }}</h1>
            </div>
        </div>
    </section>
    <!--/hero_in-->

    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                @if (count($objArticle))
        @foreach ($objArticle as $tour)
        @php
           $path = storage_path('app/media/files/article/'.$tour->picture );
           if( !empty( $tour->picture ) && (file_exists( $path )) ) {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($tour->picture, 'article', 600, 400);
              $title = $tour->aname;
          }
          else {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  600, 400);
              $title = $tour->aname;
          }
          $href = route('vpublic.core.pcsingle.index',[$tour->code]);
        @endphp
        <article class="blog wow fadeIn">
            <div class="row no-gutters">
                <div class="col-lg-7">
                    <figure>
                        <a href="{{ $href }}"><img src="{{ $anh }}" alt="{{ $title }}">
                            <div class="preview"><span>Read more</span></div>
                        </a>
                    </figure>
                </div>
                <div class="col-lg-5">
                    <div class="post_info">
                        <small> {{ date('d-m-Y',strtotime($tour->created_at)) }}</small>
                        <h3><a href="{{ $href }}">{{ $tour->aname }}</a></h3>
                        <p>{!! str_limit($tour->preview_text,200 ) !!}</p>
                        <ul>
                            @php
                               $path = storage_path('app/media/files/users/'.$tour->avatar );
                               if( !empty( $tour->avatar ) && (file_exists( $path )) ) {
                                  $avatar = \App\Classes\Utils\FileUtils::resizeResultPathFile($tour->avatar, 'users', 40, 40);
                              }
                              else {
                                  $avatar = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  40, 40);
                              }
                            @endphp
                            <li>
                                <div class="thumb"><img src="{{ $avatar }}" alt=""></div> {{ $tour->username }}
                            </li>
                            <li><i class="icon_comment_alt"></i> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
        <!-- /article -->

        <nav aria-label="...">
            <ul class="pagination pagination-sm">
                {{ $objArticle->links() }}
            </ul>
        </nav>
            <!-- /pagination -->
        @endforeach
        @else
            <h2 class="text-center">Danh mục hiện chưa có Tour hoạt động</h2>
        @endif
                
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

<?php
    
    function coutCmtPost($article_id) {
        $objmComments = new App\Model\Vadmin\Core\Comment\AccIndex() ;
        $count = $objmComments->coutItemsByPost($article_id);
        return $count;
    }  


?>
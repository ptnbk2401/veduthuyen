@extends('templates.core.master')

@section('css')
<style>

</style>
@stop
@section('main')
  <main>
    <section class="slider">
      @widget('SliderIndex')
    </section>
    
    <div class="container-fluid margin_80_0">
      <div class="main_title_2">
        <span><em></em></span>
        <h2>Các Tour Phổ Biến</h2>
        <p>Tour được du khách đặt nhiều trong tuần.</p>
      </div>
      <div id="reccomended" class="owl-carousel owl-theme">
        @foreach ($objTourItems as $tour)
        @php
           $path = storage_path('app/media/files/product/'.$tour->picture );
           if( !empty( $tour->picture ) && (file_exists( $path )) ) {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($tour->picture, 'product', 410, 273) ;
              $title = $tour->pname;
          }
          else {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  410, 273);
              $title = $tour->pname;
          }
          $href = route('vpublic.core.pcdetail.index',[str_slug($tour->cname),$tour->code]);
        @endphp
           <div class="item">
            <div class="box_grid">
              <figure>
                <a href="{{ $href }}" class="wish_bt"></a>
                <a href="{{ $href }}"><img src="{{ $anh }}" class="img-fluid" alt="{{ $title }}" title="{{ $title }}" width="800" height="533"><div class="read_more"><span>Xem chi tiết</span></div></a>
                <small>{{ $tour->cname }}</small>
              </figure>
              <div class="wrapper">
                <h3><a href="{{ $href }}">{{ $tour->pname }}</a></h3>
                <p>{!! str_limit($tour->preview_text,100) !!}</p>
                <span class="price">Giá <strong>{{ number_format($tour->giave,0,',','.') }} VNĐ</strong></span>
              </div>
              <ul>
                <li><i class="icon_clock_alt"></i> {{ date('M d, Y',strtotime($tour->created_at)) }}</li>
                <li><div class="score"><span>Đánh Giá<em></em></span><strong>{{ $tour->danhgia }}</strong></div></li>
              </ul>
            </div>
          </div>
        @endforeach
        
        <!-- /item -->
      </div>
      <!-- /carousel -->
      <div class="container">
        @php
          $href = route('vpublic.core.pcgridcat.index',['du-thuyen']);
        @endphp
        <p class="btn_home_align"><a href="{{ $href  }}" class="btn_1 rounded">Xem tất cả</a></p>
      </div>
      <!-- /container -->
      <hr class="large">
    </div>
    <!-- /container -->
    
    <div class="container-fluid margin_30_95 pl-lg-5 pr-lg-5">
      <section class="add_bottom_45">
        <div class="main_title_3">
          <span><em></em></span>
          <h2>Khách Sạn - Nhà Nghỉ</h2>
          <p>Được du khách đặt nhiều nhất.</p>
        </div>
        <div class="row">
          @foreach ($objHotelItems as $hotel)
          @php
             $path = storage_path('app/media/files/product/'.$hotel->picture );
             if( !empty( $tour->picture ) && (file_exists( $path )) ) {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($hotel->picture, 'product', 291, 194) ;
                $title = $hotel->pname;
            }
            else {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  291, 194);
                $title = $hotel->pname;
            }

          @endphp
            <div class="col-xl-3 col-lg-6 col-md-6">
              <a href="{{ $hotel->link }}" target="_blank" class="grid_item">
                <figure>
                  <div class="score"><strong>{{ $hotel->danhgia }}</strong></div>
                  <img src="{{ $anh }}" class="img-fluid" alt="{{ $title }}" title="{{ $title }}">
                  <div class="info">
                    <div class="cat_star">
                      @for ($i = 1; $i <= $hotel->star ; $i++)
                        <i class="icon_star" style="color: #FFC107;"></i>
                      @endfor
                    </div>
                    <h3>{{ $hotel->pname }}</h3>
                  </div>
                </figure>
              </a>
            </div>
          @endforeach
          
          <!-- /grid_item -->

        </div>
        <!-- /row -->
        <a href="https://shorten.asia/vu7TMtwS"  target="_blank"><strong>Xem nhiều hơn <i class="arrow_carrot-right"></i></strong></a>
      </section>
      <!-- /section -->
      
      <section>
        <div class="main_title_3">
          <span><em></em></span>
          <h2>Tour Du Lịch Nổi Tiếng</h2>
          <p></p>
        </div>
        <div class="row">
          @foreach ($objTourItems2 as $item)
            @php
             $path = storage_path('app/media/files/product/'.$item->picture );
             if( !empty( $item->picture ) && (file_exists( $path )) ) {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($item->picture, 'product', 291, 194) ;
                $title = $item->pname;
            }
            else {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  291, 194);
                $title = $item->pname;
            }
            $href = route('vpublic.core.pcdetail.index',[str_slug($item->cname),$item->code]);
          @endphp
             <div class="col-xl-3 col-lg-6 col-md-6">
              <a href="{{ $href }}" class="grid_item">
                <figure>
                  <div class="score"><strong>{{ $item->danhgia }}</strong></div>
                  <img src="{{ $anh }}" class="img-fluid" alt="{{ $title }}">
                  <div class="info">
                    <h3>{{ $item->pname }}</h3>
                  </div>
                </figure>
              </a>
            </div>
          @endforeach
          
          <!-- /grid_item -->
        </div>
        <!-- /row -->
        <a href="{{ route('vpublic.core.pcgridcat.index',['du-thuyen']) }}"><strong>Xem tất cả <i class="arrow_carrot-right"></i></strong></a>
      </section>
      <!-- /section -->
    </div>
    <!-- /container -->

    <div class="bg_color_1">
      <div class="container margin_80_55">
        <div class="main_title_2">
          <span><em></em></span>
          <h3>Tin tức Du lịch - Giải Trí</h3>
          <p></p>
        </div>
        <div class="row">
          @foreach ($objNewsItems as $item)
          @php
             $path = storage_path('app/media/files/article/'.$item->picture );
             if( !empty( $item->picture ) && (file_exists( $path )) ) {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($item->picture, 'article', 250, 167) ;
                $title = $item->aname;
            }
            else {
                $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  250, 167);
                $title = $item->aname;
            }
            
            @endphp
            <div class="col-lg-6">
              <a class="box_news" href="#0" title="{{ $title }}">
                <figure><img src="{{ $anh }}" alt="{{ $title }}" title="{{ $title }}">
                  <figcaption><strong>{{ date('d',strtotime($item->created_at)) }}</strong>{{ date('M',strtotime($item->created_at)) }}</figcaption>
                </figure>
                <ul>
                  <li>{{ $item->cname }}</li>
                  <li>{{ date('d.m.Y',strtotime($item->created_at)) }}</li>
                </ul>
                <h4>{{ $item->aname }}</h4>
                <p>{{ str_limit($item->preview_text,100) }}</p>
              </a>
            </div>
          @endforeach
          
          <!-- /box_news -->
        </div>
        <!-- /row -->
        <p class="btn_home_align"><a href="blog.html" class="btn_1 rounded">View all news</a></p>
      </div>
      <!-- /container -->
    </div>
    <!-- /bg_color_1 -->

   {{--  <div class="call_section">
      <div class="container clearfix">
        <div class="col-lg-5 col-md-6 float-right wow" data-wow-offset="250">
          <div class="block-reveal">
            <div class="block-vertical"></div>
            <div class="box_1">
              <h3>Enjoy a GREAT travel with us</h3>
              <p>Ius cu tamquam persequeris, eu veniam apeirian platonem qui, id aliquip voluptatibus pri. Ei mea primis ornatus disputationi. Menandri erroribus cu per, duo solet congue ut. </p>
              <a href="#0" class="btn_1 rounded">Read more</a>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!--/call_section-->
  </main>
@stop
@section('js')
   
@endsection

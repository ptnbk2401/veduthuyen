@extends('templates.core.master')
@php
    $picture = $objCat->icon ;
@endphp
@section('css')
<style>
    .hero_in.tours:before {
        background: url(/storage/app/media/files/product/{{ $picture }}) center center no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .hero_in:before {
        animation: pop-in 5s .3s cubic-bezier(0,.5,0,1) forwards;
        content: "";
        opacity: 1;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -1;
    }
    .print-error-msg p {
        margin: 0;
    }
</style>
@stop
@section('main')
<main>

<section class="hero_in tours">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>{{ $objCat->cname }}</h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<div class="filters_listing sticky_horizontal">
    <div class="container">
        <ul class="clearfix">
            <li>
                <div class="switch-field">
                    {{-- <input type="radio" id="all" name="listing_filter" value="all" checked>
                    <label for="all">All</label>
                    <input type="radio" id="popular" name="listing_filter" value="popular">
                    <label for="popular">Popular</label>
                    <input type="radio" id="latest" name="listing_filter" value="latest">
                    <label for="latest">Latest</label> --}}
                </div>
            </li>
            <li>
                <div class="layout_view">
                    <a href="javascript:void(0)" title="Dạng lưới" onclick="grid_list('grid')" class="active"><i class="icon-th"></i></a>
                    <a href="javascript:void(0)" title="Dạng danh sách" onclick="grid_list('list')"><i class="icon-th-list"></i></a>
                </div>
            </li>
            {{-- <li>
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
            </li> --}}
        </ul>
    </div>
    <!-- /container -->
</div>
<!-- /filters -->

{{-- <div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div> --}}
<!-- End Map -->

<div class="container margin_60_35">

    <div class="wrapper-grid">
        <div class="row">
        @if (count($objTours))
        @foreach ($objTours as $tour)
        @php
           $path = storage_path('app/media/files/product/'.$tour->picture );
           if( !empty( $tour->picture ) && (file_exists( $path )) ) {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($tour->picture, 'product', 337, 225);
              $title = $tour->pname;
          }
          else {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  337, 225);
              $title = $tour->pname;
          }
          $href = route('vpublic.core.pcdetail.index',[str_slug($tour->cname),$tour->code]);
        @endphp
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="box_grid">
                    <figure>
                        <a href="{{ $href }}" class="wish_bt"></a>
                        <a href="{{ $href }}"><img src="{{ $anh }}" class="img-fluid" alt="{{ $title }}" title="{{ $title }}" width="800" height="533"><div class="read_more"><span>Chi tiết</span></div></a>
                        <small>{{ $tour->cname }}</small>
                    </figure>
                    <div class="wrapper">
                        <h3><a href="{{ $href }}">{{ $tour->pname }}</a></h3>
                        <p>{!! str_limit($tour->preview_text,100) !!}</p>
                        <span class="price">Giá <strong>{{ number_format($tour->giave,0,',','.') }} </strong> VNĐ /người</span>
                    </div>
                    <ul>
                        <li><i class="icon_clock_alt"></i> {{ date('d-m-Y',strtotime($tour->created_at)) }}</li>
                        <li><div class="score"><span>Đánh giá </span><strong>{{ $tour->danhgia }}</strong></div></li>
                    </ul>
                </div>
            </div>
        @endforeach
        @else
            <h2 class="text-center">Danh mục hiện chưa có Tour hoạt động</h2>
        @endif
        </div>
        <!-- /row -->
    </div>
    <!-- /wrapper-grid -->
    <div class="wrapper-list" style="display: none">
        @if (count($objTours))
        @foreach ($objTours as $tour)
        @php
           $path = storage_path('app/media/files/product/'.$tour->picture );
           if( !empty( $tour->picture ) && (file_exists( $path )) ) {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($tour->picture, 'product', 479, 320);
              $title = $tour->pname;
          }
          else {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  479, 320);
              $title = $tour->pname;
          }
          $href = route('vpublic.core.pcdetail.index',[str_slug($tour->cname),$tour->code]);
        @endphp
        <div class="box_list">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <figure>
                        <small>Historic</small>
                        <a href="{{ $href }}"><img src="{{ $anh }}" class="img-fluid" alt="{{ $title }}" width="800" height="533"><div class="read_more"><span>Chi tiết</span></div></a>
                    </figure>
                </div>
                <div class="col-lg-7">
                    <div class="wrapper">
                        <a href="{{ $href }}" class="wish_bt"></a>
                        <h3><a href="{{ $href }}">{{ $tour->pname }}</a></h3>
                        <p>{!! str_limit($tour->preview_text,200 ) !!}</p>
                        <span class="price">From <strong>{{ number_format($tour->giave,0,',','.') }} </strong> VNĐ /người</span>
                    </div>
                    <ul>
                        <li><i class="icon_clock_alt"></i> {{ date('d-m-Y',strtotime($tour->created_at)) }}</li>
                        <li><div class="score"><span>Đánh giá </span><strong>{{ $tour->danhgia }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
        @else
            <h2 class="text-center">Danh mục hiện chưa có Tour hoạt động</h2>
        @endif
        
    </div>
</div>
<!-- /container -->

</main>
@stop
@section('js')
<!-- Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB6Vck_vRXDPR8ILH8ZLOeGSEz_n4YR0mU"></script>
<script src="js/markerclusterer.js"></script>
<script src="js/map_tours.js"></script>
<script src="js/infobox.js"></script>

<script>
    function grid_list(type){
        if(type=='grid') {
            $('.wrapper-grid').show();
            $('.wrapper-list').hide();
            $('.wrapper-grid').addClass('active');
            $('.wrapper-list').removeClass('active');
        } else {
            $('.wrapper-grid').hide();
            $('.wrapper-list').show();
            $('.wrapper-list').addClass('active');
            $('.wrapper-grid').removeClass('active');
        }
        
    }
</script>
@endsection

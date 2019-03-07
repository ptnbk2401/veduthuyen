
<div id="slider" class="flexslider">
    <ul class="slides">
    	@foreach ($objItems as $item)
      @php
        $href = route('vpublic.core.pcdetail.index',[str_slug($item->cname),$item->code]);
      @endphp
    		<li>
		        <img src="/storage/app/media/files/slide/{{ $item->picture }}" alt="">
		        <div class="meta">
		          <h3>{{ $item->pname }}</h3>
		          <div class="info">
		            <p>{!! str_limit($item->preview_text,200) !!}</p>
		          </div>
		          <a href="{{ $href }}" class="btn_1">Read more</a>
		        </div>
		    </li>
    	@endforeach
    </ul>
    <div id="icon_drag_mobile"></div>
</div>
<div id="carousel_slider_wp">
    <div id="carousel_slider" class="flexslider">
      <ul class="slides">
      	@foreach ($objItems as $item)
      	@php
           $path = storage_path('app/media/files/slide/'.$item->picture );
           if( !empty( $item->picture ) && (file_exists( $path )) ) {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($item->picture, 'slide', 280, 140) ;
              $title = $item->pname;
          }
          else {
              $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  280, 140);
              $title = $item->pname;
          }


      	@endphp
    		<li>
	          <img src="{{ $anh }}" alt="{{ $title }}" title="{{ $title }}">
	          <div class="caption">
	            <h3>{{ $item->cname }} <span>Đà Nẵng</span></h3>
	            <small>{{ number_format($item->giave,0,',','.') }} VNĐ </small>
	          </div>
	        </li>
    	@endforeach
      </ul>
    </div>
</div>
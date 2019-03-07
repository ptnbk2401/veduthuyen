@if ($config['vitri'] == 'top')
	@php
		$code = 'quang-cao-header';
		$adsItem = $objmAcaIndex->getItemPl($code);
	@endphp
	@if (!empty($adsItem))
		@if (!empty($adsItem->banner))
		@php
			$path = storage_path('app/media/files/ads/'.$adsItem->banner);
			if( file_exists( $path ) ) {
	            $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($adsItem->banner, 'ads', 728, 90) ;
	            $title = $adsItem->aname ;
	        }
		@endphp
		<a href="{{ $adsItem->url }}" target="_blank" class="quangcao">
			<img src="{{ $anh }}" alt="{{ $title }}"  title ="{{ $title }}" >
		</a>
		@elseif(!empty($adsItem->code_adsense))
			{!! $adsItem->code_adsense !!} 
		@endif
	@endif
	  
@elseif ($config['vitri'] == 'bottom')
	@php
		$code = 'quang-cao-bottom';
		$adsItem = $objmAcaIndex->getItemPl($code);
	@endphp
	@if (!empty($adsItem))
		@if (!empty($adsItem->banner))
		@php
			$path = storage_path('app/media/files/ads/'.$adsItem->banner);
			if( file_exists( $path ) ) {
	            $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($adsItem->banner, 'ads', 728, 90) ;
	            $title = $adsItem->aname ;
	        }
		@endphp
		<a href="{{ $adsItem->url }}" target="_blank" class="quangcao">
			<img class="img-responsive" src="{{ $anh }}" alt="{{ $title }}"  title ="{{ $title }}"/>
		</a>
		@elseif(!empty($adsItem->code_adsense))
			{!! $adsItem->code_adsense !!} 
		@endif
	@endif

@elseif ($config['vitri'] == 'right-bar')
	@php
		$code = 'quang-cao-right-bar-top';
		$adsItem = $objmAcaIndex->getItemPl($code);
	@endphp
	@if (!empty($adsItem))
		@if (!empty($adsItem->banner))
		@php
			$path = storage_path('app/media/files/ads/'.$adsItem->banner);
			if( file_exists( $path ) ) {
	            $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($adsItem->banner, 'ads', 336 , 280) ;
	            $title = $adsItem->aname ;
	        }
		@endphp
		<a href="{{ $adsItem->url }}" target="_blank" class="quangcao">
			<img class="img-responsive" src="{{ $anh }}" alt="{{ $title }}"  title ="{{ $title }}"/>
		</a>
		@elseif(!empty($adsItem->code_adsense))
			{!! $adsItem->code_adsense !!} 
		@endif
	@endif
@endif
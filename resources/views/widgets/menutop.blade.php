<ul>
	<li><span><a href="{{ route('vpublic.core.pcindex.index') }}">Home</a></span>
	</li>
	@foreach ($objparentcat as $cat)
		@php
			$href = route('vpublic.core.pcgridcat.index',[$cat->code]);
		@endphp
		@if( !empty($cat->url) )
			<li><span><a href="{{ $cat->url }}" target="_blank">{{ $cat->cname }}</a></span>
				<ul>
				@foreach ($objcat as $subcat)
					@if ($subcat->parent_id === $cat->cat_id)
						<li><a href="{{ !empty($subcat->url)? $subcat->url : '#'}}"  target="_blank">{{ $subcat->cname }}</a></li>
					@endif
				@endforeach
				</ul>
			</li>		
		@else
			<li><span><a href="{{ $href }}">{{ $cat->cname }}</a></span>
				<ul>
				@foreach ($objcat as $subcat)
					@php
						$href = route('vpublic.core.pcgridcat.index',[$subcat->code]);
					@endphp
					@if ($subcat->parent_id === $cat->cat_id)
						<li><a  href="{{ $href }}">{{ $subcat->cname }}</a></li>
					@endif
				@endforeach
				</ul>
			</li>
		@endif
		

	@endforeach 
	<li><span><a href="javascript:void(0)">Bài viết</a></span>
		<ul>
		@foreach ($objBlogCat as $cat)
			<li>
				<a href="{{ route('vpublic.core.pcblog.index',str_slug($cat->cname)) }}">{{ $cat->cname }} </a>
			</li>
		@endforeach
		</ul>
	</li>
	<li><span><a href="{{ route('vpublic.core.pccontact.index') }}">Liên hệ</a></span>
	</li>
</ul>
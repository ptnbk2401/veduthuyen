<li><a><i class="glyphicon glyphicon-user"></i> Quản lý quảng cáo <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a><i class="glyphicon glyphicon-user"></i> Vị trí quảng cáo <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
			<li><a href="{{ route('vadmin.core.adsposition.index') }}">Danh sách</a></li>
            <li><a href="{{ route('vadmin.core.adsposition.add') }}">Thêm</a></li>
			<li style="display: none"><a href="{{ route('vadmin.core.adsposition.edit', Request::segment(5)) }}">Sửa</a></li>
        </ul>
    </li>
	<li><a><i class="glyphicon glyphicon-user"></i> Quảng cáo <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
			<li><a href="{{ route('vadmin.core.ads.index') }}">Danh sách</a></li>
			<li><a href="{{ route('vadmin.core.ads.add') }}">Thêm</a></li>
			<li style="display: none"><a href="{{ route('vadmin.core.ads.edit', Request::segment(5)) }}">Sửa</a></li>
        </ul>
    </li>
  </ul>
</li>
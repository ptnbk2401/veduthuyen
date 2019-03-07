<li><a><i class="glyphicon glyphicon-user"></i> Quản lý Slide <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
      <li><a href="{{ route('vadmin.core.slide.index') }}">Danh sách</a></li>
      <li><a href="{{ route('vadmin.core.slide.add') }}">Thêm</a></li>
      <li style="display: none"><a href="{{ route('vadmin.core.slide.edit', Request::segment(5)) }}">Sửa</a></li>
  </ul>
</li>
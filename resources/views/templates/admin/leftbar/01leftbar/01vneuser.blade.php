<li><a><i class="glyphicon glyphicon-user"></i> Quản lý người dùng <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a><i class="glyphicon glyphicon-user"></i> Người dùng <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('vadmin.core.user.index') }}">Danh sách</a></li>
          <li><a href="{{ route('vadmin.core.user.add') }}">Thêm</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.user.edit', Request::segment(5)) }}">Sửa</a></li>
        </ul>
    </li>
    <li><a><i class="glyphicon glyphicon-user"></i> Nhóm người dùng <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('vadmin.core.group.index') }}">Danh sách</a></li>
          <li><a href="{{ route('vadmin.core.group.add') }}">Thêm</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.group.edit', Request::segment(5)) }}">Sửa</a></li>
        </ul>
    </li>
  </ul>
</li>
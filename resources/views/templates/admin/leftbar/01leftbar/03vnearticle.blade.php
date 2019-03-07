<li><a><i class="glyphicon glyphicon-user"></i> Quản lý bài viết <span class="fa fa-chevron-down"></span></a>
  <ul class="nav child_menu">
    <li><a><i class="glyphicon glyphicon-user"></i> Danh mục <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('vadmin.core.cat.index') }}">Danh sách</a></li>
          <li><a href="{{ route('vadmin.core.cat.add') }}">Thêm</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.cat.edit', Request::segment(5)) }}">Sửa</a></li>
        </ul>
    </li>
    <li><a><i class="glyphicon glyphicon-user"></i> Bài viết <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('vadmin.core.article.index') }}">Danh sách</a></li>
          <li><a href="{{ route('vadmin.core.article.add') }}">Thêm</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.article.edit', [ Request::segment(5),Request::segment(6)]) }}">Sửa</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.article.getDetail') }}">Sửa</a></li>
          <li style="display: none"><a href="{{ route('vadmin.core.article.search') }}">Sửa</a></li>{{-- 
          <li >
            <a href="{{ route('vadmin.core.article.getDetailText') }}">Chi tiết tin</a>
          </li> --}}
        </ul>
    </li>
	<li><a><i class="glyphicon glyphicon-user"></i> Bình luận bài viết <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('vadmin.core.comment.index') }}">Danh sách</a></li>
        </ul>
    </li>
  </ul>
</li>
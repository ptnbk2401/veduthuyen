@php
	$list = File::directories(resource_path('views').'/templates/admin/leftbar');
	$list = array_sort($list);
	foreach ($list as $path) {		
	$path = str_replace("/", "\\", $path);
		$tmp = explode('\\', $path);
		$dir = end($tmp);		
		@endphp
		@include('templates.admin.leftbar.'.$dir.'.master')
		@php
	}
@endphp
@php
	$name = 'Core';
	$dir = '01leftbar';
@endphp
<div class="menu_section">
  <h3>{{ $name }}</h3>
  <ul class="nav side-menu">
  	@php
  		$files = File::allFiles(resource_path('views/templates/admin/leftbar/'.$dir));
		$files = array_sort($files);
	
		foreach ($files as $file) {
			$path = (string)$file;			
			$path = str_replace("/", "\\", $path);
			$tmp = explode('\\', $path);
			$fileName = end($tmp);
			$tmp2 = explode('.', $fileName);
			$name = $tmp2[0];
			if ($name=='master') { continue;}
			@endphp
			@include('templates.admin.leftbar.'.$dir.'.'.$name)
			@php
		}
  	@endphp
  </ul>
</div>

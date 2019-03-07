SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'swebs'

@section('js')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('#lfm').filemanager('image');

    CKEDITOR.replace( 'ckeditor', {
          height: 350,   
          entities: false,
          basicEntities: false,
          // Pressing Enter will create a new &lt;div&gt; element.
          enterMode: CKEDITOR.ENTER_BR,
          // Pressing Shift+Enter will create a new &lt;p&gt; element.
          shiftEnterMode: CKEDITOR.ENTER_P,

          filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
          filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
          filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
          filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    });
</script>
@stop

--------------------------------------------------------
public static function getFilePathAttribute($picName, $width, $height, $dir, $isWaterMark=false){
	$path = storage_path().'/app/uploads';
	if (($picName != '') && (file_exists($path.'/'.$picName))) {
		if (file_exists($path.'/'.$dir.'/'.$picName)) {
			return $dir.'/'.$picName;
		} else { //nếu chưa có thì tạo ra
			//tạo thư mục nếu ko tồn tại
			if (!is_null($dir)) {
				$path = storage_path().'/app/uploads/'.$dir;
				if (!file_exists($path)) {
					mkdir($path, 0777, true);
				}
			}

			$fullpath = $path.'/'.$picName;
			$img = Image::make(storage_path().'/app/uploads/'.$picName); 
			$img->resize($width, $height, function ($constraint) {
				$constraint->aspectRatio();
			});
			if ($isWaterMark) {
				$img->insert(public_path('images/watermark.png'), 'bottom-right', 10, 10); 
			}
			$img->save($fullpath);

			return $dir.'/'.$picName;
		}
	}
	
	return $picName; 
}


----------------------------
Check APP_ENV in your .env file. If it's on production then yes, laravel caching it. You should run these commands before changing configs:

php artisan cache:clear
php artisan config:clear
php artisan route:clear
And then after changes run these:

php artisan config:cache
php artisan route:cache
php artisan optimize

=>php artisan config:clear
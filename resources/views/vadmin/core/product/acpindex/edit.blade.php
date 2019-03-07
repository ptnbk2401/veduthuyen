@extends('templates.admin.master')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Tour <small>Edit</small></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('msg'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ session('msg') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div class="x_content">
                        <br>
                        <form action="{{ route('vadmin.core.product.edit',$objItemOld->product_id) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên Tour </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="pname" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" value="{{ old('pname', $objItemOld->pname)}}" class="form-control" placeholder="Article name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="code"  id="slug-text" value="{{ old('code', $objItemOld->code)}}" readonly class="form-control" placeholder="Code">
                                </div>
                            </div>
							
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-6">Danh mục</label>
								<div class="col-md-5 col-sm-5 col-xs-6">
									<select name="cat_id" class="form-control" onchange="chonDanhMuc(this.value)">
										<option value="0" selected="selected" >--Chọn danh mục--</option>
										{!! $strOption !!}
									</select>
								</div>
								
								<label class="control-label col-md-3 col-sm-3 col-xs-6">Sort</label>
								<div class="col-md-1 col-sm-1 col-xs-6">
									<input type="number" name="sort" value="{{ old('sort', $objItemOld->sort)}}" class="form-control" placeholder="Enter sort">
								</div>
							</div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Hình ảnh</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="file" name="picture" value="Upload file" class="form-control">
                                    @if(!empty($objItemOld->picture))
                                        <a href="{{asset('/storage/app/media/files/product/'.$objItemOld->picture)}}" target="_blank"><img height="100px" src="{{asset('/storage/app/media/files/product/'.$objItemOld->picture)}}" alt=""></a>
                                        
                                    @else
                                        <input type="hidden" name="delPic" value="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Hình ảnh Khác <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="file" name="slide[]"  class="form-control col-md-7 col-xs-12" placeholder="" multiple >
                                  @if(!empty($objSlideOld))
                                    @foreach ($objSlideOld as $item)
                                         <a href="{{asset('/storage/app/media/files/product/'.$item->picture)}}" target="_blank"><img height="100px" src="{{asset('/storage/app/media/files/product/'.$item->picture)}}" alt=""></a>
                                    @endforeach
                                    @else
                                        <input type="hidden" name="delPic" value="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Giá vé</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="giave" id="giave" value="{{ old('giave',$objItemOld->giave) }}" class="form-control number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Giá Khuyến Mãi</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="giakhuyenmai" id="giakhuyenmai" value="{{ old('giakhuyenmai',$objItemOld->giakhuyenmai) }}" class="form-control number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Địa Chỉ</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="diachi" id="diachi" value="{{ old('diachi',$objItemOld->diachi) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Đánh giá</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="danhgia" id="danhgia" value="{{ old('danhgia',$objItemOld->danhgia) }}" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group hotel">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Số Sao(Hotel)</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="number" name="star" id="star" value="{{ old('star',$objItemOld->star) }}" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group hotel">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Link Affiliate(Hotel)</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="link" id="link" value="{{ old('link',$objItemOld->link) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Giới thiệu</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea  class="form-control ckeditor" rows="5" name="preview_text" placeholder="Giới thiệu về Tour">{{old('preview_text', $objItemOld->preview_text)}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Lịch trình</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea  class="form-control ckeditor" rows="5"  name="lichtrinh" placeholder="Lịch trình của Tour">{{old('lichtrinh', $objItemOld->lichtrinh)}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Chi tiết</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="detail_text" class="ckeditor" placeholder="Chi tiết về Tour">{{ old('detail_text', $objItemOld->detail_text)}}</textarea>
                                </div>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
	<script src="/js/core.js"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>

    <script>
        $(function(){
          $('.hotel').hide();
          $('input.number').maskNumber({
            integer: true,
            thousands: '.'
          });
          value = $('select[name=cat_id]').val();
          chonDanhMuc(value)
        });
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
        function chonDanhMuc(value){
          var idHotel = 49;
          if(value == idHotel) {
            $('.hotel').show();
          }
        }
    </script>
@stop

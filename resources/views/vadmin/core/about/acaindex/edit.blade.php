@extends('templates.admin.master')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>About <small>Edit</small></h3>
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
                    @if (Request::has('msg'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ Request::get('msg') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div class="x_content">
                        <br>
                        <form action="{{ route('vadmin.core.about.edit',$objItemOld->about_id) }}" method="post"  class="form-horizontal form-label-left">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tên</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="name"  value="{{ old('name', $objItemOld->name)}}" class="form-control" placeholder="About name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nội dung</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="content" id="ckeditor" placeholder="Enter detail text">{{old('content', $objItemOld->content)}}</textarea>
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

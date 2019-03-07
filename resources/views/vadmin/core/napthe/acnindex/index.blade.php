@extends('templates.admin.master')
@section('content')
@if (Request::get('msg'))
<div class="row tile_count">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      {{ Request::get('msg') }}
    </div>
  </div>
</div> 
@endif 
<!-- /top tiles --> 
<div class="row">
 <div class="x_content">
    <div class="col-md-8" style="float:none;margin:0 auto;">
        <form method="POST" action="{{ route('vadmin.core.napthe.index') }}>
              {{ csrf_field() }}
          <div class="form-group">
            <label>Loại thẻ:</label>
            <select class="form-control" name="card_type">
              <option value="">Chọn loại thẻ</option>
              <option value="VTT">Viettel</option>
              <option value="VMS">Mobifone</option>
              <option value="VNP">Vinaphone</option>
            </select>
          </div>
          <div class="form-group">
            <label>Mệnh giá:</label>
            <select class="form-control" name="card_amount">
              <option value="">Chọn mệnh giá</option>
              <option value="50000">50.000</option>
              <option value="100000">100.000</option>
              <option value="200000">200.000</option>
              <option value="300000">300.000</option>
              <option value="500000">500.000</option>
              <option value="1000000">1.000.000</option>
            </select>
          </div>
          <div class="form-group">
            <label>Số seri:</label>
            <input type="text" class="form-control" name="serial" />
          </div>
          <div class="form-group">
            <label>Mã thẻ:</label>
            <input type="text" class="form-control" name="pin" />
          </div>
          <div class="form-group">
            <?php echo (isset($err)) ? '<div class="alert alert-danger" role="alert">'.$err.'</div>' : ''; ?>
            <?php echo (isset($success)) ? '<div class="alert alert-success" role="alert">'.$success.'</div>' : ''; ?>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success btn-block" name="submit">NẠP NGAY</button>
          </div>
        </form>
      </div>
 </div>
</div>

@endsection
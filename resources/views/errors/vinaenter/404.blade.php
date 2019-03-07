@extends('templates.core.master')

@section('pagename','404 Page Not Found ')
@section('title','404 Page Not Found')
@section('description',' GlobalNews - Trang thông tin giải trí hấp dẫn nhất Việt Nam')
@section('main')
<div class="row">
  <div class="col-md-8 col-sm-8 col-md-offset-4 col-sm-offset-4 wrong-page wow fadeInDown animated">
    <div class="text-center">
      <h1>We are sorry</h1>
      <p>Unfortunately, the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exists</p>
    </div>
    <div class="text-center"><span class="ion-sad wrong-icon "></span></div>
    <div class="text-center"><a class="btn btn-danger"  href="/">Go to home page</a></div>
  </div>
</div>
@stop


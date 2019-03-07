@extends('templates.auth.master')
@section('content')
<div class="login_wrapper">
  <div class="animate form login_form">
    <section class="login_content">
      @if (Session::has('msg'))
          <p style="color:red;">{{Session::get('msg')}}</p>
      @endif
      <form action="{{ route('auth.auth.login') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <h1>Đăng nhập hệ thống</h1>
        <div>
          <input type="text" class="form-control" name="username" placeholder="Username" required="" />
        </div>
        <div>
          <input type="password" name="password" class="form-control" placeholder="Password" required="" />
        </div>
        <div>
          <button class="btn btn-default submit">Đăng nhập</button>
          <a class="reset_pass" href="#">Lost your password?</a>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-4">
              <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="separator">
          <div>
            <h1><i class="fa fa-newspaper-o"></i> VinaEnter</h1>
            <p>©2013-2018 All Rights Reserved. VinaEnter Team</p>
          </div>
        </div>
      </form>
    </section>
  </div>
</div>
@endsection
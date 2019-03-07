@extends('templates.core.master')
@section('main')
  <main>
    <section class="hero_in contacts">
      <div class="wrapper">
        <div class="container">
          <h1 class="fadeInUp"><span></span>Trang Liên Hệ</h1>
        </div>
      </div>
    </section>
    <!--/hero_in-->

    <div class="contact_info">
      <div class="container">
        <ul class="clearfix">
          <li>
            <i class="pe-7s-map-marker"></i>
            <h4>Address</h4>
            <span>Ngô Sỹ Liên, Hoà Minh, Liên Chiểu<br>Đà Nẵng - Việt Nam.</span>
          </li>
          <li>
            <i class="pe-7s-mail-open-file"></i>
            <h4>Email address</h4>
            <span>tourduthuyendanang@outlook.com <br><small>Monday to Friday 9am - 7pm</small></span>
          </li>
          <li>
            <i class="pe-7s-phone"></i>
            <h4>Contacts info</h4>
            <span>+84 373099406<br><small>Monday to Friday 9am - 7pm</small></span>
          </li>
        </ul>
      </div>
    </div>
    <!--/contact_info-->

    <div class="bg_color_1">
      <div class="container margin_80_55">
        <div class="row justify-content-between">
          <div class="col-lg-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d958.4550747284078!2d108.15582382915635!3d16.07481228797396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDA0JzI5LjMiTiAxMDjCsDA5JzIyLjkiRQ!5e0!3m2!1svi!2s!4v1551524515307" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            <!-- /map -->
          </div>
          <div class="col-lg-6">
            <h4>Gửi liên hệ</h4>
            <p>Điền đầy đủ thông tin</p>
            <div id="message-contact">
              @if (Session::has('msg')) 
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>{{ session('msg') }}</strong>
              </div>
              @endif
              @if ($errors->any())
              <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                  <ul style="margin-bottom: 0px;">
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif
            </div>
            <form method="post" action="{{ route('vpublic.core.pccontact.index') }}">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Họ tên</label>
                    <input class="form-control" type="text" id="name_contact" name="fullname" value="{{ old('fullname') }}" >
                  </div>
                </div>
              </div>
              <!-- /row -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" id="email_contact" name="email" value="{{ old('email') }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Điện thoại</label>
                    <input class="form-control" type="text" id="phone_contact" name="phone" value="{{ old('phone') }}" >
                  </div>
                </div>
              </div>
              <!-- /row -->
              <div class="form-group">
                <label>Nội dung</label>
                <textarea class="form-control" id="message_contact" name="content" style="height:200px;" >{{ old('content') }}</textarea>
              </div>

              <div class="captcha clear_fix u-mb-20x">
                  <figure class="clear_fix">
                      <span id="cap">{!! captcha_img('flat') !!}</span>
                      <button type="button" class="btn btn-success" id="refresh">
                            <img src="/templates/core/images/other_page/icon-reload.png" alt="" width="18" height="18" class="img_reloadCapcha">
                      </button>
                  </figure>
                  <div class="form-group">
                      <label><strong>Mã an toàn<span class="redcolor">*</span></strong></label>
                      <input id="captcha" value="{{old('captcha')}}"  type="text" class="form-control" placeholder="Nhập mã Captcha" name="captchaContact">
                  </div>
                  <div class="form-group">
                      <p>(Trong trường hợp hiện ra thông báo "Mã an toàn bạn nhập vào chưa đúng" bạn vui lòng nhấn vào nút <img src="/templates/core/images/other_page/icon-reload.png" alt="" width="18" height="18"> để tạo mã an toàn mới và thử lại)</p><br>
                  </div>
              </div>
              <input type="submit" value="Submit" class="btn_1 rounded" >
            </form>
          </div>
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    <!-- /bg_color_1 -->
  </main>
@stop
@section('js')
<script>
    function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  });
}


// Install input filters.
setInputFilter(document.getElementById("phone_contact"), function(value) {
return /^-?\d*[.]?\d*$/.test(value); });

$('#refresh').click(function(){
    $.ajax({
        type:'GET',
        url:'{{route('vpublic.core.pccindex.refreshCaptcha')}}',
        success:function(data){
            $("#cap").html(data.captcha);
        }
    });
});
</script>
@endsection

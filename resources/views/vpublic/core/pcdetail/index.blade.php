@extends('templates.core.master')
@php
    $picture = $objItemTour->picture ;
@endphp
@section('css')
<link href="/templates/core/css/skitter.css" type="text/css" media="all" rel="stylesheet" />
<style>
    .hero_in.tours_detail:before {
        background: url(/storage/app/media/files/product/{{ $picture }}) center center no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .hero_in:before {
        animation: pop-in 5s .3s cubic-bezier(0,.5,0,1) forwards;
        content: "";
        opacity: 1;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -1;
    }
    .print-error-msg p {
        margin: 0;
    }
</style>
@stop
@section('main')
<main>
    <section class="hero_in tours_detail" >
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span>{{ $objItemTour->pname }}</h1>
            </div>
            <span class="magnific-gallery">
                @php
                 $path = storage_path('app/media/files/product/'.$picture );
                 if( !empty( $picture ) && (file_exists( $path )) ) {
                    $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($picture, 'product', 483, 322) ;
                }
                else {
                    $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  483, 322);
                }
                @endphp
                <a href="{{ $anh }}" class="btn_photos" title="{{ $objItemTour->pname }}" data-effect="mfp-zoom-in">Xem hình ảnh</a>

                @if (!empty($objImages))
                @foreach ($objImages as $key=>$image)
                @php
                 $path = storage_path('app/media/files/product/'.$image->picture );
                 if( !empty( $image->picture ) && (file_exists( $path )) ) {
                    $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile($image->picture, 'product', 483, 322) ;
                }
                else {
                    $anh = \App\Classes\Utils\FileUtils::resizeResultPathFile('nopicture.jpg', 'display',  483, 322);
                }
                @endphp
                    <a href="{{ $anh }}" title="{{ $objItemTour->pname }}" data-effect="mfp-zoom-in"></a>
                @endforeach
                @endif
            </span>
        </div>
    </section>
    <!--/hero_in-->

    <div class="bg_color_1">
        <nav class="secondary_nav sticky_horizontal">
            <div class="container">
                <ul class="clearfix">
                    <li><a href="#description" class="active">Thông tin</a></li>
                    {{-- <li><a href="#reviews">Đánh giá</a></li> --}}
                    <li><a href="#sidebar">Đặt Tour</a></li>
                </ul>
            </div>
        </nav>
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <section id="description">
                        <h2>Giới thiệu</h2>
                        <p>{!! $objItemTour->preview_text !!}</p>
                        <h3>Hình ảnh</h3>
                        <div class="skitter skitter-large with-dots">
                          <ul>
                            @php
                                $arEf = ['cut','swapBlocks','swapBarsBack','cut','swapBlocks','swapBarsBack','cut','swapBlocks','swapBarsBack','cut','swapBlocks','swapBarsBack'];
                            @endphp
                            @foreach ($objImages as $key=>$image)
                            <li>
                              <a href="javascript:void(0)">
                                <img src="/storage/app/media/files/product/{{ $image->picture }}" class="{{ $arEf[$key] }}" />
                              </a>
                            </li>
                            @endforeach
                            
                          </ul>
                        </div>
                        <hr>
                        @if (!empty($objItemTour->lichtrinh))
                            <h3>Lịch Trình</h3>
                            <p>{!! $objItemTour->lichtrinh !!}</p>
                            <hr>
                        @endif
                        @if (!empty($objItemTour->detail_text))
                            <h3>Chi tiết</h3>
                            <p>{!! $objItemTour->detail_text !!}</p>
                            <hr>
                        @endif
                        <h3>Địa chỉ</h3>
                        <div style="width: 100%; height:400px">
                            <iframe src="https://regiohelden.de/google-maps/map_en.php?hl=en&amp;q={{ $objItemTour->diachi }}+({{ $objItemTour->diachi }})&amp;ie=UTF8&amp;&amp;z=14&amp;output=embed"  frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        
                        <!-- End Map -->
                    </section>
                    <!-- /section -->
                
                   
                </div>
                <!-- /col -->
                
                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail booking">
                        <div class="price">
                            @php
                                $gia = (!empty($objItemTour->giakhuyenmai) ? $objItemTour->giakhuyenmai : $objItemTour->giave) ;
                            @endphp
                            <span>{{ number_format($gia,0,',','.') }} VNĐ <small>người</small></span>
                            {{-- <div class="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div> --}}
                        </div>                        
                        <div class="form-group" id="input_date">
                            <label>Ngày khởi hành</label>
                            <input class="form-control" type="text" name="dates" id="dates" placeholder="When..">
                            <i class="icon_calendar" style="top: 26px;"></i>
                        </div>
                        <div class="panel-dropdown">
                            <a href="#">Số lượng <span class="qtyTotal">1</span></a>
                            <div class="panel-dropdown-content right">
                                <div class="qtyButtons">
                                    <label>Người lớn</label>
                                    <input type="text" name="qtyInput" value="1" id="qtyInputNL">
                                </div>
                                <div class="qtyButtons">
                                    <label>Trẻ em</label>
                                    <input type="text" name="qtyInput" value="0" id="qtyInputTE">
                                </div>
                            </div>
                        </div>
                        <a href="#sign-in-dialog" onclick="setThongTin()" id="sign-in" class="btn_1 full-width purchase">Đặt vé</a>
                        <div class="text-center"><small>Thanh toán khi nhận hàng</small></div>
                    </div>
                    
                    <ul class="share-buttons">
                        <li><a class="fb-share" href="http://www.facebook.com/share.php?u={{ Request::fullUrl() }}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Facebook"><i class="social_facebook"></i> Share</a></li>
                        <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Tweet</a></li>
                        <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                    </ul>
                </aside>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_color_1 -->
</main>
  <!-- Sign In Popup -->
  <div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="small-dialog-header">
      <h3>Thông tin</h3>
    </div>
    <form>
        {{ csrf_field() }}
      <div class="sign-in-wrapper" style="font-size: 12px">
        {{-- <a href="#0" class="social_bt facebook">Login with Facebook</a>
        <a href="#0" class="social_bt google">Login with Google</a>
        <div class="divider"><span>Or</span></div> --}}

        <div class="form-group">
          <label>Ngày Khởi Hành: <strong id="KH"></strong></label><br>
          <label>Số lượng: Người lớn: <strong id="NL">0</strong> - Trẻ em(< 1m Free): <strong id="TE">0</strong></label><br>
          <label>Thành tiền: <strong id="TT">0</strong> VNĐ</label><br>
        </div>
        <div class="alert alert-danger print-error-msg" style="display:none;font-size: 11px"></div>
        <div class="form-group">
          <label>Họ Tên<span class="redcolor">*</span></label>
          <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname">
          <i class="icon-user-1" style="left: 8px;top: 27px;"></i>
        </div>
        <div class="form-group">
          <label>Email<span class="redcolor">*</span></label>
          <input type="email" class="form-control" name="email" id="email" placeholder="abc@example.com">
          <i class="icon_mail_alt" style="top: 27px;"></i>
        </div>
        <div class="form-group">
          <label>Số Điện Thoại<span class="redcolor">*</span></label>
          <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="0345678910">
          <i class="icon_phone"></i>
        </div>
        <div class="form-group">
          <label>Địa chỉ<span class="redcolor">*</span></label>
          <input type="text" class="form-control" name="diachi" id="diachi" value="" placeholder="Address">
          <i class="icon_phone"></i>
        </div>
        <div class="captcha clear_fix u-mb-20x">
          <figure class="clear_fix">
              <span id="cap">{!! captcha_img('flat') !!} </span>
              <button type="button" class="btn btn-success" id="refresh">
                    <img src="/templates/core/images/other_page/icon-reload.png" alt="" width="18" height="18" class="img_reloadCapcha">
              </button>
          </figure>
          <div class="form-group">
              <label><strong>Mã an toàn<span class="redcolor">*</span></strong></label>
              <input id="captcha" value=""  type="text" class="form-control" placeholder="Nhập mã Captcha" name="captchaDatVe">
          </div>
      </div>
        <div class="text-center">
            <input type="button" onclick="submitDatVe()" value="Đặt Vé" class="btn_1 full-width"><span id="loading" style="display: none">Loading...</span>
        </div>
      </div>
    </form>
    <!--form -->
  </div>
  <!-- /Sign In Popup -->

<!--/main-->
@stop
@section('js')
<script src="/templates/core/js/jquery.easing.1.3.js"></script>
<script src="/templates/core/js/jquery.skitter.min.js"></script>
{{-- <script src="/templates/core/js/infobox.js"></script> --}}
<!-- INPUT QUANTITY  -->
<script src="/templates/core/js/input_qty.js"></script>
<script>
    $(function() {
      $('.skitter-large').skitter();
    });
    function setThongTin(){
        var SLNL = $('#qtyInputNL').val();
        var SLTE = $('#qtyInputTE').val();
        var NgayKH = $('#dates').val();
        var thanhtien = SLNL*{{ $gia }}; 
        $('#KH').html(NgayKH)
        $('#NL').html(SLNL)
        $('#TE').html(SLTE)
        $('#TT').html(thanhtien)
    }
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
setInputFilter(document.getElementById("phone"), function(value) {
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
function refreshCaptcha(){
    $.ajax({
        type:'GET',
        url:'{{route('vpublic.core.pccindex.refreshCaptcha')}}',
        success:function(data){
            $("#cap").html(data.captcha);
        }
    });
}
    var ajax_sendding = false;
    function submitDatVe(){
      if (ajax_sendding == true){
        alert('Vui lòng chờ trong giây lát!');
        return false;
      }
      ajax_sendding = true;
      $('#loading').show();
        
      var NgayKH = $('#KH').text();
      var NL = $('#NL').text();
      var TE = $('#TE').text();
      var captchaDatVe = $('input[name=captchaDatVe]').val();
      var fullname = $('input[name=fullname]').val();
      var email = $('input[name=email]').val();
      var phone = $('input[name=phone]').val();
      var diachi = $('input[name=diachi]').val();
      var _token = $("input[name='_token']").val();
      var gia = {{ $gia }};
      var id = {{ $objItemTour->product_id }};
      $.ajax({
        url: "{{ route('vadmin.core.tour.datve') }}",
        type: 'POST',
        cache: false,
        data: {_token:_token,id:id,captchaDatVe:captchaDatVe,fullname:fullname,email:email,diachi:diachi,phone:phone,NgayKH:NgayKH,NL:NL,TE:TE,gia:gia},
        success: function(data){
            $('.print-error-msg').hide();
            ajax_sendding = false;
            if(data==1) {
                alert('Đặt vé thành công');
                location.reload();
            } 
        },
        error: function(xhr, status, error) {
            var err = xhr.responseJSON.errors;
            $('.print-error-msg').html('');
            $.each(err, function(index, value)
            {
                if (value.length != 0)
                {
                    $('.print-error-msg').show();
                    $('.print-error-msg').append('<p>'+value+'</p>');
                }
            });
        }
        
      }).always(function(){
          $('#loading').hide();
          refreshCaptcha();
          $('input[name=captchaDatVe]').val('')
          ajax_sendding = false;
          // alert('Hoàn Thành')
      });
      return false;
  };

</script>
<!-- DATEPICKER  -->
<script>
$('input[name="dates"]').daterangepicker({
    "singleDatePicker": true,
    "autoApply": true,
    parentEl:'#input_date',
    "linkedCalendars": false,
    "showCustomRangeLabel": false,
    locale: {
        format: 'DD/MM/YYYY',
    }
});

</script>
@endsection

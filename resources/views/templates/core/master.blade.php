<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.ansonika.com/panagea/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 02 Mar 2019 06:36:05 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GrTravel - Trang du lịch giải trí Đà Nẵng, là nơi đặt vé các tour du lịch, khách sạn nhà nghỉ, cho thuê xe du lịch khu vực Đà Nẵng">
    <meta name="author" content="Ansonika">
    <title>GrTravel | Trang du lịch giải trí Đà Nẵng.</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="/templates/core/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="/templates/core/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="/templates/core/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="/templates/core/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="/templates/core/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif:300,400,500,600,700,800" rel="stylesheet">
    <!-- BASE CSS -->
    <link href="/templates/core/css/bootstrap.min.css" rel="stylesheet">
    <link href="/templates/core/css/style.css" rel="stylesheet">
  <link href="/templates/core/css/vendors.css" rel="stylesheet">
  
  <!-- YOUR CUSTOM CSS -->
  <link href="/templates/core/css/custom.css" rel="stylesheet">
  @yield('css')
  <script src="/templates/core/js/modernizr_slider.js"></script>
  <style>
    .fb_dialog {
      /*bottom: 0pt !important;*/
    }
  </style>
</head>

<body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v3.2'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="2009141692723471"
  logged_in_greeting="Chào bạn, chúng tôi có thể giúp gì được cho bạn?"
  logged_out_greeting="Chào bạn, chúng tôi có thể giúp gì được cho bạn?">
</div>
    
  <div id="page">
    
  <header class="header menu_fixed">
    <div id="preloader"><div data-loader="circle-side"></div></div><!-- /Page Preload -->
    <div id="logo">
      <a href="{{ route('vpublic.core.pcindex.index') }}">
        <img src="/templates/core/img/logo.png" width="150" height="36" data-retina="true" alt="" class="logo_normal">
        <img src="/templates/core/img/logo_sticky.png" width="150" height="36" data-retina="true" alt="" class="logo_sticky">
      </a>
    </div>
    {{-- <ul id="top_menu">
      <li><a href="cart-1.html" class="cart-menu-btn" title="Cart"><strong>4</strong></a></li>
      <li><a href="#sign-in-dialog" id="sign-in" class="login" title="Sign In">Sign In</a></li>
      <li><a href="wishlist.html" class="wishlist_bt_top" title="Your wishlist">Your wishlist</a></li>
    </ul>  --}}
    <!-- /top_menu -->
    <a href="#menu" class="btn_mobile">
      <div class="hamburger hamburger--spin" id="hamburger">
        <div class="hamburger-box">
          <div class="hamburger-inner"></div>
        </div>
      </div>
    </a>
    <nav id="menu" class="main-menu">
      @widget('MenuTop')
    </nav>

  </header>
  <!-- /header -->
  
  @yield('main')
  <!-- /main -->
  <footer>
    <div class="container margin_60_35">
      <div class="row">
        <div class="col-lg-3 col-md-3 p-r-5">
          <p><img src="/templates/core/img/logo.png" width="150" height="36" data-retina="true" alt=""></p>
          <div class="follow_us">
            <h5>Follow us</h5>
            <ul>
              <li><a href="#0"><i class="ti-facebook"></i></a></li>
              <li><a href="#0"><i class="ti-twitter-alt"></i></a></li>
              <li><a href="#0"><i class="ti-google"></i></a></li>
              <li><a href="#0"><i class="ti-pinterest"></i></a></li>
              <li><a href="#0"><i class="ti-instagram"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-5 col-md-6 ml-lg-auto">
          <h5>Fanpage</h5>
          <div class="" style="height: 214px;">
             <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FTourDuLichGiaReTaiDaNang&tabs&width=350&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1665365726845518" width="350" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
          </div>
        </div>
        <div class="col-lg-3 col-md-3">
          <div id="newsletter">
          <h5>Newsletter</h5>
          <div id="message-newsletter"></div>
          <form method="post" action="http://www.ansonika.com/panagea/assets/newsletter.php" name="newsletter_form" id="newsletter_form">
            <div class="form-group">
              <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
              <input type="submit" value="Submit" id="submit-newsletter">
            </div>
          </form>
          </div>
        </div>
      </div>
      <!--/row-->
      <hr>
      <div class="row">
        <div class="col-lg-6">
          <ul id="footer-selector">
            <li>
              <div class="styled-select" id="lang-selector">
                <select>
                  <option value="English" selected>English</option>
                  <option value="French">French</option>
                  <option value="Spanish">Spanish</option>
                  <option value="Russian">Russian</option>
                </select>
              </div>
            </li>
            <li>
              <div class="styled-select" id="currency-selector">
                <select>
                  <option value="US Dollars" selected>US Dollars</option>
                  <option value="Euro">Euro</option>
                </select>
              </div>
            </li>
            <li><img src="/templates/core/img/cards_all.svg" alt=""></li>
          </ul>
        </div>
        <div class="col-lg-6">
          <ul id="additional_links">
            <li><a href="#0">Terms and conditions</a></li>
            <li><a href="#0">Privacy</a></li>
            <li><span>© 2018 Panagea</span></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!--/footer-->
  </div>
  <!-- page -->
  
{{--   <!-- Sign In Popup -->
  <div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="small-dialog-header">
      <h3>Sign In</h3>
    </div>
    <form>
      <div class="sign-in-wrapper">
        <a href="#0" class="social_bt facebook">Login with Facebook</a>
        <a href="#0" class="social_bt google">Login with Google</a>
        <div class="divider"><span>Or</span></div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" id="email">
          <i class="icon_mail_alt"></i>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" name="password" id="password" value="">
          <i class="icon_lock_alt"></i>
        </div>
        <div class="clearfix add_bottom_15">
          <div class="checkboxes float-left">
            <label class="container_check">Remember me
              <input type="checkbox">
              <span class="checkmark"></span>
            </label>
          </div>
          <div class="float-right mt-1"><a id="forgot" href="javascript:void(0);">Forgot Password?</a></div>
        </div>
        <div class="text-center"><input type="submit" value="Log In" class="btn_1 full-width"></div>
        <div class="text-center">
          Don’t have an account? <a href="register.html">Sign up</a>
        </div>
        <div id="forgot_pw">
          <div class="form-group">
            <label>Please confirm login email below</label>
            <input type="email" class="form-control" name="email_forgot" id="email_forgot">
            <i class="icon_mail_alt"></i>
          </div>
          <p>You will receive an email containing a link allowing you to reset your password to a new preferred one.</p>
          <div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
        </div>
      </div>
    </form>
    <!--form -->
  </div>
  <!-- /Sign In Popup --> --}}
  
  <div id="toTop"></div><!-- Back to top button -->
  
  <!-- COMMON SCRIPTS -->
    <script src="/templates/core/js/jquery-2.2.4.min.js"></script>
    <script src="/templates/core/js/common_scripts.js"></script>
    <script src="/templates/core/js/main.js"></script>
  <script src="/templates/core/assets/validate.js"></script>
  
  <!-- FlexSlider -->
  <script defer src="/templates/core/js/jquery.flexslider.js"></script>
  <script>
    $(window).load(function() {
      'use strict';
      $('#carousel_slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 280,
        itemMargin: 25,
        asNavFor: '#slider'
      });
      $('#carousel_slider ul.slides li').on('mouseover', function() {
        $(this).trigger('click');
      });
      $('#slider').flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel_slider",
        start: function(slider) {
          $('body').removeClass('loading');
        }
      });
    });
  </script>
   {{-- <script defer src="/templates/core/js/weather_home.js"></script> --}}
  
  <!-- COLOR SWITCHER  -->
  {{-- <script src="/templates/core/js/switcher.js"></script> --}}
<!--  <div id="style-switcher">
    <h6>Color Switcher <a href="#"><i class="ti-settings"></i></a></h6>
    <div>
      <ul class="colors" id="color1">
        <li><a href="#" class="default" title="Default"></a></li>
        <li><a href="#" class="aqua" title="Aqua"></a></li>
        <li><a href="#" class="green_switcher" title="Green"></a></li>
        <li><a href="#" class="orange" title="Orange"></a></li>
        <li><a href="#" class="blue" title="Blue"></a></li>
        <li><a href="#" class="beige" title="Beige"></a></li>
        <li><a href="#" class="gray" title="Gray"></a></li>
        <li><a href="#" class="green-2" title="Green"></a></li>
        <li><a href="#" class="navy" title="Navy"></a></li>
        <li><a href="#" class="peach" title="Peach"></a></li>
        <li><a href="#" class="purple" title="Purple"></a></li>
        <li><a href="#" class="red" title="Red"></a></li>
        <li><a href="#" class="violet" title="Violet"></a></li>
      </ul>
    </div>
  </div> -->
  @yield('js')
</body>

<!-- Mirrored from www.ansonika.com/panagea/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 02 Mar 2019 06:37:34 GMT -->
</html>
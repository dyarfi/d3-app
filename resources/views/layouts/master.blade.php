<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ @$title }}</title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <!--link rel="stylesheet" href="{{ asset('css/all.css') }}"/-->
    <link rel="stylesheet" href="{{ asset('css/default.css') }}" class="demo-stylesheet" id="demo" />
@if(isset($styles)) @foreach ($styles as $style => $css) {!! Html::style($css, ['rel'=>'stylesheet']) !!} @endforeach @endif
    <!--script src="{{ asset('js/jquery.min.js') }}"></script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ias.min.js') }}"></script>
    <script type="text/javascript">var base_URL = '{{ url() }}/';</script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="{{ route('home') }}">Apanel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!--form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-info"><span class="fa fa-search"></span></button>
      </form-->
      <ul class="nav navbar-nav navbar-right">
        @foreach ($menus as $menu)
            <li><a href="{{ $menu->slug == route('home') ? '' : route($menu->slug) }}">{{ $menu->name }}</a></li>
        @endforeach
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu2" role="button">{{ Auth::getUser()->username }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                  <li><a href="{{ route('profile') }}">Profile</a></li>
                  <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif
      </ul>
      <menu class="language_switcher">
        <ul class="list-inline">
            <?php foreach (Config::get('app.locales') as $locale => $language): ?>
            @if ($locale != App::getLocale())
            <li class="<?php echo $locale == App::getLocale() ? 'current' : '';?>">
                <a href="<?php echo url(sprintf($changeLocaleUrl, $locale)); ?>" title="{{ $language }}"><img src="<?= url('img/country/'. $locale . '.png') ?>" /></a>
            </li>
            @endif
            <?php endforeach; ?>
        </ul>
    </menu>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
    @include('partials.alerts.success')
    @include('partials.alerts.errors')
    @yield('content')
</div>
<div class="footer">
    <div>
        <span class="center-block text-center">{{ trans('label.copyright') }} 2016</span>
    </div>
</div>
@if(isset($scripts)) @foreach($scripts as $script => $js) {!! Html::script($js, ['rel'=>$script]) !!} @endforeach @endif
<script type="text/javascript">
/*
$(window).scroll(function() {
    menuFixTop();
    function menuFixTop () {
        var screen = $(window).scrollTop();
        if(screen >= $('.navbar-default').height()) {
            $('.navbar-default').addClass('navbar-fixed-top');
        } else {
            $('.navbar-default').removeClass('navbar-fixed-top');
        }
    }
});
*/
jQuery.ias({
    container   : "#entry-listing",
    item        : ".entry",
    pagination  : ".pagination",
    next        : 'a[rel="next"]',
    loader      : '<div class="clearfix"><img class="center-block" src="{{ asset("img/ajax-loader.gif") }}"/></div>',
    delay       : 1000,
    history     : false,
    negativeMargin : 100,
    //debug : true,
    //dataType : 'html',
    //maxPage : 1,*
    onRenderComplete: function(items) {
    /*
      var $newElems = jQuery(items).addClass("newItem");
      $newElems.hide().imagesLoaded(function(){
            jQuery(this).show();
            jQuery('#infscr-loading').fadeOut('normal');
            jQuery("#entry-listing").isotope('appended', $newElems );
      });
    */
    }
});
</script>
</body>
</html>

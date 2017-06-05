<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta name="author" content="Dentsu Digital" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ @$title }}</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <!--link rel="stylesheet" href="{{ asset('css/all.css') }}"/-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/additional.css') }}" type="text/css" />
@if(isset($styles)) @foreach ($styles as $style => $css) {!! Html::style($css, ['rel'=>'stylesheet']) !!} @endforeach @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset("js/jquery.min.js") }}"><\/script>')</script>
    <!-- <script src="{{ asset('js/jquery.easing.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/jquery.ias.min.js') }}"></script> -->
    <script type="text/javascript">var base_URL = '{{ url() }}/';</script>
</head>
<body class="stretched">
<div id="wrapper" class="clearfix">
	<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">
        <div id="header-wrap">
            <div class="container clearfix">
                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                <div id="logo">
                    <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ asset('images/d3.png') }}"><img src="{{ asset('images/d3.png') }}" alt="d3 Logo"></a>
                    <a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ asset('images/d3logo@2x.png') }}"><img src="{{ asset('images/d3logo@2x.png') }}" alt="d3 Logo"></a>
                </div>
                <nav id="primary-menu" class="dark">
                    <ul>
                        @foreach ($menus as $menu)
                            <li {{ $menu->slug == Route::current()->getName() || str_is(Request::segment(1), $menu->slug)? 'class=current' : '' }}><a href="{{ $menu->slug == route('home') ? '' : route($menu->slug) }}">{{ $menu->name }}</a></li>
                        @endforeach
                        @if (Auth::guest())
                            <!--li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li-->
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
                    <div id="top-search">
						<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
						<form action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
						</form>
					</div>
                    <!--menu class="language_switcher">
                        <ul class="list-inline">
                            <?php foreach (Config::get('app.locales') as $locale => $language): ?>
                            @if ($locale != App::getLocale())
                            <li class="<?php echo $locale == App::getLocale() ? 'current' : '';?>">
                                <a href="<?php echo url(sprintf($changeLocaleUrl, $locale)); ?>" title="{{ $language }}"><img src="<?= url('img/country/'. $locale . '.png') ?>" /></a>
                            </li>
                            @endif
                            <?php endforeach; ?>
                        </ul>
                    </menu-->
                </nav>
            </div>
        </div>
    </header>
    <div class="container">
        @include('partials.alerts.success')
        @include('partials.alerts.errors')
    </div>
    @yield('content')
    <footer>
        <div id="copyrights">
            <div class="container clearfix">
                <div class="col_half">
                    {{ trans('label.copyright') }} 2017<br>
                    <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
                </div>
                <div class="col_half col_last tright">
                    <div class="fright clearfix">
                        <a href="#" class="social-icon si-small si-borderless si-facebook">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-borderless si-twitter">
                            <i class="icon-twitter"></i>
                            <i class="icon-twitter"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-borderless si-gplus">
                            <i class="icon-gplus"></i>
                            <i class="icon-gplus"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-borderless si-github">
                            <i class="icon-github"></i>
                            <i class="icon-github"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-borderless si-linkedin">
                            <i class="icon-linkedin"></i>
                            <i class="icon-linkedin"></i>
                        </a>
                    </div>
                    <div class="clear"></div>
                    <i class="icon-envelope2"></i>&nbsp;<a href="mailto:info@dentsu.digital"> info@dentsu.digital </a><span class="middot">&middot;</span> <i class="icon-headphones"></i> +62-21-6541-6369 <span class="middot">&middot;</span>
                </div>
            </div>
        </div>
    </footer>
</div>
<div id="gotoTop" class="icon-angle-up"></div>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
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
</script>
</body>
</html>

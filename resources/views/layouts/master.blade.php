<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
<head>
<meta name="author" content="Dentsu Digital" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ @$title }}</title>
    <!--link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css"/-->
    <?php /* LARAVEL Mix see webpack.mix.js for recompile the files */ ?>
    <link rel="stylesheet" href="{{ mix('css/d3all.css') }}">
@if(isset($styles)) @foreach ($styles as $style => $css) {!! Html::style($css, ['rel'=>'stylesheet']) !!} @endforeach @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset("js/jquery.min.js") }}"><\/script>')</script>
    <script type="text/javascript">var base_URL = '{{ url('/') }}/';</script>
</head>
<body class="stretched">
<div id="wrapper" class="clearfix">
	<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">
        <div id="header-wrap">
            <div class="container clearfix">
                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                @if($logo = app('App\Modules\User\Model\Setting')->key('logo')->value)
                <div id="logo">
                    <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ File::exists(public_path('images/logo/'.$logo)) ? asset('images/logo/'.$logo) : asset('images/logo-resto.png') }}"><img src="{{ File::exists(public_path('images/logo/'.$logo)) ? asset('images/logo/'.$logo) : asset('images/logo-resto.png') }}" alt="d3 Logo"></a>
                    <!--a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ asset('images/d3logo@2x.png') }}"><img src="{{ asset('images/d3logo@2x.png') }}" alt="d3 Logo"></a-->
                </div>
                @endif
                <nav id="primary-menu" class="dark">
                    <ul>
                        @foreach ($menus as $menu)
                            <li {{ $menu->slug == Route::current()->getName() || str_is(Request::segment(1), $menu->slug)? 'class=current' : '' }}><a href="{{ $menu->slug == route('home') ? '' : route($menu->slug) }}">{{ $menu->name }}</a></li>
                        @endforeach
                        <?php /*
                        @if (!Auth::check())
                            <!--li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li-->
                        @else
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu2" role="button">
                                {{ Auth::check()}} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                                  <li><a href="{{ route('profile') }}">Profile</a></li>
                                  <li><a href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                        */
                        ?>
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
                        @foreach ($socials as $social)
                        <a href="{{ $social->value }}" class="social-icon si-small si-borderless si-{{ $social->key }}">
                            <i class="icon-{{ @$social->key }}"></i>
                            <i class="icon-{{ @$social->key }}"></i>
                        </a>
                        @endforeach                       
                    </div>
                    <div class="clear"></div>
                    <i class="icon-envelope2"></i>&nbsp;<a href="mailto:info@dentsu.digital"> info@dentsu.digital </a><span class="middot">&middot;</span> <i class="icon-headphones"></i> +62-21-6541-6369 <span class="middot">&middot;</span>
                </div>
            </div>
        </div>
    </footer>
</div>
<div id="gotoTop" class="icon-angle-up"></div>
<?php /* LARAVEL Mix see webpack.mix.js for recompile the files */?>
<script src="{{ mix('js/d3all.js') }}"></script>
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

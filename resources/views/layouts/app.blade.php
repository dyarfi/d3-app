<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">   
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>&nbsp; </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><span class="fa fa-user"></span>&nbsp; {{ __('label.login') }}</a></li>
                            <li><a href="{{ route('register') }}"><span class="fa fa-tag"></span>&nbsp;{{ __('label.register') }}</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('user.dashboard') }}" title="User Dashboard">
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <menu class="language_switcher">
                        <?php
                        /*
                        <ul class="list-inline">
                            <?php foreach (Config::get('app.locales') as $locale => $language): ?>
                            @if ($locale != App::getLocale())
                            <li class="<?php echo $locale == App::getLocale() ? 'current' : '';?>">
                                <a href="<?php echo url(sprintf($changeLocaleUrl, $locale)); ?>" title="{{ $language }}"><img src="<?= url('img/country/'. $locale . '.png') ?>" /></a>
                            </li>
                            @endif
                            <?php endforeach; ?>
                        </ul>
                        */ 
                        ?>
                        <ul class="list-inline">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                @if ($localeCode != App::getLocale())
                                <li class="<?php echo $localeCode == App::getLocale() ? 'current' : '';?>">
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        <img src="<?= url('img/country/'. $localeCode . '.png') ?>" />
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </menu>
                </div>
            </div>
        </nav>
        @if ($errors->any())
            <div class="space-6"></div>
            <div class="col-lg-12">
              <div class="alert alert-danger alert-block" role="alert">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
                <!--strong>Error</strong-->
                @if ($message = $errors->first(0, ':message'))
                {{ $message }}
                @else
                Please check the form below for errors
                @endif
              </div>
            </div>
            <div class="space-6"></div>
        @endif
        @if ($message = Session::get('success'))
          <div class="space-6"></div>
            <div class="col-lg-12">
              <div class="alert alert-success alert-block" role="alert">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
                <strong>Success :</strong> {{ $message }}
              </div>
            </div>
          <div class="space-6"></div>
          @endif
          @if ($message = Session::get('error'))
          <div class="space-6"></div>
            <div class="col-lg-12">
              <div class="alert alert-warning alert-block" role="alert">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
                <strong>Error :</strong> {{ $message }}
              </div>
            </div>
          <div class="space-6"></div>
        @endif
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Meta data -->
    <meta name="description" content="@yield('description')">
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Icons -->
    <link rel="shortcut icon" href="{{asset('/assets/images/just-share-media-favicon.png')}}"/>

    <!-- Stylesheets -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
        rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/font-icons.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/animate.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/magnific-popup.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('/assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@yield('css_additional')
@yield('css_admin_additional')
@if (env('APP_ENV') === 'production')
<meta name="facebook-domain-verification" content="0c9vklgeykkqhpr8xa81xxm4tz8j48" />

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1065520910579905');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1065520910579905&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-202689967-1"></script>
      <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-202689967-1');
      </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-D2LYR5NLJB"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){window.dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-D2LYR5NLJB');
        </script>
    @endif
</head>

<body class="stretched page-transition" data-loader="1" data-animation-in="fadeIn" data-speed-in="700"
      data-animation-out="fadeOut" data-speed-out="300">

<!-- Document Wrapper -->
<div id="wrapper" class="clearfix">

    <!-- Header -->
    <header id="header" class="full-header">
        <div id="header-wrap">
            <div class="container">
                <div class="header-row">

                    <!-- Logo -->
                    <div id="logo">
                        <a href="/" data-dark-logo="/assets/images/logo.png">
                            <img src="{{asset('/assets/images/just-share-media-logo.png')}}" alt="Just Share Media Logo">
                        </a>
                    </div>

                    <!-- Header Misc -->
                    <div class="header-misc">
                        <div class="dropdown mx-3 mr-lg-0">
                            <a href="#" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-user"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                @if (Auth::user())
                                    <a class="dropdown-item text-left" href="/dashboard"><i class='icon-user-circle'></i> My Account</a>
                                    <a class="dropdown-item text-left" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-signout"></i>{{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a class="dropdown-item text-left" href="/signup"><i class='icon-location-arrow'></i> Sign Up</a>
                                    <a class="dropdown-item text-left" href="/login"><i class="icon-signin"></i> Login</a>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div id="primary-menu-trigger">
                        <svg class="svg-trigger" viewBox="0 0 100 100">
                            <path
                                d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
                            <path d="m 30,50 h 40"></path>
                            <path
                                d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
                        </svg>
                    </div>

                    <!-- Navigation -->
                    <nav class="primary-menu">
                        <ul class="menu-container">
                            @if(!Auth::user())
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('signup')}}">
                                    <div>Plans</div>
                                </a>
                            </li>
                            @endif
                            <li class="menu-item">
                                <a class="menu-link" href="/about">
                                    <div>About</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="/gallery">
                                    <div>Gallery</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="/contact">
                                    <div>Contact</div>
                                </a>
                            </li>

                            @if(!Auth::user())
                            <li class="menu-item">
                                <a class="btn btn-primary btn-lg" href="{{route('signup')}}"
                                   style="padding-top: 5px; padding-bottom: 5px;">
                                    <div>Sign Up</div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header-wrap-clone"></div>
    </header>

    <!-- Page Content-->
    <section id="content">

        @yield('content')

    </section>

    <!-- Footer -->
    @include('template.footer')

</div>

<!-- Go To Top -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- Scripts -->
<script src="{{asset('/assets/js/jquery.js')}}"></script>
<script src="{{asset('/assets/js/plugins.js')}}"></script>
<script src="{{asset('/assets/js/functions.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@yield('js_additional')
@yield('js_admin_additional')
</body>
</html>

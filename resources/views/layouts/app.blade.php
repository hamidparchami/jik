<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>پنل مدیریت</title>

    <!-- Styles -->
    <link href="/css/app.css?v=0.1" rel="stylesheet">
    <link href="/css/admin/common.css?v=0.1" rel="stylesheet">
    @yield('header_links')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('header_scripts')
</head>
<body>
<div id="loading-mask" class="loading"><div>در حال بارگزاری...</div></div>
    <div id="app">
    @if (App::environment('staging'))
        <div class="alert alert-danger" style="position: fixed; font-weight: bold; width: 20%; z-index: 9999;">You are on TEST environment!</div>
    @endif
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
                <span class="appson-navbar-brand">
                            @if(Auth::check())
                        {{ Auth::user()->email }}
                    @endif
                        </span>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <a href="{{ url('/admin/home') }}"><img src="/images/header-logo.png" width="32" height="32" style="margin: 8px;"></a>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">ورود</a></li>
                        <li><a href="{{ url('/register') }}">ثبت نام</a></li>
                    @else


                        <li class="dropdown">
                            @if (in_array('admin/user/manage', session('allowed_URLs')) || in_array('admin/role/manage', session('allowed_URLs')) || in_array('admin/url/manage', session('allowed_URLs')))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    تنظیمات سیستم<span class="caret"></span>
                                </a>
                            @endif

                            <ul class="dropdown-menu rtl" role="menu">
                                @if (in_array('admin/user/manage', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/user/manage') }}">مدیریت کاربران</a>
                                    </li>
                                @endif

                                @if (in_array('admin/role/manage', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/role/manage') }}">مدیریت نقش ها</a>
                                    </li>
                                @endif


                                @if (in_array('admin/url/manage', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/url/manage') }}">مدیریت URL ها</a>
                                    </li>
                                @endif

                            </ul>
                        </li>

                        <li class="dropdown">
                            @if (in_array('admin/slider/manage', session('allowed_URLs')) || in_array('admin/award/manage', session('allowed_URLs')))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    محتوای پایه<span class="caret"></span>
                                </a>
                            @endif

                            <ul class="dropdown-menu rtl" role="menu">
                                @if (in_array('admin/slider/manage', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/slider/manage') }}">مدیریت اسلایدر</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/slider/create') }}">افزودن اسلاید</a>
                                    </li>
                                @endif

                                @if (in_array('admin/award/manage', session('allowed_URLs')))
                                    <hr style="margin: 0">
                                    <li>
                                        <a href="{{ url('/admin/award/manage') }}">مدیریت جایزه ها</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/award/create') }}">تعریف جایزه</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            @if (in_array('admin/service/manage', session('allowed_URLs')))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    سرویس <span class="caret"></span>
                                </a>
                            @endif
                            <ul class="dropdown-menu rtl" role="menu">
                                @if (in_array('admin/service/manage', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/service/manage') }}">مدیریت سرویس‎‌ها</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/service/create') }}">ایجاد سرویس</a>
                                    </li>
                                @endif

                                @if (in_array('admin/content/manage', session('allowed_URLs')))
                                    <hr style="margin: 0;">
                                    <li>
                                        <a href="{{ url('/admin/content/manage') }}">مدیریت محتوا</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/content/create') }}">ایجاد محتوا</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            @if (in_array('admin/catalog/manage', session('allowed_URLs')) || in_array('admin/event/manage', session('allowed_URLs')))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    کاتالوگ <span class="caret"></span>
                                </a>
                            @endif

                            <ul class="dropdown-menu rtl" role="menu">
                                @if (in_array('admin/catalog/manage/{parent_id?}', session('allowed_URLs')))
                                    <li>
                                        <a href="{{ url('/admin/catalog/manage') }}">مدیریت کاتالوگ ها</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/catalog/create') }}">ایجاد کاتالوگ</a>
                                    </li>
                                @endif

                                @if (in_array('admin/event/manage', session('allowed_URLs')))
                                    <hr style="margin: 0;">
                                    <li>
                                        <a href="{{ url('/admin/event/manage') }}">مدیریت رویدادها</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/event/create') }}">ایجاد رویداد</a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu rtl" role="menu">
                                <li>
                                    <a href="{{ url('/user/change-password') }}">تغییر رمز</a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        خروج
                                    </a>

                                    <form id="logout-form" action="@if(!App::environment('local')) {{ secure_url('/logout') }} @else {{ url('/logout') }} @endif" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

</div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @yield('footer_scripts')
</body>
</html>

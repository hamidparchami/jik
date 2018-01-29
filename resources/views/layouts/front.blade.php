<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سرویس کاتالوگ {{ (isset($page_title) ? ' | ' . $page_title : '') }}</title>

    <!-- Styles -->
    <link href="/css/app.css?v=0.1" rel="stylesheet">
    <link href="/css/common.css?v=0.2" rel="stylesheet">
    @yield('header_links')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('header_scripts')
    <meta name="developer" content="Hamid Parchami">
</head>
<body>
<div id="loading-mask" class="loading"><div>لطفا کمی صبر کنید...</div></div>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 header">
            <div class="container">
                <div class="row">
                    @if(is_null(session('user_phone')))
                        <div class="col-md-1">
                                <a href="/user/login"><div class="login-button">ورود</div></a>
                        </div>
                    @else
                        <div class="col-md-2">
                            <div class="user-links-container"><a href="/user/edit-profile">پروفایل</a> | <a href="/user/logout">خروج</a></div>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <input type="search" class="rtl search-field" placeholder="جستجو...">
                    </div>
                    <div class="col-md-8 text-right header-right-navigation">
                        <span><a href="/">صفحه نخست</a></span>
                        <span><a href="/catalog/list">دسته‌بندی‌ها</a></span>
                        <span><a href="/all-delivered-awards">جوایز اهدا شده</a></span>
                        <span><a href="/all-awards">جوایز آینده</a></span>
                        @if(!is_null(session('user_phone')))
                        <span><a href="/user/registered-services">سرویس‌های من</a></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="padding: 0; margin: 0;">@yield('main')</div>
    </div>


        <div class="col-md-12 text-center" style="border: 1px solid #dbdbdb; background-color: #f2f2f2; height: 100px; margin-top: 100px; padding-top: 24px; line-height: 2.5em">
            {{--<img src="/images/appson_logo_bw.svg">--}}
            <br>© ۱۳۹۵
        </div>

</div>
@yield('footer_scripts')
</body>
</html>
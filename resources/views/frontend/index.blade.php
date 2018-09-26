<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>مجله جیک و پیک</title>

    <!-- Styles -->
    <link href="/css/app.css?v=0.1" rel="stylesheet">
    <link href="/css/common.css?v=0.2" rel="stylesheet">

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <meta name="developer" content="Hamid Parchami">
</head>
<body>
<div id="loading-mask" class="loading"><div>لطفا کمی صبر کنید...</div></div>

<div class="container-fluid main-col-container">


    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="border: 1px solid #CCCCCC;">Main</div>
            <div class="col-md-3"></div>
        </div>
    </div>


    {{--<div class="col-md-12 text-center" style="background-color: #f2f2f2; height: 100px; padding-top: 24px; line-height: 2.5em">
        <br>© ۱۳۹۵
    </div>--}}

</div>
</body>
</html>
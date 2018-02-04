<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $article->title }}</title>

    <!-- Styles -->
    <link href="/css/app.css?v=0.1" rel="stylesheet">
    <link href="/css/common.css?v=0.2" rel="stylesheet">
    <meta name="developer" content="Hamid Parchami">
</head>
<body>
<div class="container main-container">
    <div class="row">
        <div class="col-md-12 rtl"><h1>{{ $article->title }}</h1></div>
        <div class="col-md-12 rtl">{!! $article->content !!}</div>
    </div>
</div>
</body>
</html>
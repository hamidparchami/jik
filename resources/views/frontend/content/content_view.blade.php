<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $content->category->name }}</title>

    <!-- Styles -->
    <link href="/css/app.css?v=0.1" rel="stylesheet">
    <link href="/css/common.css?v=0.2" rel="stylesheet">
    <meta name="developer" content="Hamid Parchami">
</head>
<body>
<div class="container main-container">
    <div class="row">
        <div class="col-md-12 rtl">
            <div id="article_title"><h1>{{ $content->category->name }} ({{ $content->order }})</h1></div>
        </div>
        <div class="col-md-12 rtl">
            <div id="article_content">{!! $content->full_content !!}</div>
        </div>
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>مجله زیبایی و سلامت جیک و پیک</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/landing/download.css?v=0.1">
</head>
<body>
<div class="container">
<div class="row main-row">
    <div class="col-md-8 col-sm-12 col-xs-12">
        <img class="img-fluid app-screenshot" src="/images/app_screenshot.png">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 description-container">
        <div>{!! $downloadDescription !!}</div>
        <hr class="style-two">
        <div><a href="{{ $downloadLinkForAndroid }}">دریافت نسخه اندروید</a></div>
        <div><a href="#">دریافت نسخه iOS</a></div>
    </div>
</div>
</div>
</body>
</html>

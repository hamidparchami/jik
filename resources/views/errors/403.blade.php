<!DOCTYPE html>
<html>
    <head>
        <title>خطا</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="/css/common.css" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                direction: rtl;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ ($exception->getMessage() !== '' && !is_null($exception->getMessage())) ? $exception->getMessage() : "شما مجوز دسترسی به صفحه مورد نظر را ندارید." }}</div>
            </div>
        </div>
    </body>
</html>

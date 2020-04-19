<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link href="c-bble/css/c-bble.css" rel="stylesheet" type="text/css">
        <link href="c-bble/css/layout.css" rel="stylesheet" type="text/css">
        <link href="c-bble/css/themes/light.css" rel="stylesheet" type="text/css">
    </head>
    <body class="vh-100 text-tiny black-bg light-txt">
        <div class="flex flex-items-center justify-center relative vh-100">
            @if (Route::has('login'))
                <div class="absolute top right m-20 links font-12 text-bold uppercase">
                    @if (Auth::check())
                        
                    @else
                        <a class="px-10px" href="{{ url('/login') }}">Login</a>
                        <a class="px-10px" href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="font-30 align-center text-tiny">
                <div class="font-large mb-30">C-BBLe</div>
                <div class="subtitle links font-15">
                    <a href="/Sitemap" class="mx-5">Карта сайта</a>
                    <a href="/" class="mx-5">Менеджер витрины</a>
                    <a href="/" class="mx-5">Сообщество</a>
                    <a href="/" class="mx-5">Аналитика</a>
                </div>
            </div>
        </div>
    </body>
</html>

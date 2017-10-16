<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/iconmonstr-iconic-font/css/iconmonstr-iconic-font.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K25LZ78');</script>
</head>
<body>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K25LZ78"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@inject('ajax', 'App\Services\AjaxAuthService')
@include('index.header')
    <div class="row">
        <div class="col-sm-3 sidebar">
            @include('index.sidebar')
        </div>

        <div class="col-sm-9" id="content-block">
            <div id="news-spinner"><img src='/vendor/SVG-Loaders/svg-loaders/bars.svg'/></div>
            <div id="content">
                @yield('content')
            </div>
        </div>
        <div id='spinner'><img src='/vendor/SVG-Loaders/svg-loaders/three-dots.svg' id="spinner_image"/></div>
        <input type="hidden" name="ui" value="{{$ajax->getUserId()}}" />
        <input type="hidden" name="at" value="{{$ajax->getAuthToken()}}" />
    </div>

    <div class="row">
        <div class="col-sm-12" id="footer">
            © Copyright 2017. All Rights Reserved.</br> Created with love. Inspired by Kate.<i class="im im-heart"></i>
        </div>
    </div>
</div>

<script data-main="/js/config/index.js" src="/js/require.js"></script>
</body>
</html>

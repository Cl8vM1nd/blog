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
        <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108094573-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-108094573-1');
    </script>
</head>
<body>
@include('index.header')
    <div class="row">
        <div class="col-sm-12" id="content">
            @yield('content')
        </div>
    </div>
</div>

<script async="false" data-main="../js/config/article.js" src="../js/require.js"></script>
</body>
</html>

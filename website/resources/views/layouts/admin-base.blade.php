<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- LEFT PANEL -->
        <div class="col-sm-1 admin-panel-left">
            <div class="header">
                <span>ADMIN</span> Beta
            </div>

            <div class="content">
                <a href="{{ route('admin::index') }}">
                    <div class="icon">
                        <div class="dashboard circle">
                            <div class="img" id="menu">
                                <img src="/img/dashboard.png" alt="">
                            </div>
                        </div>
                        <div class="text">Dashboard</div>
                    </div>
                </a>
                <a href="{{ route('admin::news.index') }}">
                    <div class="icon">
                        <div class="dashboard circle">
                            <div class="img" id="menu">
                                <img src="/img/news.png" alt="">
                            </div>
                        </div>
                        <div class="text">News</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- TOP PANEL -->
        <div class="col-sm-9 col-sm-offset-1 admin-panel-top">
            <div class="header">
                Dashboard{{ $breadcrumb }}
            </div>

            <div class="logout">
                <a href="/" class="main-site-link">Main page</a>
                <a href="/admin/logout">Logout</a>
            </div>
        </div>

        <!-- CONTENT PANEL -->
        <div class="col-sm-11 admin-panel-content">
            @yield('content')
        </div>

    </div>
</div>

<script src="/vendor/jquery/dist/jquery.js"></script>

<script src="/vendor/bootstrap/dist/js/bootstrap.js"></script>
<script src="/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>
<script src="/vendor/tinymce/js/tinymce/tinymce.min.js?apiKey=40b8nqna5xe98q4xvjm66l4c6v708i2s20zpgcsyr1aeltet"></script>
<script src="/js/admin.js"></script>

</body>
</html>
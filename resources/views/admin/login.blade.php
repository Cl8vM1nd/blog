<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/form.css">
</head>
<body>

    <div class="container">
        <div class="login-page" id="adm_login">
            <div class="form" >
            @if (count($errors) > 0)
                <!-- Form Error List -->
                    <div class="alert alert-danger">
                        <strong>Whoops! Something went wrong!</strong>

                        <br><br>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="login-form" action="/admin/login" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="email" placeholder="email"/>
                    <input type="password" name="password" placeholder="password"/>
                    <button type="submit">login</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>


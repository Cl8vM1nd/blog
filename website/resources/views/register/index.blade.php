@extends('layouts.base')
@section('content')

    <div id="register" class="col-xs-4 col-xs-offset-4 col-xs-offset-4">
        <form action="/register" method="POST">
            {{ csrf_field() }}

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Имя</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-4 col-xs-8 ">
                        <button type="submit" class="btn btn-default">Зарегистрироваться</button>
                    </div>
                </div>
            </form>

        </form>
    </div>

@endsection
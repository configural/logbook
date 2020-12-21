
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Профиль пользователя
                </div>

                <div class="panel-body">

                    <form method="post">
                        <p><label>Отображаемое имя пользователя</label><br/>
                            <input name="name" type="text" value="{{ Auth::user()->name}}" class="form-control-static"></p>

                        <p><label>Логин (email)</label><br/>
                            <input name="email" type="email" value="{{ Auth::user()->email}}" class="form-control-static" disabled></p>

                        <p><label>Новый пароль и подтверждение</label><br/>
                            <input name="password" type="password" value="" class="form-control-static">
                            <input name="confirm_password" type="password" value="" class="form-control-static"></p>
                        </p>
                        <p>
                            Ваша текущая роль - {{ Auth::user()->role->name }}. Чтобы ее поменять обратитесь к администратору.

                        </p>
                        <button class="btn btn-success">Сохранить</button>


                        {{ csrf_field() }}
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

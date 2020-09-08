
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

                    <form action=''>
                        <p><label>Отображаемое имя пользователя</label>
                            <input name="name" type="text" value=""></p>
                        
                        <p><label>Логин (email)</label>
                            <input name="email" type="email" value=""></p>
                        
                        <p><label>Новый пароль</label>
                            <input name="password" type="password" value="">
                            <input name="confirm_password" type="password" value=""></p>
                        </p>
                        
                        
                        
                   
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

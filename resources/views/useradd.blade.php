
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание пользователя</div>

                <div class="panel-body">
                      <form action="add" method="post">
                          
                          <p><label>ФИО</label><input type="text" value="" class="form-control" name="name"></p>
                          <p><label>Логин (email)</label><input type="email" value="" class="form-control" name="email"></p>
                          <p><label>Пароль</label><input type="text" value="" class="form-control" name="password"></p>
                          <p><label>Роль пользователя</label>
                              <select name="role_id" class="form-control">
                              @foreach(\App\Role::select()->get() as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>
                              
                              @endforeach
                              </select>
                          </p>
                          
                          <p><button class="btn btn-success">Создать пользователя</button>
                    {{ csrf_field() }}
                      </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

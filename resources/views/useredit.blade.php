
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">{{ $user->name }}</div>

                <div class="panel-body">
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $user->id }}" class="form-control" name="id"></p>
                          <p><label>ФИО</label><input type="text" value="{{ $user->name }}" class="form-control" name="name"></p>
                          <p><label>Логин (email)</label><input type="email" value="{{ $user->email }}" class="form-control" name="email"></p>
                          <p><label>Роль пользователя</label>
                              <select name="role_id" class="form-control">
                              @foreach(\App\Role::select()->get() as $role)
                              @if ($role->id == $user->role_id) <option value="{{$role->id}}" selected>{{$role->name}}</option>
                              @else <option value="{{$role->id}}">{{$role->name}}</option>
                              @endif
                              @endforeach
                              </select>
                          </p>
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
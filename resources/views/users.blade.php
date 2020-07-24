
@extends('layouts.app')

@section('content')

    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Пользователи</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('user/add')}}" class="btn btn-success">Добавить пользователя</a></p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead class="">
                            <tr><td>id</td><td>Имя пользователя</td><td>Роль</td><td>Подразделение</td><td>Email</td><td>Создан</td><td>Операции</td></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\User::select()->get() as $user)
                            <tr class="">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->department->name or 'не указано' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td><center><a href="{{url('/')}}/user/{{$user->id}}/edit"><i class="fa fa-edit fa-2x"></i></a>
                                    
                                </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

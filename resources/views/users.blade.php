
@extends('layouts.app')

@section('content')

    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Пользователи</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)
                    <p><a href="{{url('user/add')}}" class="btn btn-success">Добавить пользователя</a></p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead class="">
                            <tr><td>id</td><td>Имя пользователя</td>
                                
                                <td>Роль</td>
                                <td>Договоры</td>
                                <td>Категория в табеле</td>
                                <td>Подразделение</td><td>Email</td><td>Создан</td><td>Операции</td></tr>
                        </thead>
                        <tfoot>
                        <tr class="">
                           <td>id</td>
                          <td class='filter'>Имя пользователя</td>
                          
                          <td>Договоры</td>
                          <td>Категория в табеле</td>
                          <td>Роль</td>
                           <td class='filter'>Подразделение</td>
                           <td>Email</td>
                           <td>Создан</td>
                           <td>Операции</td>
                        </tr>   
                        </tfoot>
                        
                        <tbody>
                            @foreach(\App\User::select()->get() as $user)
                            <tr class="">
                                <td>{{ $user->id }}
                                     
                                </td>
                                <td>{{ $user->name }} <!--<a href="login">Войти</a>--></td>
                                <td>{{ $user->role->name }}
                                @if($user->freelance)
                                (по договору)
                                @endif
                                </td>
                                
                                <td>
                                    @foreach($user->contracts as $contract)
                                    {{$contract->name}} от {{ $contract->date }}
                                    @endforeach
                                </td>
                                <td>{{$user->staff}}</td>
                                
                                <td>{{ $user->department->name or 'не указано' }}</td>
                                <td>@if ($user->role_id <=3)
                                    {{ $user->email }}
                                    @else
                                    <span style="color: #843534">скрыто</span>                                    
                                    @endif
                                
                                </td>
                                <td>{{ $user->created_at }}</td>
                                
                                <td>
                                    @if(in_array(Auth::user()->role_id, [3, 4, 6]))
                                   <a href="{{url('/')}}/user/{{$user->id}}/edit" title='Редактировать детали'><i class="fa fa-edit fa-2x"></i></a>
                                        @if($user->role_id == 2)
                                        <a href="{{url('/')}}/login_as/{{$user->id}}" title='Войти от имени этого пользователя'><i class="fa fa-user fa-2x"></i></a>
                                        @endif
                                    @else
                                    -
                                    @endif
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

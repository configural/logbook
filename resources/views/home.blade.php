@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Панель управления</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role_id == 4) 
                    <strong>Приветствую тебя, Администратор!</strong>
                    <p>
                    
                        <div class="icon"><a href="{{url('/')}}/users"><i class="fa fa-user fa-3x"></i><br/>Пользователи</a></div>
                        <div class="icon"><a href="{{url('/')}}/disciplines"><i class="fa fa-book fa-3x"></i><br/>Дисциплины</a></div>
                        <div class="icon"><i class="fa fa-graduation-cap fa-3x"></i><br/>Учебные планы</div>
                        <div class="icon"><i class="fa fa-users fa-3x"></i><br/>Потоки</div>
                        <div class="icon"><i class="fa fa-users fa-3x"></i><br/>Группы</div>
                </p>
                    @elseif (Auth::user()->role_id == 3)
                    <strong>Приветствую тебя, Методист!</strong>
                    

                        
                        
                    @elseif (Auth::user()->role_id == 2)
                    <strong>Приветствую тебя, Преподаватель!</strong>
                    
                    
                    @elseif (Auth::user()->role_id == 1)
                    <strong>Приветствую тебя, Слушатель!</strong>
                    @endif

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

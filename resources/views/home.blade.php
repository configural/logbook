@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                    <h3>Администрирование</h3>
                    <hr>
                    
                        <div class="icon"><a href="{{url('/')}}/users"><i class="fa fa-user fa-3x red"></i><br/>Пользователи системы</a></div>
                        <div class="icon"><a href="{{url('/')}}/departments"><i class="fa fa-graduation-cap fa-3x blue"></i><br/>Кафедры</a></div>
                        <div class="icon"><a href="{{url('/')}}/programs"><i class="fa fa-graduation-cap fa-3x orange"></i><br/>Образовательные программы</a></div>

                        <div class="icon"><a href="{{url('/')}}/disciplines"><i class="fa fa-book fa-3x green"></i><br/>Дисциплины</a></div>
                        <div class="icon"><a href="{{url('/')}}/streams"><i class="fa fa-users fa-3x blue"></i><br/>Потоки, группы, слушатели</a></div>
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                        <div class="icon"><a href="{{url('/')}}/rasp"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                        <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        <div class="icon"><a href="{{url('/')}}/classrooms"><i class="fa fa-building fa-3x blue"></i><br/>Аудитории</a></div>
                        

                </p>
                <h3>Отчеты и документы</h3>
                <hr>
                        <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                        <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Печать расписания</a></div>
                <h3>
               {{--     Справочники</h3>
                <hr>
                        <div class="icon"><a href="{{url('/')}}/districts"><i class="fa fa-list fa-3x orange"></i><br/>Округа</a></div>
                        <div class="icon"><a href="{{url('/')}}/taxoffices"><i class="fa fa-list fa-3x orange"></i><br/>Области</a></div>
                        <div class="icon"><a href="{{url('/')}}/divisions"><i class="fa fa-list fa-3x orange"></i><br/>Инспекции</a></div>
                        <div class="icon"><a href="{{url('/')}}/positions"><i class="fa fa-list fa-3x orange"></i><br/>Должности</a></div>
--}}
                    @elseif (Auth::user()->role_id == 3)
                    <strong>Приветствую тебя, Методист!</strong>
                    <h3>Администрирование</h3>
                        <div class="icon"><a href="{{url('/')}}/streams"><i class="fa fa-users fa-3x blue"></i><br/>Потоки, группы, слушатели</a></div>                    
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                         <div class="icon"><a href="{{url('/')}}/rasp"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                
                         <h3>Отчеты и документы</h3>
                        <hr>
                        <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                        <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Печать расписания</a></div>
                        
                        
                    @elseif (Auth::user()->role_id == 2 )
                    <strong>Преподаватель</strong>
                    <p>
                        @if (Auth::user()->freelance == 0)
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                        @endif
                        
                        <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        
                        

                </p>
                    
                    @elseif (Auth::user()->role_id == 1)
                    <strong>Приветствую тебя, Слушатель!</strong>
                    
                    @elseif (Auth::user()->role_id == 5)
                    <strong>Здравствуйте, {{Auth::user()->name}}!</strong>
                    <h3>Преподавательская деятельность</h3>
                    <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>    
                    <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Мой журнал</a></div>
                    
                    <h3>Контроль и мониторинг</h3>
                    <hr>
                    <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                    <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание</a></div>
                
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

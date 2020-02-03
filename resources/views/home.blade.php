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
                    
                        <div class="icon"><a href="{{url('/')}}/users"><i class="fa fa-user fa-3x red"></i><br/>Пользователи системы</a></div>
                        <div class="icon"><a href="{{url('/')}}/disciplines"><i class="fa fa-book fa-3x green"></i><br/>Дисциплины</a></div>
                        <div class="icon"><a href="{{url('/')}}/programs"><i class="fa fa-graduation-cap fa-3x orange"></i><br/>Образовательные программы</a></div>
                        <div class="icon"><a href="{{url('/')}}/streams"><i class="fa fa-users fa-3x blue"></i><br/>Потоки, группы, слушатели</a></div>
                        <div class="icon"><a href="{{url('/')}}/timetable"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                </p>
                    @elseif (Auth::user()->role_id == 3)
                    <strong>Приветствую тебя, Методист!</strong>
                    

                        
                        
                    @elseif (Auth::user()->role_id == 2)
                    <strong>Приветствую тебя, Преподаватель!</strong>
                    
                     <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x blue"></i><br/>Распределение нагрузки</a></div>
                     <div class="icon"><a href="{{url('/')}}/webinars"><i class="fa fa-video-camera fa-3x orange"></i><br/>Вебинары</a></div>
                     <div class="icon"><a href="{{url('/')}}/testing"><i class="fa fa-check fa-3x green"></i><br/>Тесты</a></div>
                    
                    <p>Распределение нагрузки</p>
                    <p>Назначенные занятия:</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>Дата, время</th>
                            <th>Группа</th>
                            <th>Тема</th>
                            <th>Часы (лекции/практика)</th>
                            <th>Выполнено (лекции/практика)</th>
                            <th>Операции</th>
                            <th>Статус</th>
                        </tr>
                    @foreach(\App\Timetable::select()->where('teacher_id', Auth::user()->id)->get() as $timetable)
                    <tr>
                    <td>{{ $timetable->start_at}}</td>
                    <td>{{ $timetable->group->name }}</td>
                    <td><strong>{{ $timetable->block->discipline->name }}</strong><br/>Тема:  {{ $timetable->block->name }}</td>
                    <td>{{ $timetable->block->l_hours }} / {{ $timetable->block->p_hours }}</td>
                    <td>{{ $timetable->journal->l_hours }} / {{ $timetable->journal->p_hours }}</td>
                    <td><a href="{{url('/')}}/journal/{{ $timetable->id}}">В журнал</a></td>
                    <td>
                        @if ($timetable->block->l_hours == $timetable->journal->l_hours and $timetable->block->p_hours == $timetable->journal->p_hours)
                        Выполнено
                        @else
                        Не выполнено
                        @endif
                        
                    </td>
                    </tr>
                    @endforeach
                    </table>
                    
                    @elseif (Auth::user()->role_id == 1)
                    <strong>Приветствую тебя, Слушатель!</strong>
                    @endif

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

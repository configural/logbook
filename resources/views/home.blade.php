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
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                        <div class="icon"><a href="{{url('/')}}/rasp"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                        <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        <div class="icon"><a href="{{url('/')}}/classrooms"><i class="fa fa-building fa-3x blue"></i><br/>Аудитории</a></div>
                        

                </p>
                    @elseif (Auth::user()->role_id == 3)
                    <strong>Приветствую тебя, Методист!</strong>
                    

                        
                        
                    @elseif (Auth::user()->role_id == 2 )
                    <strong>Приветствую тебя, Преподаватель!</strong>
                    
                     <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x blue"></i><br/>Распределение нагрузки</a></div>
                     
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
                    @if (isset($timetable))
                    <tr>
                    <td>{{ $timetable->start_at}}</td>
                    <td>{{ $timetable->group->name }}</td>
                    <td><strong>{{ $timetable->block->discipline->name }}</strong><br/>Тема:  {{ $timetable->block->name }}</td>
                    <td>@if (isset($timetable->block->l_hours)) {{ $timetable->block->l_hours }} @endif / 
                        @if (isset($timetable->block->p_hours)) {{ $timetable->block->p_hours }} @endif </td>
                    <td>@if (isset($timetable->journal->l_hours)) {{ $timetable->journal->l_hours }} @endif / 
                        @if (isset($timetable->journal->p_hours)) {{ $timetable->journal->p_hours }} @endif</td>
                    <td>@if (isset($timetable->id)) <a href="{{url('/')}}/journal/{{ $timetable->id}}">В журнал</a> @endif</td>
{{--                    <td>@if (isset($timetable->block) and (isset($timetable->block)))
                        @if ($timetable->block->l_hours == $timetable->journal->l_hours and $timetable->block->p_hours == $timetable->journal->p_hours)
                        OK
                        @else
                        -
                        @endif
                        @endif
                    </td>--}}
                    </tr>
                    @endif
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

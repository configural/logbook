@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Расписание</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role_id == 4) 
                    <strong>Приветствую тебя, Администратор!</strong>
                    
                    <p>
                    <table class='table table-bordered'>
                        <tr>
                            <th>id</th>
                            <th>Дата, время</th>
                            <th>Группа</th>
                            <th>Преподаватель</th>
                            <th>Аудитория</th>
                            <th>Часы</th>
                            <th>Дисциплина / Тема</th>

                        </tr>
                        @foreach(\App\Timetable::select()->get() as $timetable)
                    <tr>
                    <td>{{$timetable->id}}</td>
                        <td>{{$timetable->start_at}}</td>
                        <td>{{$timetable->group->name}}</td>
                        <td>{{$timetable->teacher->name}}</td>
                        <td>{{$timetable->room_id}}</td>
                        <td>{{$timetable->hours}}</td>
                        <td>{{$timetable->block->discipline->name}}<br/><small>{{$timetable->block->name}}</small></td>
                        
                </tr>
                        @endforeach
                    </table>
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

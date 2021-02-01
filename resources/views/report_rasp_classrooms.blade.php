@php
if (isset($_GET["date"]))
    {$date = $_GET["date"];}
    else 
    {$date = date('Y-m-d');}

@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Занятость аудиторий</div>

                <div class="panel-body">
                    
                    <form method="get">
                         
                        <input type="date" name="date" value="{{ date('Y-m-d')}}" class="form-control-static">   
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                    </form>
                    <p></p>
                        <table id='sortTable'>
                            <thead>
                                <tr>
                            <td>Ауд.</td>
                            <td>Время</td>
                            <td>Поток</td>
                            <td>Группа</td>
                            <td>Преподавател(и)</td>
                            <td>Методист</td>
                                </tr>
                            
                            </thead>
                            <tbody>
                    @foreach(\App\Rasp::where('date', $date)->get() as $rasp)
                    <tr>
                        <td><nobr>{{$rasp->classroom->name}}</nobr></td>
                        <td><nobr>{{ @str_limit($rasp->start_at, 5, '')}} – {{@str_limit($rasp->finish_at, 5, '')}}</nobr></td>
                        <td><nobr>{{$rasp->timetable->group->stream->name}}</nobr></td>
                        <td>{{$rasp->timetable->group->name}}</td>
                        <td>
                            @foreach($rasp->timetable->teachers as $teacher) 
                            {{$teacher->secname() or ''}}
                            @endforeach
                        </td>
                        <td>{{ $rasp->timetable->group->stream->metodist->secname() or ''}}</td>
                        
                    
                    
                    </tr>
                    
                    @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

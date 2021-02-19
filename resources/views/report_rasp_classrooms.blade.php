@php
if (isset($_GET["date"]))
    {$date = $_GET["date"];}
    else 
    {$date = date('Y-m-d');}

$tmp_class = "";
    
    @endphp



@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Занятость аудиторий</div>

                <div class="panel-body">
                    
                    <form method="get">
                         
                        <input type="date" name="date" value="{{ $date }}" class="form-control-static" onchange="this.form.submit()">   
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                    </form>
                    <p></p>
                        <table id='sortTable'>
                            <thead>
                                <tr>
                            
                            <td>Время</td>
                            <td>Поток</td>
                            <td>Группа</td>
                            <td>Преподавател(и)</td>
                            <td>Методист</td>
                                </tr>
                            
                            </thead>
                            <tbody>
                    @foreach(\App\Rasp::where('date', $date)->where('room_id', '!=', NULL)->orderby('room_id')->get() as $rasp)
                    
                    @if ($tmp_class != $rasp->classroom->name)
                    @php ($tmp_class = $rasp->classroom->name)
                    <tr><th><br/><nobr>{{$rasp->classroom->name}}</nobr></th></tr>
                        
                    @endif
                    <tr>
                        
                        <td><nobr>{{ @str_limit($rasp->start_at, 5, '')}} – {{@str_limit($rasp->finish_at, 5, '')}}</nobr></td>
                        <td><nobr>{{$rasp->timetable->group->stream->name or ''}}</nobr></td>
                        <td>{{$rasp->timetable->group->name or ''}}</td>
                        <td>
                            @foreach($rasp->timetable->teachers as $teacher) 
                            @if ($teacher)
                            {{$teacher->fio() }}
                            @else
                            n/a
                            @endif
                            @endforeach
                        </td>
                        <td>@if ($rasp->timetable->group->stream->metodist)
                            {{ $rasp->timetable->group->stream->metodist->secname() }}
                            @else
                            n/a
                            
                            @endif
                        </td>
                        
                    
                    
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

@php
session_start();
$_SESSION["work_with"] = "rasp";
@endphp

@extends('layouts.app')

@section('content')



<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action='rasp' method='get'>
                        Составление расписания <input type="date" name="date" value="{{$date}}" onchange="javascript:form.submit()" >
                        <a href="{{route('print_rasp')}}/{{$date}}">Печать расписания</a>
                    </form>
                </div>

                <div class="panel-body">

                    @if(in_array(Auth::user()->role_id, [2,3,4,6]))
 
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <th>Аудитория</th>
                        <th>Занятия</th>
                        </thead>
                        <tbody>    
                    @foreach(\App\Classroom::select()->orderby('name')->where('capacity', '!=', 0)->get() as $room)
                    <tr>
                        <td width="20%"><h3>{{$room->name}}</h3>{{$room->capacity}} мест
                        @if(in_array( Auth::user()->role_id, [4, 3]))
                            <p>
                        @if($blockedBy = \App\Classroom::is_blocked($date, $room->id))
                        <i class='fa fa-lock'></i> {{\App\User::find($blockedBy)->name }} 
                        <br><a href="{{url('room_unlock')}}/{{$date}}/{{$room->id}}">Снять блокировку</a></br>
                        @else
                        <a href="{{url('raspadd')}}/{{ $date }}/{{$room->id}}">Назначить занятие</a>
                        @endif
                        </p>
                        @endif
                        </td>
                        <td><!--вывод строк расписания-->
                            <table class='table table-borderless'>
                            @php($start = 0)
                            @php($finish = 0)
                            
                            @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room->id)->orderBy('start_at')->get() as $rasp)                            
                            <tr><td width='20%'>
                                @if($start != $rasp->start_at) 
                                {{$rasp->start_at}}–{{$rasp->finish_at}}
                                @endif
                                </td>
                            @php($start = $rasp->start_at)
                            @php($finish = $rasp->finish_at)    
                             
                        <td width='40%'>   {{$rasp->timetable->lesson_type->name or 'Нет данных' }}:  {{$rasp->timetable->block->name or ''}}</td>
                         <td width='15%'>Группа: {{$rasp->timetable->group->name or ''}}</td>
                            <td width='15%'>
                            @if($rasp->timetable)
                                @foreach($rasp->timetable->teachers as $teacher)
                            <nobr>{{$teacher->fio() }} 
                            
                            @if($j = \App\Journal::where('rasp_id', $rasp->id)->where('teacher_id', $teacher->id)->count())
                            
                            <a href="{{ url('/')}}/reports/journal/view/{{ \App\Journal::where('rasp_id', $rasp->id)->where('teacher_id', $teacher->id)->first()->id }}"><i class="fa fa-list red" title="Журнал создан!"></i></a>
                            @endif
                            
                            </nobr><br>
                            
                            @endforeach
                            @endif
                            </td>
                            <td width='10%'>
                                @if(in_array(Auth::user()->role_id, [3, 4] ))
                                <p><a href="{{url('rasp')}}/edit/{{$rasp->id}}">Изменить</a></p>
                                <p><a href="{{url('rasp')}}/delete/{{$rasp->id}}"  onClick="return window.confirm('Действительно удалить?');" >Удалить</a></p>
 
                            </td>
                                @endif
                            @endforeach</tr>
                    
                            </table>
                            <!--/ вывод строк расписания-->
                        </td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
                
                
<script>

var $window = $(window)
/* Restore scroll position */
window.scroll(0, localStorage.getItem('scrollPosition')|0)
/* Save scroll position */
$window.scroll(function () {
    localStorage.setItem('scrollPosition', $window.scrollTop())
})


</script>
@endsection

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
                    <form action='raspview' method='get'>
                        Общее расписание <input type="date" name="date" value="{{$date}}" onchange="javascript:form.submit()" >
                        
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id)
 
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <th>Аудитория</th>
                        <th>Занятия</th>
                        </thead>
                        <tbody>    
                    @foreach(\App\Classroom::select()->orderby('name')->get() as $room)
                    <tr>
                        <td width="20%"><h3>{{$room->name}}</h3>
                            {{$room->address}}
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
                             
                        <td width='40%'>   {{$rasp->timetable->lesson_type->name or 'n/a' }}:  {{$rasp->timetable->block->name or 'n/a'}}</td>
                         <td width='15%'>{{$rasp->timetable->group->name or ''}}</td>
                            <td width='15%'>@foreach($rasp->timetable->teachers as $teacher)
                            {{$teacher->fio() }}
                            @endforeach</td>

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

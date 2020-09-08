
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action='rasp' method='get'>
                        Составление расписания <input type="date" name="date" value="{{$date}}" onchange="javascript:form.submit()" >
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id >= 3)
 
                    <table class="table table-bordered">
                     
                    @foreach(\App\Classroom::select()->orderby('name')->get() as $room)
                    <tr>
                        <td width="20%"><h3>{{$room->name}}</h3>{{$room->capacity}} мест
                        <p>
                        @if($blockedBy = \App\Classroom::is_blocked($date, $room->id))
                        <i class='fa fa-lock'></i> {{\App\User::find($blockedBy)->name   }}
                        <br><a href="{{url('room_unlock')}}/{{$date}}/{{$room->id}}">Снять блокировку</a></br>
                        @else
                        <a href="{{url('raspadd')}}/{{ $date }}/{{$room->id}}">Назначить занятие</a>
                        @endif
                        </p>
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
                            {{$teacher->name}}
                            @endforeach</td>
                            <td width='10%'><!--<a href="{{url('rasp')}}/edit/{{$rasp->id}}">Изменить</a>&nbsp;-->
                                <a href="{{url('rasp')}}/delete/{{$rasp->id}}" >Отменить</a></td>
                            @endforeach</tr>
                    </table>
                            <!--/ вывод строк расписания-->
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action='rasp' method='get'>
                    Составление расписания <input type="date" name="date" value="{{$date}}"> <button> >></button>
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id == 4)
 
                    <table class="table table-bordered">
                    @foreach(\App\Classroom::select()->get() as $room)
                    <tr>
                        <td width="20%">{{$room->name}}
                        <p><a href="{{url('raspadd')}}/{{ $date }}/{{$room->id}}">Назначить занятие</a></p>
                        </td>
                        <td><!--вывод строк расписания-->
                            <table class='table table-borderless'>
                            @php($start = 0)
                            @php($finish = 0)
                            
                            @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room->id)->orderBy('start_at')->get() as $rasp)                            
                            <tr><td width='20%'>@if($start != $rasp->start_at) {{$rasp->start_at}}–{{$rasp->finish_at}}
                                @endif
                                </td>
                            @php($start = $rasp->start_at)
                            @php($finish = $rasp->finish_at)    
                                
                        <td width='40%'>   {{$rasp->timetable->lessontype}}:  {{$rasp->timetable->block->name}}</td>
                         <td width='15%'>{{$rasp->timetable->group->name}}</td>
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

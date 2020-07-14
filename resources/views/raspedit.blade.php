
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                    <form >
                        Редактирование строки расписания
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id == 4)
                    <form action="" method="post">
                        <input name="id" type="hidden" value="{{$rasp->id}}">
                        <p>
                        Дата:<br/> <input name="date" type="date" value="{{$rasp->date}}" class="form-control-static">
                        </p>
                        <p>
                           Аудитория занята:
                           @php ($i = 0)
                           @foreach(\App\Rasp::select()->where('date', $rasp->date)->where('room_id', $rasp->room_id)->orderby('start_at')->get() as $rasp)
                           <br/>
                           <span class="red">{{$rasp->start_at}} – {{$rasp->finish_at}}</span>
                           @php ($i++)
                           @endforeach
                           @if ($i == 0) 
                           свободна весь день!
                           @endif
                           
                       </p>
                        <p>Время:<br/>
                            <input type="time" name="start_at" value="{{$rasp->start_at}}" class="form-control-static" required>
                            <input type="time" name="finish_at" value="{{$rasp->finish_at}}" class="form-control-static" required>
                        </p>
                        <p>Аудитория:
                            <select name="room_id" class="form-control">
                            @foreach(\App\Classroom::select()->get() as $room)
                            @if($room->id == $rasp->room_id) 
                            <option value="{{$room->id}}" selected>{{$room->name}} :: {{$room->address}}</option>
                            @else
                            <option value="{{$room->id}}">{{$room->name}} :: {{$room->address}}</option>
                            @endif
                            @endforeach
                            </select>
                            
                        <p>Занятие (из распределенной нагрузки):
                            
                            <select name="timetable_id" class="form-control">
                                
                            @foreach(\App\Timetable::select()->whereNull('rasp_id')->orWhere('id', $rasp->timetable_id)->get() as $timetable)
                            @foreach($timetable->teachers as $teacher)
                            <option value="{{$timetable->id}}">л{{$timetable->block->l_hours}}/п{{$timetable->block->p_hours}} {{$timetable->group->name}} :: {{$timetable->block->name}}
                            </option>
                            @endforeach
                            @endforeach
                            </select>
                        </p>
                        {{csrf_field()}}
                        <button class="btn btn-success">Сохранить</button>
                    </form>
                    <p><a href="{{url('rasp')}}/delete/{{$rasp->id}}">Удалить это занятие из расписания</a></p>
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

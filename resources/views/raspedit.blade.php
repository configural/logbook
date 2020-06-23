
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
                        
                        Дата: <input name="date" type="date" value="{{$rasp->date}}" class="form-control">
                        
                        <p>Пара:
                            <select name="pair_id" class="form-control">
                                @foreach(\App\Pair::select()->get() as $pair)
                                @if($pair->id == $rasp->pair_id)
                                <option value="{{$pair->id}}" selected>{{$pair->name}} ({{$pair->variant0}}, {{$pair->variant1}}, {{$pair->variant2}}, {{$pair->variant3}})</option>
                                @else
                                <option value="{{$pair->id}}">{{$pair->name}} ({{$pair->variant0}}, {{$pair->variant1}}, {{$pair->variant2}}, {{$pair->variant3}})</option>
                                @endif
                                @endforeach
                            </select>
                            
                        </p>
                        
                        <p>Время:
                            <input type="text" name="interval" value="{{$rasp->interval}}" class="form-control">
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
                            @foreach(\App\Timetable::select()->whereNotNull('teacher_id')->get() as $timetable)
                            @if($timetable->id == $rasp->timetable_id)
                            <option value="{{$timetable->id}}" selected>{{$timetable->teacher->name}} :: {{$timetable->group->name}} :: {{$timetable->block->name}}</option>
                            @else
                            <option value="{{$timetable->id}}">{{$timetable->teacher->name}} :: {{$timetable->group->name}} :: {{$timetable->block->name}}</option>
                            @endif
                            @endforeach
                            </select>
                        </p>
                        {{csrf_field()}}
                        <button class="btn btn-success">Сохранить</button>
                    </form>
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

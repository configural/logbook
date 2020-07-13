
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
                    <form action="{{url('raspedit')}}/0" method="post">
                        <input name="id" type="hidden" value="">
                        
                        Дата: <input name="date" type="date" value="{{$date}}" class="form-control-static">
                        
                        
  
                        </p>
                        
                        <p>Время:

                        </p>
                       <input name="room_id" type="hidden" value="{{$room}}">
                       
                       Свободные пары:
                       <select name="pair_id" class="form_control">
                       @php ($busy = Array())
                       @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room)->get() as $rasp)
                       @php ($busy[] = $rasp->pair_id)
                       @endforeach
                       @foreach(\App\Pair::select()->whereNotIn('id', $busy)->get() as $pair)
                       <option value="{{$pair->id}}">{{$pair->id}}</option>
                       @endforeach
                       </select>
                                                        
                        <p>Занятие (из распределенной нагрузки):
                            
                            <select name="timetable_id" class="form-control" required>
                                
                            @foreach(\App\Timetable::select()->whereNull('rasp_id')->get() as $timetable)
                            
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
                   
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

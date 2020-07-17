
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
                    <form action="{{url('rasp/edit')}}/0" method="post">
                        <input name="id" type="hidden" value="">
                        
                        Дата: <input name="date" type="date" value="{{$date}}" class="form-control-static">
                        
                        
  
                        </p>
                        

                       <input name="room_id" type="hidden" value="{{$room}}">
                       <p>
                           Аудитория занята:
                           @php ($i = 0)
                           @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room)->orderby('start_at')->get() as $rasp)
                           <br/><span class="red">{{$rasp->start_at}} – {{$rasp->finish_at}}</span>
                           @php ($i++)
                           @endforeach
                           @if ($i == 0) 
                           свободна весь день!
                           @endif
                           
               
                        <p>Занятие (из распределенной нагрузки):
                            
                            <select name="timetable_id" class="form-control" required>
                            @foreach(\App\Timetable::select()->whereNull('rasp_id')->orderBy('block_id')->orderBy('lessontype')->get() as $timetable)
                            
                            @foreach($timetable->teachers as $teacher)
                            <option value="{{$timetable->id}}">{{$timetable->hours}} ч ({{$timetable->lessontype}}) :: {{$timetable->group->name}} :: {{$timetable->block->name}} ({{$teacher->name}})
                            </option>
                            @endforeach
                            @endforeach
                            </select>
                           
                       </p>
                       <p>Время занятий:<br/>
                       <input type="time" name="start_at" class="form-control-static" required>
                       <input type="time" name="finish_at" class="form-control-static" required>
                       </p>                            
                           
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

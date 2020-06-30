
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
                        
                        <p><input name="pair_id" type="hidden" value="{{$pair}}">
  
                        </p>
                        
                        <p>Время:
                            <select name="interval" class='form-control-static'>
                            @php ($p = \App\Pair::find($pair))
                            <option value='{{$p->variant0}}'>{{$p->variant0}}</option>
                            <option value='{{$p->variant1}}'>{{$p->variant1}}</option>
                            <option value='{{$p->variant2}}'>{{$p->variant2}}</option>
                            <option value='{{$p->variant3}}'>{{$p->variant3}}</option>
                            </select>
                        </p>
                       <input name="room_id" type="hidden" value="{{$room}}">
                       
                       
                                                        
                        <p>Занятие (из распределенной нагрузки):
                            
                            <select name="timetable_id" class="form-control">
                                
                            @foreach(\App\Timetable::select()->whereNotNull('teacher_id')->whereNull('rasp_id')->get() as $timetable)
                            <option value="{{$timetable->id}}">{{$timetable->teacher->name}} :: {{$timetable->group->name}} :: {{$timetable->block->name}}</option>
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

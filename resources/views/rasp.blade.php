
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
                    
                    
                    
                    
                    
                    
                    <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                           @foreach(\App\Pair::select()->get() as $pair)
                           <div class="col-md-2">{{$pair->name}}</div>
                           @endforeach
                           
                            
                    </div>
                    </div>
                    
                    @foreach(\App\Classroom::select()->get() as $room)
                    <div class="container">
                    <div class="row">
                    
                    <div class="col-lg-2">{{$room->name}}</div>
                        @foreach(\App\Pair::select()->get() as $pair)
                        
                        <div class="col-lg-2">
                            @foreach(\App\Rasp::select()->where('room_id', $room->id)->where('pair_id', $pair->id)->where('date', $date)->get() as $rasp)
                            @if ($rasp->id)
                            
                            <div class="rasp">{{$rasp->interval}}
                                <small title='группа'>{{$rasp->timetable->group->name or 'нет группы'}}</small> 
                                <small title='тема'><strong>{{$rasp->timetable->block->name or 'нет темы'}}</strong></small>
                                <small title='тема'><strong>{{$rasp->timetable->block->l_hours or 'нет лекций'}}</strong></small>
                                <small title='тема'><strong>{{$rasp->timetable->block->p_hours or 'нет лекций'}}</strong></small>
                                <small title='препод'>({{$rasp->timetable->teacher->name or 'нет препода'}})</small> 
                                <br/><a href="{{url('raspedit')}}/{{$rasp->id}}">изменить</a>
                            </div>

 
                            
                            @else
                            <div class="col-lg-2" style="border:1px solid blue;">-</div>
                            @endif
                            @endforeach
                                @if (\App\Timetable::whereNotNull('teacher_id')->whereNull('rasp_id')->count()) 
                                <p><a href="{{url('raspadd')}}/{{$date}}/{{$room->id}}/{{$pair->id}}">Назначить</a></p>
                                @endif
                        
                        </div>
                            


                                
                        @endforeach
                    </div>
                    </div><hr>
                    @endforeach                        
                           
                    </div>

      
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


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
                        <tr><td></td>
                           @foreach(\App\Pair::select()->get() as $pair)
                           <td width='20%'>{{$pair->name}}</td>
                           @endforeach
                           
                            
                        </tr>
                    
                    @foreach(\App\Classroom::select()->get() as $room)
                    <tr><td>{{ $room->name}}</td>

                        @foreach(\App\Pair::select()->get() as $pair)
                        <td>
                            @foreach(\App\Rasp::select()->where('room_id', $room->id)->where('pair_id', $pair->id)->where('date', $date)->get() as $rasp)
                            <div class="rasp">{{$rasp->interval}}
                                <small title='группа'>{{$rasp->timetable->group->name or 'нет группы'}}</small> 
                                <small title='тема'><strong>{{$rasp->timetable->block->name or 'нет темы'}}</strong></small>
                                <small title='препод'>({{$rasp->timetable->teacher->name or 'нет препода'}})</small> 
                                <br/><a href="{{url('raspedit')}}/{{$rasp->id}}">изменить</a>
                            </div>
                            @endforeach
                            
                                @if (\App\Timetable::whereNotNull('teacher_id')->whereNull('rasp_id')->count()) 
                                <p><a href="{{url('raspadd')}}/{{$date}}/{{$room->id}}/{{$pair->id}}">Назначить</a></p>
                                @endif
                        </td>
                        @endforeach

                    @endforeach                        
                    
                    
                    
                    </tr>        
                    

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


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
                            <p><a href="{{url('raspedit')}}/{{$rasp->id}}">{{$rasp->interval}}</a> 
                                <small class='red' title='препод'>{{$rasp->timetable->teacher->name}}</small>  - 
                                <small class='blue' title='группа'>{{$rasp->timetable->group->name}}</small> - 
                                <small title='тема'><strong>{{$rasp->timetable->block->name}}</strong></small>
                            </p>
                            @endforeach
                            <p><a href="{{url('raspadd')}}/{{$date}}/{{$room->id}}/{{$pair->id}}">Назначить</a></p>
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

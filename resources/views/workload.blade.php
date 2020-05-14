
@extends('layouts.app')

@section('content')
<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-6">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Нераспределенная нагрузка</div>

                    <div class="panel-body">
                        
                        <div id="allWorkload"></div>
                        <table class="table table-bordered">
                            <tr>
                                <th>Кто и когда</th>
                                <th>Дисциплина, тема, часы</th>
                                <th>Взять нагрузку</th>
                            </tr>
                        @foreach(\App\Timetable::select()->where('teacher_id', 0)->get() as $timetable)
                        <tr>
                            <td>{{$timetable->group->stream->name}} / 
                                {{$timetable->group->name}}<br>
                                {{$timetable->group->stream->date_start}}—
                                {{$timetable->group->stream->date_finish}}<br>
                            </td>
                            <td><small><strong>{{ $timetable->block->discipline->name }}</strong><br/>{{ $timetable->block->name }}<br/>
                            Лекции – {{ $timetable->block->l_hours }} ч, практика – {{ $timetable->block->p_hours }} ч.
                            
                            </td>
                            <td><a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Мое!</a></td>
                        </tr>
                        @endforeach
                        </table>
                    </div>

    
            </div>
 
        </div>

        
                <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading ">Моя нагрузка</div>

                <div class="panel-body">
                   
                    <div id="myWorkload"></div>
                    
                        <table class="table table-bordered">
                        @foreach(\App\Timetable::select()->where('teacher_id', Auth::user()->id)->get() as $timetable)
                        <tr>
                            <td><small><strong>{{ $timetable->block->discipline->name }}</strong><br/>{{ $timetable->block->name }}<br/>
                            Лекции – {{ $timetable->block->l_hours }} ч, практика – {{ $timetable->block->p_hours }} ч.
                            
                            </td>
                            <td><a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-success">Не мое!</a></td>
                        </tr>
                        @endforeach
                        </table>
                    
                    
                    
                </div>

            </div>
        </div>

    </div>

</div>
@endsection


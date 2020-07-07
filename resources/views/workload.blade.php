
@extends('layouts.app')

@section('content')
<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-12">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Нераспределенная нагрузка</div>

                    <div class="panel-body">
                        
                        <div id="allWorkload"></div>
                        <table class="table table-bordered">
                            <tr><th>id нагрузки</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема, часы</th>
                                <th>Преподавател(и)</th>
                                <th>Взять нагрузку</th>
                            </tr>
                        @foreach(\App\Timetable::select()->get() as $timetable)
                        <tr><td><a name="{{$timetable->id}}">{{$timetable->id}}</a></td>
                            <td>{{$timetable->group->stream->name}} / 
                                {{$timetable->group->name}}</td>
                            <td>{{$timetable->group->stream->date_start}}—
                                {{$timetable->group->stream->date_finish}}<br>
                            </td>
                            
                            <td><small><strong>{{ $timetable->block->discipline->name }}</strong><br/>{{ $timetable->block->name }}<br/>
                            Лекции – {{ $timetable->block->l_hours }} ч, практика – {{ $timetable->block->p_hours }} ч.
                            
                            </td>
                            <td>@php ($i = 0)
                                @foreach($timetable->teachers as $teacher)
                                {{$teacher->name}}
                                @if($teacher->id == Auth::user()->id)
                                @php ($i++)
                                @endif
                                @endforeach
                                
                            </td>
                            <td>
                                @if($i == 0)
                                <a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Мое!</a></td>
                                @endif
                        </tr>
                        @endforeach
                        </table>
                    </div>

    
            </div>
 
        </div>

        
                <div class="col-md-12">
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
                            <td>
                                @if(!$timetable->rasp_id)
                                <a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-success">Не мое!</a>
                                @else
                                Внесено в расписание
                                @endif
                            </td>
                            
                        </tr>
                        @endforeach
                        </table>
                    
                    
                    
                </div>

            </div>
        </div>

    </div>

</div>
@endsection


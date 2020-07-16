
@extends('layouts.app')

@section('content')
<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-12">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Нераспределенная нагрузка</div>

                    <div class="panel-body">
                        
                        <div id="allWorkload"></div>
                        <table class="table table-bordered display" id="sortTable">
                            <thead><tr><th>id нагрузки</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Часы</th>
                                <th>Подгруппы?</th>
                                <th>Преподавател(и)</th>
                                <th>Взять нагрузку</th>
                                </tr></thead>
                                
                            <tfoot><tr><th>id нагрузки</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Часы</th>
                                <th>Подгруппы?</th>
                                <th>Преподавател(и)</th>
                                <th>Взять нагрузку</th>
                                </tr></tfoot>
                            <tbody>
                        @foreach(\App\Timetable::select()->get() as $timetable)
                        <tr><td><a href="workload/edit/{{$timetable->id}}" name="{{$timetable->id}}">{{$timetable->id}}</a></td>
                            <td>{{$timetable->group->stream->name}} / 
                                {{$timetable->group->name}}</td>
                            <td>{{$timetable->group->stream->date_start}}—
                                {{$timetable->group->stream->date_finish}}<br>
                            </td>
                            
                            <td><strong>{{ $timetable->block->name }}</strong><br/>
                                <small>{{ $timetable->block->discipline->name }}</small>
                                    
                            </td>
                            <td>{{ $timetable->hours }} ч, 
                            @if ($timetable->lessontype == 1)
                            лекция
                            @elseif ($timetable->lessontype == 2)
                            практика
                            @else
                            не определено
                            @endif
                            </td>
                            <td>
                                @if($timetable->lessontype == 2)
                                @if($timetable->subgroup)
                                Подгруппа {{$timetable->subgroup}}
                                @else
                                <a href="workload/split/{{$timetable->id}}">разделить на подгруппы</a>
                                @endif
                                @endif
                            </td>
                            <td>@php ($i = 0)
                                @foreach($timetable->teachers as $teacher)
                                <span class="badge btn-danger">{{$teacher->name}}</span>
                                @if($teacher->id == Auth::user()->id)
                                @php ($i++)
                                @endif
                                @endforeach
                                Месяц {{$timetable->month or 'не определен'}} 
                            </td>
                            <td>
                                @if($i == 0)
                                <a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Мое!</a></td>
                                @else
                                
                                <a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-danger">Не мое!</a></td>
                                @endif
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>

    
            </div>
 
        </div>

        
                
    </div>

</div>


@endsection


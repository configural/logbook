
@extends('layouts.app')

@section('content')
<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-12">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Нагрузка</div>

                    <div class="panel-body">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                            
                        </p>

                        <div id="allWorkload"></div>
                        <table class="table table-bordered display" id="sortTable">
                            <thead><tr><th>id</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Часы</th>
                                
                                <th>Преподавател(и)</th>
                                <th>Мес.</th>
                                <th>Взять нагрузку</th>
                                
                                </tr></thead>
                                
                            <tfoot><tr><th>id нагрузки</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Часы</th>
                                
                                <th>Преподавател(и)</th>
                                <th>Мес.</th>
                                <th>Взять нагрузку</th>
                                </tr></tfoot>
                            <tbody>
                        @foreach(\App\Timetable::select()->get() as $timetable)
                        <tr><td><a href="workload/edit/{{$timetable->id}}" name="{{$timetable->id}}">{{$timetable->id}}</a></td>
                            <td><nobr>{{$timetable->group->stream->name}}</nobr><br> 
                            <nobr>{{$timetable->group->name}}</nobr>
                        
                        
                         @if($timetable->lessontype == 2)
                                @if($timetable->subgroup)
                                Подгруппа {{$timetable->subgroup}}
                                @else
                                <a href="workload/split/{{$timetable->id}}">разделить на подгруппы</a>
                                @endif
                                @endif
                        
                        </td>
                            <td>{{$timetable->group->stream->date_start}}<br/>
                                {{$timetable->group->stream->date_finish}}<br>
                            </td>
                            
                            <td><strong>{{ $timetable->block->name or '' }}</strong><br/>
                                <small>{{ $timetable->block->discipline->name or '' }}</small>
                                @if($timetable->discipline_id) <span class='green'><strong>Аттестация</strong>
                                        {{ \App\Discipline::find($timetable->discipline_id)->name}}</span>
                                @endif

                                @if($timetable->program_id) 
                                <span class='red'><strong>Итоговая аттестация</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                            </td>
                            <td>{{ $timetable->hours }} ч<br/>
                            {{ $timetable->lesson_type->name or 'не определено'}}
                            </td>
  
                            <td>@php ($i = 0)
                                @foreach($timetable->teachers as $teacher)
                                <span class="green"><strong>{{$teacher->secname()}}</strong><br/></span>
                                @if($teacher->id == Auth::user()->id)
                                @php ($i++)
                                @endif
                                @endforeach
                                
                                
                            </td>
                            <td>
                                {{$timetable->month or ''}}
                            </td>
                            <td>
                                @if($timetable->rasp_id)
                                Назначено на:
                                <a href="{{url('rasp')}}?date={{$timetable->rasp->date or ''}}">{{$timetable->rasp->date or ''}}</a>
                                @else
                                @if($i == 0)
                                <a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Мое!</a>
                                
                            
                                @else
                                
                                <a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-danger">Не мое!</a>

                        @endif  
                        @endif

   
                        </td>
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    
                        <p>
                        <a href='workload/add' class='btn btn-success'>Создать элемент нагрузки вручную</a>
                        </p>
                    
                    </div>

    
            </div>
 
        </div>

        
                
    </div>

</div>


@endsection


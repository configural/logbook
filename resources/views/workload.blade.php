@extends('layouts.app')

@section('content')

@php
    session_start();
    if (isset($_GET["stream_id"])) {
        $stream_id = $_GET["stream_id"]; 
        $_SESSION["stream_id"] = $stream_id;
        } 
    elseif (isset($_SESSION["stream_id"])) {
        $stream_id = $_SESSION["stream_id"];}
    else
        { $stream_id = 0; }

    $_SESSION["work_with"] = "workload";
    $_SESSION["stream_id"] = $stream_id;

    //dump($stream_id);
    
@endphp 



<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-12">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">
                
                
                    Нагрузка

                
                </div>
                    <div class="panel-body">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                            
                        </p>

                        <h3>Выберите поток</h3>
                        <form method="get">
                        <p><select name='stream_id' class='form-control-static blue' onchange="form.submit()">
                                <option value=''>Выберите поток</option>
                        @foreach(\App\Stream::orderBy('date_start', 'desc')->where('active', 1)->get() as $stream)
                        @if ($stream->id == $stream_id)
                        <option value='{{ $stream->id }}' selected>({{ $stream->date_start}} — {{ $stream->date_finish}}) {{ $stream->name }}</option>
                        @else
                        <option value='{{ $stream->id }}'>({{ $stream->date_start}} — {{ $stream->date_finish}}) {{ $stream->name }}</option>
                        @endif
                        @endforeach
                        </select>
                        </form>
                        </p>
                        @if(in_array(Auth::user()->role_id, [3,4,6]))
                        <p>Вы методист и вам нужно распределить нагрузку по преподавателям. 
                            Это делается нажатием кнопки "Распределить". После этого указываем нужных преподавателей и жмем "Сохранить нагрузку". 
                            В расписание может быть включена только нагрузка с назначенным преподавателем(ями).
                            Если нужной нагрузки в таблице нет, создайте ее вручную:</p>
                        <p><a href='workload/add' class='btn btn-success'>Создать элемент нагрузки вручную</a></p>
                        @elseif(in_array(Auth::user()->role_id, [2]))
                        <p>    
                        Вы преподаватель? Ваша задача - разобрать учебную нагрузку. Для этого нажмимайте кнопку "Взять нагрузку" в таблице, после чего в этих темах появится ваша фамилия.
                        Также вы можете отказаться от ранее взятой нагрузки, если ее не успели включить в расписание, нажав кнопку "Отказаться". 
                        Одну строку нагрузки могут делить несколько преподавателей.
                        
                        Подсказка - таблицу можно сортировать, щелкая мышкой по заголовкам. Для сортировки по нескольким столбцам, щелкайте с нажатым Shift. 
                        Также можно фильтровать данные при помощи поля "Поиск" (справа над таблицей).
                        </p>
                        
                        @endif

                        
                        @if ($stream_id)
                        
                        <table class="table table-bordered display" id="sortTable">
                            <thead><tr><th>id</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Кафедра</th>
                                <th>Часы</th>
                                
                                <th>Преподавател(и)</th>
                               
                                <th>Действия</th>
                                
                                </tr></thead>
                                
                            <tfoot><tr><th>id нагрузки</th>
                                <th>Поток/группа</th>
                                <th>Период обучения</th>
                                <th>Дисциплина, тема</th>
                                <th>Кафедра</th>
                                <th>Часы</th>
                                
                                <th>Преподавател(и)</th>
                              
                                <th>Действия</th>
                                </tr></tfoot>
                            <tbody>
  
                           
                           
                        @foreach(\App\Timetable::select(['timetable.*'])
                        ->join('groups', 'groups.id' , '=', 'timetable.group_id')
                        ->where('groups.stream_id', '=', $stream_id)
                        ->get() as $timetable)
                        
                        <tr><td>
                                @if(in_array(Auth::user()->role_id, [3,4,6]))
                                <a href="workload/edit/{{$timetable->id}}"  name="{{$timetable->id}}">{{$timetable->id}}</a>
                                @else
                                {{$timetable->id}}
                                @endif
                            </td>
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
                            
                            <td><strong></strong>
                                @if( isset($timetable->block->name) && $timetable->block->active )
                                <i class='fa fa-check-circle green'></i>
                                @endif
                                &nbsp;
                                {{ $timetable->block->id or '' }} 
                                {{ $timetable->block->name or '' }}
                                <br/>
                                <small>{{ $timetable->block->discipline->name or '' }}</small>
                                @if($timetable->discipline_id) <span class='green'><strong>Аттестация</strong>
                                        {{ \App\Discipline::find($timetable->discipline_id)->name}}</span>
                                @endif

                                @if($timetable->program_id and $timetable->lessontype == 3 ) 
                                <span class='red'><strong>Итоговая аттестация</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                @if($timetable->program_id and $timetable->lessontype == 4 ) 
                                <span class="blue"><strong>Защита ВКР</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                @if($timetable->program_id and $timetable->lessontype == 5 ) 
                                <span class="green"><strong>Защита ИР</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                                   
                            </td>
                            
                            <td>
                                @if (isset($timetable->block->department_id))
                            <strike title="Эта тема в УТП прикреплена к {{ $timetable->block->department->name }}">{{ $timetable->block->discipline->department->name or '' }}</strike><br/>
                                {{ $timetable->block->department->name }}
                                @else
                                {{ $timetable->block->discipline->department->name or '' }}
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
                            {{--<td>
                                {{$timetable->month or ''}}
                            </td>--}}
                            <td>
                                @if($timetable->rasp_id)
                                Назначено на:
                                <a href="{{url('rasp')}}?date={{$timetable->rasp->date or ''}}">{{$timetable->rasp->date or ''}}</a>
                                @else
                                @if($i == 0)
                                
                                @if(in_array(Auth::user()->role_id, [2]))
                                    <a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Взять нагрузку</a>
                                @else
                                    <a href="workload/edit/{{$timetable->id}}" class="btn btn-primary" name="{{$timetable->id}}">Распределить</a>
                                @endif
                            
                                @else
                                
                                <a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-danger">Отказаться</a>

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
                        @endif
                    </div>

    
            </div>
 
        </div>

        
                
    </div>

</div>

<script>

var $window = $(window)
/* Restore scroll position */
window.scroll(0, localStorage.getItem('scrollPosition')|0)
/* Save scroll position */
$window.scroll(function () {
    localStorage.setItem('scrollPosition', $window.scrollTop())
})


</script>

@endsection


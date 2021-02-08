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

    if (isset($_GET["year"])) {
            $year = $_GET["year"];
            $_SESSION["year"] = $year;
            }
    elseif (isset($_SESSION["year"])) {
            $year = $_SESSION["year"];      
        } else {
            $year = date('Y');
        }
        
        
    if (isset($_GET["hide_finished"])) {
            $hide_finished = $_GET["hide_finished"];
            
        } else {
            $hide_finished = 0;
            
        }

    $_SESSION["work_with"] = "workload";
    $_SESSION["stream_id"] = $stream_id;
    $_SESSION["year"] = $year;    
    $_SESSION["hide_finished"] = $hide_finished;
    
   // dump($hide_finished);
    
    $prev_program_name = "";
    
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

                        
                        <form method="get">
                            <p>
                            
                            <p>
                                @if ($hide_finished == 1)
                                <input type="checkbox" name="hide_finished" value="1" checked  onChange='form.submit()'> Показать отучившиеся потоки</p>
                                @else
                                <input type="checkbox" name="hide_finished" value="1" onChange='form.submit()'> Показать отучившиеся потоки</p>
                                @endif
                                Год: <input type='number' name='year' min='2020' max='2099' value='{{ $year }}' class='form-control-static' onChange='form.submit()'>
                            
                            
                            
                            <select name='stream_id' id='produce' class='form-control-static blue' onChange='form.submit()' >
                                <option value='0'>Выберите</option>
                                @if ($stream_id == -1)
                                    <option value='-1' selected>Показать всю нераспределенную нагрузку (первые 2000 записей)</option>
                                    @else 
                                    <option value='-1'>Показать всю нераспределенную нагрузку (первые 2000 записей)</option>
                                @endif
                                
                                @if ($hide_finished == 1)
                                    @php
                                        $streams = \App\Stream::selectRaw('streams.*, programs.name as program_name')
                                        ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                        ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                                        ->orderby('programs.name')
                                        ->where('streams.active', 1)
                                        ->where('streams.year', $year)
                                        ->orderby('streams.date_start')
                                        ->get()
                                    @endphp
                                @else
                                    @php

                                        $streams = \App\Stream::selectRaw('streams.*, programs.name as program_name')
                                        ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                        ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                                        ->orderby('programs.name')
                                        ->where('streams.active', 1)
                                        ->where('streams.year', $year)
                                        ->where('streams.date_finish', '>=', date('Y-m-d'))
                                        ->orderby('streams.date_start')
                                        ->get()                                        
                                    @endphp
                                @endif
                                
                                @foreach($streams as $stream)

                                    @if ($prev_program_name != str_limit($stream->program_name, 1))
                                    <option disabled="">{{ str_limit($stream->program_name, 1, '') }}</option>
                                    @endif
                                    
                                    @if ($stream->id == $stream_id)

                                        <option value='{{ $stream->id }}' selected>
                                        {{substr($stream->date_start, 5, 2)}} :: 
                                        {{ str_limit($stream->program_name, 70) }}
                                        :: {{$stream->name}}
                                        </option>
                                    @else
                                        <option value='{{ $stream->id }}'>
                                        {{substr($stream->date_start, 5, 2)}} :: 
                                        
                                        {{ str_limit($stream->program_name, 70) }} ::
                                        {{$stream->name}}
                                        </option>
                                    @endif
                                    
                                    @php ($prev_program_name = str_limit($stream->program_name, 1))
                                @endforeach
                         </select>

                            
                            <button class='btn btn-primary'>Отфильтровать</button>
                            
                        </p>
                        <p>
                            {{--
                            @if ($stream_id)
                            Выберите группу: 
                            <select name="filterGroup" id="filterGroup" class="form-control-static">
                                
                                @foreach(\App\Stream::find($stream_id)->groups as $gr)
                                <option value="{{$gr->name}}">{{$gr->name}}</option>
                                @endforeach
                                
                            </select>
                            
                            @endif
                            --}}
                            
                        </p>
                        
                        
                        </form>
                        </p>
                        @if(in_array(Auth::user()->role_id, [3,4,6]))
                        <p>Вы методист и вам нужно распределить нагрузку по преподавателям. 
                            Это делается нажатием кнопки "Распределить". После этого указываем нужных преподавателей и жмем "Сохранить нагрузку". 
                            В расписание может быть включена только нагрузка с назначенным преподавателем(ями).
                            Если нужной нагрузки в таблице нет, создайте ее вручную. Если нагрузка сформирована не полностью, или учебный план поменялся нажмите кнопку "Синхронизировать с учебным планом"</p>
                        <p><a href='workload/add' class='btn btn-success'>Создать элемент нагрузки вручную</a> 
                        
                        @if ($stream_id > 0) 
                        <a href='workload/rebuild?stream_id={{$stream_id}}' class='btn btn-danger'>Синхронизировать с учебным планом</a></p>
                        @endif
                        
                        @elseif(in_array(Auth::user()->role_id, [2]))
                        <p>    
                        Вы преподаватель? Ваша задача - разобрать учебную нагрузку. Для этого нажмимайте кнопку "Взять нагрузку" в таблице, после чего в этих темах появится ваша фамилия.
                        Также вы можете отказаться от ранее взятой нагрузки, если ее не успели включить в расписание, нажав кнопку "Отказаться". 
                        Одну строку нагрузки могут делить несколько преподавателей. Чтобы изменить месяц или другие детали нагрузки, нажмите кнопку "Поменять".
                        
                        Подсказка - таблицу можно сортировать, щелкая мышкой по заголовкам. Для сортировки по нескольким столбцам, щелкайте с нажатым Shift. 
                        Также можно фильтровать данные при помощи поля "Поиск" (справа над таблицей).
                        </p>
                        
                        @endif

                         @include('include.excel_button')
                         
                        @if ($stream_id > 0)
                        

                        
                        <table class="table table-bordered display" id="sortTable">
                            <thead><tr><th>id</th>
                                <th>Поток</th>
                                <th>Группа</th>
                                <th>Подгруппа</th>
                                <th>Период обучения</th>
                                <th>Укрупненная тема</th>
                                <th>Дисциплина, тема</th>
                                <th>Месяц</th>
                                <th>Кафедра</th>
                                <th>Часы</th>
                                <th>Преподавател(и)</th>
                                <th>Действия</th>
                                </tr></thead>
                                
                            <tfoot>
                                <tr>
                                <td>id</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="filter"></td>
                                <td></td>
                                <td class="filter"></td>
                                <td></td>
                                </tr></tfoot>
                            <tbody>
  
                           

                        
                        @if ($stream_id) 
                        
                        @php
                        $timetables = \App\Timetable::select(['timetable.*'])
                        ->join('groups', 'groups.id' , '=', 'timetable.group_id')
                        ->join('streams', 'streams.id', '=', 'groups.stream_id')
                        ->where('groups.stream_id', '=', $stream_id)
                        ->where('streams.date_start', 'like', $year.'%')
                        ->get();
                        @endphp
                        
                        @foreach($timetables as $timetable)
                        
                        <tr><td>
                                @if(in_array(Auth::user()->role_id, [3,6]))
                                    <a href="workload/edit/{{$timetable->id}}"  name="{{$timetable->id}}">{{$timetable->id}}</a>
                                
                                @elseif (in_array(Auth::user()->role_id, [4]))
                                    <a href="workload/edit/{{$timetable->id}}"  name="{{$timetable->id}}">{{$timetable->id}}</a>
                                    @if (!$timetable->teachers->count() && !$timetable->rasp_id)
                                    <a class="" href="{{url('workload')}}/delete/{{$timetable->id}}"  onClick="return window.confirm('Нагрузка будет удалена. Продолжить?');" ><i class="fa fa-times-circle red fa-2x"></i></a>
                                    @endif
                                @else
                                {{$timetable->id}}
                                @endif
        
                            </td>
                            <td>{{$timetable->group->stream->name}}</td>
                            
                            <td>{{$timetable->group->name}}</td>
                        
                            <td>
                         @if(in_array($timetable->lessontype, [2, 11]))
                                @if($timetable->subgroup)
                                подгр. {{$timetable->subgroup}}
                                @else
                                <a href="workload/split/{{$timetable->id}}">разделить на подгруппы</a>
                                @endif
                                @endif
                        
                        </td>
                        <td><div style="display: none !important">{{$timetable->group->stream->date_start}}
                                </div>
                            
                                {{ date('d.m', strtotime($timetable->group->stream->date_start))}} - 
                                {{ date('d.m', strtotime($timetable->group->stream->date_finish))}}
                            
                            </td>
                            <td>
                            <p><small class="blue">{{ $timetable->block->largeblock->name or '-' }}</small></p>
                            </td>
                            <td><strong></strong>
                                {{ $timetable->block->id or '' }} 
                                {{ $timetable->block->name or '' }}
                                
                               {{-- <small>{{ $timetable->block->discipline->name or '' }}</small> --}}
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
                                
                                @if($timetable->program_id and $timetable->lessontype == 19 ) 
                                <span class="orange"><strong>Защита проекта</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                @if($timetable->program_id and $timetable->lessontype == 5 ) 
                                <span class="green"><strong>Защита ИР</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                                   
                            </td>
                            
                            <td>{{$timetable->month}}</td>
                            
                            <td>
                                ({{ $timetable->block->largeblock->department->name or '' }})
                            </td>
                            <td>{{ $timetable->hours }} ч - 
                            {{ $timetable->lesson_type->name or 'не определено'}}
                            </td>
  
                            <td>@php ($i = 0)
                                @if($timetable->teachers->count())
                                
                                @foreach($timetable->teachers as $teacher)
                                    <span class="green"><strong>{{$teacher->secname()}}</strong> 
                                    
                                    @if ($teacher->freelance) 
                                     (договор)
                                    @endif
                                    </span>
                                        @if($teacher->id == Auth::user()->id)
                                        @php ($i++)
                                    @endif
                                @endforeach
                                                                
                                @else 
                                <span class="badge white">!не распределено</span>
                                @endif
                                
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
                            <center>
                                <p><a href="{{url('workload/cancel')}}/{{$timetable->id}}" class="btn btn-danger">Отказаться</a></p>
                                <p><a href="workload/edit/{{$timetable->id}}" class="btn btn-default">Поменять</a></p>
                            </center>

                        @endif  
                        @endif

   
                        </td>
                        </tr>
                        @endforeach
                        @endif
                            </tbody>
                        </table>
                    
                        <p>
                        <a href='workload/add' class='btn btn-success'>Создать элемент нагрузки вручную</a>
                        </p>
                        
                        @elseif ($stream_id == -1)
                        <h3>Нераспределенная нагрузка</h3>
                        

                        <table class='table table-bordered' id='sortTable'>
                             <thead><tr><th>id</th>
                                         <th>Поток</th>
                                             
                                <th>Группа</th>
                                <th>Подгруппа</th>
                                <th>Период обучения</th>
                                <th>Укрупненная тема</th>
                                <th>Дисциплина, тема</th>
                                
                                <th>Кафедра</th>
                                <th>Часы</th>
                                <th>Вид</th>
                                <th>Преподавател(и)</th>
                               
                                <th>Действия</th>
                                
                                </tr></thead>                           
                             

                             
                             
                             <tbody>  
 <!--///////////////////////////////////////////////////////////////////////////
 
 Если поток не выбран (stream_id == 0), то отображается нераспределенная нагрузка. 
 Поскольку объем данных, полученных по запросу может быть большой, его объем ограничен
 200 записями.
 
 ###########################################################################-->
 
    @php
    $total_hours = 0;
    @endphp
 
                        @foreach(\App\Timetable::selectRaw('streams.*, groups.*, timetable.*')
                                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                                    ->leftjoin('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                                    ->where('teachers2timetable.id', NULL)
                                                    ->where('streams.year', $year)
                                                    ->limit(2000)
                                                    ->get() as $timetable) 

                        <tr>
                            <td>
                                @if(in_array(Auth::user()->role_id, [3,6]))
                                    <a href="workload/edit/{{$timetable->id}}"  name="{{$timetable->id}}">{{$timetable->id}}</a>
                                
                                @elseif (in_array(Auth::user()->role_id, [4]))
                                    <a href="workload/edit/{{$timetable->id}}"  name="{{$timetable->id}}">{{$timetable->id}}</a>
                                    @if (!$timetable->teachers->count() && !$timetable->rasp_id)
                                    <a class="" href="{{url('workload')}}/delete/{{$timetable->id}}"  onClick="return window.confirm('Нагрузка будет удалена. Продолжить?');" ><i class="fa fa-times-circle red fa-2x"></i></a>
                                    @endif
                                @else
                                {{$timetable->id}}
                                @endif
        

                            </td>

                            <td>{{$timetable->group->stream->name}}</td>
                            <td>{{$timetable->group->name}}</td>
                            <td>
                        
                         @if(in_array($timetable->lessontype, [2, 11]))
                                @if($timetable->subgroup)
                                подгр. {{$timetable->subgroup}}
                                @else
                                <a href="workload/split/{{$timetable->id}}">разделить</a>
                                @endif
                                @endif
                        
                        </td>
                        <td>{{ date('d.m', strtotime($timetable->group->stream->date_start))}} - 
                            {{ date('d.m', strtotime($timetable->group->stream->date_finish))}}
                            
                            </td>
                            
                            
                            <td>
                            <p><small class="blue">{{ $timetable->block->largeblock->name or '---' }}</small></p>
                            </td>
                            <td>

                                {{ $timetable->block->id or '' }} ::
                                {{ $timetable->block->name or '' }}
                                
                              {{--  <small>{{ $timetable->block->discipline->name or '' }}</small> --}}
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
                                
                                @if($timetable->program_id and $timetable->lessontype == 19 ) 
                                <span class="orange"><strong>Защита проекта</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                @if($timetable->program_id and $timetable->lessontype == 5 ) 
                                <span class="green"><strong>Защита ИР</strong>
                                        {{ \App\Program::find($timetable->program_id)->name}}</span>
                                @endif
                                
                                                   
                            </td>
                            
                            
                            
                            <td>({{ $timetable->block->largeblock->department->name or '' }})</td>
                            <td>{{ $timetable->hours }}
                            @php ($total_hours += $timetable->hours)
                            </td>
                            <td>
                            {{ $timetable->lesson_type->name or 'не определено'}}
                            </td>
  
                            <td>
                                                                
                                
                                <span class="badge white">!не распределено</span>
                                
                                
                            </td>

                            <td>

                                @if(in_array(Auth::user()->role_id, [2]))
                                    <a href="{{url('workload/get')}}/{{$timetable->id}}" class="btn btn-success">Взять нагрузку</a>
                                @else
                                    <a href="workload/edit/{{$timetable->id}}" class="btn btn-primary" name="{{$timetable->id}}">Распределить</a>
                                @endif  
                        

   
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        
                        <tfoot>
                                <tr>
                                <td>id</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class='filter'></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              
                                <td></td>
                        </tr></tfoot>
                        
                        </table>
                        @else
                        
                        @endif
                    </div>

    
            </div>
 
        </div>

        
                
    </div>

</div>

<script>

var $window = $(window);
/* Restore scroll position */
window.scroll(0, localStorage.getItem('scrollPosition')|0);
/* Save scroll position */
$window.scroll(function () {
    localStorage.setItem('scrollPosition', $window.scrollTop())
});

 

</script>

<script>
/*
$('#filterGroup').on("click change", function() {
   var group_name = $("#filterGroup option:selected").val();
    $('#sortTable').DataTable().destroy();
    $('#sortTable').DataTable().column(2).search(
        $('#filterGroup').val(),
    ).draw();
localStorage.group_name = group_name;
}); 


    
$(document).ready(function() {
  $('#filterGroup option').each(function () {
        if (this.value === localStorage.group_name) {
        $('#filterGroup option[value=' + localStorage.group_name+ ']').prop('selected', true);
        }
    $('#filterGroup').click();
    });
    });
*/
        </script>


@endsection


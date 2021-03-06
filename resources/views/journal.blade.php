
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    
                      
                                
                Журнал преподавателя
                <form action='' method='get'>
                    
                   
                    
                </form>
                </div>

                <div class="panel-body">
                    <p><a href="{{ route('home')}}">В начало</a></p>
                    
                <?php 

                $me = Auth::user()->id;
                ?>
                    <h1>Сегодня <span class='green'>{{ \Logbook::normal_date(date('Y-m-d'))}}</span></h1>
                <table class='table table-bordered' id=''>
                    <thead>
                    <tr>
                        
                        <th width="10%">Дата</th>
                        <th width="10%">Время</th>
                        <th width="10%">Группа</th>
                        <th>Тема занятия</th>
                        <th width="10%">Тип занятия</th>
                        <th width="10%">Операции</th>
                        <th width="10%">Состояние журнала</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($rasp = \App\Rasp::select('rasp.*')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('users', 'teachers2timetable.teacher_id', '=', 'users.id')
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->where('teachers2timetable.teacher_id', $me)
                ->where('streams.year', date('Y'))
                ->where('streams.date_start', '<=', date('Y-m-d'))
                ->where('streams.date_finish', '>=', date('Y-m-d'))
                ->where('date', '=', date('Y-m-d'))
                ->orderby('rasp.date')
                ->get() as $rasp)
                
                
                    
                    <tr>
                        
                        <td class="largetext"><span style='display: none'>{{$rasp->date}}</span>
                        @if ($rasp->date == date('Y-m-d'))
                            <span class='green'>{{ \Logbook::normal_date($rasp->date)}}</span>
                        @else
                            {{ \Logbook::normal_date($rasp->date)}}
                        @endif
                        
                        </td>
                        <td  class="largetext">{{ substr($rasp->start_at, 0, 5)}}</td>
                        <td  class="largetext"><nobr>({{$rasp->timetable->group->name or ''}})</nobr>
                        @if ($rasp->timetable->subgroup or '')
                        <br/><nobr>{{$rasp->timetable->subgroup or ''}}</nobr>
                        @endif
                    </td>
                    
                    <td class="largetext" width="50%">{{$rasp->timetable->block->name or ''}}</td>
                    <td class="largetext">{{$rasp->timetable->hours or ''}} ч., {{$rasp->timetable->lesson_type->name or ''}}</td>
                    <td class="largetext"><a href='journal/item/{{$rasp->id}}' class="btn btn-primary">Открыть журнал</a></td>
                    <td class="largetext">
                        @if (\App\Journal::state($rasp->id))
                        <i class='fa fa-check-circle green fa fa-1x'> заполнен</i>
                        @endif
   
                    </td>
                </tr>
                @endforeach
                
                @if($rasp->count() == 0)
                <tr>
                    <td colspan="7">Сегодня занятий нет</td>
                </tr>
                @endif
                
                </tbody>
                </table>    
                
                    <p>
                        Расписание ваших дальнейших занятий, а также распределение нагрузки по месяцам можно посмотреть в разделах "Мое расписание" и "Моя нагрузка".
                    </p>
                    <p><a href="{{ route('myrasp')}}" class="btn btn-success">Мое расписание</a> 
                        <a href="{{ route('workloadmythemes')}}" class="btn btn-primary">Моя нагрузка по темам и месяцам</a>
                    </p>
                    
                    <hr>
                    
                    
                   <div id="previous" style="display: block; width: 100%"> 
                    <h4>Предыдущие записи журнала</h4>    
                    <p>
                        В этой таблице отображаются ранее проведенные занятия.                         Пожалуйста, следите, чтобы журнал по всем занятиям имел статус "Заполнен".
                    </p>
                <table class='table table-bordered' id='sortTable'>
                    <thead>
                    <tr>
                        
                        <th width="10%">Дата</th>
                        <th width="10%">Время</th>
                        <th width="10%">Группа</th>
                        <th>Тема занятия</th>
                        <th width="10%">Тип занятия</th>
                        <th width="10%">Операции</th>
                        <th width="10%">Состояние журнала</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach(\App\Rasp::selectRaw('rasp.*')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('users', 'teachers2timetable.teacher_id', '=', 'users.id')
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->where('users.id', $me)
                ->where('streams.year', date('Y'))
                ->where('date', '<', date('Y-m-d'))
                ->orderby('rasp.date', 'desc')
                ->get() as $rasp)
                
               
                
                
                    
                    <tr>
                        
                        <td class=""><span style='display: none'>{{$rasp->date}}</span>
                        @if ($rasp->date == date('Y-m-d'))
                            <span class='green'>{{ \Logbook::normal_date($rasp->date)}}</span>
                        @else
                            {{ \Logbook::normal_date($rasp->date)}}
                        @endif
                        
                        </td>
                        <td  class="">{{ substr($rasp->start_at, 0, 5)}}</td>
                        <td  class=""><nobr>({{$rasp->timetable->group->name or ''}})</nobr>
                        @if ($rasp->timetable->subgroup or '')
                        <br/><nobr>{{$rasp->timetable->subgroup or ''}}</nobr>
                        @endif
                    </td>
                    
                    <td class="" width="50%">{{$rasp->timetable->block->name or ''}}</td>
                    <td class="">{{$rasp->timetable->hours or ''}} ч., {{$rasp->timetable->lesson_type->name or ''}}</td>
                    <td class=""><a href='journal/item/{{$rasp->id}}' class="btn btn-primary">Открыть журнал</a></td>
                    <td class="">
                        @if (\App\Journal::state($rasp->id))
                        <i class='fa fa-check-circle green fa fa-1x'> заполнен</i>
                        @else
                        <i class='fa fa-times-circle red fa fa-1x'> не заполнен</i>
                        @endif
   
                    </td>
                </tr>
                    
                
                @endforeach
                </tbody>
                </table>                    
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


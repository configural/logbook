
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
                    <h3>Сегодня <span class='green'>{{ \Logbook::normal_date(date('Y-m-d'))}}</span></h3>
                <table class='table table-bordered' id='sortTable'>
                    <thead>
                    <tr>
                        
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Группа</th>
                        <th>Тема занятия</th>
                        <th>Тип занятия</th>
                        <th>Операции</th>
                        <th>Состояние журнала</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach(\App\Rasp::select('rasp.*')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('users', 'teachers2timetable.teacher_id', '=', 'users.id')
                ->where('users.id', $me)
                ->where('date', '<=', date('Y-m-d'))
                ->orderby('rasp.date', 'desc')
                ->get() as $rasp)
                
                @foreach($rasp->timetable->teachers as $teacher)
                    
                    <tr>
                        
                        <td class="largetext"><span style='display: none'>{{$rasp->date}}</span>
                        @if ($rasp->date == date('Y-m-d'))
                            <span class='green'>{{ \Logbook::normal_date($rasp->date)}}</span>
                        @else
                            {{ \Logbook::normal_date($rasp->date)}}
                        @endif
                        
                        </td>
                        <td  class="largetext">{{ substr($rasp->start_at, 0, 5)}}</td>
                        <td  class="largetext"><nobr>{{$rasp->timetable->group->name or ''}}</nobr>
                        @if ($rasp->timetable->subgroup or '')
                        <br/><nobr>{{$rasp->timetable->subgroup or ''}}</nobr>
                        @endif
                    </td>
                    
                    <td class="largetext" width="50%">{{$rasp->timetable->block->name or ''}}</td>
                    <td class="largetext">{{$rasp->timetable->hours or ''}} ч., {{$rasp->timetable->lesson_type->name or ''}}</td>
                    <td class="largetext"><a href='journal/item/{{$rasp->id}}' class="btn btn-primary">Открыть журнал</a></td>
                    <td class="largetext">
                        @if (\App\Journal::state($rasp->id))
                        <i class='fa fa-check-circle green fa fa-2x'> заполнен</i>
                        @endif
   
                    </td>
                </tr>
                    
                @endforeach
                @endforeach
                </tbody>
                </table>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                
                Журнал преподавателя
                <form action='' method='get'>
                    
                    <input name='date' type='date' value='{{$date}}' onchange="javascript:form.submit()">
                    
                </form>
                </div>

                <div class="panel-body">
                <?php 

                $me = Auth::user()->id;
                ?>
                    <h3>Занятия на {{$date}}</h3>
                <table class='table table-bordered'>
                    <tr>
                        <th>Время</th>
                        <th>Группа</th>
                        <th>Тема занятия</th>
                        <th>Часы</th>
                        <th>Тип занятия</th>
                        <th>Операции</th>
                        <th>Состояние</th>
                    </tr>
                @foreach(\App\Rasp::select()->where('date', $date)->get() as $rasp)
                @foreach($rasp->timetable->teachers as $teacher)
                    @if($teacher->id == $me)
                    <tr>
                        <td>{{$rasp->start_at}}</td>
                        <td><nobr>{{$rasp->timetable->group->name or ''}}</nobr>
                        @if ($rasp->timetable->subgroup or '')
                        <br/><nobr>{{$rasp->timetable->subgroup or ''}}</nobr>
                        @endif
                    </td>
                    
                    <td>{{$rasp->timetable->block->name or ''}}</td>
                    <td>{{$rasp->timetable->hours or ''}}</td>
                    <td>{{$rasp->timetable->lesson_type->name or ''}}</td>
                    <td><a href='journal/item/{{$rasp->id}}'>Открыть журнал</a></td>
                    <td>
                        @if (\App\Journal::state($rasp->id))
                        <i class='fa fa-check-circle green fa-2x'></i>
                        @endif
                        
                    </td>
                </tr>
                    @endif
                @endforeach
                @endforeach
                </table>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


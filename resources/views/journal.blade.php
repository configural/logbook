
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                
                Журнал преподавателя
                <form action='' method='get'>
                    
                    <input name='date' type='date' value='{{$date}}'>
                    <button>>></button>
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
                    </tr>
                @foreach(\App\Rasp::select()->where('date', $date)->get() as $rasp)
                @foreach($rasp->timetable->teachers as $teacher)
                    @if($teacher->id == $me)
                    <tr>
                    <td>{{$rasp->start_at}}–{{$rasp->finish_at}}</td>
                    <td>{{$rasp->timetable->group->name}} 
                        @if ($rasp->timetable->subgroup)
                        <br/>Подгруппа {{$rasp->timetable->subgroup}}
                        @endif
                    </td>
                    
                    <td>{{$rasp->timetable->block->name}}</td>
                    <td>{{$rasp->timetable->hours}}</td>
                    <td>{{$rasp->timetable->lesson_type->name}}</td>
                    <td><a href='journal/item/{{$rasp->id}}'>Открыть журнал</a></td>
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


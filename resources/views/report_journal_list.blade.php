
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журнал преподавателя</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>Дата, время</th>
                                <th>Тема занятия</th>
                                <th>Часов</th>
                                <th>Вид занятия</th>
                                <th>Группа</th>
                                <th>Посещаемость</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach($journals as $journal)
                            <tr>
                                <td><a href="view/{{$journal->id}}">{{$journal->updated_at or 'n/a'}}</a></td>
                                <td>{{$journal->rasp->timetable->block->name or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->hours or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->lesson_type->name or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->group->name or 'n/a'}}
                                    @if (isset($journal->rasp->timetable->subgroup))
                                    <br/>Подгруппа {{$journal->rasp->timetable->subgroup or 'n/a'}}
                                    @endif
                                </td>
                                <td>{{$journal->percent() }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

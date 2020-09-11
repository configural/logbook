
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журнал преподавателя</div>

                <div class="panel-body">
                    
                    <p><a href="{{ route('home')}}">В начало</a> —
                    <a href="{{ route('report_journal')}}">Журналы преподавателей</a>
                    </p>
                    
                    @if(Auth::user()->role_id >= 3)  
                    <h2>{{$user->name}}</h2>
                    <h3>{{$user->department->name or ''}}</h3>
                    
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
                                <td>{{$journal->updated_at or 'n/a'}}</td>
                                <td><a href="view/{{$journal->id}}">{{$journal->rasp->timetable->block->name or 'n/a'}}</a></td>
                                <td>{{$journal->rasp->timetable->hours or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->lesson_type->name or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->group->name or 'n/a'}}
                                    @if (isset($journal->rasp->timetable->subgroup))
                                    <br/>Подгруппа {{$journal->rasp->timetable->subgroup or 'n/a'}}
                                    @endif
                                </td>
                                <td>{{$journal->percent() * 100}} %</td>

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

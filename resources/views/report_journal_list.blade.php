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
                    
                   
                    <h1>{{ $user->name }}</h1>
                    <h3>Кафедра {{ $user->department->name}}</h3>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th widh="10%">Дата, время</th>
                                <th width="">Тема занятия</th>
                                <th widh="5%">Часов</th>
                                <th widh="5%">Вид занятия</th>
                                <th widh="5%">Группа</th>
                                <th widh="10%">Посещаемость</th>
                                <th widh="10%">Аттестация</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach($journals as $journal)
                            <tr>
                                <td><span class="hidden">{{$journal->rasp->date}}</span>
                                    {{ \Logbook::normal_date($journal->rasp->date) }}</td>
                                <td><a href="view/{{$journal->id}}">{{$journal->rasp->timetable->block->name or 'n/a'}}</a></td>
                                <td>{{$journal->rasp->timetable->hours or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->lesson_type->name or 'n/a'}}</td>
                                <td>{{$journal->rasp->timetable->group->name or 'n/a'}}
                                    @if (isset($journal->rasp->timetable->subgroup))
                                    <br/>Подгруппа {{$journal->rasp->timetable->subgroup or 'n/a'}}
                                    @endif
                                </td>
                                <td>
                                    @if ($journal->percent())
                                    <i class="fa fa-check-circle green"></i> {{$journal->percent() * 100}} %
                                    @else
                                    <i class="fa fa-minus-circle orange"></i>
                                    
                                    @endif
                                </td>
                                
                                <td>
                                    @if (array_sum(unserialize($journal->attestation)) > 0)
                                    <i class="fa fa-check-circle green"></i>
                                    
                                    {{ (int) (count(unserialize($journal->attestation)) / $journal->rasp->timetable->group->students->count() * 100) }}%
                                    
                                    
                                    @else
                                    <i class="fa fa-minus-circle orange"></i>
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
@endsection

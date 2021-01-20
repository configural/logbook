@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журналы преподавателей</div>

                <div class="panel-body">
                    <p><a href="{{ route('home')}}">В начало</a></p>
                    
                    @if(Auth::user()->role_id >= 3)  
                    <h1>Хронология учебных занятий</h1>
                    
                    @include('include.excel_button')
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>ФИО</th>
                                <th>Кафедра</th>
                                <th>Группа</th>
                                <th>Тема</th>
                                <th>Вид занятия</th>
                                <th>Часы</th>
                            </tr>
                        </thead>    
                        <tbody>

                            @foreach(\App\Journal::orderby('updated_at', 'desc')->limit(200)->get() as $journal)
                            <tr>
                                <td><nobr>{{$journal->updated_at}}</nobr></td>
                    <td><nobr><a href='{{url('reports')}}/journal/{{$journal->teacher_id}}'>{{$journal->teacher($journal->rasp_id)}}</a><nobr></td>
                                
                                <td>{{$journal->user->department->name}}</td>
                                <td>{{$journal->rasp->timetable->group->name}}</td>
                                <td>{{$journal->rasp->timetable->block->name or 'нет данных'}}</td>
                                <td>{{$journal->rasp->timetable->lesson_type->name or 'нет данных'}}</td>
                                <td>{{$journal->rasp->timetable->hours}}</td>
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

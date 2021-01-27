
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Они не заполнили журнал!</div>

                <div class="panel-body">
                    
                    <p><a href="{{ route('home') }}">В начало</a></p>
                 
                    <table class="table table-bordered" id="sortTable">
                        <thead>

                        <th width="5%">id журнала</th>
                        <th width="10%">Дата</th>
                        <th width="25%">Преподаватель</th>
                        <th width="10%">Группа</th>
                        <th width="10%">Тип занятия</th>
                        <th width="50%">Занятие</th>
                        
                        </thead>
                        <tbody>
                        
                        @foreach($rasp as $r)
                        @if ($r->journal == NULL && isset($r->timetable->lessontype) && in_array($r->timetable->lessontype, [1,2,4,5,11]))  
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td><span style="display: none">{{ $r->date }}</span>{{ \Logbook::normal_date($r->date)}}</td>
                            <td>@foreach($r->timetable->teachers as $teacher)
                                {{$teacher->name}}<br/>
                                @endforeach
                            </td>
                            <td>{{ $r->timetable->group->name or '' }}</td>
                            <td>{{ $r->timetable->lesson_type->name or '' }}</td>
                            <td>{{ $r->timetable->block->name or '' }}</td>
                            
                            
                        </tr>
                        @endif
                        @endforeach
                    
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


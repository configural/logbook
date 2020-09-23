
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Мое расписание</div>

                <div class="panel-body">
                    <form method="get">
                    @include('include.daterange', ['date1' => $date1 , 'date2' => $date2])
                    <button class="btn btn-success">Обновить</button>
                    </form>
                    <hr>
                    <h3>{{ Auth::user()->name}}</h3>
                    <table class='table table-bordered' id="sortTable">

                        <thead>
                        <tr class='alert-info'>
                            
                            <th width='10%'>Дата</th>
                            <th width='10%'>Время</th>
                            <th width='10%'>Группа</th>
                            <th width='10%'>Аудитория</th>
                            <th width='10%'>Методист</th>
                            <th width='50%'>Тема в расписании</th>
                            
                            
                        </tr>  
                        </thead>
                        <tbody>
                    @foreach(Auth::user()->timetable()
                    ->join('rasp', 'rasp.id', '=', 'rasp_id')
                    ->whereBetween('rasp.date', [$date1, $date2])
                    ->orderby('rasp.date')->get() as $timetable)
                        
                        <tr>
                            <td><nobr>{{ $timetable->rasp->date or ''}}</nobr></td>
                            <td>{{ $timetable->rasp->start_at or ''}}<br>
                                {{ $timetable->rasp->finish_at or ''}}</td>
                            <td>{{ $timetable->group->name or ''}}</td>
                            <td>{{ $timetable->rasp->classroom->name or ''}}</td>
                            <td>
                                @if ($timetable->group->stream->metodist_id)
                                {{ $timetable->group->stream->metodist->fio()}}
                                @endif
                            </td>
                                
                            <td><strong>{{$timetable->lesson_type->name}}</strong>: {{ $timetable->block->name or ''}} </td>
                            
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

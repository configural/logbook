
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Мое расписание</div>

                <div class="panel-body">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                        </p>
                    <form method="get">
                    @include('include.daterange', ['date1' => $date1 , 'date2' => $date2])
                    <button class="btn btn-success">Обновить</button>
                    </form>
                    @include ('include.excel_button')
                        
                        <hr>
                    <h3>{{ Auth::user()->name}}</h3>
                    <table class='table table-bordered' id="sortTable">

                        <thead>
                        <tr class='alert-info'>
                            
                            <th width='10%'>Дата</th>
                            <th width='10%'>Время</th>
                            <th width='10%'>Аудитория</th>
                            <th width='10%'>Группа</th>
                            <th width='10%'>Поток</th>
                            <th width='40%'>Тема в расписании</th>
                            <th width='10%'>Методист</th>
                            
                            
                        </tr>  
                        </thead>
                        <tbody>
                    @foreach(Auth::user()->timetable()
                    ->join('rasp', 'rasp.id', '=', 'rasp_id')
                    ->whereBetween('rasp.date', [$date1, $date2])
                    ->orderby('rasp.date')->get() as $timetable)
                        
                        <tr>
                            <td>{{\Logbook::normal_date($timetable->rasp->date)}}</td>
                    <td>{{ str_limit($timetable->rasp->start_at,5, '') }} - {{ str_limit($timetable->rasp->finish_at, 5, '')}}</td>
                            
                            <td>{{ $timetable->rasp->classroom->name or ''}}</td>
                            <td>Группа {{ $timetable->group->name or ''}}</td>
                            <td>{{ $timetable->group->stream->name or ''}}</td>
                                
                            <td><strong>{{$timetable->lesson_type->name}}</strong>: {{ $timetable->block->name or ''}} </td>
                                 <td>
                                @if ($timetable->group->stream->metodist_id)
                                 <nobr>{{ $timetable->group->stream->metodist->fio()}}</nobr>
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

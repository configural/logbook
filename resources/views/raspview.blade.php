@php
session_start();
$_SESSION["work_with"] = "rasp";

if (isset($_GET["date1"])) {
$date1 = $_GET["date1"];
} else {
$date1 = date('Y-m-d');
}

if (isset($_GET["date2"])) {
$date2 = $_GET["date2"];
} else {
$date2 = date("Y-m-d", strtotime("+7 days"));;
}

if (isset($_GET["group_id"])) {
$group_id = $_GET["group_id"];
} else {
$group_id = NULL;
}

@endphp

@extends('layouts.app')

@section('content')



<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action='raspview' method='get'>
                        @include('include.daterange')
                        
                        <select name='group_id' class='form-control-static'>
                            <option value=''>Выберите группу</option>
                            @foreach($groups = \App\Group::selectRaw('groups.*, streams.date_start, streams.date_finish')
                                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                ->whereBetween('streams.date_start',  [$date1, $date2])
                                ->orWhereBetween('streams.date_finish',  [$date1, $date2])
                                ->orWhere(function($query) use($date1, $date2) {
                                    $query->where('streams.date_start', '<=', $date1)
                                          ->where('streams.date_finish', '>=', $date2);
                                    })
                                    ->orderby('groups.name')
                                    ->get()
                                as $group)
                                @if ($group->id == $group_id)
                                <option value='{{ $group->id }}' selected>Группа: {{ $group->name }} ({{ $group->stream->name}})</option>
                                @else
                                <option value='{{ $group->id }}'>Группа: {{ $group->name }} ({{ $group->stream->name}})</option>
                                @endif
                                
                            @endforeach    
                            
                            
                        </select>
                        <button>Показать</button>
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id)
                    @if ($group = \App\Group::find($group_id))
                    <table class="table table-bordered" id="">
                        <caption><h3>Расписание группы {{$group->name}}</h3></caption>
                        <thead>
                        <th>Время</th>
                        <th>Занятие</th>
                        <th>Тема</th>
                        <th>Аудитория</th>
                        <th>Преподаватель</th>
                        </thead>
                        
                        <tbody>   
                            @php 
                            $tmp_date = "";
                            @endphp
                        @foreach($rasp = \App\Rasp::select('rasp.*')
                                        ->leftjoin('timetable', 'timetable.id', '=', 'rasp.timetable_id')
                                        ->where('timetable.group_id', '=', $group_id)
                                        ->whereBetween('rasp.date', [$date1, $date2])
                                        ->orderby('rasp.date')
                                        ->get() as $r)
                                        
                                        @if ($tmp_date != $r->date)
                                        <tr>
                                            <th colspan='10'>{{ \Logbook::normal_date($r->date)}}</th>
                                        </tr>
                                        @php
                                        $tmp_date = $r->date;
                                        @endphp
                                        @endif
                                        
                                        <tr>
                                            
                                            <td>{{ @str_limit($r->start_at, 5, '')}} - {{ @str_limit($r->finish_at, 5, '')}}</td>
                                            <td>{{$r->timetable->lesson_type->name}}, {{$r->timetable->hours}} ч</td>
                                            <td>{{ $r->timetable->block->name or ''}}</td>
                                            <td>{{ $r->classroom->name or '' }}</td>
                                            <td>@foreach($r->timetable->teachers as $t)
                                                {{ $t->fio() }} 
                                                @endforeach
                                            </td>
                                        </tr>
                        
                        @endforeach
                            
                            
                    
                        </tbody>
                    </table>
                    @endif
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
                
                
<script>

$('select, input').change(function(){
    $('form').submit();    
});



var $window = $(window)
/* Restore scroll position */
window.scroll(0, localStorage.getItem('scrollPosition')|0)
/* Save scroll position */
$window.scroll(function () {
    localStorage.setItem('scrollPosition', $window.scrollTop())
})


</script>
@endsection


@extends('layouts.app')

@section('content')
@php
$date1 = '2021-01-01';
$date2 = '2021-12-31';
if (isset($_GET["year"])) {
$year = $_GET["year"];
} else {$year = 2021;
}

if (isset($_GET["month1"])) {
$month1 = $_GET["month1"];
} else {$month1 = 1;
}

if (isset($_GET["month2"])) {
$month2 = $_GET["month2"];
} else {$month2 = 12;
}

if (isset($_GET["user_id"])) {
$user_id = $_GET["user_id"];
} else {$user_id = 0;
}

$hours_total = 0;
$hours_total_month = [0,0,0,0,0,0,0,0,0,0,0,0,0];
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Темы преподавателя - {{$year}} (группировка по названию)</div>

                <div class="panel-body">

                    <form method="get">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                        </p>
                        @if (in_array(Auth::user()->role_id, [3,4,5,6]))
                            <select name="user_id" class="form-control-static" onChange="form.submit()">
                            
                            @foreach(\App\User::where('department_id', Auth::user()->department_id)->where('role_id', 2)->orderby('name')->get() as $user)
                            @if($user->id == $user_id)
                            <option value='{{$user->id}}' selected >{{ $user->name }}</option>
                            @else
                            <option value='{{$user->id}}'>{{ $user->name }}</option>
                            @endif
                            @endforeach
                            </select>
                        @else
                        <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
                        @endif
                        
                        с месяца: <input type="number" name="month1" value="{{$month1}}" min="1" max="12" class="form-control-static">
                        по месяц:  <input type="number" name="month2" value="{{$month2}}" min="1" max="12" class="form-control-static">
                        Год: <input type='number' name='year' value='{{$year}}' class="form-control-static">
                        
                        <button class="btn btn-success">Сформировать</button>
                    
                    
                        @if ($user_id)
                        @include('include.excel_button')
                        @endif
                    
                    </form>
                    
                    @if($user_id)
                    
                    <h3>{{ Auth::user()->where('id', $user_id)->first()->name}}</h3>
                    
                    
                    
                    <table class='table table-bordered' id="sortTable" width='100%'>
                        <thead>
                            <tr>
                                <th>Тема</th>
                                <th>Часы</th>
                            </tr>
                        </thead>
                        
                        <tbody>
 
                   @foreach(\App\Timetable::selectRaw('blocks.name, sum(hours) as hours')
                   ->join('groups', 'groups.id', '=', 'timetable.group_id')
                   ->join('streams', 'streams.id', '=', 'groups.stream_id')
                   ->leftjoin('blocks', 'blocks.id', '=', 'timetable.block_id')
                   ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                   ->groupBy('blocks.name')
                   ->where('teachers2timetable.teacher_id', $user_id)
                   ->where('streams.year', $year)
                   ->whereBetween('timetable.month', [$month1, $month2])
                   ->orderby('blocks.name')
                   ->get() as $timetable
                   )
                   <tr>
                       <td>@if ($timetable->name)
                           {{ @str_limit($timetable->name)}}
                           @else
                           Аттестации, экзамены, защиты ВКР, ИР
                           @endif
                       </td>

                       <td>{{ $timetable->hours}}</td>
                   </tr>
                   
                   @php 
                   $hours_total += $timetable->hours;
                   @endphp
                   @endforeach
                        </tbody>
                   <tfoot>
                       <tr>
                           <td>Итого</td>

                           <td>{{$hours_total}}</td>
                           
                       </tr>
                   </tfoot> 
                    </table>
                    
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

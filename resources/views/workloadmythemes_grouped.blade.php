
@extends('layouts.app')

@section('content')
@php
$date1 = '2021-01-01';
$date2 = '2021-12-31';
if (isset($_GET["year"])) {
$year = $_GET["year"];
} else {$year = 2021;
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
                <div class="panel-heading ">Темы преподавателя - {{$year}}</div>

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
                        <input type='number' name='year' value='{{$year}}' onChange="form.submit()" class="form-control-static">
                        <button class="btn btn-success">Обновить</button>
                    <p>Для печати нажмите Ctrl + P</p>
                    </form>
                    
                    @if($user_id)
                    
                    <h3>{{ Auth::user()->where('id', $user_id)->first()->name}}</h3>
                    
                    
                    
                    <table class='table table-bordered' id="sortTable">
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
                   ->join('blocks', 'blocks.id', '=', 'timetable.block_id')
                   ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                   ->groupBy('blocks.name')
                   ->where('teachers2timetable.teacher_id', $user_id)
                   ->where('streams.year', $year)
                   ->get() as $timetable
                   )
                   <tr>
                       <td>{{ @str_limit($timetable->name)}}</td>

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

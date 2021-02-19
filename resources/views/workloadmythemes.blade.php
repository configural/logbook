
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
$vneaud_hours = 0;
$hours_total_month = [0,0,0,0,0,0,0,0,0,0,0,0,0];
@endphp
<div class="container-fluid ">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Темы преподавателя - {{$year}}</div>

                <div class="panel-body">

                    <form method="get">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                        </p>
                        <p>
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
                    </p>
                    <p>
                        @if ($user_id)
                        @include('include.excel_button')
                        @endif
                    </p>    
                    </form>
                    
                    @if($user_id)
                    
                    
                    <h3>{{ Auth::user()->where('id', $user_id)->first()->name}}</h3>
                    
                    <table class='table table-bordered' id="sortTable" width='100%'>
                        <caption></caption>
                        <thead>
                            <tr>
                                <th width="5%">Месяц</th>
                                <th width="">Тема</th>
                                <th width="10%">Поток<br>Группа/подгр.</th>
                                <th width="10%">Период обучения</th>
                                <th width="10%">тип занятия</th>
                                <th width="10%">часы</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan='6'>Аудиторная нагрузка</th>
                            </tr>
                            
                   @foreach(\App\Timetable::select()
                   ->leftjoin('blocks', 'blocks.id', '=', 'timetable.block_id')
                   ->join('groups', 'groups.id', '=', 'timetable.group_id')
                   ->join('streams', 'streams.id', '=', 'groups.stream_id')
                   ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                   ->where('teachers2timetable.teacher_id', $user_id)
                   ->where('streams.year', $year)
                   ->whereBetween('timetable.month', [$month1, $month2])
                   ->orderby('timetable.month')
                   ->orderby('streams.date_start')
                   ->orderby('blocks.name')
                   ->get() as $timetable
                   )
                   <tr>
                       <td>{{ \Logbook::month($timetable->month)}}</td>
                       <td>
                           {{ @str_limit($timetable->block->name, 80)}}
                       </td>
                       <td>
                        @if (Auth::user()->role_id == 3)
                        <nobr><a href="{{ url('/')}}/stream/{{$timetable->group->stream_id}}/edit">{{$timetable->group->stream->name}}</a></nobr>,
                        @else
                        <nobr>{{$timetable->group->stream->name}}</nobr>,
                        @endif
                        <nobr>группа {{$timetable->group->name}}
                        @if ($timetable->subgroup)
                        /{{$timetable->subgroup}}
                        @endif 
                        </nobr></td>
                       <td>
                        <nobr>{{date('d.m', strtotime($timetable->group->stream->date_start))}}<nobr> - <nobr>{{date('d.m', strtotime($timetable->group->stream->date_finish))}}</nobr>
                       </td>
                       <td>{{ $timetable->lesson_type->name}}</td>
                       <td>{{ $timetable->hours}}</td>

                   </tr>
                   
                   @php 
                   $hours_total += $timetable->hours;
                   @endphp
                   @endforeach


                        <tr>
                        
                        
                        <th colspan='6'>Внеаудиторная нагрузка</th>
                        
                        </tr>
                        
                    @foreach(\App\Vneaud::where('user_id', $user_id)
                    ->whereMonth('date', '>=', $month1)
                    ->whereMonth('date', '<=', $month2)
                    ->orderby('date')->get() as $vneaud)
                    <tr><td></td>
                        <td>{{ $vneaud->lessontype->name }}</td>
                        <td><nobr>{{ $vneaud->group->stream->name }}</nobr>, <nobr>{{ $vneaud->group->name }}</nobr></td>
                        <td>{{ substr(\Logbook::normal_date($vneaud->group->stream->date_start),0, 5) }} - {{ substr(\Logbook::normal_date($vneaud->group->stream->date_finish), 0, 5) }}</td>
                        
                        
                        <td></td>
                        <td>{{ $vneaud->hours }}</td>
                    </tr>
                    @php 
                    $vneaud_hours += $vneaud->hours;
                    @endphp
                    
                    @endforeach
                        </tbody>
                        
                        <tfoot>
                       <tr>
                           <td colspan='5'>ИТОГО</td>

                            <td>{{ ($hours_total + $vneaud_hours) }}</td>
                           
                           
                       </tr>
                   </tfoot>        
                        
                        <tfoot>
                            
                            <tr>
                                <td colspan='5'>Итого внеаудиторной нагрузки</td>
                                <td>{{ $vneaud_hours}}</td>
                            </tr>
                        </tfoot>
                        
                       <tfoot>
                       <tr>
                           <td colspan='5'>Итого аудиторной нагрузки</td>

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

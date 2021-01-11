
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
                <div class="panel-heading ">Нагрузка преподавателя - {{$year}}</div>

                <div class="panel-body">

                    <form method="get">
                        <p>
                            <a href="{{route('home')}}">В начало</a>
                        </p>
                        @if (in_array(Auth::user()->role_id, [3,4,5,6]))
                            <select name="user_id" class="form-control-static">
                            
                            @foreach(\App\User::where('department_id', Auth::user()->department_id)->where('role_id', 2)->orderby('name')->get() as $user)
                            @if($user->id == $user_id)
                            <option value='{{$user->id}}' selected>{{ $user->name }}</option>
                            @else
                            <option value='{{$user->id}}'>{{ $user->name }}</option>
                            @endif
                            @endforeach
                            </select>
                        @else
                        <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
                        @endif
                        
                        Месяц 1: <input type="number" name="month1" value="{{$month1}}" min="1" max="12" class="form-control-static">
                        Месяц 2:  <input type="number" name="month2" value="{{$month2}}" min="1" max="12" class="form-control-static">
                        Год: <input type='number' name='year' value='{{$year}}' class="form-control-static">
                        
                        <button class="btn btn-success">Обновить</button>
                    <p>Для печати нажмите Ctrl + P</p>
                    </form>
                    
                    @if($user_id)
                    
                    <hr>
                    <h3>{{ \App\User::where('id', $user_id)->first()->name}}</h3>
                    <table class='table table-bordered' id="">

                        <thead>
                        <tr class='alert-info'>
                            
                            <td>Занятия / месяцы</td>
                            @for ($month = $month1; $month<=$month2; $month++)
                            <td>{{ $month }}</td>
                            @endfor        
                            <td>Итого</td>
                        </tr>  
                        </thead>
                        <tbody>
                    
                        @foreach(\App\Lessontype::where('vneaud', 0)->where('in_table', 1)->orderby('id')->get() as $lessontype)
                        @php 
                        $hours_total = 0;
                        
                        @endphp
                        <tr>
                            <td>{{ $lessontype->name }}</td>
                            @for ($month = $month1; $month<=$month2; $month++)
                            <td>
                                @php
                                $hours = \App\User::user_hours_workload($user_id, $month, $year, $lessontype->id);
                                $hours_total += $hours;
                                $hours_total_month[$month] += $hours;
                                @endphp
                        <details>
                            <summary>{{ $hours }}</summary>
                            @foreach(\App\User::user_workload_groups($user_id, $month, $year, $lessontype->id) as $tmp)
                            <li><a href="{{url('/')}}/workload/edit/{{$tmp->id}}">Группа {{$tmp->group->name}} ::  {{$tmp->hours}}ч.</a></li>
                            @endforeach
                        </details>
                        
                                
                            </td>
                            @endfor
                            <td>{{ $hours_total or ''}}</td>
                        </tr>    
                        @endforeach
                         
                        <tr><td></td></tr>
                        @foreach(\App\Lessontype::where('vneaud', 1)->where('in_table', 1)->orderby('id')->get() as $lessontype)
                        @php ($hours_total = 0)
                        <tr>
                            <td>{{ $lessontype->name }}</td>
                            @for ($month = $month1; $month<=$month2; $month++)
                            <td>
                                @php
                                $hours = \App\User::user_hours_vneaud($user_id, $month, $year, $lessontype->id);
                                $hours_total += $hours;
                                $hours_total_month[$month] += $hours;
                                @endphp
                                {{ $hours }}
                                

                                
                                
                                
                            </td>
                            @endfor
                            <td>{{ $hours_total or ''}}</td>
                        </tr>    
                        @endforeach                            
                            

                        <tfoot>
                            <tr>
                        <td>ИТОГО</td>
                        @php ($total = 0)
                        @for ($month = $month1; $month<=$month2; $month++) 
                        <td>{{$hours_total_month[$month]}}
                        @php ($total += $hours_total_month[$month])
                        </td>
                        @endfor
                        <td>{{$total}}</td>
                        </tr>
                        </tfoot>
                    </tbody>
                </table>
                    
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

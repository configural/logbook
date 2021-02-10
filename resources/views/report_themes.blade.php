@php
$total_hours = 0;
$total_hours_distributed = 0;

@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Дисциплины кафедры (укрупненные темы)</div>

                <div class="panel-body">
                    <form method="post">
                        <p>
                        <label>Кафедра</label>
                        <select name="department_id" class='form-control-static'>
                                @foreach(\App\Department::get() as $department)
                                @if ($department->id == $department_id)
                                @php 
                                $kaf = $department->name;
                                @endphp
                                <option value='{{$department->id}}' selected>{{$department->name}}</option>
                                @else
                                <option value='{{$department->id}}'>{{$department->name}}</option>
                                @endif
                                @endforeach
                        </select>
                        </p>
                        <p>
                        <label>С месяца: </label>
                        @if ($date1)
                        <input class='form-control-static' type='number' name='date1' value='{{$date1}}' min='1' max='12'>
                        @else
                        <input class='form-control-static' type='number' name='date1' value='1' min='1' max='12'>
                        @endif
                        <label>по месяц: </label> 
                        @if ($date2)
                        <input class='form-control-static' type='number' name='date2' value='{{$date2}}' min='1' max='12'>
                        @else
                        <input class='form-control-static' type='number' name='date2' value='12' min='1' max='12'>
                        @endif   
                        
                        <label>Год: </label> 
                        @if ($date2)
                        <input class='form-control-static' type='number' name='year' value='{{$year}}'  min='2020' max='2099'>
                        @else
                        <input class='form-control-static' type='number' name='year' value='{{ date('Y') }}' min='2020' max='2099'>
                        @endif 
                        
                        @php
                        if ($date1 == 1 and $date2 == 12) {$full_year = true;}
                        else {$full_year = false;}
                        
                        @endphp
                        <p>
                        
                        
                        </p>                       
                        </p>
                        {{ csrf_field() }}
                        <button class='btn btn-success'>Сформировать</button>

                    
                    
                    </form>
                    
                    
                    
                    @if($date1 && $date2)
                    
                    
                    
                    <h2>Кафедра {{ $kaf }}</h2>
                    
                    @if ($date1 != $date2)
                        <h3>Месяцы: {{ sprintf('%02d — %02d', $date1, $date2) }}</h3>
                    @else
                        <h3>Месяц: {{ sprintf('%02d', $date1) }}</h3>
                    @endif
                    
                    <table class='table table-bordered' id="">
                    <thead>
                        <tr>
                            <th>Укрупненная тема</th>
                            <th>Не распределено часов</th>
                            <th>Распределено часов</th>
                            <th>Всего часов</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Largeblock::where('department_id', $department_id)->orderby('name')->get() as $largeblock)
                        <tr>
                        <td>{{ $largeblock->name}}</td>
                        
                        <td>
                            @php
                            $hours1 = \App\Largeblock::largeblock_hours_undistributed($largeblock->id, $date1, $date2, $year);
                            $total_hours += $hours1;
                            @endphp
                            {{$hours1}}
                        </td>
                        <td>
                            @php
                            $hours2 = \App\Largeblock::largeblock_hours_distributed($largeblock->id, $date1, $date2, $year);
                            $total_hours_distributed += $hours2;
                            @endphp
                            {{$hours2}}
                        </td>
                        @php
                        $delta = $hours1 + $hours2;
                        @endphp
                        <td>{{ $delta }}</td>
                        </tr>
                        @endforeach
                        

                        <tr>
                            <td>Аттестация, защита (укрупненная тема не указана или отсутствует)</td>
                            
                            <td>
                                -
                            </td>
                            <td>
                                -
                                
                            </td>
                            
                            
                            <td>{{
                                $attest_distrib = \App\Timetable::select()
                                    ->leftjoin('blocks', 'blocks.id', '=', 'timetable.block_id')
                                    ->leftjoin('largeblocks', 'largeblocks.id', '=', 'blocks.largeblock_id')
                                    ->join('lesson_types', 'lesson_types.id', '=', 'timetable.lessontype')
                                    ->leftjoin('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                    ->join('users', 'users.id', '=', 'teachers2timetable.teacher_id')
                                    ->join('departments', 'departments.id', '=', 'users.department_id')
                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                    ->join('streams', 'groups.stream_id', '=', 'streams.id')
                                    ->where('users.department_id', $department_id)
                                    ->where('streams.year', $year)
                                    ->whereBetween('timetable.month', [$date1, $date2])
                                    ->where('largeblocks.id', NULL)
                                    ->where('lesson_types.in_table', 1)
                                    ->where('teachers2timetable.id', '!=',  NULL)
                                    ->sum('timetable.hours')
                                }}
                            </td>

                            
                        </tr>
                         <tr>
                            <td>Внеаудиторная нагрузка</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                
                                {{
                                $total_vneaud = \App\Vneaud::select('vneaud.hours')
                                        ->join('users', 'users.id', '=', 'vneaud.user_id')
                                        ->join('departments', 'departments.id', '=', 'users.department_id')
                                        ->where('departments.id', $department_id)
                                        ->whereMonth('date', '>=', $date1 )
                                        ->whereMonth('date', '<=', $date2 )
                                        ->sum('vneaud.hours')
                                }}
                                
                                
                            </td>
                            
                        </tr>                       
                        
                    </tbody>
                    <tfoot>
                        <tr>
                        <td>ИТОГО аудиторной</td>
                        <td>{{$total_hours}}</td>
                        <td>{{$total_hours_distributed}}</td>
                        <td>
                            @php ($delta = $total_hours + $total_hours_distributed)
                            {{$delta}}
                        </td>
                    </tr>
                    <tr><td>ВСЕГО</td>
                        <td></td>
                        <td></td>
                        <td> {{ $total_vneaud + $delta + $attest_distrib}}</td>
                    </tr>
                        </tfoot>
                    </table>
                    
                    <strong>
                        Важно! Приведенные выше аудиторные часы считаются ПО НАГРУЗКЕ и они ориентировочные, так как не учитывают, 
                        что нагрузка может объединяться в расписании (при этом реальных часов становится меньше). 
                        Фактическую нагрузку преподавателей можно посмотреть в разделе 
                        "<a href="{{route('workloadmy')}}">Нагрузка преподавателей</a>", выбрав источник данных "Расписание".
                    </strong>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

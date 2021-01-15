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
                        <input class='form-control-static' type='integer' name='date1' value='{{$date1}}' min='1' max='12'>
                        @else
                        <input class='form-control-static' type='integer' name='date1' value='1' min='1' max='12'>
                        @endif
                        <label>по месяц: </label> 
                        @if ($date2)
                        <input class='form-control-static' type='integer' name='date2' value='{{$date2}}' min='1' max='12'>
                        @else
                        <input class='form-control-static' type='integer' name='date2' value='12' min='1' max='12'>
                        @endif                        
                        </p>
                        {{ csrf_field() }}
                        <button class='btn btn-success'>Сформировать</button>
                        
                    </form>
                    @if($date1 && $date2)
                    <h2>Кафедра {{ $kaf }}</h2>
                    <h3>Месяцы: {{$date1}} — {{$date2}}</h3>
                    <table class='table table-bordered'>
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
                            $hours1 = \App\Largeblock::largeblock_hours_undistributed($largeblock->id, $date1, $date2);
                            $total_hours += $hours1;
                            @endphp
                            
                            {{$hours1}}
                        </td>
                        
                                                <td>
                            @php
                            $hours2 = \App\Largeblock::largeblock_hours_distributed($largeblock->id, $date1, $date2);
                            $total_hours_distributed += $hours2;
                            @endphp
                            
                            {{$hours2}}
                        </td>
                        @php
                        $delta = $hours1 + $hours2;
                        @endphp
                        <td>{{ $delta }}</td>
                        <tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                        <td>ИТОГО</td>
                        <td>{{$total_hours}}</td>
                        <td>{{$total_hours_distributed}}</td>
                        <td>
                            @php ($delta = $total_hours + $total_hours_distributed)
                            {{$delta}}
                        </td>
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

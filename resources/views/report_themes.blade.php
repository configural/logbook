
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Дисциплины кафедры (подсчет нагрузки)</div>

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
                        <label>Дата 1</label>
                        @if ($date1)
                        <input class='form-control-static' type='date' name='date1' value='{{$date1}}'>
                        @else
                        <input class='form-control-static' type='date' name='date1' value=@php echo date('Y'); @endphp-01-01>
                        @endif

                        @if ($date2)
                        <input class='form-control-static' type='date' name='date2' value='{{$date2}}'>
                        @else
                        <input class='form-control-static' type='date' name='date2' value=@php echo date('Y'); @endphp-12-31>
                        @endif                        
                        </p>
                        {{ csrf_field() }}
                        <button class='btn btn-success'>Сформировать</button>
                        
                    </form>
                    @if($date1 && $date2)
                    <h2>Кафедра {{ $kaf }}</h2>
                    <h3>Период: {{$date1}} – {{$date2}}</h3>
                    <table class='table table-bordered'>
                        <tr>
                            <th>Дисциплина</th>
                            <th>Часов</th>
                        </tr>
                    
                    @php ($total_hours = 0)    
                    @foreach($disciplines as $d)
                    @php 
                    $hours = \App\Discipline::hours_by_discipline_name($d->name, $date1, $date2, $department_id);
                    $total_hours += $hours;
                    @endphp
                    
                    <tr> 
                        <td>{{$d->name}}</td>
                        <td>{{ $hours }}</td>
                        
                        
                    </tr>
                    @endforeach
                    <tr>
                        <td>ИТОГО</td>
                        <td>{{ $total_hours}}</td>
                    </tr>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

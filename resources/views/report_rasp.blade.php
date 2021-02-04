@php

if (isset($_GET["group_id"]))
{$group_id = $_GET["group_id"];
$date_start = \App\Group::select('streams.date_start')
    ->join('streams', 'streams.id', '=',  'groups.stream_id')
    ->where('groups.id', $group_id)
    ->first()->date_start;

$date_finish = \App\Group::select('streams.date_finish')
    ->join('streams', 'streams.id', '=', 'groups.stream_id')
    ->where('groups.id', $group_id)
    ->first()->date_finish;    
}
else 
{$group_id = 0;
$date_start = date('Y') ."-01-01";
$date_finish = date('Y') ."-12-31";
}

@endphp
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Печать расписания</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="post" action="{{route('rasp_xls')}}">
                        <p><label>Группа</label> <br/>
                        <select name="group_id" class="form-control-static">
                            @foreach(\App\Group::select('groups.*')
                            ->join('streams', 'groups.stream_id','=', 'streams.id')
                            ->where('streams.active', 1)
                            ->where('streams.date_finish', '>=', $date)
                            ->orderby('groups.name')
                            ->get() as $group)
                            @if($group->id == $group_id)
                            <option value="{{ $group->id }}" selected>Группа {{ $group->name }} :: {{ $group->stream->name }}</option>
                            @else
                            <option value="{{ $group->id }}">Группа {{ $group->name }} :: {{ $group->stream->name }}</option>
                            @endif
                            @endforeach
                            
                        </select>
                        <p>
                            <label>Период: </label><br/>
                            <input type="date" name="date1" class="form-control-static" min="{{ $date_start}}" max="{{ $date_finish}}" required>
                            <input type="date" name="date2" class="form-control-static" min="{{ $date_start}}" max="{{ $date_finish}}" required>

                        </p>
                        <p>
                            <label>Перерыв на обед:</label><br/>
                            <select name="obed" class="form-control-static">
                                <option value="11.00 – 12.00">11.00 – 12.00</option>
                                <option value="11.10 – 12.10">11.10 – 12.10</option>
                                <option value="11.20 – 12.20">11.20 – 12.20</option>
                                <option value="11.50 – 12.50">11.50 – 12.50</option>
                                <option value="11.50 – 13.20">11.50 – 13.20</option>
                                <option value="12.00 – 13.00">12.00 – 13.00</option>
                                <option value="12.20 – 13.20">12.20 – 13.20</option>
                                <option value="12.50 – 13.50">12.50 – 13.50</option>
                            </select>
                        </p>
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                    </form>
 

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

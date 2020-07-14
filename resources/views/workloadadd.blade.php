
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                                    <form >
                        Взять нагрузку
                    </form>
                </div>

                <div class="panel-body">
                    <p><h3>{{ $timetable->block->name}}</h3></p>
                <p>Часов - {{ $timetable->hours }}</p>
                <p>Тип занятия - {{ $timetable->lessontype }}</p>
                <p>Группа: <strong>{{$timetable->group->name}}</strong>, поток: <strong>{{$timetable->group->stream->name}}</strong></p>
                <p>Начало обучения: {{$timetable->group->stream->date_start}}</p>
                <p>Окончание обучения: {{$timetable->group->stream->date_finish}}</p>
                    <hr>
                    <form action='' method='post'>
                        <input type="hidden" name="id" value="{{$timetable->id}}">
                        <hr>
                        <p>В каком месяце вы готовы вести занятия: 
                        <select name="month" class="form-control-static">
                            
                            @php ($n = date('n'));
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($i == $n ) <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    <hr>   
                    <button class="btn btn-success">Взять эту нагрузку</button>
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

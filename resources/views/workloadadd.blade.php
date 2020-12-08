
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    

                                    <form >
                        Взять нагрузку – подтверждение
                    </form>
                </div>

                <div class="panel-body">

                    <p><a href="{{route('home')}}">В начало</a> –
                    <a href="{{route('workload')}}">Нагрузка</a>
                    </p>
                                            
                                            
                    <p><h3>{{ $timetable->block->name or ''}}</h3></p>
                <h4 class="orange">{{ $timetable->hours }} ч, 
                    {{ $timetable->lesson_type->name }}</strong></h4>
                <p>Группа: <strong>{{$timetable->group->name}}</strong>, поток: <strong>{{$timetable->group->stream->name}}</strong></p>
                <p>Период обучения: <strong>{{$timetable->group->stream->date_start}} — {{$timetable->group->stream->date_finish}}</strong></p>
                    <hr>
                    <form action='' method='post'>
                        <input type="hidden" name="id" value="{{$timetable->id}}">
                        <p>В каком месяце вы готовы вести занятия: 
                        <select name="month" class="form-control-static">
                            
                            @php 
                            $n = date('n');
                            $start = explode("-", $timetable->group->stream->date_start)[1];
                            $finish = explode("-", $timetable->group->stream->date_finish)[1];
                            @endphp
                            @for ($i = $start; $i <= $finish; $i++)
                                @if ($i == $n ) <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                        <p>
                            (Эта информация может быть использована методистом при составлении расписания)
                        </p>
                    <hr>   
                    <p><button class="btn btn-lg btn-success">Да, я действительно готов(а) взять эту нагрузку</button></p>
                    <p>
                        Вы сможете отказаться от этой нагрузки, нажав кнопку "Отказаться" в таблице нагрузки, но только до тех пор, пока она не будет внесена в расписание.
                        Если тема уже была включена в расписание, но вы не готовы ее вести, обратитесь к методисту.
                    </p>
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

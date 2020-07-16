
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
                @php ($timetable = \App\Timetable::find($id))
                <p><h3>{{ $timetable->block->name}}</h3></p>
                <p>Часов - {{ $timetable->hours }}</p>
                <p>Тип занятия - {{ $timetable->lessontype }}</p>
                <p>Группа: <strong>{{$timetable->group->name}}</strong>, поток: <strong>{{$timetable->group->stream->name}}</strong></p>
                <p>Начало обучения: {{$timetable->group->stream->date_start}}</p>
                <p>Окончание обучения: {{$timetable->group->stream->date_finish}}</p>
                    <hr>
                    <form action='' method='post'>
                        <input type="hidden" name="id" value="{{$timetable->id}}">
                        <p>Преподавател(и)</p>

                        <select name="teachers[]" multiple class="form-control-static">
                            @foreach(\App\User::select()->get() as $user)
                            @php($in_list = 0)
    
                            @foreach($timetable->teachers as $teacher)
                                
                                @if($teacher->id == $user->id) 
                                @php($in_list = 1)
                                @endif
                                @endforeach
                                @if($in_list)
                                <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                @else
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endif
                            
                            @endforeach
                        </select>
                        <hr>
                        <p>Месяц: 
                        <select name="month" class="form-control-static">
                            
                            @php ($n = date('n'));
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($i == $n ) <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    <hr>   
                    <button class="btn btn-success">Сохранить нагрузку</button>
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

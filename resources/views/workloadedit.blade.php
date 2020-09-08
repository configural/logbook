
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
                <p><h3>{{ $timetable->block->name or ''}}</h3></p>
                <h4>{{ $timetable->lesson_type->name }}, {{ $timetable->hours }} ч.</h4>
                <p>Группа: <strong>{{$timetable->group->name}}</strong>, поток: <strong>{{$timetable->group->stream->name}}</strong></p>
                <p>Период обучения: {{$timetable->group->stream->date_start}} — {{$timetable->group->stream->date_finish}}</p>
                    <hr>
                    <form action='' method='post'>
                        <input type="hidden" name="id" value="{{$timetable->id}}">
                        <p>Преподавател(и)</p>

                        <select name="teachers[]" multiple class="form-control" style="height: 600px;">
                            @foreach(\App\User::select()->where('role_id', 2)->orderBy('name')->get() as $user)
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
                    <p>
                     @if (!$timetable->rasp_id)
                    <button class="btn btn-success">Сохранить нагрузку</button>
                    @else
                    Как изменить? Сначала уберите из расписания. Занятие назначено на <a href="{{url('rasp')}}?date={{$timetable->rasp->date}}">{{$timetable->rasp->date}}</a>
                    @endif
                    </p>
                    <p>
                    @if (!$timetable->teachers->count() && !$timetable->rasp_id)
                    <a class="btn btn-danger pull-right" href="{{url('workload')}}/delete/{{$id}}"  onClick="return window.confirm('Нагрузка будет удалена. Продолжить?');" >Удалить нагрузку</a>
                    @else
                    <span class="pull-left">Как удалить? Уберите эту нагрузку из расписания и удалите привязку преподавателей.</span>
                    @endif
                    </p>
                    {{ csrf_field() }}
                    </form>
                    
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

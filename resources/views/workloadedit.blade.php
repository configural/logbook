
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
                        <label>Подгруппа (если деление на подгруппы не предусмотрено, оставьте поле ПУСТЫМ): </label>
                        <input type='number' name='subgroup' value='{{$timetable->subgroup}}' class='form-control-static'>
                    @if (isset($timetable->rasp->date))
                    
                        Занятие назначено на 
                        <input type="date" id="dateField" value="{{$timetable->rasp->date}}" disabled> 
                        c <input type="time" id="startAt" value="{{ $timetable->rasp->start_at }}" disabled> до 
                        <input type="time" id="finishAt" value="{{ $timetable->rasp->finish_at }}" disabled>
                         <br>
                        <a href="{{url('rasp')}}?date={{$timetable->rasp->date}}">Перейти в расписание</a>.
                        <hr>
                    @else
                        <input type="hidden" id="dateField" value="{{--{{$timetable->group->stream->date_start}}--}}    " disabled> 
                    
                    @endif
                        <div class="row">
                            <div class="col-lg-6">
                        <input type="hidden" name="id" value="{{$timetable->id}}">
                        <h3>Преподаватель(ли)</h3>
                        <p>Для выделения сразу нескольких строк используйте левый клик мыши с нажатой клавишей Ctrl. Если вы выбираете внештатного преподавателя, нужно указать договор, по которому он будет работать.</p>

                        <select id="teacherSelect" name="teachers[]" multiple class="form-control" style="height: 600px;">
                            @foreach(\App\User::select()->whereIn('role_id', [2, 5])->orderBy('name')->get() as $user)
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
                            </div>
                            
                            
                            
                            <div class="col-lg-6">
                        
                        <p>Месяц: 
                        <select name="month" class="form-control-static">
                            
                            @php $n = date('n');
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
                        <span id="teacherBusy"><span>
                        
                        
                    </p>
                    </div>
                    </div>
                                            <hr>

                    <p>

                    <button class="btn btn-success">Сохранить нагрузку</button>

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

<script>

$(document).ready(function() {
    
    if ($('#dateField').val()) checkTeachers();
    
    $("#teacherSelect").click(function() {
        
            checkTeachers();
    });
    


function checkTeachers() {
    
    $('#teacherBusy').html("");
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var date = $('#dateField').val();      
    var selectedTeachers = $('#teacherSelect :selected').toArray().map(item => item.value);  

    selectedTeachers.forEach(function(item) {
    
    var url = "{{url('/')}}/ajax/teacher_busy/" + item + ";" + date + ";" + start_at + ";" + finish_at + ";" + {{$id}};
    console.log(url);
    $.ajax({
        url: url, 
        success: function(param) { $('#teacherBusy').append(param);  }
    });
        
    });
    }

});


</script>
    
    
@endsection

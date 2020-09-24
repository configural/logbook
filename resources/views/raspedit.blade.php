
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
Перенос занятия                    
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id >= 3)
                    <form action="" method="post">
                        <input name="id" type="hidden" value="{{$rasp->id}}">
                        <p><strong>Тема занятия:</strong> {{ $rasp->timetable->block->name or ''}}</p>
                        <p><strong>Группа:</strong> {{ $rasp->timetable->group->name}}</p>
                       
                        <p><strong>Преподаватель(и):</strong><br>
                            <select id='teacherSelect' disabled  multiple="1">
                            @foreach($rasp->timetable->teachers as $teacher)
                            <option value='{{$teacher->id}}'>{{$teacher->name}}</option>
                            @endforeach
                            </select><br/>
                            <a href="{{ url('workload')}}/edit/{{ $rasp->timetable->id }}" class="btn btn-primary btn-sm">Переназначить преподавателей</a>
                        </p>
                        <hr>
                        <p>
                        Дата:<br/> <input name="date" id="date" type="date" value="{{$rasp->date}}" class="form-control-static">
                        <input name="date_copy" type="hidden" value="{{$rasp->date}}">
                        </p>
                        <p>Время:<br/>
                            <input type="time" id="startAt" name="start_at" value="{{$rasp->start_at}}" class="form-control-static" required>
                            <input type="time" id="finishAt" name="finish_at" value="{{$rasp->finish_at}}" class="form-control-static" required>
                        </p>
                        
                        <p>Аудитория:
                            <select id="classroom" name="room_id" class="form-control">
                            @foreach(\App\Classroom::select()->get() as $room)
                            @if($room->id == $rasp->room_id) 
                            <option value="{{$room->id}}" selected>{{$room->name}} :: {{$room->address}}</option>
                            @else
                            <option value="{{$room->id}}">{{$room->name}} :: {{$room->address}}</option>
                            @endif
                            @endforeach
                            </select>
                            <input type="hidden" name="timetable_id" value="{{$rasp->timetable_id}}">
                       </p>                        
                        
                        <p>
                           Аудитория занята:
                           <span id="classroomBusy" class="red"></span>
                          
                           
                       </p>

                        
                        
                       <div class="container-fluid">
                           <div class="row-fluid">
                           
                           <div class="col-lg-6"><span id="teacherBusy"></span></div>
                           <div class="col-lg-6"><span id="groupBusy"></span></div>
                           </div>
                       </div>
                       
                
                        
                        {{csrf_field()}}
                        <button class="btn btn-success">Сохранить</button>
                    </form>
                    <p>
                        
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('document').ready(function(){
    
    check_classroom(); check_teacher(); check_group();
    
$('#classroom').change(function() { check_classroom(); check_teacher(); check_group();});
$('#date').change(function() { check_classroom(); check_teacher(); check_group();});
$('#startAt').change(function() { check_classroom(); check_teacher(); check_group();});
$('#finishAt').change(function() { check_classroom(); check_teacher(); check_group();});

function check_classroom() {
    var room_id = $("#classroom option:selected").val();
    var date = $('#date').val();
    //    console.log("{{url('/')}}/ajax/classroom_busy/" + room_id + ";" + date);
        $.ajax({
        url: "{{url('/')}}/ajax/classroom_busy/" + room_id + ";" + date, 
        success: function(param) { $('#classroomBusy').html(param);  }
        });
    }


function check_teacher() {
    $('#teacherBusy').html("");
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var date = $('#date').val();

    var selectedTeachers = $('#teacherSelect option').toArray().map(item => item.value);  
    console.log(selectedTeachers);
        selectedTeachers.forEach(function(item) {
    
    var url = "{{url('/')}}/ajax/teacher_busy/" + item + ";" + date + ";" + start_at + ";" + finish_at;
    console.log(url);
    $.ajax({
        url: url, 
        success: function(param) { $('#teacherBusy').append(param);  }
    });
        
    });

/*
    var teacher = {{$rasp->timetable->teachers->first()->id}};
    var date = $('#date').val();
        if (start_at && finish_at) {
        //console.log(date + ";" + start_at + ";" + finish_at);
    $.ajax({
        url: "{{url('/')}}/ajax/teacher_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) { $('#teacherBusy').html(param);  }
        
    });
    }*/
    check_group();
}

function check_group() {
    var start_at = "00:00";
    var finish_at = "23:59";
    var group_id = {{ $rasp->timetable->group_id }};
    var date = $('#date').val();

    if (start_at && finish_at) {
        //console.log("{{url('/')}}/ajax/group_busy/" + group_id + ";" + date + ";" + start_at + ";" + finish_at);
        
        $.ajax({
        url: "{{url('/')}}/ajax/group_busy/" + group_id + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) { $('#groupBusy').html(param);  }
        });
    }
}
});
</script>
@endsection

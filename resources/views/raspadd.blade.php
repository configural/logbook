
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                    <form >
                        Редактирование строки расписания
                    </form>
                </div>

                <div class="panel-body">

                    @if(Auth::user()->role_id == 4)
                    <form action="{{url('rasp/edit')}}/0" method="post">
                        <input name="id" type="hidden" value="">
                        
                        Дата: <input name="date" id="date" type="date" value="{{$date}}" class="form-control-static">
                        
                        
  
                        </p>
                        

                       <input name="room_id" type="hidden" value="{{$room}}">
                       <p>
                           Аудитория занята:
                           @php ($i = 0)
                           @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room)->orderby('start_at')->get() as $rasp)
                           <br/><span class="red">{{$rasp->start_at}} – {{$rasp->finish_at}}</span>
                           @php ($i++)
                           @endforeach
                           @if ($i == 0) 
                           свободна весь день!
                           @endif
                           
               
                        <p>Занятие (из распределенной нагрузки):
                            
                            <select name="timetable_id" class="form-control" required id="timetableId">
                                <option value="">Выберите!</option>
                            @foreach(\App\Timetable::select()->whereNull('rasp_id')->orderBy('block_id')->orderBy('lessontype')->get() as $timetable)
                            
                            @foreach($timetable->teachers as $teacher)
                            <option value="{{$timetable->id}}" data-hours="{{$timetable->hours}}" data-teacher="{{$teacher->id}}">{{$timetable->hours}} ч ({{$timetable->lesson_type->name}}) :: {{$timetable->group->name}} 
                                @if($timetable->subgroup)
                                (подгруппа {{$timetable->subgroup }})
                                @endif
                                :: {{$timetable->block->name}} ({{$teacher->name}})
                            </option>
                            @endforeach
                            @endforeach
                            </select>
                           
                       </p>
                       <span id="teacherBusy"></span>
                       <p>Время занятий: <strong><span id="needHours" class="red"></span></strong><br/>
                       <input type="time" id="startAt" name="start_at" class="form-control-static" required>
                       <input type="time" id="finishAt" name="finish_at" class="form-control-static" required>
                       </p>                            
                       
                       <span id="groupBusy"></span>
                        </p>
                        {{csrf_field()}}
                        <button class="btn btn-success" id="saveButton">Сохранить</button>
                    </form>
                   
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#timetableId').change(function(){
    var hours = $('#timetableId option:selected').data('hours');
    $('#needHours').html(hours + " часа");
    
    check_teacher();
    
});

$('#startAt').change(function() {check_teacher();});
$('#finishAt').change(function() {check_teacher();});

function check_teacher() {
    var start_at = "00:00";//$('#startAt').val();
    var finish_at = "23:59";// $('#finishAt').val();
    var teacher = $('#timetableId option:selected').data('teacher');

    var date = $('#date').val();
        if (start_at && finish_at) {
        console.log(date + ";" + start_at + ";" + finish_at);
    $.ajax({
        url: "{{url('/')}}/ajax/is_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) { $('#teacherBusy').html(param);  }
        
    });
    }
}

function check_group() {
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var teacher = $('#timetableId option:selected').data('teacher');

    var date = $('#date').val();
        if (start_at && finish_at) {
        console.log(date + ";" + start_at + ";" + finish_at);
    $.ajax({
        url: "{{url('/')}}/ajax/is_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) {
            if (param == 1) {$('#teacherBusy').html('Преподаватель в это время занят');
                $('#saveButton').hide();
            }
            else {$('#teacherBusy').html('');
                $('#saveButton').show();
        }
        }
        
    });
    }
}


</script>
@endsection

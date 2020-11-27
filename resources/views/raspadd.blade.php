
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

                    @if(Auth::user()->role_id >= 3)
                    <form action="{{url('rasp/edit')}}/0" method="post">
                        <input name="id" type="hidden" value="">
                        
                        Дата: <input name="date" id="date" type="date" value="{{$date}}" class="form-control-static">
                        
                        <input name="date_copy" type="date" value="{{$date}}" class="form-control-static">
                        
                       Группа: <select id="filterGroup" class='form-control-static'>
                           <option value=''>Выберите</option>
                           @foreach(\App\Group::select()->where('active',1)->orderby('name')->get() as $group)
                           @if($group->stream->active)
                           <option value='{{$group->name}}'>{{$group->name}} ({{$group->students->count()}} чел.) - {{$group->stream->name}}</option>
                           @endif
                           @endforeach
                       </select>                        
                        
  
                        </p>
                        

                       <input name="room_id" type="hidden" value="{{$room}}">
                       

               
                        <p>Занятие (из распределенной нагрузки):
                           
                        <table class="table table-bordered" id="sortTable" data-page-length='10'>
                            <thead>
                            <th width="50"></th>
                            <th>Группа</th>
                            <th>Преподаватель</th>
                            <th>Время и тип занятия</th>
                            <th>Тема</th>
                            
                            </thead>
                            <tbody>
                                
                             @foreach(\App\Timetable::select()->whereNull('rasp_id')->orderBy('block_id')->orderBy('lessontype')->get() as $timetable)
                             @foreach($timetable->teachers as $teacher)
                             <tr>
                                 <td>
                                     <input required type="radio" name="timetable_id" value="{{$timetable->id}}" data-hours="{{$timetable->hours}}" data-teacher="{{$teacher->id}}" data-group_id="{{$timetable->group_id}}">
                                     
                                 </td>
                                 <td>
                                     {{$timetable->group->name}} 
                                @if($timetable->subgroup)
                                (подгруппа {{$timetable->subgroup }})
                                @endif
                                 </td>
                                 <td>
                                     
                                     {{$teacher->name}}
                                 </td>
                                  <td>
                                     {{$timetable->hours}} ч ({{$timetable->lesson_type->name}})
                                 </td>  
                                 <td>
                                     {{ $timetable->block->name or ''}}
                                 </td>

                                                           </tr>
                             @endforeach
                             @endforeach
                            </tbody>
                        </table>
                          
                       <p>Время занятий: <strong><span id="needHours" class="red"></span></strong><br/>
                       <input type="time" id="startAt" name="start_at" class="form-control-static" required>
                       <input type="time" id="finishAt" name="finish_at" class="form-control-static" required>
                       </p>                            
                       
                        
                        
                        
                       </p>
                                                  <strong>{{\App\Classroom::find($room)->name}} ({{\App\Classroom::find($room)->capacity}} мест) занята:</strong>

                       <div class="container-fluid">
                       <p>
                           @php ($i = 0)
                           @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room)->orderby('start_at')->get() as $rasp)
                           <br/><span class="red">{{$rasp->start_at}} – {{$rasp->finish_at}}</span>
                           @php ($i++)
                           @endforeach
                           @if ($i == 0) 
                           свободна весь день!
                           @endif
                           <div class="row-fluid">
                           
                           <div class="col-lg-6"<span id="teacherBusy"></span></div>
                           <div class="col-lg-6"><span id="groupBusy"></span></div>
                       </div>
                       </div>
                       {{csrf_field()}}
                        <button class="btn btn-success" id="saveButton">Сохранить</button>
                        <a href="{{url('room_unlock')}}/{{$date}}/{{$room}}" class="btn btn-info">Выйти без сохранения</a>
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
    

    $('#filterGroup').change(function() {
    var group_name = $("#filterGroup option:selected").val();
   $('#sortTable').DataTable().column( 1 ).search(
        $('#filterGroup').val(),

    ).draw();
});    
    
$('#timetableId').change(function(){
    var hours = $('#timetableId option:selected').data('hours');
    $('#needHours').html(hours + " часа");
    
    check_teacher();
    
    
});

$('#startAt').change(function() {check_teacher(); check_group();});
$('#finishAt').change(function() {check_teacher(); check_group();});

function check_teacher() {
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var teacher = $('#timetableId option:selected').data('teacher');

    var date = $('#date').val();
        if (start_at && finish_at) {
        console.log(date + ";" + start_at + ";" + finish_at);
    $.ajax({
        url: "{{url('/')}}/ajax/teacher_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) { $('#teacherBusy').html(param);  }
        
    });
    }
    check_group();
}

function check_group() {
    var start_at = "00:00";//$('#startAt').val();
    var finish_at = "23:59";// $('#finishAt').val();
   // var start_at = $('#startAt').val();
   // var finish_at = $('#finishAt').val();
    var group_id = $('#timetableId option:selected').data('group_id');

    var date = $('#date').val();
        if (start_at && finish_at) {
        console.log("{{url('/')}}/ajax/group_busy/" + group_id + ";" + date + ";" + start_at + ";" + finish_at);
        
    $.ajax({
        url: "{{url('/')}}/ajax/group_busy/" + group_id + ";" + date + ";" + start_at + ";" + finish_at, 
        success: function(param) { $('#groupBusy').html(param);  }
        
    });
    }
}


</script>
@endsection

@php
$month = (int) substr($date, 5, 2);
@endphp

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
                        <input name="id" type="" value="" id="raspId" readonly>
                        
                        Дата: <input name="date" id="date" type="date" value="{{$date}}" class="form-control-static">
                        
                        <input name="date_copy" type="hidden" value="{{$date}}" class="form-control-static">
                        
                       Группа: <select id="filterGroup" class='form-control-static'>
                           <option value=''>Выберите</option>
                           @foreach(\App\Group::select()->where('active',1)->orderby('name')->get() as $group)
                           @if($group->stream->active && $group->stream->date_start <= $date && $group->stream->date_finish >= $date  )
                           <option value='{{$group->name}}'>Группа {{$group->name}} ({{$group->students->count()}} чел.) - {{$group->stream->name}}</option>
                           @endif
                           @endforeach
                       </select>                        
                        
  
                        </p>
                        

                       <input name="room_id" type="hidden" value="{{$room}}">
                       

               
                        <p>Занятие (из распределенной нагрузки):
                           
                        <table class="" id="sortTable" data-page-length='20'>
                            <thead>
                            <th width="1%"></th>
                            <th width="10%">Группа</th>
                            <th width="10%">Преподаватель</th>
                            <th width="10%">Время и тип занятия</th>
                            <th>Тема</th>
                            <th width="10%">Дата</th>
                            <th width="10%">Время</th>
                            
                            </thead>
                            <tbody>
                             
                             @foreach(\App\Timetable::selectRaw('timetable.*, rasp.start_at, rasp.finish_at, rasp.date')
                             ->leftjoin('rasp', 'rasp.timetable_id', '=', 'timetable.id')
                             ->where('timetable.month', $month)
                             ->orderBy('block_id')
                             ->orderBy('lessontype')
                             ->get() as $timetable)
                             @foreach($timetable->teachers as $teacher)
                             <tr>
                                 <td>
                                     <input required type="radio" id="timetableId" name="timetable_id" value="{{$timetable->id}}" 
                                            data-hours="{{$timetable->hours}}" 
                                            data-teacher="{{$teacher->id}}" 
                                            data-group_id="{{$timetable->group_id}}"
                                            data-rasp_id="{{$timetable->rasp_id}}"
                                            data-start_at="{{$timetable->start_at}}"
                                            data-finish_at="{{$timetable->finish_at}}"
                                            >
                                 </td>
                                 <td>
                            <nobr>Группа {{$timetable->group->name}} 
                                @if($timetable->subgroup)
                                /{{$timetable->subgroup }}
                                @endif</nobr>
                                 </td>
                                 <td>
                                     
                                     {{$teacher->secname()}}
                                 </td>
                                  <td>
                            <nobr>{{$timetable->hours}} ч ({{$timetable->lesson_type->name}})</nobr>
                                 </td>  
                                 <td>
                                     {{ $timetable->block->name or ''}}
                                 </td>
                                 <td>@if ($timetable->date)
                                     {{ \Logbook::normal_date($timetable->date)}}
                                     @else
                                     -
                                     @endif
                                 </td>
                                 <td><nobr>{{ $timetable->start_at}} - {{ $timetable->finish_at}}</nobr></td>

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
                                                  
                      
                       <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="col-lg-3">
                                    <strong><span class="red">{{\App\Classroom::find($room)->name}} занята:</span></strong>
                                        @php ($i = 0)
                                        @foreach(\App\Rasp::select()->where('date', $date)->where('room_id', $room)->orderby('start_at')->get() as $rasp)
                                        <br/>{{$rasp->start_at}} – {{$rasp->finish_at}}
                                        @php ($i++)
                                        @endforeach
                                        @if ($i == 0) 
                                        свободна весь день!
                                        @endif
                                </div>    
                                <div class="col-lg-3"><span id="groupBusy"></span></div>
                                <div class="col-lg-3"><span id="teacherBusy"></span></div>

                            </div>
                       </div>
                       <div style="clear: both"></div>
                       <hr>
                       {{csrf_field()}}
                       <p>
                        <button class="btn btn-success" id="saveButton">Сохранить</button>
                        <a href="{{url('room_unlock')}}/{{$date}}/{{$room}}" class="btn btn-info">Выйти без сохранения</a>
                       </p>
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
    
$('input[type=radio]').change(function(){
    
    var hours = $('#timetableId:checked').data('hours');
    var start_at = $('#timetableId:checked').data('start_at');
    var finish_at = $('#timetableId:checked').data('finish_at');
    var rasp_id =  $('#timetableId:checked').data('rasp_id');
    $('#needHours').html(hours + " часа");
    $('#startAt').val(start_at);
     $('#finishAt').val(finish_at);
    $('#raspId').val(rasp_id);
    
    
    //alert(hours);
    check_teacher();
    
    
});

$('#startAt').change(function() {check_teacher(); check_group();});
$('#finishAt').change(function() {check_teacher(); check_group();});

function check_teacher() {
    
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var teacher = $('input[type=radio]:checked').data('teacher');
    var date = $('#date').val();
    if (start_at && finish_at) {
    console.log(date + ";" + start_at + ";" + finish_at);
    $.ajax({
        url: "{{url('/')}}/ajax/teacher_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at + ";0" , 
        success: function(param) { $('#teacherBusy').html(param);  }
        
    });
    }
    console.log("{{url('/')}}/ajax/teacher_busy/" + teacher + ";" + date + ";" + start_at + ";" + finish_at);

    check_group();
}

function check_group() {
    var start_at = $('#startAt').val();
    var finish_at = $('#finishAt').val();
    var group_id = $('input[type=radio]:checked').data('group_id');
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

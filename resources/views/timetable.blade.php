@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Расписание</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role_id == 4) 
                    <strong>Приветствую тебя, Администратор!</strong>
                    
                    <p>
                    <table class='table table-bordered'>
                        <tr>
                            <th>id</th>
                            <th>Группа, период обучения</th>
                            <th>Дисциплина / Тема</th>
                            <th>Часы</th>
                            <th>Преподаватель</th>
                            <th>Дата, время, аудитория</th>
                        
                            

                        </tr>
                        @foreach(\App\Timetable::select()->get() as $timetable)
                    <tr>
                    <td>{{$timetable->id}}</td>
                    
                        <td>{{$timetable->group->name}}<br>
                        <nobr>{{ $timetable->group->stream->date_start}} ... {{ $timetable->group->stream->date_finish}}</nobr>
                        
                        </td>    
                    
                        <td>{{$timetable->block->discipline->name}}<br/><small>{{$timetable->block->name}}</small></td>
                    
                        <td>{{$timetable->hours}}</td>
                        
                        <td>@if ($timetable->teacher)
                            <button class="btn btn-block setTeacher"   data-id="{{$timetable->id}}" data-teacher_id = "{{$timetable->teacher_id}}" data-toggle="modal" data-target="#timetableTeacher">{{$timetable->teacher->name}}</button>
                            @else
                            <p><button class="btn btn-danger setTeacher"   data-id="{{$timetable->id}}" data-teacher_id = "{{$timetable->teacher_id}}" data-toggle="modal" data-target="#timetableTeacher">Назначить преподавателя</button></p>

                            @endif
                            
                        </td>
                        
                        <td>@if ($timetable->start_at) 
                            <button class="btn btn-block setTime"   data-id="{{$timetable->id}}" data-teacher_id = "{{$timetable->teacher_id}}" data-toggle="modal" data-target="#timetableForm">
                            {{$timetable->start_at}}
                            
                            @if ($timetable->room_id) 
                                {{$timetable->classroom->name}}
                            @endif
                            
                            
                            </button>
                            @endif
                            
      
                            
                        @if (!($timetable->start_at && $timetable->room_id) && $timetable->teacher)
                        <p><button class="btn btn-danger setTime"   data-id="{{$timetable->id}}" data-teacher_id = "{{$timetable->teacher_id}}" data-toggle="modal" data-target="#timetableForm">Назначить место и время</button></p>
                        @endif
                        
                            </td>
                        
                        
                        
                </tr>
                        @endforeach
                    </table>
                
                    <h3>Занятость аудиторий</h3>
                    <form>
                        <input id="selectDate" type="date" class="form-control">
                    </form>
                    <div id="classRooms"></div>
                
                
                
                </p>
                    @elseif (Auth::user()->role_id == 3)
                    <strong>Приветствую тебя, Методист!</strong>
                    

                        
                        
                    @elseif (Auth::user()->role_id == 2)
                    <strong>Приветствую тебя, Преподаватель!</strong>
                    
                    
                    @elseif (Auth::user()->role_id == 1)
                    <strong>Приветствую тебя, Слушатель!</strong>
                    @endif

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальная форма - НАЗНАЧИТЬ ПРЕПОДАВАТЕЛЯ -->
<div class="modal fade" id="timetableTeacher">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Назначить преподавателя</h4>
      </div>
      <form method="post" action="{{url('/')}}/timetable/appoint-teacher">
      <div class="modal-body">
             

            <select class="form-control">
                @foreach (Illuminate\Foundation\Auth\User::select('id', 'name')->get() as $teacher)
                <option value="{{ $teacher->id}}">{{$teacher->name}}</option>
                @endforeach
            </select>
            {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button  class="btn btn-primary">Сохранить</button>
      </div>
                    </form>

    </div><!-- /.модальное окно-Содержание -->  
  </div><!-- /.модальное окно-диалог -->  
</div><!-- /.модальное окно --> 



<!-- Модальная форма - НАЗНАЧИТЬ ВРЕМЯ И МЕСТО -->

<div class="modal fade" id="timetableForm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Назначить время и аудиторию</h4>
      </div>
      <form method="post" action="{{url('/')}}/timetable/appoint-time">
      <div class="modal-body">
        
            <p><input type="text" name="id" id="timetable_id" class="form-control">    </p>
            <p><label>Дата</label> <input id="startDate" type="date" name="start_at_date" class="form-control"></p>
            <p><div id="TeacherWorkload" class="alert-success"></div></p>
            <p><label>Время начала занятия</label> <input type="time" name="start_at_time" class="form-control"></p>
            <p><label>Количество часов</label> <input type="number" name="hours" class="form-control"></p>
            <p><label>Аудитория</label> <input type="text" name="room_id" class="form-control"></p>
            {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button class="btn btn-primary">Сохранить</button>
      </div>
      </form>
    </div><!-- /.модальное окно-Содержание -->  
  </div><!-- /.модальное окно-диалог -->  
</div><!-- /.модальное окно --> 




<script>
$(document).ready(function() {
    var teacher_id;
    var timetable_id;
    $(".setTime").click(function(){
        timetable_id = $(this).data("id");
        $("#timetable_id").val(timetable_id);
        teacher_id = $(this).data("teacher_id");        
        
    }); 


    $("#startDate").change(function() {
        $.ajax({
            type: 'GET',
            url: "{{url('/')}}/ajax/workload/" + $("#startDate").val() + "/" +  teacher_id,
            data: "",
            success: function(data){
                $("#TeacherWorkload").html(data);
                }
        });
    });

// Ajax запрос занятость аудиторий
$("#selectDate").change(function() {
    $.ajax({
        type: 'GET',
        url: "{{url('/')}}/ajax/classrooms/" + $("#selectDate").val(),
        data: "",
        success: function(data) {
            $("#classRooms").html(data);
        }
    });
});

});
</script>


@endsection

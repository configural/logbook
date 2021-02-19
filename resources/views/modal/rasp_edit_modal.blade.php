<h4>{{ $timetable->lesson_type->name }}, {{ $timetable->hours }} ч.</h4>
<p>Группа: {{ $timetable->group->name}}, 
    
    @foreach($timetable->teachers as $t)
    {{ $t->fio() }}
    @endforeach
    
    </p>
<p>{{ $timetable->block->name or '' }}</p>


<form method='' id='editForm'>
    
    <input id='timetable_id' type='hidden' value='{{ $timetable->id }}'>
    <input name='group_id' type='hidden' value='{{ $timetable->group_id }}'> </p>
    <p><label>Дата:</label> <input id='date' name='date' type='date' value='{{ $timetable->rasp->date or ''}}' class='form-control-static' min='{{ $timetable->group->stream->date_start}}' max='{{ $timetable->group->stream->date_finish}}'>  
        <label>Время:</label> <input id='start_at' name='start_at' type='time' value='{{ $timetable->rasp->start_at or '' }}' class='form-control-static'>  <input id='finish_at' name='finish_at' type='time' value='{{ $timetable->rasp->finish_at or ''}}' class='form-control-static'> </p>
    <p><label>Аудитория:</label> <select id='room_id' name='room_id' class='form-control-static'>
            <option value=''>не выбрана</option>
    @if (isset($timetable->rasp->room_id))
    @foreach(\App\Classroom::orderby('name')->where('capacity', '!=', 0)->get() as $room)
        @if ($room->id == $timetable->rasp->room_id)
            <option value='{{$room->id}}' selected>{{$room->name}}</option>
        @else
            <option value='{{$room->id}}'>{{$room->name}}</option>
        @endif
    @endforeach
    @else
    @foreach(\App\Classroom::orderby('name')->get() as $room)
        <option value='{{$room->id}}'>{{$room->name}}</option>
    @endforeach
    @endif
    </select>
    </p>
    <p>
        <a id='btnSubmit' class='btn btn-primary'>Сохранить</a>
    </p>
    <p><div id='status'></div></p>
    
</form>


<script>

$(document).ready(function(){
    check_all();
});

$("input, select").on("change", function() {
    check_all()
});

$(".modal-body").on("show", function() {
    check_all();
});


function check_all() {
    var url = "{{ url('/') }}/ajax/check_all";
    var group_id = "{{ $timetable->group_id}}";
    var date = $('#date').val();
    var start_at = $('#start_at').val();
    var finish_at = $('#finish_at').val();
    var room_id = $('#room_id option:selected').val();
    var teachers = "{{ $teachers }}";
    var data = {'group_id': group_id,
                    'date': date,
                    'start_at': start_at,
                    'finish_at': finish_at,
                    'room_id': room_id,
                    'teachers': teachers
                };
                console.log(data);
    
        $.ajax({
            'url': url,
            'method': 'get',
            'data': data,
            'success': function(param) {$('#status').html(param);}
        });    
}

$('#btnSubmit').on('click', function(){
    var timetable_id = $('#timetable_id').val();
    var date = $('#date').val();
    var start_at = $('#start_at').val();
    var finish_at = $('#finish_at').val();
    var room_id = $('#room_id option:selected').val();
    var url = "{{ url('/') }}/ajax/rasp_update";
    
    var data = {'timetable_id' : timetable_id,
                'date' : date,
                'start_at' : start_at,
                'finish_at' : finish_at,
                'room_id' : room_id
         };
    console.log(data);
    $.ajax({
        'url' : url,
        'method' : 'get',
        'data' : data,
        success: (function(param) {
            $('#myModal').modal('hide');
            $('#groupSelect').change();
            //location.reload();
            //$('#status').html(param);
        })
    });
    
});


</script>

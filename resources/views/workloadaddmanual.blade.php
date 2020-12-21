
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                                    <form >
                        Создать аудиторную нагрузку вручную
                    </form>
                </div>

                <div class="panel-body">
                    
                    <form method="post">
                        <p><label>Группа: </label>
                        <select id="groupSelect" name="group_id" class="form-control-static" required>
                            <option></option>
                            @foreach(\App\Group::where('active', 1)->orderBy('name')->get() as $group)
                            <option value='{{ $group->id }}'>{{ $group->name }} (поток {{ $group->stream->name }})</option>
                            @endforeach
                        </select>
                        </p>
                        
                        <p>
                            <label>Вид занятия</label>
                            <select id="lessonTypeSelect" name="lessontype" class="form-control-static" required>
                                <option></option>
                                @foreach(\App\LessonType::where('vneaud', 0)->get() as $lt)
                                <option value='{{ $lt->id}}'>{{ $lt->name }}</option>
                                @endforeach
                            </select>
                            
                        </p>
                        
                        <p>
                        
                        <div id='blocks'></div>
                        </p>    
                        <p>
                        <div id="hours" style="display: none;">
                        <label>Количество часов:</label><br/>
                        <input  name="hours" type="number" class="form-control-static" value="4"  required>
                        </div>
                    </p>
                        <p>
                        <button class="btn btn-success">Создать</button>
                        </p>
                    {{ csrf_field() }}
                    
                    
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    
    $("#groupSelect").change(function() {
         $("#lessonTypeSelect option:first").prop('selected', true);
         $('#blocks').hide();
         $('#hours').hide();
    })
    
    
    $("#lessonTypeSelect").change(function() {
        
        var lessontype = Number($("#lessonTypeSelect option:selected").val());
        
        
        if ($.inArray(lessontype, [1, 2, 11] ) != -1) {
        var url = "{{url('/')}}/ajax/group_blocks/" + $("#groupSelect option:selected").val();
            
            $.ajax({
            url: url, 
            success: function(param) { $('#blocks').html(param);  }
            });
            $('#blocks').show();
            $('#hours').show();
        } else {
        var url = "{{url('/')}}/ajax/group_programs/" + $("#groupSelect option:selected").val();
            $.ajax({
            url: url, 
            success: function(param) { $('#blocks').html(param);  }
            });
            $('#hours').show();
        }
        



    });
    
    
</script>
    
@endsection

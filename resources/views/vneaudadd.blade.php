
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Внести данные о внеаудиторной нагрузке</div>

                <div class="panel-body">
                    <form method="post">
                        <p> 
                        @if (in_array(Auth::user()->role_id, [3,4,5,6]))
                        <select name="user_id" id="user_id" class="form-control-static">
                            @foreach(\App\User::where('department_id', Auth::user()->department_id)->where('role_id', 2)->orderby('name')->get() as $user)
                            <option value='{{$user->id}}'>{{ $user->name }}
                            @if ($user->freelance)
                            (внештатный)
                            @endif
                            </option>
                            
                            @endforeach
                        </select>
                        
                        <p>
                        <div id="contracts"></div>
                        </p>
                        
                        
                        @else
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        
                        @endif
                        </p>
                        <p>
                            <label>Вид работы</label><br/>
                            <select name="lessontype_id" class="form-control-static">
                                @foreach(\App\LessonType::where('vneaud', 1)->get() as $lessontype)
                                <option value='{{$lessontype->id}}'>{{ $lessontype->name }}</option>
                                @endforeach
                            </select>
                        
                        </p>

                            <div id="contract"></div>

                        <p>
                            
                            <label>Группа</label><br/>
                            <select name="group_id" class="form-control-static">
                                <option disabled>Месяц :: поток-группа :: программа</option>
                                @foreach(\App\Group::select('groups.*')
                                ->where('streams.active', 1)
                                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                ->orderBy('streams.name')
                                ->get() as $group)
                                @php
                                if ($program = $group->stream->programs->first()) {
                                    $prog = str_limit($program->name);
                                }
                                else {$prog = 'нет данных';}
                                @endphp
                                
                                <option value='{{$group->id}}'>
                                    {{ substr($group->stream->date_start, 5, 2) }} :: 
                                    {{$group->stream->name}}-{{$group->name}} ::  
                                    {{$prog or ''}}</option>
                                @endforeach
                            </select>
                            
                        </p>
                        <label>Количество работ <u>или</u> часов. Для неактуальной единицы измерения оставьте значение 0.</label><br/>
                           Работ: <input type='number' name='count' class='form-control-static' placeholder="шт." value='0'>
                           Часов:  <input type='number' name='hours' class='form-control-static' placeholder='ч.' value='0'>
                                
                        <p>
                        
                        </p>
                        <label>Дата</label><br/>
                            <input type='date' name='date' value='{{ date('Y-m-d') }}' class='form-control-static'>
                                
                        <p>                            
                            
                        </p>
                            <label>Комментарий</label><br/>
                            
                            <textarea name='description' class='form-control'></textarea>
                                
                        <p>    
                            {{ csrf_field() }}
                        <p>
                            <button class='btn btn-success'>Сохранить</button>
                        </p>
                    </form>
                    <hr>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    
    $("#user_id").on("change", function(){
        var user_id = $("#user_id option:selected").val();
        $.ajax({
            url: '{{ route('ajax_contracts')}}',
            method: 'get',
            dataType: 'html',
            data: {'user_id': user_id },
            success: function(data) {
                $("#contracts").html(data);
            },
            error: {function() {
                $("#contracts").html("Ошибка");    
            }}
        });
    });
    
    
});

</script>

@endsection

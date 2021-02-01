
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактировать данные о внеаудиторной нагрузке</div>

                <div class="panel-body">
                    <form method="post">
                        
                        <input type="hidden" name="user_id" value="{{$vneaud->user_id}}">
                        <p>
                            @if(\App\User::find($vneaud->user_id)->freelance)
                        <h3>{{ $vneaud->user->name}}</h3>
                            <label>По какому договору? </label>
                            <select name="contract_id" class="form-control-static">
                                @foreach(\App\Contract::where('active', 1)->where('user_id', $vneaud->user_id)->get() as $contract)
                                @if ($contract->id == $vneaud->contract_id)
                                <option value='{{$contract->id}}' selected>{{ $contract->name }} от {{ $contract->date}} ({{ $contract->price}} руб./ч)</option>
                                @else
                                <option value='{{$contract->id}}'>{{ $contract->name }} от {{ $contract->date}} ({{ $contract->price}} руб./ч)</option>
                                @endif
                                @endforeach
                                
                            </select>
                            
                            @endif
                        </p>
                        
                        <p>
                            <label>Вид работы</label><br/>
                            <select name="lessontype_id" class="form-control-static">
                                @foreach(\App\LessonType::where('vneaud', 1)->get() as $lessontype)
                                    @if ($lessontype->id == $vneaud->lessontype_id)
                                    <option value='{{$lessontype->id}}' selected>{{ $lessontype->name }}</option>
                                    @else
                                    <option value='{{$lessontype->id}}'>{{ $lessontype->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        
                        </p>
                        <p>
                            
                            <label>Группа</label><br/>
                            <select name="group_id" class="form-control-static"  id='groupSelect'>>
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
                                
                                @if($group->id == $vneaud->group_id)
                                <option value='{{$group->id}}' selected  data-date_start='{{$group->stream->date_start}}' data-date_finish='{{$group->stream->date_finish}}'>
                                
                                    {{ substr($group->stream->date_start, 5, 2) }} :: 
                                    {{$group->stream->name}}-{{$group->name}} ::  
                                    {{$prog or ''}}</option>
                                @else
                                    <option value='{{$group->id}}'  data-date_start='{{$group->stream->date_start}}' data-date_finish='{{$group->stream->date_finish}}'>
                                    {{ substr($group->stream->date_start, 5, 2) }} :: 
                                    {{$group->stream->name}}-{{$group->name}} ::  
                                    {{$prog or ''}}</option>
                                @endif
                                @endforeach
                            </select>
                            
                        </p>
                        <p>                     <span id='streamDates'></span>
                        </p>
                        <p>
                            <label>Дата привязки нагрузки (по умолчанию - дата заезда выбранной группы):</label>
                            <input type='date' name='date' id='date' value='{{ $vneaud->date }}' id='date_start'  class='form-control-static'>
                        </p>                          
                        <label>Количество работ <u>или</u> часов. Для неактуальной единицы измерения оставьте значение 0.</label><br/>
                            Количество работ: <input type='number' required name='count' value='{{ $vneaud->count }}'class='form-control-static' placeholder="шт.">
                            или количество часов: <input type='number' required step='0.5' name='hours' value='{{ $vneaud->hours }}' class='form-control-static' placeholder='ч.'>
                                
                        <p>
                        
                        </p>
                         
                            
                        </p>
                            <label>Комментарий</label><br/>
                            
                            <textarea name='description' class='form-control'>{{ $vneaud->description }}</textarea>
                                
                        <p>    
                            {{ csrf_field() }}
                        <p>
                            <button class='btn btn-success'>Сохранить</button>
                        </p>
                    </form>
                    <hr>
                    <a href="{{url('/')}}/vneaud/{{ $vneaud->id}}/delete" onclick="return confirm('Действительно удалить?')" class="btn btn-danger"><i class="fa fa-times-circle white"></i> Удалить</a>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $("#groupSelect").on("change", function() {
        $("#date").val($("#groupSelect option:selected").data('date_start'));
        $("#streamDates").html("Поток учится: " + $("#groupSelect option:selected").data('date_start') + " - " + $("#groupSelect option:selected").data('date_finish'));
    });
</script>
@endsection

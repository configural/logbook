
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Внести данные о нагрузке</div>

                <div class="panel-body">
                    <form method="post">
                        
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
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
                            <select name="group_id" class="form-control-static">
                                @foreach(\App\Group::where('active', 1)->orderBy('name')->get() as $group)
                                @if($group->id == $vneaud->group_id)
                                <option value='{{$group->id}}' selected>{{ $group->name }} - {{$group->stream->name}} - {{$group->stream->date_start}}</option>
                                @else
                                    <option value='{{$group->id}}'>{{ $group->name }} - {{$group->stream->name}} - {{$group->stream->date_start}}</option>
                                @endif
                                @endforeach
                            </select>
                            
                        </p>
                        <label>Количество работ <u>или</u> часов. Для неактуальной единицы измерения оставьте значение 0.</label><br/>
                            <input type='number' required name='count' value='{{ $vneaud->count }}'class='form-control-static' placeholder="шт.">
                            <input type='number' required step='0.5' name='hours' value='{{ $vneaud->hours }}' class='form-control-static' placeholder='ч.'>
                                
                        <p>
                        
                        </p>
                        <label>Дата</label><br/>
                            <input type='date' name='date' value='{{ $vneaud->date }}' class='form-control-static'>
                                
                        <p>                            
                            
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
@endsection

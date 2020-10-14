
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
                                <option value='{{$lessontype->id}}'>{{ $lessontype->name }}</option>
                                @endforeach
                            </select>
                        
                        </p>
                        <p>
                            
                            <label>Группа</label><br/>
                            <select name="group_id" class="form-control-static">
                                @foreach(\App\Group::where('active', 1)->orderBy('name')->get() as $group)
                                <option value='{{$group->id}}'>{{ $group->name }} - {{$group->stream->name}} - {{$group->stream->date_start}}</option>
                                @endforeach
                            </select>
                            
                        </p>
                            <label>Количество</label><br/>
                            <input type='number' name='count' class='form-control-static'>
                                
                        <p>
                        
                        </p>
                        <label>Дата</label><br/>
                            <input type='date' name='date' class='form-control-static'>
                                
                        <p>                            
                            
                        </p>
                            <label>Комментарий</label><br/>
                            
                            <textarea name='description' class='form-control'></textarea>
                                
                        <p>    
                            
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

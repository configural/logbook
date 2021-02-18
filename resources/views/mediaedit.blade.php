
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактирование описания медиаконтента</div>

                <div class="panel-body">
                    @if(in_array(Auth::user()->role_id, [4]))  
                    
                    <form method="post">
                        
                        <p>
                        <label>Год</label>
                        <input type="number" name="year" value="{{$media->year}}" class="form-control-static">
                        </p>
                        
                        
                        <p><label>Тип:</label>
                            
                        <input type="hidden" name="id" value="{{ $media->id }}">
                            
                        <select name="type" class="form-control-static" required="">
                        @foreach(\App\Mediatype::get() as $type)
                        @if ($type->id == $media->type)
                        <option value='{{$type->id}}' selected>{{ $type->name }}</option>
                        @else
                        <option value='{{$type->id}}'>{{ $type->name }}</option>
                        @endif
                        @endforeach
                        </select>
                        </p>
                        
                        
                        <p><label>Наименование:</label>
                        <input type="text" value="{{ $media->name }}" name="name" class="form-control" required=""></p>
                        
                        <p><label>Описание:</label>
                            <textarea name="description" class="form-control" >{{ $media->description }}</textarea></p>
                        
                        <p><label>Преподаватель:</label><br/>
                        <select name="users[]" class="form-control-static" required="" multiple style="height: 200px;">
                           @foreach(\App\User::select()->orderBy('name')->get() as $user)
                            @php($in_list = 0)
                            @foreach($media->users as $teacher)
                                @if($teacher->id == $user->id) 
                                @php($in_list = 1)
                                @endif
                                @endforeach
                                @if($in_list)
                                    <option value="{{$user->id}}" selected>{{$user->name}}
                                    @if($user->freelance) (по договору)
                                    @endif
                                    </option>
                                    
                                @else
                                    <option value="{{$user->id}}">{{$user->name}}
                                    @if($user->freelance) (по договору)
                                    @endif
                                    </option>
                                @endif
                            
                            @endforeach
                        </select>
                        <p>
                            <label>Исполнитель</label>
                            <select name="master_id" class='form-control-static'>
                                <option value=''></option>

                                @foreach(\App\User::select()->where('role_id', 4)->orderBy('name')->get() as $user)
                                @if($media->master_id == $user->id)
                                <option value='{{ $user->id }}' selected>{{$user->name}}</option>
                                @else
                                <option value='{{ $user->id }}'>{{$user->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </p>
                        
                        <p><label>На какой квартал запланировано?:</label>
                            <input type="number" value="{{$media->quarter}}" name="quarter" class="form-control-static" required=""></p>
                        
                        <p><label>Даты начала и завершения:</label>
                            <input type="date" value="{{ $media->date_start }}" name="date_start" class="form-control-static"> 
                            <input type="date" value="{{ $media->date_finish }}" name="date_finish" class="form-control-static"></p>
                        <p>
                        <label>Сетевой путь к результату:</label>
                        <textarea name='result_path' class='form-control'>{{ $media->result_path }}</textarea>
                        </p>

                        
                        <p><label>Состояние проекта (0/1):</label>
                            <input type="number" value="{{ $media->status }}" name="status" class="form-control-static" required=""></p>
                        
                        {{ csrf_field() }}
                        
                        <p><button class="btn btn-success">Сохранить</button></p>
                        
                        <hr>
                        
                        <p>
                            <a href='delete' class='btn btn-danger' onclick="return confirm('Действительно удалить?')">Удалить</a>
                        </p>
                    </form>
                    

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

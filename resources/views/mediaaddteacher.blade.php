
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Новый медиаконтент</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 2)  
                    
                    <form method="post">
                        
                        
                        <p>
                        <label>Год</label>
                        <input type="number" name="year" value="{{ date('Y')}}" class="form-control-static">
                        </p>
                        
                        <input type="hidden" name="return" value="my_media">
                        <p><label>Тип:</label>
                        <select name="type" class="form-control-static" required="">
                        @foreach(\App\Mediatype::get() as $type)
                        <option value='{{$type->id}}'>{{ $type->name }}</option>
                        @endforeach
                        </select>
                        </p>
                        
                        
                        <p><label>Наименование:</label>
                        <input type="text" value="" name="name" class="form-control" required=""></p>
                        
                        <p><label>Описание:</label>
                            <textarea name="description" class="form-control" ></textarea></p>
                        
                        <p><label>Преподаватель(ли):</label><br/>
                            Для множественного выбора/отмены выбора кликайте мышкой с нажатой клавишей Ctrl:<br/>
                        <select name="users[]" class="form-control-static" required="" multiple style="height: 200px;">
                        @foreach(\App\User::orderBy('name')->get() as $user)
                        @if(Auth::user()->id == $user->id)
                        <option value='{{$user->id}}' selected>{{ $user->name }}</option>
                        @else
                        <option value='{{$user->id}}'>{{ $user->name }}</option>
                        @endif
                        @endforeach
                        </select>
                        </p>
                        
                              

                         <p><label>На какой квартал запланировано?:</label>
                            <input type="number" value="0" name="quarter" min="1" max="4" class="form-control-static" required=""></p>

                        
                        {{ csrf_field() }}
                        
                        <p><button class="btn btn-success">Сохранить</button></p>
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

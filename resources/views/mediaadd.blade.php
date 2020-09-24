
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Новая медиаконтент</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <form method="post">
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
                        
                        <p><label>Преподаватель:</label><br/>
                        <select name="users[]" class="form-control-static" required="" multiple style="height: 200px;">
                        @foreach(\App\User::orderBy('name')->get() as $user)
                        <option value='{{$user->id}}'>{{ $user->name }}</option>
                        @endforeach
                        </select>
                        </p>
                        
                        <p><label>Дата начала:</label>
                            <input type="date" value="" name="date_start" class="form-control-static"></p>

                        <p><label>Дата завершения:</label>
                            <input type="date" value="" name="date_finish" class="form-control-static"></p>
                        
                        <p><label>Состояние проекта (0/1):</label>
                            <input type="integer" value="0" name="status" class="form-control-static" required=""></p>
                        
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

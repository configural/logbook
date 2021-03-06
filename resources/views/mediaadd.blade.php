
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Новый медиаконтент</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <form method="post">
                        
                        <p>
                        <label>Год</label>
                        <input type="number" name="year" value="" class="form-control-static">
                        </p>
                        
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
                        <option value='{{$user->id}}'>{{ $user->name }} 
                            @if($user->freelance) (по договору)
                            @endif

                        </option>
                        @endforeach
                        </select>
                        </p>
                        
                        <p>
                            <label>Исполнитель</label>
                            <select name="master_id" class='form-control-static'>
                                <option value=''></option>

                                @foreach(\App\User::select()->where('role_id', 4)->orderBy('name')->get() as $user)
                               
                                <option value='{{ $user->id }}'>{{$user->name}}</option>
                               
                                @endforeach
                            </select>
                        </p>                        

                         <p><label>На какой квартал запланировано?:</label>
                            <input type="number" value="0" name="quarter" class="form-control-static" required=""></p>

                        
                        <p><label>Дата начала и завершения:</label><br/>
                            <input type="date" value="" name="date_start" class="form-control-static"> 
                            <input type="date" value="" name="date_finish" class="form-control-static"></p>
 
                        <p>
                        <label>Сетевой путь к результату:</label>
                        <textarea name='result_path' class='form-control'></textarea>
                        </p>
                        
                        <p><label>Состояние проекта (0/1):</label>
                            <input type="number" value="0" name="status" class="form-control-static" required=""></p>
                        
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

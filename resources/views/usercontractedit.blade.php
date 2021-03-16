
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Добавление договора</div>
                <div class="panel-body">
            
                @if(in_array(Auth::user()->role_id, [3, 4, 6]) and \App\User::find($contract->user_id)->freelance)    
                <form  method="post">
                    <input type="hidden" name="user_id" value="{{ $contract->id }}">
                    <h3>
                        Преподаватель: {{ \App\User::find($contract->user_id)->fio()}}
                    </h3>
                    
                    <hr>
                    <input type="hidden" name="id" value="{{ $contract->id}}" class="form-control-static" required>
                    <input type="hidden" name="user_id" value="{{ $contract->user_id}}" class="form-control-static" required>
                    <p>
                        
                        <label>Номер (название) договора</label><br>
                        <input type="text" name="name" value="{{ $contract->name}}" class="form-control-static" required>
                    </p>
                    <p>
                        
                        <label>Дата заключения договора</label><br>
                        <input type="date" name="date" value="{{ $contract->date}}" class="form-control-static" required>
                    </p>


                    <p>
                        <label>Количество часов</label><br>
                        <input type="number" name="hours" value="{{ $contract->hours}}" class="form-control-static" required>
                    </p>
                    <p>
                        <label>Стоимость часа, руб</label><br>
                        <input type="number" name="price" value="{{ $contract->price}}" class="form-control-static" required>
                    </p>
                    
                    <p>
                        <label>Срок действия:</label><br>
                        <input type="date" name="start_at" value="{{$contract->start_at}}" class="form-control-static" required>  
                        <input type="date" name="finish_at" value="{{$contract->finish_at}}" class="form-control-static" required>
                    </p>
                    <p>
                        <label>Дополнительно</label><br>
                        <textarea name="description" class="form-control">{{$contract->description}}</textarea>
                    </p>
                    <p>
                        <label>Действует? (1/0)</label><br>
                        <input type="number" name="active" value="{{$contract->active}}" class="form-control-static" required>
                    </p>
                          
                          <p><button class="btn btn-success">Сохранить данные</button>
                    {{ csrf_field() }}
                      </form>
                
                
                <hr>
                
                <a href="{{url('/')}}/user/deletecontract/{{$contract->id}}" onclick="return confirm('Действительно удалить?')" class="btn btn-danger"><i class="fa fa-times-circle white"></i> Удалить договор</a>
                    @else
                    Договор можно добавить только внештатному преподавателю                  
                    @endif
            
            </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

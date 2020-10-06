
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Добавление договора</div>
                <div class="panel-body">
            
                @if(in_array(Auth::user()->role_id, [3, 4]) and \App\User::find($contract->user_id)->freelance)    
                <form  method="post">
                    <input type="hidden" name="user_id" value="{{ $contract->id }}">
                    <h3>
                        Преподаватель: {{ \App\User::find($contract->user_id)->fio()}}
                    </h3>
                    
                    <hr>
                    <p>
                        <label>Номер (название) договора</label><br>
                        <input type="text" name="name" value="{{ $contract->name}}" class="form-control-static" required>
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

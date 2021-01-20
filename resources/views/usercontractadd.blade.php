
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Добавление договора</div>
                <div class="panel-body">
            @if($id)
                @if(in_array(Auth::user()->role_id, [3, 4, 6]) and \App\User::find($id)->freelance)    
                <form action="addcontract" method="post">
                    <input type="hidden" name="user_id" value="{{ $id }}">
                    <h3>
                        Преподаватель: {{ \App\User::find($id)->fio()}}
                    </h3>
                    
                    <hr>
                    <p>
                        <label>Номер (название) договора</label><br>
                        <input type="text" name="name" class="form-control-static" required>
                    </p>
                    <p>
                        <label>Дата заключения договора</label><br>
                        <input type="date" name="date" class="form-control-static" required>
                    </p>
                    
                    <p>
                        <label>Стоимость часа, руб</label><br>
                        <input type="number" name="price" class="form-control-static" required>
                    </p>
                    
                    <p>
                        <label>Срок действия:</label><br>
                        <input type="date" name="start_at" class="form-control-static" required>  
                        <input type="date" name="finish_at" class="form-control-static" required>
                    </p>
                    <p>
                        <label>Дополнительно</label><br>
                        <textarea name="description" class="form-control"></textarea>
                    </p>
                    <p>
                        <label>Действует? (1/0)</label><br>
                        <input type="number" name="active" value="1" class="form-control-static" required>
                    </p>
                          
                    <p>
                        <input name="fill" type="checkbox" value="1"> Привязать всю непривязанную до сих пор нагрузку преподавателя к этому договору
                    </p>
                          <p><button class="btn btn-success">Создать договор</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    Договор можно добавить только внештатному преподавателю                  
                    @endif
            @endif
            </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание блока</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="{{url('/')}}/block/add" method="post">
                          
                        <p><input type="hidden" name="discipline_id" value="{{$id}}"></p>
                        <p><label>Название блока</label><input type="text" value="" class="form-control" name="name" required></p>
                          <p><label>Лекции (часов)</label><input type="text" value="0" class="form-control" name="l_hours"></p>
                          <p><label>Практика (часов)</label><input type="text" value="0" class="form-control" name="p_hours"></p>
                          <p><label>Самост. работа (часов)</label><input type="text" value="0" class="form-control" name="s_hours"></p>
                          <p><label>Опубликован (1/0)?</label><input type="text" value="1" class="form-control" name="active"></p>
                          <p><button class="btn btn-success">Создать блок</button>
                    {{ csrf_field() }}
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

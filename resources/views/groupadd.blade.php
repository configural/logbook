
@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание группы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="{{url('/')}}/group/add" method="post">
                          
                        <p><input type="hidden" name="stream_id" value="{{$id}}"></p>
                        <p><label>Название группы</label><input type="text" value="" class="form-control" name="name" required></p>
                        <p><label>Количество подгрупп</label><input type="number" value="1" class="form-control" name="subgroup_count"></p>
                        <p><label>Описание группы</label>
                            <textarea name="description" class="form-control"></textarea></p>

                      <p><label>Опубликовано (1/0)?</label><input type="number" value="" class="form-control" name="active"></p>
                          
                          
                          <p><button class="btn btn-success">Создать группу</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>

@endsection

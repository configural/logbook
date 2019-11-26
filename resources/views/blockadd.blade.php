
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание блока</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="{{url('/')}}/block/add" method="post">
                          
                        <p><input type="hidden" name="discipline_id" value="{{$id}}"></p>
                        <p><label>Название блока</label><input type="text" value="" class="form-control" name="name"></p>
                          
                          <p><label>Опубликована (1/0)?</label>
                              <input type="text" value="" class="form-control" name="active">
                          </p>
                          
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

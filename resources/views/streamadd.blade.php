
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание потока</div>
                <div class="panel-body">
                @if(Auth::user()->role_id == 4)    
                <form action="add" method="post">
                          
                          <p><label>Название потока</label><input type="text" value="" class="form-control" name="name"></p>
                          <p><label>Начало обучения</label><input type="date" value="" class="form-control" name="date_start"></p>
                          <p><label>Окончание обучения</label><input type="date" value="" class="form-control" name="date_finish"></p>
                          <p><label>Учебный год</label><input type="text" value="" class="form-control" name="year"></p>
                          
                          <p><label>Образовательная программа</label>
                              <select name="program_id" class="form-control">
                                  @foreach(\App\Program::select()->get() as $program)
                                  <option value="{{$program->id}}">{{$program->hours}} ч. - {{$program->name}}</option>
                                  
                                  @endforeach
                              </select>
                          
                          <p><button class="btn btn-success">Создать поток</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    К сожалению, у вас нет доступа к этой функции.                   
                    @endif
            </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


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
                          
                          <p><label>Название потока</label><br/><input type="text" value="" class="form-control" name="name" required></p>
                          <p><label>Начало обучения</label><br/><input type="date" value="" class="form-control-static" name="date_start" required></p>
                          <p><label>Окончание обучения</label><br/><input type="date" value="" class="form-control-static" name="date_finish" required></p>
                          <p><label>Учебный год</label><br/><input type="text" value="" class="form-control-static" name="year" required></p>
                          <p><label>Методист</label><br/>
                              <select name="metodist_id" class="form-control-static">
                                  
                                  @foreach(\App\User::where('role_id', 3)->get() as $user)
                                  <option value='{{$user->id}}'>{{$user->name}}</option>
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

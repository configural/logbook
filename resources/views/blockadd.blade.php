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
                        <p><label>Название блока</label><textarea class="form-control" name="name" required></textarea></p>
                          <p><label>Лекции (часов)</label><input type="text" value="0" class="form-control" name="l_hours"></p>
                          <p><label>Практика (часов)</label><input type="text" value="0" class="form-control" name="p_hours"></p>
                          <p><label>Самост. работа (часов)</label><input type="text" value="0" class="form-control" name="s_hours"></p>
                          <p><label>Вебинары (часов)</label><input type="text" value="0" class="form-control" name="w_hours"></p>
                          <p><label>Кафедра:</label>
                              <select name="department_id" class="form-control-static">
                                  <option value="">Наследуется от дисциплины</option>
                                  @foreach(\App\Department::get() as $department)
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endforeach
                              </select>
 
                          <p><label>Укрупненная тема:</label>
                              <select name="largeblock_id" class="form-control-static">
                                  <option value=""></option>
                                  @foreach(\App\Largeblock::orderby('name')->get() as $largeblock)
                                  <option value="{{$largeblock->id}}">{{$largeblock->name}}</option>
                                  @endforeach
                              </select>                              
                              
                          </p>
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

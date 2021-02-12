
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание дисциплины</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="add" method="post">
                          
                          <p><label>Название</label><input type="text" value="" class="form-control" name="name"></p>
                          <p><label>Часы</label><input  type="number" step="0.01" value="" class="form-control" name="hours"></p>
                          <p><label>Аттестация по дисциплине</label>
                              <select name="attestation_id" class="form-control">
                                  @foreach(\App\Attestation::select()->get() as $attestation)
                                  <option value="{{$attestation->id}}">{{$attestation->name}}</option>
                                  @endforeach
                              </select>
                          </p>
                          <p><label>Аттестация, часы</label><input type="number" value="0" class="form-control" name="attestation_hours" required></p>

                          
                          <p><label>Кафедра</label>
                              <select name="department_id" class="form-control">
                                  @foreach(\App\Department::select()->get() as $department)
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endforeach
                              </select>
                          </p>
                          
                          <p><label>Опубликована (1/0)?</label>
                              <input type="text" value="" class="form-control" name="active">
                          </p>
                          
                          <p><button class="btn btn-success">Создать дисциплину</button>
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

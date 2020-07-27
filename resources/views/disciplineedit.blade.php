
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактирование дисциплины - {{ $discipline->name }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $discipline->id }}" class="form-control" name="id"></p>
                          <p><label>Название дисциплины</label><input type="text" value="{{ $discipline->name }}" class="form-control" name="name"></p>
                          <p><label>Часы. </label> Здесь нужно ввести количество часов, предусмотренное УТП.<input type="text" value="{{ $discipline->hours }}" class="form-control" name="hours"></p>
                          <p><label>Кафедра</label>
                              <select name="department_id" class="form-control">
                                  @foreach(\App\Department::select()->get() as $department)
                                  @if($discipline->department_id == $department->id)
                                  <option value="{{$department->id}}" selected>{{$department->name}}</option>
                                  @else
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endif
                                  @endforeach
                              </select>
                          </p>
                          
                          <p><label>Опубликована (1/0)?</label> Введите 1, если дисциплина активна и 0, если она больше не нужна.<input type="text" value="{{ $discipline->active }}" class="form-control" name="active"></p>
                           <p><a href="{{ url('/') }}/discipline/{{ $discipline->id }}">Список блоков дисциплины</a></p> 
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

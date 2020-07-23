
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактирование дисциплины</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $student->id }}" class="form-control" name="id"></p>
                          <p><label>Фамилия</label>
                              <input type="text" value="{{ $student->secname }}" class="form-control" name="secname"></p>
                          
                          <p><label>Имя</label>
                              <input type="text" value="{{ $student->name }}" class="form-control" name="name"></p>
                          
                          <p><label>Отчество</label>
                              <input type="text" value="{{ $student->fathername }}" class="form-control" name="fathername"></p>
                          
                          <p><label>Группа</label>
                              <select name="group_id" class="form-control">
                                  @foreach(\App\Group::select()->get() as $group)
                                  @if ($student->group_id == $group->id)
                                  <option value='{{$group->id}}' selected>{{$group->name}} ({{$group->stream->name}} {{$group->stream->year}})</option> 
                                  @else
                                  <option value='{{$group->id}}'>{{$group->name}} ({{$group->stream->name}} {{$group->stream->year}})</option>
                                  @endif
                                  @endforeach
                              
                              </select>
                          </p>
                          
                          
                          <p><label>Код СОНО</label>
                              <input type="text" value="{{ $student->sono }}" class="form-control" name="sono"></p>
                          
                          <p><label>Квалификация</label>
                              <input type="text" value="{{ $student->qualification }}" class="form-control" name="qualification"></p>
                          <p>
                              <label>Уровень образования</label>
                              <input type="text" value="{{ $student->edu_level }}" class="form-control" name="edu_level"></p>
                          <p>
                              <label>Серия документа об образовании</label>
                              <input type="text" value="{{ $student->doc_seria }}" class="form-control" name="doc_seria"></p>
                          <p>Фамилия в диплом</label>
                              <input type="text" value="{{ $student->doc_secname }}" class="form-control" name="doc_secname"></p>
                          
                          <p><label>Статус</label>
                              <input type="text" value="{{ $student->status }}" class="form-control" name="status"></p>
                          
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


@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">{{ $group->name }} - редактирование</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $group->id }}" class="form-control" name="id"></p>
                          <p><label>Название группы</label><input type="text" value="{{ $group->name }}" class="form-control" name="name" required></p>
                          <p><label>Поток</label>
                              <select name="stream_id" class="form-control">
                              @foreach(\App\Stream::select()->get() as $stream)
                              @if($group->stream_id == $stream->id) <option value="{{$stream->id}}" selected>{{$stream->name}}</option>
                              @else <option value="{{$stream->id}}">{{$stream->name}}</option>
                              @endif
                              @endforeach
                              </select>
                              
                          <p><label>Группа активна?</label><input type="text" value="{{ $group->active }}" class="form-control" name="active"></p>
                          <p><label>Описание группы</label>
                              <textarea name="description" class="form-control">{{$group->description}}</textarea>
                          </p> 
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    <hr/>
                </div>
            </div>
        </div>
         <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">Слушатели</div>

                <div class="panel-body">                   
                    
                    <table class='table table-bordered' id="sortTable">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>ФИО</th>
                            <th>Код СОНО</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($group->students as $student)
                    <tr>
                        <td>{{ $student->id }} </td>
                        <td><a href="{{url('/')}}/student/{{ $student->id}}/edit">{{ $student->secname }} {{ $student->name }} {{ $student->fathername }}</a></td>
                        <td>{{ $student->sono }}</td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                    @else
                    @endif
                    <a href="{{url('/')}}/group/{{$group->id}}/addstudents" class="btn btn-success">Добавить студентов в группу</a>
                    
                </div>
            </div>
        </div>
    </div>




@endsection

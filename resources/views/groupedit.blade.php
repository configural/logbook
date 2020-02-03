
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">Группа {{ $group->name }} - редактирование</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    <h4>Редактировать детали потока</h4>
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $group->id }}" class="form-control" name="id"></p>
                          <p><label>Название группы</label><input type="text" value="{{ $group->name }}" class="form-control" name="name" required></p>
                          <p><label>Поток</label><input type="text" value="{{ $group->stream_id }}" class="form-control" name="stream_id"></p>
                          <p><label>Группа активна?</label><input type="text" value="{{ $group->active }}" class="form-control" name="active"></p>
                          <p><label>Описание группы</label>
                              <textarea name="description" class="form-control">{{$group->description}}</textarea>
                          </p> 
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    <hr/>
                    
                    
                    <h3>Слушатели в группе</h3>
                    <table class='table table-bordered'>
                        <tr>
                            <th>id</th>
                            <th>ФИО</th>
                            <th>Код СОНО</th>
                            
                        </tr>
                    @foreach($group->students as $student)
                    <tr>
                        <td>{{ $student->id }} </td>
                        <td><a href="{{url('/')}}/student/{{ $student->id}}/edit">{{ $student->secname }} {{ $student->name }} {{ $student->fathername }}</a></td>
                        <td>{{ $student->sono }}</td>
                    </tr>
                    @endforeach
                    </table>
                    @else
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

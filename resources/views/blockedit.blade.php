
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">{{ $block->name }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $block->id }}" class="form-control" name="id"></p>
                          <p><label>Название блока</label><textarea class="form-control" name="name">{{ $block->name }}</textarea></p>
                          <p><label>Лекции (часов): </label><input  type="number" step="0.01" value="{{ $block->l_hours }}" class="form-control" name="l_hours"></p>
                          <p><label>Практика (часов)</label><input  type="number" step="0.01" value="{{ $block->p_hours }}" class="form-control" name="p_hours"></p>
                          <p><label>Самост. работа (часов)</label><input  type="number" step="0.01" value="{{ $block->s_hours }}" class="form-control" name="s_hours"></p>
                          <p><label>Вебинары (часов)</label><input  type="number" step="0.01" value="{{ $block->w_hours }}" class="form-control" name="w_hours"></p>
                          
                          <p><label>Кафедра:</label>
                              <select name="department_id" class="form-control-static">
                                  <option value="">Наследуется от дисциплины</option>
                                  @foreach(\App\Department::get() as $department)
                                  @if ($department->id == $block->department_id)
                                  <option value="{{$department->id}}" selected>{{$department->name}}</option>
                                  @else
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endif
                                  @endforeach
                              </select>
                           
                          <p><label>Укрупненная тема:</label>
                              <select name="largeblock_id" class="form-control-static">
                                  <option value=""></option>
                                  @foreach(\App\Largeblock::orderby('name')->get() as $largeblock)
                                  @if ($largeblock->id == $block->largeblock_id)
                                  <option value="{{$largeblock->id}}" selected>{{$largeblock->name}}</option>
                                  @else
                                  <option value="{{$largeblock->id}}">{{$largeblock->name}}</option>
                                  @endif
                                  @endforeach
                              </select>                         
                          <p><label>Опубликован (1/0)?</label><input type="text" value="{{ $block->active }}" class="form-control" name="active"></p>
    
                          <p><button class="btn btn-success">Обновить</button>
                     {{ csrf_field() }}

                      </form>
                    
                    <hr/>
                    
                    <h3>Эта тема в нагрузке</h3>
                    <table class='table table-bordered'>
                        <tr>
                            <th>id</th>
                            <th>Дата</th>
                            <th>Группа</th>
                        </tr>
                    @foreach($block->in_timetable()->get() as $timetable)
                    <tr>
                        <td><a href="{{ route('workload')}}/edit/{{ $timetable->id }}">{{ $timetable->id }}</a></td>
                        <td>{{ $timetable->rasp->date or ''}}</td>
                        <td>{{ $timetable->group->name}}</td>
                    </tr>
                    @endforeach
                    </table>
                    
                    <p>
                        @if($block->in_timetable()->count())
                    <div class="warning">Поскольку тема присутствует в нагрузке, ее удалить нельзя.</div>
                        @else
                        
                        <a href='delete' class='btn btn-danger' onclick="return confirm('Действительно удалить?')" class="btn btn-danger"><i class="fa fa-times-circle white"></i> Удалить эту тему</a>
                        @endif
                    </p>
                    
                    @else
                    У вас нед доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

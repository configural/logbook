
@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">{{ $stream->name }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <h4>Редактировать детали потока</h4>
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $stream->id }}" class="form-control" name="id"></p>
                          <p><label>Название потока</label><input type="text" value="{{ $stream->name }}" class="form-control" name="name"></p>
                          <p><label>Начало обучения</label><input type="date" value="{{ $stream->date_start}}" class="form-control" name="date_start"></p>
                          <p><label>Окончание обучения</label><input type="date" value="{{ $stream->date_finish}}" class="form-control" name="date_finish"></p>
                          <p><label>Год</label><input type="text" value="{{ $stream->year }}" class="form-control" name="year"></p>
                          <p><label>Поток активен? (1/0)</label>
                              <input name="active" type="number" value="{{ $stream->active }}" class="form-control-static" required>
                          <p><label>Методист</label><br/>
                              <select name="metodist_id" class="form-control-static">
                                  
                                  @foreach(\App\User::where('role_id', 3)->get() as $user)
                                  @if ($stream->metodist_id == $user->id)
                                  <option value='{{$user->id}}' selected>{{$user->name}}</option>
                                  @else
                                  <option value='{{$user->id}}'>{{$user->name}}</option>
                                  @endif
                                  @endforeach
                                  
                              </select>
                           
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    <hr/>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            

            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">1. Сформировать ВСЕ группы для потока</div>

                <div class="panel-body">
                    
                    <table class="table table-bordered">
                       <tr>
                            <td>id</td>
                            <td>Название группы</td>
                            <td>Описание</td>
                            <td>Слушателей</td>
                            <td>Платная?</td>
                            <td>Активна?</td>
                        </tr>
                        @foreach($stream->groups as $group)
                        <tr>
                            <td>{{$group->id}}</td>
                            <td><a href="{{url('/group')}}/{{$group->id}}/edit">{{$group->name}}</a></td>
                            
                            <td>{{$group->description}}</td>
                            <td>{{$group->students->count()}}</td>
                            <td>
                                @if ($group->paid)
                                 платная
                                @else
                                -
                                @endif
                            </td>
                            <td>{{$group->active}}</td>
                        </tr>
                        @endforeach
                    </table>
                    <p><a href="{{url('/group/add')}}/{{$stream->id}}" class="btn btn-success"><i class="fa fa-group"></i> Создать группу в этом потоке</a>
    
                    @else
                    @endif
                    
                    
                </div>
            </div>
            
            <div class="panel panel-primary">
                <div class="panel-heading">2. Назначить потоку образовательную программу</div>

                <div class="panel-body">
                    
                    <table class="table table-bordered">
                        <tr>
                            <td>Наименование</td>
                            <td>Часов</td>
                            <td>Действия</td>
                        </tr>
                    @foreach($stream->programs as $program)
                    <tr>
                        <td><a href="{{url('/program/')}}/{{$program->id}}" target="_blank">{{ $program->name }}</td>
                        <td>{{ $program->hours }}</td>
                        <td>
                          
                            
                            @if (Auth::user()->role_id == 4)
                            <a href="{{ url('/')}}/stream/{{$stream->id}}/program_unbind/{{$program->id}}" 
                               onClick="return window.confirm('Вся нагрузка будет удалена. Действительно удалить привязку?');" 
                               class="btn btn-danger"><i class="fa fa-times"></i> Удалить</a>
                            @endif
                            </td>
                        
                    </tr>
                    
                    @endforeach
                    </table>
                    
                    @if($stream->programs->count() == 0)
                    <p>Образовательная программа для потока не назначена. Выберите из списка. После назначения программы будет автоматически сформирована нераспределенная нагрузка для данного потока.</p>
                    <form action="program_bind" method="post">
                        <p>
                    <input type="hidden" name="stream_id" value="{{$stream->id}}">
                        <select name="program_id" class="form-control">
                            @foreach(\App\Program::select()->where('active', 1)->orderby('name', 'asc')->get() as $program)
                            <option value='{{ $program->id }}'>
                                {{$program->year}} 
                                [{{ $program->form->name}}] 
                                {{$program->name}} - {{ $program->description}}</option>
                            @endforeach
                        </select>
                        </p>
                    <p><button class="btn btn-success">Назначить программу потоку</button>
                        <a href="{{url('programs')}}">Перейти в «Образовательные программы»</a> 
                    {{ csrf_field() }}
                    </form>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

@endsection

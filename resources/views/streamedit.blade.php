
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading panel-success ">{{ $stream->name }} - редактирование</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    <h4>Редактировать детали потока</h4>
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $stream->id }}" class="form-control" name="id"></p>
                          <p><label>Название потока</label><input type="text" value="{{ $stream->name }}" class="form-control" name="name"></p>
                          <p><label>Начало обучения</label><input type="date" value="{{ $stream->date_start}}" class="form-control" name="date_start"></p>
                          <p><label>Окончание обучения</label><input type="date" value="{{ $stream->date_finish}}" class="form-control" name="date_finish"></p>
                          <p><label>Год</label><input type="text" value="{{ $stream->year }}" class="form-control" name="year"></p>
                           
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    <hr/>
                    
                    <h4>Назначенные образовательные программы</h4>
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
                        <td></td>
                    </tr>
                    
                    @endforeach
                    </table>
                    <form action="bind_program" method="post">
                        <p>
                        <select name="program_id" class="form-control">
                            @foreach(\App\Program::select()->where('active', 1)->get() as $program)
                            <option value='{{ $program->id }}'>{{$program->name}}</option>
                            @endforeach
                        </select>
                        </p>
                    <p><a class="btn btn-primary"><i class="fa fa-graduation-cap"></i> Добавить программу</a>
                    
                    <hr/>
                    <h4>Учебные группы в потоке</h4>
                    <table class="table table-bordered">
                       <tr>
                            <td>id</td>
                            <td>Название группы</td>
                            <td>Описание</td>
                            <td>Активна</td>
                        </tr>
                        @foreach($stream->groups as $group)
                        <tr>
                            <td>{{$group->id}}</td>
                            <td><a href="{{url('/group')}}/{{$group->id}}/edit">{{$group->name}}</a></td>
                            <td>{{$group->description}}</td>
                            <td>{{$group->active}}</td>
                        </tr>
                        @endforeach
                    </table>
                    <p><a href="{{url('/group/add')}}/{{$stream->id}}" class="btn btn-primary"><i class="fa fa-group"></i> Создать группу в этом потоке</a>
    
                    @else
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

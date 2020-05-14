
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Образовательные программы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('program/add')}}" class="btn btn-success">Добавить образовательную программу</a></p>
                    
                    <table class="table table-bordered">
                        <thead class="">
                            <tr><td>id</td><td>Название программы</td><td>Часов запланировано</td><td>Часов назначено</td><td>Активна?</td><td>Операции</td></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Program::select()->get() as $program)
                            <tr class="">
                                <td>{{ $program->id }} </td>
                                <td><a href="{{url('/')}}/program/{{$program->id}}">{{ $program->name }}</a><br><small>{{$program->description}}</small></td>
                                <td>{{ $program->hours }}</td>
                                <td>{{ $program->hours() }}</td>
                                <td>{{ $program->active }}</td>
                                <td><center><a href="{{url('/')}}/program/{{$program->id}}/edit" title="Изменить название, описание"><i class="fa fa-edit fa-2x"></i></a>
                                    <a href="{{url('/')}}/program/{{$program->id}}" title="Редактировать дисциплины и блоки"><i class="fa fa-gears fa-2x green"></i>
                                    
                                </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                    
                    
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

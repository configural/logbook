
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12 ">
            <p>Образовательная программа - это совокупность дисциплин, которые изучаются слушателями одного потока. Контролируйте, чтобы количество назначенных часов совпадало с количеством запланированных!</p>
            <div class="panel panel-primary">
                <div class="panel-heading">Образовательные программы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('program/add')}}" class="btn btn-success">Добавить образовательную программу</a></p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead class="">
                            <tr><td>id</td><td width="35%">Название программы</td>
                                <td>Форма</td>
                                <td width="10%">Часов по плану</td>
                                <td width="10%">Часов по факту</td>
                                <td>Дисциплины</td>
                                <td>Операции</td></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Program::where('active', 1)->get() as $program)
                            <tr class="">
                                <td>{{ $program->id }} </td>
                                <td><a href="{{url('/')}}/program/{{$program->id}}/edit">{{ $program->name }}</a><br><small>{{$program->description}}</small></td>
                                <td>{{ $program->form->name or ''}}</td>
                                <td>{{ $program->hours }}</td>
                                <td>{{ $program->hours() }}</td>
                                <td><a href="{{url('/')}}/program/{{$program->id}}" title="Редактировать дисциплины и блоки" class="btn btn-primary">Дисциплины</a> </td>
                                
                                
                                <td><a href="{{url('/')}}/program/{{$program->id}}/clone" title="Клонировать программу" class="btn btn-warning"  onClick="return window.confirm('Будет создана отдельная программа с точно таким же содержимым, но с другим ID. Продолжить?');">Копия</a> 
                                    <a href="{{url('/')}}/program/{{$program->id}}/delete" title="Удалить программу" class="btn btn-danger" onClick="return window.confirm('Действительно удалить? Вернуть будет нельзя!');">Удалить</a>
                                            
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

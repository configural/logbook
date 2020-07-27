
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                            <p>Дисциплина включается в состав образовательной программы. Одна дисциплина может быть задействована в нескольких образовательных программах.  В одной образовательной программе может быть много дисциплин.
                    Дисциплина делится на тематические блоки (темы)</p>
            <div class="panel panel-primary">
                <div class="panel-heading">Дисциплины</div>


                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('disciplines/add')}}" class="btn btn-success">Добавить дисциплину</a></p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr><th width="5%">id</th>
                                <th width="40%">Название дисциплины</th>
                                <th width="10%">Кафедра</th>
                                <th>Активна?</th>
                                <th>Темы</th>
                                <th>Операции</th></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Discipline::select()->get() as $discipline)
                            <tr class="">
                                <td>{{ $discipline->id }} </td>
                                <td><a href="{{url('/')}}/discipline/{{$discipline->id}}">{{ $discipline->name }}</a> ({{ $discipline->hours }} ч.)<br/>
                                {{$discipline->description or ''}}</td>
                                <td>{{$discipline->department->name or 'нет'}}</td>
                                <td>{{ $discipline->active }}</td>
                                <td><a href="{{url('/')}}/discipline/{{$discipline->id}}" class="btn btn-primary">Темы ({{ $discipline->blocks->count()}})</a></td>
                                
                                <td><a href="{{url('/')}}/disciplines/{{$discipline->id}}/edit" class="btn btn-success">Ред.</a>
                                    <a href="{{url('/')}}/disciplines/{{$discipline->id}}/clone" class="btn btn-warning">Клон.</a>
                                    
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

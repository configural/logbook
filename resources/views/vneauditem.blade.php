
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Внеаудиторная нагрузка</div>

                <div class="panel-body">
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>Преподаватель</th>
                                <th>Группа</th>
                                <th>Вид работы</th>
                                <th>Часы</th>
                                <th>Дата</th>
                                <th>Комментарий</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @foreach(\App\Vneaud::get() as $vneaud)
                        <tr>
                            <td>{{ $vneaud->user->name}}</td>
                            <td>{{ $vneaud->group->name}}</td>
                            <td>{{ $vneaud->lessontype->name }}</td>
                            <td>{{ $vneaud->hours }}</td>
                            <td>{{ $vneaud->date }}</td>
                            <td>{{ $vneaud->description }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

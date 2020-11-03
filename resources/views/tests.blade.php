
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Тесты</div>

                <div class="panel-body">
                    <p>
                        <a href="{{route('testadd')}}" class="btn btn-success">Создать тест</a>
                    </p>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Название</th>
                                <th>Вопросы</th>
                                <th>Программа(ы)</th>
                                <th>Последнее обновление</th>
                                <th>Активен</th>
                            </tr>
                        
                        
                        </thead>
                        <tbody>
                            @foreach(\App\Test::get() as $test)
                        <td>{{ $test->id }}</td>
                        <td><a href="test/{{ $test->id}}/edit">{{ $test->name }}</a></td>
                        <td><a href="test/{{$test->id}}/questions">{{ $test->questions->count() }}</a></td>
                        <td></td>
                        <td>{{$test->updated_at}}</td>
                        <td>{{ $test->active }}</td>
                            @endforeach
                        </tbody>
                        
                    </table>
                   
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

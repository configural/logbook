
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Дисциплины</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('discipline/add')}}" class="btn btn-success">Добавить дисциплину</a></p>
                    
                    <table class="table table-bordered">
                        <thead class="">
                            <tr><td>id</td><td>Название дисциплины</td><td>Активна?</td><td>Операции</td></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Discipline::select()->get() as $discipline)
                            <tr class="">
                                <td>{{ $discipline->id }}</td>
                                <td>{{ $discipline->name }}</td>
                                <td>{{ $discipline->active }}</td>
                                <td><center><a href="{{url('/')}}/discipline/{{$discipline->id}}/edit"><i class="fa fa-edit fa-2x"></i></a>
                                    
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

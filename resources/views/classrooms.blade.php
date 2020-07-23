
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Аудиторный фонд</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    <p><a href="classroom/add" class="btn btn-success">Создать аудиторию</a></p>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                            <th>Наименование</th>
                            <th>Количество мест</th>
                            <th>Расположение</th>
                            <th>Доп. информация</th>
                            <th>Операции</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Classroom::select()->get() as $room)
                    <tr>
                    <td>{{$room->name}}</td>
                    <td>{{$room->capacity}}</td>
                    <td>{{$room->address}}</td>
                    <td>{{$room->description}}</td>
                    <td><a href="{{url('classroom')}}/edit/{{$room->id}}" class="btn btn-primary">Редактировать</a></td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

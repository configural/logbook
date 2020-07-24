
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Кафедры и подразделения</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    <table class='table table-bordered'>
                        <tr>
                            <th>id</th>
                            <th>Наименование</th>
                            <th>Полное название</th>
                            <th>Активно</th>
                        </tr>
                    @foreach(\App\Department::select()->get() as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->description }}</td>
                        <td>{{ $department->active }}</td>
                    </tr>
                    @endforeach
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

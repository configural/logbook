
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журналы преподавателей</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>ФИО</th>
                                <th>Присутствие</th>

                            </tr>
                        </thead>    
                        <tbody>

                            @foreach($attendance as $key => $value)
                            <tr>
                                
                                <td>{{$key}}</td>
                                <td>
                                    {{ \App\Student::find($key)->secname }} {{ \App\Student::find($key)->name }} {{ \App\Student::find($key)->fathername }}
                                </td>
                                <td>{{$value}}</td>

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

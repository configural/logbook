
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журналы преподавателей</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    
                    <p><a href="{{ route('home')}}">В начало</a> —
                    <a href="{{ route('report_journal')}}">Журналы преподавателей</a> –
                    <a href="{{url('reports/journal')}}/{{$user->id}}">{{$user->name}}</a>
                    </p>
                    <h3>{{$journal->rasp->timetable->block->name}}</h3>
                    <h4>{{$journal->rasp->timetable->group->name}}, {{$journal->rasp->date}}</h4>
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
                                <td>
                                @if ($value) 
                                <i class="fa fa-check-circle fa-2x green"></i>
                                @else
                                <i class="fa fa-times-circle fa-2x red"></i>
                                @endif
                                </td>

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


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Внеаудиторная нагрузка</div>

                <div class="panel-body">
                    <p>
                        <a href="{{route('vneaudadd')}}" class="btn btn-success">Внести данные</a>
                    </p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>Преподаватель</th>
                                <th>Кафедра</th>
                                <th>Группа</th>
                                <th>Поток</th>
                                <th>Вид работы</th>
                                <th>Часы</th>
                                <th>Дата</th>
                                <th>Комментарий</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @foreach(\App\Vneaud::get() as $vneaud)
                        <tr>
                            <td><a href='vneaud/{{$vneaud->id}}/edit'>{{ $vneaud->user->name}}</a>
                            @if ($vneaud->user->freelance == 1) 
                            (внештатный)
                            @endif
                            <td>({{ $vneaud->user->department->name}})</td>
                            </td>
                            <td>{{ $vneaud->group->name}}</td>
                            <td>{{ $vneaud->group->stream->name}}</td>
                            <td>{{ $vneaud->lessontype->name }}</td>
                            <td>{{ $vneaud->hours }}</td>
                            <td><span style='display: none'>{{ $vneaud->date }}</span>{{ \Logbook::normal_date($vneaud->date) }}</td>
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


@extends('layouts.app')


@php
    session_start();

    if (isset($_GET["year"])) {
            $year = $_GET["year"];
            $_SESSION["year"] = $year;
            }
    elseif (isset($_SESSION["year"])) {
            $year = $_SESSION["year"];      
        } else {
            $year = date('Y');
        }
 
    $_SESSION["year"] = $year;    

@endphp 

@section('content')

    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Потоки</div>

                <div class="panel-body">
                    
                    
                                            <form method="get">
                            <p>
                            Год: <input type='number' name='year' min='2020' max='2099' value='{{ $year }}' class='form-control-static' onChange='form.submit()'>

                            <button class='btn btn-primary'>Отфильтровать</button>
                        </p>
                    
                    
                    
                    @if(Auth::user()->role_id >= 3)
                    <p><a href="{{url('stream/add')}}" class="btn btn-success">Создать поток</a></p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead class="">
                            <tr>
                                <td>id</td>
                                <td>Название потока</td>
                                <td>Программа</td>
                                <td>Группы</td>
                                <td>Учатся с</td>
                                <td>Учатся до</td>
                                <td>Учебный год</td>
                                <td>Методист</td>
                                <td>Поток активен?</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Stream::select()->where('year', $year)->orderBy('active', 'desc')->orderBy('date_start', 'desc')->get() as $stream)
                            <tr class="">
                                <td><nobr>{{ $stream->id }}</nobr></td>
                                <td><a href="{{url('/')}}/stream/{{$stream->id}}/edit">{{ $stream->name }}</a></td>
                                <td>
                                @foreach($stream->programs as $program) 
                                {{ @str_limit($program->name, 120)}}
                                @endforeach
                                
                                </td>
                                <td>
                                    @foreach($stream->groups as $group)
                                    <a href='{{url('/')}}/group/{{$group->id}}/edit'>
                                        <small class='badge'>
                                        @if($group->paid)
                                        <i class="fa fa-money yellow"></i>
                                        @endif
                                            {{ $group->name }}

                                        </small></a>
                                    @endforeach
                                    
                                </td>
                                
                                <td>{{ $stream->date_start }}</td>
                                <td>{{ $stream->date_finish }}</td>
                                <td>{{ $stream->year }}</td>
                                <td>{{ $stream->metodist->name or ''}}</td>
                                <td>{{ $stream->active or ''}}</td>
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

@endsection

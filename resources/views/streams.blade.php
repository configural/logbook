
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Потоки</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)
                    <p><a href="{{url('stream/add')}}" class="btn btn-success">Создать поток</a></p>
                    
                    <table class="table table-bordered">
                        <thead class="">
                            <tr><td>id</td><td>Название потока</td><td>Учебный год</td></tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Stream::select()->get() as $stream)
                            <tr class="">
                                <td>{{ $stream->id }}</td>
                                <td><a href="{{url('/')}}/stream/{{$stream->id}}/edit">{{ $stream->name }}</a></td>
                                <td>{{ $stream->year }}</td>
                                
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
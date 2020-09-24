
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Планы по созданию медиаконтента</div>

                <div class="panel-body">
                    <p>Данная таблица носит рекомендательный характер и напоминает о том, что не стоит забывать своевременно выполнять план 
                        по созданию видеоуроков, интерактивных учебников, тренажеров, "коротко о главном" и т.п.
                    </p>
                    <p>
                        <a href="{{ route('mediaadd')}}" class="btn btn-success">Добавить</a>
                    </p>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <tr class="info">
                        <th>id</th>
                        <th>Тип</th>
                        <th>Название</th>
                        <th>Преподаватель</th>
                        <th>Дата начала</th>
                        <th>Дата завершения</th>
                        <th>Статус</th>
                        
                        </thead> 
                        <tbody>
                    

                    @foreach(\App\Mediacontent::select()->get() as $media)
                    
                    <tr>
                        <td>{{ $media->id }}</td>
                        <td>{{ $media->mediatype->name or ''}}</td>
                        <td><a href="media/{{$media->id}}/edit">{{ $media->name or ''}}</a></td>
                        <td>
                            @foreach($media->users as $user)
                            {{$user->fio()}} ({{$user->department->name}})<br/>
                            @endforeach
                            
                        </td>
                        
                        <td>{{ $media->date_start}}</td>
                        <td>{{ $media->date_finish}}</td>
                        <td>
                            @if ($media->status)
                            <i class="fa fa-check-circle green fa-2x"></i>
                            @else
                            @endif
                        </td>
                        
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

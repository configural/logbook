
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
                       @if(Auth::user()->role_id == 4) 
                        <a href="{{ route('mediaadd')}}" class="btn btn-success">Добавить</a>
                        @endif
                    </p>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <tr class="info">
                        <th>№</th>
                        <th>Тип</th>
                        <th>Название</th>
                        <th>Преподаватель</th>
                        <th>Продюссер</th>
                        <th>Квартал/Дата начала/завершения</th>
                        
                        <th>Статус</th>
                        <th>Где посмотреть?</th>
                        
                        </thead> 
                        <tbody>
                    
                            @php $i = 0; @endphp
                    @foreach(\App\Mediacontent::select()->get() as $media)
                    
                    <tr>
                        @php $i++; @endphp
                        <td>{{ $i }}</td>
                        <td>{{ $media->mediatype->name or ''}}</td>
                        <td>
                            @if (Auth::user()->role_id == 4)
                            <a href="media/{{$media->id}}/edit">{{ $media->name or ''}}</a>
                            @else
                            {{ $media->name or ''}}
                            @endif
                            
                        </td>
                        <td>
                            @foreach($media->users as $user)
                            {{$user->secname()}} ({{$user->department->name}})<br/>
                            @endforeach
                            
                        </td>
                        <td>
                            @if ($media->master_id)
                            {{ \App\User::find($media->master_id)->secname() }}
                            @endif
                        </td>
                        
                        <td>
                            @if ($media->quarter)
                            {{ $media->quarter }}&nbsp;квартал<br/>
                            @endif
                            {{ $media->date_start}}<br>
                        {{ $media->date_finish}}</td>
                        <td>
                            @if ($media->status)
                            <i class="fa fa-check-circle green fa-2x"></i>
                            @else
                            @endif
                        </td>
                        <td>
                                @if ($media->result_path)
                                <span class='small'>{{$media->result_path}}</span>
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


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Мои планы по созданию медиаконтента</div>

                <div class="panel-body">
                    
                    <p>
                        <a href="{{ route('home')}}">В начало</a>
                    </p>
                    <h1>Планы по созданию медиаконтента</h1>
                    <p>
                    Данная таблица сформирована на основании планов кафедр по созданию видеоуроков и интерактивных учебников. Планы находятся в сетевой папке:<br/>
                    <strong>\\buchterminal\Обмен\Учебно-методическая документация\2020\План Видеоуроки и Интерактив</strong><br/>
                    (скопируйте эту строку и вставьте в адресную строку "Проводника").
                    <p>
                    
                    <P><a href="{{ route('my_media_add')}}" class="btn btn-primary btn-lg">Запланировать запись/создание</a></p>

                        
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <tr class="info">
                        <th>№</th>
                        <th>Тип</th>
                        <th>Название</th>
                        
                        <th>Специалист</th>
                        <th>план начало завершение</th>
                        <th>Статус</th>
                        <th>Где посмотреть?</th>
                        <th>Действия</th>
                        
                        </thead> 
                        <tbody>
                    
                            @php $i = 0; @endphp
                    @foreach(\App\Mediacontent::select()->get() as $media)

                    @foreach($media->users as $user)
                            
                    @if (Auth::user()->id == $user->id)
                    
                    <tr>
                        @php $i++; @endphp
                        <td>{{ $i }}</td>
                        <td>{{ $media->mediatype->name or ''}}</td>
                        <td>{{ $media->name or ''}}</td>
                        <td>
                            @if ($media->master_id)
                            {{ \App\User::find($media->master_id)->fio() }}
                            @endif
                        </td>
                        
                        <td>
                                                        @if ($media->quarter)
                                                        {{ $media->quarter }} квартал<br>
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
                        
                        <td>
                            <a href="my_media/{{$media->id}}/edit" class="btn btn-success">Редактировать</a>
                            
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                    </tbody>
                    </table>
                    
                                            <strong class="red">Если у вас есть «долги» по записи видео или созданию учебников, убедительная просьба не откладывать на конец года, так как
                            загруженность студии и сотрудников ОДПО в этот период традиционно очень большая.
                        </strong>
                    </p>
                    
                    <p>
                      Для планирования работы обращайтесь к Н.Карпеевой или А.Кашканову - тел. 138
                </p>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

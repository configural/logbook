
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Вебинары</div>

                <div class="panel-body">
                    <p>
                        <a href="{{ route('webinaradd')}}" class="btn btn-success">Внести данные</a>
                    </p>
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Название, описание</th>
                                <th>Преподаватели</th>
                                <th>Группы</th>
                                <th>Ссылка</th>
                                <th>Кабинет</th>
                                <th>Методист</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @foreach(\App\Webinar::get() as $webinar)
                        <tr>
                            <td>{{$webinar->date}}</td>
                            <td>{{$webinar->start_at}}<br/>{{ $webinar->finish_at}}</td>
                            <td>{{$webinar->name}}<br><small>{{$webinar->description}}</small></td>
                            <td>
                               @foreach($webinar->teachers as $teacher)
                               <span class="badge">{{$teacher->secname()}}</span>
                                @endforeach                                 
                            </td>
                            <td>
                                @foreach($webinar->groups as $group)
                                <span class="badge">{{$group->name}}</span>
                                @endforeach
                            </td>
                            <td><nobr>
                                <a href="{{$webinar->webinar_link}}" target="_blank" class="btn btn-primary">Вебинар</a> 
                                @if($webinar->record_link)
                                <a href="{{$webinar->record_link}}" target="_blank" class="btn btn-danger">Запись</a></td>
                                @endif
                                </nobr>
                            <td>
                                {{$webinar->room_id}}
                            </td>
                            <td>
                                {{$webinar->metodist->secname()}}
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

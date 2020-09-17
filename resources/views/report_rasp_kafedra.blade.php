
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Расписание преподавателей кафедры за период</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="post">
                        <p><label>Кафедра (подразделение)</label> <br/>
                        
                            <select name="department_id" class="form-control-static">
                            
                            @foreach(\App\Department::where('active', 1)->get() as $dep)
                            @if (isset($request) && $dep->id == $request->department_id)
                            <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                            @else
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endif
                            @endforeach
                            
                        </select>
                        <p>
                            <label>Период: </label><br/>
                            <input type="date" name="date1" class="form-control-static" value='{{$request->date1 or ''}}' required>
                            <input type="date" name="date2" class="form-control-static" value='{{$request->date2 or ''}}' required>

                        </p>
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                    </form>
                    <p></p>
                    
                    @if(isset($users))
                    <table class='table table-bordered'>
                    @foreach($users as $user)
                    <tr>
                        <th colspan='7' class='alert-success'>{{ $user->name}}</th>
                    </tr>

                        <tr>
                            
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Группа</th>
                            <th>Аудитория</th>
                            <th>Методист</th>
                            <th>Тема в расписании</th>
                            
                            
                        </tr>                    
                    @foreach($user->timetable()->get() as $timetable)

                        <tr>
                            <td><nobr>{{ $timetable->rasp->date or ''}}</nobr></td>
                            <td>{{ $timetable->rasp->start_at or ''}}<br>
                                {{ $timetable->rasp->finish_at or ''}}</td>
                            <td>{{ $timetable->group->name or ''}}</td>
                            <td>{{ $timetable->rasp->classroom->name or ''}}</td>
                            <td>
                                @if ($timetable->group->stream->metodist_id)
                                {{ $timetable->group->stream->metodist->fio()}}
                                @endif
                            </td>
                                
                            <td>{{ $timetable->block->name or ''}} {{$timetable->lesson_type->name}}</td>
                            
                        </tr>
                        @endforeach
                    
                    @endforeach
                    @endif
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

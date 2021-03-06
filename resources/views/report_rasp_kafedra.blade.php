@extends('layouts.app')

@php 
    $hours = 0;
    $date = "";
    $time1 = "";
    $time2 = "";
    $room = "";
    
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Расписание преподавателей кафедры за период {{ date('d.m.Y', strtotime($date1)) }} — {{ date('d.m.Y', strtotime($date2)) }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="get">
                        <p><label>Кафедра (подразделение)</label> <br/>
                        
                            <select name="department_id" class="form-control-static">
                                
                            @foreach(\App\Department::where('active', 1)->get() as $dep)
                            @if (isset($department_id) && $dep->id == $department_id)
                            <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                            @else
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endif
                            @endforeach
                            @if (isset($department_id) && $dep->id == -1)
                            <option value='-1' selected>Все кафедры</option>
                            @else
                            <option value='-1'>Все кафедры</option>
                            @endif
                        </select>
                         
                            @include('include.daterange', ['date1' => $date1, 'date2' => $date2])
                        
                        @if ($freelance == 0)
                        <p><input type="radio" name="freelance" value="0" checked> Штатные преподаватели</p>
                        <p><input type="radio" name="freelance" value="1"> Внештатные преподаватели</p>
                        @else
                        <p><input type="radio" name="freelance" value="0"> Штатные преподаватели</p>
                        <p><input type="radio" name="freelance" value="1" checked> Внештатные преподаватели</p>
                        
                        @endif
                        
                        
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                    </form>
                    <p></p>

                    
                    @if(isset($users))
                    
                    @foreach($users as $user)
                    
                    @if (\App\User::rasp($user->id, $date1, $date2))
                    <hr>        
                    <h4>{{ $user->name}}</h4>
                            
                            <table class='table-bordered'>

                                <thead>
                                <tr class='alert-info'>

                                    <th width='10%'>Дата</th>
                                    <th width='15%'>Время</th>
                                    <th width='2%'>Часов</th>
                                    <th width='10%'>Группа</th>
                                    <th width='10%'>Аудитория</th>
                                    <th width='15%'>Методист</th>
                                    <th width='40%'>Тема в расписании</th>


                                </tr>  
                                </thead>
                                <tbody>
                            @foreach($user->timetable()
                            ->join('rasp', 'rasp.id', '=', 'rasp_id')
                            ->whereBetween('rasp.date', [$date1, $date2])
                            ->whereNotNull('rasp.room_id')
                            ->orderby('rasp.date')->get() as $timetable)

                            @if (!($date == $timetable->rasp->date 
                                and $time1 == $timetable->rasp->start_at 
                                and $time2 == $timetable->rasp->finish_at
                                and $room ==  $timetable->rasp->classroom->name
                                
                                ))
                                <tr>
                                    <td><nobr>{{ \Logbook::normal_date($timetable->rasp->date)}}</nobr></td>
                                    <td>{{ @str_limit($timetable->rasp->start_at, 5, '')}} —
                                        {{ @str_limit($timetable->rasp->finish_at, 5,'')}}</td>
                                    <td><center>{{ $timetable->hours}}</center></td>
                                    <td>{{ $timetable->group->name or ''}}</td>
                                    <td>{{ $timetable->rasp->classroom->name or ''}}</td>
                                    <td>
                                        @if ($timetable->group->stream->metodist_id)
                                        {{ $timetable->group->stream->metodist->fio()}}
                                        @endif
                                    </td>

                                    <td><strong>{{$timetable->lesson_type->name}}</strong>: {{ $timetable->block->name or ''}} </td>

                                </tr>
                                @php
                                $hours += $timetable->hours;
                                
                                $date = $timetable->rasp->date;
                                $time1 = $timetable->rasp->start_at ;
                                $time2 = $timetable->rasp->finish_at;
                                $room =  $timetable->rasp->classroom->name;
                                
                                
                                
                                @endphp
                            
                                @else
                                <tr><td><center><i class="fa fa-arrow-up" title="Объединено с предыдущим"></i></center></td>
                                    <td>{{ @str_limit($timetable->rasp->start_at, 5, '')}} —
                                        {{ @str_limit($timetable->rasp->finish_at, 5,'')}}</td>
                                    <td><center><i class="fa fa-arrow-up" title="Объединено с предыдущим"></i></center></td>
                                    <td>{{ $timetable->group->name or ''}}</td>
                                    <td>{{ $timetable->rasp->classroom->name or ''}}</td>
                                    <td>
                                        @if ($timetable->group->stream->metodist_id)
                                        {{ $timetable->group->stream->metodist->fio()}}
                                        @endif
                                    </td>

                                    <td><strong>{{$timetable->lesson_type->name}}</strong>: {{ $timetable->block->name or ''}} </td>
                                </tr>
                                
                                @endif
                            
                            
                            
                            @endforeach
                            
                             
                             
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <td>Итого<td>
                                    <td><center>{{ $hours }}</center></td>
                                    <td colspan="10"></td>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                        @php ($hours = 0)
                    @endforeach
                    @endif
                

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

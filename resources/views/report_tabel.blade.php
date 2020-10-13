
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Табель учета проведенных занятий (штатные преподаватели)</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="get">
                        <p><label>Кафедра (подразделение)</label> <br/>
                        
                            <select name="department_id" class="form-control-static">
                            
                            @foreach(\App\Department::where('active', 1)->get() as $dep)
                            @if (isset($department_id) && $dep->id == $department_id)
                            <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                            @php $kafedra = $dep->description; @endphp
                            @else
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endif
                            @endforeach
                            
                        </select>
                         
                            @include('include.daterange', ['date1' => $date1, 'date2' => $date2])
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                        
                        <p>Для печати табеля нажмите Ctrl + P</p>
                        
                    </form>
                    <p></p>
                    <h2>{{ $kafedra or '' }}</h2>
                    <table class='table table-bordered printable' width="100%">
                        
                    <thead>
                        <tr class='alert-info'>
                            
                            <th style="width: 10%;">№</th>
                            <th style="width: 30%;">ФИО</th>
                             @foreach(\App\Lessontype::where('in_table', 1)->get() as $lessontype)
                             <th  style="width: 10%;">
                            {{ $lessontype->name }}
                             </th>
                            @endforeach
                            <th  style="width: 10%;">Всего часов</th>

                            
                            
                        </tr>  
                        </thead>
                        <tbody>
                    
                    @if(isset($users))
                    
                    @php
                    $total = Array();
                    $i = 0;
                    @endphp
                    
                    @foreach($users as $user)
                    <tr>
                        @php
                        $total_user = 0;
                        $i++;
                        @endphp
 
                        <td>{{ $i }}</td>
                        <td>{{ $user->fio()}}</td>
                        
                        @foreach(\App\Lessontype::where('in_table', 1)->get() as $lessontype)
                        <td>
                           @php 
                            $total_user += \App\User::user_hours_rasp($user->id, $date1, $date2, $lessontype->id);
                            
                            if (!isset($total[$lessontype->id])) { 
                                $total[$lessontype->id] = 0;
                                $total[$lessontype->id] += \App\User::user_hours_rasp($user->id, $date1, $date2, $lessontype->id);
                            } else {
                                $total[$lessontype->id] += \App\User::user_hours_rasp($user->id, $date1, $date2, $lessontype->id);
                            }
                            
                            @endphp
                       
                            {{ \App\User::user_hours_rasp($user->id, $date1, $date2, $lessontype->id) }}
                        

                            <br>
                        </td>
                        @endforeach
                        <td>
                            {{ $total_user}}
                        </td>
                    </tr>
                    @endforeach

                    @endif
                    <tr>
                        <th></th>
                        <th>Итого</th>
                        @foreach($total  as $t)
                        <th>{{ $t }}</th>
                        @endforeach
                        <th>{{ array_sum($total)}}</th>
                    </tr>
                    
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

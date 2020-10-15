
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="panel panel-primary">
                <div class="panel-heading ">Табель учета проведенных занятий (внештатные преподаватели)</div>

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
                            <tr>
                                <th rowspan="2">ФИО</th>
                                <th rowspan="2">Договор</th>
                                <th rowspan="2">Стоимость часа</th>
                                @foreach(\App\Lessontype::where('in_table', 1)->get() as $lessontype)
                                <th colspan="2">{{$lessontype->name}}</th>
                                @endforeach
                            <th  colspan="2">ИТОГО</th>
                            </tr>
                            <tr>
                                @foreach(\App\Lessontype::where('in_table', 1)->get() as $lessontype)
                                <th>ч.</th>
                                <th>руб.</th>
                                @endforeach
                            <th>часов</th>
                            <th>рублей</th>
                            </tr>
                      
                        </thead>
                        <tbody>
                   @php
                       $total_price = 0;
                       $total_hours = 0;         
                   @endphp
                   @foreach(\App\Contract::get() as $contract)
                   @if($contract->user->department_id == $department_id)
                   <tr>

                   
                   
                       <td>
                           {{ $contract->user->name }}
                       </td> 
                       
                       <td>
                           {{ $contract->name }}
                       </td> 
                       
                       <td>
                           {{ $contract->price }}
                           
                       </td> 
                   
                   @php
                        $line_price = 0;
                        $line_hours = 0;
                   @endphp
                   
                   @foreach(\App\Lessontype::where('in_table', 1)->get() as $lessontype)
                   @if (!$lessontype->vneaud)
                   @php
                      $hours = \App\User::user_hours_rasp($contract->user->id, $date1, $date2, $lessontype->id);
                      $price = $hours * $contract->price;
                      
                      $line_hours += $hours;
                      $line_price += $price;
                      
                    @endphp
                       
                      <td>{{ $hours }}</td>
                      
                      <td>{{ $price }}</td>
                   
                   
                      @else 
                   @php
                      $hours = \App\User::user_hours_vneaud($contract->user->id, $date1, $date2, $lessontype->id);
                      $price = $hours * $contract->price;
                      
                      $line_hours += $hours;
                      $line_price += $price;
                      
                    @endphp
                       
                      <td>{{ $hours }}</td>
                      
                      <td>{{ $price }}</td>                      
                      @endif
                      
                      @endforeach
                   @php
                        $total_price += $line_price;
                        $total_hours += $line_hours;
                    
                   @endphp
                   <td>{{$line_hours}}</td>
                   <td>{{$line_price}}</td>
                   
                   </tr>
                   @endif
                   @endforeach
                   <tr>
                       <td>
                           {{ $total_hours}}
                       </td>

                       <td>
                           {{ $total_price}}
                       </td>                       
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

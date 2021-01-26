@php
$hours1 = 0;
$hours2 = 0;
$price1 = 0;
$price2 = 0;
$contract_price = 600;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="panel panel-primary">
<!--                <div class="panel-heading "></div>-->

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="get">
                        <p><label>Форма обучения</label> 
                        
                            <select name="form_id" class="form-control-static">
                                <option value=''>выберите</option>
                            @foreach(\App\Form::get() as $form)
                            @if (isset($form_id) && $form->id == $form_id)
                            <option value="{{ $form->id }}" selected>{{ $form->name }}</option>
                            @else
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                            @endif
                            @endforeach
                            
                        </select>
                            
                            
                            <label>Источник средств </label> 
                                        <select id="paid" name="paid" class="form-control-static">
                                            @if ($paid == 0)
                                            <option value="0" selected>субсидии</option>
                                            <option value="1">деятельность, приносящая доход</option>
                                            @else
                                            <option value="0">субсидии</option>
                                            <option value="1" selected>деятельность, приносящая доход</option>
                                            @endif
                                        </select> 
                                    </p>
                            @include('include.daterange', ['date1' => $date1, 'date2' => $date2])
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                        
                        <p>Для печати табеля нажмите Ctrl + P</p>
                        
                    </form>
                    <p></p>
                    <div style="float: right; width: 400; display: block"><center>Утверждаю</center>
                        <p>Ректор Приволжского института повышения<br/>квалификации ФНС России</p>
                        <p>__________________ Н.Ф. Беляков</p>
                        <p>"_____" _________ {{ date('Y')}}</p>
                    
                    </div>
                    <div style="clear: both;"></div>
                    
                    
                    <center><h3>Табель учета проведенных занятий и причитающихся сумм к выплате исполнителям преподавательских услуг</h3></center>
                    
                    <h4>Период: {{ \Logbook::normal_date($date1)}} – {{ \Logbook::normal_date($date2)}}</h4>
                    
                    @if ($form_id)
                    <h4>Форма обучения: {{ \App\Form::find($form_id)->name }}</h4>
                    @endif
                    
                    @if ($paid == 1)
                    <h4>Источник финансирования: деятельность, приносящая доход</h4>
                    @else
                    <h4>Источник финансирования: субсидии</h4>
                    @endif
                    
                    
                    <table class='table table-bordered printable' width="100%">
                        
                        <thead>
                            <tr>
                                <th rowspan="2">ФИО</th>
                                <th rowspan="2">Таб.№</th>
                                
                                <th rowspan="2">Цена, руб/ч</th>
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
                   
                   
                   @foreach(\App\Contract::selectRaw('contracts.*' )
                            ->join('teachers2timetable', 'teachers2timetable.contract_id', '=', 'contracts.id')
                            ->join('timetable', 'timetable.id', '=', 'teachers2timetable.timetable_id')
                            ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                            ->join('groups', 'groups.id', '=', 'timetable.group_id')
                            ->join('streams', 'streams.id', '=', 'groups.stream_id')
                            ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                            ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                            ->join('users', 'contracts.user_id', '=', 'users.id')
                            ->distinct()
                            ->where('groups.paid', $paid)
                            ->whereBetween('rasp.date', [$date1, $date2])
                            ->where('programs.form_id', $form_id)
                            
                            ->get() as $contract)
                   
                   <tr>

                   
                   
                       <td>
                        <nobr>{{ $contract->user->name }}</nobr>

                        <nobr>{{ $contract->name }}  от {{ \Logbook::normal_date($contract->date)}}</nobr>
                       </td> 
                       <td>
                           {{$contract->user->table_number}}
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
                   
                   @endforeach
                   <tr>
                       <td>ИТОГО<td>
                           @for($i = 0; $i<33; $i++)
                       <td></td>
                           @endfor
                       <td>
                           {{ $total_hours}}
                       </td>

                       <td>
                           {{ $total_price}}
                       </td>                       
                   </tr>
                    </tbody>
                </table>
                
                    

                    <table class='table table-bordered'>
                        <tr>
                        <th colspan='3'>"32"</th>
                            </tr>
                        
                    @foreach(\App\User::selectRaw('sum(timetable.hours) as hours ')
                                    ->leftjoin('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                                    ->join('timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                    ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                    ->join('programs', 'programs.id', '=', 'programs2stream.program_id')                                    
                                    ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                                    ->where('users.freelance', '=', 0)
                                    ->where('programs.form_id', $form_id)
                                    ->where('groups.paid', $paid)
                                    ->whereBetween('rasp.date', [$date1, $date2])
                                    ->get() 
                    
                    as $contract)
                    <tr>
                        <td>{{$contract_price}}</td>
                        <td>{{$contract->hours}}</td>
                        <td>{{$contract->hours * $contract_price}}</td>
                        @php
                        $hours1 += $contract->hours;
                        $price1 += $contract->hours * $contract_price;
                        @endphp
                    </tr>
                    @endforeach
                        
                        
                        
                        
                            <tr>
                                <th colspan='3'>"34"</th>
                            </tr>
                        
                    @foreach(\App\Contract::selectRaw('contracts.price as price, sum(timetable.hours) as hours ')
                                    ->join('teachers2timetable', 'teachers2timetable.contract_id', '=', 'contracts.id')
                                    ->join('timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                    ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                    ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                    ->join('programs', 'programs.id', '=', 'programs2stream.program_id')                                      
                                    ->groupBy('contracts.price')
                                    ->whereBetween('rasp.date', [$date1, $date2])
                                    ->where('programs.form_id', $form_id)
                                    ->where('groups.paid', $paid)
                                    ->get() 
                    as $contract)
                    <tr>
                        <td>{{$contract->price}}</td>
                        <td>{{$contract->hours}}</td>
                        <td>{{$contract->hours * $contract->price}}</td>
                        @php
                        $hours2 += $contract->hours;
                        $price2 += $contract->hours * $contract->price;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td>ИТОГО</td>
                        <td>{{$hours2}}</td>
                        <td>{{$price2}}</td>
                    </tr>
                    <tfoot>
                        <tr>
                            <td>ВСЕГО</td>
                            <td>{{ $hours1 + $hours2 }}</td>
                            <td>{{ $price1 + $price2 }}</td>
                        </tr>
                    </tfoot>
                    </table>
                    
                    
                    @php
                    
                                     $check = \App\User::selectRaw('sum(timetable.hours) as hours ')
                                    ->leftjoin('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                                    ->join('timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                    ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                    ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                    ->join('programs', 'programs.id', '=', 'programs2stream.program_id')  
                                    ->where('users.freelance', '=', 1)
                                    ->whereBetween('rasp.date', [$date1, $date2])
                                    ->where('programs.form_id', $form_id)
                                    ->where('groups.paid', $paid)
                                    ->first(); 
                    
                    
                    @endphp
                    
                    @if ($check->hours != $hours2)
                    <div class='red'>Найдено расхождение в часах! У внештатников должно быть 50 часов. Кого-то забыли!</div>
                    
                    @foreach(\App\User::selectRaw('users.name as username, timetable.hours as hours, timetable.id as timetable_id, contracts.name as contractname')
                                    ->leftjoin('contracts', 'contracts.user_id', '=', 'users.id')
                                    ->leftjoin('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                                    ->join('timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                    ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                    ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                                    ->join('programs', 'programs.id', '=', 'programs2stream.program_id')  
                                    ->where('users.freelance', '=', 1)
                                    ->where('teachers2timetable.contract_id', NULL)
                                    ->where('programs.form_id', $form_id)
                                    ->where('groups.paid', $paid)                                    
                                    ->whereBetween('rasp.date', [$date1, $date2])
                                    ->get() as $checklist )
                                    <a href='{{url('/')}}/workload/edit/{{$checklist->timetable_id}}' target="_blank">{{ $checklist->username}} - {{ $checklist->hours}} - {{$checklist->contractname}}</a><br>               
                    @endforeach
                    <div class='red'>Причина - отсутствует привязка нагрузки к договору. Найдите нагрузку (кликните по ссылке), выберите из списка номер договора и нажмтите "Сохранить". 
                        После этого вернитесь на эту страницу и обновите ее (F5)</div>

                    @else
                    <p>Главный бухгалтер _________________________  М.Г. Цветкова</p>
                    <p>Проректор по учебной работе________________  И.В. Кожанова</p>
                    
                    
                    
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

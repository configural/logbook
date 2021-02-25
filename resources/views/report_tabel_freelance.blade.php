@php
$hours1 = 0;
$hours2 = 0;
$price1 = 0;
$price2 = 0;
$contract_price = 600;
$months_array = ['','январь','фераль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'];

$table32 = 0;
$table34 = [];


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
                            @if ($form_id == "-1")
                            <option value="-1" selected>все формы обучения</option>
                            @else
                            <option value="-1">все формы обучения</option>
                            @endif
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
                                    
                            <label>Месяц:</label> 
                            <select name="month"  class="form-control-static">
                                @for($i = 1; $i<=12; $i++)
                                @if ($month == $i)
                                <option value="{{ sprintf("%02d", $i)}}" selected>{{ $months_array[$i]}}</option>
                                @else
                                <option value="{{ sprintf("%02d", $i)}}">{{ $months_array[$i]}}</option>
                                @endif
                                
                                @endfor
                            </select>
                            
                        
                            <label>Год:</label> <input type='number' name='year' value='{{$year}}' class="form-control-static">
                        </p>
                        <p>
                        <!--    <label>Кто утверждает: </label>
                        <input id='rektor_input' value='Ректор' class='form-control-static'>
                        <input id='rektor_fio_input' value='Н.Ф. Беляков' class='form-control-static'>
                        </p>-->
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
                        {{ csrf_field() }}
                        
                        <p>Для печати табеля нажмите Ctrl + P</p>
                        
                    </form>
                    <p></p>
                   <!-- <div style="float: right; width: 400; display: block"><center>Утверждаю</center>
                        <p><span id="rektor">Ректор</span> Приволжского института повышения<br/>квалификации ФНС России</p>
                        <p>__________________ <span id="rektor_fio">Н.Ф. Беляков</span></p>
                        <p>"_____" _________ {{ date('Y')}}</p>
                    
                    </div>
                    <div style="clear: both;"></div>
                    -->
                    
                    <h4>Табель учета проведенных занятий и причитающихся сумм к выплате исполнителям преподавательских услуг за {{ $months_array[(int)$month]}} {{$year}} года</h4>
                    
                   {{-- <h4>Период: {{ \Logbook::normal_date($date1)}} – {{ \Logbook::normal_date($date2)}}</h4>
                    --}}
                    
                    @if ($form_id)
                    <h4>
                        @if(strlen($form_id) == 1)
                        Форма обучения: 
                        {{ \App\Form::find($form_id[0])->name }}
                        @else
                        Все формы обучения
                        @endif
                    </h4>
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
                                <th colspan='2'>Аудиторные занятия, консультации, в т.ч. перед экзаменами, рук.квал.работой</th>
                                <th colspan='2'>Участие в аттестационной комиссии в качестве члена или председателя комиссии</th>
                                <th colspan='2'>Проверка итоговых работ и участие в аттестационной комиссии по их защите</th>
                                <th colspan='2'>Проверка тестов</th>
                                <th colspan='2'>Проведение вебинаров</th>

                            <th  colspan="2">ИТОГО</th>
                            </tr>
                            <tr>
                            
                            <th>часов</th>
                            <th>рублей</th>
                            
                            <th>часов</th>
                            <th>рублей</th>
                            
                            <th>часов</th>
                            <th>рублей</th>

                            <th>часов</th>
                            <th>рублей</th>

                            <th>часов</th>
                            <th>рублей</th>
                            <th>часов</th>
                            <th>рублей</th>
                            
                            
                            </tr>
                      
                        </thead>
                        <tbody>
                   @php
                       $total_price = 0;
                       $total_hours = 0;         
                   @endphp
                   
                   @php
                   if ($form_id == -1){
                   $contracts = \App\Contract::selectRaw('contracts.*' )
                            ->join('users', 'contracts.user_id', '=', 'users.id')         
                            ->join('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                            ->join('timetable', 'timetable.id', '=', 'teachers2timetable.timetable_id')
                            ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                            ->join('groups', 'groups.id', '=', 'timetable.group_id')
                            ->join('streams', 'streams.id', '=', 'groups.stream_id')
                            ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                            ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                            ->where('groups.paid', $paid)
                            ->whereMonth('rasp.date', $month)
                            ->whereIn('programs.form_id', [1,2,3])
                            ->distinct()
                            ->orderBy('users.name')
                            ->get();
                            }
                    else    {
                    $contracts = \App\Contract::selectRaw('contracts.*' )
                            ->join('users', 'contracts.user_id', '=', 'users.id')         
                            ->join('teachers2timetable', 'teachers2timetable.teacher_id', '=', 'users.id')
                            ->join('timetable', 'timetable.id', '=', 'teachers2timetable.timetable_id')
                            ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                            ->join('groups', 'groups.id', '=', 'timetable.group_id')
                            ->join('streams', 'streams.id', '=', 'groups.stream_id')
                            ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                            ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                            ->where('groups.paid', $paid)
                            ->whereMonth('rasp.date', $month)
                            ->where('programs.form_id', $form_id)
                            ->distinct()
                            ->orderBy('users.name')
                            ->get();
                          }  
                   @endphp
                   
                   
                   
                   @foreach($contracts as $contract)
                   
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
                        $hours = 0;
                        $aud_h = [1,2,13, 14, 15];
                        $att_h = [3, 16, 17, 18, 19];
                        $prov_h = [4,5,10];
                        $test_h = [9];
                        $web_h = [11];
                        
                        
                   @endphp
                   
<!-- аудиторные занятия-->
                   @foreach($aud_h as $h) 
                    @php
                    $hours += \App\User::user_hours_rasp($contract->user->id, $month, $year, $h);
                    @endphp
                   @endforeach
                    <td>{{ $hours }}</td>
                    <td>{{ $hours * $contract->price }}</td>                  
                    @php ($line_hours += $hours)
                    @php ($hours = 0)
                    
<!-- аттестация-->
                   @foreach($att_h as $h) 
                    @php
                    $hours += \App\User::user_hours_rasp($contract->user->id, $month, $year, $h);
                    @endphp
                   @endforeach
                    <td>{{ $hours }}</td>
                    <td>{{ $hours * $contract->price }}</td>                                      
                    @php ($line_hours += $hours)
                    @php ($hours = 0)

<!-- проверка итоговых работ-->
                   @foreach($prov_h as $h) 
                    @php
                    $hours += \App\User::user_hours_vneaud($contract->user->id, $month, $year, $h);
                    @endphp
                   @endforeach
                    <td>{{ $hours }}</td>
                    <td>{{ $hours * $contract->price }}</td>                                      
                    @php ($line_hours += $hours)
                    @php ($hours = 0)

<!-- проверка тестов-->
                   @foreach($test_h as $h) 
                    @php
                    $hours += \App\User::user_hours_vneaud($contract->user->id, $month, $year, $h);
                    @endphp
                   @endforeach
                    <td>{{ $hours }}</td>
                    <td>{{ $hours * $contract->price }}</td>                                      
                    @php ($line_hours += $hours)
                    @php ($hours = 0)
<!-- вебинары-->
                   @foreach($web_h as $h) 
                    @php
                    $hours += \App\User::user_hours_rasp($contract->user->id, $month, $year, $h);
                    @endphp
                   @endforeach
                    <td>{{ $hours }}</td>
                    <td>{{ $hours * $contract->price }}</td>                                      
                    @php ($line_hours += $hours)
                    @php ($hours = 0)
                    @php ($line_price = $line_hours * $contract->price)
<!-- Итого -->
                    <td>{{ $line_hours }}</td>
                    <td>{{ $line_price }}</td> 

                   @php
                        $total_price += $line_price;
                        $total_hours += $line_hours;
                    
                     if (!isset($table34[$contract->price])) {$table34[$contract->price] = $line_hours;}
                     else {$table34[$contract->price] += $line_hours;}
                   
                   
                   
                   @endphp
                   

                   </tr>
                   
                   @endforeach
                   <tr>
                       <td>ИТОГО<td>
                           @for($i = 0; $i<11; $i++)
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

                    <p>Проректор по учебной работе________________  И.В. Кожанова</p>
                    
                    <p class="pagebreak"></p>

                    <table class='table table-bordered'>
                        <tr>
                            <th colspan='3'>"32"</th>
                        </tr>
                            @foreach(\App\User::where('role_id', '2')->where('freelance', 0)->get() as $user)
                            
                                @foreach(\App\LessonType::where('in_table', 1)->where('vneaud', 0)->get() as $lessontype)
                                    @php 
                                    $table32 += \App\User::user_hours_rasp($user->id, $month, $year, $lessontype->id);
                                    @endphp
                                @endforeach
                                
                                @foreach(\App\LessonType::where('in_table', 1)->where('vneaud', 1)->get() as $lessontype)
                                    @php 
                                    $table32 += \App\User::user_hours_vneaud($user->id, $month, $year, $lessontype->id);
                                    @endphp
                                @endforeach                                
                        
                            
                            @endforeach
                        <tr>
                            <td>{{ $contract_price }}</td>
                            <td>{{ $table32 }}</td>
                            <td>{{ $table32 * $contract_price }}</td>
                            
                        </tr>
                        
                        <tr>
                            <th colspan='3'>"34"</th>
                        </tr>
                        @php
                        $total_hours = 0;
                        $total_price = 0;
                        @endphp
                        
                        @foreach($table34 as $key => $value)
                        <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $value }}</td>
                        <td>{{ $key * $value }}</td>
                        
                        @php
                        $total_price += $key * $value;
                        @endphp
                        
                        <tr>
                        @endforeach
                        <tfoot>
                        <tr><td colspan='2'>Итого</td><td>{{ $total_price }}</td></tr>
                        <tr><td colspan='2'>Всего</td><td>{{ $total_price + $table32 * $contract_price }}</td></tr>
                        </tfoot>
                    </table>
                        
                    
                    
                    <p>Проректор по учебной работе________________  И.В. Кожанова</p>
                    
                    
                    
<!--- Проверка на привязанность элементов нагрузки к договорам --->             

@foreach($timetable = \App\Timetable::selectraw('timetable.*, users.id as uid, users.name as uname')
            ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
            ->join('users', 'users.id', '=', 'teachers2timetable.teacher_id')
            ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
            ->where('users.freelance', 1)
            ->whereMonth('rasp.date', $month)
            ->where('teachers2timetable.contract_id', NULL)
            ->get() as $t

)

Нет договора: <a href="{{url('/')}}/workload/edit/{{$t->id}}" target="_blank">{{ @$t->rasp->date }} {{ @$t->lesson_type->name }} {{ @$t->block->name }} {{ @$t->uname}}</a> <br>

@endforeach




                    
                    
                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
        $('#rektor_input').keyup(function(){
        $('#rektor').html($('#rektor_input').val());
        });
        
        $('#rektor_fio_input').keyup(function(){
        $('#rektor_fio').html($('#rektor_fio_input').val());
        });
});      
</script>
    
@endsection

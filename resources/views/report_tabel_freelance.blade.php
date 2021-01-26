
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="panel panel-primary">
                <div class="panel-heading ">Табель учета проведенных занятий (внештатные преподаватели): {{ \Logbook::normal_date($date1)}} – {{ \Logbook::normal_date($date2)}}</div>

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
                    @if ($form_id)
                    <h2>Форма обучения: {{ \App\Form::find($form_id)->name }}</h2>
                    @endif
                    
                    @if ($paid == 1)
                    <h3>Источник финансирования: деятельность, приносящая доход</h3>
                    @else
                    <h3>Источник финансирования: субсидии</h3>
                    @endif
                    
                    
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
                   
                   
                   @foreach(\App\Contract::selectRaw('contracts.*' )
                            ->join('teachers2timetable', 'teachers2timetable.contract_id', '=', 'contracts.id')
                            ->join('timetable', 'timetable.id', '=', 'teachers2timetable.timetable_id')
                            ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                            ->join('groups', 'groups.id', '=', 'timetable.group_id')
                            ->join('streams', 'streams.id', '=', 'groups.stream_id')
                            ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                            ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                            ->distinct()
                            ->where('groups.paid', $paid)
                            ->whereBetween('rasp.date', [$date1, $date2])
                            ->where('programs.form_id', $form_id)
                            
                            ->get() as $contract)
                   
                   <tr>

                   
                   
                       <td>
                           {{ $contract->user->name }}
                       </td> 
                       
                       <td>
                           {{ $contract->name }}  от {{ \Logbook::normal_date($contract->date)}}
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
                

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

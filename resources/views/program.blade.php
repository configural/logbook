@php
$l_sum = 0;
$p_sum = 0;
$s_sum = 0;
$w_sum = 0;

@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Образовательная программа</div>

                <div class="panel-body">
                    
                    <p><a href="{{ url('programs')}}">Все программы</a></p>
                    <h3>{{ \App\Program::find($id)->name }} </h3>
                    <p>Учебных часов: {{ \App\Program::find($id)->hours}}</p>
                    <p>Форма обучения: {{ \App\Program::find($id)->form->name}}</p>
                    <p>Итоговая аттестация: {{ \App\Program::find($id)->attestation->name}}</p>

                    <h4>Учебно-тематический план</h4>
                    
                    <form action="discipline_bind" method="post">
                    <h3>Добавить дисциплину</h3>
                    <p>
                        <input name="program_id" type="hidden" value="{{$id}}">
                        <select name="discipline_id" class="form-control">
                        @foreach(\App\Discipline::select()->where('active', 1)->orderby('name')->get() as $discipline)
                        @if (1)
                        <option value="{{$discipline->id}}">
                            [id:{{$discipline->id}}]
                            
                            {{ @str_limit($discipline->name, 100)}} 
                            [{{ @str_limit($discipline->programs->first()->form->name, 5) }} ::
                            {{$discipline->hours}} ч.]
                            
                            
                        </option>
                        @endif
                        @endforeach
                    
                        </select>    
                    </p>
                    {{ csrf_field() }}
                    <button class='btn btn-success'>Добавить дисциплину в эту программу</button>
                    </form>
                    
                    
                    
                    
                    <table class="table table-bordered">
                        <tr>   
                            <td colspan="2">Дисциплина</th>
                            <td>Лекции, ч</th>
                            <td>Практика, ч</th>
                            <td>Самост., ч</th>
                            <td>Вебинары., ч</th>
                                <td>Действия</th>
                        </tr>
                        
                    @foreach(\App\Program::find($id)->disciplines as $discipline)
                    <tr>
                        <th colspan="2"><a href="{{ url('/')}}/discipline/{{ $discipline->id}}" title="Кликните чтобы редактировать список блоков">{{$discipline->name}}</a></th>
                    <th>{{ $discipline->active_blocks->sum('l_hours')}} @php $l_sum +=$discipline->active_blocks->sum('l_hours'); @endphp</th>
                    <th>{{ $discipline->active_blocks->sum('p_hours')}} @php $p_sum +=$discipline->active_blocks->sum('p_hours'); @endphp</th>
                    <th>{{ $discipline->active_blocks->sum('s_hours')}} @php $s_sum +=$discipline->active_blocks->sum('s_hours'); @endphp</th>
                    <th>{{ $discipline->active_blocks->sum('w_hours')}} @php $w_sum +=$discipline->active_blocks->sum('w_hours'); @endphp</th>
                    <th><a href="{{$id}}/discipline_unbind/{{$discipline->id}}"  onclick="return confirm('Действительно удалить привязку?')">Убрать</a></th></tr>
                     
                        <ul>    
                        @foreach(\App\Block::select()->where('discipline_id', $discipline->id)->where('active', 1)->get() as $block)
                           
                        <tr>
                            <td></td>
                        <td>{{ $block->name }}</td>
                        <td>{{ $block->l_hours }}</td>
                        <td>{{ $block->p_hours }}</td>
                        <td>{{ $block->s_hours }}</td>
                        <td>{{ $block->w_hours }}</td>
                        <td></td>
                        
                        </tr>
                                @endforeach
                        
                    @endforeach
                    <tr>
                        
                        <td colspan="2"><h3>Итого</h3></td>
                        <td><h3>{{$l_sum}}</h3></td>
                        <td><h3>{{$p_sum}}</h3></td>
                        <td><h3>{{$s_sum}}</h3></td>
                        <td><h3>{{$w_sum}}</h3></td>
                        <td><h3>{{$w_sum + $s_sum + $p_sum + $l_sum + \App\Program::find($id)->attestation_hours}}</h3>Вместе с аттестацией ({{\App\Program::find($id)->attestation_hours}} ч.)</td>          
                            
                        
                    </tr>
                    </table>

                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

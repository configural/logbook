
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
                    <th>{{ $discipline->active_blocks->sum('l_hours')}}</th>
                    <th>{{ $discipline->active_blocks->sum('p_hours')}}</th>
                    <th>{{ $discipline->active_blocks->sum('s_hours')}}</th>
                    <th>{{ $discipline->active_blocks->sum('w_hours')}}</th>
                    <th><a href="{{$id}}/discipline_unbind/{{$discipline->id}}">Убрать&nbsp;<i class="fa fa-thumbs-down red " aria-hidden="true"></i></a></th></tr>
                     
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
                    
                    </table>

                    
                    <form action="discipline_bind" method="post">
                    <h3>Добавить дисциплину</h3>
                    <p>
                        <input name="program_id" type="hidden" value="{{$id}}">
                        <select name="discipline_id" class="form-control">
                        @foreach(\App\Discipline::select()->where('active', 1)->orderby('name')->get() as $discipline)
                        @if (1)
                        <option value="{{$discipline->id}}">
                            {{$discipline->active}}
                            
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
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

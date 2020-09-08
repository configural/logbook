
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <p>
                Тематический блок - неделимая часть дисциплины. Для каждого блока прописываются часы лекционные, практические, самостоятельная работа.
            </p>
            <div class="panel panel-primary">
                <div class="panel-heading ">Блоки дисциплины</div>

                <div class="panel-body">
                    
                    <p><a href="{{ url('disciplines')}}">Все дисциплины</a></p>
                    <h3>{{$discipline->name}}</h3>
                    Дисциплина присутствует в программах:
                    <ul>
                            <?php $i = 0; ?>
                    @foreach ($discipline->programs as $program)
                    <?php $i++; ?>
                    <li><a href="{{url('/program')}}/{{$program->id}}">{{$program->name}}</a></li>
                    @endforeach
                    @if ($i == 0) 
                    Дисциплина пока нигде не задействована
                    @endif
                     </ul>
                    <p>Изменение состава тематических блоков повлияет на программы, в которых эта дисциплина присутствует. 
                    
                    </p>
                    <p><a href="{{url('block/add')}}/{{$discipline->id}}" class="btn btn-success">Добавить тематический блок</a></p>
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <tr>
                            <td>id</td>
                            <td>Темы в расписании</td>
                            <td>Лекции, ч</td>
                            <td>Практика, ч</td>
                            <td>Самост., ч</td>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discipline->blocks as $block)
                        @if($block->active)
                         <tr>
                            <td>{{$block->id}}</td>
                            <td><a href="{{url('/')}}/block/{{$block->id}}/edit">{{$block->name}}</td>
                            <td>{{$block->l_hours}}</td>
                            <td>{{$block->p_hours}}</td>
                            <td>{{$block->s_hours}}</td>

                         </tr>
                         @endif
                         @endforeach
                            </tbody>
                            <tr class="itogo"><td rowspan="2"></td>
                                <td rowspan="2">ИТОГО</td>
                                <td>{{ $discipline->l_hours_total() }} </td>
                                <td>{{ $discipline->p_hours_total() }} </td>
                                <td>{{ $discipline->s_hours_total() }} </td>
                            </tr>
                            <tr class="itogo">
                                
                                <td colspan="3">{{ $discipline->hours_total() }} </td>
                                
                            </tr>                            
                    </table>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Образовательная программа</div>

                <div class="panel-body">
                    
                    <p><a href="{{ url('programs')}}">Все программы</a></p>
                    <h3>{{ \App\Program::find($id)->name}} </h3>
                    <p>Учебных часов: {{ \App\Program::find($id)->hours}}</p>
                    <p>Форма обучения: {{ \App\Program::find($id)->form->name}}</p>
                    <p>Итоговая аттестация: {{ \App\Program::find($id)->attestation->name}}</p>
                    {{-- <p class="alert alert-success">Чтобы проставить часы вам нужно на базе программы создать учебный план. Впоследствии этот учебный план можно прикреплять к различным преподавателям и группам.</p>
                   <a href="studyplanadd/{{$id}}" class="btn btn-success">Назначить учебный план потоку...</a> --}}
                    <h4>Учебно-тематический план</h4>
                    <table class="table table-bordered">
                        <tr>   
                            <td colspan="2">Дисциплина</th>
                            <td>Лекции, ч</th>
                            <td>Практика, ч</th>
                            <td>Самост., ч</th>
                        </tr>
                        
                    @foreach(\App\Program::find($id)->disciplines as $discipline)
                    <tr>
                    <th colspan="2">{{$discipline->name}}</th>
                    <th>{{ $discipline->blocks->sum('l_hours')}}</th>
                    <th>{{ $discipline->blocks->sum('p_hours')}}</th>
                    <th>{{ $discipline->blocks->sum('s_hours')}}</th></tr>
                        <ul>    
                        @foreach(\App\Block::select()->where('discipline_id', $discipline->id)->get() as $block)
                        <tr>
                            <td></td>
                        <td>{{ $block->name }}</td>
                        <td>{{ $block->l_hours }}</td>
                        <td>{{ $block->p_hours }}</td>
                        <td>{{ $block->s_hours }}</td>
                        
                        
                        </tr>
                                @endforeach
                        
                    @endforeach
                    </table>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

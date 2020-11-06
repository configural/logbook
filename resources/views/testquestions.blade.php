
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Вопросы теста</div>
                <div class="panel-body">
                @if(Auth::user()->role_id == 4)    
                <h3>{{$test->name}}</h3>
                
                <p><a href="addquestion" class="btn btn-success">Добавить вопрос</a>
                
                </p>
                
                @foreach($test->questions as $q)
                <a href="#{{$q->id}}" name='{{ $q->id }}'>#{{ $q->id }}</a> <a href="{{ url('/')}}/question/{{ $q->id }}/edit">Редактировать</a>
                <h4>
                    
                    {!! $q->name !!}</h4>
                <i class="muted">{{ $q->questiontype->name or '' }}</i>
                <ol>
                @if($q->a0) <li>{{ $q->a0}}</li> @endif
                @if($q->a1) <li>{{ $q->a1}}</li> @endif
                @if($q->a2) <li>{{ $q->a2}}</li> @endif
                @if($q->a3) <li>{{ $q->a3}}</li> @endif
                @if($q->a4) <li>{{ $q->a4}}</li> @endif
                @if($q->a5) <li>{{ $q->a5}}</li> @endif
                @if($q->a6) <li>{{ $q->a6}}</li> @endif
                @if($q->a7) <li>{{ $q->a7}}</li> @endif
                @if($q->a8) <li>{{ $q->a8}}</li> @endif
                @if($q->a9) <li>{{ $q->a9}}</li> @endif
                </ol>
                Ключ: {{$q->key}}
                <hr>
                @endforeach
                
                <p><a href="addquestion" class="btn btn-success">Добавить вопрос</a></p>

                    @else
                    К сожалению, у вас нет доступа к этой функции.                   
                    @endif
            </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

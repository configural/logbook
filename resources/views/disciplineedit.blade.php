
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">{{ $discipline->name }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $discipline->id }}" class="form-control" name="id"></p>
                          <p><label>Название дисциплины</label><input type="text" value="{{ $discipline->name }}" class="form-control" name="name"></p>
                           <p><label>Опубликована (1/0)?</label><input type="text" value="{{ $discipline->active }}" class="form-control" name="active"></p>
                           <p><a href="{{ url('/') }}/discipline/{{ $discipline->id }}">Список блоков дисциплины</a></p> 
                          <p><button class="btn btn-success">Обновить</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

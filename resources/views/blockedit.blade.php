
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">{{ $block->name }}</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $block->id }}" class="form-control" name="id"></p>
                          <p><label>Название блока</label><input type="text" value="{{ $block->name }}" class="form-control" name="name"></p>
                          <p><label>Лекции (часов): </label><input type="text" value="{{ $block->l_hours }}" class="form-control" name="l_hours"></p>
                          <p><label>Практика (часов)</label><input type="text" value="{{ $block->p_hours }}" class="form-control" name="p_hours"></p>
                          <p><label>Самост. работа (часов)</label><input type="text" value="{{ $block->s_hours }}" class="form-control" name="s_hours"></p>
                           <p><label>Опубликован (1/0)?</label><input type="text" value="{{ $block->active }}" class="form-control" name="active"></p>
    
                          <p><button class="btn btn-success">Обновить</button>
                     {{ csrf_field() }}

                      </form>
                    
                    <hr/>
                     {{--     
                          <form action="delete" method="post">
                              <label>Удалить блок &laquo;{{ $block->name }} &raquo;</label>
                              <p><input type="checkbox" required> Я действительно хочу удалить этот блок</p>
                              <button class="btn btn-danger">Удалить блок</button>
                    {{ csrf_field() }}

                          </form>
                    --}}
                    @else
                    У вас нед доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

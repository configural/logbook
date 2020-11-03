
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание теста</div>
                <div class="panel-body">
                @if(Auth::user()->role_id == 4)    
                <form method="post">
                          <p><label>Название теста</label><br/><input type="text" value="" class="form-control" name="name" required></p>
                          <p><button class="btn btn-success">Продолжить</button>
                    {{ csrf_field() }}
                      </form>
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

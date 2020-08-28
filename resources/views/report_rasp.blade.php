
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Печать расписания</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    <form method="post">
                        <p><label>Группа</label> 
                        <select name="group_id" class="form-control-static">
                            @foreach(\App\Group::where('active', 1)->get() as $group)
                            <option value="{{ $group->id }}">{{ $group->stream->name }} / {{ $group->name }}</option>
                            @endforeach
                            
                        </select>
 
                            <label>Дата: </label>
                            <input type="date" name="date" class="form-control-static">
                        </p>
                        <button class="btn btn-success">Сформировать</button>
                        {{ csrf_field() }}
                    </form>
 

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

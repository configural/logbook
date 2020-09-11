
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Печать расписания</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="post">
                        <p><label>Группа</label> <br/>
                        <select name="group_id" class="form-control-static">
                            @foreach(\App\Group::where('active', 1)->get() as $group)
                            <option value="{{ $group->id }}">{{ $group->stream->name }} / {{ $group->name }}</option>
                            @endforeach
                            
                        </select>
                        <p>
                            <label>Период: </label><br/>
                            <input type="date" name="date1" class="form-control-static" required>
                            <input type="date" name="date2" class="form-control-static" required>

                        </p>
                        
                        <button class="btn btn-success">Сформировать</button>
                        
                        <a href="{{ route('home')}}" class="btn btn-info">Отмена</a>
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

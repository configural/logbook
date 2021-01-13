
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Печать расписания</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    <form method="post" action="{{route('rasp_xls')}}">
                        <p><label>Группа</label> <br/>
                        <select name="group_id" class="form-control-static">
                            @foreach(\App\Group::select('groups.*')
                            ->join('streams', 'groups.stream_id','=', 'streams.id')
                            ->where('streams.active', 1)
                            ->where('streams.date_start', '<=', $date)
                            ->where('streams.date_finish', '>=', $date)
                            ->get() as $group)
                            @if($group->stream->active)
                            <option value="{{ $group->id }}">{{ $group->name }} :: {{ $group->stream->name }}</option>
                            @endif
                            @endforeach
                            
                        </select>
                        <p>
                            <label>Период: </label><br/>
                            <input type="date" name="date1" class="form-control-static" required>
                            <input type="date" name="date2" class="form-control-static" required>

                        </p>
                        <p>
                            <label>Перерыв на обед:</label><br/>
                            <select name="obed" class="form-control-static">
                                <option value="11.00 – 12.00">11.00 – 12.00</option>
                                <option value="11.10 – 12.10">11.10 – 12.10</option>
                                <option value="11.20 – 12.20">11.20 – 12.20</option>
                                <option value="11.50 – 12.50">11.50 – 12.50</option>
                                <option value="11.50 – 13.20">11.50 – 13.20</option>
                                <option value="12.00 – 13.00">12.00 – 13.00</option>
                                <option value="12.20 – 13.20">12.20 – 13.20</option>
                                <option value="12.50 – 13.50">12.50 – 13.50</option>
                            </select>
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

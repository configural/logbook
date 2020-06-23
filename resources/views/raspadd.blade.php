
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                    <form >
                        Составление расписания <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                    </form>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr><td></td>
                           @foreach(\App\Pair::select()->get() as $pair)
                           <td>{{$pair->name}}</td>
                           @endforeach
                           
                            
                        </tr>
                    @if(Auth::user()->role_id == 4)
                    @foreach(\App\Classroom::select()->get() as $room)
                    <tr><td>{{ $room->name}}</td>
                           @foreach(\App\Pair::select()->get() as $pair)
                        <td><select name='time_interval' class='form-control'>
                        <option value=''></option>
                        <option value='{{$pair->variant0}}'>{{$pair->variant0}}</option>
                        <option value='{{$pair->variant1}}'>{{$pair->variant1}}</option>
                        <option value='{{$pair->variant2}}'>{{$pair->variant2}}</option>
                        <option value='{{$pair->variant3}}'>{{$pair->variant3}}</option>
                            </select>
                            <select name='timetable_id' class="form-control form-control-static">   
                        @foreach(\App\Timetable::select()->whereNotNull('teacher_id')->get() as $timetable)
                        <option  value='{{$timetable->id}}'>{{$timetable->group->name}} - {{$timetable->teacher->name}} - {{$timetable->block->name}}</option>
                        @endforeach
                            </select>
                            <p><button class='btn btn-sm'>Сохранить</button></p>
                        
                        </td> 
                        @endforeach                        
                    
                    
                    </tr>        
                    
                    @endforeach
                    </table>
                    @else
                    Доступ только для администраторов
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

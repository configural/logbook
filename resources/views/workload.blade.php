
@extends('layouts.app')

@section('content')
<div class="container-fluid">





    <div class="row-fluid">
        
        
        <div class="col-md-6">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Нераспределенная нагрузка</div>

                    <div class="panel-body">
                        
                        <div id="allWorkload"></div>
                        <table class="table table-bordered">
                        @foreach(\App\Timetable::select()->where('teacher_id', 0)->get() as $timetable)
                        <tr>
                            <td><small><strong>{{ $timetable->block->discipline->name }}</strong><br/>{{ $timetable->block->name }}<br/>
                            Лекции – {{ $timetable->block->l_hours }} ч, практика – {{ $timetable->block->p_hours }} ч.
                            
                            </td>
                            <td><button class="btn btn-success">Мое!</button></td>
                        </tr>
                        @endforeach
                        </table>
                    </div>

    
            </div>
 
        </div>

        
                <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading ">Моя нагрузка</div>

                <div class="panel-body">
                   
                    <div id="myWorkload"></div>
                    
                        <table class="table table-bordered">
                        @foreach(\App\Timetable::select()->where('teacher_id', Auth::user()->id)->get() as $timetable)
                        <tr>
                            <td><small><strong>{{ $timetable->block->discipline->name }}</strong><br/>{{ $timetable->block->name }}<br/>
                            Лекции – {{ $timetable->block->l_hours }} ч, практика – {{ $timetable->block->p_hours }} ч.
                            
                            </td>
                            <td><button class="btn btn-success">Мое!</button></td>
                        </tr>
                        @endforeach
                        </table>
                    
                    
                    
                </div>

            </div>
        </div>

    </div>

</div>
@endsection


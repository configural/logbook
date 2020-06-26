
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                
                Журнал преподавателя
                </div>

                <div class="panel-body">
                <?php 
                $date = date("Y-m-d");
                $me = Auth::user()->id;
                ?>
                <table class='table table-bordered'>
                    @foreach(\App\Timetable::select()->where('teacher_id', $me)->whereNotNull('rasp_id')->get() as $timetable)
                    <tr><td>{{ $timetable->id }}</td>
                        @foreach(\App\Rasp::select()->where('timetable_id', $timetable->id)->get() as $rasp)
                        <td>{{$rasp->id}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </table>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


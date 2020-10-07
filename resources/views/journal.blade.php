
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    
                      
                                
                Журнал преподавателя
                <form action='' method='get'>
                    
                    <input name='date' type='date' value='{{$date}}' onchange="javascript:form.submit()" class="form-control-static" style="color: black;">
                    
                </form>
                </div>

                <div class="panel-body">
                    <p><a href="{{ route('home')}}">В начало</a></p>
                    
                <?php 

                $me = Auth::user()->id;
                ?>
                    <h3>Занятия на {{$date}}</h3>
                <table class='table table-bordered'>
                    <tr>
                        <th>Время</th>
                        <th>Группа</th>
                        <th>Тема занятия</th>
                        <th>Тип занятия</th>
                        <th>Операции</th>
                        <th>Состояние журнала</th>
                    </tr>
                @foreach(\App\Rasp::select()->where('date', $date)->get() as $rasp)
                @foreach($rasp->timetable->teachers as $teacher)
                    @if($teacher->id == $me)
                    <tr>
                        <td  class="largetext">{{ substr($rasp->start_at, 0, 5)}}</td>
                        <td  class="largetext"><nobr>{{$rasp->timetable->group->name or ''}}</nobr>
                        @if ($rasp->timetable->subgroup or '')
                        <br/><nobr>{{$rasp->timetable->subgroup or ''}}</nobr>
                        @endif
                    </td>
                    
                    <td class="largetext" width="50%">{{$rasp->timetable->block->name or ''}}</td>
                    <td class="largetext">{{$rasp->timetable->hours or ''}} ч., {{$rasp->timetable->lesson_type->name or ''}}</td>
                    <td class="largetext"><a href='journal/item/{{$rasp->id}}' class="btn btn-primary">Открыть журнал</a></td>
                    <td class="largetext">
                        @if (\App\Journal::state($rasp->id))
                        <i class='fa fa-check-circle green fa'></i>
                        @endif
   
                    </td>
                </tr>
                    @endif
                @endforeach
                @endforeach
                </table>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


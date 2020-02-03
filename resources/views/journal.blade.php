
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <form action="{{url('journal')}}/update" method="post">
<input type="text" name="timetable_id" value="{{$timetable->id}}">  
@if ($journal) 
<input type="text" name="id" value="{{$journal->id}}"> 
@endif
    <div class="row-fluid">
        
        
        <div class="col-md-6">

    
            <div class="panel panel-primary">

                <div class="panel-heading ">Посещаемость и оценки</div>

                    <div class="panel-body">


                    <table class="table table-bordered">
                    @foreach($students as $student)
                    <tr>
                        <td>{{$student->name}}</td>
                        <td>
                            <select name="attendance[{{$student->id}}]">
                                <option @if($journal->attendance[$student->id] == 1) selected @endif value="1">Присутствует</option>
                                <option @if($journal->attendance[$student->id] == 0) selected @endif value="0">Отсутствует</option>
                                <option @if($journal->attendance[$student->id] == 5) selected @endif value="5">Отлично</option>
                                <option @if($journal->attendance[$student->id] == 4) selected @endif value="4">Хорошо</option>
                                <option @if($journal->attendance[$student->id] == 3) selected @endif value="3">Удовл</option>
                                <option @if($journal->attendance[$student->id] == 2) selected @endif  value="2">Неудовл</option>
                                
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    </table>
                    

                </div>

    
            </div>
 
        </div>

        
                <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading ">Внести запись в журнал</div>

                <div class="panel-body">
                    <p><strong>Дата и время занятия:</strong> {{$timetable->start_at}}</p>
                    <p><strong>Дисциплина:</strong> {{ $block->discipline->name }}</p>
                    <p><strong>Тема занятия:</strong> {{$block->name}}</p>
                    <p>По учебно-тематическому плану предусмотрено:</p>
                    <ul>
                        <li>Лекции: {{$block->l_hours}} ч. </li>
                        <li>Практика: {{$block->p_hours}} ч.</li>
                    </ul>
     
                    
                    
                    
                    <p>Какой вид занятия вы провели?<br/>
                    <select class="form-control" name="lesson_type" required>
                                <option value="">выберите</option>        
                                <option value="0" @if ($journal->l_hours) selected @endif>Лекция</option>
                                <option value="1" @if ($journal->p_hours) selected @endif>Практика</option>
                    </select></p>
                    <p>Сколько академических часов?<br/>
                        @if ($journal->l_hours) <input class="form-control" type="number" name="hours" value = "{{ $journal->l_hours }}"  required>
                        @elseif($journal->p_hours) <input class="form-control" type="number" name="hours" value = "{{ $journal->p_hours }}"  required>
                        @else <input class="form-control" type="number" name="hours" required>@endif
                    </p>
                    
                    
                </div>

            </div>
        </div>

    </div>
{{ csrf_field() }}
<center><button class="btn btn-success">Сохранить</button></center>
</form>  
</div>
@endsection


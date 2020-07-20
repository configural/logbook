
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                                
                Журнал преподавателя. Запись {{$id}}   
             
                </div>
                
                
                <div class="panel-body">
                    <p>Тема занятия:  {{$block or 'не определена'}}</p>
                    <p>Вид занятия:  {{$lessontype or 'не определен'}}</p>
                    <p>Количество часов:  {{$hours or 'не определено'}}</p>
                    <form name='attendance' action='update' method='post'>
                        <input type='hidden' name='id' value='{{$id}}'>
                    <table class='table table-bordered'>
                        <thead>
                        <th>id</th>
                        <th>ФИО</th>
                        <th>Посещаемость/Оценка</th>
                        </thead>
                        <tbody>
                    
                    @foreach(\App\Student::select()->where('group_id', $group_id)->get() as $student)
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{$student->secname or 'нет данных'}}</td>
                        <td>
                            @if($attendance[$student->id] == 1 or $attendance === false)
                            <input type='radio' name='attendance[{{$student->id}}]' value='1' checked> присутствует&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='attendance[{{$student->id}}]' value='0'> отсутствует  
                            @else
                            <input type='radio' name='attendance[{{$student->id}}]' value='1'> присутствует&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='attendance[{{$student->id}}]' value='0' checked> отсутствует
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                    </table>
  {{ csrf_field() }}
                        <button class='btn btn-success'>Сохранить запись журнала</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                                
                Журнал преподавателя   
             
                </div>
                
                
                <div class="panel-body">
                    <p>Тема занятия:  <u>{{$block or 'не определена'}}</u></p>
                    <p>Подгруппа: <u>{{ $subgroup or 'не определена' }}</u></p>
                    <p>Вид занятия:  <u>{{$lessontype or 'не определен'}}</u></p>
                    <p>Количество часов:  <u>{{$hours or 'не определено'}}</u></p>
                    <form name='attendance' action='update' method='post'>
                        <input type='hidden' name='id' value='{{$id}}'>
                    <table class='table table-bordered' id="sortTable">
                        <thead>
                        <th>id</th>
                        <th>ФИО</th>
                        <th>Посещаемость/Оценка</th>
                        </thead>
                        <tbody>
                    
                    @foreach(\App\Student::select()->where('group_id', $group_id)->orderBy('secname')->get() as $student)
                    
                    @if (($subgroup == 1 and $student->id % 2) || ($subgroup == 2 and !($student->id % 2)) || ($subgroup == 0))
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{$student->secname or 'нет данных'}} {{$student->name or 'нет данных'}} {{$student->fathername or 'нет данных'}}</td>
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
                    @endif
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


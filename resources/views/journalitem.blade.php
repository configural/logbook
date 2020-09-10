
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
                        
                        <p><button class='btn btn-large btn-success'>Сохранить запись журнала</button></p>
                        <marquee style="width: 210px;">Обязательно нажмите эту кнопку после заполнения журнала!</marquee>
                        
                    <table class='table table-bordered'>
                        <thead>
                        <th>id</th>
                        <th>ФИО</th>
                        
                        <th>Посещаемость/Оценка</th>
                        </thead>
                        <tbody>
                    
                    @foreach(\App\Student::select()->where('group_id', $group_id)->orderBy('secname')->get() as $student)
                    
                    @if ($subgroup == 0 || $subgroup == $student->subgroup)
                    <tr>
                        <td>{{$student->id}}</td>
                        
                        <td width="50%">{{$student->secname or ''}} {{$student->name or ''}} {{$student->fathername or ''}}</td>
                        <!--<td>{{ $student->subgroup }}</td>-->
                        <td>
                            @if(!array_key_exists("$student->id", $attendance) or $attendance[$student->id]==0)
                            <input type='radio' name='attendance[{{$student->id}}]' value='1'> присутствует&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='attendance[{{$student->id}}]' value='0' checked > отсутствует  
                            @else
                            <input type='radio' name='attendance[{{$student->id}}]' value='1' checked> присутствует&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='attendance[{{$student->id}}]' value='0'> отсутствует
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
                    </table>
            {{ csrf_field() }}
            <p><marquee style="width: 210px;">Обязательно нажмите эту кнопку после заполнения журнала!</marquee></p>
            <p><button class='btn btn-success'>Сохранить запись журнала</button></p>
            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


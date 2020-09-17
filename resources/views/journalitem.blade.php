
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
                    <div class="lead"><p>Тема занятия:  <u>{{$block or 'не определена'}}</u></p>
                    <p>Подгруппа: <u>{{ $subgroup or 'не определена' }}</u></p>
                    <p>Вид занятия:  <u>{{$lessontype or 'не определен'}}</u></p>
                    <p>Количество часов:  <u>{{$hours or 'не определено'}}</u></p>
                    </div>
                    <form name='attendance' action='update' method='post'>
                        <input type='hidden' name='id' value='{{$id}}'>
                        
                        <p><button class='btn btn-lg btn-success'>Сохранить запись журнала</button>
                            <a href="{{route('journal')}}" class="btn btn-info">Выйти без сохранения</a>
                        </p>
                        <marquee style="width: 260px;">Обязательно нажмите эту кнопку после заполнения журнала!</marquee>
                        
                    <table class='table table-bordered'>
                        <thead>
                        <th width="10%">№</th>
                        <th width="70%">ФИО</th>
                        
                        <th width="10%"><a href="#" id="check_all" class="btn btn-success">Все на месте</a></th>
                        <th width="10%"><a href="#" id="check_none" class="btn btn-danger">Нет никого</a></th>
                        </thead>
                        <tbody>
                    @php
                    $i = 0
                    @endphp
                    
                    @foreach(\App\Student::select()->where('group_id', $group_id)->orderBy('secname')->get() as $student)
                    
                    @if ($subgroup == 0 || $subgroup == $student->subgroup)
                    <tr>
                        @php
                        $i ++;
                        @endphp
                        <td>{{$i}}</td>
                        
                        <td class="largetext" width="50%">{{$student->secname or ''}} {{$student->name or ''}} {{$student->fathername or ''}}</td>
                        <!--<td>{{ $student->subgroup }}</td>-->
                        
                            @if(!array_key_exists("$student->id", $attendance) or $attendance[$student->id]==0)
                            <td class="largetext"><input type='radio' name='attendance[{{$student->id}}]' value='1' id="present[{{$student->id}}]"> <label for="present[{{$student->id}}]" class="green">есть</label></td>
                            <td class="largetext"><input type='radio' name='attendance[{{$student->id}}]' value='0' id="absent[{{$student->id}}]" checked >  <label for="absent[{{$student->id}}]"  class="red">нет</label></td>  
                            @else
                            <td class="largetext"><input type='radio' name='attendance[{{$student->id}}]' value='1' id="present[{{$student->id}}]" checked> <label for="present[{{$student->id}}]" class="green" >есть</label>&nbsp;&nbsp;&nbsp;</td>
                            <td class="largetext"><input type='radio' name='attendance[{{$student->id}}]' value='0' id="absent[{{$student->id}}]"> <label for="absent[{{$student->id}}]"  class="red">нет</label></td>
                            @endif
                        
                    </tr>
                    @endif
                @endforeach
                </tbody>
                    </table>
            {{ csrf_field() }}
            <p><marquee style="width: 260px;">Обязательно нажмите эту кнопку после заполнения журнала!</marquee></p>
            <p><button class='btn btn-success btn-lg'>Сохранить запись журнала</button></p>
            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
 $("#check_all").click(function(){
     $('input[type="radio"][value="1"]').prop('checked', true);
    });
    
$("#check_none").click(function(){
     $('input[type="radio"][value="0"]').prop('checked', true);
    });    
</script>
@endsection


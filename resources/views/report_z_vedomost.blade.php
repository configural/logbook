
@php
if (isset($_GET["group_id"]))
    {$group_id = $_GET["group_id"];}
    else 
    {$group_id = 0;}

$disc_count = 0;
    
@endphp



@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">

                
                <div class="panel-body">
                <form method='get'>
                    <p>
                        <label>Выберите группу</label>
                    <select id='groupSelect' name='group_id' class='form-control-static' onChange="form.submit()">
                        <option value=''>выбрать</option>
                        @foreach(\App\Group::selectRaw('groups.id as id, groups.name as groupname, streams.name as streamname, streams.date_start,  streams.date_finish, 
                        programs.name as pname, programs.id as pid')
                        ->join('streams', 'streams.id', '=', 'groups.stream_id')
                        ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                        ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                        ->where('streams.active', 1)
                        ->where('streams.date_finish', '>=', date('Y-m-d'))
                        ->orderby('streams.date_start')
                        ->orderby('programs.name')
                        ->orderby('groups.id')
                        ->get()
                        as $group)
                        @if ($group_id == $group->id)
                            <option value="{{ $group->id}}" selected>{{ \Logbook::month($group->date_start, 1)}} :: {{ str_limit($group->pname, 40) }} :: {{ $group->streamname}} :: Группа {{ $group->groupname}}</option>
                        @else
                            <option value="{{ $group->id}}">{{ \Logbook::month($group->date_start, 1)}} :: {{ str_limit($group->pname, 40) }} :: {{ $group->streamname}} :: Группа {{ $group->groupname}}</option>
                        @endif
                        
                        @endforeach
                    </select>
                    <p>Щелкайте по ячейкам, чтобы вкл/выкл отметку "зачтено". Для печати нажмите Ctrl+P.</p>
                </form>

                        
                    @if ($group_id)
                    
                    <center><small>
                        <p>Федеральное государственное бюджетное учреждение дополнительного профессионального образования<br/>
                            «Приволжский институт повышения квалификации Федеральной налоговой службы»,<br/>г. Нижний Новгород</p>
                        
                        <p>ЗАЧЕТНАЯ ВЕДОМОСТЬ<br>промежуточной аттестации по дисциплинам</p>
                        <p>
                            Наименование программы: «{{$group->pname}}», группа {{$group->groupname}}.<br>
                            Период обучения: {{\Logbook::normal_date($group->date_start)}} – {{\Logbook::normal_date($group->date_finish)}}
                            
                        </p>
                        <table class="table-bordered">
                            <thead>
                                <tr>
                                    <td rowspan='2' width='40%'>ФИО слушателей</td>
                                    <td colspan='100'>Наименование разделов и дисциплин</td>
                                </tr>
                                <tr>
                            @foreach(\App\Program::where('id', $group->pid)->get() as $program)
                                @foreach($program->disciplines as $discipline)
                            <td>{{$discipline->name}}</td>
                            @php($disc_count++)
                                @endforeach
                            @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                
                                @foreach(\App\Student::where('group_id', $group_id)->orderby('secname')->get() as $student)
                                <tr>    
                                <td>{{$student->secname}} {{$student->name}} {{$student->fathername}}</td>
                                @for($i = 0; $i < $disc_count; $i++)
                                <td class="zachet"><span class="cell">зачтено</span></td>
                                @endfor
                                </tr>
                                @endforeach

                                
                                
                            </tbody>
                        </table>
                        
                        </small>
                    </center>
                    @endif
                        
                    </p>
                    <p>Подпись заведующего кафедрой</p><p> _____________ / ___________________ </p>


                   
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
$(".zachet").click(function() {
    $(this).find(".cell").toggle()
});    
</script>


@endsection

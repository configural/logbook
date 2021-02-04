
@php
if (isset($_GET["group_id"]))
    {$group_id = $_GET["group_id"];}
    else 
    {$group_id = 0;}

@endphp



@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Расписание группы</div>
                
                <div class="panel-body">
                <form action="{{ url('/')}}/reports/rasp" method='get'>
                    <p>
                        <label>Выберите группу</label>
                    <select id='groupSelect' name='group_id' class='form-control-static'>
                        <option value=''>выбрать</option>
                        @foreach(\App\Group::selectRaw('groups.id as id, groups.name as groupname, streams.name as streamname, streams.date_start, programs.name as pname')
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
                        <option value="{{ $group->id}}">{{ @substr(\Logbook::normal_date($group->date_start), 3, 2)}} :: {{ str_pad(str_limit($group->pname, 40), 40, ".", STR_PAD_RIGHT)}} :: {{ $group->streamname}} :: Группа {{ $group->groupname}}</option>
                        @endforeach
                    </select>
                        
                        
                        
                    </p>
                    <p><button class='btn btn-primary'>Печать расписания</button></p>

                    <div id='operations'></div>   
                </form>    
                    <div id='workloadList'></div>
                   
                    <p><a href="javascript:history.back()">Вернуться</a></p>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Назначить занятие</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        
      </div>
    </div>
  </div>
</div>

<script>


$(document).ready(function(){
    
    $('#groupSelect').on('change', function() {
    var group_id = $(this).val();
    var url = "{{ url('/') }}/ajax/rasp_group"
 
     $.ajax({
        url: url, 
        method: 'get',
        data: { 'group_id' : group_id },
        success: function(param) { $('#workloadList').html(param);  }
        
    });
    
    
    });
    
    $(document).on('click', '.btnChange', function() {
        var timetable_id = $(this).data('timetable_id');
        $(".modal-body").load('{{ url("/rasp_modal/")}}/' + timetable_id);        
    });
  
    
});
</script>

@endsection

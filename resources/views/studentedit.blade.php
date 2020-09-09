
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактирование студента</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $student->id }}" class="form-control" name="id"></p>
                          <p><label>Фамилия</label>
                              <input type="text" value="{{ $student->secname }}" class="form-control" name="secname"></p>
                          
                          <p><label>Имя</label>
                              <input type="text" value="{{ $student->name }}" class="form-control" name="name"></p>
                          
                          <p><label>Отчество</label>
                              <input type="text" value="{{ $student->fathername }}" class="form-control" name="fathername"></p>
                          
                          <p><label>Группа</label>
                              <select name="group_id" class="form-control">
                                  @foreach(\App\Group::select()->get() as $group)
                                  @if ($student->group_id == $group->id)
                                  <option value='{{$group->id}}' selected>{{$group->name}} ({{$group->stream->name}} {{$group->stream->year}})</option> 
                                  @else
                                  <option value='{{$group->id}}'>{{$group->name}} ({{$group->stream->name}} {{$group->stream->year}})</option>
                                  @endif
                                  @endforeach
                              
                              </select>
                          
                          </p>
                          
                          <p><label>Подгруппа</label>
                              <input type="text" value="{{ $student->subgroup }}" class="form-control" name="subgroup"></p>                         
                          
                          <p><label>Код СОНО</label>
                              <input type="text" value="{{ $student->sono }}" class="form-control" name="sono"></p>
                          
                          <p><label>Регион</label>
                          <select id="taxoffice_id" name="taxoffice_id" class='form-control-static'>
                          @foreach(\App\Taxoffice::orderby('name')->get() as $taxoffice)
                          @if ($student->division_id && $taxoffice->id === $student->division->taxoffice->id)  
                          <option value="{{$taxoffice->id or '0'}}" selected>{{ $taxoffice->name or '' }}</option>
                          @else
                          <option value="{{$taxoffice->id or '0'}}">{{ $taxoffice->name or '' }}</option>
                          @endif
                          @endforeach
                          </select>
                          
                          <p><label>Инспекция</label>
                          <select id="division_id" name="division_id" class='form-control-static'>
                                <option value="0" data-taxoffice="0"></option>
                              
                          @foreach(\App\Division::orderby('name')->get() as $division)
                            @if($student->division_id == $division->id)
                                <option value="{{$division->id}}" data-taxoffice="{{$division->taxoffice_id}}" selected>{{ $division->name }}</option>
                            @else
                                <option value="{{$division->id}}" data-taxoffice="{{$division->taxoffice_id}}">{{ $division->name }}</option>
                            @endif
                          @endforeach
                          </select>
                          
                          <p><label>Квалификация</label>
                              <input type="text" value="{{ $student->qualification }}" class="form-control" name="qualification"></p>
                          <p>
                              <label>Уровень образования</label>
                              <input type="text" value="{{ $student->edu_level }}" class="form-control" name="edu_level"></p>
                          <p>
                              <label>Серия документа об образовании</label>
                              <input type="text" value="{{ $student->doc_seria }}" class="form-control" name="doc_seria"></p>
                          <p>Фамилия в диплом</label>
                              <input type="text" value="{{ $student->doc_secname }}" class="form-control" name="doc_secname"></p>
                          
                          <p><label>Статус</label>
                              <input type="text" value="{{ $student->status }}" class="form-control" name="status"></p>
                          
                          <p><button class="btn btn-success">Обновить</button>
                              
                          
                          <hr>
                          <p>
                          <a href="{{url('/')}}/student/{{ $student->id}}/delete" onclick="return confirm('Действительно удалить?')" class="btn btn-danger"><i class="fa fa-times-circle white"></i> Удалить студента</a>
                          <p>
                    {{ csrf_field() }}
                      </form>
                    @else
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$("#taxoffice_id").change(function(){
    var taxoffice_id = $("#taxoffice_id option:selected").val();
   

$("#division_id option").hide();
$("#division_id option").each(function(){
        var taxoffice = $(this).data("taxoffice");
        if(taxoffice == taxoffice_id){
          $(this).show();
        }
    });
//$("#division_id option").hide();
$("#division_id :first").prop('selected', 'true');


});
</script>
@endsection

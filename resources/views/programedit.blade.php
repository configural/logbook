
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Редактирование Образовательной программы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="store" method="post">
                          
                          <p><label>Название</label>
                              <textarea class="form-control" name="name" required>{{ \App\Program::find($id)->name }}</textarea></p>
                          <p><label>Планируемое количество часов</label>
                              <input type="number" value="{{ \App\Program::find($id)->hours }}" class="form-control" name="hours" required></p>
                          <p><label>Форма обучения</label>
                              <select name="form_id" class="form-control">
                                  @foreach(\App\Form::select()->get() as $form)
                                  @if (\App\Program::find($id)->form_id == $form->id) <option value='{{$form->id}}' selected>{{$form->name}}</option> 
                                  @else   <option value='{{$form->id}}' >{{$form->name}}</option>                                          
                                  @endif
                                  @endforeach
                              </select>

                          <p><label>Итоговая аттестация</label>
                              <select name="attestation_id" class="form-control">
                                  @foreach(\App\Attestation::select()->get() as $attestation)
                                  @if (\App\Program::find($id)->attestation_id === $attestation->id) <option value='{{$attestation->id}}' selected>{{$attestation->name}}</option>
                                  @else <option value='{{$attestation->id}}'>{{$attestation->name}}</option>
                                  @endif
                                  @endforeach
                              </select>
                              
                         <p><label>Часов на аттестацию</label><input type="number" value="{{ \App\Program::find($id)->attestation_hours }}" class="form-control" name="attestation_hours"></p>
                         <p><label>Часов на защиту ВКР (Проставляется только для программ длительностью от 72 часов. В противном случае - оставляем "0").</label><input type="number" value="{{ \App\Program::find($id)->vkr_hours }}" class="form-control" name="vkr_hours"></p>

                          </p>
                          <p><label>Краткое описание</label><input type="text" value="{{\App\Program::find($id)->description}}" class="form-control" name="description"></p>
                          <p><label>Опубликована (1/0)?</label>
                              <input type="text" value="{{\App\Program::find($id)->active}}" class="form-control" name="active" required>
                          </p>
                          
                          <p><button class="btn btn-success">Обновить образовательную программу</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

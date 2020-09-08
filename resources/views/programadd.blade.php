
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание Образовательной программы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <form action="add" method="post">
                          
                          <p><label>Название</label><input type="text" value="" class="form-control" name="name" required></p>
                          <p><label>Планируемое количество часов</label><input type="number" value="" class="form-control" name="hours"></p>
                          <p><label>Форма обучения</label>
                              <select name="form_id" class="form-control">
                                  @foreach(\App\Form::select()->get() as $form)
                                  <option value='{{$form->id}}'>{{$form->name}}</option>
                                  @endforeach
                              </select>

                          <p><label>Итоговая аттестация</label>
                              <select name="attestation_id" class="form-control">
                                  @foreach(\App\Attestation::select()->get() as $attestation)
                                  <option value='{{$attestation->id}}'>{{$attestation->name}}</option>
                                  @endforeach
                              </select>
                              
                          <p><label>Часов на аттестацию</label><input type="number" value="" class="form-control" name="attestation_hours"></p>
                          
                          <p><label>Часов на защиту ВКР (Проставляется только для программ длительностью от 72 часов. В противном случае - оставляем "0").</label><input type="number" value="" class="form-control" name="vkr_hours"></p>
                          
                          </p>
                          <p><label>Краткое описание</label><input type="text" value="" class="form-control" name="description"></p>
                          <p><label>Опубликована (1/0)?</label>
                              <input type="text" value="" class="form-control" name="active" required>
                          </p>
                          
                          <p><button class="btn btn-success">Создать образовательную программу</button>
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

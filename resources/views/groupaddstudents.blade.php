
@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание группы</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    
                    <form action="{{url('/')}}/group/addstudents" method="post">
                        <h3>Группа: <a href="{{url('/')}}/group/{{$id}}/edit">{{ \App\Group::find($id)->name}}</a> </h3>
                        <p><input type="hidden" name="group_id" value="{{$id}}"></p>
                        <p>
                            
                            @if(isset($message)) 
                                {!!$message!!}
                            @endif
                        </p>
                        
                        
                        <p>
                                <label>Разделитель полей</label><select name="divider" class="form-control">
                                <option value="\t">табуляция или пробел (копирование из excel)</option>
                                <option value=";">точка с запятой (копирование из блокнота csv)</option>
                            </select>
                        </p>
                        
                        <p>   
                            <label>Список студентов (по одному в строке)</label>
                        
<textarea name="import" class="form-control" placeholder="5210;Иванов;Иван;Иванович"  style="height: 400px;" required>
@if (isset($problems))
@foreach($problems as $p)
{{ $p[0] }} {{ $p[1] }} {{ $p[2] }} {{ $p[3] }}
@endforeach
@endif</textarea>
                        </p>  
                          <p><button class="btn btn-success">Загрузить список</button>
                    {{ csrf_field() }}
                      </form>
                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>

@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Новая аудитория</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id == 4)  
                    
                    <form method="post">
                        <p><label>Наименование:</label>
                            <input type="text" value="" name="name" class="form-control" required=""></p>
                        
                        <p><label>Расположение:</label>
                            <input type="text" value="" name="address" class="form-control" required=""></p>
                        
                        <p><label>Количество мест:</label>
                            <input type="number" value="20" name="capacity" class="form-control" required=""></p>

                        <p><label>Дополнительно:</label>
                            <input type="text" value="" name="description" class="form-control"></p>
                        
                        {{ csrf_field() }}
                        
                        <p><button class="btn btn-success">Сохранить</button></p>
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

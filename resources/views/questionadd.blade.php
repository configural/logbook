
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Тесты</div>

                <div class="panel-body">
                    <p>
                    <form method="post">
                        <input type="hidden" name ="test_id" value="{{ $test_id }}">
                        <div class="row-fluid">
                            <div class="col-lg-12">
                               <p>Текст вопроса:
                                <textarea name="name" class="form-control" required></textarea>
                               </p>
                            
                                <p><label>Тип вопроса:</label>
                                    <select name="questiontype_id" class="form-control-static">
                                        @foreach(\App\QuestionType::get() as $qt)
                                        <option value='{{ $qt->id }}'>{{ $qt->name }}</option>
                                        @endforeach
                                        
                                        
                                    </select>
                                </p>
                            </div>
                            
                            
                            <p>
                            <div class="col-lg-6">
                                0.<br/>
                                <textarea name="a0" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                5.<br/>
                                <textarea name="a5" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                1.<br/>
                                <textarea name="a1" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                6.<br/>
                                <textarea name="a6" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                2.<br/>
                                <textarea name="a2" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                7.<br/>
                                <textarea name="a7" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                3.<br/>
                                <textarea name="a3" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                8.<br/>
                                <textarea name="a8" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                4.<br/>
                                <textarea name="a4" class="form-control"></textarea>
                            </div>
                            
 <div class="col-lg-6">
                                9.<br/>
                                <textarea name="a9" class="form-control"></textarea>
                            </div>
                            
                            <div class="col-lg-6">
                                <p>
                                <hr>
                                <p>
                                    <label>
                                        Ключ правильного ответа:
                                    </label>
                                    <input type='text' name='key' class='form-control' required>
                                </p>
                                    <button class="btn btn-success">Сохранить вопрос</button>
                                </p>
                            </div>                          

                        </div>
                    </p>
                        
                       
                    {{ csrf_field() }}
                    </p>

                   
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

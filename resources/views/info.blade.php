
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Информация</div>

                <div class="panel-body">
                    <strong><p>{!! $html !!}</p></strong>
                   
                    <p><a href="javascript:history.back()">Вернуться</a></p>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Панель управления</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role_id == 4) 
                    @include('home.admin')
                        
                    @elseif (Auth::user()->role_id == 3)
                    @include('home.metodist')
                   
                    @elseif (Auth::user()->role_id == 2 )
                    @include('home.teacher')
                    
                    @elseif (Auth::user()->role_id == 1)
                    <strong>Приветствую тебя, Слушатель!</strong>
                    
                    @elseif (Auth::user()->role_id == 5)
                    @include('home.director')

                
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

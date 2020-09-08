
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                                    <form >
                        Создать нагрузку
                    </form>
                </div>

                <div class="panel-body">

                    <form action=''>
                        Пока в разработке :)
                   
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

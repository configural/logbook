
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                                    <form >
                        Создать нагрузку вручную
                    </form>
                </div>

                <div class="panel-body">
                    
                    <form method="post">
                        <label>Группа: </label>
                        <select name="group_id" class="form-control-static">
                            @foreach(\App\Group::where('active', 1)->orderBy('name')->get() as $group)
                            <option value='{{ $group->id }}'>{{ $group->name }} (поток {{ $group->stream->name }})</option>
                            @endforeach
                        </select>
                        
                   
                    {{ csrf_field() }}
                    </form>

                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

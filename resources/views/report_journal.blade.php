
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журналы преподавателей</div>

                <div class="panel-body">
                    @if(Auth::user()->role_id >= 3)  
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>ФИО</th>
                                <th>Записей в журнале</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach(\App\User::orderBy('name')->whereIn('role_id', [2, 5])->get() as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td><a href='{{url('reports')}}/journal/{{$user->id}}'>{{$user->name}}</a></td>
                                <td>{{$user->journal->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    К сожалению, у вас нет доступа к этой функции
                    @endif
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

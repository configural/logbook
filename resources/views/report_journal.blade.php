@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Журналы преподавателей</div>

                <div class="panel-body">
                    <p><a href="{{ route('home')}}">В начало</a></p>
                    
                    @if(Auth::user()->role_id >= 3)  
                    
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>ФИО</th>
                                <th>Кафедра</th>
                                <th>Записей в журнале ({{date('Y')}})</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @php
                            $i = 0
                            @endphp
                            @foreach(\App\User::orderBy('name')->whereIn('role_id', [2])->where('department_id', '<>', 1)->get() as $user)
                                @php 
                                $i++;
                                @endphp
                            <tr>
                                <td>{{$i}}

                                </td>
                                <td><a href='{{url('reports')}}/journal/{{$user->id}}'>{{$user->name}}</a>
                                
                                                                @if ($user->freelance)
                                 (внештатный)
                                @endif
                                </td>
                                <td>{{$user->department->name}}</td>
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

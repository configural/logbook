
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Они не заполнили журнал!</div>

                <div class="panel-body">
                    
                    <p><a href="{{ route('home') }}">В начало</a></p>
                 
                    <table class="table table-bordered" id="sortTable">
                        <thead>
                        <th width="10%">Дата</th>
                        <th width="30%">Преподаватель</th>
                        <th width="10%">Группа</th>
                        <th width="50%">Занятие</th>
                        
                        </thead>
                        <tbody>
                        
                        @foreach($journal as $j)
                            
                        <tr>
                            <td>{{ $j->date }}</td>
                            <td>{{ \App\User::find($j->id)->name }}</td>
                            <td>{{ \App\Group::find($j->group_id)->name }}</td>
                            <td>{{ @str_limit( \App\Block::find($j->block_id)->name , 60) }}</td>
                            
                            
                        </tr>
                        @endforeach
                    
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

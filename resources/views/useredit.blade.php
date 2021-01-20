
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">{{ $user->name }}</div>

                <div class="panel-body">
                      <form action="store" method="post">
                          <p><input type="hidden" value="{{ $user->id }}" class="form-control" name="id"></p>
                          <p><label>ФИО</label><input type="text" value="{{ $user->name }}" class="form-control" name="name" required></p>
                          <p><label>Логин (email)</label><input type="email" value="{{ $user->email }}" class="form-control" name="email" required></p>

                          <p><label>Подразделение</label>
                              <select name="department_id" class="form-control">
                              @foreach(\App\Department::select()->get() as $department)
                              @if ($department->id == $user->department_id) <option value="{{$department->id}}" selected>{{$department->name}}</option>
                              @else <option value="{{$department->id}}">{{$department->name}}</option>
                              @endif
                              @endforeach
                              </select>
                          </p>
                          
                          <p><label>Роль пользователя</label>
                              <select name="role_id" class="form-control">
                              @foreach(\App\Role::select()->get() as $role)
                              @if ($role->id == $user->role_id) <option value="{{$role->id}}" selected>{{$role->name}}</option>
                              @else <option value="{{$role->id}}">{{$role->name}}</option>
                              @endif
                              @endforeach
                              </select>
                          </p>
                          <p><label>Табельный номер (только для штатных)</label>
                              <input name="table_number" type="number" value="{{$user->table_number}}" class="form-control-static">
                          </p>
                          
                          <p><label>Внештатный?</label><input type="number" value="{{$user->freelance}}" class="form-control" name="freelance" required>
                              <br/>Если преподаватель внештатный, поставьте 1, в остальных случаях 0.</p>
                          
                          
                          @if ($user->freelance)
                          
                          <h4>Договоры (только для внештатных)</h4>
                          <table class="table table-bordered" id="sortTable">
                              <thead>
                              <th>id</th>
                              <th>Номер договора</th>
                              <th>Дата заключения</th>
                              <th>Дата начала</th>
                              <th>Дата окончания</th>
                              <th>Стоимость часа</th>
                              
                              </thead>    
                              <tbody>
                          @foreach(\App\User::find($user->id)->contracts as $contract)
                          <tr>
                              <td>id</td>
                              <td><a href="{{url('/user/')}}/editcontract/{{$contract->id}}">{{ $contract->name or 'без имени'}}</a></td>
                              <td>{{ $contract->date }}</td>
                              <td>{{ $contract->start_at }}</td>
                              <td>{{ $contract->finish_at }}</td>
                              <td>{{ $contract->price }}</td>
                              
                          </tr>
                          @endforeach
                              </tbody>
                          </table>
                          <a href="addcontract" class="btn btn-primary">Добавить договор</a>
                          <hr/>
                          
                          @endif
                          
                          <p><button class="btn btn-success">Обновить</button>
                              </div>
                    {{ csrf_field() }}
                      </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection

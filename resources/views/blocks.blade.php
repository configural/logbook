
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Темы в расписании</div>

                <div class="panel-body">
                    <table class='table table-bordered' id='sortTable'>
                        <thead>
                        <th>id</th>
                        <th>Темы</th>
                        <th>Тип</th>
                        <th>Кафедры</th>
                        <th>Дисциплины</th>
                        
                        <th>Программы</th>
                        </thead>
                        <tbody>
                   @foreach(\App\Block::where('active', 1)->get() as $b)
                           <tr><td>
                                   <a name="{{$b->id}}">{{$b->id}}</a>
                       </td>
                       <td class="block">
                           <div class="name"><span class="linkOnPage">{{$b->name}}</span></div>
                           <div class="form" style="display: none">
                                <form method="post">
                                    <textarea name="name"  class="form-control"style="width: 100%; height: 200px;">{{ $b->name }}</textarea>
                                   <input type="hidden" name="id" value="{{$b->id}}">
                              
                              <p><label>Кафедра:</label>
                              <select name="department_id" class="form-control-static">
                                  <option value="">Наследуется от дисциплины</option>
                                  @foreach(\App\Department::get() as $department)
                                  @if ($department->id == $b->department_id)
                                  <option value="{{$department->id}}" selected>{{$department->name}}</option>
                                  @else
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endif
                                  @endforeach
                              </select></P>
                              <BR/>
                              
                                <p><label>Укрупненная тема:</label>
                              <select name="largeblock_id" class="form-control-static">
                                  <option value=""></option>
                                  @foreach(\App\Largeblock::where('active', 1)->orderby('name')->get() as $largeblock)
                                  @if ($largeblock->id == $b->largeblock_id)
                                  <option value="{{$largeblock->id}}" selected>{{$largeblock->name}}</option>
                                  @else
                                  <option value="{{$largeblock->id}}">{{$largeblock->name}}</option>
                                  @endif
                                  @endforeach
                              </select></P>
                              <BR/>                            
                                   
                                   <button>Сохранить</button>
                                   
                                   {{ csrf_field() }}
                               </form>
                           
                           </div>
                       </td>
                       <td>
                       @if ($b->l_hours) Лек:{{$b->l_hours}} @endif
                       @if ($b->p_hours) Прак:{{$b->p_hours}} @endif
                       @if ($b->s_hours) СР:{{$b->s_hours}} @endif
                       @if ($b->w_hours) Веб:{{$b->w_hours}} @endif
                       </td>
                       <td>
                           @if($b->department_id)
                            {{$b->discipline->department->name or ''}}
                           -> {{$b->department->name or ''}}
                           
                           
                           @else
                           {{$b->discipline->department->name or ''}}
                           @endif
                       </td>
                       <td>{{$b->discipline->name}}</td>
                       <td>
                           @foreach($b->discipline->programs as $program)
                        <li>[{{$program->year}}] {{$program->name}}</li>
                           @endforeach
                       
                       </td>
                   </tr>
                   @endforeach
                        </tbody>
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
    $(".block").click(function(){
        $(this).children('.form').toggle();
        
    });
    
    $(".form").click(function(e) {
        e.stopPropagation();;
        
        
    });
    
    
    
</script>

<script>

var $window = $(window)
/* Restore scroll position */
window.scroll(0, localStorage.getItem('scrollPosition')|0)
/* Save scroll position */
$window.scroll(function () {
    localStorage.setItem('scrollPosition', $window.scrollTop())
})


</script>

@endsection

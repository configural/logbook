
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Укрупненные темы</div>

                <div class="panel-body">
                    <p>
                    <form method='get'>
                    Выберите образовательную программу:
                    <select name='program_id' class='form-control' onchange='form.submit()'>
                        <option></option>  
                        @foreach(\App\Program::where('active', 1)->orderby('name')->get() as $program)
                    @if (isset($program_id) and $program_id == $program->id)
                    <option value='{{$program->id}}' selected>{{ $program->year }} - {{ $program->name}} 
                    @else
                    <option value='{{$program->id}}'>{{ $program->year }} - {{ $program->name}} 
                    @endif
                    @endforeach
                    </select>
                    </form>
                </p>
                    @if ($blocks)
                    
                    <table class='table table-bordered' id='sortTable'>
                        <thead>
                        <th>id</th>
                        <th>Темы</th>
                        <th>Тип</th>
                        <th>Укрупненные темы</th>

                        </thead>
                        <tbody>
                   @foreach($blocks as $b)
                           <tr><td>
                                   <a name="{{$b->id}}">{{$b->id}}</a>
                       </td>
                       <td class="block">
                           <div class="name"><span class="linkOnPage">{{$b->name}}</span></div>
                           <div class="form" style="display: none">
                                <form method="post">
                                    <textarea name="name"  class="form-control"style="width: 100%; height: 200px;">{{ $b->name }}</textarea>
                                   <input type="hidden" name="id" value="{{$b->id}}">
                              

                              
                                <p><label>Укрупненная тема:</label>
                              <select name="largeblock_id" class="form-control-static">
                                  <option value=""></option>
                                  @foreach(\App\Largeblock::where('active', 1)->orderby('name')->get() as $largeblock)
                                  @if ($largeblock->id == $b->largeblock_id)
                                  <option value="{{$largeblock->id}}" selected>{{$largeblock->name}} :: {{$largeblock->department->name}}</option>
                                  @else
                                  <option value="{{$largeblock->id}}">{{$largeblock->name}} :: {{$largeblock->department->name}}</option>
                                  @endif
                                  @endforeach
                              </select></P>
                              <input type='hidden' name='program_id' value='{{$program_id}}'>
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
                        @if ($b->largeblock_id)
                        {{$b->largeblock->name}}
                        @endif
                       </td>

                           
                       
                       </td>
                   </tr>
                   @endforeach
                        </tbody>
                    </table>
                    @endif
                    
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

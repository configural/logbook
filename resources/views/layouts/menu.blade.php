                   
@if (Auth::user()->role_id == 3)
<li><a href="{{ route('users')}}"><i class="fa fa-user red"></i> Преподаватели</a></li> 
<li><a href="{{ route('streams')}}"><i class="fa fa-users blue"></i> Слушатели</a></li> 
<li><a href="{{ route('workload')}}"><i class="fa fa-pie-chart red"></i> Нагрузка</a></li> 
<li><a href="{{ route('rasp')}}"><i class="fa fa-calendar blue"></i> Расписание</a></li>
@endif



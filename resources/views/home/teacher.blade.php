                    <strong>Преподаватель</strong>
                    <p>
                        @if (Auth::user()->freelance == 0)
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                        
                        @endif
                        <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        <div class="icon"><a href="{{route('myrasp')}}"><i class="fa fa-calendar fa-3x green"></i><br/>Мое расписание</a></div>
                        <div class="icon"><a href="{{route('my_media')}}"><i class="fa fa-camera fa-3x orange"></i><br/>Медиаконтент (планы)</a></div>
                        
                    </p>
                        
                  
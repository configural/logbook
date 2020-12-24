                    <strong>Преподаватель</strong>
                    <p>
                        @if (Auth::user()->freelance == 0)
                        <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Аудиторная нагрузка</a></div>
                        <div class="icon"><a href="{{route('vneaudmy')}}"><i class="fa fa-pie-chart fa-3x violet"></i><br/>Внеаудиторная нагрузка</a></div>
                        @endif
                                                <div class="icon"><a href="{{route('workloadmy')}}"><i class="fa fa-pie-chart fa-3x green"></i><br/>Моя нагрузка</a></div>
                        <div class="icon"><a href="{{route('workloadmythemes')}}"><i class="fa fa-list-ol fa-3x green"></i><br/>Темы в нагрузке</a></div> 
                                                <hr>
                                                <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        <div class="icon"><a href="{{route('myrasp')}}"><i class="fa fa-calendar fa-3x green"></i><br/>Мое расписание</a></div>
                        <div class="icon"><a href="{{route('raspview')}}"><i class="fa fa-calendar fa-3x blue"></i><br/>Общее расписание</a></div>
                        <div class="icon"><a href="{{route('my_media')}}"><i class="fa fa-camera fa-3x orange"></i><br/>Медиаконтент (планы)</a></div>
                        
                        
                    </p>
                        
                  
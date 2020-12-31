 <strong>Приветствую тебя, Методист!</strong>

                        <h3>Администрирование</h3>
                        <hr>
                        <div class="icon"><a href="{{route('users')}}"><i class="fa fa-user fa-3x red"></i><br/>Пользователи системы</a></div>
                        <div class="icon"><a href="{{ route('streams') }}"><i class="fa fa-users fa-3x blue"></i><br/>Потоки, группы, слушатели</a></div>                    
                        <div class="icon"><a href="{{ route('workload') }}"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение аудиторной нагрузки</a></div>
                        <div class="icon"><a href="{{route('vneaud')}}"><i class="fa fa-pie-chart fa-3x blue"></i><br/>Внеаудиторная нагрузка</a></div>

                        
                        <div class="icon"><a href="{{ route('rasp') }}"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                
                        <h3>Отчеты и документы</h3>
                        <hr>
                        <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                        <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Печать расписания</a></div>
                        <div class="icon"><a href="{{route('print_rasp_kafedra')}}"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание преподавателей кафедры</a></div>
                        <div class="icon"><a href="{{route('tabel')}}"><i class="fa fa-clock-o fa-3x blue"></i><br/>Табель (штатники)</a></div>                                
                        <div class="icon"><a href="{{route('themes')}}"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Дисциплины по кафедрам</a></div>                        
                        <div class="icon"><a href="{{route('no_journal')}}"><i class="fa fa-user-secret fa-3x black"></i><br/>Кто не заполнил журнал?</a></div>                        
                 
                        <h3>
                        Вспомогательные инструменты    
                        </h3>
                        
                        <ul>

                        <li><a href="{{route('largeblocks')}}">Темы в расписании по укрупненным темам</a></li>
                </ul>                       
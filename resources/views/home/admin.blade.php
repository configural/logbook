                    <strong>Приветствую тебя, Администратор!</strong>
                    <p>
                    <h3>Администрирование</h3>
                    <hr>
                    
                        <div class="icon"><a href="{{route('users')}}"><i class="fa fa-user fa-3x red"></i><br/>Пользователи системы</a></div>
                        <div class="icon"><a href="{{route('departments')}}"><i class="fa fa-graduation-cap fa-3x blue"></i><br/>Кафедры</a></div>
                        <div class="icon"><a href="{{route('programs')}}"><i class="fa fa-graduation-cap fa-3x orange"></i><br/>Образовательные программы</a></div>
                        <div class="icon"><a href="{{route('disciplines')}}"><i class="fa fa-book fa-3x green"></i><br/>Дисциплины</a></div>
                        <div class="icon"><a href="{{route('streams')}}"><i class="fa fa-users fa-3x blue"></i><br/>Потоки, группы, слушатели</a></div>
                        <div class="icon"><a href="{{route('workload')}}"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>
                        <div class="icon"><a href="{{route('rasp')}}"><i class="fa fa-calendar fa-3x brown"></i><br/>Расписание</a></div>
                        <div class="icon"><a href="{{route('myrasp')}}"><i class="fa fa-calendar fa-3x green"></i><br/>Мое расписание</a></div>
                        <div class="icon"><a href="{{route('journal')}}"><i class="fa fa-list fa-3x brown"></i><br/>Журнал</a></div>
                        <div class="icon"><a href="{{route('classrooms')}}"><i class="fa fa-building fa-3x blue"></i><br/>Аудитории</a></div>
                        <div class="icon"><a href="{{route('media')}}"><i class="fa fa-camera fa-3x orange"></i><br/>Медиаконтент (планы)</a></div>
                        

                </p>
                <h3>Отчеты и документы</h3>
                <hr>
                        <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                        <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Печать расписания</a></div>
                        <div class="icon"><a href="{{route('print_rasp_kafedra')}}"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание преподавателей кафедры</a></div>                                
                        <div class="icon"><a href="{{route('no_journal')}}"><i class="fa fa-user-secret fa-3x black"></i><br/>Кто не заполнил журнал?</a></div>
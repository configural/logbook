<strong>Здравствуйте, {{Auth::user()->name}}!</strong>
                    <h3>Преподавательская деятельность</h3>
                    <div class="icon"><a href="{{url('/')}}/workload"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Распределение нагрузки</a></div>    
                    <div class="icon"><a href="{{url('/')}}/journal"><i class="fa fa-list fa-3x brown"></i><br/>Мой журнал</a></div>
                    <div class="icon"><a href="{{route('myrasp')}}"><i class="fa fa-calendar fa-3x green"></i><br/>Мое расписание</a></div>
                    <div class="icon"><a href="{{route('raspview')}}"><i class="fa fa-calendar fa-3x blue"></i><br/>Общее расписание</a></div>
                    
                    
                    <h3>Контроль и мониторинг</h3>
                    <hr>
                    <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                    <div class="icon"><a href="{{url('/')}}/reports/rasp"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание занятий</a></div>
                    <div class="icon"><a href="{{route('print_rasp_kafedra')}}"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание преподавателей кафедры</a></div>
                    <div class="icon"><a href="{{route('themes')}}"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Нагрузка по кафедрам</a></div>
                    <div class="icon"><a href="{{route('report_rasp_classrooms')}}"><i class="fa fa-building fa-3x blue"></i><br/>Занятость аудиторий</a></div>
                    <div class="icon"><a href="{{route('tabel_freelance')}}"><i class="fa fa-clock-o fa-3x green"></i><br/>Табель</a></div>                                
                        
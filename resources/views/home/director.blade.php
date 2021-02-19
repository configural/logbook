<strong>Здравствуйте, {{Auth::user()->name}}!</strong>
                   
                    <h3>Контроль и мониторинг</h3>
                    <hr>
                    <div class="icon"><a href="{{url('/')}}/reports/journal"><i class="fa fa-list fa-3x orange"></i><br/>Журналы преподавателей</a></div>
                    <div class="icon"><a href="{{route('rasp')}}"><i class="fa fa-calendar fa-3x blue"></i><br/>Расписание по аудиториям</a></div>
                    <div class="icon"><a href="{{route('raspview')}}"><i class="fa fa-calendar fa-3x blue"></i><br/>Расписание по группам</a></div>
                    <div class="icon"><a href="{{route('print_rasp_kafedra')}}"><i class="fa fa-calendar fa-3x orange"></i><br/>Расписание преподавателей кафедры</a></div>
                    <div class="icon"><a href="{{route('themes')}}"><i class="fa fa-pie-chart fa-3x orange"></i><br/>Нагрузка по кафедрам</a></div>
                    <div class="icon"><a href="{{route('report_rasp_classrooms')}}"><i class="fa fa-building fa-3x blue"></i><br/>Занятость аудиторий</a></div>
                    <div class="icon"><a href="{{route('tabel')}}"><i class="fa fa-clock-o fa-3x green"></i><br/>Табель (штатные)</a></div>                                
                    <div class="icon"><a href="{{route('tabel_freelance')}}"><i class="fa fa-clock-o fa-3x green"></i><br/>Табель (внештатные)</a></div>
                    <div class="icon"><a href="{{route('media')}}"><i class="fa fa-camera fa-3x green"></i><br/>Медиаконтент (планы)</a></div>
                    <div class="icon"><a href="{{route('no_journal')}}"><i class="fa fa-user-secret fa-3x black"></i><br/>Кто не заполнил журнал?</a></div>                        
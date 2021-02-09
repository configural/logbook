<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css')}}/font-awesome-4.7.0/css/font-awesome.min.css">  

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>    
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>  
        
        <script src="http://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
       
        @yield('head_links')
        
        <title>LogBook</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/home') }}">
                            <i class="fa fa-home"></i> Журнал
                        </a>
                    </div>
                    <ul class="nav navbar-nav">
                        @if(Route::currentRouteName() != 'home')
                        @include('layouts.menu')
                        @endif  


                    </ul>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            {{--<li><a href="{{ route('register') }}">Register</a></                            li>--}}
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>

                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('profile') }}">Мой профиль</a>
                                                <a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid">


                @if (mb_strstr($_SERVER["REQUEST_URI"], "logbook-dev"))
                <div class="alert alert-danger">Контур разработки! <a href="http://localhost/logbook/public">Перейти на рабочий контур</a></div>
                @endif


                @yield('content')
            </div>
        </div>
    </body>
        <!-- Scripts -->

        <script>
            $(document).ready(function () {
                $('#sortTable').DataTable(
                        {
                            "stateSave": true,
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Все"]],
                            "pageLength": 25,
                            "scrollX": true,
                            
                            "scrollY": false, 
                            "language" : {
                                "processing": "Подождите...",
                                "search": "Поиск:",
                                "lengthMenu": "Показать _MENU_ записей",
                                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                                "infoPostFix": "",
                                "loadingRecords": "Загрузка записей...",
                                "zeroRecords": "Записи отсутствуют.",
                                "emptyTable": "В таблице отсутствуют данные",
                                "paginate": {
                                    "first": "Первая",
                                    "previous": "Предыдущая",
                                    "next": "Следующая",
                                    "last": "Последняя"
                                    
                                    },      
                            }
                        }
                );



            });


        </script>
        <script src="{{url('/')}}/js/filter.js"></script>
<script>
$("#toExcel").click(function(){
$("#sortTable").table2excel({
filename: "result.xls"
});




});
</script>
        <!---->
        @yield('footer_code')
    </body>

</html>



@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Добавить вебинар</div>

                <div class="panel-body">
                    <form method="post">
                        <p><label>Тема вебинара:</label>
                            <input id="name" type="text" name="name" class="form-control" autocomplete="off">
                            <div id="nameList"></div>
                        </p>
                        <p>
                            <label>Дата вебинара: </label>
                            <input type="date" name="date" value="{{ date('Y-m-d')}}" class="form-control-static">
                        
                        </p>
                        
                        <p>
                            <label>Время вебинара: </label>
                            <input type="time" name="start_at" value=""  class="form-control-static">
                            <input type="time" name="start_at" value=""  class="form-control-static">
                            
                        </p>
                        <p>
                            <label>Академических часов: </label>
                            <input type="number" name="hours" value="" class="form-control-static">
                            
                        </p>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#name").on("keyup", function() {
        var text = $(this).val();
        var url = "{{url('/')}}/ajax/search/block/" + text;
        
        if (text) {
            $.ajax({
            'url': url,
             success: function(result) {  $("#nameList").html(result);  } 
            
        });}
    });
    
    $("#nameList").click(function() {
        var str = event.target;

    });

}); 



</script>
@endsection

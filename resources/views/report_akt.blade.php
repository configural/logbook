
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading ">Создание актов</div>

                <div class="panel-body">
                    <form method="get">
                        <p><label>Год <label> 
                                
                                    <input id="year" type="number" name="year" min="2020" value="{{date('Y')}}" class="form-control-static">
                                
                                <label>Месяц <label> 
                                
                                <select id="month" class="form-control-static">
                                    <option value="">выберите</option>
                                    <option value="1">январь</option>
                                    <option value="2">февраль</option>
                                    <option value="3">март</option>
                                    <option value="4">апрель</option>
                                    <option value="5">май</option>
                                    <option value="6">июнь</option>
                                    <option value="7">июль</option>
                                    <option value="8">август</option>
                                    <option value="9">сентябрь</option>
                                    <option value="10">октябрь</option>
                                    <option value="11">ноябрь</option>
                                    <option value="12">декабрь</option>
                                </select>
                                </p>
                                <p>
                                <label>Источник средств <label> 
                                        <select id="paid" name="paid" class="form-control-static">
                                            <option value="0">субсидии</option>
                                            <option value="1">деятельность, приносящая доход</option>
                                        </select> 
                                
                                <label>Дата формирования акта <label> 
                                <input id="akt_date" name="akt_date" type="date" value="{{@date('Y-m-d')}}" class="form-control-static">
                                
                                <label>Заказчик <label> 
                                <input id="rektor" name="rektor" type="text" value="Беляков Н.Ф." class="form-control-static">
                                
                                </p>  
                                
                                
                    </form>
                    <div id="result"></div>   
                   
                   
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    
    $("input").add("select").on("change keyup", function(){
      
      var year = $("#year").val();
      var month = $("#month").val();
      var paid = $("#paid").val();
      var akt_date = $("#akt_date").val();
      var rektor = $("#rektor").val();
      
      $.ajax({
          url: '{{route('ajax_contracts_month')}}',
          method: 'get',
          datatype: 'html',
          data: {
              month: month,
              year: year,
              paid: paid,
              akt_date: akt_date,
              rektor: encodeURI(rektor)
               },
          success: function(data) {
              $('#result').html(data);
          }
      });
    }); 
    
});    
</script>

@endsection

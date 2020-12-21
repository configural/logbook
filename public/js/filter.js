

    
$('tfoot .filter').each( function () {
        var title = $('#sortTable tfoot td').eq( $(this).index() ).text();
        $(this).append('<input type="text" placeholder="поиск '+title+'" />' );
});
$("#sortTable tfoot td input").on( 'keyup change', function () {
            $('#sortTable').DataTable()
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
    
    console.log(this.value);
});


$(document).ready(function() {
    $('a.delete').on('click', function(){
        var tr = $(this).closest('tr');
        var id = tr.children('td:first').html();
        $('#container').load('HW15.php?action=delete&id='+id, 
                             function(){ //success
                               tr.fadeOut('slow', function(){$(this).remove();});
                             }); 
    });
});
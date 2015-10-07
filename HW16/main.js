$(document).ready(function() {
    $('a.del').on('click',function(){
        var id=$(this).closest('tr').children('td:first').html();
        var tr=$(this).closest('tr');
        var test = {'id':id};
        
        $.getJSON('HW16.php?action=delete',
        test,
        function(response){
            if(response.status == 'success'){
                $('#delete').show();
                $('#delete').removeClass('alert-danger').addClass('alert-warning');
                $('#delete button').removeClass('btn-danger').addClass('btn-warning');
                $('#delete_info').html(response.message);
                if(response.message1){
                    $('#info_message').html(response.message1);
                }
                $('#delete').fadeIn('slow').fadeOut(2000);
            } else if(response.status == 'error'){
                $('#delete').removeClass('alert-warning').addClass('alert-danger');
                $('#delete button').removeClass('btn-warning').addClass('btn-danger');
                $('#delete_info').html(response.message);
                $('#delete').fadeIn('slow');
            }
            tr.fadeOut('slow',function(){
                $(this).remove();
            });
        });
    });
});

$(document).ready(function() {
    $('a.add').on('click', function(){
        var msg = $('#formx').serialize();
        $.ajax({
        type: 'POST',
        url: 'HW16.php?action=add',
        data: msg,
        success: function(data) {
            document.write(data);
            $('#add').removeClass('alert-danger').addClass('alert-info');
            $('#add button').removeClass('btn-danger').addClass('btn-info');
            $('#add_info').html('Объявление добавлено');
            $('#add').fadeIn('slow').fadeOut(2000);
            document.close();
            },
        error: function(){
            $('#add').removeClass('alert-info').addClass('alert-danger');
            $('#add button').removeClass('btn-info').addClass('btn-danger');
            $('#add_info').html('Произошла ошибка. Объявление не было изменено');
            $('#add').fadeIn('slow');
        }
        });
    });
});

$(document).ready(function() {
    $('a.change').on('click', function(){
        var tr = $(this).closest('tr');
        var id = tr.children('td:first').html();
        
        $.ajax({
        type: 'GET',
        url: 'HW16.php?action=change&id='+id,
        success: function(data) {
            $('div#all-ads').remove();
            $('#formx').html(data);
        }
        });
    });
});

$(document).ready(function() {
    $('a.change_ad').on('click', function(){
        var msg = $('form#formx').serialize();
        var id = $('#ad_id').html();
        $.ajax({
        type: 'POST',
        url: 'HW16.php?action=change_ad&id='+id,
        data: msg,
        success: function(data) {
            $('#change').removeClass('alert-danger').addClass('alert-info');
            $('#change button').removeClass('btn-danger').addClass('btn-info');
            $('#change_info').html('Объявление '+id+' успешно изменено');
            $('#change').fadeIn('slow').fadeOut(2000);
            
            },
        error: function(){
            $('#change').removeClass('alert-info').addClass('alert-danger');
            $('#change button').removeClass('btn-info').addClass('btn-danger');
            $('#change_info').html('Произошла ошибка. Объявление '+id+'  не было изменено');
            $('#change').fadeIn('slow');
        }
        });
    });
});
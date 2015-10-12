$(document).ready(function() {

    $(document).on('click', 'a#show_ad', function(){
        var id= $(this).closest('tr').children('td:first').html();
        
        $.ajax({
            type: 'GET',
            url: 'HW17.php?action=fullAd&id='+id,
            success: function(data) {  
                $('#forma').empty();
                $('#forma').html(data.full);
                var phone = data.phone;
                var email = data.email;
                
                var i=0;
                $(document).on('click', 'a#phone', function(){

                    $("a#phone").html(
                        function () {
                            if(i==0) {
                                i++;$("a#phone").html( "<i class='glyphicon glyphicon-earphone'></i>&nbsp;"+phone);
                            }
                            else{
                                i=0;$("a#phone").html("<i class='glyphicon glyphicon-earphone'></i>&nbsp;"+'Показать телефон');
                            }
                        }
                    );
                    $(this).toggleClass("active");
                    return false;
                });
                
                var y=0;
                $(document).on('click', 'a#email', function(){

                    $("a#email").html(
                        function () {
                            if(y==0) {
                                y++;$("a#email").html( "<i class='glyphicon glyphicon-envelope'></i>&nbsp;"+email);
                            }
                            else{
                                y=0;$("a#email").html("<i class='glyphicon glyphicon-envelope'></i>&nbsp;"+'Показать Email');
                            }
                        }
                    );
                    $(this).toggleClass("active");
                    return false;
                });
            },
            dataType: 'json'
        });
    });
    
    $(document).on('click', 'button#add_ad', function(){
        function showResponse(response){
            $('#ads>tbody').append(response.ad);

            if(response.status === 'success'){
                alertify.success(response.message);
            } else {
                alertify.error(response.message);
            }
        }
    
        var options = {
            success:       showResponse,
            url:       'HW17.php?action=insert',
            dataType:  'json',
            resetForm: true
        }; 
        $('#ajax-form').ajaxForm(options); 
    });
    
    $(document).on('click', 'a.del', function(){
        var id= $(this).closest('tr').children('td:first').html();
        var tr= $(this).closest('tr');
        var test = {'id':id};
        alertify.confirm("Вы действительно хотите удалить объявление "+id+"?", function (e) {
            if (e){
                $.getJSON('HW17.php?action=delete',
                test,
                function(response){
                    if(response.message1){
                        alertify.success(response.message);
                        alertify.error(response.message1);
                    } else {
                        alertify.success(response.message);
                    } 
                    tr.fadeOut('slow',function(){
                        $(this).remove();
                    });
                });  
            } else {
                alertify.error("Удаление отменено");
            }
        });
    });
    
    $(document).on('click', 'a.change', function(){
        var tr = $(this).closest('tr');
        var id = tr.children('td:first').html();
        
        $.ajax({
            type: 'GET',
            url: 'HW17.php?action=change&id='+id,
            success: function(data) {  
              $('div#all-ads').hide();
              $('#forma').empty();
              $('#forma').html(data.full);
              $('h2.title').html('Объявление №'+id);
            },
            dataType: 'json'
        });
    });

    $(document).on('click', 'button#change_ad', function(){
        function changeAd(response){
            if(response.status === 'success'){
                alertify.success(response.message);
            } else {
                alertify.error(response.message);
            }
        }
    
        var id = $('#ad_id1').html();       
        var options1 = {
            success:       changeAd,
            url:       'HW17.php?action=change_ad&id='+id,
            dataType:  'json'
        };      
        $('#ajax-form').ajaxForm(options1);   
        });
        
    $(document).on('click', '#reset-ad', function(){
        $.ajax({
            type: 'GET',
            url: 'HW17.php?action=reset',
            success: function(data) {
                $('div#all-ads').html(data.all_ads).show();
                $('div#forma').html(data.reset_form);
            },
            dataType: 'json'
        });
    });
});
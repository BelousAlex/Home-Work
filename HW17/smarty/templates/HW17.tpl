<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HW17</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link href="css/alertify.core.css?{php}echo time();{/php}" rel="stylesheet" type="text/css"/>
        <link href="css/alertify.default.css?{php}echo time();{/php}" rel="stylesheet" type="text/css"/>
        <link href="css/style.css?{php}echo time();{/php}" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="js/jquery.form.min.js" type="text/javascript"></script>
        <script src="js/alertify.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>

    <body style="width:99%">
        <div class="row">
            {if isset($smarty.get.id)}<div class="col-md-12">{else}<div class="col-md-5" id="forma">{/if}
                {include file='form.tpl'}                 
            </div>
            <div class="col-md-7" id="all-ads">
                {if !isset($smarty.get.id)}{include file='table.tpl.html'}{/if}
            </div> 
        </div>   
        <script src="js/main.js?{php}echo time();{/php}" type="text/javascript"></script>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OOP</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    
    <body style="width:99%; ">
        <div class="row">
            <div class="col-md-5">
                <div class='col-md-offset-3'><h2 class="sub-header">Подать объявление</h2></div>
                <form class="form-horizontal" method="POST" role="form">
                    {*<input type="hidden" name="id" value="1">*}

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            {if isset($selected_ads.id_type)}
                                {html_radios name='id_type' separator='&nbsp&nbsp' options=$type_array selected=$selected_ads.id_type}
                            {else}
                                {html_radios name='id_type' separator='&nbsp&nbsp' options=$type_array selected='1'}
                            {/if}  
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName1" class="col-sm-3 control-label">Ваше имя</label>
                        <div class="col-sm-9">
                            <input type="text" name="user_name" placeholder='Пример: Иван' id="inputName1" class="form-control" value='{if isset($selected_ads.user_name)}{$selected_ads.user_name}{/if}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='inputEmail' class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name='email' placeholder='Пример: user@mail.ru' id='inputEmail' class="form-control" value='{if isset($selected_ads.email)}{$selected_ads.email}{/if}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class='col-sm-offset-3 col-sm-9'>
                            {if (isset($selected_ads.otvet) && $selected_ads.otvet == 'on')}
                                <input type="checkbox" name="otvet" checked='cheked'/> Я не хочу получать ответы по объявлению по e-mail
                            {else}
                                <input type="checkbox" name="otvet"/> Я не хочу получать ответы по объявлению по e-mail
                            {/if}
                        </label>
                    </div>

                    <div class="form-group">
                        <label for='inputPhone' class="col-sm-3 control-label">Номер телефона</label>
                        <div class="col-sm-9">
                            <input type="tel" name="phone" placeholder='Пример: +7(918)111-22-33' id='inputPhone' class="form-control" value='{if isset($selected_ads.phone)}{$selected_ads.phone}{/if}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='inputCity' class="col-sm-3 control-label">Город</label>
                        <div class='col-sm-9'>
                            <select class="form-control" name="id_city" id='inputCity'>
                                {if isset($selected_ads.id_city)}
                                    {html_options options=$city_array selected=$selected_ads.id_city}
                                {else}
                                    {html_options options=$city_array}
                                {/if}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='inputCategory' class="col-sm-3 control-label">Категория</label>
                        <div class='col-sm-9'>
                            <select class="form-control" name="id_category" id='inputCategory'>
                                {if isset($selected_ads.id_category)}
                                    {html_options options=$category_array selected=$selected_ads.id_category}
                                {else}
                                    {html_options options=$category_array}
                                {/if}
                            </select>
                        </div>
                    </div>        

                    <div class="form-group">
                        <label for='inputNameAd' class="col-sm-3 control-label">Название объявления</label>
                        <div class="col-sm-9">
                            <input type="text" name="ad_title" id='inputNameAd' class="form-control" value='{if isset($selected_ads.ad_title)}{$selected_ads.ad_title}{/if}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='inputDescAd' class="col-sm-3 control-label">Описание объявления</label>
                        <div class="col-sm-9">
                            <textarea name="ad_description" placeholder='Не более 400 символов' id='inputDescAd' class="form-control" rows="5">{if isset($selected_ads.ad_description)}{$selected_ads.ad_description}{/if}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='inputPrice' class="col-sm-3 control-label">Цена</label>
                        <div class="col-sm-9">
                            <input type="number" step='100' id='inputPrice' name="price" min="0" max="100000" class="form-control" value='{if isset($selected_ads.price)}{$selected_ads.price}{else}0{/if}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary btn-lg" name="{if isset($smarty.get.id)}change{/if}">{if isset($smarty.get.id)}Изменить{else}Отправить{/if}</button>
                            {if isset($smarty.get.id)}<a href="HW12.php" class="btn btn-primary btn-lg active" role="button">Назад на главную</a>{/if}
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-7">
                {if !isset($smarty.get.id)}{include file='table.tpl.html'}{/if}
            </div>
        </div>
    </body>
</html>
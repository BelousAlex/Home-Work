<form class="form-horizontal" id="ajax-form" method="POST" role="form">
    <div class='col-md-offset-3'><h2 class="title sub-header">Подать объявление</h2></div>

    {if isset($selected_ads.ad_id)}
        <div id="ad_id1" style="display: none">{$selected_ads.ad_id}</div>
    {/if}

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
            <input type="text" name="user_name" placeholder='Пример: Иван' title="Длина имени: от 2 до 20. Только русские символы (кириллица)" id="inputName1" maxlength="20" class="form-control" value='{if isset($selected_ads.user_name)}{$selected_ads.user_name}{/if}' required pattern="{literal}^[А-Яа-яЁё]{2,20}${/literal}">
        </div>
    </div>

    <div class="form-group">
        <label for='inputEmail' class="col-sm-3 control-label">Email</label>
        <div class="col-sm-9">
            <input type="email" name='email' placeholder='Пример: user@mail.ru' id='inputEmail' class="form-control" value='{if isset($selected_ads.email)}{$selected_ads.email}{/if}' required>
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
            <input type="tel" name="phone" placeholder='Пример: +7(918)111-22-33' title="+код страны(1-2 цифры)(код оператора)-xxx-xx-xx" id='inputPhone' maxlength="17" class="form-control" value='{if isset($selected_ads.phone)}{$selected_ads.phone}{/if}' required pattern="{literal}\+[0-9]{1,2}\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}{/literal}">
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
        <label for='inputNameAd' class="col-sm-3 control-label">Название объявления*</label>
        <div class="col-sm-9">
            <input type="text" name="ad_title" placeholder='Не более 50 символов' title="Длина: от 2 до 50. Можно использовать: русскую/английскую раскладки, точки, тире" id='inputNameAd' maxlength="50" class="form-control" value='{if isset($selected_ads.ad_title)}{$selected_ads.ad_title}{/if}' required pattern="{literal}^[А-Яа-яЁё\s?A-z\.?]{2,50}${/literal}">
        </div>
    </div>

    <div class="form-group">
        <label for='inputDescAd' class="col-sm-3 control-label">Описание объявления*</label>
        <div class="col-sm-9">
            <textarea name="ad_description" placeholder='Не более 400 символов' id='inputDescAd' maxlength="400" class="form-control" rows="5" required>{if isset($selected_ads.ad_description)}{$selected_ads.ad_description}{/if}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for='inputPrice' class="col-sm-3 control-label">Цена*</label>
        <div class="col-sm-9">
            <input type="number" step='100' id='inputPrice' name="price" min="0" max="100000" class="form-control" value='{if isset($selected_ads.price)}{$selected_ads.price}{else}0{/if}'>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {if !isset($smarty.get.id)}
                <button type="submit" id="add_ad" class="add btn btn-primary btn-lg" name="">Отправить</button>
            {else}
                <button type="submit" id="change_ad" class="change btn btn-primary btn-lg">Изменить</button>
                <a id="reset-ad" class="btn btn-primary btn-lg">Назад на главную</a>
            {/if}
        </div>
    </div>
</form>
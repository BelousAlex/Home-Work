{$selected_ads.user_name}
<html>
    <head>
        <title>HW10</title>
    </head>
    <body>
        <form method="post">
            {if isset($selected_ads.id_type)}
                <p>{html_radios name='id_type' options=$type_array selected=$selected_ads.id_type}</p>
            {else}
                <p>{html_radios name='id_type' options=$type_array selected='1'}</p>
            {/if}
            <p>Ваше имя: <input type="text" name="user_name" value='{if isset($selected_ads.user_name)}{$selected_ads.user_name}{/if}'/></p>
            <p>Электронная почта <input type="email" name="email" value='{if isset($selected_ads.email)}{$selected_ads.email}{/if}'/></p>
            {if (isset($selected_ads.otvet) && $selected_ads.otvet == 'on')}
                <p><input type="checkbox" name="otvet" checked='cheked'/> Я не хочу получать ответы по объявлению по e-mail </p>
            {else}
                <p><input type="checkbox" name="otvet"/> Я не хочу получать ответы по объявлению по e-mail </p>
             {/if}
            <p>Номер телефона <input type="tel" name="phone" value='{if isset($selected_ads.phone)}{$selected_ads.phone}{/if}'/></p>
                <form method="POST">
            <p><select name="id_city">
            {if isset($selected_ads.id_city)}
                {html_options options=$city_array selected=$selected_ads.id_city}
            {else}
                {html_options options=$city_array}
            {/if}
            </select></p>
            <p><select name="id_category">
            {if isset($selected_ads.id_category)}
                {html_options options=$category_array selected=$selected_ads.id_category}
            {else}
                {html_options options=$category_array}
            {/if}
            </select></p>
            <p>Название объявления: <input type="text" name="ad_title" value='{if isset($selected_ads.ad_title)}{$selected_ads.ad_title}{/if}'/></p>
            <p>Описане объявления: <textarea name="ad_description">{if isset($selected_ads.ad_description)}{$selected_ads.ad_description}{/if}</textarea></p>
            <p>Цена <input type="number" name="price" min="0" max="100000" value='{if isset($selected_ads.price)}{$selected_ads.price}{else}0{/if}'/> руб</p>
            <input type="submit">
        </form>
        {if !isset($smarty.get.id)}
            {showAd}
        {else}
            <a href="HW10.php">Главная страница</a>
        {/if}
    </body>
</html>